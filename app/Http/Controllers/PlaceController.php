<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Place;
use App\Detail;

class PlaceController extends Controller
{
    public function destination_search(Detail $detail)
    {
        return view('/itineraries/search_destination')->with(['detail' => $detail]);
    }
    
    
    public function destination_map(Request $request, Detail $detail, Place $place)
    {
        $input_s = $request['search_name'];
        $client = new \GuzzleHttp\Client();
        //検索ワードに関連する施設の詳細情報を取得
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?key=' . config("services.google-map.apikey") . '&query=' . $input_s . '&language=ja';
        $response = $client->request('GET', $url,
        ['Bearer' => config('serveices.google-map.apikey')]);
        $details = json_decode($response->getBody(), true);
        $place_addresses = [ ];
        $place_names = [ ];
        //$places = array( );
        for($i = 0; $i < count($details['results']); $i++){
            $place_addresses[ ] = $details['results'][$i]['formatted_address'];
            $place_names[ ] = $details['results'][$i]['name'];
            //$places[ $details['results'][$i]['place_id'] ] = $details['results'][$i]['name'];
        }
        $place_details = array_map(null, $place_addresses, $place_names);
        return view('/itineraries/select_destination')->with(['place_details' => $place_details, 'detail' => $detail, 'place' => $place]);
    }
    
    public function destination_store(Request $request, Detail $detail, Place $place)
    {
        $place->fill($request['destination'])->save();
        return redirect('/itineraries/'.$detail->id.'/show/'.$place->id);//目的地を保存
    }
    
    public function show(Detail $detail, Place $place) //目的地を含めた詳細画面表示
    {
        
        return view('/itineraries/show')->with(['detail' => $detail, 'places' => $place->where('detail_id', $detail->id)->get()]);
    }
    
    public function edit(Detail $detail, Place $place)
    {
        return view('/itineraries/search_destination_edit')->with(['detail' => $detail, 'place' => $place]);
    }
    
    public function edit_departure_place_map(Request $request, Detail $detail, Place $place)
    {
        $input_s = $request['search_name'];
        $client = new \GuzzleHttp\Client();
        //検索ワードに関連する施設の詳細情報を取得
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?key=' . config("services.google-map.apikey") . '&query=' . $input_s . '&language=ja';
        $response = $client->request('GET', $url,
        ['Bearer' => config('serveices.google-map.apikey')]);
        $details = json_decode($response->getBody(), true);
        $place_addresses = [ ];
        $place_names = [ ];
        //$places = array( );
        for($i = 0; $i < count($details['results']); $i++){
            $place_addresses[ ] = $details['results'][$i]['formatted_address'];
            $place_names[ ] = $details['results'][$i]['name'];
            //$places[ $details['results'][$i]['place_id'] ] = $details['results'][$i]['name'];
        }
        $place_details = array_map(null, $place_addresses, $place_names);
        return view('/itineraries/select_destination_edit')->with(['place_details' => $place_details, 'detail' => $detail, 'place' => $place]);
    }
    
    public function update(Request $request, Detail $detail, Place $place)
    {
        $place->fill($request['destination'])->save();
        return redirect('/itineraries/'.$detail->id.'/show/'.$place->id);//目的地をupdate
    }
    
    
    
    public function first_destination_search(Detail $detail)
    {
        return view('/itineraries/search_first_destination')->with(['detail' => $detail]);
    }
    
     public function first_destination_map(Request $request, Detail $detail)
    {
        $input_s = $request['search_name'];
        $client = new \GuzzleHttp\Client();
        //検索ワードに関連する施設の詳細情報を取得
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?key=' . config("services.google-map.apikey") . '&query=' . $input_s . '&language=ja';
        
        
        //$url = 'https://maps.googleapis.com/maps/api/place/details/json?key=' . config("services.google-map.apikey") . '&q=' . $input_s;
        $response = $client->request('GET', $url,
        ['Bearer' => config('serveices.google-map.apikey')]);
        $details = json_decode($response->getBody(), true);
        $place_ids = [ ];
        $place_names = [ ];
        //$places = array( );
        for($i = 0; $i < count($details['results']); $i++){
            $place_ids[ ] = $details['results'][$i]['formatted_address'];
            $place_names[ ] = $details['results'][$i]['name'];
            //$places[ $details['results'][$i]['place_id'] ] = $details['results'][$i]['name'];
        }
        $places = array_map(null, $place_ids, $place_names);
        return view('/itineraries/select_first_destination')->with(['places' => $places, 'detail' => $detail]);
    }
    
    
    
    
    public function second_destination_search(Detail $detail)
    {
        return view('/itineraries/search_second_destination')->with(['detail' => $detail]);
    }
    
