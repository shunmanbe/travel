<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detail;
use App\Place;
use Carbon\Carbon;

class DetailController extends Controller
{
     public function show(Detail $detail)
    {
        return view('itineraries/show')->with(['detail' => $detail]);
    }
    
    public function new_entry_date()
    {
        return view('itineraries/new_entry_date');
    }
    
    public function store(Request $request, Detail $detail)
    {
        $input = $request['date'];
        $detail->fill($input)->save();
        return redirect('/itineraries/new_entry_area');
        
    }

}
