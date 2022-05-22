<?php

namespace App\Http\Requests\Learning;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateLearningRequest extends FormRequest
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
            "title" => "required|string|unique:learnings,title,".$this->learning,
            "slug" => "required|string",
            "url" => "required|string",
            "thumbnail" => "required|image|max:514",
        ];
    }

    public function messages()
    {
        return [
            "title.required" => "flearnin material/video not specified",
            "title.unique" => "A material/video with this title already exist",
            "url.required" => "enter the url/link to the source",
            "thumbnail.required" => "Select an image/thumbnail",
            "thumbnail.image" => "image/thumbnail file type not supported",
            "thumbnail.max" => "image size too large",
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "slug" => Str::slug($this->title, '-')
        ]);
    }
}
