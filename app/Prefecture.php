<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prefecture extends Model
{
    protected $fillable = ['name', 'area_id'];
    
    public function area()
    {
        return $this->belongsTo('App\Area');
    }
    
    public function getByPrefectre()
    {
        //return $this
    }

    
}
