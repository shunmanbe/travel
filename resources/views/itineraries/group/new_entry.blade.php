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
        <link rel="stylesheet" href="{{ asset('/css/responsive/title_date.css') }}" >
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
            <div class="container containers">
                <div class = "date_select">
                    <form name="date_store" action="{{ route('group.date_store', ['group' => $group->id]) }}" method="POST">
                        @csrf
                        <span>旅行タイトル</span>
                        <br>
                        <!--旅行タイトル入力欄-->
                        <input id="title" type="text" name="initial_setting[title]" value="{{ old('initial_setting.title') }}">
                        <br>
                        <br>
                        <span>期間</span>
                        <br>
                        <br class="responsive">
                        <!--出発日入力欄-->
                        <input id="departure-day" type="date" name="initial_setting[departure_date]" value="{{ old('initial_setting.departure_date') }}">
                        <br>
                        
                        <span>↓</span>
                        <br>
                        <br class="responsive">
                        <!--到着日入力欄-->
                        <input id="arrival-day" type="date" name="initial_setting[arrival_date]" value="{{ old('initial_setting.arrival_date') }}">
                        <br>
                        
                        <!--「次へ」ボタン-->
                        <input class ="btn-orange" type="submit" value="次へ" onclick="check_new_entry(event);return false;">
                    </form>
                </div>
            </div>
            <footer>
                <div class="footer-left"></div>
                <div class="copyright"><span>©︎2022 Shun Nakanishi</span></div>
                <div class="contact"><a href="/itineraries/contact/form">お問い合わせ</a></div>
            </footer>
            <script src="{{ asset('/js/validation.js') }}"></script>
        </div>
    </body>
</html>
