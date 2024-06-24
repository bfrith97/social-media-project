<?php

namespace Tests\Unit\CommentLike;

use App\Http\Controllers\CommentLikeController;
use App\Http\Requests\CommentLikeRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Services\ActivityService;
use App\Services\CommentLikeService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;
use Tests\Traits\ModelFactoryTrait;

class CommentLikeControllerTest extends TestCase
{
    use WithFaker, DatabaseTransactions, ModelFactoryTrait;

    protected User $user;
    protected Post $post;
    protected Comment $comment;

    public function setUp(): void
    {
        parent::setUp();

        // Create a user and a post with a comment
        $this->user = $this->createUser();
        $this->post = $this->createPost($this->user);

        // Create a comment by a different user
        $this->commentUser = $this->createUser();
        $this->comment = $this->createComment($this->commentUser, $this->post);

        config(['app.debug' => false]);
    }

    //Tests
    public function test_store_method_successfully_creates_comment_like(): void
    {
        $this->actingAs($this->user);

        // Mock the CommentLikeRequest
        $request = Mockery::mock(CommentLikeRequest::class);
        $request->allows('validated')
            ->andReturns([
                'user_id' => $this->user->id,
                'comment_id' => $this->comment->id,
            ]);

        $data = $request->validated();

        $comment = Comment::with('user', 'commentLikes')
            ->find($data['comment_id']);
        $like = $comment->commentLikes()
            ->createOrFirst($data);
        $type = $comment->item_type === Post::class ? 'posts' : 'news';

        // Mock the CommentLikeService
        $commentLikeServiceMock = Mockery::mock(CommentLikeService::class);
        $commentLikeServiceMock->expects('storeCommentLike')
            ->with($request)
            ->andReturns([$like, $type, $comment]);

        // Mock the ActivityService
        $activityServiceMock = Mockery::mock(ActivityService::class);
        $activityServiceMock->expects('storeActivity')
            ->withArgs([$like, "$type.show", $comment->item_id, 'bi bi-hand-thumbs-up', 'liked a comment']);

        // Create an instance of the controller
        $controller = new CommentLikeController($commentLikeServiceMock, $activityServiceMock);

        // Call the store method
        $response = $controller->store($request);

        // Assert the response
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'Like added successfully',
            'like' => [
                'user' => [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'picture' => $this->user->profile_picture ? asset($this->user->profile_picture) : '',
                ],
            ],
        ], JSON_THROW_ON_ERROR), $response->content());

        Mockery::close();
    }
}
