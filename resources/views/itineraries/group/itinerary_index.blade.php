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
                <div class='itineraries'>
                    <h1>グループのしおり一覧</h1>
                    <div class="index">
                        <div class="index-detail">
                            <!--しおり一覧を表示-->
                            @foreach($shareItineraries as $shareItinerary)
                                <div class="itinerary">
                                    <!--しおりタイトル-->
                                    <div class="theme">
                                        <h2><a href="{{ route('group.completed_show', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id ]) }}">{{ $shareItinerary->title }}</a></h2><span>{{ $shareItinerary->explanation }}</span>
                                    </div>
                                    <!--しおり概要編集-->
                                    <a href="{{ route('group.explanation', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id]) }}"><i class="fa-solid fa-pen-to-square icon"></i>　</a>
                                    <!--削除ボタン-->
                                    <form action="{{ route('group.itinerary_delete',['group' => $group->id, 'shareItinerary' => $shareItinerary->id] ) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="icon group-trash" type="submit" onClick="delete_alert(event);return false;"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="btn">
                        <a class="new_entry" href="{{ route('group.new_entry', ['group' => $group->id]) }}">しおりを作成</a>
                    </div>
                    
                </div>
                <br>
                <br>
                <div class="others">
                    <a  class="btn-click" href="{{ route('group.index_group')}}">グループ一覧に戻る</a>
                </div>
                <br>
            </div>
            <footer>
                <div class="footer-left"></div>
                <div class="copyright"><span>©︎2022 Shun Nakanishi</span></div>
                <div class="contact"><a href="/itineraries/contact/form">お問い合わせ</a></div>
            </footer>
            <script src="{{ asset('/js/delete_alert.js') }}"></script>
        </div>
    </body>
</html>

        
        
       