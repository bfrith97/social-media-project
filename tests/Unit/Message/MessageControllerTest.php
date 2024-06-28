<?php


namespace Tests\Unit\Message;

use App\Http\Controllers\MessageController;
use App\Http\Requests\MessageRequest;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\Message;
use App\Models\User;
use App\Services\MessageService;
use App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Mockery;
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
    public function test_store_method_successfully_creates_post(): void
    {
        $this->actingAs($this->userOne);

        // Mock the MessageRequest
        $request = Mockery::mock(MessageRequest::class);
        $request->allows('validated')
            ->andReturns([
                'conversation_id' => $this->conversation->id,
                'user_id' => $this->userOne->id,
                'content' => 'content example',
            ]);

        // Mock the MessageService
        $message = new Message($request->validated());
        $messageServiceMock = Mockery::mock(MessageService::class);
        $messageServiceMock->expects('storeMessage')
            ->with($request)
            ->andReturns($message);

        // Mock the UserService
        $userServiceMock = Mockery::mock(UserService::class);

        // Create an instance of the controller
        $controller = new MessageController($messageServiceMock, $userServiceMock);

        // Call the store method
        $response = $controller->store($request);

        // Assert the response
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertJsonStringEqualsJsonString(json_encode([
            'message' => 'Message added successfully',
            'conversationId' => $this->conversation->id,
            'content' => $message,
        ], JSON_THROW_ON_ERROR), $response->content());

        Mockery::close();
    }

    public function test_follow_request_validation_passes_with_correct_data(): void
    {
        $data = [
            'conversation_id' => $this->conversation->id,
            'user_id' => $this->userOne->id,
            'content' => 'content example',
        ];

        // Manually create the validator instance
        $validator = Validator::make($data, (new MessageRequest())->rules());

        // Check if the data passes the validation
        $validatedData = $validator->validate();

        // Expect the validation to succeed
        $this->assertTrue($validator->passes());

        // Assert that the data has been validated
        $this->assertEquals([
            'conversation_id' => $this->conversation->id,
            'user_id' => $this->userOne->id,
            'content' => 'content example',
        ], $validatedData);
    }

    public function test_follow_request_validation_fails_with_incorrect_data(): void
    {
        $data = [
            'conversation_id' => $this->conversation->id,
            'user_id' => $this->userOne->id,
            'content' => null,
        ];

        // Manually create the validator instance
        $validator = Validator::make($data, (new MessageRequest())->rules());

        // Expect the validation to fail
        $this->assertFalse($validator->passes());

        // Check for specific error related to content
        $this->assertArrayHasKey('content', $validator->errors()
            ->messages());
    }
}
