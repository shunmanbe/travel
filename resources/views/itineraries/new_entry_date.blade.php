<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Itinerary</title>

        <!-- Fonts -->
        <link href="https:fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('/css/departure_date.css')  }}" >
      
    </head>
    <body>
        @extends('layouts.app')
        @section('content')
        <div class = "date_select">
            <form action="/itineraries/new_entry/date_store" method="POST">
                @csrf
                <!--//出発日を入力-->
                <a>旅行タイトル</a>
                <br>
                <input type="text" name="initial_setting[title]">
                <br>
                <br>
                <a>出発日</a>
                <input type="date" name="initial_setting[departure_date]">
                <br>
                <br>
                <a>到着日</a>
                <input type="date" name="initial_setting[end_date]">
                <br>
                <br>
                <br>
                    <input class ="btn" type="submit" value="次へ">
            </form>
        </div>
        @endsection
       
        
    </body>
</html>
