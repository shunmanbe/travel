<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>旅のしおり</title>

        <!-- Fonts -->
        <link href="https:fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <!--ページトップリンク-->
        <link rel="stylesheet" type="text/css" href="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/reset.css">
        <!--アイコン表示-->
        <script src="https://kit.fontawesome.com/af4a7db726.js" crossorigin="anonymous"></script>
        <!--css読み込み-->
        <link rel="stylesheet" href="{{ asset('/css/contact.css') }}" >
        <link rel="stylesheet" href="{{ asset('/css/responsive/contact.css') }}" >
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
                <form action="/itineraries/contact/confirm" method="POST">
                    @csrf
                    <div class="mail-address">
                        <label>メールアドレス</label>
                        <br>
                        <input name="email" value="{{ old('email') }}" type="text">
                        @if ($errors->has('email'))
                            <p class="error-message">{{ $errors->first('email') }}</p>
                        @endif
                    </div>
                    <br>
                    <div class="title">
                        <label>タイトル</label>
                        <br>
                        <input name="title" value="{{ old('title') }}" type="text">
                        @if ($errors->has('title'))
                            <p class="error-message">{{ $errors->first('title') }}</p>
                        @endif
                    </div>
                    <br>
                    <div class="contact-form">
                        <label>お問い合わせ内容</label>
                        <br>
                        <textarea name="body">{{ old('body') }}</textarea>
                        @if ($errors->has('body'))
                            <p class="error-message">{{ $errors->first('body') }}</p>
                        @endif
                    </div>
                    <br>
                    <div class="center">
                        <button class="btn" type="submit">入力内容確認</button>
                    </div>
                    <br>
                </form>
            </div>
            <footer>
                <div class="footer-left"></div>
                <div class="copyright"><span>©︎2022 Shun Nakanishi</span></div>
                <div class="contact"><a href="/itineraries/contact/form">お問い合わせ</a></div>
            </footer>
        </div>
    </body>
</html>

