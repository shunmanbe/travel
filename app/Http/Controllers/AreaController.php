<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Area;


class AreaController extends Controller
{
    public function select(Area $area)
    {
        return view('itineraries/new_entry_area')->with(['areas' => $area->get()]);
    }
    
}
