<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 06.03.2018
 * Time: 21:21
 */

namespace App\Http\Controllers;


use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function getProfile($UserID = null)
    {
        if (!Auth::guest() && Auth::id() == $UserID) {

            $user = DB::table('users')->select()->where('id', '=', $UserID)->first();

            $data['username'] = $user->{'username'};
            $data['email'] = $user->{'email'};
            return view('profile', ['data' => $data]);

        }else{
            abort(404) ;
        }


    }
}