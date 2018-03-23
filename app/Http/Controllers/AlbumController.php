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
        if (Auth::check() !== false) {
            $userID = Auth::user()->getAuthIdentifier();
            $data = DB::table('albums')->where('creator', '=', $userID)->where('id', '>', '1')->orderByRaw('created_at ASC')->get();
            return view('albums-list', ['list' => $data]);
        } else {
            return view('albums-list', ['list' => []]);
        }
    }

    public function getEditForm($AlbumID)
    {
        $data = DB::table('albums')->where('id', $AlbumID)->first();
        if($data !== null) {
            if (Auth::check() && Auth::user()->getAuthIdentifier() == $data->{'creator'}) {
                return view('edit-album', [
                    'album' => $data,
                ]);
            } else {
                return redirect('/');
            }
        }
        return abort(404);
    }

    public function getForm()
    {
        return view('create-album');
    }

    public function editAlbum($AlbumID, Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:250',
            'description' => 'max:250',
        ]);

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
        $check = DB::table('albums')->where('id', '=', $data['AlbumID'])->first();
        if($check == null){
            return abort(404);
        }
        DB::table('images')->where('album', '=', $data['AlbumID'])->update(['album' => 0]);
        $album = DB::table('albums')->where('id', '=', $data['AlbumID'])->first();
        $image = $album->{'preview_img_id'};

        $userID = Auth::user()->getAuthIdentifier();
        $userData = DB::table('users')->where('id', '=', $userID)->first();
        Cloudinary::config([
            'cloud_name' => $userData->{'cloud_name'},
            'api_key' => $userData->{'api_key'},
            'api_secret' => $userData->{'api_secret'},
        ]);
        Uploader::destroy($image, array("invalidate" => true));
        Cloudinary::reset_config();

        DB::table('albums')->where('id', '=', $data['AlbumID'])->delete();

        return redirect('albums', 302);
    }

    public function createAlbum(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:250',
            'description' => 'max:250',
            'file.0' => 'required|image|max:20440',
        ]);

        $form = $request->all();

        $userID = Auth::user()->getAuthIdentifier();
        $userData = DB::table('users')->where('id', '=', $userID)->first();
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

        DB::table('albums')->insert(
            [
                'name' => $form['name'],
                'creator' => $userID,
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