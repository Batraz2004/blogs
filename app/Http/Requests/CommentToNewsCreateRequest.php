<?php

namespace App\Http\Requests;

use App\Models\News;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CommentToNewsCreateRequest extends FormRequest
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
            'news_id' => ['required', 'exists:news,id'],
            'parent_id' => ['nullable','exists:comments,id'],
        ];
    }

    public function getData(): array
    {
        $data = [
            'message' => $this->message,
            'parent_id' => $this->parent_id,
            'commentable_type' => News::class,
            'commentable_id' => $this->news_id,
            'user_id' => Auth::id(),
        ];

        return $data;
    }
}
