<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\GroupPlace;
use App\ShareItinerary;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ItinerarySearchRequest;
use App\Http\Requests\DepartureTimeRequest;
use App\Http\Requests\ArrivalTimeRequest;

class GroupPlaceController extends Controller
{
    use SoftDeletes;
    
    //目的地を検索
    public function destination_search(Group $group, ShareItinerary $shareItinerary)
    {
        $auth = Auth::user();
        return view('/itineraries/group/search_destination')->with(['auth' => $auth, 'group' => $group, 'shareItinerary' => $shareItinerary]);
    }
    
    //目的地を地図表示
    public function destination_map(ItinerarySearchRequest $request, Group $group, ShareItinerary $shareItinerary, GroupPlace $groupPlace)
    {
        $auth = Auth::user();
        $input = $request['search_name'];
        $client = new \GuzzleHttp\Client();
        //検索ワードに関連する施設の詳細情報を取得
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?key=' . config("services.google-map.apikey") . '&query=' . $input . '&language=ja';
        $response = $client->request('GET', $url,
        ['Bearer' => config('serveices.google-map.apikey')]);
        // 受け取った土地に関する情報全てを$groupPlace_detailsに代入
        $groupPlace_details = json_decode($response->getBody(), true);
        // 必要情報を全地点分まとめる
        $groupPlace_detail_requireds =[];
        // 受け取った情報を一つずつに分解
        foreach($groupPlace_details['results'] as $groupPlace_detail){
            // 地名情報
            $groupPlace_name = $groupPlace_detail['name'];
            // 住所情報
            $groupPlace_address = $groupPlace_detail['formatted_address'];
            // ジオコーディングで緯度・軽度を取得
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?key=' . config('services.google-map.apikey') . '&address=' . $groupPlace_address . '&language=ja';
            $response = $client->request('GET', $url,
            ['Bearer' => config('serveices.google-map.apikey')]);
            $groupPlace_lat_lng = json_decode($response->getBody(), true);
            // 緯度情報
            $groupPlace_lat = $groupPlace_lat_lng['results'][0]['geometry']['location']['lat'];
            // 経度情報
            $groupPlace_lng = $groupPlace_lat_lng['results'][0]['geometry']['location']['lng'];
            // 地名・住所・緯度・経度情報を一つにまとめる
            $groupPlace_detail_required = [$groupPlace_name, $groupPlace_address, $groupPlace_lat, $groupPlace_lng];
            $groupPlace_detail_requireds[] =$groupPlace_detail_required;
        }
        return view('/itineraries/group/map_destination')->with(['auth' => $auth, 'group' => $group, 'shareItinerary' => $shareItinerary, 'groupPlace' => $groupPlace, 'place_detail_requireds' => $groupPlace_detail_requireds]);
    }
    
