<?php

namespace Database\Seeders;

use App\Models\PromoCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromoCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            PromoCode::factory()->create(
                [
                    'code' => "PromoCode $i",
                    'discount_percent' => $i,
                    'max_uses' => 10 * $i,
                    'used_count' => $i * 10,
                    'expires_at' => now()->addDays(30),
                ]
            );
        }
    }
}
