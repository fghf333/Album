<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 10.01.2018
 * Time: 19:16
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');
    }

    function getHome()
    {
        $images = DB::table('images')->latest()->take(12)->get();

         return view('welcome', [
            'images' => $images,
        ]);

    }
}