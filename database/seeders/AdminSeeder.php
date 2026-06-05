<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@blkk.test',
            ],
            [
                'role' => 'admin',
                'name' => 'Administrator',

                'nik' => '0000000000000000',
                'phone' => '081234567890',

                'gender' => 'L',

                'birth_place' => 'Banjar',

                'birth_date' => '2000-01-01',

                'address' => 'BLKK Tanwiriyyah',

                'is_active' => true,

                'password' => Hash::make('password'),
            ]
        );
    }
}