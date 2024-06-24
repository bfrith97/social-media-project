<?php

namespace Tests\Unit\Follow;

use App\Http\Controllers\FollowController;
use App\Http\Requests\FollowRequest;
use App\Models\Follow;
use App\Models\Post;
use App\Models\User;
use App\Services\ActivityService;
use App\Services\FollowService;
use App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Mockery;
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
}
