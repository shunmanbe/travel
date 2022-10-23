<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Place;
use App\Detail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DetailSearchRequest;
use App\Http\Requests\DepartureTimeRequest;
use App\Http\Requests\ArrivalTimeRequest;

class PlaceController extends Controller
{
    use SoftDeletes;
    
    //目的地を検索
    public function destination_search(Detail $detail)
    {
        $auth = Auth::user();
        return view('/itineraries/search_destination')->with(['auth' => $auth, 'detail' => $detail]);
    }
    
    //目的地を地図表示
    public function destination_map(DetailSearchRequest $request, Detail $detail, Place $place)
    {
        $auth = Auth::user();
        $input_s = $request['search_name'];
        $client = new \GuzzleHttp\Client();
        //検索ワードに関連する施設の詳細情報を取得
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?key=' . config("services.google-map.apikey") . '&query=' . $input_s . '&language=ja';
        $response = $client->request('GET', $url,
        ['Bearer' => config('serveices.google-map.apikey')]);
        $details = json_decode($response->getBody(), true);
        $place_addresses = [ ];
        $place_names = [ ];
        for($i = 0; $i < count($details['results']); $i++)
        {
            $place_addresses[ ] = $details['results'][$i]['formatted_address'];
            $place_names[ ] = $details['results'][$i]['name'];
        }
        $place_details = array_map(null, $place_addresses, $place_names);
        return view('/itineraries/map_destination')->with(['auth' => $auth, 'place_details' => $place_details, 'detail' => $detail, 'place' => $place]);
    }
    
    //目的地を保存
    public function destination_store(Request $request, Detail $detail, Place $place)
    {
        //dd($request['destination']);
        $place->fill($request['destination'])->save();
        return redirect('/itineraries/'.$detail->id.'/show/edit');
    }
    
    //目的地を含めた詳細画面表示
    public function show(Detail $detail, Place $place) 
    {
        $auth = Auth::user();
        return view('/itineraries/edit_show')->with(['auth' => $auth, 'detail' => $detail, 'places' => $place->where('detail_id', $detail->id)->get()]);
    }
    
    //目的地を編集
    public function edit_destination(Detail $detail, Place $place)
    {
        $auth = Auth::user();
        return view('/itineraries/search_destination_edit')->with(['auth' => $auth, 'detail' => $detail, 'place' => $place]);
    }
    
    //編集時の地図表示
    public function edit_destination_map(Request $request, Detail $detail, Place $place)
    {
        $auth = Auth::user();
        $input_s = $request['search_name'];
        $client = new \GuzzleHttp\Client();
        //検索ワードに関連する施設の詳細情報を取得
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?key=' . config("services.google-map.apikey") . '&query=' . $input_s . '&language=ja';
        $response = $client->request('GET', $url,
        ['Bearer' => config('serveices.google-map.apikey')]);
        $details = json_decode($response->getBody(), true);
        $place_addresses = [ ];
        $place_names = [ ];
        for($i = 0; $i < count($details['results']); $i++)
        {
            $place_addresses[ ] = $details['results'][$i]['formatted_address'];
            $place_names[ ] = $details['results'][$i]['name'];
        }
        $place_details = array_map(null, $place_addresses, $place_names);
        return view('/itineraries/map_destination_edit')->with(['auth' => $auth, 'place_details' => $place_details, 'detail' => $detail, 'place' => $place]);
    }
    
    //編集内容を更新
    public function destination_update(Request $request, Detail $detail, Place $place)
    {
        $place->fill($request->input('destination'))->save();
        return redirect('/itineraries/'.$detail->id.'/show/edit');//目的地をupdate
    }
    
    //削除
    public function destination_delete(Detail $detail, Place $place)
    {
        $place->delete();
        return redirect('/itineraries/'.$detail->id.'/show/edit');
    }
    
    //メモ
    public function memo(Detail $detail, Place $place)
    {
        $auth = Auth::user();
        return view('itineraries/memo')->with(['auth' => $auth, 'detail' => $detail, 'place' => $place]);
    }
    
    //メモを保存
    public function memo_store(Detail $detail, Place $place, Request $request)
    {
        $input_memo = $request->input('memo');
        $place->fill($input_memo)->save();
        return redirect('/itineraries/'.$detail->id.'/show/edit');
    }
    
    //出発時刻を保存
    public function departure_time_store(Request $request, Detail $detail, Place $place)
    {
        $auth = Auth::user();
        $input = $request['time'];
        $place->fill($input)->save();
        return redirect('/itineraries/'.$detail->id.'/show/edit');
    }
    
    //出発時刻を編集(削除)
    public function edit_departure_time(Detail $detail, Place $place)
    {
        $place->departure_time = null;
        $place->save();
        return redirect('/itineraries/'. $detail->id .'/show/edit');
    }
    
     //到着時刻を保存
    public function arrival_time_store(Request $request, Detail $detail, Place $place)
    {
        $auth = Auth::user();
        $input = $request['time'];
        $place->fill($input)->save();
        return redirect('/itineraries/'.$detail->id.'/show/edit');
    }
    
    //到着時刻を編集(削除)
    public function edit_arrival_time(Detail $detail, Place $place)
    {
        $place->arrival_time = null;
        $place->save();
        return redirect('/itineraries/'. $detail->id .'/show/edit');
    }
    
}