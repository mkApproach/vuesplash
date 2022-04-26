<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhoto;
use App\Models\Middleclass;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Comment;
use App\Http\Requests\StoreComment;

use Illuminate\Support\Facades\Log;

class MiddleClassController extends Controller
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