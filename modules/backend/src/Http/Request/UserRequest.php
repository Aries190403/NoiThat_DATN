<?php

namespace Modules\Backend\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string|min:1|max:50',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|regex:/^\+?[0-9]{10,15}$/',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
                'confirmed',
            ],
        ];
    }

        public function messages()
    {
        return [
            'name.required' => 'Name is a required field.',
            'name.string' => 'Name must be a string.',
            'name.min' => 'Name must be at least 1 character long.',
            'name.max' => 'Name must not exceed 50 characters.',
            'email.required' => 'Email is a required field.',
            'email.email' => 'Invalid email address.',
            'email.max' => 'Email must not exceed 255 characters.',
            'email.unique' => 'This email has already been taken.',
            'phone.regex' => 'Invalid phone number.',
            'password.required' => 'Password is a required field.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.regex' => 'Password must include at least one lowercase letter, one uppercase letter, one digit, and one special character.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
        
    }
}
