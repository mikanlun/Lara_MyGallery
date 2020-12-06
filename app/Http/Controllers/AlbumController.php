<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;

use App\Album;
use App\User;

class AlbumController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only('create', 'store', 'edit', 'update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // アルバム情報取得
        $albums = Album::getAlbumsWithMessage();

        return view('album.index', $albums);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('album.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // バリデーション
        $validator =Validator::make($request->all(), Album::$rulesStore);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        // ユーザー情報を取得
        $user_id = Auth::user()->id;
        // 画像パス生成
        $path = 'images' . sprintf('%04d', $user_id);

        // アップロードファイルの存在チェック
        $file_name = $request->file('image')->getClientOriginalName();
        if (Storage::disk('public')->exists($path . '/' . $file_name)) {
            $validator->errors()->add('image', $file_name . __('messages.file.exists'));

            return back()->withInput()->withErrors($validator);

        }

        // アップロードファイルを保存
        $request->file('image')->storeAs('public/' . $path . '/' ,$file_name);
        $form = $request->all();
        unset($form['_token']);
        $form['user_id'] = $user_id;
        $form['path'] = $path;
        $form['image'] = $file_name;
        // アルバムインスタンス生成
        $album = new Album;
        $album->fill($form)->save();

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // アルバム情報を取得
        $album = Album::find($id);
        // ユーザー情報を取得
        $user = User::find($album->user_id);

        return view('album.show', compact('album', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // アルバム情報を取得
        $album = Album::find($id);

        return view('album.edit', compact('album'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // バリデーション
        $validator =Validator::make($request->all(), Album::$rulesUpdate);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        // アルバム情報を取得
        $album = Album::find($id);
        // ユーザー情報を取得
        $user_id = Auth::user()->id;
        // 画像パス生成
        $path = 'images' . sprintf('%04d', $user_id);
        // 既存のアップロードファイル名を取得
        $now_image = $album->image;

        // アップロードファイルを選択したか
        if (!is_null($request->file('image'))) {
            // アップロードファイルを選択
            // アップロードファイルの既存チェック
            $file_name = $request->file('image')->getClientOriginalName();
            if (Storage::disk('public')->exists($path . '/' . $file_name)) {
                $validator->errors()->add('image', $file_name .  __('messages.file.exists'));

                return back()->withInput()->withErrors($validator);

            }

            // 既存のアップロードファイルを削除
            if (Storage::disk('public')->exists($path . '/' . $now_image)) {
                Storage::delete('public/' . $path . "/" . $now_image);
            }

            // アップロードファイルを更新
            $request->file('image')->storeAs('public/' . $path . '/' ,$file_name);

        } else {
            // アップロードファイルを未選択
            $file_name = $now_image;
        }
        $form = $request->all();
        unset($form['_token']);
        $form['user_id'] = $user_id;
        $form['path'] = $path;
        $form['image'] = $file_name;
        $album->fill($form)->save();

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // アルバム情報を取得
        $album = Album::find($id);
        // 画像パス取得
        $path = $album->path;
        // 既存のアップロードファイル名を取得
        $now_image = $album->image;
        // 既存のアップロードファイルを削除
        if (Storage::disk('public')->exists($path . '/' . $now_image)) {
            Storage::delete('public/' . $path . "/" . $now_image);
        }

        // アルバム情報を削除
        Album::destroy($id);

        return redirect('/');
    }
}
