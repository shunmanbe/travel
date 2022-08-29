<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    public function detail()
    {
        return $this->belongsTo('App\Detail');
    }
}
