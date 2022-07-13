<?php

namespace App\Http\Requests\ProductRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductEnquiryRequest extends FormRequest
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
            "name" => "required|string",
            "email" => "required|string|email",
            "company" => "required|string",
            "phone_number" => "required|string",
            "brand" => "required|string",
            "product" => "required|string",
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
            "product.required" => "please product field cannot be empty",
            "brand.required" => "please select brand",
            "company.required" => "please enter your mobile/whatsapp line",
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
