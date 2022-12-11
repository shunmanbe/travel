<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>旅のしおり</title>
        <!-- Fonts -->
        <link href="https:fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <!--アイコン表示-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.0/css/all.css">
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
        <!--ヘッダー-->
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
                    <h1>しおり一覧</h1>
                    <div class="index">
                        <div class="index-detail">
                            <!--しおり一覧を表示-->
                            @foreach($itineraries as $itinerary)
                                <div class="itinerary">
                                    <!--しおりタイトル-->
                                    <div class="theme">
                                        <h2><a href="{{ route('completed_show', ['itinerary' => $itinerary->id]) }}">{{ $itinerary->title }}</a></h2><span>{{ $itinerary->explanation }}</span>
                                    </div>
                                    <!--しおり概要編集-->
                                    <a href="{{ route('explanation', ['itinerary' => $itinerary->id]) }}"><i class="fa-solid fa-pen-to-square icon"></i>　</a>
                                    <!--削除ボタン-->
                                    <form action="{{ route('itinerary_delete', ['itinerary' => $itinerary->id]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="icon" type="submit" onClick="delete_alert(event);return false;"><i class="fa-solid fa-trash-can trash"></i></button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="btn">
                        <a class="new_entry" href="{{ route('new_entry') }}">新規作成</a>
                    </div>
                    <br>
                    <div class="display-group">
                        <a class="btn-click" href="{{ route('group.index_group') }}">グループ一覧</a>
                    </div>
                </div>
                <br>
                <div class="others">
                    <a  class="btn-click" href="{{ route('others_index') }}">他のユーザーが作成したしおりを見る</a>
                </div>
            </div>
            <br>
            <footer>
                <div class="footer-left"></div>
                <div class="copyright"><span>©︎2022 Shun Nakanishi</span></div>
                <div class="contact"><a href="{{ route('form') }}">お問い合わせ</a></div>
            </footer>
            <script src="{{ asset('/js/delete_alert.js') }}"></script>
            <script src="{{ asset('/js/loading.js') }}"></script>
            <script src="{{ asset('/js/setting.js') }}"></script>
        </div>
    </body>
</html>

        
        
       