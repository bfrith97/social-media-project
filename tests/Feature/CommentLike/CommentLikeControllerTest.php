<?php

namespace CommentLike;

use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Post;
use App\Models\User;
use App\Services\CommentLikeService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Mockery;
use Tests\TestCase;

class CommentLikeControllerTest extends TestCase
{
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        // Create a user and a post with a comment
        $this->user = User::factory()
            ->create();
        $this->post = Post::factory()
            ->create(['user_id' => $this->user->id]);
        $this->comment = Comment::factory()
            ->create([
                'user_id' => $this->user->id,
                'item_id' => $this->post->id,
                'item_type' => Post::class,
            ]);
    }

    public function test_user_not_logged_in(): void
    {
        // Do not use $this->>actingAs($this->user);

        // Make POST request to create comment like
        $response = $this->json('POST', '/comment-likes', [
            'user_id' => $this->user->id,
            'comment_id' => $this->comment->id,
        ]);

        // Assert correct error response
        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);

        // Ensure no like is created
        $this->assertDatabaseMissing('comment_likes', [
            'user_id' => $this->user->id,
            'comment_id' => $this->comment->id,
        ]);
    }

    public function test_form_user_id_does_not_match_auth_user_id(): void
    {
        $this->actingAs($this->user);

        // Make POST request to create comment like
        $response = $this->json('POST', '/comment-likes', [
            'user_id' => 1,
            'comment_id' => $this->comment->id,
        ]);

        // Assert correct error response
        $response->assertStatus(403)
            ->assertJson([
                'error' => 'User ID mismatch',
            ]);

        // Ensure no like is created
        $this->assertDatabaseMissing('comment_likes', [
            'user_id' => $this->user->id,
            'comment_id' => $this->comment->id,
        ]);
    }

    public function test_user_can_like_a_comment(): void
    {
        $this->actingAs($this->user);

        // Make POST request to create comment like
        $response = $this->json('POST', '/comment-likes', [
            'user_id' => $this->user->id,
            'comment_id' => $this->comment->id,
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

        // Assert that the comment has been liked
        $likeData = $response->getData()->like;
        $this->assertEquals($this->user->id, $likeData->user->id);
        $this->assertDatabaseHas('comment_likes', [
            'user_id' => $this->user->id,
            'comment_id' => $this->comment->id,
        ]);

        // Assert the activity is logged
        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'default',
            'subject_type' => CommentLike::class,
            'description' => 'liked a comment',
            'causer_id' => $this->user->id,
        ]);
    }

    public function test_user_like_comment_failure_due_to_missing_ids(): void
    {
        $user = User::factory()
            ->create();
        $this->actingAs($user);

        // Make POST request to create comment like with null IDs
        $response = $this->json('POST', '/comment-likes', [
            'user_id' => null,
            'comment_id' => null,
        ]);

        // Assert that the response status is 422 Unprocessable Entity
        $response->assertStatus(422);

        // Assert specific validation errors are returned
        $response->assertJsonValidationErrors([
            'user_id' => 'The user id field is required.',
            'comment_id' => 'The comment id field is required.',
        ]);
    }

    public function test_user_like_comment_failure_due_to_string_ids(): void
    {
        $user = User::factory()
            ->create();
        $this->actingAs($user);

        // Make POST request to create comment like with null IDs
        $response = $this->json('POST', '/comment-likes', [
            'user_id' => 'string',
            'comment_id' => 'string',
        ]);

        // Assert that the response status is 422 Unprocessable Entity
        $response->assertStatus(422);

        // Assert specific validation errors are returned
        $response->assertJsonValidationErrors([
            'user_id' => 'The user id field must be an integer.',
            'comment_id' => 'The comment id field must be an integer.',
        ]);
    }
}
