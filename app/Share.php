<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    public function group()
    {
        return $this->belongsTo('App\Group');
    }
    
    protected $fillable = [
        'group_id',
        'title',
        'departure_date', 
        'arrival_date', 
        'departure_place_name',
        'departure_place_address',
        'departure_place_lat',
        'departure_place_lng',
        'explanation',
    ];
    
    protected $dates = [
        'departure_date', 
        'arrival_date',
    ];
}