<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'id' => 1,
                'name' => 'ماركة اياكا',
                'name_kr' => 'maraka Ayaka',
                'description' => 'Hello guys',
            ]
        ];


        foreach ($brands as $brand) {
            $brand = Brand::updateOrCreate(
                [
                    'id' => $brand['id']
                ],
                [
                    'id' => $brand['id'],
                    'name' => $brand['name'],
                    'name_kr' => $brand['name_kr'],
                    'description' => $brand['description'],
                ],
            );
        }
    }
}
