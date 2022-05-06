<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
            "message" => "required|string",
            "post_id" => "required|exists:posts,id"
        ];
    }

    public function messages()
    {
        return [
            "message.required" => "message field cannot be empty",
            "post_id.exists" => "seems the resource doesn't longer exist"
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            
        ]);
    }
}
