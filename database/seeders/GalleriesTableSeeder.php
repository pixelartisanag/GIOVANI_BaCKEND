<?php
namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class GalleriesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $featuredIds = [1, 2, 3];
        for ($i = 1; $i <= 10; $i++) {
            $isFeatured = in_array($i, $featuredIds);
            $title = $faker->sentence(3);
            $mainImage = $this->storeDummyImage();
            $mediaGallery = $this->storeDummyGallery($faker);
            Gallery::create([
                'title' => $title,
                'featured' => $isFeatured,
                'main_image' => $mainImage,
                'plan_id' => rand(1, 3),
                'price' => rand(10, 50),
                'media_gallery' => $mediaGallery,
                'published' => true,
                'uri' => Str::slug($title),
            ]);
        }
    }

    private function storeDummyImage()
    {
        $filename = Str::random(10) . '.jpg';
        $filepath = public_path('dummy-images/' . $filename);
        copy('https://source.unsplash.com/random/800x600', $filepath);
        return asset('dummy-images/' . $filename);
    }

    private function storeDummyGallery($faker)
    {
        $gallery = [];
        for ($i = 1; $i <= 4; $i++) {
            $filename = Str::random(10) . '.jpg';
            $filepath = public_path('dummy-images/' . $filename);
            copy('https://source.unsplash.com/random/800x600', $filepath);
            $gallery[] = [
                'src' => asset('dummy-images/' . $filename),
                'title' => $faker->sentence(3),
                'description' => $faker->paragraph(2),
            ];
        }
        return $gallery;
    }
}
