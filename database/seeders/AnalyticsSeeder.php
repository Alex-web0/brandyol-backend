<?php

namespace Database\Seeders;

use App\Models\Analytics;
use App\Models\Brand;
use App\Models\ColorScheme;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnalyticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $analytics =   [
            [
                'id' => 1,
                'total_sales' => 0, // TODO: add sales query
                'estimated_revenue' => 0,
                'user_count' => User::count(),
                'transactions_count' => 0,
                'brand_count' => Brand::count(),
                'color_count' => ColorScheme::count(),
                'completed_orders' => 0,
                'pending_orders' => 0,
                'total_products' => Product::count(),
            ],
            [
                'id' => 2,
                'total_sales' => 0, // TODO: add sales query
                'estimated_revenue' => 0,
                'user_count' => User::count(),
                'transactions_count' => 0,
                'brand_count' => Brand::count(),
                'color_count' => ColorScheme::count(),
                'completed_orders' => 0,
                'pending_orders' => 0,
                'total_products' => Product::count(),
            ],
            [
                'id' => 3,
                'total_sales' => 0, // TODO: add sales query
                'estimated_revenue' => 0,
                'user_count' => User::count(),
                'transactions_count' => 0,
                'brand_count' => Brand::count(),
                'color_count' => ColorScheme::count(),
                'completed_orders' => 0,
                'pending_orders' => 0,
                'total_products' => Product::count(),
                'created_at' => '2025-03-20',
            ],
            [
                'id' => 4,
                'total_sales' => 23, // TODO: add sales query
                'estimated_revenue' => 2000,
                'user_count' => User::count() + 10,
                'transactions_count' => 0 + 10,
                'brand_count' => Brand::count() + 10,
                'color_count' => ColorScheme::count() + 10,
                'completed_orders' => 0 + 10,
                'pending_orders' => 0 + 3,
                'total_products' => Product::count() + 10,
                'created_at' => '2025-03-20',
            ],
        ];


        foreach ($analytics as $analytic) {
            $analytic = Analytics::updateOrCreate(
                [
                    'id' => $analytic['id']
                ],
                [
                    ...$analytic,
                    'id' => $analytic['id'],
                ],
            );
        }
    }
}
