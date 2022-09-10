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
        <!--都道府県を選択-->
        <p>都道府県を選択</p> 
        <form action="/itineraries/new_entry/prefecture_store" method="POST">
            @csrf
            <select　name="prefecture">
                <option value="未選択">選択してください</option>
                @foreach($prefectures as $prefecture)
                <option value="prefecture_name">{{$prefecture->name}}</option>
                @endforeach
            </select>
            <input type="submit" value="登録">
       </form>
        @endsection
        
    </body>
</html>
