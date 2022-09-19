<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Itinerary</title>

        <!-- Fonts -->
        <link href="https:fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

      
    </head>
    <body>
        @extends('layouts.app')
        @section('content')
        <!--出発地を選択-->
        <h1>出発する地域を検索</h1> 
        <form action="/itineraries/departure_place_map" method="POST">
            @csrf
            <input type="search_name" name="search_name" placeholder="例：東京 マック">
            <input type="submit" value="検索">
        </form>
        
        @endsection
        <script>
        //吹き出し（情報ウィンドウ）作成
            const infoWindow = new google.maps.InfoWindow({
              position: map.getCenter(),
              content: `<div class="custom-info">
                <div class="custom-info-item name">
                Tips
                </div>
                <div class="custom-info-item address">
                東京都ほげ
                </div>
                <div class="custom-info-item tel">
                <a href="tel:000-0000-0000">000-0000-0000</a>
                </div>
                <div class="custom-info-item google-map">
                <a href="https://goo.gl/maps/qytx6qv2aGp2Xg8G8" target="_blank">MAP</a>
                </div>
            </div>`,
              pixelOffset: new google.maps.Size(0, -50)
            })
             //マーカーをクリックしたら情報ウィンドウを開く
            marker.addListener('click', () => {
              infoWindow.open(map);
            });
        </script>
    </body>
</html>
