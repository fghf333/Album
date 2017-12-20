<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 15.11.2017
 * Time: 15:34
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
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
        $data = DB::table('albums')->orderByRaw('created_at DESC')->get();
        return view('albumsList', ['list' => $data]);
    }

    public function getForm()
    {
        return view('createAlbum');
    }

    public function createAlbum(Request $request)
    {
        $form = $request->all();
        Storage::disk('public_uploads')->putFileAs('images/albums', new File($request->file('preview')->getRealPath()), $form['name'].'.png');

        DB::table('albums')->insert(
            [
                'name' => $form['name'],
                'description' => $form['description'],
                'preview_img' => $form['name'].'.png',
                'updated_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
            ]
        );
        return redirect('albums', 302);
    }

}