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
use Cloudinary;
use Cloudinary\Uploader;

class EditImageController extends Controller
{

    public function deleteImage(Request $request)
    {

        $userID = Auth::id();
        $image = DB::table('images')
            ->where('id', '=', $request['ImageID'])
            ->where('author', '=', $userID)
            ->first();
        if ($image !== null) {
            DB::table('images')
                ->where('id', '=', $request['ImageID'])
                ->delete();
            $filename = $image->{'image_id'};

            $userData = DB::table('users')
                ->where('id', '=', $userID)
                ->first();
            Cloudinary::config([
                'cloud_name' => $userData->{'cloud_name'},
                'api_key' => $userData->{'api_key'},
                'api_secret' => $userData->{'api_secret'},
            ]);
            Uploader::destroy($filename, array("invalidate" => true));
            Cloudinary::reset_config();

            return redirect('images-list', 302);
        } else {
            return abort(404);
        }
    }

    public function getForm($imageID)
    {

        $data = DB::table('images')
            ->where('id', $imageID)
            ->first();
        $user = Auth::id();

        if (!Auth::check() || $data == null || $user != $data->{'author'}) {
            return abort(404);
        }

        $tags = DB::table('tags')
            ->select('name')
            ->get();
        $albums = DB::table('albums')
            ->whereIn('creator', [$user, 1])
            ->select('name', 'id')
            ->get();

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
            'peoples' => 'max:250',
            'place' => 'max:250',
            'CreatedAt' => 'required|date',
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

        DB::table('images')
            ->where('id', $ImageID)
            ->update(
            [
                'name' => $form['name'],
                'album' => $form['album'],
                'createdAt' => $form['CreatedAt'],
                'tags' => $form['tags'],
                'peoples' => $form['peoples'],
                'place' => $form['place'],
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        );

        return redirect('images-list/' . $request->{'album'}, 302);
    }
}