    //目的地を保存
    public function destination_store(Request $request, Group $group, ShareItinerary $shareItinerary, GroupPlace $groupPlace)
    {
        $groupPlace->fill($request['destination'])->save();
        return redirect()->route('group.edit_show', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id]);
    }
    
    //目的地を含めた詳細画面表示
    public function show(Group $group, ShareItinerary $shareItinerary, GroupPlace $groupPlace) 
    {
        $auth = Auth::user();
        return view('/itineraries/group/edit_show')->with(['auth' => $auth, 'group' => $group, 'shareItinerary' => $shareItinerary, 'places' => $groupPlace->where('itinerary_id', $itinerary->id)->get()]);
    }
    
    //目的地を編集
    public function edit_destination(Group $group, ShareItinerary $shareItinerary, GroupPlace $groupPlace)
    {
        $auth = Auth::user();
        return view('/itineraries/group/search_destination_edit')->with(['auth' => $auth, 'group' => $group, 'shareItinerary' => $shareItinerary, 'groupPlace' => $groupPlace]);
    }
    
    //編集時の地図表示
    public function edit_destination_map(Request $request, Group $group, ShareItinerary $shareItinerary, GroupPlace $groupPlace)
    {
        $auth = Auth::user();
        $input = $request['search_name'];
        $client = new \GuzzleHttp\Client();
        //検索ワードに関連する施設の詳細情報を取得
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?key=' . config("services.google-map.apikey") . '&query=' . $input . '&language=ja';
        $response = $client->request('GET', $url,
        ['Bearer' => config('serveices.google-map.apikey')]);
        // 受け取った土地に関する情報全てを$groupPlace_detailsに代入
        $groupPlace_details = json_decode($response->getBody(), true);
        // 必要情報を全地点分まとめる
        $groupPlace_detail_requireds =[];
        // 受け取った情報を一つずつに分解
        foreach($groupPlace_details['results'] as $groupPlace_detail){
            // 地名情報
            $groupPlace_name = $groupPlace_detail['name'];
            // 住所情報
            $groupPlace_address = $groupPlace_detail['formatted_address'];
            // ジオコーディングで緯度・軽度を取得
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?key=' . config('services.google-map.apikey') . '&address=' . $groupPlace_address . '&language=ja';
            $response = $client->request('GET', $url,
            ['Bearer' => config('serveices.google-map.apikey')]);
            $groupPlace_lat_lng = json_decode($response->getBody(), true);
            // 緯度情報
            $groupPlace_lat = $groupPlace_lat_lng['results'][0]['geometry']['location']['lat'];
            // 経度情報
            $groupPlace_lng = $groupPlace_lat_lng['results'][0]['geometry']['location']['lng'];
            // 地名・住所・緯度・経度情報を一つにまとめる
            $groupPlace_detail_required = [$groupPlace_name, $groupPlace_address, $groupPlace_lat, $groupPlace_lng];
            $groupPlace_detail_requireds[] =$groupPlace_detail_required;
        }
        return view('/itineraries/group/map_destination_edit')->with(['auth' => $auth, 'group' => $group, 'shareItinerary' => $shareItinerary, 'groupPlace' => $groupPlace, 'place_detail_requireds' => $groupPlace_detail_requireds]);
    }
    
    //編集内容を更新
    public function destination_update(Request $request, Group $group, ShareItinerary $shareItinerary, GroupPlace $groupPlace)
    {
        $groupPlace->fill($request->input('destination'))->save();
        return redirect()->route('group.edit_show', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id]);
    }
    
    //削除
    public function destination_delete(Group $group, ShareItinerary $shareItinerary, GroupPlace $groupPlace)
    {
        $groupPlace->delete();
        return redirect()->route('group.edit_show', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id]);
    }
    
    //メモ
    public function memo(Group $group, ShareItinerary $shareItinerary, GroupPlace $groupPlace)
    {
        $auth = Auth::user();
        return view('itineraries/group/memo')->with(['auth' => $auth, 'group' => $group, 'shareItinerary' => $shareItinerary, 'groupPlace' => $groupPlace]);
    }
    
    //メモを保存
    public function memo_store(Group $group, ShareItinerary $shareItinerary, GroupPlace $groupPlace, Request $request)
    {
        $input_memo = $request->input('memo');
        $groupPlace->fill($input_memo)->save();
        return redirect()->route('group.edit_show', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id]);
    }
    
    //出発時刻を保存
    public function departure_time_store(Request $request, Group $group, ShareItinerary $shareItinerary, GroupPlace $groupPlace)
    {
        $auth = Auth::user();
        $input = $request['time_d'];
        $groupPlace->fill($input)->save();
        return redirect()->route('group.edit_show', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id]);
    }
    
    //出発時刻を編集(削除)
    public function edit_departure_time(Group $group, ShareItinerary $shareItinerary, GroupPlace $groupPlace)
    {
        $groupPlace->departure_time = null;
        $groupPlace->save();
        return redirect()->route('group.edit_show', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id]);
    }
    
     //到着時刻を保存
    public function arrival_time_store(ArrivalTimeRequest $request, Group $group, ShareItinerary $shareItinerary, GroupPlace $groupPlace)
    {
        $auth = Auth::user();
        $input = $request['time_a'];
        $groupPlace->fill($input)->save();
        return redirect()->route('group.edit_show', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id]);
    }
    
    //到着時刻を編集(削除)
    public function edit_arrival_time(Group $group, ShareItinerary $shareItinerary, GroupPlace $groupPlace)
    {
        $groupPlace->arrival_time = null;
        $groupPlace->save();
        return redirect()->route('group.edit_show', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id]);
    }
}
