<?php

namespace Database\Seeders;

use App\Models\ProductFeature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'id' => 1,
                'product_id' => 4,
                'title' => 'الطول',
                'value' => 'طول المنتج ٩٠ سم',
            ],
            [
                'id' => 2,
                'product_id' => 4,
                'title' => 'العرض',
                'value' => 'عرض المنتج ٩٠ سم',
            ],
            [
                'id' => 3,
                'product_id' => 4,
                'title' => 'الارتفاع',
                'value' => 'ارتفاع المنتج ٩٠ سم',
            ],
        ];


        foreach ($products as $p) {
            ProductFeature::updateOrCreate(
                [
                    'id' => $p['id'],
                ],
                [
                    'id' => $p['id'],
                    'product_id' => $p['product_id'],
                    'title' => $p['title'],
                    'value' => $p['value'],

                ],
            );
        }
    }
}
