<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>旅のしおり</title>
        <!-- Fonts -->
        <link href="https:fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <!--アイコン表示-->
        <!--<script src="https://kit.fontawesome.com/af4a7db726.js" crossorigin="anonymous"></script>-->
        <!--<script defer src="https://use.fontawesome.com/releases/v6.2.0/js/all.js"></script>-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.0/css/all.css">
        <!--ページCSS-->
        <link rel="stylesheet" href="{{ asset('/css/index.css') }}" >
        <link rel="stylesheet" href="{{ asset('/css/responsive/index.css') }}" >
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
                <div class='groups'>
                    <h1>グループ一覧</h1>
                    <div class="index">
                        <div class="index-detail">
                            <!--しおり一覧を表示-->
                            @foreach($groups as $group)
                                <div class="group">
                                    <!--グループ名-->
                                    <div class="group-name">
                                        <h2><a href="{{ route('group.itinerary_index', ['group' => $group->id]) }}">{{ $group->name }}</a></h2>
                                    </div>
                                    <!--グループ詳細画面へ-->
                                    <a href="{{ route('group.group_information', ['group' => $group->id]) }}"><i class="fa-solid fa-circle-info icon"></i>　</a>
                                    <!--グループを抜ける-->
                                    <form action="{{ route('group.escape', ['group' => $group->id]) }}" method="post">
                                        @csrf
                                        <button class="btn icon" type="submit" onClick="escape_alert(event);return false;"><i class="fa-solid fa-person-running"></i></button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="btn">
                        <a class="new_entry" href="{{ route('group.create_group') }}">グループを作成</a>
                    </div>
                    <br>
                    <div class="search-group">
                        <a class="btn-click" href="{{ route('group.search_group') }}">グループを検索する</a>
                    </div>
                    
                </div>
                <br>
                <br>
                <div class="own">
                    <a  class="btn-click" href="{{ route('index') }}">自分のしおり一覧に戻る</a>
                </div>
                <br>
            </div>
            <footer>
                <div class="footer-left"></div>
                <div class="copyright"><span>©︎2022 Shun Nakanishi</span></div>
                <div class="contact"><a href="/itineraries/contact/form">お問い合わせ</a></div>
            </footer>
            <script src="{{ asset('/js/escape_alert.js') }}"></script>
        </div>
    </body>
</html>

        
        
       