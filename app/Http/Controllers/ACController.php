<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 09/08/2018
 * Time: 15:27
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ACController
{
    function post(Request $request){
        $file = json_encode($request->all());
        \File::put('file.json', $file);
        return 'done';
    }

    function get(){
       return \File::get('file.json');
    }
}
