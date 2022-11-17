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
        <link rel="stylesheet" href="{{ asset('/css/responsive/map.css') }}" >
        <!--header-->
        <link rel="stylesheet" href="{{ asset('/css/header.css') }}" >
        <link rel="stylesheet" href="{{ asset('/css/responsive/header.css') }}" >
        <!--footer-->
        <link rel="stylesheet" href="{{ asset('/css/footer.css') }}" >
        <link rel="stylesheet" href="{{ asset('/css/responsive/footer.css') }}" >
    </head>
    <body>
        <div class="wrapper">
            <header>
                <div class="header-left not-responsive"></div>
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
                <h1>以下から目的地を<br class="responsive">選択してください</h1> 
                @foreach ($place_detail_requireds as $place_detail_required)
                    <div class="container">
                        <form action="{{ route('group.destination_store', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id]) }}" method="POST">
                            @csrf
                            <!--検索候補地名表示-->
                            <h2>{{$place_detail_required[0]}}</h2>
                            <!--候補地の名前-->
                            <input type="hidden" name="destination[name]" value="{{$place_detail_required[0]}}">
                            <!--候補地の住所-->
                            <input type="hidden" name="destination[address]" value="{{$place_detail_required[1]}}">
                            <!--候補地の緯度-->
                            <input type="hidden" name="destination[lat]" value="{{$place_detail_required[2]}}">
                            <!--候補地の経度-->
                            <input type="hidden" name="destination[lng]" value="{{$place_detail_required[3]}}">
                            <!--候補地が属するしおりのid-->
                            <input type="hidden" name="destination[share_itinerary_id]" value="{{$shareItinerary->id}}">
                            <!--保存ボタン-->
                            <input class="btn-orange" type="submit" value="ここを目的地として保存する">
                            <br>
                            <br>
                            <!--地図を表示-->
                            <!--GoogleMapsEmbedAPI-->
                            <iframe id='map' src='https://www.google.com/maps/embed/v1/place?key={{ config("services.google-map.apikey") }}&q={{$place_detail_required[2]}},{{$place_detail_required[3]}}'
                            width='50%' height='300' frameborder='0'></iframe>
                    </form>
                </div>
                @endforeach
            </div>
            <footer>
                <div class="footer-left"></div>
                <div class="copyright"><span>©︎2022 Shun Nakanishi</span></div>
                <div class="contact"><a href="/itineraries/contact/form">お問い合わせ</a></div>
            </footer>
        </div>
    </body>
</html>

