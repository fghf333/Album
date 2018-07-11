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
    /**
     * @param null $UserID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProfile($UserID = null)
    {

        $user = Auth::id();

        if (!Auth::check() || $user != $UserID) {
            return abort(404);
        }

        $userData = DB::table('users')
            ->where('id', '=', $user)
            ->first();

        $data['username'] = $userData->{'username'};
        $data['email'] = $userData->{'email'};
        return view('profile', [
            'data' => $data,
            'tab' => 'default',
        ]);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
        ]);

        $new_Password = Hash::make($request->get('password'));
        DB::table('users')
            ->where('id', '=', Auth::id())
            ->update(['password' => $new_Password]);

        $data = $this->getProfile(Auth::id());

        return view('profile', [
            'data' => $data->{'data'},
            'tab' => 'password',
            'message' => 'Пароль успешно изменен',
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws Api\GeneralError
     */
    public function charts()
    {
        $userData = DB::table('users')
            ->where('id', '=', Auth::id())
            ->first();

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

    /**
     * @param $bytes
     * @param int $precision
     * @return string
     */
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
