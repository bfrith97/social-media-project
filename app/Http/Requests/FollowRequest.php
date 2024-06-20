<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FollowRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'follower_id' => ['required', 'integer', 'exists:users,id'],
            'followee_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
