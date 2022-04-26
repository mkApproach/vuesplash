<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage; // ★追加
use Illuminate\Support\Facades\Auth; // ★ 追記

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'filename',       
        'major_id',           // 大分類id
        'middle_id',          // 中分類ID
        'subcategory_id',     // 小分類ID
        'productname_j',      // 商品名（日本語）
        'price' => 0,        // 価格 -2147483647 〜 2147483647 まで
    ];

    /** プライマリキーの型 */
    protected $keyType = 'string';

    /** JSONに含める属性 */
    protected $visible = [
        'id', 'owner', 'url', 'comments', 'likes_count', 'liked_by_user',
    ];

    /** JSONに含める属性 */
    protected $appends = [
        'url', 'likes_count', 'liked_by_user',
    ];

    /** 1ページあたりのアイテム数 */
    protected $perPage = 15;
    
    /** IDの桁数 */
    const ID_LENGTH = 12;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (! Arr::get($this->attributes, 'id')) {
            $this->setId();
        }
    }

    /**
     * ランダムなID値をid属性に代入する
     */
    private function setId()
    {
        $this->attributes['id'] = $this->getRandomId();
    }

    /**
     * ランダムなID値を生成する
     * @return string
     */
    private function getRandomId()
    {
        $characters = array_merge(
            range(0, 9), range('a', 'z'),
            range('A', 'Z'), ['-', '_']
        );

        $length = count($characters);

        $id = "";

        for ($i = 0; $i < self::ID_LENGTH; $i++) {
            $id .= $characters[random_int(0, $length - 1)];
        }

        return $id;
    }

    
    /**
     * アクセサ - url
     * @return string
     */
    public function getUrlAttribute()
    {
        return Storage::url('photos/' . $this->attributes['filename']); // ★変更
    }

    /**
     * アクセサ - likes_count
     * @return int
     */
    public function getLikesCountAttribute()
    {
        return $this->likes->count();
    }

    /**
     * アクセサ - liked_by_user
     * @return boolean
     */
    public function getLikedByUserAttribute()
    {
        if (Auth::guest()) {
            return false;
        }

        return $this->likes->contains(function ($user) {
            return $user->id === Auth::user()->id;
        });
    }


    /**
     * リレーションシップ - usersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id', 'users');
    }
    
    /**
    * リレーションシップ - commentsテーブル
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment')->orderBy('id', 'desc');
    }

    /**
    * リレーションシップ - usersテーブル
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function likes()
    {
        return $this->belongsToMany('App\Models\User', 'likes')->withTimestamps();
    }

}
