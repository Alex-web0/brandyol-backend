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
        $files = [
            [
                'id' => 1,
                'user_id' => 1,
                'owner_id' => 1,
                'path' => "/uploads/placeholder.png",
                'owner_type' => Product::$ownerType,
            ]
        ];


        foreach ($files as $file) {
            $file = FileAttachment::updateOrCreate(
                [
                    'id' => $file['id']
                ],
                [
                    'id' => $file['id'],
                    'user_id' => $file['user_id'],
                    'owner_id' => $file['owner_id'],
                    'path' => $file['path'],
                    'owner_type' => $file['owner_type'],
                ],
            );
        }
    }
}
