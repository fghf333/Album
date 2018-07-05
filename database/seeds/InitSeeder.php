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
            'preview_img_id' => null,
            'shared' => 1,
            'description' => null,
            'preview_img' => null,
            'photo_num' => 0,
            'updated_at' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
