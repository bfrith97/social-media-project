<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'group_id' => ['required', 'integer', 'exists:groups,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
