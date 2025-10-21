<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            CourseSeeder::class,
            SectionSeeder::class,
            LessonSeeder::class,
            TestSeeder::class,
            QuestionSeeder::class,
            AnswerSeeder::class,
            TagSeeder::class,
            CertificateSeeder::class,
            PromoCodeSeeder::class,
        ]);
    }
}
