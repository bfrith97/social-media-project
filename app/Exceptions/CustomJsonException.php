<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class CustomJsonException extends Exception
{
    private int $statusCode;

    public function __construct($message , $statusCode = 400)
    {
        parent::__construct($message, $statusCode);

        $this->statusCode = $statusCode;
    }

    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => $this->message,
        ], $this->statusCode);
    }
}
