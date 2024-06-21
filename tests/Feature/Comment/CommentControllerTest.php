<?php

namespace Comment;

use App\Models\NewsArticle;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
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
    public function test_user_not_logged_in(): void
    {
        // Do not use $this->>actingAs($this->user);

        // Make POST request to create a comment
        $response = $this->json('POST', '/comments', [
            'user_id' => $this->user->id,
            'item_type' => 'App\Models\Post',
            'item_id' => $this->post->id,
        ]);

        // Assert correct error response
        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);

        // Ensure no comment is created
        $this->assertDatabaseMissing('comments', [
            'user_id' => $this->user->id,
            'item_type' => 'App\Models\Post',
            'item_id' => $this->post->id,
        ]);
    }

    public function test_form_user_id_does_not_match_auth_user_id(): void
    {
        $this->actingAs($this->user);

        // Make POST request to create a comment
        $response = $this->json('POST', '/comments', [
            'user_id' => 1,
            'item_type' => 'App\Models\Post',
            'item_id' => $this->post->id,
            'content' => 'content example',
        ]);

        // Assert correct error response
        $response->assertStatus(403)
            ->assertJson([
                'message' => 'Authentication error',
            ]);

        // Ensure no comment is created
        $this->assertDatabaseMissing('comments', [
            'user_id' => $this->user->id,
            'item_type' => 'App\Models\Post',
            'item_id' => $this->post->id,
            'content' => 'content example',
        ]);
    }

    public function test_user_can_comment_on_a_post(): void
    {
        $this->actingAs($this->user);

        // Make POST request to create a comment
        $response = $this->json('POST', '/comments', [
            'user_id' => $this->user->id,
            'item_type' => 'App\Models\Post',
            'item_id' => $this->post->id,
            'content' => 'content example',
        ]);

        // Assert success status and JSON
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Comment added successfully',
            ]);

        // Assert that a comment as been created
        $this->assertDatabaseHas('comments', [
            'user_id' => $this->user->id,
            'item_type' => 'App\Models\Post',
            'item_id' => $this->post->id,
            'content' => 'content example',
        ]);

        // Assert the activity is logged
        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'default',
            'subject_type' => Post::class,
            'description' => 'commented on a post',
            'causer_id' => $this->user->id,
        ]);
    }

    public function test_user_can_comment_on_a_news_article(): void
    {
        $this->actingAs($this->user);

        // Make POST request to create a comment
        $response = $this->json('POST', '/comments', [
            'user_id' => $this->user->id,
            'item_type' => 'App\Models\NewsArticle',
            'item_id' => $this->newsArticle->id,
            'content' => 'content example',
        ]);

        // Assert success status and JSON
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Comment added successfully',
            ]);

        // Assert that a comment as been created
        $this->assertDatabaseHas('comments', [
            'user_id' => $this->user->id,
            'item_type' => 'App\Models\NewsArticle',
            'item_id' => $this->newsArticle->id,
            'content' => 'content example',
        ]);

        // Assert the activity is logged
        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'default',
            'subject_type' => NewsArticle::class,
            'description' => 'commented on a post',
            'causer_id' => $this->user->id,
        ]);
    }

    public function test_user_comment_failure_due_to_missing_ids(): void
    {
        $this->actingAs($this->user);

        // Make POST request to create a comment with null IDs
        $response = $this->json('POST', '/comments', [
            'user_id' => null,
            'item_type' => null,
            'item_id' => null,
            'content' => null,
        ]);

        // Assert that the response status is 422 Unprocessable Entity
        $response->assertStatus(422);

        // Assert specific validation errors are returned
        $response->assertJsonValidationErrors([
            'user_id' => 'The user id field is required.',
            'item_type' => 'The item type field is required.',
            'item_id' => 'The item id field is required.',
            'content' => 'The content field is required.',
        ]);
    }

    public function test_user_comment_failure_due_to_string_ids(): void
    {
        $this->actingAs($this->user);

        // Make POST request to create a comment with string values
        $response = $this->json('POST', '/comments', [
            'user_id' => 'string',
            'item_type' => 'string',
            'item_id' => 'string',
            'content' => 'string',
        ]);

        // Assert that the response status is 422 Unprocessable Entity
        $response->assertStatus(422);

        // Assert specific validation errors are returned
        $response->assertJsonValidationErrors([
            'user_id' => 'The user id field must be an integer.',
            'item_type' => 'The selected item type is invalid.',
            'item_id' => 'The item id field must be an integer.',
        ]);
    }
}
