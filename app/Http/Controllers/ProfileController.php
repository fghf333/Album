<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 06.03.2018
 * Time: 21:21
 */

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
   public function getProfile(){
       $user = Auth::user()['original'];
       
       $oldDate = new Carbon($user['created_at']);
       $newDate = Carbon::now();
       $dateDiff = $oldDate->diffForHumans($newDate,false,false, 6);
       
       $data['username'] = $user['username'];
       $data['email'] = $user['email'];
       $data['since'] = $dateDiff;
       return view('profile', ['data' => $data]);
   }
}