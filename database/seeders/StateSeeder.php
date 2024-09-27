<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            [
                "id" => 1,
                "name" => "الأنبار",
                "country_id" => 1,
            ],
            [
                "id" => 2,
                "name" => "بابل",
                "country_id" => 1,
            ],
            [
                "id" => 3,
                "name" => "بغداد",
                "country_id" => 1,
            ],
            [
                "id" => 4,
                "name" => "البصرة",
                "country_id" => 1,
            ],
            [
                "id" => 5,
                "name" => "دهوك",
                "country_id" => 1,
            ],
            [
                "id" => 6,
                "name" => "ديالى",
                "country_id" => 1,
            ],
            [
                "id" => 7,
                "name" => "أربيل",
                "country_id" => 1,
            ],
            [
                "id" => 8,
                "name" => "كربلاء",
                "country_id" => 1,
            ],
            [
                "id" => 9,
                "name" => "كركوك",
                "country_id" => 1,
            ],
            [
                "id" => 10,
                "name" => "ميسان",
                "country_id" => 1,
            ],
            [
                "id" => 11,
                "name" => "المثنى",
                "country_id" => 1,
            ],
            [
                "id" => 12,
                "name" => "النجف",
                "country_id" => 1,
            ],
            [
                "id" => 13,
                "name" => "نينوى",
                "country_id" => 1,
            ],
            [
                "id" => 14,
                "name" => "القادسية",
                "country_id" => 1,
            ],
            [
                "id" => 15,
                "name" => "صلاح الدين",
                "country_id" => 1,
            ],
            [
                "id" => 16,
                "name" => "السليمانية",
                "country_id" => 1,
            ],
            [
                "id" => 17,
                "name" => "ذي قار",
                "country_id" => 1,
            ],
            [
                "id" => 18,
                "name" => "واسط",
                "country_id" => 1,
            ],
        ];

        foreach ($states as $state) {
            $state = State::updateOrCreate(
                [
                    'id' => $state['id']
                ],
                [
                    'id' => $state['id'],
                    'name' => $state['name'],
                    'country_id' => $state['country_id'],
                ],
            );
        }
    }
}
