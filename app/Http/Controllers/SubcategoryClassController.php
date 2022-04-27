<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Subcategoryclass;

use Illuminate\Support\Facades\Log;

class SubcategoryclassController extends Controller
{
    /**
     *  小分類　一覧
    **/
    public function index(string $id, string $subid)
    {
    /*    LOG::debug('SubcategoryClassController::index');
        LOG::debug($id);
        LOG::debug($subid);*/

        $subcategoryclasses = Subcategoryclass::where('major_id', $id)->where('middle_id', $subid)->get();


        return $subcategoryclasses;
    }
}
