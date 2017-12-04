<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 15.11.2017
 * Time: 21:57
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ImagesListController
{
    //TODO: create delete image button
    public function getList()
    {
        $edit = storage_path('images/edit.png');
        $data = DB::table('images')->orderByRaw('created_at DESC')->get();
        return view('images-list', [
            'list' => $data,
            'edit' => $edit,

        ]);
    }
}