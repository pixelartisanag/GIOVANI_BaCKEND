<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $plans = [
            ['name' => 'Silver', 'price' => 29.99, 'period' => 'monthly'],
            ['name' => 'Gold', 'price' => 59.99, 'period' => 'monthly'],
            ['name' => 'Platinum', 'price' => 99.99, 'period' => 'monthly'],
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
