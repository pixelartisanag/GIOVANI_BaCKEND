<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class VideosTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $featuredIds = [1, 2, 3];
        for ($i = 1; $i <= 10; $i++) {
            $isFeatured = in_array($i, $featuredIds);
            $title = $faker->sentence(3);
            $filename = Str::random(10) . '.mp4';
            $videoUrl = "https://dummyvideo.com/$filename";
            Storage::disk('public')->put($filename, file_get_contents('https://source.unsplash.com/random/1280x720'));
            Video::create([
                'title' => $title,
                'featured' => $isFeatured,
                'video_src' => $videoUrl,
                'plan_id' => rand(1, 3),
                'price' => rand(10, 50),
                'published' => true,
                'uri' => Str::slug($title),
            ]);
        }
    }
}
