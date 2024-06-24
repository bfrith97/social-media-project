<?php

namespace Tests\Unit\PostLike;

use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\PostLikeController;
use App\Http\Requests\CommentLikeRequest;
use App\Http\Requests\PostLikeRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Services\ActivityService;
use App\Services\CommentLikeService;
use App\Services\PostLikeService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;
use Tests\Traits\ModelFactoryTrait;

class PostLikeControllerTest extends TestCase
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

        // Mock the PostLikeRequest
        $request = Mockery::mock(PostLikeRequest::class);
        $request->allows('validated')
            ->andReturns([
                'user_id' => $this->user->id,
                'post_id' => $this->post->id,
            ]);

        $data = $request->validated();

        $post = Post::with('user')
            ->findOrFail($data['post_id']);
        $like = $post->postLikes()
            ->createOrFirst($data);

        // Mock the PostLikeService
        $postLikeServiceMock = Mockery::mock(PostLikeService::class);
        $postLikeServiceMock->expects('storePostLike')
            ->with($request)
            ->andReturns($like);

        // Mock the ActivityService
        $activityServiceMock = Mockery::mock(ActivityService::class);
        $activityServiceMock->expects('storeActivity')
            ->withArgs([$like, 'posts.show', $like->post_id, 'bi bi-hand-thumbs-up', 'liked a post']);

        // Create an instance of the controller
        $controller = new PostLikeController($postLikeServiceMock, $activityServiceMock);

        // Call the store method
        $response = $controller->store($request);

        // Assert the response
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'Like added successfully',
            'like' => [
                'id' => $like->id,
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
