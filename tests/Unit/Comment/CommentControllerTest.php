<?php

namespace Tests\Unit\Comment;

use App\Http\Controllers\CommentController;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\NewsArticle;
use App\Models\Post;
use App\Models\User;
use App\Services\ActivityService;
use App\Services\CommentService;
use App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;
use Tests\Traits\ModelFactoryTrait;

class CommentControllerTest extends TestCase
{
    use WithFaker, DatabaseTransactions, ModelFactoryTrait;

    protected User $user;
    protected Post $post;
    protected NewsArticle $newsArticle;

    public function setUp(): void
    {
        parent::setUp();

        // Create a user and post
        $this->user = $this->createUser();
        $this->post = $this->createPost($this->user);
        $this->newsArticle = $this->createNewsArticle();

        config(['app.debug' => false]);
    }

    //Tests
    public function test_store_method_successfully_creates_comment(): void
    {
        $this->actingAs($this->user);

        // Mock the CommentRequest
        $request = Mockery::mock(CommentRequest::class);
        $request->allows('validated')
            ->andReturns([
                'user_id' => $this->user->id,
                'item_type' => 'App\Models\Post',
                'item_id' => $this->post->id,
            ]);

        $data = $request->validated();
        $comment = new Comment($data);

        $model = $data['item_type']::findOrFail($data['item_id']);
        $type = $data['item_type'] === Post::class ? 'posts' : 'news';

        // Mock the CommentService
        $postServiceMock = Mockery::mock(CommentService::class);
        $postServiceMock->expects('storeComment')
            ->with($request)
            ->andReturns([$comment, $model, $type]);

        // Mock the ActivityService
        $activityServiceMock = Mockery::mock(ActivityService::class);
        $activityServiceMock->expects('storeActivity')
            ->withArgs([$model, "$type.show", $comment->item_id, 'bi bi-chat-left-dots', 'commented on a post']);

        // Mock the UserService
        $userServiceMock = Mockery::mock(UserService::class);

        // Create an instance of the controller
        $controller = new CommentController($postServiceMock, $activityServiceMock, $userServiceMock);

        // Call the store method
        $response = $controller->store($request);

        // Assert the response
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertJsonStringEqualsJsonString(json_encode([
            "comment" => [
                "content" => null,
                "csrf" => null,
                "id" => null,
                "likeCommentRoute" => route('comment_likes.store'),
                "user" => [
                    "id" => $this->user->id,
                    "name" => $this->user->name,
                    "picture" => $this->user->profile_picture ? asset($comment->user->profile_picture) : '',
                ],
            ],
            "message" => "Comment added successfully",
        ], JSON_THROW_ON_ERROR), $response->content());

        Mockery::close();
    }
}
