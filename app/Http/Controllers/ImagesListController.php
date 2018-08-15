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
    /**
     * @param null $AlbumID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList($AlbumID = null)
    {
        $user = Auth::id();

        if(!Auth::check()){
            return view('images-list', [
                'list' => [],
                'album' => '',
            ]);
        }

        $check = DB::table('albums')
            ->where('id', '=', $AlbumID)
            ->first();

        if ($check == null && $AlbumID !== null) {
            return abort(404);
        }

        $family_id = DB::table('users')
            ->where('id', '=', Auth::user()->family_id)
            ->select('family_id')
            ->first()
            ->family_id;

        $family = DB::table('users')
            ->where('family_id', '=', $family_id)
            ->pluck('id')
            ->toArray();

        if ($AlbumID !== null) {

            $album = DB::table('albums')
                ->where('id', '=', $AlbumID)
                ->first();

            $family_id = DB::table('users')
                ->when($album->id !== 1, function ($query) use ($album) {
                    return $query->where('id', '=', $album->creator)
                        ->select('family_id')
                        ->first()
                        ->family_id;

                }, function ($query) {
                    return $query->select('family_id')
                        ->pluck('family_id')
                        ->unique()
                        ->toArray();
                });

            $family = DB::table('users')
                ->whereIn('family_id', (array)$family_id)
                ->pluck('id')
                ->toArray();

            $check = in_array($user, $family);

            if ($check || $AlbumID == 1 && Auth::check()) {
                $data = DB::table('images')
                    ->where('album', '=', $AlbumID)
                    ->whereIn('author', $family)
                    ->orderByRaw('created_at DESC')
                    ->get();

                return view('images-list', [
                    'list' => $data,
                    'album' => $album,
                ]);
            } else {
                return abort(404);
            }
        } else {
            $data = DB::table('images')
                ->orderByRaw('created_at DESC')
                ->whereIn('author', $family)
                ->get();

            return view('images-list', [
                'list' => $data,
                'album' => '',
            ]);
        }
    }
}
