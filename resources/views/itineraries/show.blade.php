<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Itinerary</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <style>
        #gmap 
        {
          height: 400px;
          width: 600px;
        }
        </style>
    </head>
    <body>
        @extends('layouts.app')
        @section('content')
        <h1>{{ $detail->title }}</h1>
        <a>期間:{{ $detail->departure_date->format('Y年m月d日') }}→{{ $detail->end_date->format('Y年m月d日') }}
        
        <p>出発地：{{ $detail->departure_place_name }}</p>
        
        @if(empty($places))
        @else
        @foreach($places as $n => $place)
        <form action="/itineraries/new_entry/date_store" method="POST">
            @csrf
            <select name="Mode">
                <option value="">移動手段を選択し、経路詳細を表示してください</option>
                <option value="DRIVING">自動車</option>
                <option value="TRANSIT">電車</option>
                <option value="WALKING">徒歩</option>
            </select>
        </form>
        <!--<a href="/itineraries/{{$detail->id}}/route">経路詳細</a>-->
        <div id="gmap"></div><!-- 地図を表示する領域 -->
        <input type="button" value="経路を表示" onclick="initMap()">
        <script>
            @if($n+1 == 1)
                var starts = @json($detail->departure_place_name);
                var ends =@json($places[$n]->destination_name);
                
            @else
                var starts =@json($places[$n]->destination_name);
                var ends =@json($places[$n-1]->destination_name);
            @endif
        
            
            
        </script>
        
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config("services.google-map.apikey") }}&callback=initMap" async defer></script>
        
        <p>移動時間：</p>
        <a>目的地{{ $n + 1 }}:{{ $place->destination_name }}
        <a href="/itineraries/{{$detail->id}}/edit/{{ $place->id }}">目的地を編集</a>
        
        
        <form action="/itineraries/{{ $detail->id }}/destinetion/{{ $place->id }}" method="post" style="display:inline">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="delete_alert(event);return false;">目的地を削除</button> 
        </form>
        <br>
        @endforeach
        @endif
        
        <a href ="/itineraries/{{$detail->id}}/destination_search">目的地を選択</a>
        <br>
        <a href ="/">しおり一覧に戻る</a>
        @endsection
        <script src="{{ asset('/js/alert.js') }}"></script>
        <script src="{{ asset('/js/map_route.js') }}"></script>
    </body>
</html>
