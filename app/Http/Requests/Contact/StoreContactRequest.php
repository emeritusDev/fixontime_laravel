<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "firstName" => "required|string",
            "lastName" => "required|string",
            "email" => "required|string|email",
            "company" => "required|string",
            "subject" => "required|string",
            "message" => "required|string",
        ];
    }

    public function messages()
    {
        return [
            "firstName.required" => "first name field required",
            "lastName.required" => "first name field required",
            "email.required" => "email field is required",
            "email.email" => "enter a valid email address",
            "company.required" => "please specify company name",
            "subject.required" => 'kindly specify the subject of your message',
            "message.required" => 'message field required',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            //
        ]);
    }
}
