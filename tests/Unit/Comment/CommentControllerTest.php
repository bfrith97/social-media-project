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
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Mockery;
use Spatie\Activitylog\Models\Activity;
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
                'content' => 'content example',
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

        // Create an instance of the controller
        $controller = new CommentController($postServiceMock, $activityServiceMock);

        // Call the store method
        $response = $controller->store($request);

        // Assert the response
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertJsonStringEqualsJsonString(json_encode([
            "comment" => [
                "content" => 'content example',
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

    public function test_comment_request_validation_passes_with_correct_data(): void
    {
        $data = [
            'user_id' => $this->user->id,
            'item_type' => 'App\Models\Post',
            'item_id' => $this->post->id,
            'content' => 'content example',
        ];

        // Manually create the validator instance
        $validator = Validator::make($data, (new CommentRequest())->rules());

        // Check if the data passes the validation
        $validatedData = $validator->validate();

        // Expect the validation to succeed
        $this->assertTrue($validator->passes());

        // Assert that the data has been validated
        $this->assertEquals([
            'user_id' => $this->user->id,
            'item_type' => 'App\Models\Post',
            'item_id' => $this->post->id,
            'content' => 'content example',
        ], $validatedData);
    }

    public function test_comment_request_validation_fails_with_incorrect_data(): void
    {
        $data = [
            'user_id' => $this->user->id,
            'item_type' => 'App\Models\Post',
            'item_id' => $this->post->id,
            'content' => '', // Invalid empty content
        ];

        // Manually create the validator instance
        $validator = Validator::make($data, (new CommentRequest())->rules());

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
        $request = Mockery::mock(CommentRequest::class);
        $request->allows('validated')
            ->andReturns([
                'user_id' => $this->user->id,
                'item_type' => 'App\Models\Post',
                'item_id' => $this->post->id,
                'content' => 'content example',
            ]);

        $data = $request->validated();
        $comment = new Comment($data);

        $model = $data['item_type']::findOrFail($data['item_id']);
        $type = $data['item_type'] === Post::class ? 'posts' : 'news';

        // Create an instance of the service being tested
        $service = new ActivityService();

        // Call the method under test
        $result = $service->storeActivity($model, "$type.show", $comment->item_id, 'bi bi-chat-left-dots', 'commented on a post');
        unset($result['id'], $result['created_at'], $result['updated_at']);

        // Assertions to verify the correct behavior
        $this->assertInstanceOf(Activity::class, $result);
        $this->assertEquals([
            "log_name" => "default",
            "properties" => [
                "route" => route("$type.show", $data['item_id']),
                "icon" => "bi bi-chat-left-dots",
            ],
            "causer_id" => $this->user->id,
            "causer_type" => "App\Models\User",
            "batch_uuid" => null,
            "subject_id" => $data['item_id'],
            "subject_type" => $data['item_type'],
            "description" => "commented on a post",
        ], $result->attributesToArray());
    }
}
