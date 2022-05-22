<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdatePostRequest extends FormRequest
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
            "title" => "bail|required|string|unique:posts,title,".$this->post,
            "content" => "required|string",
            "slug" => "required|string",
            "image" => "nullable|image|max:514",
            "category_id" => "required|string|exists:categories,id",
        ];
    }

    public function messages()
    {
        return [
            "title.required" => "post title field cannot be empty",
            "title.unique" => "post with this title already exist",
            "content.required" => "enter post content...",
            "image.image" => "file form not supported",
            "image.max" => "post image must be less than 514kb",
            "category_id.exists" => "selected category doesn't exist"
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "slug" => Str::slug($this->title, '-'),
        ]);
    }
}
