<?php

namespace Database\Seeders;

use App\Models\AppSection;
use Illuminate\Database\Seeder;

class AppSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appSections = [
            [
                'id' => 1,
                'name' => 'Special Offers',
                'banner_type' => 'carousel_item',
                'section' => 'special_offers',
                'type' => 'product',
                'brand_id' => null,
                'product_id' => null,
                'url' => null,
            ],
            [
                'id' => 2,
                'name' => 'BrandYol Special',
                'banner_type' => 'banner_16_by_19',
                'section' => 'brandyol_special',
                'type' => 'brand',
                'brand_id' => null,
                'product_id' => null,
                'url' => null,
            ],
        ];

        foreach ($appSections as $section) {
            AppSection::updateOrCreate(['id' => $section['id']], $section);
        }
    }
}
