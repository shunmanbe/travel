<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShareItinerary;
use App\Group;
use App\GroupPlace;
use App\Like;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ItineraryDateRequest;
use App\Http\Requests\ItinerarySearchRequest;
use App\Http\Requests\ExplanationRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ShareItineraryController extends Controller
{
    // グループのしおり一覧画面へ
    public function itinerary_index(Group $group, ShareItinerary $shareItinerary)
    {
        $auth = Auth::user();
        return view('itineraries/group/itinerary_index')->with(['auth' => $auth, 'group' => $group, 'shareItineraries' => $shareItinerary->where('group_id', $group->id)->get() ]);
    }
    
    //しおりの説明文入力画面へ
    public function explanation(Group $group, ShareItinerary $shareItinerary)
    {
        $auth = Auth::user();
        return view('itineraries/group/explanation')->with(['auth' => $auth, 'group' => $group, 'shareItinerary' => $shareItinerary]);
    }
    
    //しおりの説明文を保存
    public function explanation_store(ExplanationRequest $request, Group $group, ShareItinerary $shareItinerary)
    {
        $input = $request['explanation'];
        $shareItinerary->fill($input)->save();
        //地域選択画面を表示するweb.phpへ
        return redirect()->route('group.itinerary_index', ['group' => $group]);
    }
    
    //しおりを削除
    public function itinerary_delete(Group $group, ShareItinerary $shareItinerary)
    {
        $auth = Auth::user();
        $shareItinerary->delete();
        return view('itineraries/group/itinerary_index')->with(['auth' => $auth, 'group' => $group, 'shareItineraries' => $shareItinerary->where('group_id', $group->id)->get() ]);
    }

    //完成した詳細画面表示
    public function completed_show(Group $group, ShareItinerary $shareItinerary, GroupPlace $groupPlace) 
    {
        $auth = Auth::user();
        return view('/itineraries/group/completed_show')->with(['auth' => $auth, 'group' => $group, 'shareItinerary' => $shareItinerary, 'groupPlaces' => $groupPlace->where('share_itinerary_id', $shareItinerary->id)->get()]);
    }
    
    //詳細編集画面表示
    public function edit_show(Group $group, ShareItinerary $shareItinerary, GroupPlace $groupPlace) 
    {
        $auth = Auth::user();
        // 出発地しか決まっていない時は<script>の$nに値がなくてエラーが出るため、$nにnullを代入しておく
        $n = null;
        return view('/itineraries/group/edit_show')->with(['auth' => $auth, 'group' => $group, 'shareItinerary' => $shareItinerary, 'groupPlaces' => $groupPlace->where('share_itinerary_id', $shareItinerary->id)->get(), 'n' => $n]);
    }
    
    //日付選択画面へ
    public function date_select(User $user, Group $group)
    {
        $auth = Auth::user();
        return view('itineraries/group/new_entry')->with(['auth' => $auth, 'user' => $user, 'group' => $group]);
    }
    
    //日付を保存
    public function date_store(ItineraryDateRequest $request, Group $group, ShareItinerary $shareItinerary)
    {
        $input_date = $request['initial_setting'];
        $input_date['group_id'] = $group->id;
        $shareItinerary->fill($input_date)->save();
        //地域選択画面を表示するweb.phpへ
        return redirect()->route('group.departure_place_search', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id]);
    }
    
    //出発地を選択
    public function departure_place_search(Group $group, ShareItinerary $shareItinerary)
    {
        $auth = Auth::user();
        return view('/itineraries/group/search_departure_place')->with(['auth' => $auth, 'group'=> $group, 'shareItinerary' => $shareItinerary]);
    }
    
    //出発地をマップから選択
    public function departure_place_map(ItinerarySearchRequest $request, Group $group, ShareItinerary $shareItinerary)
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
        return view('/itineraries/group/map_departure_place')->with(['auth' => $auth, 'group' => $group, 'shareItinerary' => $shareItinerary, 'place_detail_requireds' => $place_detail_requireds]);
    }
    
    //出発地を保存
    public function departure_place_store(Request $request, Group $group, ShareItinerary $shareItinerary)
    {
        $input_departure = $request['departure'];
        $shareItinerary->fill($input_departure)->save();
        return redirect()->route('group.edit_show', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id]);
    }
    
    //しおり名・旅行期間を編集
    public function edit_new_entry(Group $group, ShareItinerary $shareItinerary, User $user)
    {
        $auth = Auth::user();
        return view('itineraries/group/edit_new_entry')->with(['auth' => $auth, 'group' => $group, 'shareItinerary' => $shareItinerary, 'user' => $user]);
    }
    
    //しおり名と旅行期間をアップデート
    public function update_new_entry(ItineraryDateRequest $request, Group $group, ShareItinerary $shareItinerary)
    {
        $auth = Auth::user();
        $input_date = $request['initial_setting'];
        $input_date['user_id'] = Auth::id();
        $shareItinerary->fill($input_date)->save();
        return redirect()->route('group.edit_show',['group' => $group->id, 'shareItinerary' => $shareItinerary->id]);
    }
    
    //出発地を編集
    public function edit_departure(Group $group, ShareItinerary $shareItinerary)
    {
        $auth = Auth::user();
        return view('/itineraries/group/search_departure_place')->with(['auth' => $auth, 'group' => $group, 'shareItinerary' => $shareItinerary]);
    }
    
    //詳細編集ページから経路詳細（ルート）を表示
    public function route(Request $request, Group $group, ShareItinerary $shareItinerary, GroupPlace $groupPlace)
    {
        $auth = Auth::user();
        //移動手段で「電車」が入力された場合
        if($request->input('Mode') == 'TRANSIT'){
            $start_address = $request->input('start_address');
            $goal_address = $request->input('goal_address');
            return redirect('/itineraries/' . $groupPlace->id . '/geocoding')->with(['start_address' => $start_address, 'goal_address' => $goal_address]);
        //それ以外が入力された場合
        }else{
            $mode = $request->input('Mode');
            $start_name = $request->input('start_name');
            $goal_name = $request->input('goal_name');
            $start_lat = $request->input('start_lat');
            $start_lng = $request->input('start_lng');
            $goal_lat = $request->input('goal_lat');
            $goal_lng = $request->input('goal_lng');
            $client = new \GuzzleHttp\Client();
            $url = 'https://maps.googleapis.com/maps/api/directions/json?origin=' . $start_lat . ',' . $start_lng . '&destination=' . $goal_lat . ',' . $goal_lng . '&mode=' . $request->input('Mode') . '&key=' . config('services.google-map.apikey');
            $response = $client->request('GET', $url,
            ['Bearer' => config('serveices.google-map.apikey')]);
            $route_details = json_decode($response->getBody(), true);
            // 距離情報を取り出す
            $distance = $route_details['routes'][0]['legs'][0]['distance']['text'];
            // 時間情報を取り出す
            $duration = $route_details['routes'][0]['legs'][0]['duration']['text'];
            // 時間情報を日本語に変換
            // 変換したいものが複数あるので、変換した状態のものを次の変換元に指定
            // replaceArray('変換する部分', ['変換先'], 変換元)
            $duration_ja = Str::replaceArray('days', ['日'], $duration);
            $duration_ja = Str::replaceArray('day', ['日'], $duration_ja);
            $duration_ja = Str::replaceArray('hours', ['時間'], $duration_ja);
            $duration_ja = Str::replaceArray('hour', ['時間'], $duration_ja);
            $duration_ja = Str::replaceArray('mins', ['分'], $duration_ja);
            $duration_ja = Str::replaceArray('min', ['分'], $duration_ja);
        }
        return view('/itineraries/group/route')->with(['auth' => $auth, 'group' => $group, 'shareItinerary' => $shareItinerary, 'mode'=> $mode, 'start_name' => $start_name, 'goal_name' => $goal_name, 'distance' => $distance, 'duration_ja' => $duration_ja ]);
    }
    
     //詳細完成ページから経路詳細（ルート）を表示
    public function completed_route(Request $request, Group $group, ShareItinerary $shareItinerary, GroupPlace $groupPlace)
    {
        $auth = Auth::user();
        //移動手段で「電車」が入力された場合
        if($request->input('Mode') == 'TRANSIT'){
            $start_address = $request->start_address;
            $goal_address = $request->goal_address;
            return redirect('/itineraries/' . $place->id . '/geocoding')->with(['start_address' => $start_address, 'goal_address' => $goal_address]);
        //それ以外が入力された場合
        }else{
            $mode = $request->input('Mode');
            $start_name = $request->input('start_name');
            $goal_name = $request->input('goal_name');
            $start_lat = $request->input('start_lat');
            $start_lng = $request->input('start_lng');
            $goal_lat = $request->input('goal_lat');
            $goal_lng = $request->input('goal_lng');
            $client = new \GuzzleHttp\Client();
            $url = 'https://maps.googleapis.com/maps/api/directions/json?origin=' . $start_lat . ',' . $start_lng . '&destination=' . $goal_lat . ',' . $goal_lng . '&mode=' . $request->input('Mode') . '&key=' . config('services.google-map.apikey');
            $response = $client->request('GET', $url,
            ['Bearer' => config('serveices.google-map.apikey')]);
            $route_details = json_decode($response->getBody(), true);
            // 距離情報を取り出す
            $distance = $route_details['routes'][0]['legs'][0]['distance']['text'];
            // 時間情報を取り出す
            $duration = $route_details['routes'][0]['legs'][0]['duration']['text'];
            // 時間情報を日本語に変換
            // 変換したいものが複数あるので、変換した状態のものを次の変換元に指定
            // replaceArray('変換する部分', ['変換先'], 変換元)
            $duration_ja = Str::replaceArray('days', ['日'], $duration);
            $duration_ja = Str::replaceArray('day', ['日'], $duration_ja);
            $duration_ja = Str::replaceArray('hours', ['時間'], $duration_ja);
            $duration_ja = Str::replaceArray('hour', ['時間'], $duration_ja);
            $duration_ja = Str::replaceArray('mins', ['分'], $duration_ja);
            $duration_ja = Str::replaceArray('min', ['分'], $duration_ja);
        }
        return view('/itineraries/group/completed_route')->with(['auth' => $auth, 'group' => $group, 'shareItinerary' => $shareItinerary, 'mode'=> $mode, 'start_name' => $start_name, 'goal_name' => $goal_name, 'distance' => $distance, 'duration_ja' => $duration_ja ]);
    }
    
    //いいね機能
    public function like(Request $request)
    {
        //ログインユーザーのid取得
        $user_id = Auth::user()->id; 
        //投稿idの取得
        $shareItinerary_id = $request->itinerary_id; 
        $already_liked = Like::where('user_id', $user_id)->where('itinerary_id', $shareItinerary_id)->first();
        //もしこのユーザーがこの投稿にまだいいねしてなかったら
        if (!$already_liked) { 
            //Likeクラスのインスタンスを作成
            $like = new Like; 
            //Likeインスタンスにitinerary_idをセット
            $like->itinerary_id = $shareItinerary_id; 
            //Likeインスタンスにuser_idをセット
            $like->user_id = $user_id; 
            $like->save();
        //もしこのユーザーがこの投稿に既にいいねしてたらdelete
        } else { 
            Like::where('itinerary_id', $shareItinerary_id)->where('user_id', $user_id)->delete();
        }
        //この投稿の最新の総いいね数を取得
        //withCountメソッドを使用することでリレーションされている別テーブルの数をカウントすることができる。
        $shareItinerary_likes_count = Itinerary::withCount('likes')->findOrFail($shareItinerary_id)->likes_count; //findOrFail()は一致する()が見つからなかったらエラーを返す。
        $param = [
            'itinerary_likes_count' => $shareItinerary_likes_count,
        ];
        return response()->json($param); //JSONデータをjQueryに返す
    }
    
}
