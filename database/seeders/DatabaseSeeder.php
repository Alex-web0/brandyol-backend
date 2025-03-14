<?php

namespace Database\Seeders;

use App\Models\Analytics;
use App\Models\AppSection;
use App\Models\City;
use App\Models\ContactMethod;
use App\Models\FileAttachment;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            CountrySeeder::class,
            StateSeeder::class,
            UserSeeder::class,

            FileAttachmentSeeder::class,

            BrandSeeder::class,
            ColorSchemeSeeder::class,



            /// Product specific area
            ProductSeeder::class,
            ProductFeatureSeeder::class,

            ReviewSeeder::class,
            AppSectionSeeder::class,


            /// MUST STAY THE LAST ONE
            AnalyticsSeeder::class,

        ]);
    }
}
