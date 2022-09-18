<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Place;

class PlaceController extends Controller
{
     public function departure_area(Place $place)
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
