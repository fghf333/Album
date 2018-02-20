<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 15.11.2017
 * Time: 15:34
 */

namespace App\Http\Controllers;


use Cloudinary\Uploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class AlbumController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList()
    {
        if (Auth::check() !== false) {
            $userID = Auth::user()->getAuthIdentifier();
            $data = DB::table('albums')->where('creator', '=', $userID)->orderByRaw('created_at ASC')->get();
            return view('albums-list', ['list' => $data]);
        } else {
            return view('albums-list', ['list' => []]);
        }
    }

    public function getEditForm($AlbumID)
    {
        $data = DB::table('albums')->where('id', $AlbumID)->first();
        if (Auth::check() && Auth::user()->getAuthIdentifier() == $data->{'creator'}) {
            return view('edit-album', [
                'album' => $data,
            ]);
        } else {
            return redirect('/');
        }
    }

    public function getForm()
    {
        return view('create-album');
    }

    public function editAlbum($AlbumID, Request $request)
    {
        $form = $request->all();
        DB::table('albums')->where('id', $AlbumID)->update(
            [
                'name' => $form['name'],
                'description' => $form['description'],
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );
        return redirect()->route('edit_album', ['AlbumID' => $AlbumID]);
    }

    public function deleteAlbum(Request $request)
    {
        $data = $request->all();
        DB::table('images')->where('album', '=', $data['AlbumID'])->update(['album' => 0]);
        $album = DB::table('albums')->where('id', '=', $data['AlbumID'])->first();
        $image = $album->{'preview_img_id'};

        $userID = Auth::user()->getAuthIdentifier();
        $userData = DB::table('users')->where('id', '=', $userID)->first();
        \Cloudinary::config([
            'cloud_name' => $userData->{'cloud_name'},
            'api_key' => $userData->{'api_key'},
            'api_secret' => $userData->{'api_secret'},
        ]);
        \Cloudinary\Uploader::destroy($image, array("invalidate" => true));
        \Cloudinary::reset_config();

        DB::table('albums')->where('id', '=', $data['AlbumID'])->delete();

        return redirect('albums', 302);
    }

    public function createAlbum(Request $request)
    {
        $form = $request->all();

        $userID = Auth::user()->getAuthIdentifier();
        $userData = DB::table('users')->where('id', '=', $userID)->first();
        \Cloudinary::config([
            'cloud_name' => $userData->{'cloud_name'},
            'api_key' => $userData->{'api_key'},
            'api_secret' => $userData->{'api_secret'},
        ]);
        $uploaded = \Cloudinary\Uploader::upload($request->file('file')->getRealPath());
        $id = $uploaded['public_id'];
        $url = $uploaded['secure_url'];
        \Cloudinary::reset_config();

        DB::table('albums')->insert(
            [
                'name' => $form['name'],
                'creator' => $userID,
                'shared' => 0,
                'preview_img_id' => $id,
                'description' => $form['description'],
                'preview_img' => $url,
                'updated_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
            ]
        );
        return redirect('albums', 302);
    }

}