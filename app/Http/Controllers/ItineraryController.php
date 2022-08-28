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
    
    public function show(Detail $detail)
    {
        return view('itineraries/show')->with(['details' => $detail->get()]);
    }
}
