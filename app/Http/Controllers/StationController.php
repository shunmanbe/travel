<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class StationController extends Controller
{
    public function index()
    {
        $url = "http://express.heartrails.com/api/json?method=getLines";
        $method = "GET";
        
        $client = new Client();
        $response = $client->request($method, $url);
        
        $stations = json_decode($posts, true);
        return view('new_entry_station')->with([
            'stations' => $stations['stations']    
        ]);
        dd($stations);
    }
}
