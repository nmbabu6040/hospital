<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'body' => ['required', 'string', 'min:3', 'max:1000'],
            'parent_id' => ['nullable', 'exists:comments,id'],
            // honeypot field — bot ফর্ম সাবমিট করলে এটা ভরে ফেলবে, মানুষ দেখবেও না
            'website' => ['prohibited'],
        ];
    }

    public function messages(): array
    {
        return [
            'website.prohibited' => 'Spam detected.',
        ];
    }
}
