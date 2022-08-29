<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Itinerary;


class ItineraryController extends Controller
{
    public function index(Itinerary $itinerary)
    {
        return view('itineraries/top')->with(['itineraries' => $itinerary->get()]);
    }
    
}
