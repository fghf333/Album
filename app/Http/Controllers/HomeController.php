<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 10.01.2018
 * Time: 19:16
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController
{
    function getHome()
    {
        $images = DB::table('images')->latest()->take(25)->get();

        return view('welcome', [
            'images' => $images,
        ]);

    }
}