     public function second_destination_map(Request $request, Detail $detail)
    {
        $input_s = $request['search_name'];
        $client = new \GuzzleHttp\Client();
        //検索ワードに関連する施設の詳細情報を取得
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?key=' . config("services.google-map.apikey") . '&query=' . $input_s . '&language=ja';
        
        
        //$url = 'https://maps.googleapis.com/maps/api/place/details/json?key=' . config("services.google-map.apikey") . '&q=' . $input_s;
        $response = $client->request('GET', $url,
        ['Bearer' => config('serveices.google-map.apikey')]);
        $details = json_decode($response->getBody(), true);
        $place_ids = [ ];
        $place_names = [ ];
        //$places = array( );
        for($i = 0; $i < count($details['results']); $i++){
            $place_ids[ ] = $details['results'][$i]['formatted_address'];
            $place_names[ ] = $details['results'][$i]['name'];
            //$places[ $details['results'][$i]['place_id'] ] = $details['results'][$i]['name'];
        }
        $places = array_map(null, $place_ids, $place_names);
        return view('/itineraries/select_second_destination')->with(['places' => $places, 'detail' => $detail]);
    }
    
    
    
    
    
    public function third_destination_search(Detail $detail)
    {
        return view('/itineraries/search_third_destination')->with(['detail' => $detail]);
    }
    
    public function third_destination_map(Request $request, Detail $detail)
    {
        $input_s = $request['search_name'];
        $client = new \GuzzleHttp\Client();
        //検索ワードに関連する施設の詳細情報を取得
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?key=' . config("services.google-map.apikey") . '&query=' . $input_s . '&language=ja';
        
        
        //$url = 'https://maps.googleapis.com/maps/api/place/details/json?key=' . config("services.google-map.apikey") . '&q=' . $input_s;
        $response = $client->request('GET', $url,
        ['Bearer' => config('serveices.google-map.apikey')]);
        $details = json_decode($response->getBody(), true);
        $place_ids = [ ];
        $place_names = [ ];
        //$places = array( );
        for($i = 0; $i < count($details['results']); $i++){
            $place_ids[ ] = $details['results'][$i]['formatted_address'];
            $place_names[ ] = $details['results'][$i]['name'];
            //$places[ $details['results'][$i]['place_id'] ] = $details['results'][$i]['name'];
        }
        $places = array_map(null, $place_ids, $place_names);
        return view('/itineraries/select_third_destination')->with(['places' => $places, 'detail' => $detail]);
    }
    
  
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
     public function departure_area() //yahooAPI住所情報取得
    {

        $client = new \GuzzleHttp\Client();
        $method ='GET';

        $url = 'https://map.yahooapis.jp/geoapi/V1/reverseGeoCoder?output=json&lat=35.68381981&lon=139.77456498&appid=dj00aiZpPTdFUG05aUJVU3lRMSZzPWNvbnN1bWVyc2VjcmV0Jng9YTQ-';

        // リクエスト送信と返却データの取得
        // Bearerトークンにアクセストークンを指定して認証を行う
        $response = $client->request($method,$url);
        
        // API通信で取得したデータはjson形式なので
        // PHPファイルに対応した連想配列にデコードする
        $departure_area = json_decode($response->getBody(), true);
        
        //dd($departure_area);
       
        // index bladeに取得したデータを渡す
        return view('/itineraries/departure_area_nouken')->with(['place' => $departure_area['Feature'][0]['Property']['Address'],
        ]);
       
     }
     
     
     public function departure_place_map_embed(Request $request)
    {
        // .envのAPIキーを変数へ
        $api_key = config('app.api_key');
        $input_s = $request['search_name'];
        return view('/itineraries/departure_area_google_embed_map_api')->with(['search_name'=>$input_s, 'api_key'=>$api_key]);
    }
}
