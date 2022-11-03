<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    public function places()
    {
        return $this->hasMany('App\Place');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function likes()
    {
        return $this->hasMany('App\Like');
    }
    
    //いいねされているかを判定するメソッド
    public function isLikedBy($user): bool 
    {
        //user_idの値がuserのidを同じもののうち、itinerary_idがlikeのidを同じものの最初の値を取ってくる。その値が空(null)であれば、false。空でなければtrue。
        return Like::where('user_id', $user->id)->where('itinerary_id', $this->id)->first() !==null;
    }
    
    protected $fillable = [
        'title',
        'user_id',
        'departure_date', 
        'arrival_date', 
        'departure_place_name',
        'departure_place_address',
        'departure_place_lat',
        'departure_place_lng',
        ];
    
    protected $dates = [
        'departure_date', 
        'arrival_date',
        ];
}
