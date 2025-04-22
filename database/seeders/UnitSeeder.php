<?php

namespace Database\Seeders;

use App\Models\Type;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UnitSeeder extends Seeder
{
    public function run()
    {
        // $faker = Faker::create();



        $ar = DB::table('languages')->where('code', 'ar')->first();
//        $en = DB::table('languages')->where('code', 'en')->first();

        $first =  Unit::create([
            'sort_order' => 1, // Adjust as needed.
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('unit_translations')->insert([
            'unit_id' => $first->id,
            'language_id' => $ar->id,
            'name' => 'كيلو',
        ]);



        $second =  Unit::create([
            'sort_order' => 2, // Adjust as needed.
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('unit_translations')->insert([
            'unit_id' => $second->id,
            'language_id' => $ar->id,
            'name' => 'عبوة',
        ]);


    }
}
