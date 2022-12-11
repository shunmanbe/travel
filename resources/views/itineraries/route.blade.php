<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>旅のしおり</title></title>

        <!-- Fonts -->
        <link href="https:fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        </style>
        <!--アイコン表示-->
        <script src="https://kit.fontawesome.com/af4a7db726.js" crossorigin="anonymous"></script>
        <!--CSS-->
        <link rel="stylesheet" href="{{ asset('/css/route.css') }}" >
        <link rel="stylesheet" href="{{ asset('/css/responsive/route.css') }}" >
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
            <div class="container containers">
                <div class="title">
                    <h1><span class="not-responsive">経路：</span>{{$start_name}}（A）<span class="not-responsive">→</span><br class="responsive"><span class="responsive">↓</span>{{$goal_name}}（B）</h1>
                </div>
                <!-- 地図を表示する領域 -->
                <div id="gmap"></div>
                <p class="route-time"></p>
                <p>距離：{{$distance}}</p>
                <p>時間：{{$duration_ja}}（自動車移動の時）</p>
                <p>地図がうまく表示されない場合は<br class="responsive">リロードしてください</p>
                <a class="btn-click" href="{{ route('edit_show', ['itinerary' => $itinerary->id]) }}">戻る</a>
            </div>
            <br>
            <footer>
                <div class="footer-left"></div>
                <div class="copyright"><span>©︎2022 Shun Nakanishi</span></div>
                <div class="contact"><a href="{{ route('form') }}">お問い合わせ</a></div>
            </footer>
            <script>
                // 地図表示に使う変数
                var start_name = '{{$start_name}}';
                var goal_name = '{{$goal_name}}';
                var travel = '{{$mode}}';
            </script>
            <!--apiを呼び出すときにcallback関数でinitMapを呼び出している-->
            <script src="https://maps.googleapis.com/maps/api/js?key={{ config("services.google-map.apikey") }}&callback=initMap" async defer></script>
            <script src="{{ asset('/js/map_route.js') }}"></script>
            <script src="{{ asset('/js/setting.js') }}"></script>
        </div>
    </body>
</html>