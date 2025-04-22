<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ar = DB::table('languages')->where('code', 'ar')->first();
        $data =  Contact::create([
            'phone' => '01022458766',
            'email' => 'info@email.com',
            'work_time' =>  '10:00 to 6:00',
            'facebook_link' => 'www.facebook.com',
            'instagram_link' => 'www.instagram.com',
            'twitter_link' => 'www.twitter.com',
            'whatsapp_link' => 'www.whatsapp.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $dataTrans = DB::table('contact_translations')->insert([
            'contact_id' => $data->id,
            'language_id' => $ar->id,
            'address' => 'new address',
        ]);
    }
}
