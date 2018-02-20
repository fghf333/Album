<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 15.11.2017
 * Time: 15:34
 */

namespace App\Http\Controllers;


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
        $userID = Auth::user()->getAuthIdentifier();
        $data = DB::table('albums')->where('creator', '=', $userID)->orderByRaw('created_at ASC')->get();
        return view('albums-list', ['list' => $data]);
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
        $image = $album->{'preview_img'};
        Storage::disk('public_uploads')->delete('/images/albums/' . $image);
        DB::table('albums')->where('id', '=', $data['AlbumID'])->delete();

        return redirect('albums', 302);
    }

    public function createAlbum(Request $request)
    {
        $userID = Auth::user()->getAuthIdentifier();
        $form = $request->all();
        Storage::disk('public_uploads')->putFileAs('images/albums', new File($request->file('file')->getRealPath()),
            $form['name'] . '.png');

        DB::table('albums')->insert(
            [
                'name' => $form['name'],
                'creator' => $userID,
                'description' => $form['description'],
                'preview_img' => $form['name'] . '.png',
                'updated_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
            ]
        );
        return redirect('albums', 302);
    }

}