<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupPlace extends Model
{
    public function shareItinerary()
    {
        return $this->belongsTo('App\ShareItinerary');
    }
    
    protected $fillable = [
        'share_itinerary_id',
        'name',
        'address',
        'lat',
        'lng',
        'departure_time',
        'arrival_time', 
        'memo',
        ];
    
    // protected $casts = [
    //     'departure_time' => 'datetime',
    //     'arrival_time' => 'datetime',
    //     ];
}
