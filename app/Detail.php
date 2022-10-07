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
        'title',
        'departure_date', 
        'end_date', 
        'departure_place_address',
        'departure_place_name',
        ];
    
    protected $dates = ['departure_date', 'end_date'];
    
    
   
    
    //protected $d_date = ['depature_date'];
    
    //protected $e_date = ['end_date'];
}
