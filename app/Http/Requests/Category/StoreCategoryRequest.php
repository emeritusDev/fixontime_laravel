<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('sanctum')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name" => "bail|required|string|unique:categories,name",
            "description" => "required|string",
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "name field cannot be empty",
            "description.required" => 'enter short description...',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            
        ]);
    }
}
