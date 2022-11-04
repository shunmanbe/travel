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
        <!--モーダル用jQuery読み込み-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <!--ページCSS-->
        <link rel="stylesheet" href="{{ asset('/css/show.css') }}" >
        <!--header-->
        <link rel="stylesheet" href="{{ asset('/css/header.css') }}" >
        <!--footer-->
        <link rel="stylesheet" href="{{ asset('/css/footer.css') }}" >
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
                    <p>出発時刻：</p>
                @else
                    @foreach($places as $n => $place)
                        <div class="to_destination">
                            <!--三角形表示-->
                            <div class="triangles">
                                @for ($i=0; $i<3; $i++)
                                    <br>
                                    <div class="triangle"></div>
                                    <br>
                                @endfor
                            </div>
                            <!--出発・到着時刻などの補足情報-->
                            <div class="supplement">
                                <!--出発時刻表示-->
                                <div class="departure_time">
                                    <p>出発時刻：{{ $place->departure_time }}</p>
                                </div>
                                <!--経路情報-->
                                <div class="route">
                                    <form action="/itineraries/{{$itinerary->id}}/completed_route/{{$place->id}}" method="POST">
                                        @csrf
                                        <!--移動手段選択肢-->
                                        <select name="Mode">
                                            <option value="">移動手段を選択</option>
                                            <!--<option value="TRANSIT">電車</option>-->
                                            <option value="DRIVING">自動車</option>
                                            <option value="BICYCLING">自転車</option>
                                            <option value="WALKING">徒歩</option>
                                        </select>
                                        <!--エラーメッセージ-->
                                        <p class="error-message">{{ $errors->first('Mode') }}</p>
                                        <!--経路詳細表示ボタン-->
                                        <input class="btn" type="submit" name="route" value="経路詳細">
                                        <!--出発地からの出発か、目的地からの出発かで場合分け-->
                                        @if($n+1 == 1)
                                            <!--出発地から出発の場合は出発地→目的地-->
                                            <input type="hidden" name="start_name" value={{$itinerary->departure_place_name}}>
                                            <input type="hidden" name="start_address" value={{$itinerary->departure_place_address}}>
                                            <input type="hidden" name="goal_name" value={{$places[$n]->name}}>
                                            <input type="hidden" name="goal_address" value={{$places[$n]->address}}>
                                        @else
                                            <!--目的地からの出発の場合は目的地→目的地-->
                                            <input type="hidden" name="start_name" value={{$places[$n-1]->name}}>
                                            <input type="hidden" name="start_address" value={{$places[$n-1]->address}}>
                                            <input type="hidden" name="goal_name" value={{$places[$n]->name}}>
                                            <input type="hidden" name="goal_address" value={{$places[$n]->address}}>
                                        @endif
                                    </form>
                                </div>
                                <!--到着時刻表示-->
                                <div class="arrival"><p>到着時刻：{{$place->arrival_time }}</p></div>
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
                <a href ="/itineraries/{{$itinerary->id}}/edit/show">しおりを編集する</a>
                <br>
                <a href ="/">しおり一覧に戻る</a>
            </div>
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
        <script src="{{ asset('/js/memo-modal.js') }}"></script>
    </body>
</html>