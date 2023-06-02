<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
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
            'main_image' => $this->main_image,
            'plan_id' => $this->plan_id,
            'price' => $this->price,
            'media_gallery' => $this->media_gallery,
            'published' => $this->published,
            'uri' => $this->uri,
            'type' => 'Gallery',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function withResponse($request, $response)
    {
        $data = json_decode($response->getContent(), true);
        $response->setContent(json_encode($data['data']));
    }
}

