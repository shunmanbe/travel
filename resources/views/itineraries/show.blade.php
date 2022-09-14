<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Itinerary</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

      
    </head>
    <body>
        @extends('layouts.app')
        @section('content')
        <a>期間:{{ $detail->departure_date->format('Y年m月d日') }}→{{ $detail->end_date->format('Y年m月d日') }}
        
        <a>出発地</a>
       
        @endsection
        
    </body>
</html>
