<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 15.11.2017
 * Time: 20:09
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditImageController
{
    public function getForm($imageID)
    {
        $data = DB::table('images')->where('id', $imageID)->first();
        return view('edit-image', ['image' => $data]);
    }

    //TODO: ability to update image with another one
    public function saveForm(Request $request)
    {
        $form = $request->all();
        DB::table('images')->where('id', $form['id'])->update(
            [
                'name' => $form['name'],
                'album' => $form['album'],
                'createdAt' => $form['CreatedAt'],
                'tags' => $form['tags'],
                'peoples' => $form['peoples'],
                'place' => $form['place'],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]
        );
        return redirect('edit-image/' . $form['id'], 301);
    }
}