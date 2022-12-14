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
        <link rel="stylesheet" href="{{ asset('/css/title_date.css') }}" >
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
            <div class = "container containers">
                <form name="date_store" action="{{ route('update_new_entry', ['itinerary' => $itinerary->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <span>旅行タイトル</span>
                    <br>
                    <!--old関数の第一引数は入力した値、第二引数は第一引数がなかった場合に入力される値（今回はもともと入力されていた値）-->
                    <!--旅行タイトル入力欄-->
                    <input id="title" type="text" name="initial_setting[title]" value="{{ old('initial_setting.title', $itinerary->title) }}"> 
                    <br>
                    <br>
                    <span>期間</span>
                    <br>
                    <br class="responsive">
                    <!--出発日入力欄-->
                    <input id="departure-day" type="date" name="initial_setting[departure_date]" value="{{ old('initial_setting.departure_date', $itinerary->departure_date->format('Y-m-d') )}}">
                    <br>
                    
                    <span>↓</span>
                    <br>
                    <br class="responsive">
                    <!--到着日入力欄-->
                    <input id="arrival-day" type="date" name="initial_setting[arrival_date]" value="{{ old('initial_setting.arrival_date', $itinerary->arrival_date->format('Y-m-d') )}}">
                    <br>
                    
                    <!--「次へ」ボタン-->
                    <input class ="btn-orange" type="submit" value="更新" onclick="checkNewEntry(event);return false;">
                </form>
            </div>
            <footer>
                <div class="footer-left"></div>
                <div class="copyright"><span>©︎2022 Shun Nakanishi</span></div>
                <div class="contact"><a href="{{ route('form') }}">お問い合わせ</a></div>
            </footer>
            <script src="{{ asset('/js/validation.js') }}"></script>
            <script src="{{ asset('/js/setting.js') }}"></script>
        </div>
    </body>
</html>
