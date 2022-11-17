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
        <link rel="stylesheet" href="{{ asset('/css/show.css') }}" >
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
                <div class="header-title"><h1><a href="/">旅のしおり</a></h1></div>
                <div class="header-right">
                    <ul>
                        <li><i class="fa-solid fa-user"></i> {{ $auth->name }}</li>
                        <li><a href="/itineraries/logout">ログアウト</a></li>
                    </ul>
                </div>
            </header>
            <div class="containers">
                <!--しおり名-->
                <div class="theme">
                    <h1>{{ $itinerary->title }}</h1>
                    <span>期間:{{ $itinerary->departure_date->format('Y年m月d日') }}→{{ $itinerary->arrival_date->format('Y年m月d日') }}</span>
                </div>
                <!--出発地-->
                <div class="departure">
                    <p class="name">出発地：{{ $itinerary->departure_place_name }}</p>
                </div>
                <!--目的地一覧-->
                <div class="destinations">
                    @if(empty($places))
                    @else
                        @foreach($places as $n => $place)
                            <div class="to-destination">
                                <!--三角形表示-->
                                <div class="triangles">
                                    <br>
                                    @for ($i=0; $i<3; $i++)
                                        <div class="triangle"></div>
                                        <br class="not-responsive">
                                    @endfor
                                </div>
                                <!--出発・到着時刻などの補足情報-->
                                <div class="supplement">
                                    <!--出発時刻表示-->
                                    <div class="departure-time">
                                        <p class="departure-time-empty departure-time-entered">出発時刻：{{ $place->departure_time }}</p>
                                    </div>
                                    <!--経路情報-->
                                    <div class="route">
                                        <form action="/itineraries/{{$itinerary->id}}/completed_others_route/{{$place->id}}" method="POST">
                                            @csrf
                                            <!--移動手段-->
                                            <p>移動手段：
                                                <select name="Mode">
                                                    <option value="WALKING">徒歩</option>
                                                    <!--<option value="TRANSIT">電車</option>-->
                                                    <option value="DRIVING">自動車</option>
                                                    <option value="BICYCLING">自転車</option>
                                                </select>
                                                <!--経路詳細表示ボタン-->
                                                <input class="btn-green" type="submit" name="route" value="経路詳細">
                                            </p>
                                            <!--出発地からの出発か、目的地からの出発かで場合分け-->
                                            @if($n+1 == 1)
                                                <!--出発地から出発の場合は出発地→目的地-->
                                                <!--出発地の名前・緯度・経度-->
                                                <input type="hidden" name="start_name" value="{{$itinerary->departure_place_name}}">
                                                <input type="hidden" name="start_lat" value="{{$itinerary->departure_place_lat}}">
                                                <input type="hidden" name="start_lng" value="{{$itinerary->departure_place_lng}}">
                                                <!--目的地の名前・緯度・経度-->
                                                <input type="hidden" name="goal_name" value="{{$places[$n]->name}}">
                                                <input type="hidden" name="goal_lat" value="{{$places[$n]->lat}}">
                                                <input type="hidden" name="goal_lng" value="{{$places[$n]->lng}}">
                                            @else
                                                <!--目的地からの出発の場合は目的地→目的地-->
                                                <!--出発地の名前・緯度・経度-->
                                                <input type="hidden" name="start_name" value="{{$places[$n-1]->name}}">
                                                <input type="hidden" name="start_lat" value="{{$places[$n-1]->lat}}">
                                                <input type="hidden" name="start_lng" value="{{$places[$n-1]->lng}}">
                                                <!--目的地の名前・緯度・経度-->
                                                <input type="hidden" name="goal_name" value="{{$places[$n]->name}}">
                                                <input type="hidden" name="goal_lat" value="{{$places[$n]->lat}}">
                                                <input type="hidden" name="goal_lng" value="{{$places[$n]->lng}}">
                                            @endif
                                        </form>
                                    </div>
                                    <!--到着時刻表示-->
                                    <div class="arrival-time"><p class="arrival-time-empty arrival-time-entered">到着時刻：{{$place->arrival_time }}</p></div>
                                </div>
                            </div>
                            <div class="destination">
                                <div class="name">目的地{{ $n + 1 }}:{{ $place->name }}
                                    <!--目的地メモ-->
                                    <!--メモアイコン-->
                                    <span class="open-memo"><i class="fa-regular fa-comment icon"></i></span>
                                    <!--メモモーダル-->
                                    <div class="memo-modal">
                                        <div class="modal-contents">
                                            <!--メモ閉じるボタン-->
                                            <div class="close-memo"><i class="fa fa-2x fa-times"></i></div>
                                            <!--メモ-->
                                            <div class="memo"><span>メモ</span></div>
                                            <!--メモ内容-->
                                            <div class="memo-body"><textarea readonly>{{$place->memo}}</textarea></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                        @endforeach
                    @endif
                </div>
                <div class="center">
                    <a class="btn-click" href ="/itineraries/others/index">他のユーザーのしおり一覧に戻る</a>
                </div>
            </div>
            <footer>
                <div class="footer-left"></div>
                <div class="copyright"><span>©︎2022 Shun Nakanishi</span></div>
                <div class="contact"><a href="/itineraries/contact/form">お問い合わせ</a></div>
            </footer>
            <script src="{{ asset('/js/alert.js') }}"></script>
            <script src="{{ asset('/js/memo-modal.js') }}"></script>
        </div>
    </body>
</html>
