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
            <form action="/itineraries/contact/thanks" method="POST">
                @csrf
                <label>メールアドレス</label>
                <br>
                <input value="{{ $inputs['email'] }}" readonly>
                <input name="email" value="{{ $inputs['email'] }}" type="hidden">
                <br>
                <br>
                <label>タイトル</label>
                <br>
                <input value="{{ $inputs['title'] }}" readonly>
                <input name="title" value="{{ $inputs['title'] }}" type="hidden">
                <br>
                <br>
                <label>お問い合わせ内容</label>
                <br>
                <textarea readonly>{{$inputs['body']}}</textarea>
                
                <input name="body" value="{{ $inputs['body'] }}" type="hidden">
                <br>
                <br>
                <div class="center">
                    <button class="modify" type="submit" name="action" value="back">入力内容修正</button>
                    <br>
                    <br>
                    <button class="btn" type="submit" name="action" value="submit">送信する</button>
                </div>
            </form>
        </div>
        <footer>
            <div class="footer-wrapper">
                <div class="copyright"><span>©︎2022 Shun Nakanishi</span></div>
                <div class="contact">
                    <ul>
                        <li><a href="/itineraries/contact/form">お問い合わせ</a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </body>
</html>

