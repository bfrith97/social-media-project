<?php

namespace Tests\Feature\Message;

use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\ModelFactoryTrait;

class MessageControllerTest extends TestCase
{
    use WithFaker, DatabaseTransactions, ModelFactoryTrait;

    protected User $userOne;
    protected User $userTwo;
    protected Conversation $conversation;
    protected ConversationParticipant $conversationParticipantOne;
    protected ConversationParticipant $conversationParticipantTwo;

    public function setUp(): void
    {
        parent::setUp();

        // Create a user and post
        $this->userOne = $this->createUser();
        $this->userTwo = $this->createUser();

        $this->conversation = $this->createConversation();

        $this->conversationParticipantOne = $this->createConversationParticipant($this->conversation, $this->userOne);
        $this->conversationParticipantTwo = $this->createConversationParticipant($this->conversation, $this->userTwo);

        config(['app.debug' => false]);
    }

    //Tests
    public function test_user_not_logged_in(): void
    {
        // Do not use $this->>actingAs($this->userOne);

        // Make POST request to send a message
        $response = $this->json('POST', '/messages', [
            'conversation_id' => $this->conversation->id,
            'user_id' => $this->userOne->id,
            'content' => 'content example',
        ]);

        // Assert correct error response
        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);

        // Ensure no message is created
        $this->assertDatabaseMissing('messages', [
            'conversation_id' => $this->conversation->id,
            'user_id' => $this->userOne->id,
            'content' => 'content example',
        ]);
    }

    public function test_form_user_id_does_not_match_auth_user_id(): void
    {
        $this->actingAs($this->userOne);

        // Make POST request to send a message
        $response = $this->json('POST', '/messages', [
            'conversation_id' => $this->conversation->id,
            'user_id' => 1,
            'content' => 'content example',
        ]);

        // Assert correct error response
        $response->assertStatus(403)
            ->assertJson([
                'message' => 'Authentication error',
            ]);

        // Ensure no message is created
        $this->assertDatabaseMissing('messages', [
            'conversation_id' => $this->conversation->id,
            'user_id' => $this->userOne->id,
            'content' => 'content example',
        ]);
    }

    public function test_user_can_create_message(): void
    {
        $this->actingAs($this->userOne);

        // Make POST request to send a message
        $response = $this->json('POST', '/messages', [
            'conversation_id' => $this->conversation->id,
            'user_id' => $this->userOne->id,
            'content' => 'content example',
        ]);


        // Assert success status and JSON
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Message added successfully',
            ]);

        // Assert that a message as been created
        $this->assertDatabaseHas('messages', [
            'conversation_id' => $this->conversation->id,
            'user_id' => $this->userOne->id,
            'content' => 'content example',
        ]);
    }

    public function test_user_message_failure_due_to_missing_ids(): void
    {
        $this->actingAs($this->userOne);

        // Make POST request to send a message with null IDs
        $response = $this->json('POST', '/messages', [
            'conversation_id' => null,
            'user_id' => null,
            'content' => null,
        ]);

        // Assert that the response status is 422 Unprocessable Entity
        $response->assertStatus(422);

        // Assert specific validation errors are returned
        $response->assertJsonValidationErrors([
            'conversation_id' => 'The conversation id field is required.',
            'user_id' => 'The user id field is required.',
            'content' => 'The content field is required.',
        ]);
    }

    public function test_user_message_failure_due_to_string_ids(): void
    {
        $this->actingAs($this->userOne);

        // Make POST request to send a message with string values
        $response = $this->json('POST', '/messages', [
            'conversation_id' => 'string',
            'user_id' => 'string',
            'content' => 'string',
        ]);

        // Assert that the response status is 422 Unprocessable Entity
        $response->assertStatus(422);

        // Assert specific validation errors are returned
        $response->assertJsonValidationErrors([
            'conversation_id' => 'The conversation id field must be an integer.',
            'user_id' => 'The user id field must be an integer.',
        ]);
    }
}
