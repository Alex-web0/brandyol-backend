<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'id' => 1,
                'brand_id' => 1,
                'color_scheme_id' => 1,
                'user_id' => 1,
                'file_attachment_id' => 1,
                'name' => "اقلام مكياج حجم كبير درزن",
                'name_kr' => "pens of makeup",
                'description' => "درزن اقلام يحتوي ١٢  و بخشب متين",
                'cost' => 2000,
                'price' => 2750,
                'discount' => null,
                // 'status' => 'active',
                'stock' => 100,
                'is_available' => true,
            ],

            [
                'id' => 2,
                'brand_id' => 1,
                'user_id' => 1,
                'color_scheme_id' => 2,
                'file_attachment_id' => 1,
                'name' => "اقلام مكياج حجم كبير درزن",
                'name_kr' => "pens of makeup",
                'description' => "درزن اقلام يحتوي ١٢  و بخشب متين",
                'cost' => 2000,
                'price' => 2750,
                'discount' => null,
                // 'status' => 'active',
                'stock' => 100,
                'is_available' => true,
            ],
        ];


        foreach ($products as $p) {
            Product::updateOrCreate(
                [
                    'id' => $p['id'],
                ],
                [
                    'id' => $p['id'],
                    'user_id' => $p['user_id'],
                    'brand_id' => $p['brand_id'],
                    'color_scheme_id' => $p['color_scheme_id'],
                    'file_attachment_id' => $p['file_attachment_id'],
                    'name' => $p['name'],
                    'name_kr' => $p['name_kr'],
                    'description' => $p['description'],
                    'cost' => $p['cost'],
                    'price' => $p['price'],
                    'cost' => $p['cost'],
                    'discount' => $p['discount'],
                    // 'status' => $p['status'],
                    'stock' => $p['stock'],
                    'is_available' => $p['is_available'],
                ],
            );
        }
    }
}
