<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Category::factory()->create(
                [
                    'name' => "Category $i",
                    'slug' => "category-$i",
                    'description' => "Category $i description",
                ]
            );
        }
    }
}
