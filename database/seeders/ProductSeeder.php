<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Certificate;
use App\Models\Quality;
use App\Models\Type;
use App\Models\Unit;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();



        foreach (range(1, 100) as $index) { // Change 100 to the desired number of fake products.
            DB::table('products')->insert([
                'category_id' => Category::inRandomOrder()->first()->id, // Replace with your actual category IDs.
                'type_id' => Type::inRandomOrder()->first()->id, // Replace with your actual type IDs.
                'unit_id' => Unit::inRandomOrder()->first()->id, // Replace with your actual unit IDs.
                'vendor_id' => Vendor::inRandomOrder()->first()->id, // Replace with your actual vendor IDs.
                'certificate_id' => Certificate::inRandomOrder()->first()->id, // Replace with your actual certificate IDs.
                'quality_id' => Quality::inRandomOrder()->first()->id, // Replace with your actual quality IDs.
                'image' => $faker->imageUrl(),
                'price' => $faker->randomFloat(2, 10, 1000),
                'price_from' => $faker->randomFloat(2, 1, 10),
                'price_to' => $faker->randomFloat(2, 10, 1000),
                'quantity' => $faker->numberBetween(1, 100),
                'is_visible' => $faker->boolean,
                'status' => $faker->randomElement(['pending', 'refused', 'accepted']),
                'weight' => $faker->randomFloat(2, 0.1, 10),
                'length' => $faker->randomFloat(2, 1, 100),
                'width' => $faker->randomFloat(2, 1, 100),
                'height' => $faker->randomFloat(2, 1, 100),
                'sort_order' => $faker->numberBetween(1, 100),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        $faker = Faker::create();

        $productIds = DB::table('products')->pluck('id')->toArray();
        $languageIds = DB::table('languages')->pluck('id')->toArray();

        foreach ($productIds as $productId) {
            foreach ($languageIds as $languageId) {
                DB::table('product_translations')->insert([
                    'product_id' => $productId,
                    'language_id' => $languageId,
                    'name' => $faker->word,
                    'desc' => $faker->sentence,
                    'slug' => $faker->slug,
                ]);
            }
        }

    }
}
