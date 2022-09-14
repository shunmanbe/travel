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
        <form action="/itineraries/new_entry/date_store" method="POST">
            @csrf
            <!--//出発日を入力-->
            <a>出発日</a>
            <input type="date" name="date[departure_date]">
            <br>
            <a>到着日</a>
            <input type="date" name="date[end_date]">
            
            <input type="submit" value="次へ">
        </form>
       
        @endsection
       
        
    </body>
</html>