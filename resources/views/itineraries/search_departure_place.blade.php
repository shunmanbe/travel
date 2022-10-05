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
        <form action="/itineraries/{{$detail->id}}/departure_place_map" method="POST">
            @csrf
            <input type="search_name" name="search_name" placeholder="例：東京 マック">
            <input type="submit" value="検索">
        </form>
        
        @endsection
       
    </body>
</html>
