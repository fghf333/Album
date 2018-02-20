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
    }
}
