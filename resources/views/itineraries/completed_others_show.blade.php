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
                <p class="name">
                    <span>出発地：{{ $itinerary->departure_place_name }}</span>
                </p>
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
                                <!--出発時刻-->
                                <div class="departure_time">
                                    <p>出発時刻：{{$place->departure_time}}</p>
                                </div>
                                <!--経路選択-->
                                <div class="route">
                                    <form action="/itineraries/{{$itinerary->id}}/completed_route/{{$place->id}}" method="POST">
                                        @csrf
                                        <select name="Mode">
                                            <option value="">移動手段を選択</option>
                                            <option value="DRIVING">自動車</option>
                                            <option value="TRANSIT">電車</option>
                                            <option value="WALKING">徒歩</option>
                                        </select>
                                        <p class="error-message">{{ $errors->first('Mode') }}</p>
                                        <input class="btn" type="submit" name="route" value="経路詳細">
                                        @if($n+1 == 1)
                                            <!--出発地から出発の場合は出発地→目的地-->
                                            <input type="hidden" name="start_name" value={{$itinerary->departure_place_name}}>
                                            <input type="hidden" name="start_address" value={{$itinerary->departure_place_address}}>
                                            <input type="hidden" name="end_name" value={{$places[$n]->destination_name}}>
                                            <input type="hidden" name="end_address" value={{$places[$n]->destination_address}}>
                                        @else
                                            <!--目的地からの出発の場合は目的地→目的地-->
                                            <input type="hidden" name="start_name" value={{$places[$n-1]->destination_name}}>
                                            <input type="hidden" name="start_address" value={{$places[$n-1]->destination_address}}>
                                            <input type="hidden" name="end_name" value={{$places[$n]->destination_name}}>
                                            <input type="hidden" name="end_address" value={{$places[$n]->destination_address}}>
                                        @endif
                                    </form>
                                </div>
                                <!--到着時刻-->
                                <div class="arrival">
                                    <p>到着時刻：{{$place->arrival_time}}</p>
                                </div>
                            </div>
                        </div>
                        <!--目的地-->
                        <div class="destination">
                            <div class="name">目的地{{ $n + 1 }}:{{ $place->destination_name }}
                                <!--目的地メモ-->
                                <a class="memo" href="/itineraries/{{ $itinerary->id }}/memo/{{ $place->id }}"><i class="fa-regular fa-comment icon"></i></a>
                            </div>
                        </div>
                        <br>
                    @endforeach
                @endif
            </div>
            <div class="center">
                <a href ="/itineraries/others/index">他のユーザーのしおり一覧に戻る</a>
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
        <script src="modal.js"></script>
    </body>
</html>
