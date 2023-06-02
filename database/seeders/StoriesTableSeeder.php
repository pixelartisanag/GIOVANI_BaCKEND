<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            DB::table('stories')->insert([
                'title' => $faker->sentence(6),
                'excerpt' => $faker->text(200),
                'content' => $faker->paragraphs(3, true),
                'role' => $faker->randomElement([null, 'Admin', 'Moderator', 'User']),
                'media_gallery' => json_encode([
                    $faker->imageUrl(),
                    $faker->imageUrl(),
                ]),
                'published' => $faker->boolean(),
                'uri' => $faker->unique()->slug,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
