<?php

namespace Database\Seeders;

use App\Models\Country;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $faker = Faker::create();



        $ar = DB::table('languages')->where('code', 'ar')->first();
        $first =  Country::create([
//            'sort_order' => 1, // Adjust as needed.
            'code' => 'sa',
            'created_at' => now(),
            'updated_at' => now(),
            'flag' => 'images/no-image.png'
        ]);
        DB::table('country_translations')->insert([
            'country_id' => $first->id,
            'language_id' => $ar->id,
            'name' => 'المملكة العربية السعودية',
        ]);
    }
}
