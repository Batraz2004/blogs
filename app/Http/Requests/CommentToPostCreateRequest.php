<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CommentToPostCreateRequest extends FormRequest
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
        $data = [
            'message' => $this->message,
            'parent_id' => $this->parent_id,
            'commentable_type' => Post::class,
            'commentable_id' => $this->post_id,
            'user_id' => Auth::id(),
        ];

        return $data;
    }
}
