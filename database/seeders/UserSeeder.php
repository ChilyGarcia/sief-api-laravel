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
                    'name' => 'professional@gmail.com',
                    'email' => 'professional@gmail.com',
                    'password' => Hash::make('professional@gmail.com'),
                    'role' => 'professional',
                ],
                [
                    'name' => 'professional2@gmail.com',
                    'email' => 'professional2@gmail.com',
                    'password' => Hash::make('professional2@gmail.com'),
                    'role' => 'professional',
                ],
                [
                    'name' => 'patient@gmail.com',
                    'email' => 'patient@gmail.com',
                    'password' => Hash::make('patient@gmail.com'),
                    'role' => 'patient',
                ],
            ],
            ['email'],
            ['name', 'password', 'role'],
        );
    }
}
