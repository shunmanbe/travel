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
            <!--//出発日を入力-->
            <a>出発日</a>
            <input type="date" name="date[depature_date]">
            <br>
            <a>到着日</a>
            <input type="date" name="date[end_date]">
            
            
            
            
            
            <!--<div class="depature">-->
            <!--    <a>出発日</a>-->
            <!--   <input type="date" name="date[depature_year]" placeholder="20◯◯">-->
            <!--   年-->
            <!--   <input type="integer" name="date[depature_month]" placeholder="◯◯">-->
            <!--   月-->
            <!--   <input type="integer" name="date[depature_day]" placeholder="◯◯">-->
            <!--   日-->
            <!--</div>-->
            <!--到着日を入力-->
            <!--<div class="end">-->
            <!--   <a>到着日</a> -->
            <!--   <input type="integer" name="date[end_year]" placeholder="20◯◯">-->
            <!--   年-->
            <!--   <input type="integer" name="date[end_month]" placeholder="◯◯">-->
            <!--   月-->
            <!--   <input type="integer" name="date[end_day]" placeholder="◯◯">-->
            <!--   日-->
            <!--   <input type="submit" value="日程を登録する">-->
            <!--</div>-->
        </form>
       
        @endsection
        
    </body>
</html>
