<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

class Users extends Model
{
    public function likes()
    {
        return $this->hasMany('App\Like');
    }
    
    public function groups()
    {
        // 呼び出すDBのモデル, 中間テーブル, 自モデルの主キー, 呼び出すモデルの主キー
        return $this->belongsToMany('App\Group', 'group_user', 'user_id', 'group_id')->withTimestamps();
    }
    
    public function belongsToGroup($user_id)
    {
        return$this->belongsToMany('App\Group')->wherePivot('user_id', $user_id);
    }
    
}