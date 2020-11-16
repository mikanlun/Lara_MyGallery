<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Album extends Model
{
    protected $guarded = ['id'];

    // 登録用のルール
    public static $rulesStore = [
        'title' => ['required', 'string', 'max:20'],
        'image' => ['required', 'file', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        'comment' => ['required', 'string', 'max:255'],
    ];

    // 更新用のルール
    public static $rulesUpdate = [
        'title' => ['required', 'string', 'max:20'],
        'image' => ['file', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        'comment' => ['required', 'string', 'max:255'],
    ];

    /**
     * リレーション
     *
     * User has many Albums
     */

     public function user()
     {
         return $this->belongsTo('App\User');
     }

    /**
    * アルバム情報取得
    *
    * @return アルバム情報取得
    */
    static public function  getAlbumsWithMessage()
    {
        $user = null;
        $caption = null;
        $comment =  null;
        $btn_label =  null;
        $register_url =  null;
        $thumbnails =  null;
        $user_cnt = 0;

        // 認証済みのユーザーか
        if (Auth::check()) {
            // 認証済みのユーザーのアルバム
            $user = Auth::user();
            $albums = self::where('user_id', $user->id)->orderBy('updated_at', 'desc')->get();
            if (!count($albums)) {
                // 認証済みのユーザーのアルバムは未登録
                $caption =  __('messages.wwllcome.caption');
                $comment =  $user->name . __('messages.wwllcome.comment');
                $btn_label = __('messages.btn_label.albumRegister');
                $register_url = '/album/create';
            } else {
                // ユーザー数（ログインユーザーのみ）
                $user_cnt = 1;
                $thumbnail['user_id'] = $user->id;
                $thumbnail['user_info'] = $albums;
                $thumbnails[] = $thumbnail;
            }

        } else {
            // 一般ユーザーのアルバム
            $albums = self::orderBy('updated_at', 'desc')->get();
            if (!count($albums)) {
                // 一般ユーザーのアルバムは未登録
                $caption =  __('messages.lucky.caption');
                $comment =  __('messages.lucky.comment');
                $btn_label = __('messages.btn_label.userRegister');
                $register_url = '/register';
            } else {
                // ユーザーごとの最新の更新日を取得
                $userInfo = [];
                $latest_user_albums = self::select('user_id', DB::raw('MAX(updated_at) as latest_updated_at'))
                                        ->groupBy('user_id')->orderBy('latest_updated_at', 'desc')->get();
                // ユーザーごとにアルバム 取得
                foreach($latest_user_albums as $row) {
                    $thumbnail['user_id'] = $row->user_id;
                    $thumbnail['user_info'] = self::where('user_id', $row->user_id)->orderBy('updated_at', 'desc')->get();
                    $thumbnails[] = $thumbnail;
                }
                // ユーザー数
                $user_cnt = count($thumbnails);
            }
        }

        return [
            'albums' => $albums,
            'thumbnails' => $thumbnails,
            'user' => $user,
            'caption' => $caption,
            'comment' =>  $comment,
            'btn_label' => $btn_label,
            'register_url' =>  $register_url,
            'user_cnt' => $user_cnt,
        ];
    }
}
