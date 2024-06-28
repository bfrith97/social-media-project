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
use Illuminate\Support\Facades\Validator;
use Mockery;
use Spatie\Activitylog\Models\Activity;
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

    public function test_comment_like_request_validation_passes_with_correct_data(): void
    {
        $data = [
            'user_id' => $this->user->id,
            'comment_id' => $this->comment->id,
        ];

        // Manually create the validator instance
        $validator = Validator::make($data, (new CommentLikeRequest())->rules());

        // Check if the data passes the validation
        $validatedData = $validator->validate();

        // Expect the validation to succeed
        $this->assertTrue($validator->passes());

        // Assert that the data has been validated
        $this->assertEquals([
            'user_id' => $this->user->id,
            'comment_id' => $this->comment->id,
        ], $validatedData);
    }

    public function test_comment_like_request_validation_fails_with_incorrect_data(): void
    {
        $data = [
            'user_id' => $this->user->id,
            'comment_id' => null,
        ];

        // Manually create the validator instance
        $validator = Validator::make($data, (new CommentLikeRequest())->rules());

        // Expect the validation to fail
        $this->assertFalse($validator->passes());

        // Check for specific error related to comment_id
        $this->assertArrayHasKey('comment_id', $validator->errors()
            ->messages());
    }

    public function test_activity_service_returns_correct_response(): void
    {
        $this->actingAs($this->user);

        // Mock the CommentRequest
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
        $comment->load($type === 'posts' ? 'post' : 'newsArticle');

        // Create an instance of the service being tested
        $service = new ActivityService();

        // Call the method under test
        $result = $service->storeActivity($like, "$type.show", $comment->item_id, 'bi bi-hand-thumbs-up', 'liked a comment');
        unset($result['id'], $result['created_at'], $result['updated_at']);

        // Assertions to verify the correct behavior
        $this->assertInstanceOf(Activity::class, $result);
        $this->assertEquals([
            "log_name" => "default",
            "properties" => [
                "route" => route("$type.show", $comment->item_id),
                "icon" => "bi bi-hand-thumbs-up",
            ],
            "causer_id" => $this->user->id,
            "causer_type" => "App\Models\User",
            "batch_uuid" => null,
            "subject_id" => 0,
            "subject_type" => "App\Models\CommentLike",
            "description" => "liked a comment",
        ], $result->attributesToArray());
    }
}
