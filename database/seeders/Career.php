<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Career extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('careers')->upsert(
            [
                [
                    'name' => 'Ingeniería de software',
                ],
                [
                    'name' => 'Diseño gráfico',
                ],
                [
                    'name' => 'Diseño de modas',
                ],
                [
                    'name' => 'Hoteleria y turismo',
                ],
            ],
            ['name'],
            ['name'],
        );
    }
}
