<?php

namespace Tests\Feature\Follow;

use App\Models\Follow;
use App\Models\User;
use App\Notifications\NewFollower;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Tests\Traits\ModelFactoryTrait;

class FollowControllerTest extends TestCase
{
    use WithFaker, DatabaseTransactions, ModelFactoryTrait;

    protected User $follower;
    protected User $followee;

    public function setUp(): void
    {
        parent::setUp();

        // Create a follower and a followee
        $this->follower = $this->createUser();
        $this->followee = $this->createUser();

        config(['app.debug' => false]);
    }

    //Tests
    public function test_user_not_logged_in(): void
    {
        // Do not use $this->>actingAs($this->follower);

        // Make POST request to create follow
        $response = $this->json('POST', '/follows', [
            'follower_id' => $this->follower->id,
            'followee_id' => $this->followee->id,
        ]);

        // Assert correct error response
        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);

        // Ensure no follow is created
        $this->assertDatabaseMissing('follows', [
            'follower_id' => $this->follower->id,
            'followee_id' => $this->followee->id,
        ]);
    }

    public function test_form_user_id_does_not_match_auth_user_id(): void
    {
        $this->actingAs($this->follower);

        // Make POST request to create follow
        $response = $this->json('POST', '/follows', [
            'follower_id' => 1,
            'followee_id' => $this->followee->id,
        ]);

        // Assert correct error response
        $response->assertStatus(403)
            ->assertJson([
                'message' => 'Authentication error',
            ]);

        // Ensure no follow is created
        $this->assertDatabaseMissing('follows', [
            'follower_id' => $this->follower->id,
            'followee_id' => $this->followee->id,
        ]);
    }

    public function test_user_can_follow_a_user(): void
    {
        $this->actingAs($this->follower);

        // Make POST request to create follow
        $response = $this->json('POST', '/follows', [
            'follower_id' => $this->follower->id,
            'followee_id' => $this->followee->id,
        ]);

        // Assert success status and JSON
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Follow added successfully',
            ]);

        // Assert that the user has been followed
        $this->assertDatabaseHas('follows', [
            'follower_id' => $this->follower->id,
            'followee_id' => $this->followee->id,
        ]);

        // Assert the activity is logged
        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'default',
            'subject_type' => Follow::class,
            'description' => 'followed ' . $this->followee->name,
            'causer_id' => $this->follower->id,
        ]);
    }

    public function test_user_can_unfollow_a_user(): void
    {
        $this->actingAs($this->follower);

        // Make POST request to create follow
        $response = $this->json('DELETE', '/follows', [
            'follower_id' => $this->follower->id,
            'followee_id' => $this->followee->id,
        ]);

        // Assert success status and JSON
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Follow removed successfully',
            ]);

        // Assert that the user has been followed
        $this->assertDatabaseMissing('follows', [
            'follower_id' => $this->follower->id,
            'followee_id' => $this->followee->id,
        ]);
    }

    public function test_user_cannot_follow_non_existent_user(): void
    {
        $this->actingAs($this->follower);

        // Attempt to follow a user ID that does not exist
        $response = $this->json('POST', '/follows', [
            'follower_id' => $this->follower->id,
            'followee_id' => 999999,
        ]);

        // Assert correct error response
        $response->assertStatus(422)
            ->assertJson([
                'message' => 'The selected followee id is invalid.',
            ]);
    }

    public function test_user_follow_failure_due_to_missing_ids(): void
    {
        $this->actingAs($this->follower);

        // Make POST request to create follow with null IDs
        $response = $this->json('POST', '/follows', [
            'user_id' => null,
            'post_id' => null,
        ]);

        // Assert that the response status is 422 Unprocessable Entity
        $response->assertStatus(422);

        // Assert specific validation errors are returned
        $response->assertJsonValidationErrors([
            'follower_id' => 'The follower id field is required.',
            'followee_id' => 'The followee id field is required.',
        ]);
    }

    public function test_user_follow_failure_due_to_string_ids(): void
    {
        $this->actingAs($this->follower);

        // Make POST request to create follow with string values
        $response = $this->json('POST', '/follows', [
            'follower_id' => 'string',
            'followee_id' => 'string',
        ]);

        // Assert that the response status is 422 Unprocessable Entity
        $response->assertStatus(422);

        // Assert specific validation errors are returned
        $response->assertJsonValidationErrors([
            'follower_id' => 'The follower id field must be an integer.',
            'followee_id' => 'The followee id field must be an integer.',
        ]);
    }

    public function test_follow_sends_notification(): void
    {
        $this->actingAs($this->follower);

        // Mock notification service
        Notification::fake();

        // Make POST request to create follow
        $this->json('POST', '/follows', [
            'follower_id' => $this->follower->id,
            'followee_id' => $this->followee->id,
        ]);

        // Assert notification was sent
        Notification::assertSentTo(
            [$this->followee],
            NewFollower::class,
            function ($notification, $channels) {
                return $notification->follower->id === $this->follower->id;
            }
        );
    }

}
