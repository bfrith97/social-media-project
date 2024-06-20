<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomJsonException;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BaseController extends Controller
{
    public function handleException(Exception $e, Request $request = null): JsonResponse
    {
        if ($e instanceof ValidationException) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        }

        if ($e instanceof AuthenticationException) {
            return response()->json([
                'message' => 'Authentication error',
                'error' => $e->getMessage(),
            ], 403);
        }

        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'message' => 'Model not found error',
                'error' => $e->getMessage(),
            ], 404);
        }

        if ($e instanceof CustomJsonException) {
            return $e->render($request);
        }

        return response()->json([
            'message' => 'An unexpected error occurred',
            'error' => $e->getMessage(),
        ], 500);
    }
}
