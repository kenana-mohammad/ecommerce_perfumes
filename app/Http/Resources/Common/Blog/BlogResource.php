<?php

namespace App\Http\Resources\Common\Blog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'created_at' => ($this->created_at)->format('Y:m:d H:i:s A'),
            'main_image' => $this->main_image,
            'images' =>isset($this->images)?$this->images:null
        ];
    }
}
