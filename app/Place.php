<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Datetime;

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
    
    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
        ];
    
    
}
