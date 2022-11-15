<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function users()
    {
        // 中間テーブルのcreated_at、updated_atタイムスタンプを自動的に保守したい場合は、withTimestampsメソッドをリレーション定義に付ける
        return $this->belongsToMany('App\User', 'group_user', 'group_id', 'user_id')->withTimestamps(); 
    }
    
    public function shareItineraries()
    {
        return $this->hasMany('App\ShareItinerary');
    }
    
    protected $fillable = [
        'created_at',
        'updated_at',
        'group_id',
        'name',
        'password',
        ];
}
