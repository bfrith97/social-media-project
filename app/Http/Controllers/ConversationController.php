<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConversationRequest;
use App\Services\ConversationService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConversationController extends BaseController
{
    private ConversationService $conversationService;

    public function __construct(ConversationService $conversationService)
    {
        $this->conversationService = $conversationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConversationRequest $request): ?JsonResponse
    {
        try {
            [$conversation, $participant, $newConversation] = $this->conversationService->storeConversation($request);

            return response()->json([
                'conversation' => $conversation,
                'participant' => $participant ?? null,
                'isNewConversation' => $newConversation,
            ]);

        } catch (Exception $e) {
            return $this->handleException($e, $request);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
