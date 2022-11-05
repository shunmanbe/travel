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
        <!--loading-->
        <link rel="stylesheet" href="{{ asset('/css/loading.css') }}" >
        <!--header-->
        <link rel="stylesheet" href="{{ asset('/css/header.css') }}" >
        <link rel="stylesheet" href="{{ asset('/css/responsive/header.css') }}" >
        <!--footer-->
        <link rel="stylesheet" href="{{ asset('/css/footer.css') }}" >
        <link rel="stylesheet" href="{{ asset('/css/responsive/footer.css') }}" >
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
        <div class="container">
            <div class='itineraries'>
                <h1>他のユーザーのしおり</h1>
                <div class="index">
                    <div class="index-detail">
                        <!--しおり一覧を表示-->
                        @foreach($itineraries as $itinerary)
                            <div class="itinerary">
                                <!--しおりタイトル-->
                                <div class="theme"><h2><a href="/itineraries/{{ $itinerary->id }}/completed/others/show">{{ $itinerary->title }}</a></h2></div>
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
            <div class="others"><a href="/">自分のしおり一覧に戻る</a></div>
        </div>
        <footer>
            <div class="footer-wrapper">
                <div class="copyright"><span>©︎2022 Shun Nakanishi</span></div>
                <ul>
                    <li><a href="/itineraries/contact/form">お問い合わせ</a></li>
                </ul>
            </div>
        </footer>
        <script src="{{ asset('/js/alert.js') }}"></script>
        <script src="{{ asset('/js/like.js') }}"></script>
    </body>
</html>

        
        
       