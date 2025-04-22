<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Categoryseeder;
use App\Models\Vendor;
use App\Models\SubVendor;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {



//         \App\Models\User::factory(10)->create();
//          $this->call(Categoryseeder::class);
//          $this->call(TypeSeeder::class);
//          $this->call(UnitSeeder::class);
//          $this->call(QualitySeeder::class);
//          $this->call(ProductSeeder::class);
//
//
//
//         Vendor::factory()->create();
//
//         if (Vendor::count()) {
//             foreach (Vendor::all() as $vendor) {
//                 SubVendor::factory(4)->create([
//                     "vendor_id" => $vendor['id']
//                 ]);
//             }
//         }
        $this->call(CountrySeeder::class);
        $this->call(BankSeeder::class);
        $this->call(RoleAndPermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ContactSeeder::class);
        $this->call(Categoryseeder::class);
        $this->call(TypeSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(QualitySeeder::class);
//        $this->call(VendorSeeder::class);
//        $this->call(ProductSeeder::class);

    }
}
