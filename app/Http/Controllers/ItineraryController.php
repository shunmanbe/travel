<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Itinerary;
use App\Place;
use App\Like;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExplanationRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ItineraryController extends Controller
{
    //しおり一覧画面へ
    public function index(Itinerary $itinerary, Place $place, User $user)
    {
        $auth = Auth::user();
        return view('itineraries/index')->with(['auth' => $auth, 'itineraries' => $itinerary->where('user_id', auth()->id())->get(), 'place' => $place]);
    }
    
    //しおりの説明文入力画面へ
    public function explanation(Itinerary $itinerary)
    {
        $auth = Auth::user();
        return view('itineraries/explanation')->with(['auth' => $auth, 'itinerary' => $itinerary]);
    }
    
    //しおりの説明文を保存
    public function explanation_store(ExplanationRequest $request, Itinerary $itinerary)
    {
        $input = $request['explanation'];
        $itinerary->fill($input)->save();
        //地域選択画面を表示するweb.phpへ
        return redirect()->route('index');
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
        // 出発地しか決まっていない時は<script>の$nに値がなくてエラーが出るため、$nにnullを代入しておく
        $n = null;
        return view('/itineraries/edit_show')->with(['auth' => $auth, 'itinerary' => $itinerary, 'places' => $place->where('itinerary_id', $itinerary->id)->get(), 'n' => $n]);
    }
    
    //日付選択画面へ
    public function date_select(User $user)
    {
        $auth = Auth::user();
        return view('itineraries/new_entry_date')->with(['auth' => $auth, 'user' => $user]);
    }
    
    //日付を保存
    public function date_store(Request $request, Itinerary $itinerary)
    {
        $input_date = $request['initial_setting'];
        $input_date['user_id'] = Auth::id();
        $itinerary->fill($input_date)->save();
        //地域選択画面を表示するweb.phpへ
        return redirect()->route('departure_place_search',['itinerary' => $itinerary->id]);
    }
    
    //出発地を選択
    public function departure_place_search(Itinerary $itinerary)
    {
        $auth = Auth::user();
        return view('/itineraries/search_departure_place')->with(['auth' => $auth, 'itinerary' => $itinerary]);
    }
    
    //出発地をマップから選択
    public function departure_place_map(Request $request, Itinerary $itinerary)
    {
        $auth = Auth::user();
        $input = $request['search_name'];
        // GuzzleパッケージはPHPでWebサーバにAPIリクエストを送信したい場合に利用するもの
        // インスタンス作成
        $client = new \GuzzleHttp\Client();
        //検索ワードに関連する施設の詳細情報を取得
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?key=' . config("services.google-map.apikey") . '&query=' . $input . '&language=ja';
        // APIに対してGETメソッドでHTTP通信を行う。
        $response = $client->request('GET', $url,
        ['Bearer' => config('serveices.google-map.apikey')]);
        // 受け取った土地に関する情報全てを$place_detailsに代入
        // json_decode関数はJSONフォーマットされた文字列をPHPの変数に変換する関数。
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
        return view('/itineraries/map_departure_place')->with(['auth' => $auth, 'itinerary' => $itinerary, 'place_detail_requireds' => $place_detail_requireds]);
    }
    
    //出発地を保存
    public function departure_place_store(Request $request, Place $place, Itinerary $itinerary)
    {
        $input_departure = $request['departure'];
        $itinerary->fill($input_departure)->save();
        return redirect()->route('edit_show',['itinerary' => $itinerary->id]);
    }
    
    // 写真投稿画面へ
    public function image_departure(Itinerary $itinerary)
    {
        $auth = Auth::user();
        return view('itineraries/image_departure')->with(['auth' => $auth, 'itinerary' => $itinerary]);
    }
    
    // 写真の投稿
    public function image(Request $request, Itinerary $itinerary)
    {
        $form = $request->all();
        // s3アップロード開始
        $image = $request->file('image');
        // バケットのmyprefixフォルダへアップロード
        $path = Storage::disk('s3')->putFile('myprefix', $image, 'public');
        // アップロードした画像のパスを取得
        $itinerary->image_path = Storage::disk('s3')->url($path);
        $itinerary->save();
        return redirect()->route('index');
    }
    
    
    //しおりを削除
    public function itinerary_delete(Itinerary $itinerary)
    {
        $itinerary->delete();
        return redirect()->route('index');
    }
    
    //しおり名・旅行期間を編集
    public function edit_new_entry(Itinerary $itinerary, User $user)
    {
        $auth = Auth::user();
        return view('itineraries/edit_new_entry')->with(['auth' => $auth, 'itinerary' => $itinerary, 'user' => $user]);
    }
    
    //しおり名と旅行期間をアップデート
    public function update_new_entry(Request $request, Itinerary $itinerary)
    {
        $auth = Auth::user();
        $input_date = $request['initial_setting'];
        $input_date['user_id'] = Auth::id();
        $itinerary->fill($input_date)->save();
        return redirect()->route('edit_show',['itinerary' => $itinerary->id]);
    }
    
    //出発地を編集
    public function edit_departure(Itinerary $itinerary)
    {
        $auth = Auth::user();
        return view('/itineraries/search_departure_place')->with(['auth' => $auth, 'itinerary' => $itinerary]);
    }
    
    //出発地のメモ
    public function memo_departure(Itinerary $itinerary)
    {
        $auth = Auth::user();
        return view('itineraries/memo_departure')->with(['auth' => $auth, 'itinerary' => $itinerary]);
    }
    
    //出発地のメモを保存
    public function memo_departure_store(Itinerary $itinerary, Request $request)
    {
        $input_memo = $request->input('memo');
        $itinerary->fill($input_memo)->save();
        return redirect()->route('edit_show',['itinerary' => $itinerary->id]);
    }
    
    //詳細編集ページから経路詳細（ルート）を表示（移動手段が決まっていない時）
    public function route(Request $request, Itinerary $itinerary, Place $place)
    {
        $auth = Auth::user();
        // 移動手段が登録されている時
        if($place->transportation !== null){
            $mode = $place->transportation;
        }else{ //移動手段が登録されていなかった時
            // 選択された移動手段を取得
            $mode = $request->input('transportation')['transportation'];
            // 移動手段で「電車」が入力された場合
            if($mode == 'TRAIN'){
                $start_address = $request->start_address;
                $goal_address = $request->goal_address;
                return redirect()->route('route_train', ['itinerary' => $itinerary->id, 'place' => $place->id]);
            }
        }
        $start_name = $request->input('start_name');
        $goal_name = $request->input('goal_name');
        $start_lat = $request->input('start_lat');
        $start_lng = $request->input('start_lng');
        $goal_lat = $request->input('goal_lat');
        $goal_lng = $request->input('goal_lng');
        $client = new \GuzzleHttp\Client();
        $url = 'https://maps.googleapis.com/maps/api/directions/json?origin=' . $start_lat . ',' . $start_lng . '&destination=' . $goal_lat . ',' . $goal_lng . '&mode=' . $mode . '&key=' . config('services.google-map.apikey');
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
            
        return view('/itineraries/route')->with(['auth' => $auth, 'itinerary' => $itinerary, 'mode'=> $mode, 'start_name' => $start_name, 'goal_name' => $goal_name, 'distance' => $distance, 'duration_ja' => $duration_ja ]);
    }
    
     //詳細完成ページから経路詳細（ルート）を表示
    public function completed_route(Request $request, Itinerary $itinerary, Place $place)
    {
        $auth = Auth::user();
        $mode = $place->transportation;
        $start_name = $request->input('start_name');
        $goal_name = $request->input('goal_name');
        $start_lat = $request->input('start_lat');
        $start_lng = $request->input('start_lng');
        $goal_lat = $request->input('goal_lat');
        $goal_lng = $request->input('goal_lng');
        $client = new \GuzzleHttp\Client();
        $url = 'https://maps.googleapis.com/maps/api/directions/json?origin=' . $start_lat . ',' . $start_lng . '&destination=' . $goal_lat . ',' . $goal_lng . '&mode=' . $mode . '&key=' . config('services.google-map.apikey');
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
            
        return view('/itineraries/completed_route')->with(['auth' => $auth, 'itinerary' => $itinerary, 'mode'=> $mode, 'start_name' => $start_name, 'goal_name' => $goal_name, 'distance' => $distance, 'duration_ja' => $duration_ja ]);
    }
    
    // 電車移動
    public function route_train()
    {
        $client = new \GuzzleHttp\Client();
        $url = 'https://api.ekispert.jp/v1/json/station/light?key=' . config('services.ekispert.apikey') . '&code=22828';
        $response = $client->request('GET', $url,
        ['Bearer' => config('serveices.google-map.apikey')]);
        $route_details = json_decode($response->getBody(), true);
        // dd($route_details);
    }
    
    //ログアウト
    public function logout()
    {
        Auth::logout();
        return redirect()->route('index');
    }
    
    //いいね機能
    public function like(Request $request, Itinerary $itinerary)
    {
        //ログインユーザーのid取得
        $user_id = Auth::user()->id; 
        //投稿idの取得
        $itinerary_id = $request->itinerary_id; 
        // Likeテーブル（中間テーブル）の'user_id'カラムが上で定義した$user_id（userのid）で、'itinerary_id'カラムが上で定義した$itinerary_id（itineraryのid）と一致するものを一つとってくる。
        $already_liked = Like::where('user_id', $user_id)->where('itinerary_id', $itinerary_id)->first();
        //もしこのユーザーがこの投稿にまだいいねしてなかったら（already_Likedが空だったら（上で該当するものがなかったら））
        // 中間テーブルにおける処理
        if (!$already_liked) { 
            //Likeクラスのインスタンスを作成
            $like = new Like; 
            //Likeインスタンスにitinerary_idをセット
            $like->itinerary_id = $itinerary_id; 
            //Likeインスタンスにuser_idをセット
            $like->user_id = $user_id; 
            $like->save();
        //もしこのユーザーがこの投稿に既にいいねしてたらdelete
        } else { 
            Like::where('user_id', $user_id)->where('itinerary_id', $itinerary_id)->delete();
        }
        //この投稿の最新の総いいね数を取得
        //withCountメソッドを使用することでリレーションされている別テーブルの数をカウントすることができる。
        $itinerary_likes_count = Itinerary::withCount('likes')->findOrFail($itinerary_id)->likes_count; //findOrFail()は一致する()が見つからなかったらエラーを返す。
        // $itinerary_likes_count = Itinerary::withCount('likes')->where('itinerary_id', $itinerary_id)->first();
        
        $param = [
            'itinerary_likes_count' => $itinerary_likes_count,
        ];
        return response()->json($param); //JSONデータをjQueryに返す(dataに入る)
    }
    
    //他のユーザーのしおりを見る
    public function others_index(Itinerary $itinerary)
    {
        $auth = Auth::user();
        // withCountはリレーション結果の件数を実際にレコードに読み込むことなく取得することができる。件数の結果は'{リレーション名}_count'カラム名に格納される。
        // withCountの引数は取得したいリレーションテーブル名。
        $itineraries = Itinerary::withCount('likes')->orderBy('id', 'desc')->paginate(10);
        $param = ['itineraries' => $itineraries];
        return view ('itineraries/others_index')->with(['auth' => $auth, 'itineraries' => $itinerary->where('user_id', '!=', $auth->id)->get(), 'param' => $param]);
    }
    
    //他のユーザーのしおり詳細を見る
    public function completed_others_show(Itinerary $itinerary, Place $place)
    {
        $auth = Auth::user();
        return view('/itineraries/completed_others_show')->with(['auth' => $auth, 'itinerary' => $itinerary, 'places' => $place->where('itinerary_id', $itinerary->id)->get()]);
    }
    
    
    public function completed_others_route(Request $request, Itinerary $itinerary, Place $place)
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
        return view('/itineraries/completed_others_route')->with(['auth' => $auth, 'itinerary' => $itinerary, 'mode'=> $mode, 'start_name' => $start_name, 'goal_name' => $goal_name, 'distance' => $distance, 'duration_ja' => $duration_ja ]);
    }
    
    //ジオコーディング（住所から緯度・軽度取得）
    public function geocoding(Request $request, Itinerary $itinerary, Place $place)
    {
        $auth = Auth::user();
        $client = new \GuzzleHttp\Client();
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?key=' . config('services.google-map.apikey') . '&address=' . $start_address . '&language=ja';
        $response = $client->request('GET', $url,
        ['Bearer' => config('serveices.google-map.apikey')]);
        $itineraries = json_decode($response->getBody(), true);
        //緯度取得
        $place_lat = [ ];
        //軽度取得
        $place_lng = [ ];
        
    }
}
