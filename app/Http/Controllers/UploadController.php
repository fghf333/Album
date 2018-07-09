<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Cloudinary;
use Cloudinary\Uploader;

class UploadController extends Controller
{

    public function getForm($AlbumID = null)
    {
        if (!Auth::check()) {
            return abort(404);
        }

        $tags = DB::table('tags')
            ->select('name', 'id')
            ->get();
        $albums = DB::table('albums')
            ->whereIn('creator', [Auth::id(), 1])
            ->select('name', 'id')
            ->get();

        $data = [
            'albums' => $albums,
            'tags' => $tags,
        ];

        if (isset($AlbumID)) {
            $data['default_album'] = (int)$AlbumID;
        }
        return view('upload', $data);
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:250',
            'peoples' => 'max:250',
            'place' => 'max:250',
            'CreatedAt' => 'required|date',
            'file' => 'required|image|max:10000',
        ]);

        $photo = $request->all();

        $tagsq = explode(',', $photo['tags']);
        foreach ($tagsq as $tag) {
            DB::table('tags')
                ->updateOrInsert([
                    'name',
                    'created_at',
                    'updated_at',
                ],
                    [
                        $tag,
                        date("Y-m-d H:i:s"),
                        date("Y-m-d H:i:s"),

                    ]);
        }
        $userID = Auth::id();
        $userData = DB::table('users')
            ->where('id', '=', $userID)
            ->first();
        Cloudinary::config([
            'cloud_name' => $userData->{'cloud_name'},
            'api_key' => $userData->{'api_key'},
            'api_secret' => $userData->{'api_secret'},
        ]);

        $uploaded = Uploader::upload($request->file('file')->getRealPath());
        $id = $uploaded['public_id'];
        $url = $uploaded['secure_url'];

        $options = [
            'transformation' => [
                'height' => '185',
                'width' => '255',
                'crop' => 'fill',
            ]
        ];
        $preview_img_url = Cloudinary::cloudinary_url($id, $options);

        Cloudinary::reset_config();

        if (isset($photo['album']) && $this->check_album($photo['album'])) {
            $album = $photo['album'];
        } else {
            $album = $photo['album'] = 1;
        }

        DB::table('images')
            ->insert(
                [
                    'name' => $photo['name'],
                    'album' => $album,
                    'image_id' => $id,
                    'image_url' => $url,
                    'preview_img_url' => $preview_img_url,
                    'createdAt' => $photo['CreatedAt'],
                    'tags' => $photo['tags'],
                    'peoples' => $photo['peoples'],
                    'place' => $photo['place'],
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'author' => $userID,
                ]
            );


        return redirect('images-list/' . $album, 302);
    }

    function check_album($AlbumID)
    {
        $albums = DB::table('albums')
            ->whereIn('creator', [Auth::id(), 1])
            ->select('id')
            ->get()
            ->toArray();

        $check = array_filter($albums, function ($e) use ($AlbumID) {
            return $e->id == $AlbumID;
        });

        if (!empty($check)) {
            return true;
        } else {
            return false;
        }
    }
}
