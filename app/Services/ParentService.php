<?php

namespace App\Services;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class ParentService
{
    /**
     * @throws AuthenticationException
     */
    public function validateUser($request, $column = 'user_id'): void
    {
        if ($request->$column != Auth::id()) {
            throw new AuthenticationException('User ID mismatch, logged in user does not match with the provided user');
        }
    }
}
