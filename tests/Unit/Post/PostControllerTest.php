<?php


namespace Tests\Unit\Post;

use App\Http\Controllers\PostController;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\User;
use App\Services\ActivityService;
use App\Services\NewsService;
use App\Services\PostService;
use App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;
use Tests\Traits\ModelFactoryTrait;

class PostControllerTest extends TestCase
{
    use WithFaker, DatabaseTransactions, ModelFactoryTrait;

    protected User $user;
    protected Post $post;

    public function setUp(): void
    {
        parent::setUp();

        // Create a user and a post
        $this->user = $this->createUser();
        $this->post = $this->createPost($this->user);

        config(['app.debug' => false]);
    }

    //Tests
    public function test_store_method_successfully_creates_post(): void
    {
        $this->actingAs($this->user);

        // Mock the PostRequest
        $request = Mockery::mock(PostRequest::class);
        $request->allows('validated')
            ->andReturns([
                'content' => 'Sample post',
                'user_id' => $this->user->id,
            ]);

        // Mock the PostService
        $post = new Post($request->validated());
        $postServiceMock = Mockery::mock(PostService::class);
        $postServiceMock->expects('storePost')
            ->with($request)
            ->andReturns($post);

        // Mock the ActivityService
        $activityServiceMock = Mockery::mock(ActivityService::class);
        $activityServiceMock->expects('storeActivity')
            ->withArgs([$post, 'posts.show', $post->id, 'bi bi-box-arrow-right', 'created a post']);

        // Mock the UserService
        $userServiceMock = Mockery::mock(UserService::class);

        // Mock the NewsService
        $newsServiceMock = Mockery::mock(NewsService::class);

        // Create an instance of the controller
        $controller = new PostController($postServiceMock, $userServiceMock, $newsServiceMock, $activityServiceMock);

        // Call the store method
        $response = $controller->store($request);

        // Assert the response
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertJsonStringEqualsJsonString(json_encode([
            "csrf" => null,
            "message" => "Post added successfully",
            "post" => [
                "comment_route" => route('comments.store'),
                "content" => 'Sample post',
                "id" => $post->id,
                "image_path" => null,
                "is_feeling" => null,
                "post_like_route" => route('post_likes.store'),
                "user" => [
                    "company" => $this->user->company,
                    "id" => $this->user->id,
                    "name" => $this->user->name,
                    "profile_picture" => $this->user->profile_picture ? asset($this->user->profile_picture) : '',
                    "profile_route" => route('profiles.show', $this->user->id),
                    "role" => $this->user->role,
                ],
            ],
        ], JSON_THROW_ON_ERROR), $response->content());

        Mockery::close();
    }
}
