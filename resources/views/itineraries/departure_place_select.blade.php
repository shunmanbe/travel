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
        <h1>以下から出発地を選択してください</h1> 
        <form action="/itineraries/departure_place_map" method="POST">
            @csrf
            
            @foreach ($places as $place)
            <h2>{{$place[1]}}</h2>
            <iframe id='map' src='https://www.google.com/maps/embed/v1/place?key={{ config("services.google-map-places.apikey") }}&q={{ $place[1] }}'
            width='50%' height='300' frameborder='0'></iframe>
            
            @endforeach
            
            
        </form>
        
        @endsection
       
    </body>
</html>
