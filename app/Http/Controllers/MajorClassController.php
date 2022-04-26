<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhoto;
use App\Models\Majorclass;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Comment;
use App\Http\Requests\StoreComment;

use Illuminate\Support\Facades\Log;

class MajorClassController extends Controller
{
    /**
     * 大分類　一覧
     */
    public function index()
    {
//        LOG::debug('');

        $majorclasses = Majorclass::all();


        return $majorclasses;
    }
}
