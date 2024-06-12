<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewLike;
use App\Notifications\NewProfilePost;
use ConsoleTVs\Profanity\Facades\Profanity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ParentService
{
    public function returnErrorResponse($response, $method): JsonResponse
    {
        $parts = explode('::', $method);
        $method = end($parts);

        return response()->json([
            'message' => "Failed to edit resource ($method)" ,
            'error' => $response['error'],
        ], $response['code']);
    }
}
