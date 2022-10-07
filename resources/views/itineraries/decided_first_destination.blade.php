<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Itinerary</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

      
    </head>
    <body>
        @extends('layouts.app')
        @section('content')
        <h2>期間:{{ $detail->departure_date->format('Y年m月d日') }}→{{ $detail->end_date->format('Y年m月d日') }}</h2>
        
        <h3>出発地：{{ $detail->departure_place_name }}</h3>
        <form action="/itineraries/new_entry/date_store" method="POST">
        @csrf
            <select name="Mode">
                <option value="">移動手段を選択し、経路詳細を表示してください</option>
                <option value="DRIVING">自動車</option>
                <option value="TRANSIT">電車</option>
                <option value="WALKING">徒歩</option>
            </select>
        </form>
        <a href="/itineraries/{{$detail->id}}/route_to_first_destination">経路詳細</a>
        <p>移動時間：</p>
        
        <h3>目的地1：{{ $detail->first_destination_name }}</h3>
        
        <a href ="/itineraries/{{$detail->id}}/second_destination_search">目的地を追加</a>
       
        @endsection
        
    </body>
</html>
