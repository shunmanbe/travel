<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>旅のしおり</title>
        <!-- Fonts -->
        <link href="https:fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <!--アイコン表示-->
        <script src="https://kit.fontawesome.com/af4a7db726.js" crossorigin="anonymous"></script>
        <!--ページCSS-->
        <link rel="stylesheet" href="{{ asset('/css/map.css') }}" >
        <!--header-->
        <link rel="stylesheet" href="{{ asset('/css/header.css') }}" >
        <!--footer-->
        <link rel="stylesheet" href="{{ asset('/css/footer.css') }}" >
    </head>
    <body>
        <header>
            <div class="header-title"><h1><a href="/">旅のしおり</a></h1></div>
            <div class="header-right">
                <ul>
                    <li><i class="fa-solid fa-user"></i> {{ $auth->name }}</li>
                    <li><a href="/itineraries/logout">ログアウト</a></li>
                </ul>
            </div>
        </header>
        <!--出発地を選択-->
        <div class ="containers">
            <h1>以下から目的地を選択してください</h1> 
            @foreach ($place_details as $place_addresses => $place_names)
                <div class="container">
                    <form action="/itineraries/{{ $itinerary->id }}/destination_update/{{ $place->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!--検索候補地名表示-->
                        <h2>{{$place_names}}</h2>
                        <!--候補地の住所-->
                        <input type="hidden" name="destination[destination_address]" value="{{$place_addresses}}">
                        <!--候補地名-->
                        <input type="hidden" name="destination[destination_name]" value="{{$place_names}}">
                        <!--候補地のdetail_id-->
                        <input type="hidden" name="destination[itinerary_id]" value="{{$itinerary->id}}">
                        <!--保存ボタン-->
                        <input class="btn" type="submit" value="ここを目的地として保存する">
                        <br>
                        <br>
                        <!--地図を表示-->
                        <!--GoogleMapsEmbedAPI-->
                        <iframe id='map' src='https://www.google.com/maps/embed/v1/place?key={{ config("services.google-map.apikey") }}&q={{ $place_names }}'
                        width='50%' height='300' frameborder='0'></iframe>
                    </form>
                </div>
            @endforeach
        </div>
        <footer>
            <div class="footer-wrapper">
                <div class="copyright"><span>©︎2022 Shun Nakanishi</span></div>
                <ul>
                    <li><a href="/itineraries/contact/form">お問い合わせ</a></li>
                </ul>
            </div>
        </footer>
    </body>
</html>

