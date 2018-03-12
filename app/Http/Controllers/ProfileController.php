<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 06.03.2018
 * Time: 21:21
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
   public function getProfile(){

       $user = Auth::user()['original'];
       
       $data['username'] = $user['username'];
       $data['email'] = $user['email'];
       return view('profile', ['data' => $data]);
   }
}