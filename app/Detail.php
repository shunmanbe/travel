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
        'departure_place_address',
        'departure_place_name',
        'first_destination_address',
        'first_destination_name',
        'second_destination_address',
        'second_destination_name',
        'third_destination_address',
        'third_destination_name',
        ];
    
    protected $dates = ['departure_date', 'end_date'];
    
    
   
    
    //protected $d_date = ['depature_date'];
    
    //protected $e_date = ['end_date'];
}
