<?php

namespace Database\Seeders;

use App\Models\PromoCode;
use Illuminate\Database\Seeder;

class PromoCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            PromoCode::create(
                [
                    'code' => 'PROMO'.str_pad($i, 3, '0', STR_PAD_LEFT),
                    'discount_percent' => min($i * 5, 100), // 5%, 10%, 15%... up to 50%
                    'max_uses' => 10 * $i, // 10, 20, 30... up to 100
                    'used_count' => min($i * 2, 10 * $i - 1), // Always less than max_uses
                    'expires_at' => now()->addDays(30 + ($i * 10)), // Varying expiration dates
                ],
            );
        }

        // Add some expired promo codes for testing
        PromoCode::create([
            'code' => 'EXPIRED001',
            'discount_percent' => 20,
            'max_uses' => 100,
            'used_count' => 10,
            'expires_at' => now()->subDays(10), // Expired
        ]);

        // Add a fully used promo code
        PromoCode::create([
            'code' => 'FULLYUSED001',
            'discount_percent' => 15,
            'max_uses' => 50,
            'used_count' => 50, // Fully used
            'expires_at' => now()->addDays(30),
        ]);
    }
}
