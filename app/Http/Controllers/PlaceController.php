<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Place;
use App\Detail;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaceController extends Controller
{
    use SoftDeletes;
    
    public function destination_search(Detail $detail)
    {
        return view('/itineraries/search_destination')->with(['detail' => $detail]);
    }
    
    
    public function destination_map(Request $request, Detail $detail, Place $place)
    {
        $input_s = $request['search_name'];
        $client = new \GuzzleHttp\Client();
        //検索ワードに関連する施設の詳細情報を取得
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?key=' . config("services.google-map.apikey") . '&query=' . $input_s . '&language=ja';
        $response = $client->request('GET', $url,
        ['Bearer' => config('serveices.google-map.apikey')]);
        $details = json_decode($response->getBody(), true);
        $place_addresses = [ ];
        $place_names = [ ];
        //$places = array( );
        for($i = 0; $i < count($details['results']); $i++){
            $place_addresses[ ] = $details['results'][$i]['formatted_address'];
            $place_names[ ] = $details['results'][$i]['name'];
            //$places[ $details['results'][$i]['place_id'] ] = $details['results'][$i]['name'];
        }
        $place_details = array_map(null, $place_addresses, $place_names);
        return view('/itineraries/select_destination')->with(['place_details' => $place_details, 'detail' => $detail, 'place' => $place]);
    }
    
    public function destination_store(Request $request, Detail $detail, Place $place)
    {
        $place->fill($request['destination'])->save();
        return redirect('/itineraries/'.$detail->id.'/show/'.$place->id);//目的地を保存
    }
    
    public function show(Detail $detail, Place $place) //目的地を含めた詳細画面表示
    {
        
        return view('/itineraries/show')->with(['detail' => $detail, 'places' => $place->where('detail_id', $detail->id)->get()]);
    }
    
    public function edit(Detail $detail, Place $place)
    {
        return view('/itineraries/search_destination_edit')->with(['detail' => $detail, 'place' => $place]);
    }
    
    public function edit_departure_place_map(Request $request, Detail $detail, Place $place)
    {
        $input_s = $request['search_name'];
        $client = new \GuzzleHttp\Client();
        //検索ワードに関連する施設の詳細情報を取得
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?key=' . config("services.google-map.apikey") . '&query=' . $input_s . '&language=ja';
        $response = $client->request('GET', $url,
        ['Bearer' => config('serveices.google-map.apikey')]);
        $details = json_decode($response->getBody(), true);
        $place_addresses = [ ];
        $place_names = [ ];
        //$places = array( );
        for($i = 0; $i < count($details['results']); $i++){
            $place_addresses[ ] = $details['results'][$i]['formatted_address'];
            $place_names[ ] = $details['results'][$i]['name'];
            //$places[ $details['results'][$i]['place_id'] ] = $details['results'][$i]['name'];
        }
        $place_details = array_map(null, $place_addresses, $place_names);
        return view('/itineraries/select_destination_edit')->with(['place_details' => $place_details, 'detail' => $detail, 'place' => $place]);
    }
    
    public function update(Request $request, Detail $detail, Place $place)
    {
        $place->fill($request['destination'])->save();
        return redirect('/itineraries/'.$detail->id.'/show/'.$place->id);//目的地をupdate
    }
    
    public function delete(Place $place)
    {
        $place->delete();
        return redirect('/');
    }
    
}
