<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'featured' => $this->featured,
            'main_image' => $this->main_image,
            'plan_id' => $this->plan_id,
            'price' => $this->price,
            'media_gallery' => $this->media_gallery,
            'published' => $this->published,
            'uri' => $this->uri,
            'type' => 'Story',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
