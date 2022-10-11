<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detail;
use App\Place;
use Carbon\Carbon;
use App\Area;
use App\Prefecture;
use GuzzleHttp\Client;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DetailDateRequest;
use App\Http\Requests\DetailSearchRequest;

class DetailController extends Controller
{
    public function index(Detail $detail, Place $place, User $user)
    {
        return view('itineraries/top')->with(['details' => $detail->where('user_id', auth()->id())->get(), 'place' => $place]);
    }
    
    
    public function date_select(User $user)
    {
        return view('itineraries/new_entry_date')->with(['user' => $user]);
    }
    
    //日付を保存
    public function date_store(DetailDateRequest $request, Detail $detail)
    {
        $input_date = $request['initial_setting'];
        $input_date['user_id'] = Auth::id();
        $detail->fill($input_date)->save();
        //地域選択画面を表示するweb.phpへ
        return redirect('/itineraries/'.$detail->id.'/departure_place_search');
    }
    
    public function departure_place_serach(Detail $detail)
    {
        return view('/itineraries/search_departure_place')->with(['detail' => $detail]);
    }
    
    public function departure_place_map(DetailSearchRequest $request, Detail $detail)
    {
        $input_s = $request['search_name'];
        $client = new \GuzzleHttp\Client();
        //検索ワードに関連する施設の詳細情報を取得
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?key=' . config("services.google-map.apikey") . '&query=' . $input_s . '&language=ja';
        $response = $client->request('GET', $url,
        ['Bearer' => config('serveices.google-map.apikey')]);
        $details_get = json_decode($response->getBody(), true);
        $place_ids = [ ];
        $place_names = [ ];
        for($i = 0; $i < count($details_get['results']); $i++)
        {
            $place_ids[ ] = $details_get['results'][$i]['formatted_address'];
            $place_names[ ] = $details_get['results'][$i]['name'];
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
    
    //詳細画面表示
    public function show(Detail $detail, Place $place) 
    {
        return view('/itineraries/show')->with(['detail' => $detail, 'places' => $place->where('detail_id', $detail->id)->get()]);
    }
    //しおりを削除
    public function delete(Detail $detail)
    {
        $detail->delete();
        return redirect('/');
    }
    
    //出発地を編集
    public function edit(Detail $detail)
    {
        return view('/itineraries/search_departure_place')->with(['detail' => $detail]);
    }
    
    //ルートを表示
    public function route(Request $request, Detail $detail)
    {
        $mode = $request->input('Mode');
        // $start = $request->input('start');
        $end = $request->input('end');
        // $start = $request->start;
        // $start = $request['start'];
        // $start = $request->('start');
        // $start = $request->input[start];
        
        
        
        dd($start);
        return view('itineraries/route')->with(['mode'=> $mode, 'start' => $start, 'end' => $end]);
    }
}
