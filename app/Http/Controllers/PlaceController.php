<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Place;
use App\Itinerary;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ItinerarySearchRequest;
use App\Http\Requests\DepartureTimeRequest;
use App\Http\Requests\ArrivalTimeRequest;

class PlaceController extends Controller
{
    use SoftDeletes;
    
    //目的地を検索
    public function destination_search(Itinerary $itinerary)
    {
        $auth = Auth::user();
        return view('/itineraries/search_destination')->with(['auth' => $auth, 'itinerary' => $itinerary]);
    }
    
    //目的地を地図表示
    public function destination_map(ItinerarySearchRequest $request, Itinerary $itinerary, Place $place)
    {
        $auth = Auth::user();
        $input_s = $request['search_name'];
        $client = new \GuzzleHttp\Client();
        //検索ワードに関連する施設の詳細情報を取得
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?key=' . config("services.google-map.apikey") . '&query=' . $input_s . '&language=ja';
        $response = $client->request('GET', $url,
        ['Bearer' => config('serveices.google-map.apikey')]);
        $itineraries = json_decode($response->getBody(), true);
        $place_addresses = [ ];
        $place_names = [ ];
        for($i = 0; $i < count($itineraries['results']); $i++)
        {
            $place_addresses[ ] = $itineraries['results'][$i]['formatted_address'];
            $place_names[ ] = $itineraries['results'][$i]['name'];
        }
        $place_details = array_map(null, $place_addresses, $place_names);
        return view('/itineraries/map_destination')->with(['auth' => $auth, 'place_details' => $place_details, 'itinerary' => $itinerary, 'place' => $place]);
    }
    
    //目的地を保存
    public function destination_store(Request $request, Itinerary $itinerary, Place $place)
    {
        $place->fill($request['destination'])->save();
        return redirect('/itineraries/'.$itinerary->id.'/edit/show');
    }
    
    //目的地を含めた詳細画面表示
    public function show(Itinerary $itinerary, Place $place) 
    {
        $auth = Auth::user();
        return view('/itineraries/edit_show')->with(['auth' => $auth, 'itinerary' => $itinerary, 'places' => $place->where('itinerary_id', $itinerary->id)->get()]);
    }
    
    //目的地を編集
    public function edit_destination(Itinerary $itinerary, Place $place)
    {
        $auth = Auth::user();
        return view('/itineraries/search_destination_edit')->with(['auth' => $auth, 'itinerary' => $itinerary, 'place' => $place]);
    }
    
    //編集時の地図表示
    public function edit_destination_map(Request $request, Itinerary $itinerary, Place $place)
    {
        $auth = Auth::user();
        $input_s = $request['search_name'];
        $client = new \GuzzleHttp\Client();
        //検索ワードに関連する施設の詳細情報を取得
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?key=' . config("services.google-map.apikey") . '&query=' . $input_s . '&language=ja';
        $response = $client->request('GET', $url,
        ['Bearer' => config('serveices.google-map.apikey')]);
        $itineraries = json_decode($response->getBody(), true);
        $place_addresses = [ ];
        $place_names = [ ];
        for($i = 0; $i < count($itineraries['results']); $i++)
        {
            $place_addresses[ ] = $itineraries['results'][$i]['formatted_address'];
            $place_names[ ] = $itineraries['results'][$i]['name'];
        }
        $place_details = array_map(null, $place_addresses, $place_names);
        return view('/itineraries/map_destination_edit')->with(['auth' => $auth, 'place_details' => $place_details, 'itinerary' => $itinerary, 'place' => $place]);
    }
    
    //編集内容を更新
    public function destination_update(Request $request, Itinerary $itinerary, Place $place)
    {
        $place->fill($request->input('destination'))->save();
        return redirect('/itineraries/'.$itinerary->id.'/edit/show');//目的地をupdate
    }
    
    //削除
    public function destination_delete(Itinerary $itinerary, Place $place)
    {
        $place->delete();
        return redirect('/itineraries/'.$itinerary->id.'/edit/show');
    }
    
    //メモ
    public function memo(Itinerary $itinerary, Place $place)
    {
        $auth = Auth::user();
        return view('itineraries/memo')->with(['auth' => $auth, 'itinerary' => $itinerary, 'place' => $place]);
    }
    
    //メモを保存
    public function memo_store(Itinerary $itinerary, Place $place, Request $request)
    {
        $input_memo = $request->input('memo');
        $place->fill($input_memo)->save();
        return redirect('/itineraries/'.$itinerary->id.'/edit/show');
    }
    
    //出発時刻を保存
    public function departure_time_store(Request $request, Itinerary $itinerary, Place $place)
    {
        $auth = Auth::user();
        $input = $request['time_d'];
        $place->fill($input)->save();
        return redirect('/itineraries/'.$itinerary->id.'/edit/show');
    }
    
    //出発時刻を編集(削除)
    public function edit_departure_time(Itinerary $itinerary, Place $place)
    {
        $place->departure_time = null;
        $place->save();
        return redirect('/itineraries/'. $itinerary->id .'/edit/show');
    }
    
     //到着時刻を保存
    public function arrival_time_store(ArrivalTimeRequest $request, Itinerary $itinerary, Place $place)
    {
        $auth = Auth::user();
        $input = $request['time_a'];
        $place->fill($input)->save();
        return redirect('/itineraries/'.$itinerary->id.'/edit/show');
    }
    
    //到着時刻を編集(削除)
    public function edit_arrival_time(Itinerary $itinerary, Place $place)
    {
        $place->arrival_time = null;
        $place->save();
        return redirect('/itineraries/'. $itinerary->id .'/edit/show');
    }
    
}