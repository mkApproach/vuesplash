<?php

namespace App\Http\Controllers;

use App\Models\Middleclass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

class MiddleclassController extends Controller
{
     /**
     * 中分類　一覧
     */
    public function index(string $id)
    {
    //    LOG::debug('MiddleClassController::index');
    //    LOG::debug($id);

    //    $middleclasses = Middleclass::all();
        $middleclasses = Middleclass::where('major_id', $id)->get();


        return $middleclasses;
    }

}
