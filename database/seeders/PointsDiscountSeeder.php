<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PointsDiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Point discount calculations for exchanging points
        DB::table('points_discounts')->insert([
            [
                'points_needed' => 100,
                'discount_percent' => 10,
                'stripe_discount_id' => 'RcPFNqKR',
                'created_at' => Carbon::now(),
            ],
            [
                'points_needed' => 200,
                'discount_percent' => 20,
                'stripe_discount_id' => 'kDd7x8Wj',
                'created_at' => Carbon::now(),
            ],
            [
                'points_needed' => 350,
                'discount_percent' => 35,
                'stripe_discount_id' => '9AxQ3v8e',
                'created_at' => Carbon::now(),
            ],
            [
                'points_needed' => 500,
                'discount_percent' => 50,
                'stripe_discount_id' => 'fzBkLtHq',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
