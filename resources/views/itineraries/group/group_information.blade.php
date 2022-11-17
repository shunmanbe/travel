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
        <link rel="stylesheet" href="{{ asset('/css/group_information.css') }}" >
        <link rel="stylesheet" href="{{ asset('/css/responsive/group_information.css') }}" >
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
            <div class ="container containers">
                <div class="information-wrapper">
                    <div class="left"></div>
                    <div class="information">
                        <p>グループ名：{{ $group->name }}</p>
                        <p>グループID：{{ $group->group_id }}</p>
                        <p>パスワード：{{ $group->password }}</p>
                    </div>
                    <div class="right"></div>
                </div>
                <div class="information-free">
                    <p>その他情報</p>
                    <form action="{{ route('group.information_store', ['group' => $group->id]) }}" method="POST">
                    @csrf
                    <textarea name="information[information]" placeholder="グループ情報をメモしよう！">{{ $group->information }}</textarea>
                    <br>
                    <input class="btn-click" type=submit value="保存する">
                </div>
                <br>
            </div>
            <footer>
                <div class="footer-left"></div>
                <div class="copyright"><span>©︎2022 Shun Nakanishi</span></div>
                <div class="contact"><a href="/itineraries/contact/form">お問い合わせ</a></div>
            </footer>
        </div>
    </body>
</html>
