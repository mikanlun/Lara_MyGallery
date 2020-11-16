<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use Validator;
use App\Mail\ContactMail;

class SupportController extends Controller
{
    /**
     * My Galleryとは？
     *
     * @return \Illuminate\Http\Response
     */
    public function about()
    {
        return view('support.about');
    }

    /**
     * お問い合わせ
     *
     * @return \Illuminate\Http\Response
     */
    public function contact()
    {
        // 確認画面からの戻りか
        if (session()->exists('contacts')) {
            // 確認画面からの戻り、入力内容を取得
            $contacts = session('contacts');
            session()->forget('contacts');
        } else {
            // 初期画面
            if (Auth::check()) {
                // 認可中
                $name = Auth::user()->name;
                $email = Auth::user()->email;
            } else {
                // 未認可
                $name = '';
                $email = '';
            }
            $contact = '';
            $contacts = compact('name', 'email', 'contact');
        }

        return view('support.contact', $contacts);
    }

    /**
     * お問い合わせ(確認)
     *
     * @return \Illuminate\Http\Response
     */
    public function contact_confirm(Request $request)
    {
        // バリデーション
        $validator =Validator::make($request->all(),  [
            'name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'email', 'max:255', 'confirmed'],
            'contact' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        $contacts = [
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
        ];
        session(['contacts' => $contacts]);

        return view('support.contact_confirm', $contacts);
    }

    /**
     * お問い合わせ(送信)
     *
     * @return \Illuminate\Http\Response
     */
    public function contact_commit(Request $request)
    {
        if (!is_null(session('contacts'))) {
            $contacts = session('contacts');
            session()->forget('contacts');

        } else {

            return redirect('/support/contact');
        }

        Mail::to($contacts['email'])->send(new ContactMail($contacts));

        $name = $contacts['name'];
        return view('support.contact_commit', compact('name'));
    }
}
