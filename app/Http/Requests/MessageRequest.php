<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'conversation_id' => ['required', 'integer', 'exists:conversations,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'content' => ['required', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
