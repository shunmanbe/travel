<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    public function places()
    {
        return $this->hasMany('App\Place');
    }
}
