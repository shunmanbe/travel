<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    public function places()
    {
        return $this->hasMany('App\Place');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function likes()
    {
        return $this->hasMany('App\Like');
    }
    
    protected $fillable = [
        'title',
        'user_id',
        'departure_date', 
        'arrival_date', 
        'departure_place_address',
        'departure_place_name',
        ];
    
    protected $dates = [
        'departure_date', 
        'arrival_date'
        ];
}
