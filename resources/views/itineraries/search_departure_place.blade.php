<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Itinerary</title>

        <!-- Fonts -->
        <link href="https:fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('/css/search_departure.css')  }}" >
      
    </head>
    <body>
        @extends('layouts.app')
        @section('content')
        <!--出発地を選択-->
        <div class ="select">
            <h1>出発する地域を検索</h1> 
            <form action="/itineraries/{{$detail->id}}/departure_place_map" method="POST">
                @csrf
                <input type="text" name="search_name" placeholder="例：東京 マック"　value="{{ old('search_name') }}">
                <p class="serch_name__error" style="color:red">{{ $errors->first('search_name') }}</p>
                <input type="submit" value="検索">
            </form>
        </div>
        @endsection
       
    </body>
</html>
