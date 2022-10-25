<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Itinerary;
use App\Place;
use App\Like;
use Carbon\Carbon;
use App\Area;
use App\Prefecture;
use GuzzleHttp\Client;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ModeRequest;
use App\Http\Requests\ItineraryDateRequest;
use App\Http\Requests\ItinerarySearchRequest;
use Illuminate\Support\Facades\Validator;

class ItineraryController extends Controller
{
    //しおり一覧画面へ
    public function index(Itinerary $itinerary, Place $place, User $user)
    {
        $auth = Auth::user();
        return view('itineraries/index')->with(['auth' => $auth, 'itineraries' => $itinerary->where('user_id', auth()->id())->get(), 'place' => $place]);
    }

    //完成した詳細画面表示
    public function completed_show(Itinerary $itinerary, Place $place) 
    {
        $auth = Auth::user();
        return view('/itineraries/completed_show')->with(['auth' => $auth, 'itinerary' => $itinerary, 'places' => $place->where('itinerary_id', $itinerary->id)->get()]);
    }
    
    //詳細編集画面表示
    public function edit_show(Itinerary $itinerary, Place $place) 
    {
        $auth = Auth::user();
        return view('/itineraries/edit_show')->with(['auth' => $auth, 'itinerary' => $itinerary, 'places' => $place->where('itinerary_id', $itinerary->id)->get()]);
    }
    
    //日付選択画面へ
    public function date_select(User $user)
    {
        $auth = Auth::user();
        return view('itineraries/new_entry_date')->with(['auth' => $auth, 'user' => $user]);
    }
    
    //日付を保存
    public function date_store(ItineraryDateRequest $request, Itinerary $itinerary)
    {
        $input_date = $request['initial_setting'];
        $input_date['user_id'] = Auth::id();
        $itinerary->fill($input_date)->save();
        //地域選択画面を表示するweb.phpへ
        return redirect('/itineraries/'.$itinerary->id.'/departure_place_search');
    }
    
    //出発地を選択
    public function departure_place_serach(Itinerary $itinerary)
    {
        $auth = Auth::user();
        return view('/itineraries/search_departure_place')->with(['auth' => $auth, 'itinerary' => $itinerary]);
    }
    
    //出発地をマップから選択
    public function departure_place_map(ItinerarySearchRequest $request, Itinerary $itinerary)
    {
        $auth = Auth::user();
        $input_s = $request['search_name'];
        $client = new \GuzzleHttp\Client();
        //検索ワードに関連する施設の詳細情報を取得
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?key=' . config("services.google-map.apikey") . '&query=' . $input_s . '&language=ja';
        $response = $client->request('GET', $url,
        ['Bearer' => config('serveices.google-map.apikey')]);
        $itineraries_get = json_decode($response->getBody(), true);
        $place_ids = [ ];
        $place_names = [ ];
        for($i = 0; $i < count($itineraries_get['results']); $i++)
        {
            $place_ids[ ] = $itineraries_get['results'][$i]['formatted_address'];
            $place_names[ ] = $itineraries_get['results'][$i]['name'];
        }
        $place_details = array_map(null, $place_ids, $place_names);
        return view('/itineraries/map_departure_place')->with(['auth' => $auth, 'itinerary' => $itinerary,'place_details' => $place_details]);
    }
    
    //出発地を保存
    public function departure_place_store(Request $request, Place $place, Itinerary $itinerary)
    {
        $input_departure = $request['departure'];
        $itinerary->fill($input_departure)->save();
        //return redirect('/itineraries/'.$itinerary->id.'/decided_only_departure_place');//出発地を保存
        return redirect('/itineraries/'.$itinerary->id.'/edit/show');
    }
    
    
    //しおりを削除
    public function itinerary_delete(Itinerary $itinerary)
    {
        $itinerary->delete();
        return redirect('/');
    }
    
