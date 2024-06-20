<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentLikeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'comment_id' => ['required', 'integer', 'exists:comments,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
