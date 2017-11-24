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
        $tags = DB::table('tags')->select('name', 'id')->get();
        $albums = DB::table('albums')->select('name', 'id')->get();
        $ImageTags = DB::table('tags')->select('id','name')->whereIn('id', explode(',', $data->{'tags'}))->get();

        return view('edit-image', [
            'image' => $data,
            'albums' => $albums,
            'tags' => $tags,
            'ImageTags' => $ImageTags,

        ]);
    }

    //TODO: ability to update image with another one
    //TODO: implement tags with autocomplite and creating
    public function saveForm($ImageID, Request $request)
    {
        $form = $request->all();
        DB::table('images')->where('id', $ImageID)->update(
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
        //return redirect('edit-image/' . $form['id'], 301);
        return redirect()->route('edit_form', ['imageID' => $ImageID]);
    }
}