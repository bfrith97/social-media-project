<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostLikeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'post_id' => ['required', 'integer', 'exists:posts,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
