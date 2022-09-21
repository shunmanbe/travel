<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Place;
use App\Detail;

class PlaceController extends Controller
{
   
     
    public function departure_place(Detail $detail)//Google Maps Embed API
    {
        return view('/itineraries/departure_place'); 
    }
     
    public function departure_place_serach()
    {
        return view('/itineraries/departure_place_search');
    }
    
    public function departure_place_map_embed(Request $request)
    {
        // .envのAPIキーを変数へ
        $api_key = config('app.api_key');
        $input_s = $request['search_name'];
        return view('/itineraries/departure_area_google_embed_map_api')->with(['search_name'=>$input_s, 'api_key'=>$api_key]);
    }
    
    public function departure_place_map_places(Request $request)
    {
        $url = "https://maps.googleapis.com/maps/api/place/textsearch/json?key={{ config("services.google-map.apikey") }}&q={{ $search_name }}";
        $method = "GET";
        
        $client = new Client();
        $response = $client->request($method, $url);
        
        $railroutes = json_decode($response->getBody(), true);
       
        //return view('/itineraries/new_entry_railroute');
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
}
