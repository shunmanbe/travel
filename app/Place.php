<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Datetime;

class Place extends Model
{
    public function itinerary()
    {
        return $this->belongsTo('App\Itinerary');
    }
    
    protected $fillable = [
        'itinerary_id',
        'name',
        'address',
        'lat',
        'lng',
        'departure_time',
        'arrival_time', 
        'transportation',
        'memo',
        ];
    
}
