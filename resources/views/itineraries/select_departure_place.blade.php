<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Itinerary</title>

        <!-- Fonts -->
        <link href="https:fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('/css/select_departure.css')  }}" >
      
    </head>
    <body>
        @extends('layouts.app')
        @section('content')
        <!--出発地を選択-->
        <div class ="select_departure">
            <h1>以下から出発地を選択してください</h1> 
            @foreach ($place_details as $place_detail)
                <form action="/itineraries/{{ $detail->id }}/departure_place_store" method="POST">
                    @csrf
                    <h2>{{$place_detail[1]}}</h2>
                    <input type="hidden" name="departure[departure_place_address]" value={{$place_detail[0]}}>
                    <input type="hidden" name="departure[departure_place_name]" value={{$place_detail[1]}}>
                    <input type="hidden" name="departure[detail_id]" value={{$detail->id}}>
                    <p><input type="submit" value="ここを出発地として保存する"></p>
                    <iframe id='map' src='https://www.google.com/maps/embed/v1/place?key={{ config("services.google-map.apikey") }}&q={{ $place_detail[1] }}'
                    width='50%' height='300' frameborder='0'></iframe>
                </form>
            @endforeach
        </div>
        @endsection
       
    </body>
</html>
