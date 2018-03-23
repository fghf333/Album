<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 15.11.2017
 * Time: 21:57
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ImagesListController
{
    public function getList($AlbumID = null)
    {
        $check = DB::table('albums')->where('id', '=', $AlbumID)->first();
        if($check == null && $AlbumID !== null){
            return abort(404);
        }
        if ($AlbumID !== null) {
            $data = DB::table('images')->where('album', '=', $AlbumID)->orderByRaw('created_at DESC')->get();
            $AlbumName = DB::table('albums')->where('id', '=', $AlbumID)->select('name')->first();

            return view('images-list', [
                'list' => $data,
                'AlbumID' => $AlbumID,
                'AlbumName' => $AlbumName,
            ]);
        } else {
            $data = DB::table('images')->orderByRaw('created_at DESC')->get();

            return view('images-list', [
                'list' => $data,
                'AlbumName' => '',
            ]);
        }
    }
}