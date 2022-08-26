<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItineraryController extends Controller
{
    public function index(Itineraries $itinerary)
    {
        return view('itinerary/top')->with(['itineraries' => $itinerary->get()]);
    }
}
