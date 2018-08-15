<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 27.03.2018
 * Time: 21:04
 */

namespace App\Http\Controllers\Family;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FamilyController
{
    public function getFamilyList($FamilyID = null)
    {

        if (!Auth::check()) {
            return abort(404);
        } else {


            $familyID = Auth::user()['family_id'];

            if ($familyID !== null) {

                if ($FamilyID == $familyID) {
                    $familyList = DB::table('users')->where('family_id', '=', $FamilyID)->select()->get();

                    return view('family.family-list', ['data' => $familyList]);

                } else {
                    return abort(404);
                }
            } else {
                return 'Здест должна быть страница создания семьи';
            }
        }
    }
}
