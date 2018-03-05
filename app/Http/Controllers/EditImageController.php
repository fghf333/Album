<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 15.11.2017
 * Time: 20:09
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EditImageController extends Controller
{

    public function deleteImage(Request $request)
    {
        $image = DB::table('images')->where('id', '=', $request['ImageID'])->first();
        DB::table('images')->where('id', '=', $request['ImageID'])->delete();
        $filename = $image->{'image_id'};

        $userID = Auth::user()->getAuthIdentifier();
        $userData = DB::table('users')->where('id', '=', $userID)->first();
        \Cloudinary::config([
            'cloud_name' => $userData->{'cloud_name'},
            'api_key' => $userData->{'api_key'},
            'api_secret' => $userData->{'api_secret'},
        ]);
        \Cloudinary\Uploader::destroy($filename, array("invalidate" => true));
        \Cloudinary::reset_config();

        return redirect('images-list', 302);
    }

    public function getForm($imageID)
    {
        $data = DB::table('images')->where('id', $imageID)->first();
        $tags = DB::table('tags')->select('name')->get();
        $albums = DB::table('albums')->select('name', 'id')->get();

        return view('edit-image', [
            'image' => $data,
            'albums' => $albums,
            'tags' => $tags,
        ]);
    }

    public function saveForm($ImageID, Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:250',
            'peoples' => 'required|max:250',
            'place' => 'required|max:250',
            'CreatedAt' => 'required|date',
            'file.0' => 'required|image|size:81920',
        ]);

        $form = $request->all();

        if (empty($form['album'])) {
            $form['album'] = 0;
        }

        $tagsq = explode(',', $form['tags']);
        $query = '';
        $i = 0;
        foreach ($tagsq as $tag) {
            if ($i === 0) {
                $query .= '(\'' . $tag . '\',\'' . date("Y-m-d H:i:s") . '\',\'' . date("Y-m-d H:i:s") . '\')';
                $i++;
            } else {
                $query .= ',(\'' . $tag . '\',\'' . date("Y-m-d H:i:s") . '\',\'' . date("Y-m-d H:i:s") . '\')';
            }
        }

        DB::insert('INSERT IGNORE INTO tags (name, created_at, updated_at) VALUES ' . $query);

        DB::table('images')->where('id', $ImageID)->update(
            [
                'name' => $form['name'],
                'album' => $form['album'],
                'createdAt' => $form['CreatedAt'],
                'tags' => $form['tags'],
                'peoples' => $form['peoples'],
                'place' => $form['place'],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]
        );
        //return redirect('edit-image/' . $form['id'], 301);
        return redirect()->route('edit_image_form', ['imageID' => $ImageID]);
    }
}