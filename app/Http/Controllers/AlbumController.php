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
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList()
    {
        $data = DB::table('albums')->orderByRaw('created_at DESC')->get();
        return view('albumsList', ['list' => $data]);
    }

    public function createAlbum()
    {

    }

}