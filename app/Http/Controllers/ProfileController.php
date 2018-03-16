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

class ProfileController extends Controller
{
    public function getProfile($UserID = null)
    {
        if (Auth::guest() && Auth::id() !== $UserID) {
            abort(404);
        }

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
}