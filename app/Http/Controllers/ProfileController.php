<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 06.03.2018
 * Time: 21:21
 */

namespace App\Http\Controllers;


class ProfileController extends Controller
{
   public function getProfile($UserID){
       return view('profile');
   }
}