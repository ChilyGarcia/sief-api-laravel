<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('academic_periods')->upsert(
            [
                [
                    'period' => '2019-1',
                ],
                [
                    'period' => '2019-2',
                ],
                [
                    'period' => '2020-1',
                ],
                [
                    'period' => '2020-2',
                ],
                [
                    'period' => '2021-1',
                ],
                [
                    'period' => '2021-2',
                ],
            ],
            ['period'],
            ['period'],
        );
    }
}
