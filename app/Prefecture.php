<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prefecture extends Model
{
    public function area()
    {
        return $this->belongsTo('App\Area');
    }

    protected $fillable = ['name', 'area_id'];
}
