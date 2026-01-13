<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'message' => ['required'],
            'post_id' => ['required', 'exists:posts,id'],
            'parent_id' => ['nullable','exists:comments,id'],
        ];
    }

    public function getData(): array
    {
        return $this->only(['message', 'post_id', 'parent_id']);
    }
}
