<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function getForm()
    {

        $tags = DB::table('tags')->select('name', 'id')->get();
        $albums = DB::table('albums')->select('name', 'id')->get();
        return view('upload', [
            'albums' => $albums,
            'tags' => $tags,
        ]);
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

                $f->move(storage_path('images'), $photo['name']);
                Storage::cloud()->put($photo['name'], fopen(storage_path('images/') . $photo['name'], 'r+'));
                $ID = $this->GetImageId($photo['name']);
                $URL = $this->GetImageURL($ID);
                unlink(storage_path('images/' . $photo['name']));
                //Storage::disk('local')->delete($photo['name']);
                DB::table('images')->insert(
                    [
                        'name' => $photo['name'],
                        'album' => $photo['album'],
                        'image_id' => $ID,
                        'image_URL' => $URL,
                        'createdAt' => $photo['CreatedAt'],
                        'tags' => $photo['tags'],
                        'peoples' => $photo['peoples'],
                        'place' => $photo['place'],
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    ]
                );
            }
        }
        return redirect('upload');
    }
}
