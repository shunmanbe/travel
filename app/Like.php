<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
     //いいねしているユーザー
    public function user()
    {
        return $this->belongsTo('App\User');
    }

     //いいねしている投稿
    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    //いいねが既にされているかを確認
    public function like_exist($user_id, $detail_id)
    {
        /*
　　　　 Likesテーブルのレコードにユーザーidと投稿idが一致するものを取得。
　　　　 引数に与えられたユーザーidと投稿idの組み合わせのレコードが存在するなら、「投稿にはすでにいいねが押されている」ことがわかる。
　　　　 逆に、一致するレコードがなければ、「まだ投稿にいいねがされていない」ということがわかる。
　　　　*/
        $exist = Like::where('user_id', '=', $user_id)->where('detail_id', '=', $detail_id)->get();

        // レコード（$exist）が存在するときtrueを返す
        if (!$exist->isEmpty()) {
            return true;
        } else {
        // レコード（$exist）が存在しないときfalseを返す
            return false;
        }
    }
}
