<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhoto;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Comment;
use App\Http\Requests\StoreComment;

use Illuminate\Support\Facades\Log;

class PhotoController extends Controller
{
    public function __construct()
    {
        // 認証が必要
        $this->middleware('auth')->except(['index', 'download', 'show']);
    }

    /**
     * 写真投稿
     * @param StorePhoto $request
     * @return \Illuminate\Http\Response
     */
    public function create(StorePhoto $request)
    {
        $file_name = $request->fphoto;

        LOG::debug('create');
        LOG::debug($file_name);
        LOG::debug($request);
    
        // 投稿写真の拡張子を取得する
        $extension = $request->photo->extension();

        $photo = new Photo();

        // インスタンス生成時に割り振られたランダムなID値と
        // 本来の拡張子を組み合わせてファイル名とする
        $photo->filename = $file_name;
        $photo->major_id = $request->majorid;
        $photo->middle_id = $request->middleid;
        $photo->subcategory_id = $request->subcategoryid;
        $photo->productname_j = $request->jphoto;
        $photo->price = $request->price;
   
        // storage/app/public配下に保存する
        //Storage::putFileAs('photos', $photo->filename, 'public');
        $request->photo->storeAs('photos', $photo->filename, 'public');

        // データベースエラー時にファイル削除を行うため
        // トランザクションを利用する
        DB::beginTransaction();

        try {
            Auth::user()->photos()->save($photo);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            // DBとの不整合を避けるためアップロードしたファイルを削除
            Storage::disk()->delete($photo->filename);
            throw $exception;
        }

        // リソースの新規作成なので
        // レスポンスコードは201(CREATED)を返却する
        return response($photo, 201);
    }

    /**
     * 写真一覧
     */
    public function index()
    {
        $major_id = $_GET['major_id'];
        $middle_id = $_GET['middle_id'];
        $subcategory_id = $_GET['subcategory_id'];

        LOG::debug('写真検索');
        LOG::debug($major_id);
        LOG::debug($middle_id);
        LOG::debug($subcategory_id);

        if ($major_id != '*') {
            if ($middle_id != '*') {
                if ($subcategory_id != '*') {                        // 全て選択
                    $photos = Photo::with(['owner', 'likes'])
                    ->where('major_id', $major_id)
                    ->where('middle_id', $middle_id)
                    ->where('subcategory_id', $subcategory_id)
                    ->orderBy(Photo::CREATED_AT, 'desc')->paginate();   
                } else {                                            // 大分類・中分類
                    $photos = Photo::with(['owner', 'likes'])
                    ->where('major_id', $major_id)
                    ->where('middle_id', $middle_id)
                    ->orderBy(Photo::CREATED_AT, 'desc')->paginate();  
                } 
            }  else {                                               // 大分類
                $photos = Photo::with(['owner', 'likes'])->where('major_id', $major_id)
                ->orderBy(Photo::CREATED_AT, 'desc')->paginate();   
            } 
        } else {
            $photos = Photo::with(['owner', 'likes'])
            ->orderBy(Photo::CREATED_AT, 'desc')->paginate();    
        }
  
        return $photos;
    }

    /**
    * 写真ダウンロード
    * @param Photo $photo
    * @return \Illuminate\Http\Response
    */
    public function download(Photo $photo)
    {
        // 写真の存在チェック
        //if (! Storage::exists($photo->filename)) {
        //    abort(404);
        //}
    //???    LOG::debug("downloadに来てますよ！");
    
        $filePath = '/public/photos/' . $photo->filename;
        $mimeType = Storage::mimeType($filePath);
        $disposition = 'attachment; filename="' . $photo->filename . '"';
        $headers = [
            'Content-Type' => $mimeType,
            'Content-Disposition' => $disposition,
        ];
  //      return abort(404);
        return Storage::download($filePath, $photo->filename, $headers);
    }

    /**
    * 写真詳細
    * @param string $id
    * @return Photo
    */
    public function show(string $id)
    {
        $photo = Photo::where('id', $id)
        ->with(['owner', 'comments.author', 'likes'])->first();

        return $photo ?? abort(404);
    }

    /**
     * コメント投稿
     * @param Photo $photo
     * @param StoreComment $request
     * @return \Illuminate\Http\Response
     */
    public function addComment(Photo $photo, StoreComment $request)
    {
        $comment = new Comment();
        $comment->content = $request->get('content');
        $comment->user_id = Auth::user()->id;
        $photo->comments()->save($comment);

        // authorリレーションをロードするためにコメントを取得しなおす
        $new_comment = Comment::where('id', $comment->id)->with('author')->first();

        return response($new_comment, 201);
    }

    /**
    * いいね
    * @param string $id
    * @return array
    */
    public function like(string $id)
    {
//        LOG::debug("likeに来てますよ！");
    
        $photo = Photo::where('id', $id)->with('likes')->first();

        if (! $photo) {
            abort(404);
        }

        $photo->likes()->detach(Auth::user()->id);
        $photo->likes()->attach(Auth::user()->id);

        return ["photo_id" => $id];
    }

    /**
    * いいね解除
    * @param string $id
    * @return array
    */
    public function unlike(string $id)
    {
        $photo = Photo::where('id', $id)->with('likes')->first();

        if (! $photo) {
            abort(404);
        }

        $photo->likes()->detach(Auth::user()->id);

        return ["photo_id" => $id];
    }

    /**
    * 写真　削除
    * @param string $id
    * @return Photo
    */
    public function remove(string $id)
    {
//        LOG::debug("deleteに来てますよ！");

        $photo = Photo::where('id', $id)->with('likes')->first();

        // データベースエラー時にファイル削除を行うため
        // トランザクションを利用する
        DB::beginTransaction();

        try {
            Photo::where('id', $id)->delete();
            Storage::disk()->delete($photo->filename);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    
        return $id;
 
    }
}