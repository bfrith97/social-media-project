<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'cover_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'role' => ['nullable', 'string', 'max:191'],
            'company' => ['nullable', 'string', 'max:191'],
            'info' => ['nullable', 'string', 'max:191'],
            'number' => ['nullable', 'integer', 'min:0'],
            'date_of_birth' => ['nullable', 'date'],
            'relationship_id' => ['nullable', 'integer', 'exists:relationships,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
