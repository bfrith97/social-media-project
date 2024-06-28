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
use Illuminate\Support\Facades\Validator;
use Mockery;
use Spatie\Activitylog\Models\Activity;
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

    public function test_post_request_validation_passes_with_correct_data(): void
    {
        $data = [
            'content' => 'Sample post',
            'user_id' => $this->user->id,
        ];

        // Manually create the validator instance
        $validator = Validator::make($data, (new PostRequest())->rules());

        // Check if the data passes the validation
        $validatedData = $validator->validate();

        // Expect the validation to succeed
        $this->assertTrue($validator->passes());

        // Assert that the data has been validated
        $this->assertEquals([
            'content' => 'Sample post',
            'user_id' => $this->user->id,
        ], $validatedData);
    }

    public function test_post_request_validation_fails_with_incorrect_data(): void
    {
        $data = [
            'content' => null,
            'user_id' => $this->user->id,
        ];

        // Manually create the validator instance
        $validator = Validator::make($data, (new PostRequest())->rules());

        // Expect the validation to fail
        $this->assertFalse($validator->passes());

        // Check for specific error related to content
        $this->assertArrayHasKey('content', $validator->errors()
            ->messages());
    }

    public function test_activity_service_returns_correct_response(): void
    {
        $this->actingAs($this->user);

        // Mock the CommentRequest
        $request = Mockery::mock(PostRequest::class);
        $request->allows('validated')
            ->andReturns([
                'content' => 'Sample post',
                'user_id' => $this->user->id,
                'is_feeling' => 0,
            ]);

        $data = $request->validated();

        $post = Post::create($data);

        // Create an instance of the service being tested
        $service = new ActivityService();

        // Call the method under test
        $result = $service->storeActivity($post, 'posts.show', $post->id, 'bi bi-box-arrow-right', 'created a post');
        unset($result['id'], $result['created_at'], $result['updated_at']);

        // Assertions to verify the correct behavior
        $this->assertInstanceOf(Activity::class, $result);
        $this->assertEquals([
            "log_name" => "default",
            "properties" => [
                "route" => route("posts.show", $post->id),
                "icon" => "bi bi-box-arrow-right",
            ],
            "causer_id" => $this->user->id,
            "causer_type" => "App\Models\User",
            "batch_uuid" => null,
            "subject_id" => $post->id,
            "subject_type" => "App\Models\Post",
            "description" => "created a post",
        ], $result->attributesToArray());
    }
}
