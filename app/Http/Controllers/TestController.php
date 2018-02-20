<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 30.01.2018
 * Time: 22:53
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestController
{
    public function test()
    {
        return view('test');
    }

    public function upload(Request $request)
    {
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

      return '<img src="'.$url.'"></img>';
    }
}