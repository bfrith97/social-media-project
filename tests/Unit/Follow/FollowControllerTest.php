<?php

namespace Tests\Unit\Follow;

use App\Http\Controllers\FollowController;
use App\Http\Requests\FollowRequest;
use App\Models\Comment;
use App\Models\Follow;
use App\Models\Post;
use App\Models\User;
use App\Services\ActivityService;
use App\Services\FollowService;
use App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Mockery;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;
use Tests\Traits\ModelFactoryTrait;

class FollowControllerTest extends TestCase
{
    use WithFaker, DatabaseTransactions, ModelFactoryTrait;

    protected User $user;
    protected Post $post;

    public function setUp(): void
    {
        parent::setUp();

        // Create a follower and a followee
        $this->follower = $this->createUser();
        $this->followee = $this->createUser();

        config(['app.debug' => false]);
    }

    //Tests
    public function test_store_method_successfully_creates_follow(): void
    {
        $this->actingAs($this->follower);

        // Mock the FollowRequest
        $request = Mockery::mock(FollowRequest::class);
        $request->allows('validated')
            ->andReturns([
                'follower_id' => $this->follower->id,
                'followee_id' => $this->followee->id,
            ]);

        // Mock the FollowService
        $follow = new Follow($request->validated());
        $postServiceMock = Mockery::mock(FollowService::class);
        $postServiceMock->expects('storeFollow')
            ->with($request)
            ->andReturns([
                $follow,
                $this->followee,
            ]);

        // Mock the ActivityService
        $activityServiceMock = Mockery::mock(ActivityService::class);
        $activityServiceMock->expects('storeActivity')
            ->withArgs([$follow, 'profiles.show', $follow->followee_id, 'bi bi-person-add', 'followed ' . $follow->followee->name]);

        // Mock the UserService
        $userServiceMock = Mockery::mock(UserService::class);

        // Create an instance of the controller
        $controller = new FollowController($postServiceMock, $activityServiceMock, $userServiceMock);

        // Call the store method
        $response = $controller->store($request);

        // Assert the response
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertJsonStringEqualsJsonString(json_encode([
            "message" => "Follow added successfully",
        ], JSON_THROW_ON_ERROR), $response->content());

        Mockery::close();
    }

    public function test_follow_request_validation_passes_with_correct_data(): void
    {
        $data = [
            'follower_id' => $this->follower->id,
            'followee_id' => $this->followee->id,
        ];

        // Manually create the validator instance
        $validator = Validator::make($data, (new FollowRequest())->rules());

        // Check if the data passes the validation
        $validatedData = $validator->validate();

        // Expect the validation to succeed
        $this->assertTrue($validator->passes());

        // Assert that the data has been validated
        $this->assertEquals([
            'follower_id' => $this->follower->id,
            'followee_id' => $this->followee->id,
        ], $validatedData);
    }

    public function test_follow_request_validation_fails_with_incorrect_data(): void
    {
        $data = [
            'follower_id' => $this->follower->id,
            'followee_id' => null,
        ];

        // Manually create the validator instance
        $validator = Validator::make($data, (new FollowRequest())->rules());

        // Expect the validation to fail
        $this->assertFalse($validator->passes());

        // Check for specific error related to followee_id
        $this->assertArrayHasKey('followee_id', $validator->errors()
            ->messages());
    }

    public function test_activity_service_returns_correct_response(): void
    {
        $this->actingAs($this->follower);

        // Mock the FollowRequest
        $request = Mockery::mock(FollowRequest::class);
        $request->allows('validated')
            ->andReturns([
                'follower_id' => $this->follower->id,
                'followee_id' => $this->followee->id,
            ]);

        $data = $request->validated();

        $follow = Follow::createOrFirst($data);
        $followee = User::find($data['followee_id']);

        // Create an instance of the service being tested
        $service = new ActivityService();

        // Call the method under test
        $result = $service->storeActivity($follow, 'profiles.show', $follow->followee_id, 'bi bi-person-add', 'followed ' . $followee->name);
        unset($result['id'], $result['created_at'], $result['updated_at']);

        // Assertions to verify the correct behavior
        $this->assertInstanceOf(Activity::class, $result);
        $this->assertEquals([
            "log_name" => "default",
            "properties" => [
                "route" => route("profiles.show", $this->followee->id),
                "icon" => "bi bi-person-add",
            ],
            "causer_id" => $this->follower->id,
            "causer_type" => "App\Models\User",
            "batch_uuid" => null,
            "subject_id" => 0,
            "subject_type" => "App\Models\Follow",
            "description" => "followed " . $this->followee->name,
        ], $result->attributesToArray());
    }
}
