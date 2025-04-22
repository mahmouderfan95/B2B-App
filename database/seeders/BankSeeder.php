<?php

namespace Database\Seeders;

use App\Models\Bank;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $faker = Faker::create();



        $ar = DB::table('languages')->where('code', 'ar')->first();
        $first =  Bank::create([
//            'sort_order' => 1, // Adjust as needed.
            'created_at' => now(),
            'updated_at' => now(),
            'image' => 'images/no-image.png'
        ]);
        DB::table('bank_translations')->insert([
            'bank_id' => $first->id,
            'language_id' => $ar->id,
            'name' => 'البنك الاهلى',
        ]);
    }
}
