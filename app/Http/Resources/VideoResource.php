<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
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
            'featured' => $this->featured,
            'video_src' => $this->video_src,
            'plan_id' => $this->plan_id,
            'price' => $this->price,
            'published' => $this->published,
            'uri' => $this->uri,
            'type' => 'Video',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
