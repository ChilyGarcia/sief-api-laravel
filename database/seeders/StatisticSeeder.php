<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statistics')->upsert(
            [
                [
                    'graduate_students' => '2',
                    'retired_students' => '5',
                    'enrolled_students' => '10',
                    'admited_students' => '9',
                    'career_id' => '1',
                    'academic_period_id' => '1',
                ],
                [
                    'graduate_students' => '3',
                    'retired_students' => '6',
                    'enrolled_students' => '11',
                    'admited_students' => '10',
                    'career_id' => '2',
                    'academic_period_id' => '2',
                ],
                [
                    'graduate_students' => '4',
                    'retired_students' => '7',
                    'enrolled_students' => '12',
                    'admited_students' => '11',
                    'career_id' => '3',
                    'academic_period_id' => '3',
                ],
                [
                    'graduate_students' => '5',
                    'retired_students' => '8',
                    'enrolled_students' => '13',
                    'admited_students' => '12',
                    'career_id' => '4',
                    'academic_period_id' => '4',
                ],
            ],
            ['career_id', 'academic_period_id'],
            ['graduate_students', 'retired_students', 'enrolled_students', 'admited_students'],
        );
    }
}
