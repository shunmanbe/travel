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
        <h1>しおり一覧</h1>
        <div class='itinerary'>
            @foreach($itineraries as $itinerary)
            <div class='itinerary'>
                <h2 class='title'><a href="/itineraries/{{ $itinerary->id }}">{{ $itinerary->title }}</a></h2>
            </div>
            @endforeach
            <a href="/itineraries/new_entry_date">新規作成</a>
        </div>
        @endsection
    </body>
</html>
