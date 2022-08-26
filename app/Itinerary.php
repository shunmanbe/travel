<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
     public function index(Itineraries $itinerary)
    {
        return view('itinerary/top')->with(['itineraries' => $itinerary->get()]);
    }
}
