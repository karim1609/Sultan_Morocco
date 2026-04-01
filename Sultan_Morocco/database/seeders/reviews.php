<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class reviews extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void

    {
        Review::factory(10)->create();
        // DB::table('reviews')->insert([
        //     'user_id' => random_int(2, 10),
        //     'place_id' => random_int(2, 10),
        //     'rating' => random_int(1, 5),
        //     'comment' => Str::random(100),
        //     'image' => Str::random(100),

        // ]);
    }
}
