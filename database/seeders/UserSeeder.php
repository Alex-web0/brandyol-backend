<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'id' => 1,
                'phone_number' => '+9647701001000',
                'full_name' => 'Super Admin',
                'gender' => 'male',
                // 'country_id' => 1,
                // 'state_id' => 1,
                // 'sector' => 'System Administration',
                // 'address' => '123 Admin Street, City, Country',
                'role' => 'admin',
                'password' => 'password'
            ],
            [
                'id' => 2,
                'phone_number' => '+9647711001000',
                'full_name' => 'Manager',
                'gender' => 'male',
                // 'country_id' => 1,
                // 'state_id' => 2,
                // 'sector' => 'Printing Services',
                // 'address' => '456 Printing Avenue, City, Country',
                'role' => 'manager',
                'password' => 'password'
            ],
            [
                'id' => 3,
                'phone_number' => '+9647701001529',
                'full_name' => 'Another Customer Name',
                'gender' => 'male',
                // 'country_id' => 1,
                // 'state_id' => 4,
                // 'sector' => 'General Public',
                // 'address' => '202 Customer Lane, City, Country',
                'role' => 'customer',
            ]
        ];;

        foreach ($users as $user) {
            User::updateOrCreate(
                [
                    'id' => $user['id'],
                    'full_name' => $user['full_name'],
                    'phone_number' => $user['phone_number'],
                ],
                $user,
            );
        }
    }
}
