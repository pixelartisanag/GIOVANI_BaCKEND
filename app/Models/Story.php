<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'excerpt',
        'content',
        'featured',
        'main_image',
        'plan_id',
        'price',
        'media_gallery',
        'published',
        'uri',
    ];

    protected $casts = [
        'media_gallery' => 'array',
        'featured' => 'boolean',
    ];
}
