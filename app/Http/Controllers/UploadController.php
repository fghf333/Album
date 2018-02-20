<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{

    function GetImageId($filename)
    {
        $dir = '/';
        $recursive = true;
        $file = collect(Storage::cloud()->listContents($dir, $recursive))
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
            ->sortBy('timestamp')
            ->last();
        return $file['path'];
    }

    function GetImageURL($path)
    {

        return 'https://drive.google.com/uc?export=media&id=' . $path;
    }

    public function getForm($AlbumID = null)
    {
        $tags = DB::table('tags')->select('name', 'id')->get();
        $albums = DB::table('albums')->select('name', 'id')->get();
        $data = ['albums' => $albums, 'tags' => $tags, 'default_album' => 0];

        if (isset($AlbumID)) {
            $data['default_album'] = (int)$AlbumID;
        }
        return view('upload', $data);
    }

    public function upload(Request $request)
    {
        foreach ($request->file() as $file) {

            foreach ($file as $f) {
                $photo = $request->all();
                $tagsq = explode(',', $photo['tags']);
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

                //$f->move(storage_path('images'), $photo['name']);
                //Storage::cloud()->put($photo['name'], fopen(storage_path('images/') . $photo['name'], 'r+'));
                //$ID = $this->GetImageId($photo['name']);
                //$URL = $this->GetImageURL($ID);
                //Storage::cloud()->rename($ID, $ID . " ");
                //unlink(storage_path('images/' . $photo['name']));
                //Storage::disk('local')->delete($photo['name']);

                $userID = Auth::user()->getAuthIdentifier();
                $userData = DB::table('users')->where('id', '=', $userID)->first();
                \Cloudinary::config([
                    'cloud_name' => $userData->{'cloud_name'},
                    'api_key' => $userData->{'api_key'},
                    'api_secret' => $userData->{'api_secret'},
                ]);

                $uploaded = \Cloudinary\Uploader::upload($request->file('file.0')->getRealPath());
                $id = $uploaded['public_id'];
                $url = $uploaded['secure_url'];
                \Cloudinary::reset_config();

                DB::table('images')->insert(
                    [
                        'name' => $photo['name'],
                        'album' => $photo['album'],
                        'image_id' => $id,
                        'image_URL' => $url,
                        'createdAt' => $photo['CreatedAt'],
                        'tags' => $photo['tags'],
                        'peoples' => $photo['peoples'],
                        'place' => $photo['place'],
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s"),
                    ]
                );
            }
        }
        return redirect('images-list', 302);
    }
}
