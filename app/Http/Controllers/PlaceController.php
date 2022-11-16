<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Place;
use App\Itinerary;
use Carbon\Carbon;
// use Illuminate\Support\Carbon;
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
        $input = $request['search_name'];
        $client = new \GuzzleHttp\Client();
        //検索ワードに関連する施設の詳細情報を取得
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?key=' . config("services.google-map.apikey") . '&query=' . $input . '&language=ja';
        $response = $client->request('GET', $url,
        ['Bearer' => config('serveices.google-map.apikey')]);
        // 受け取った土地に関する情報全てを$place_detailsに代入
        $place_details = json_decode($response->getBody(), true);
        // 必要情報を全地点分まとめる
        $place_detail_requireds =[];
        // 受け取った情報を一つずつに分解
        foreach($place_details['results'] as $place_detail){
            // 地名情報
            $place_name = $place_detail['name'];
            // 住所情報
            $place_address = $place_detail['formatted_address'];
            // ジオコーディングで緯度・軽度を取得
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?key=' . config('services.google-map.apikey') . '&address=' . $place_address . '&language=ja';
            $response = $client->request('GET', $url,
            ['Bearer' => config('serveices.google-map.apikey')]);
            $place_lat_lng = json_decode($response->getBody(), true);
            // 緯度情報
            $place_lat = $place_lat_lng['results'][0]['geometry']['location']['lat'];
            // 経度情報
            $place_lng = $place_lat_lng['results'][0]['geometry']['location']['lng'];
            // 地名・住所・緯度・経度情報を一つにまとめる
            $place_detail_required = [$place_name, $place_address, $place_lat, $place_lng];
            $place_detail_requireds[] =$place_detail_required;
        }
        return view('/itineraries/map_destination')->with(['auth' => $auth, 'itinerary' => $itinerary, 'place' => $place, 'place_detail_requireds' => $place_detail_requireds]);
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
        $input = $request['search_name'];
        $client = new \GuzzleHttp\Client();
        //検索ワードに関連する施設の詳細情報を取得
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?key=' . config("services.google-map.apikey") . '&query=' . $input . '&language=ja';
        $response = $client->request('GET', $url,
        ['Bearer' => config('serveices.google-map.apikey')]);
        // 受け取った土地に関する情報全てを$place_detailsに代入
        $place_details = json_decode($response->getBody(), true);
        // 必要情報を全地点分まとめる
        $place_detail_requireds =[];
        // 受け取った情報を一つずつに分解
        foreach($place_details['results'] as $place_detail){
            // 地名情報
            $place_name = $place_detail['name'];
            // 住所情報
            $place_address = $place_detail['formatted_address'];
            // ジオコーディングで緯度・軽度を取得
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?key=' . config('services.google-map.apikey') . '&address=' . $place_address . '&language=ja';
            $response = $client->request('GET', $url,
            ['Bearer' => config('serveices.google-map.apikey')]);
            $place_lat_lng = json_decode($response->getBody(), true);
            // 緯度情報
            $place_lat = $place_lat_lng['results'][0]['geometry']['location']['lat'];
            // 経度情報
            $place_lng = $place_lat_lng['results'][0]['geometry']['location']['lng'];
            // 地名・住所・緯度・経度情報を一つにまとめる
            $place_detail_required = [$place_name, $place_address, $place_lat, $place_lng];
            $place_detail_requireds[] =$place_detail_required;
        }
        return view('/itineraries/map_destination_edit')->with(['auth' => $auth, 'itinerary' => $itinerary, 'place' => $place, 'place_detail_requireds' => $place_detail_requireds]);
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
        // requestで送られてきた"departure_time"を抜き出す
        $input = $request['time']['departure_time'];
        // Carbonを使ってformatを書き換える
        $input = Carbon::parse($input)->format('Y年m月d日 H時i分');
        // 保存するために連想配列を作る
        $input_array = ['departure_time' => $input];
        // 保存する
        $place->fill($input_array)->save();
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
    public function arrival_time_store(Request $request, Itinerary $itinerary, Place $place)
    {
        // requestで送られてきた"departure_time"を抜き出す
        $input = $request['time']['arrival_time'];
        // Carbonを使ってformatを書き換える
        $input = Carbon::parse($input)->format('Y年m月d日 H時i分');
        // 保存するために連想配列を作る
        $input_array = ['arrival_time' => $input];
        // 保存する
        $place->fill($input_array)->save();
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