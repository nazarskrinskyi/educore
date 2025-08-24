<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Badge::factory()->create(
                [
                    'name' => "Badge $i",
                    'description' => "Description $i",
                    'icon_path' => null
                ]
            );
        }
    }
}
