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
        <link rel="stylesheet" href="{{ asset('/css/memo.css') }}" >
        <link rel="stylesheet" href="{{ asset('/css/responsive/memo.css') }}" >
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
                <!--メモの地名表示-->
                <h2>{{$shareItinerary->departure_place_name}}</h2>
                <!--メモ入力欄-->
                <form action="{{ route('group.memo_departure_store', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id]) }}" method="POST">
                    @csrf
                    <textarea name="memo[memo]" placeholder="必要なことはここにメモをしておこう！">{{ $shareItinerary->memo }}</textarea>
                    <br>
                    <!--保存ボタン-->
                    <input class="btn-green" type="submit" value="保存して詳細ページへ">
                </form>
            </div>
            <footer>
                <div class="footer-left"></div>
                <div class="copyright"><span>©︎2022 Shun Nakanishi</span></div>
                <div class="contact"><a href="{{ route('form') }}">お問い合わせ</a></div>
            </footer>
            <script src="{{ asset('/js/setting.js') }}"></script>
        </div>
    </body>
</html>
