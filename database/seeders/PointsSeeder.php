<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PointsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Stores records and dummy information inside points table
        DB::table('points')->insert([
            [
                'points_per_dollar' => 1,
                'start_date' => Carbon::now(),
                'expiry_date' => Carbon::now()->addYear(1),
                'created_at' => Carbon::now(),
            ],
        ]);
        //Points Multiplier
        DB::table('points_multipliers')->insert([
            [
                'group_id' => 4,
                'points_id' => 1,
                'multiplier' => 2,
                'start_date' => Carbon::now(),
                'expiry_date' => Carbon::now()->addYear(1),
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
