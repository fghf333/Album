<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 06.03.2018
 * Time: 21:21
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Cloudinary;
use Cloudinary\Api;

class ProfileController extends Controller
{
    public function getProfile($UserID = null)
    {
        if (Auth::guest() && Auth::id() !== $UserID) {
            abort(404);
        }

        $userID = Auth::user()->getAuthIdentifier();
        $userData = DB::table('users')->where('id', '=', $userID)->first();

        $user = DB::table('users')->select()->where('id', '=', $UserID)->first();

        $data['Имя пользователя'] = $user->{'username'};
        $data['Имейл'] = $user->{'email'};
        return view('profile', [
            'data' => $data,
            'tab' => 'default',
        ]);

    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
        ]);

        $new_Password = Hash::make($request->get('password'));
        DB::table('users')->where('id', '=', Auth::id())->update(['password' => $new_Password]);

        $data = $this->getProfile(Auth::id());

        return view('profile', [
            'data' => $data->{'data'},
            'tab' => 'password',
            'message' => 'Пароль успешно изменен',
        ]);
    }

    public function charts()
    {
        $userData = DB::table('users')->where('id', '=', Auth::id())->first();

        Cloudinary::config([
            'cloud_name' => $userData->{'cloud_name'},
            'api_key' => $userData->{'api_key'},
            'api_secret' => $userData->{'api_secret'},
        ]);

        $api = new Api();
        $usage = $api->usage();

        $transformations = $usage['transformations'];
        $images = $usage['objects'];
        $storage = $usage['storage'];
        $storage['human_usage'] = $this->FBytes($storage['usage']);
        $storage['human_limit'] = $this->FBytes($storage['limit']);
        $bandwidth = $usage['bandwidth'];
        $bandwidth['human_usage'] = $this->FBytes($bandwidth['usage']);
        $bandwidth['human_limit'] = $this->FBytes($bandwidth['limit']);
        return response()->json([
            'transformations' => $transformations,
            'images' => $images,
            'storage' => $storage,
            'bandwidth' => $bandwidth,
        ]);
    }

    function FBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}