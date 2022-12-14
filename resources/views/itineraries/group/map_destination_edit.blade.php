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
                <div class="header-title"><h1><a href="{{ route('index') }}">旅のしおり</a></h1></div>
                <div class="header-right">
                    <div class="setting-list-left"></div>
                    <div class="setting-icon open-setting"><i class="fa-solid fa-gear color-change"></i></div>
                    <div class="setting-list">
                        <ul>
                            <li class="setting-list-item"><span class="color-change"><i class="fa-solid fa-user"></i> {{ $auth->name }}</span></li>
                            <li class="setting-list-item"><a href="{{ route('logout') }}">ログアウト</a></li>
                            <li class="close-setting setting-list-item"><span class="color-change">閉じる</span></li>
                        </ul>
                    </div>
                </div>
                <div class="setting-background"></div>
            </header>
            <!--出発地を選択-->
            <div class ="containers">
                <h1>以下から目的地を<br class="responsive">選択してください</h1>
                <div class="place-index">
                    <ul>
                        @foreach ($place_detail_requireds as $i => $place_detail_required)
                            <li><a href="#{{$i}}">{{ $place_detail_required[0] }}</a></li>
                        @endforeach
                    </ul>
                </div>
                @foreach ($place_detail_requireds as $i => $place_detail_required)
                    <div class="container">
                        <form action="{{ route('group.destination_update', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id, 'groupPlace' => $groupPlace->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <!--検索候補地名表示-->
                            <h2 id="{{$i}}">{{$place_detail_required[0]}}</h2>
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
                            <input class="btn" type="submit" value="ここを目的地として保存する">
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
            <script src="{{ asset('/js/setting.js') }}"></script>
        </div>
    </body>
</html>

