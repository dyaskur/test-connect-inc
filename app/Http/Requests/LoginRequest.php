<?php

namespace App\Http\Requests;


use JetBrains\PhpStorm\ArrayShape;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['email' => "string", 'password' => "string"])] public function rules(): array
    {
        return [
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|min:8',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required'    => 'Email is required',
            'email.email'       => 'Email is invalid',
            'email.exists'      => 'Email is not registered',
            'password.required' => 'Password is required',
            'password.min'      => 'Password must be at least 8 characters',
        ];
    }
}
