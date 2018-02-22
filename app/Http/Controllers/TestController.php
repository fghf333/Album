<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 30.01.2018
 * Time: 22:53
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestController
{
    public function test()
    {
        return view('vendor.notifications.email',[
            'level' => 'success',
            'introLines' => ['Hello', 'world', '!'],
            'outroLines' => ['Hello', 'human', '!'],
        ]);
    }
}