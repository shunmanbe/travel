<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $fillable = [
        'departure_date', 
        'end_date', 
        'area_name',
        'prefecture_name',
        'railRoute_name',
        'station_name'
        ];
    
    public function places()
    {
        return $this->hasMany('App\Place');
    }
    
    //protected $d_date = ['depature_date'];
    
    //protected $e_date = ['end_date'];
}
