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
    public function index(Itinerary $itinerary, Place $place, User $user, Like $like)
    {
        $auth = Auth::user();
        //データという名前の配列を作成
        $data = []; 
        //いいねをつけたしおりを作成日時の降順で取得
        $itineraries = Itinerary::with('likes')->orderBy('created_at', 'desc')->paginate(10);
        //$dataの配列に要素を追加
        $data = [
                'itineraries' => $itinerary, 
                'like' => $like,
            ];
        
        return view('itineraries/index')->with(['auth' => $auth, 'itineraries' => $itinerary->where('user_id', auth()->id())->get(), 'place' => $place, 'like' => $like]);
    }
    
    public function ajaxlike(Request $request, Like $like)
    {
        $id = Auth::user()->id;
        $itinerary_id = $request->Itinerary_id;
        $itinerary = Itinerary::findOrFail($itinerary_id); //findOrFail()は、一致するitinerary_idが見つからなかった場合は、エラーを返す。find()は、一致するitinerary_idが見つからなかった場合はnullを返す。

        // 空でない（既にいいねしている）とき
        if ($like->like_exist($id, $post_id)) {
            //likesテーブルのレコードを削除
            $like = Like::where('post_id', $post_id)->where('user_id', $id)->delete();
        } else {
            //空（まだ「いいね」していない）ならlikesテーブルに新しいレコードを作成する
            $like = new Like;
            $like->Itinerary_id = $request->Itinerary_id;
            $like->user_id = Auth::user()->id;
            $like->save();
        }
        //いいねの総数
        $itineraryLikesCount = $itinerary->withCount('likes');

        //一つの変数にajaxに渡す値をまとめる
        $json = [
            'ItineraryLikesCount' => $itineraryLikesCount,
        ];
        //ajaxに引数(パラメーター)の値を返す
        return response()->json($json);
    }

    //完成した詳細画面表示
    public function completed_show(Itinerary $itinerary, Place $place) 
    {
        $auth = Auth::user();
        return view('/itineraries/completed_show')->with(['auth' => $auth, 'itinerary' => $itinerary, 'places' => $place->where('itinerary_id', $itinerary->id)->get()]);
    }
    
    //詳細編集画面表示
    public function show_edit(Itinerary $itinerary, Place $place) 
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
        return redirect('/itineraries/'.$itinerary->id.'/show/edit');
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
        return redirect('/itineraries/' . $itinerary->id . '/show/edit');
    }
    
    //出発地を編集
    public function edit_departure(Itinerary $itinerary)
    {
        $auth = Auth::user();
        return view('/itineraries/search_departure_place')->with(['auth' => $auth, 'itinerary' => $itinerary]);
    }
    
    //ルートを表示
    public function route(ModeRequest $request, Itinerary $itinerary, Place $place)
    {
        $auth = Auth::user();
        $mode = $request->input('Mode');
        $start = $request->input('start');
        $end = $request->input('end');
        //falseにする。ここに到達すればバリデーションテェックは通過。
        return view('/itineraries/route')->with(['auth' => $auth, 'mode'=> $mode, 'start' => $start, 'end' => $end, 'itinerary' => $itinerary]);
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

}
