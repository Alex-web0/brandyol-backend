<?php

namespace Database\Seeders;

use App\Models\ColorScheme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSchemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colorSchemes = [
            [
                'id' => 1,
                'name' => 'ابيض',
                'color' => 'ffffff',

            ],
            [
                'id' => 2,
                'name' => 'احمر',
                'color' => 'ffbbbb',

            ]
        ];


        foreach ($colorSchemes as $color) {
            $color = ColorScheme::updateOrCreate(
                [
                    'id' => $color['id']
                ],
                [
                    'id' => $color['id'],
                    'name' => $color['name'],
                    'color' => $color['color'],
                ],
            );
        }
    }
}
