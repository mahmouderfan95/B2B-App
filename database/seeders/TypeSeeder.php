<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Type;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TypeSeeder extends Seeder
{
    public function run()
    {
        // $faker = Faker::create();



        $ar = DB::table('languages')->where('code', 'ar')->first();
//        $en = DB::table('languages')->where('code', 'en')->first();

        $first =  Type::create([
            'sort_order' => 1, // Adjust as needed.
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('type_translations')->insert([
            'type_id' => $first->id,
            'language_id' => $ar->id,
            'name' => 'طبيعى',
        ]);



        $second =  Type::create([
            'sort_order' => 2, // Adjust as needed.
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('type_translations')->insert([
            'type_id' => $second->id,
            'language_id' => $ar->id,
            'name' => 'غير طبيعى',
        ]);

    }
}
