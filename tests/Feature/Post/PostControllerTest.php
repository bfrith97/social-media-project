<?php

namespace Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\ModelFactoryTrait;

class PostControllerTest extends TestCase
{
    use WithFaker, DatabaseTransactions, ModelFactoryTrait;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        // Create a follower and a followee
        $this->user = $this->createUser();

        config(['app.debug' => false]);
    }

    //Tests
    public function test_user_not_logged_in(): void
    {
        // Do not use $this->>actingAs($this->user);

        // Make POST request to create a post
        $response = $this->json('POST', '/posts', [
            'user_id' => $this->user->id,
            'is_feeling' => 0,
            'content' => 'content example',
        ]);

        // Assert correct error response
        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);

        // Ensure no post is created
        $this->assertDatabaseMissing('posts', [
            'user_id' => $this->user->id,
            'is_feeling' => 0,
            'content' => 'content example',
        ]);
    }

    public function test_form_user_id_does_not_match_auth_user_id(): void
    {
        $this->actingAs($this->user);

        // Make POST request to create a post
        $response = $this->json('POST', '/posts', [
            'user_id' => 1,
            'is_feeling' => 0,
            'content' => 'content example',
        ]);

        // Assert correct error response
        $response->assertStatus(403)
            ->assertJson([
                'message' => 'Authentication error',
            ]);

        // Ensure no post is created
        $this->assertDatabaseMissing('posts', [
            'user_id' => $this->user->id,
            'is_feeling' => 0,
            'content' => 'content example',
        ]);
    }

    public function test_user_can_create_a_post(): void
    {
        $this->actingAs($this->user);

        // Make POST request to create a post
        $response = $this->json('POST', '/posts', [
            'user_id' => $this->user->id,
            'is_feeling' => 0,
            'content' => 'content example',
        ]);

        // Assert success status and JSON
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Post added successfully',
            ]);

        // Assert that a post as been created
        $this->assertDatabaseHas('posts', [
            'user_id' => $this->user->id,
            'is_feeling' => 0,
            'content' => 'content example',
        ]);

        // Assert the activity is logged
        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'default',
            'subject_type' => Post::class,
            'description' => 'created a post',
            'causer_id' => $this->user->id,
        ]);
    }

    public function test_user_post_failure_due_to_missing_ids(): void
    {
        $this->actingAs($this->user);

        // Make POST request to create a post with null IDs
        $response = $this->json('POST', '/posts', [
            'user_id' => null,
            'is_feeling' => null,
            'content' => null,
        ]);

        // Assert that the response status is 422 Unprocessable Entity
        $response->assertStatus(422);

        // Assert specific validation errors are returned
        $response->assertJsonValidationErrors([
            'user_id' => 'The user id field is required.',
            'content' => 'The content field is required.',
        ]);
    }

    public function test_user_post_failure_due_to_string_ids(): void
    {
        $this->actingAs($this->user);

        // Make POST request to create a post with string values
        $response = $this->json('POST', '/posts', [
            'user_id' => 'string',
            'is_feeling' => 'string',
            'content' => 'string',
        ]);

        // Assert that the response status is 422 Unprocessable Entity
        $response->assertStatus(422);

        // Assert specific validation errors are returned
        $response->assertJsonValidationErrors([
            'user_id' => 'The user id field must be an integer.',
            'is_feeling' => 'The is feeling field must be true or false.',
        ]);
    }
}
