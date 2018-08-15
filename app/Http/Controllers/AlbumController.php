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
use Cloudinary;

class AlbumController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList()
    {
        if (Auth::check()) {
            $family = DB::table('users')
                ->where('family_id', '=', Auth::user()->family_id)
                ->pluck('id')
                ->toArray();

            $data = DB::table('albums')
                ->whereIn('creator', $family)
                ->where('id', '>', '1')
                ->orderByRaw('created_at ASC')
                ->get();

            return view('albums-list', ['list' => $data]);

        } else {
            return view('albums-list');
        }


    }

    /**
     * @param $AlbumID
     * @return mixed
     */
    public function getEditForm($AlbumID)
    {
        $data = DB::table('albums')
            ->where('id', $AlbumID)
            ->where('creator', '=', Auth::id())
            ->first();
        if ($data !== null) {
                return view('edit-album', [
                    'album' => $data,
                ]);
        }
        return abort(404);
    }

    /**
     * @return mixed
     */
    public function getForm()
    {
        if (Auth::check()) {
            return view('create-album');
        } else {
            return abort(404);
        }
    }

    /**
     * @param $AlbumID
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editAlbum($AlbumID, Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:250',
            'description' => 'max:250',
        ]);

        $form = $request->all();
        DB::table('albums')
            ->where('id', $AlbumID)
            ->update(
                [
                    'name' => $form['name'],
                    'description' => $form['description'],
                    'updated_at' => date("Y-m-d H:i:s"),
                ]
            );
        return redirect()->route('albums_list');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function deleteAlbum(Request $request)
    {
        $data = $request->all();
        $check = DB::table('albums')
            ->where('id', '=', $data['AlbumID'])
            ->where('creator', '=', Auth::id())
            ->first();

        if ($check === null) {
            return abort(404);
        }
        DB::table('images')
            ->where('album', '=', $data['AlbumID'])
            ->update(['album' => 1]);
        $album = DB::table('albums')
            ->where('id', '=', $data['AlbumID'])
            ->first();
        $image = $album->{'preview_img_id'};

        $userData = DB::table('users')
            ->where('id', '=', Auth::id())
            ->first();
        Cloudinary::config([
            'cloud_name' => $userData->{'cloud_name'},
            'api_key' => $userData->{'api_key'},
            'api_secret' => $userData->{'api_secret'},
        ]);
        Uploader::destroy($image, array("invalidate" => true));
        Cloudinary::reset_config();

        DB::table('albums')
            ->where('id', '=', $data['AlbumID'])
            ->delete();

        return redirect('albums', 302);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createAlbum(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:250',
            'description' => 'max:250',
            'file' => 'required|image|max:20440',
        ]);

        $form = $request->all();

        $userData = DB::table('users')
            ->where('id', '=', Auth::id())
            ->first();
        Cloudinary::config([
            'cloud_name' => $userData->{'cloud_name'},
            'api_key' => $userData->{'api_key'},
            'api_secret' => $userData->{'api_secret'},
        ]);

        $uploaded = Uploader::upload($request->file('file')->getRealPath());
        $id = $uploaded['public_id'];

        $options = [
            'transformation' => [
                'height' => '220',
                'width' => '255',
                'crop' => 'fill',
            ]
        ];
        $preview_img_url = Cloudinary::cloudinary_url($id, $options);

        Cloudinary::reset_config();

        DB::table('albums')
            ->insert(
                [
                    'name' => $form['name'],
                    'creator' => Auth::id(),
                    'shared' => 0,
                    'preview_img_id' => $id,
                    'description' => $form['description'],
                    'preview_img' => $preview_img_url,
                    'updated_at' => date("Y-m-d H:i:s"),
                    'created_at' => date("Y-m-d H:i:s"),
                ]
            );
        return redirect('albums', 302);
    }

}
