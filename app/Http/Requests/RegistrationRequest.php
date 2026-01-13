<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegistrationRequest extends FormRequest
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
            'email'    => ['required', 'max:255', 'email', 'unique:users'],
            'name'     => ['required', 'max:255'],
            'password' => ['required', 'max:255', 'confirmed', Password::min(8)],
        ];
    }

    public function getData(): array
    {
        return $this->only(['email', 'name', 'password']);
    }
}
