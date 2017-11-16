<?php
/**
 * Created by PhpStorm.
 * User: yaroslavgraboveckiy
 * Date: 15.11.2017
 * Time: 15:34
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use \Illuminate\Database\Query\Builder;

class AlbumController
{
    /**
     * @var Builder
     */
    private $table;

    /**
     * AlbumController constructor.
     */
    public function __construct()
    {
        $this->table = DB::table('albums');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList()
    {
        $data = $this->table->get();
        return view('albums', ['list' => $data]);
    }

}