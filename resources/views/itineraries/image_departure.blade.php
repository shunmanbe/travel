<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>旅のしおり</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <!--アイコン表示-->
        <script src="https://kit.fontawesome.com/af4a7db726.js" crossorigin="anonymous"></script>
        <!--ページCSS-->
        <link rel="stylesheet" href="{{ asset('/css/image.css') }}" >
        <link rel="stylesheet" href="{{ asset('/css/responsive/show.css') }}" >
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
                    <ul>
                        <li><i class="fa-solid fa-user"></i> {{ $auth->name }}</li>
                        <li><a href="{{ route('logout') }}">ログアウト</a></li>
                    </ul>
                </div>
            </header>
            <div class="containers">
                <!--しおり名-->
                <div class="theme">
                    <h1>{{ $itinerary->title }}</h1>
                    <span>期間：{{ $itinerary->departure_date->format('Y年m月d日') }}→{{ $itinerary->arrival_date->format('Y年m月d日') }}</span>
                </div>
                <!--出発地-->
                <div class="departure">
                    <div class="name">出発地：{{ $itinerary->departure_place_name }}
                    </div>
                </div>
                <div class="image-class">
                <br>
                <!--写真投稿-->
                <form action="{{ route('image', ['itinerary' => $itinerary->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- アップロードフォームの作成 -->
                    <input type="file" name="image">
                    <input type="submit" value="アップロード">
                </form>
                <div class="images">
                    <img class="image" src="{{ $itinerary->image_path }}">
                </div>
                </div>
                <div class="center">
                    <a class="btn-click" href ="{{ route('edit_show', ['itinerary' => $itinerary->id]) }}">しおりを編集する</a>
                    <br>
                    <a class="btn-click" href ="/">しおり一覧に戻る</a>
                </div>
            </div>
            <footer>
                <div class="footer-left"></div>
                <div class="copyright"><span>©︎2022 Shun Nakanishi</span></div>
                <div class="contact"><a href="{{ route('form') }}">お問い合わせ</a></div>
            </footer>
            <script src="{{ asset('/js/memo-modal.js') }}"></script>
            <script src="{{ asset('/js/memo-accordion.js') }}"></script>
        </div>
    </body>
</html>