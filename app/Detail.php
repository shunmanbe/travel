<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $fillable = [
        'date[depature_date]', 
        'date[end_date]', 
        ];
    
    public function places()
    {
        return $this->hasMany('App\Place');
    }
    
    //protected $d_date = ['depature_date'];
    
    //protected $e_date = ['end_date'];
}
