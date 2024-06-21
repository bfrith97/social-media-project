<?php

namespace PostLike;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\ModelFactoryTrait;

class PostLikeControllerTest extends TestCase
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
    public function test_user_not_logged_in(): void
    {
        // Do not use $this->>actingAs($this->user);

        // Make POST request to create post like
        $response = $this->json('POST', '/post-likes', [
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);

        // Assert correct error response
        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);

        // Ensure no like is created
        $this->assertDatabaseMissing('post_likes', [
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);
    }

    public function test_form_user_id_does_not_match_auth_user_id(): void
    {
        $this->actingAs($this->user);

        // Make POST request to create post like
        $response = $this->json('POST', '/post-likes', [
            'user_id' => 1,
            'post_id' => $this->post->id,
        ]);

        // Assert correct error response
        $response->assertStatus(403)
            ->assertJson([
                'message' => 'Authentication error',
            ]);

        // Ensure no like is created
        $this->assertDatabaseMissing('post_likes', [
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);
    }

    public function test_user_can_like_a_post(): void
    {
        $this->actingAs($this->user);

        // Make POST request to create post like
        $response = $this->json('POST', '/post-likes', [
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);

        // Assert success status and JSON
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Like added successfully',
                'like' => [
                    'user' => [
                        'id' => $this->user->id,
                        'name' => $this->user->name,
                        'picture' => asset($this->user->profile_picture),
                    ],
                ],
            ]);

        // Assert that the post has been liked
        $likeData = $response->getData()->like;
        $this->assertEquals($this->user->id, $likeData->user->id);
        $this->assertDatabaseHas('post_likes', [
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);

        // Assert the activity is logged
        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'default',
            'subject_type' => PostLike::class,
            'description' => 'liked a post',
            'causer_id' => $this->user->id,
        ]);
    }

    public function test_user_like_post_failure_due_to_missing_ids(): void
    {
        $this->actingAs($this->user);

        // Make POST request to create post like with null IDs
        $response = $this->json('POST', '/post-likes', [
            'user_id' => null,
            'post_id' => null,
        ]);

        // Assert that the response status is 422 Unprocessable Entity
        $response->assertStatus(422);

        // Assert specific validation errors are returned
        $response->assertJsonValidationErrors([
            'user_id' => 'The user id field is required.',
            'post_id' => 'The post id field is required.',
        ]);
    }

    public function test_user_like_post_failure_due_to_string_ids(): void
    {
        $this->actingAs($this->user);

        // Make POST request to create post like with string values
        $response = $this->json('POST', '/post-likes', [
            'user_id' => 'string',
            'post_id' => 'string',
        ]);

        // Assert that the response status is 422 Unprocessable Entity
        $response->assertStatus(422);

        // Assert specific validation errors are returned
        $response->assertJsonValidationErrors([
            'user_id' => 'The user id field must be an integer.',
            'post_id' => 'The post id field must be an integer.',
        ]);
    }
}
