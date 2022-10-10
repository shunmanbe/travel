<?php

use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
    }
    
    public function index()
    {
        $url = "http://express.heartrails.com/api/json?method=getLines";
        $method = "GET";
        
        $client = new Client();
        $response = $client->request($method, $url);
        
        $railroutes = json_decode($response->getBody(), true);
        dd($railroutes);
        return view('new_entry_railroute')->with(['railroutes' => $railroutes['railroutes']    
        ]);
        
    }
}
