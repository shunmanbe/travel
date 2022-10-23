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
        <!--==============レイアウトを制御する独自のCSSを読み込み===============-->
        <link href="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/reset.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/loading.css') }}" >
        <!--アイコン表示-->
        <script src="https://kit.fontawesome.com/af4a7db726.js" crossorigin="anonymous"></script>
        <!--ページCSS-->
        <link rel="stylesheet" href="{{ asset('/css/index.css')  }}" >
        <!--loading-->
        <link rel="stylesheet" href="{{ asset('/css/loading.css')  }}" >
        <!--footer-->
        <link rel="stylesheet" href="{{ asset('/css/footer.css')  }}" >
        <!--header-->
        <link rel="stylesheet" href="{{ asset('/css/header.css')  }}" >
    </head>

    <body>
        <div id="splash">
            <div id="splash_text"></div>
        </div>
        <header>
            <div class="header-title"><h1>旅のしおり</h1></div>
            <div class="header-right">
                <ul>
                    <li><i class="fa-solid fa-user"></i> {{ $auth->name }}</li>
                    <li><a href="/itineraries/logout">ログアウト</a></li>
                </ul>
            </div>
        </header>
        <div class="container">
            <div class='itineraries'>
                <h1>しおり一覧</h1>
                <div class="index">
                    <div class="index-detail">
                        @foreach($details as $detail)
                            <div class="itinerary">
                                <div class="theme">
                                    <h2><a href="/itineraries/{{ $detail->id }}/completed_show">{{ $detail->title }}</a></h2>
                                </div>
                                <!--@if($like->like_exist(Auth::user()->id,$detail->id))-->
                                <!--    <p class="favorite-marke">-->
                                <!--      <a class="js-like-toggle loved" href="" data-postid="{{ $detail->id }}"><i class="fas fa-heart"></i></a>-->
                                <!--      <span class="likesCount">{{$post->likes_count}}</span>-->
                                <!--    </p>-->
                                <!--@else-->
                                <!--    <p class="favorite-marke">-->
                                <!--      <a class="js-like-toggle" href="" data-postid="{{ $detail->id }}"><i class="fas fa-heart"></i></a>-->
                                <!--      <span class="likesCount">{{$detail->likes_count}}</span>-->
                                <!--    </p>-->
                                <!--@endif​-->
                                <form action="/itineraries/{{ $detail->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="trash" type="submit" onClick="delete_alert(event);return false;"><i class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="btn">
                    <a class="new_entry" href="/itineraries/new_entry/date">新規作成</a>
                </div>
            </div>
        </div>
        <footer>
            <div class="footer-wrapper">
                <ul>
                    <li><a href="/itineraries/contact/form">お問い合わせ</a></li>
                </ul>
            </div>
        </footer>
        <script src="{{ asset('/js/alert.js') }}"></script>
        <!--==============JQuery読み込み===============-->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://rawgit.com/kimmobrunfeldt/progressbar.js/master/dist/progressbar.min.js"></script>
        <!--IE11用-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.26.0/babel.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/6.26.0/polyfill.min.js"></script>
        <!--自作のJS-->
        <script src="{{ asset('/js/loading.js') }}"></script>
    </body>
</html>

        
        
       