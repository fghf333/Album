<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Cloudinary;
use Cloudinary\Uploader;
use Cloudinary\Api;

class UploadController extends Controller
{

    public function func($tag)
    {

        $object = new \stdClass();
        $object->name = $tag;

        return $object;
    }

    /**
     * @param Request $request
     * @return mixed
     */
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

    /**
     * @param null $AlbumID
     * @return mixed
     */
    public function getForm($AlbumID = null)
    {

        if (!Auth::check()) {
            return abort(404);
        }

        $albums = DB::table('albums')
            ->whereIn('creator', [Auth::id(), 1])
            ->select('name', 'id')
            ->get();

        $data = [
            'albums' => $albums,
            'edit' => 0,
        ];

        if (isset($AlbumID)) {
            $data['default_album'] = (int)$AlbumID;
        }
        return view('upload', $data);
    }

    /**
     * @param null $imageID
     * @return mixed
     */
    public function getEditForm($imageID = null)
    {

        $data = DB::table('images')
            ->where('id', $imageID)
            ->first();
        $user = Auth::id();

        if (!Auth::check() || $data == null || $user != $data->{'author'}) {
            return abort(404);
        }

        $albums = DB::table('albums')
            ->whereIn('creator', [$user, 1])
            ->select('name', 'id')
            ->get();

        return view('upload', [
            'image' => $data,
            'albums' => $albums,
            'edit' => 1,
        ]);

    }

    /**
     * @param Request $request
     * @param null $ImageID
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function upload(Request $request, $ImageID = null)
    {

        $userID = Auth::id();
        $photo = $request->all();

        if ($ImageID !== null) {

            $this->validate($request, [
                'name' => 'required|max:250',
                'peoples' => 'max:250',
                'place' => 'max:250',
                'CreatedAt' => 'required|date',
            ]);

            $image = DB::table('images')
                ->where('id', '=', $ImageID)
                ->first();

            $id = $image->{'image_id'};
            $url = $image->{'image_url'};
            $preview_img_url = $image->{'preview_img_url'};

            $userData = DB::table('users')
                ->where('id', '=', $userID)
                ->first();
            Cloudinary::config([
                'cloud_name' => $userData->{'cloud_name'},
                'api_key' => $userData->{'api_key'},
                'api_secret' => $userData->{'api_secret'},
            ]);

            Uploader::explicit($id, [
                'type' => 'upload',
                'tags' => $photo['tags'],
            ]);

            Cloudinary::reset_config();

        } else {

            $this->validate($request, [
                'name' => 'required|max:250',
                'peoples' => 'max:250',
                'place' => 'max:250',
                'CreatedAt' => 'required|date',
                'file' => 'required|image|max:10000',
            ]);

            $userData = DB::table('users')
                ->where('id', '=', $userID)
                ->first();
            Cloudinary::config([
                'cloud_name' => $userData->{'cloud_name'},
                'api_key' => $userData->{'api_key'},
                'api_secret' => $userData->{'api_secret'},
            ]);

            $uploaded = Uploader::upload($request->file('file')->getRealPath(), [
                'tags' => $photo['tags'],
            ]);
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

        }

        if (isset($photo['album']) && $this->check_album($photo['album'])) {
            $album = $photo['album'];
        } else {
            $album = $photo['album'] = 1;
        }

        DB::table('images')
            ->updateOrInsert(
                [
                    'image_id' => $id,
                ],
                [
                    'name' => $photo['name'],
                    'album' => $album,
                    'image_id' => $id,
                    'image_url' => $url,
                    'preview_img_url' => $preview_img_url,
                    'peoples' => $photo['peoples'],
                    'place' => $photo['place'],
                    'updated_at' => date("Y-m-d H:i:s"),
                    'author' => $userID,
                    'createdAt' => $photo['CreatedAt'],
                ]
            );


        return redirect('images-list/' . $album, 302);
    }

    /**
     * @param $AlbumID
     * @return bool
     */
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

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    function tags()
    {

        $user = Auth::id();
        $tags = [];
        $userData = DB::table('users')
            ->where('id', '=', $user)
            ->first();

        Cloudinary::config([
            'cloud_name' => $userData->{'cloud_name'},
            'api_key' => $userData->{'api_key'},
            'api_secret' => $userData->{'api_secret'},
        ]);

        $api = new Api();
        try {
            $tags = $api->tags()['tags'];
            $tags = array_map(array($this, 'func'), $api->tags()['tags']);
        } catch (API\GeneralError $e) {
            dd($e);
        }


        Cloudinary::reset_config();

        return response($tags);

    }

    function addtags($imageID = null)
    {

        $user = Auth::id();
        $tags = [];
        $userData = DB::table('users')
            ->where('id', '=', $user)
            ->first();

        Cloudinary::config([
            'cloud_name' => $userData->{'cloud_name'},
            'api_key' => $userData->{'api_key'},
            'api_secret' => $userData->{'api_secret'},
        ]);

        $api = new Api();
        try {
            $tags = implode(',', $api->resource($imageID)['tags']);
        } catch (API\GeneralError $e) {
            dd($e);
        }

        Cloudinary::reset_config();

        return response($tags);
    }
}
