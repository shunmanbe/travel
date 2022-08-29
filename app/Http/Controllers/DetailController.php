<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detail;

class DetailController extends Controller
{
     public function show(Detail $detail)
    {
        return view('itineraries/show')->with(['detail' => $detail]);
    }

}
