<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactsSendmail;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ContactRequest;

class ContactsController extends Controller
{
    public function form(User $user)
    {
        $auth = Auth::user();
        // 入力ページを表示
        return view('itineraries/contact/form')->with(['auth' => $auth]);
    }
    
    public function confirm(User $user, ContactRequest $request)
    {
        $auth = Auth::user();
        // フォームからの入力値を全て取得
        $inputs = $request->all();
    
        // 確認ページに表示
        // 入力値を引数に渡す
        return view('itineraries/contact/confirm')->with(['auth' => $auth,'inputs' => $inputs]);
    }
    
    public function send(User $user, Request $request)
    {
        $auth = Auth::user();
    
        // actionの値を取得
        $action = $request->input('action');
    
        // action以外のinputの値を取得
        $inputs = $request->except('action');
    
        //actionの値で分岐
        if($action !== 'submit'){
    
            // 戻るボタンの場合リダイレクト処理
            return redirect('/itineraries/contact/form')->withInput($inputs);
            
        } else {
            // 送信ボタンの場合、送信処理
    
            // ユーザにメールを送信
            \Mail::to($inputs['email'])->send(new ContactsSendmail($inputs));
            // 自分にメールを送信
            \Mail::to('travel.itinerary.service@gmail.com')->send(new ContactsSendmail($inputs));
    
            // 二重送信対策のためトークンを再発行
            $request->session()->regenerateToken();
    
            // 送信完了ページのviewを表示
            return view('itineraries/contact/thanks')->with(['auth' => $auth]);
    
        }
    }
}
