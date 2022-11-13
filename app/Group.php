<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    
    public function shares()
    {
        return $this->hasMany('App\Itinerary');
    }
    
    protected $fillable = [
        'created_at',
        'updated_at',
        'name',
        'password',
        ];
}
