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
                    <h1>{{ $shareItinerary->title }}</h1>
                    <span>期間:{{ $shareItinerary->departure_date->format('Y年m月d日') }}→{{ $shareItinerary->arrival_date->format('Y年m月d日') }}</span>
                </div>
                <!--出発地-->
                <div class="departure">
                    <div class="name">出発地：{{ $shareItinerary->departure_place_name }}
                        <!--出発地メモ-->
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
                                <div class="memo-body"><textarea readonly>{{$shareItinerary->memo}}</textarea></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--目的地一覧-->
                <div class="destinations">
                    @if(empty($groupPlaces))
                    @else
                        @foreach($groupPlaces as $n => $groupPlace)
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
                                        @if($groupPlace->departure_time == null)
                                            <p class="departure-time-empty departure-time-entered"><span>出発時刻：未登録</span></p>
                                        @else
                                            <p class="departure-time-empty departure-time-entered"><span>出発時刻：{{ $groupPlace->departure_time }}</span></p>
                                        @endif
                                    </div>
                                    <!--経路情報-->
                                    <div class="route">
                                        <form action="{{ route('group.completed_route', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id, 'groupPlace' => $groupPlace->id]) }}" method="POST">
                                            @csrf
                                            <!--移動手段-->
                                            <!--移動手段が登録されていない時-->
                                            @if($groupPlace->transportation == null)
                                                <span>移動手段：未登録</span>
                                            <!--移動手段が"WALKING"で保存されているとき-->
                                            @elseif($groupPlace->transportation == "WALKING")
                                                <span>移動手段：徒歩</span>
                                            <!--移動手段が"TRAIN"で保存されているとき-->
                                            @elseif($groupPlace->transportation == "TRAIN")
                                                <span>移動手段：電車</span>
                                            <!--移動手段が"DRIVING"で保存されているとき-->
                                            @elseif($groupPlace->transportation == "DRIVING")
                                                <span>移動手段：自動車</span>
                                            <!--移動手段が"BICYCLING"で保存されているとき-->
                                            @else($groupPlace->transportation == "BICYCLING")
                                                <span>移動手段：自転車</span>
                                            @endif
                                            <!--経路詳細-->
                                            @if($groupPlace->transportation == null)
                                            <!--経路詳細は表示しない-->
                                            @else
                                                <input class="btn-green" type="submit" name="route" value="経路詳細">
                                            @endif
                                            <!--出発地からの出発か、目的地からの出発かで場合分け-->
                                            @if($n+1 == 1)
                                                <!--出発地から出発の場合は出発地→目的地-->
                                                <!--出発地の名前・緯度・経度-->
                                                <input type="hidden" name="start_name" value="{{$shareItinerary->departure_place_name}}">
                                                <input type="hidden" name="start_lat" value="{{$shareItinerary->departure_place_lat}}">
                                                <input type="hidden" name="start_lng" value="{{$shareItinerary->departure_place_lng}}">
                                                <!--目的地の名前・緯度・経度-->
                                                <input type="hidden" name="goal_name" value="{{$groupPlaces[$n]->name}}">
                                                <input type="hidden" name="goal_lat" value="{{$groupPlaces[$n]->lat}}">
                                                <input type="hidden" name="goal_lng" value="{{$groupPlaces[$n]->lng}}">
                                            @else
                                                <!--目的地からの出発の場合は目的地→目的地-->
                                                <!--出発地の名前・緯度・経度-->
                                                <input type="hidden" name="start_name" value="{{$groupPlaces[$n-1]->name}}">
                                                <input type="hidden" name="start_lat" value="{{$groupPlaces[$n-1]->lat}}">
                                                <input type="hidden" name="start_lng" value="{{$groupPlaces[$n-1]->lng}}">
                                                <!--目的地の名前・緯度・経度-->
                                                <input type="hidden" name="goal_name" value="{{$groupPlaces[$n]->name}}">
                                                <input type="hidden" name="goal_lat" value="{{$groupPlaces[$n]->lat}}">
                                                <input type="hidden" name="goal_lng" value="{{$groupPlaces[$n]->lng}}">
                                            @endif
                                        </form>
                                    </div>
                                    <!--到着時刻表示-->
                                    <div class="arrival-time">
                                        @if($groupPlace->arrival_time == null)
                                            <p class="departure-time-empty departure-time-entered"><span>出発時刻：未登録</span></p>
                                        @else
                                            <p class="departure-time-empty departure-time-entered"><span>出発時刻：{{ $groupPlace->arrival_time }}</span></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="destination">
                                <div class="name">目的地{{ $n + 1 }}:{{ $groupPlace->name }}
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
                                            <div class="memo-body"><textarea readonly>{{$groupPlace->memo}}</textarea></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                        @endforeach
                    @endif
                </div>
                <div class="center">
                    <a class="btn-click" href ="{{ route('group.edit_show', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id]) }}">しおりを編集する</a>
                    <br>
                    <a class="btn-click" href ="{{ route('group.itinerary_index', ['group' => $group->id]) }}">グループのしおり一覧に戻る</a>
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