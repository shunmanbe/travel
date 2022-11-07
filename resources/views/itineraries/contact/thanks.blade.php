<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>旅のしおり</title>

        <!-- Fonts -->
        <link href="https:fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('/css/map_departure_place.css')  }}" >
        <!--ページトップリンク-->
        <link rel="stylesheet" type="text/css" href="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/reset.css">
        <!--css読み込み-->
        <link rel="stylesheet" href="{{ asset('/css/contact.css')  }}" >
        <!--アイコン表示-->
        <script src="https://kit.fontawesome.com/af4a7db726.js" crossorigin="anonymous"></script>
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
        <div class="container-thanks">
            <span>送信が完了しました。</span>
            <br>
            <br>
            <span>お問い合わせありがとうございました。</span>
            <br>
            <span>送信内容をメールでお送りします。<br class="responsive">少し時間をおいてからご確認ください。</span>
            <br>
            <br>
            <a class="btn to-index" href="/">しおり一覧へ</a>
            <br>
            <br>
            <span class="warning">このページでリロード・戻るボタンを<br class="responsive">押さないでください</span>
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

