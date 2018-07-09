<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 15.11.2017
 * Time: 21:57
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ImagesListController
{
    public function getList($AlbumID = null)
    {
        $user = Auth::id();

        $check = DB::table('albums')
            ->where('id', '=', $AlbumID)
            ->first();

        if ($check == null && $AlbumID !== null) {
            return abort(404);
        }

        if ($AlbumID !== null) {

            $album = DB::table('albums')
                ->where('id', '=', $AlbumID)
                ->first();

            if ($album->{'creator'} == $user || $AlbumID == 1 && Auth::check()) {
                $data = DB::table('images')
                    ->where('album', '=', $AlbumID)
                    ->where('author', '=', $user)
                    ->orderByRaw('created_at DESC')
                    ->get();

                return view('images-list', [
                    'list' => $data,
                    'AlbumID' => $AlbumID,
                    'AlbumName' => $album->{'name'},
                ]);
            } else {
                return abort(404);
            }
        } else {
            $data = DB::table('images')
                ->orderByRaw('created_at DESC')
                ->where('author', '=', $user)
                ->get();

            return view('images-list', [
                'list' => $data,
                'AlbumName' => '',
            ]);
        }
    }
}
