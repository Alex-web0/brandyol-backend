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
                'user_id' => 4,
                'product_category_id' => 1,
                'name' => "اقلام المتنبي حجم كبير درزن",
                'description' => "درزن اقلام يحتوي ١٢ قلم من حجم  H2 سريع الكتابة و بخشب متين",
                'cost' => 2000,
                'price' => 2750,
                'discount' => null,
                'status' => 'active',
                'stock' => 100,
            ]
        ];


        foreach ($products as $p) {
            // Product::updateOrCreate(
            //     [
            //         'id' => $p['id'],
            //     ],
            //     [
            //         'id' => $p['id'],
            //         'user_id' => $p['user_id'],
            //         'product_category_id' => $p['product_category_id'],
            //         'name' => $p['name'],
            //         'description' => $p['description'],
            //         'cost' => $p['cost'],
            //         'price' => $p['price'],
            //         'discount' => $p['discount'],
            //         'status' => $p['status'],
            //         'stock' => $p['stock'],
            //     ],
            // );
        }
    }
}
