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
        <link rel="stylesheet" href="{{ asset('/css/title_date.css')  }}" >
        <!--header-->
        <link rel="stylesheet" href="{{ asset('/css/header.css')  }}" >
        <!--footer-->
        <link rel="stylesheet" href="{{ asset('/css/footer.css')  }}" >
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
            <div class = "date_select">
                <form action="/itineraries/new_entry/date_store" method="POST">
                    @csrf
                    <!--//出発日を入力-->
                    <span>旅行タイトル</span>
                    <br>
                    <input type="text" name="initial_setting[title]" value="{{ old('initial_setting.title') }}">
                    <p class="title__error" style="color:red">{{ $errors->first('initial_setting.title') }}</p>
                    <span>出発日</span>
                    <input type="date" name="initial_setting[departure_date]" value="{{ old('initial_setting.departure_date') }}">
                    <br>
                    <p class="departure_date__error" style="color:red">{{ $errors->first('initial_setting.departure_date') }}</p>
                    <span>到着日</span>
                    <input type="date" name="initial_setting[arrival_date]" value="{{ old('initial_setting.arrival_date') }}">
                    <br>
                    <p class="arrival_date__error" style="color:red">{{ $errors->first('initial_setting.arrival_date') }}</p>
                    <input class ="btn" type="submit" value="次へ">
                </form>
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
    </body>
</html>
