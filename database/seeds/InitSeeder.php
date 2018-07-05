<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('albums')->insert([
            'id' => 1,
            'name' => 'Неотсортированное',
            'creator' => 1,
            'preview_img_id' => NULL,
            'shared' => 1,
            'description' => NULL,
            'preview_img' => NULL,
            'photo_num' => 0,
            'updated_at' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('users')->insert([
            'id' => 1,
            'username' => 'Mock',
            'first_name' => 'Mock',
            'last_name' => 'Mackovsky',
            'family_id' => '0',
            'email' => 'example@domain.com',
            'password' => '1',
            'api_key' => '1',
            'api_secret' => '1',
            'cloud_name' => 'placeholder',
            'updated_at' => '2018-02-22 12:18:14',
            'created_at' => '2018-02-22 12:18:15',
            'family_admin' => 0,
        ]);
    }
}
