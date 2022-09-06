<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    //エリアに属する都道府県を取得
    public function prefectures()
    {
        return $this->hasMany('App\Prefecture');
    }
    
    protected $fillable = ['name'];
}