    //しおり名・旅行期間を編集
    public function edit_new_entry(Itinerary $itinerary, User $user)
    {
        $auth = Auth::user();
        return view('itineraries/edit_new_entry')->with(['auth' => $auth, 'itinerary' => $itinerary, 'user' => $user]);
    }
    
    //しおり名と旅行期間をアップデート
    public function update_new_entry(ItineraryDateRequest $request, Itinerary $itinerary)
    {
        $auth = Auth::user();
        $input_date = $request['initial_setting'];
        $input_date['user_id'] = Auth::id();
        $itinerary->fill($input_date)->save();
        return redirect('/itineraries/' . $itinerary->id . '/edit/show');
    }
    
    //出発地を編集
    public function edit_departure(Itinerary $itinerary)
    {
        $auth = Auth::user();
        return view('/itineraries/search_departure_place')->with(['auth' => $auth, 'itinerary' => $itinerary]);
    }
    
    //詳細編集ページから経路詳細（ルート）を表示
    public function route(ModeRequest $request, Itinerary $itinerary, Place $place)
    {
        $auth = Auth::user();
        $mode = $request->input('Mode');
        $start = $request->input('start');
        $end = $request->input('end');
        //falseにする。ここに到達すればバリデーションテェックは通過。
        return view('/itineraries/route')->with(['auth' => $auth, 'mode'=> $mode, 'start' => $start, 'end' => $end, 'itinerary' => $itinerary]);
    }
    
     //詳細完成ページから経路詳細（ルート）を表示
    public function completed_routeroute(ModeRequest $request, Itinerary $itinerary, Place $place)
    {
        $auth = Auth::user();
        $mode = $request->input('Mode');
        $start = $request->input('start');
        $end = $request->input('end');
        //falseにする。ここに到達すればバリデーションテェックは通過。
        return view('/itineraries/completed_route')->with(['auth' => $auth, 'mode'=> $mode, 'start' => $start, 'end' => $end, 'itinerary' => $itinerary]);
    }
    
    //ログアウト
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    
    //いいね機能
    public function like(Request $request)
    {
        $user_id = Auth::user()->id; //ログインユーザーのid取得
        $itinerary_id = $request->itinerary_id; //投稿idの取得
        $already_liked = Like::where('user_id', $user_id)->where('itinerary_id', $itinerary_id)->first();
    
        if (!$already_liked) { //もしこのユーザーがこの投稿にまだいいねしてなかったら
            $like = new Like; //Likeクラスのインスタンスを作成
            $like->itinerary_id = $itinerary_id; //Likeインスタンスにitinerary_id,user_idをセット
            $like->user_id = $user_id; //上と同様
            $like->save();
        } else { //もしこのユーザーがこの投稿に既にいいねしてたらdelete
            Like::where('itinerary_id', $itinerary_id)->where('user_id', $user_id)->delete();
        }
        //この投稿の最新の総いいね数を取得
        //withCountメソッドを使用することでリレーションされている別テーブルの数をカウントすることができる。
        $itinerary_likes_count = Itinerary::withCount('likes')->findOrFail($itinerary_id)->likes_count; //findOrFail()は一致する()が見つからなかったらエラーを返す。
        $param = [
            'itinerary_likes_count' => $itinerary_likes_count,
        ];
        return response()->json($param); //6.JSONデータをjQueryに返す
    }
    
    //他のユーザーのしおりを見る
    public function others_index(Itinerary $itinerary)
    {
        $auth = Auth::user();
        $itineraries = Itinerary::withCount('likes')->orderBy('id', 'desc')->paginate(10);
        $param = ['itineraries' => $itineraries];
        return view ('itineraries/others_index')->with(['auth' => $auth, 'itineraries' => $itinerary->where('user_id', '!=', $auth->id)->get(), 'param' => $param]);
    }
    
    public function completed_others_show(Itinerary $itinerary, Place $place)
    {
        $auth = Auth::user();
        return view('/itineraries/completed_others_show')->with(['auth' => $auth, 'itinerary' => $itinerary, 'places' => $place->where('itinerary_id', $itinerary->id)->get()]);
    }
    

}
