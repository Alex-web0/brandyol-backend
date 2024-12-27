<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reviews = [
            [
                'id' => 1,
                'product_id' => 1,
                'user_id' => 1,
                'rating' => 4.5,
                'content' => "اعجبني المنتج بشكل ممتاز جدا",
            ],
            [
                'id' => 2,
                'product_id' => 1,
                'user_id' => 2,
                'rating' => 4.5,
                'content' => "اعجبني المنتج بشكل ممتاز جدا",
            ]
        ];


        foreach ($reviews as $p) {
            Review::updateOrCreate(
                [
                    'id' => $p['id'],
                ],
                [
                    'id' => $p['id'],
                    'product_id' => $p['product_id'],
                    'user_id' => $p['user_id'],
                    'rating' => $p['rating'],
                    'content' => $p['content'],
                ],
            );
        }
    }
}
