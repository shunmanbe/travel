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
        <p>出発地する地域を選択</p> 
        <select　name="area">
            @csrf
            <option value="未選択">選択してください</option>
            @foreach($areas as $area)
            <option value="id">{{$area->name}}</option>
            @endforeach
        </select>
        
        <a href="/itineraries/new_entry/prefecture/{{$area->id}}">次へ</a>
       
        @endsection
        
    </body>
</html>
