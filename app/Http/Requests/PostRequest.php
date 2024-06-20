<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content' => ['required', 'string'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'group_id' => ['nullable', 'integer', 'exists:groups,id'],
            'profile_id' => ['nullable', 'integer', 'exists:users,id'],
            'is_feeling' => ['nullable', 'boolean'],
            'image_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
