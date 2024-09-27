<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            [
                'id' => 1,
                'name' => 'العراق',
            ]
        ];


        foreach ($countries as $country) {
            $country = Country::updateOrCreate(
                [
                    'id' => $country['id']
                ],
                [
                    'id' => $country['id'],
                    'name' => $country['name'],
                ],
            );
        }
    }
}
