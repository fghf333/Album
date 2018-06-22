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
            'username' => 'Mr.Gnef',
            'first_name' => 'Yaroslav',
            'last_name' => 'Graboveckiy',
            'family_id' => '1',
            'email' => 'Mr.Gnef@yandex.ru',
            'password' => '$2y$10$C5mqWstwIDD8DTb.uyJDH.ZuzRrPn0PZb9fLCBgFztJTQiSuQAVcu',
            'api_key' => '887936878151233',
            'api_secret' => 'V6a3OmoPCXKXRRLDqncYJq1QIao',
            'cloud_name' => 'happy-moments',
            'updated_at' => '2018-02-22 12:18:14',
            'created_at' => '2018-02-22 12:18:15',
            'family_admin' => 1,
        ]);
    }
}
