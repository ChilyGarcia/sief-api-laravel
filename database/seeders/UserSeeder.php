<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->upsert(
            [
                [
                    'name' => 'user@gmail.com',
                    'email' => 'user@gmail.com',
                    'password' => Hash::make('user@gmail.com'),
                ],
                [
                    'name' => 'admin@gmail.com',
                    'email' => 'admin@gmail.com',
                    'password' => Hash::make('admin@gmail.com'),
                ],
            ],
            ['email'],
            ['name', 'password'],
        );
    }
}
