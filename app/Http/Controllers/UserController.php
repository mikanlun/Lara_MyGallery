<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Validator;

use App\User;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile($id)
    {
        $user = User::find($id);

        return view('user.profile', compact('user'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if (is_null($user) || (Auth::user()->id != $id)) {
            // ユーザー情報が無い時又は認可中のユーザーのIDで無い時トップページに戻る
            return redirect("/album");
        }

        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if (is_null($user) || (Auth::user()->id != $id)) {
            // ユーザー情報が無い時又は認可中のユーザーのIDで無い時トップページに戻る
            return redirect("/album");
        }

        return view('user.edit', compact('user'));
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
        $validator =Validator::make($request->all(), User::$rulesUpdate);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        // メールアドレス
        $newEmail = $request->email;
        if ($newEmail == Auth::user()->email) {
            // 変更なし
            $email = Auth::user()->email;
        } else {
            // 変更あり
            if (User::where('email', $newEmail)->first()) {
                // 使用済み
                $validator->errors()->add('email', $newEmail .  __('messages.email.exists'));

            } else {

                $email = $newEmail;
            }
        }

        // パスワード
        $newPassword = $request->password;

        if (is_null($newPassword)) {
            // 変更なし
            $password = Auth::user()->password;

        } else {
            // 変更あり
            if (strlen($newPassword) < 8) {
                $validator->errors()->add('password', __('messages.password.min'));

            } else {
                $password = Hash::make($newPassword);
            }
        }

        // バリデーション
        if (count($validator->errors())) {

            return back()->withInput()->withErrors($validator);
        }

        // 新ユーザー情報保存
        $newUser = [
            'name' => $request->name,
            'email' => $email,
            'password' => $password,
            'profile' => $request->profile,
        ];

        $user = User::find($id);
        $user->fill($newUser)->save();

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
        // ユーザー情報を取得
        $user_id = Auth::user()->id;
        $user_name = Auth::user()->name;
        // 画像パス生成
        $path = 'images' . sprintf('%04d', $user_id);
        // アップロードファイルの既存チェック
        foreach(Storage::directories('public') as $dir) {

            if ($dir === 'public/' . $path) {
                // 既存のアップロードファイルを削除
                Storage::deleteDirectory('public/' . $path);
            }
        }
        // ユーザー情報を削除
        User::find($user_id)->delete();
        Auth::logout();

        return view('user.destroy', compact('user_name'));

    }

}
