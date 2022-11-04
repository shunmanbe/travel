<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    public function detail()
    {
        return $this->belongsTo('App\Detail');
    }
    
    protected $fillable = [
        'itinerary_id',
        'name',
        'address',
        'lat',
        'lng',
        'departure_time',
        'arrival_time', 
        'memo',
        ];
    
    // protected $dates = [
    //     'departure_time', 
    //     'arrival_time',
    //     ];
    
    
}
