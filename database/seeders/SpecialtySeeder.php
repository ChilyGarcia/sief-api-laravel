<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('specialties')->insert(
            [
                [
                    'name' => 'Cardiologia',
                ],
                [
                    'name' => 'Dermatologia',
                ],
                [
                    'name' => 'Endocrinologia',
                ],
                [
                    'name' => 'Gastroenterologia',
                ],
                [
                    'name' => 'Geriatria',
                ],
                [
                    'name' => 'Ginecologia',
                ],
                [
                    'name' => 'Hematologia',
                ],
                [
                    'name' => 'Infectologia',
                ],
                [
                    'name' => 'Nefrologia',
                ],
                [
                    'name' => 'Neurologia',
                ],
                [
                    'name' => 'Nutrologia',
                ],
                [
                    'name' => 'Oftalmologia',
                ],
                [
                    'name' => 'Ortopedia',
                ],
                [
                    'name' => 'Otorrinolaringologia',
                ],
                [
                    'name' => 'Pediatria',
                ],
                [
                    'name' => 'Pneumologia',
                ],
                [
                    'name' => 'Psiquiatria',
                ],
                [
                    'name' => 'Reumatologia',
                ],
                [
                    'name' => 'Urologia',
                ],
            ],
            ['name'],
            ['name']
        );
    }
}
