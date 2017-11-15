<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 15.11.2017
 * Time: 15:34
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;

class AlbumController
{

public function getList () {
    $data = DB::table('albums')->get();
    return view('albums', ['list' => $data]);
}

}