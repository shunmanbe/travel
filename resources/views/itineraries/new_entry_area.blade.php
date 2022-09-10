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
        <form action="/itineraries/new_entry/area_store" method="POST">
            @csrf
            <select　name="area">
                <option value="未選択">選択してください</option>
                @foreach($areas as $area)
                    <option value="area_name">{{$area->area_name}}</option>
                @endforeach
            </select>
        </form>
        <input type="submit" value="次へ">
       
        @endsection
        
    </body>
</html>
