<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
     public function places()
    {
        return $this->hasMany('App\Place');
    }
    
    protected $fillable = [
        'departure_date', 
        'end_date', 
        'area_name',
        'prefecture_name',
        'railRoute_name',
        'station_name'
        ];
    
    protected $dates = ['departure_date', 'end_date'];
    
    
   
    
    //protected $d_date = ['depature_date'];
    
    //protected $e_date = ['end_date'];
}
