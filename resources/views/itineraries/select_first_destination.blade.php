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
        @foreach ($places as $place)
        <form action="/itineraries/{{ $detail->id }}/first_destination_store" method="POST">
            @csrf
            <h2>{{$place[1]}}</h2>
            <input type="hidden" name="first[first_destination_address]" value={{$place[0]}}>
            <input type="hidden" name="first[first_destination_name]" value={{$place[1]}}>
            <p><input type="submit" value="ここを目的地として保存する"></p>
            <iframe id='map' src='https://www.google.com/maps/embed/v1/place?key={{ config("services.google-map.apikey") }}&q={{ $place[1] }}'
            width='50%' height='300' frameborder='0'></iframe>
        </form>
        @endforeach
        @endsection
       
    </body>
</html>
