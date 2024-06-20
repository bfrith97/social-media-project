<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content' => ['required', 'string'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'item_id' => ['required', 'integer', ],
            'item_type' => ['required', 'string', 'in:App\Models\Post,App\Models\NewsArticle'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
