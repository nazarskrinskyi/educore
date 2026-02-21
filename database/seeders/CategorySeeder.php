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
        // Clear existing categories to avoid duplicates on re-seeding
        Category::query()->delete();

        $categories = [
            ['name' => 'Web Development', 'slug' => 'web-development', 'description' => 'Learn modern web development technologies including HTML, CSS, JavaScript, and frameworks'],
            ['name' => 'Mobile Development', 'slug' => 'mobile-development', 'description' => 'Master mobile app development for iOS and Android platforms'],
            ['name' => 'Data Science', 'slug' => 'data-science', 'description' => 'Explore data analysis, machine learning, and artificial intelligence'],
            ['name' => 'Cloud Computing', 'slug' => 'cloud-computing', 'description' => 'Learn cloud platforms like AWS, Azure, and Google Cloud'],
            ['name' => 'Cybersecurity', 'slug' => 'cybersecurity', 'description' => 'Master security principles, ethical hacking, and network protection'],
            ['name' => 'Database Management', 'slug' => 'database-management', 'description' => 'Learn SQL, NoSQL, and database design principles'],
            ['name' => 'DevOps', 'slug' => 'devops', 'description' => 'Master CI/CD, containerization, and infrastructure automation'],
            ['name' => 'UI/UX Design', 'slug' => 'ui-ux-design', 'description' => 'Learn user interface and user experience design principles'],
            ['name' => 'Business & Marketing', 'slug' => 'business-marketing', 'description' => 'Digital marketing, business strategy, and entrepreneurship'],
            ['name' => 'Programming Languages', 'slug' => 'programming-languages', 'description' => 'Master various programming languages from basics to advanced'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
