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
use App\Http\Requests\ModeRequest;
use App\Http\Requests\DetailDateRequest;
use App\Http\Requests\DetailSearchRequest;
use Illuminate\Support\Facades\Validator;

class DetailController extends Controller
{
    //しおり一覧画面へ
    public function index(Detail $detail, Place $place, User $user)
    {
        $auth = Auth::user();
        return view('itineraries/top')->with(['auth' => $auth, 'details' => $detail->where('user_id', auth()->id())->get(), 'place' => $place]);
    }
    
    //完成した詳細画面表示
    public function completed_show(Detail $detail, Place $place) 
    {
        $auth = Auth::user();
        return view('/itineraries/completed_show')->with(['auth' => $auth, 'detail' => $detail, 'places' => $place->where('detail_id', $detail->id)->get()]);
    }
    
    //詳細編集画面表示
    public function show_edit(Detail $detail, Place $place) 
    {
        $auth = Auth::user();
        return view('/itineraries/edit_show')->with(['auth' => $auth, 'detail' => $detail, 'places' => $place->where('detail_id', $detail->id)->get()]);
    }
    
    //日付選択画面へ
    public function date_select(User $user)
    {
        $auth = Auth::user();
        return view('itineraries/new_entry_date')->with(['auth' => $auth, 'user' => $user]);
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
    
    //出発地を選択
    public function departure_place_serach(Detail $detail)
    {
        $auth = Auth::user();
        return view('/itineraries/search_departure_place')->with(['auth' => $auth, 'detail' => $detail]);
    }
    
    //出発地をマップから選択
    public function departure_place_map(DetailSearchRequest $request, Detail $detail)
    {
        $auth = Auth::user();
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
        return view('/itineraries/map_departure_place')->with(['auth' => $auth, 'detail' => $detail,'place_details' => $place_details]);
    }
    
    //出発地を保存
    public function departure_place_store(Request $request, Place $place, Detail $detail)
    {
        $input_departure = $request['departure'];
        $detail->fill($input_departure)->save();
        //return redirect('/itineraries/'.$detail->id.'/decided_only_departure_place');//出発地を保存
        return redirect('/itineraries/'.$detail->id.'/show/edit');
    }
    
    
    //しおりを削除
    public function itinerary_delete(Detail $detail)
    {
        $detail->delete();
        return redirect('/');
    }
    
    //しおり名・旅行期間を編集
    public function edit_new_entry(Detail $detail, User $user)
    {
        $auth = Auth::user();
        return view('itineraries/edit_new_entry')->with(['auth' => $auth, 'detail' => $detail, 'user' => $user]);
    }
    
    //しおり名と旅行期間をアップデート
    public function update_new_entry(DetailDateRequest $request, Detail $detail)
    {
        $auth = Auth::user();
        $input_date = $request['initial_setting'];
        $input_date['user_id'] = Auth::id();
        $detail->fill($input_date)->save();
        return redirect('/itineraries/' . $detail->id . '/show');
    }
    
    //出発地を編集
    public function edit_departure(Detail $detail)
    {
        $auth = Auth::user();
        return view('/itineraries/search_departure_place')->with(['auth' => $auth, 'detail' => $detail]);
    }
    
    //ルートを表示
    public function route(ModeRequest $request, Detail $detail, Place $place)
    {
        $auth = Auth::user();
        $mode = $request->input('Mode');
        $start = $request->input('start');
        $end = $request->input('end');
        //falseにする。ここに到達すればバリデーションテェックは通過。
        return view('/itineraries/route')->with(['auth' => $auth, 'mode'=> $mode, 'start' => $start, 'end' => $end, 'detail' => $detail]);
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    
    
    public function edit_departure_time(Detail $detail, Place $place)
    {
        $place->departure_time = null;
        $place->save();
        return redirect('/itineraries/'. $detail->id .'/show/');
    }

}
