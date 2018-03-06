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
       
       $oldDate = date_create($user['created_at']);
       $newDate = date_create(date('Y-m-d H:i:s'));
       $dateDiff = date_diff($oldDate, $newDate)->format('%y Лет %m Месяцев %d Дней %h Часов %i Минут %s Секунд');
       
       $data['username'] = $user['username'];
       $data['email'] = $user['email'];
       $data['since'] = $dateDiff;
       return view('profile', ['data' => $data]);
   }
}