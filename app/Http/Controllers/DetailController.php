<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detail;
use App\Place;
use Carbon\Carbon;
use App\Area;
use App\Prefecture;
use GuzzleHttp\Client;


class DetailController extends Controller
{
     public function index(Detail $detail, Place $place)
    {
        return view('itineraries/top')->with(['details' => $detail->get(), 'place' => $place]);
    }
    
    
    public function date_select()
    {
        return view('itineraries/new_entry_date');
    }
    
    public function date_store(Request $request, Detail $detail)//日付を保存
    {
        $input_date = $request['initial_setting'];
        $detail->fill($input_date)->save();
        return redirect('/itineraries/'.$detail->id.'/departure_place_search');//地域選択画面を表示するweb.phpへ
    }
    
    public function departure_place_serach(Detail $detail)
    {
        return view('/itineraries/search_departure_place')->with(['detail' => $detail]);
    }
    
    public function departure_place_map(Request $request, Detail $detail)
    {
        $input_s = $request['search_name'];
        $client = new \GuzzleHttp\Client();
        //検索ワードに関連する施設の詳細情報を取得
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?key=' . config("services.google-map.apikey") . '&query=' . $input_s . '&language=ja';
        
        
        //$url = 'https://maps.googleapis.com/maps/api/place/details/json?key=' . config("services.google-map.apikey") . '&q=' . $input_s;
        $response = $client->request('GET', $url,
        ['Bearer' => config('serveices.google-map.apikey')]);
        $details_get = json_decode($response->getBody(), true);
        $place_ids = [ ];
        $place_names = [ ];
        //$places = array( );
        for($i = 0; $i < count($details_get['results']); $i++){
            $place_ids[ ] = $details_get['results'][$i]['formatted_address'];
            $place_names[ ] = $details_get['results'][$i]['name'];
            //$places[ $details['results'][$i]['place_id'] ] = $details['results'][$i]['name'];
        }
        $place_details = array_map(null, $place_ids, $place_names);
        return view('/itineraries/select_departure_place')->with(['detail' => $detail,'place_details' => $place_details]);
    }
    
    public function departure_place_store(Request $request, Place $place, Detail $detail)
    {
        $input_departure = $request['departure'];
        $detail->fill($input_departure)->save();
        //return redirect('/itineraries/'.$detail->id.'/decided_only_departure_place');//出発地を保存
        return redirect('/itineraries/'.$detail->id.'/show');
    }
    
    public function show(Detail $detail, Place $place) //詳細画面表示
    {
        return view('/itineraries/show')->with(['detail' => $detail, 'places' => $place->where('detail_id', $detail->id)->get()]);
    }
    
    // public function departure_place_store(Request $request, Detail $detail)
    // {
    //     $input_departure = $request['departure'];
    //     $detail->fill($input_departure)->save();
    //     return redirect('/itineraries/'.$detail->id.'/decided_only_departure_place');//出発地を保存
    // }
    
    
    
    
    
    
    
    
    
    
    public function decide_first_destination(Detail $detail, Place $place) //出発地が決定した状態で詳細画面表示
    {
        return view('/itineraries/decided_only_departure_place')->with(['detail' => $detail, 'place' => $place]);
    }
    
    public function first_destination_store(Request $request, Detail $detail)
    {
        $input_first = $request['first'];
        $detail->fill($input_first)->save();
        return redirect('/itineraries/'.$detail->id.'/decided_first_destination');//出発地を保存
    }
    
    
    
    
    public function decide_second_destination(Detail $detail) //目的地1までが決定した状態で詳細画面表示
    {
        return view('/itineraries//decided_first_destination')->with(['detail' => $detail]);
    }
    
    public function second_destination_store(Request $request, Detail $detail)
    {
        $input_second = $request['second'];
        $detail->fill($input_second)->save();
        return redirect('/itineraries/'.$detail->id.'/decided_second_destination');//出発地を保存
    }
    
    public function decide_third_destination(Detail $detail) //出発地2までが決定した状態で詳細画面表示
    {
        return view('/itineraries//decided_second_destination')->with(['detail' => $detail]);
    }
    
    public function third_destination_store(Request $request, Detail $detail)
    {
        $input_third = $request['third'];
        $detail->fill($input_third)->save();
        return redirect('/itineraries/'.$detail->id.'/decided_third_destination');//出発地を保存
    }
    
    public function decided_all(Detail $detail) //出発地3までが決定した状態で詳細画面表示
    {
        return view('/itineraries//decided_all_places')->with(['detail' => $detail]);
    }
    
    
    
    
    public function route_to_first_destination(Request $request, Detail $detail, Place $place)
    {
        $client = new \GuzzleHttp\Client();
        //検索ワードに関連する施設の詳細情報を取得
        $url = 'https://maps.googleapis.com/maps/api/directions/json?origin='. $place->departure_place_address .'&destination='. $place->first_destination_address .'&key=' . config("services.google-map.apikey");
        $response = $client->request('GET', $url,
        ['Bearer' => config('serveices.google-map.apikey')]);
        $details = json_decode($response->getBody(), true);
        return view('/itineraries/route_to_first_destination_map')->with(['detail' => $detail]);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function area_select(Area $area, Detail $detail)
    {
        return view('itineraries/new_entry_area')->with(['areas'=>$area->get(), 'detail'=>$detail]);//地域選択画面を表示
    }
    
    
    public function area_store(Request $request, Detail $detail)//出発地域を保存
    {
        $input_a = $request->area;
        $detail->fill($input_a)->save();
        return redirect('/itineraries/new_entry/'.$detail->id.'/prefecture');//都道府県選択画面を表示するweb.phpへ
    }
    
    public function prefecture_select(Area $area, Detail $detail)
    {
        //areaインスタンスのうち、(areaテーブルの)area_nameのうち、detailテーブル（選択したデータを格納するテーブル）のarea_nameと同じものを選択し、その一つ目を呼び出す（id情報も含まれている）。
        $select_prefecture = $area->where('area_name', $detail->area_name)->first();
       
        //$select_prefectureに含まれているareaデータのidを持つprefectureをgetしている。
        
        return view('/itineraries/new_entry_prefecture')->with(['prefectures'=>$select_prefecture->prefectures()->get(), 'detail'=>$detail]);//地域選択画面を表示
    }
    
    public function prefecture_store(Request $request, Detail $detail)//出発都道府県を保存
    {
        $input_p = $request->prefecture;
        $detail->fill($input_p)->save();
        return redirect('/itineraries/new_entry/'.$detail->id.'/railroute');//出発駅選択画面を表示するweb.phpへ
    }
    
    public function railroute_select(Request $request, Detail $detail)//heartrails検証用
    {
       
        $url = "http://express.heartrails.com/api/json?method=getLines";
        $method = "GET";
        
        $client = new Client();
        $response = $client->request($method, $url);
        
        $railroutes = json_decode($response->getBody(), true);
       
        //return view('/itineraries/new_entry_railroute');
    }
    
    
     
    
    
     public function new_entry_date()
    {
        return view('itineraries/new_entry_date');
    }
    
    public function departure_area()
    {
        return view ('itineraries/departure_area_nouken');//yahooのmap作り途中
    }



}
