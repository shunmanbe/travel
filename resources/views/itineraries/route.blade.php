<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Itinerary</title>

        <!-- Fonts -->
        <link href="https:fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <style>
            #gmap 
            {
              height: 400px;
              width: 600px;
            }
        </style>
        <!--アイコン表示-->
        <script src="https://kit.fontawesome.com/af4a7db726.js" crossorigin="anonymous"></script>
        <!--ヘッダー-->
        <link rel="stylesheet" href="{{ asset('/css/header.css')  }}" >
    </head>
    <body>
        <header>
            <div class="header-title"><h1>旅のしおり</h1></div>
            <div class="header-right">
                <ul>
                    <li>{{ $auth->name }}</li>
                    <li><a href="/itineraries/logout">ログアウト</a></li>
                </ul>
            </div>
        </header>
        <div class="container">
            <div id="gmap"></div><!-- 地図を表示する領域 -->
            <input type="button" value="経路を表示" onclick="initMap()">
            <script>
                var starts = '{{$start}}';
                var ends = '{{$end}}';
                var travel = '{{$mode}}';
            </script>
        </div>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config("services.google-map.apikey") }}&callback=initMap" async defer></script>
        <script src="{{ asset('/js/map_route.js') }}"></script>
    </body>
</html>