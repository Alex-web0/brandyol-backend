<?php

namespace Database\Seeders;

use App\Models\FileAttachment;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FileAttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'id' => 1,
                'user_id' => 1,
                'owner_id' => 1,
                'path' => "/uploads/placeholder.png",
                'owner_type' => Product::$ownerType,
            ]
        ];


        foreach ($brands as $brand) {
            $brand = FileAttachment::updateOrCreate(
                [
                    'id' => $brand['id']
                ],
                [
                    'id' => $brand['id'],
                    'user_id' => $brand['user_id'],
                    'owner_id' => $brand['owner_id'],
                    'path' => $brand['path'],
                    'owner_type' => $brand['owner_type'],
                ],
            );
        }
    }
}
