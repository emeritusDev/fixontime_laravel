<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "email" => "bail|required|string|email|exists:users",
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'token' => 'required|exists:password_resets,token',
        ];
    }

    public function messages()
    {
        return [
            "email.required" => "Email field cannot be empty.",
            "email.email" => "Enter a valid email address",
            "email.exists" => "email does not exist",
            "password.required" => 'Password field cannot be empty',
            "password.confirmed" => 'password do not match',
            "token.exists" => "invalid token"
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            //
        ]);
    }
}
