<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Category\CategoryResource;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "content" => $this->content,
            "slug" => $this->slug,
            "image" => $this->image,
            "comments_count" => count($this->comments),
            "user" => [
                "name" => $this->user->name
            ],
            "category" => new CategoryResource($this->category),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
