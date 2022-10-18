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
        'detail_id',
        'destination_address',
        'destination_name',
        'departure_time',
        'arrival_time', 
        'memo',
        ];
}
