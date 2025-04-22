<?php

namespace Database\Seeders;

use App\Models\Quality;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CertificateSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();



        $ar = DB::table('languages')->where('code', 'ar')->first();
//        $en = DB::table('languages')->where('code', 'en')->first();

        $first =  Quality::create([
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('quality_translations')->insert([
            'quality_id' => $first->id,
            'language_id' => $ar->id,
            'name' => 'ممتاز',
        ]);



        $second =  Quality::create([
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('quality_translations')->insert([
            'quality_id' => $second->id,
            'language_id' => $ar->id,
            'name' => 'جيد',
        ]);


    }
}
