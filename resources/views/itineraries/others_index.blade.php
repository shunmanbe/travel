<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>旅のしおり</title>
        <!--アイコン表示-->
        <script src="https://kit.fontawesome.com/af4a7db726.js" crossorigin="anonymous"></script>
        <!--ページCSS-->
        <link rel="stylesheet" href="{{ asset('/css/index.css') }}" >
        <link rel="stylesheet" href="{{ asset('/css/responsive/index.css') }}" >
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
                <div class='itineraries'>
                    <h1>他のユーザーのしおり</h1>
                    <div class="index">
                        <div class="index-detail">
                            <!--しおり一覧を表示-->
                            @foreach($itineraries as $itinerary)
                                <div class="itinerary">
                                    <!--しおりタイトル-->
                                    <div class="theme"><h2><a href="{{ route('completed_others_show', ['itinerary' => $itinerary->id]) }}">{{ $itinerary->title }}</a></h2></div>
                                    <!--いいねボタン-->
                                        <span class="likes">
                                            <i class="fa-regular fa-heart like-toggle liked" data-itinerary-id="{{ $itinerary->id }}"></i>
                                            <!--いいねカウント-->
                                            <span class="like-counter">{{$itinerary->likes_count}}</span>
                                        </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="others"><a class="btn-click" href="/">自分のしおり一覧に戻る</a></div>
                <br>
            </div>
            <footer>
                <div class="footer-left"></div>
                <div class="copyright"><span>©︎2022 Shun Nakanishi</span></div>
                <div class="contact"><a href="{{ route('form') }}">お問い合わせ</a></div>
            </footer>
            <script src="{{ asset('/js/alert.js') }}"></script>
            <script src="{{ asset('/js/like.js') }}"></script>
            <script src="{{ asset('/js/setting.js') }}"></script>
        </div>
    </body>
</html>

        
        
       