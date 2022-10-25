<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>旅のしおり</title>
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
                <h1>他のユーザーのしおり</h1>
                <div class="index">
                    <div class="index-detail">
                        @foreach($itineraries as $itinerary)
                            <div class="itinerary">
                                <div class="theme">
                                    <h2><a href="/itineraries/{{ $itinerary->id }}/completed/others/show">{{ $itinerary->title }}</a></h2>
                                </div>
                                <!--いいねマークについての処理-->
                                @if (!$itinerary->isLikedBy(Auth::user()))
                                    <span class="likes">
                                        <i class="fa-regular fa-heart like-toggle" data-itinerary-id="{{ $itinerary->id }}"></i>
                                        <span class="like-counter">{{$itinerary->likes_count}}</span>
                                    </span><!-- /.likes -->
                                @else
                                    <span class="likes">
                                        <i class="fa-regular fa-heart like-toggle liked" data-itinerary-id="{{ $itinerary->id }}"></i>
                                        <span class="like-counter">{{$itinerary->likes_count}}</span>
                                    </span><!-- /.likes -->
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="others"><a href="/">自分のしおり一覧に戻る</a></div>
        </div>
        <footer>
            <div class="footer-wrapper">
                <ul>
                    <li><a href="/itineraries/contact/form">お問い合わせ</a></li>
                </ul>
            </div>
        </footer>
        <script src="{{ asset('/js/alert.js') }}"></script>
        <script src="{{ asset('/js/like.js') }}"></script>
    </body>
</html>

        
        
       