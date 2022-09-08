<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $fillable = [
        'date[depature_year]', 
        'date[depature_month]', 
        'date[depature_day]', 
        'date[end_year]', 
        'date[end_month]', 
        'date[end_day]'
        ];
    
    public function places()
    {
        return $this->hasMany('App\Place');
    }
}
