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
        <form action="/itineraries/new_entry/area" method="POST">
            @csrf
            <a>出発日</a> <!--//出発日を入力-->
               <input type="integer" name="depature_year" placeholder="20◯◯">
               年
               <input type="integer" name="depature_month" placeholder="◯◯">
               月
               <input type="integer" name="depature_day" placeholder="◯◯">
               日
            
             <a>到着日</a> //到着日を入力
               <input type="integer" name="end_year" placeholder="20◯◯">
               年
               <input type="integer" name="end_month" placeholder="◯◯">
               月
               <input type="integer" name="end_day" placeholder="◯◯">
               日
               <input type="submit" value="日程を登録する">
       </form>
       
        @endsection
        
    </body>
</html>
