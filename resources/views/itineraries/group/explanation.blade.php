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
        <link rel="stylesheet" href="{{ asset('/css/explanation.css') }}" >
        <link rel="stylesheet" href="{{ asset('/css/responsive/explanation.css') }}" >
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
            <div class = "container containers">
                <!--しおり名表示-->
                <h2>{{$shareItinerary->title}}</h2>
                <!--説明入力欄-->
                <form action="{{ route('group.explanation_store', ['shareItinerary' => $shareItinerary->id]) }}" method="POST">
                    @csrf
                    <input class="text" type="text" name="explanation[explanation]" value="{{ old('explanation.explanation', $shareItinerary->explanation) }}"placeholder="20文字以内で入力してください">
                    <p class="error-message">{{ $errors->first('explanation.explanation') }}</p>
                    <br>
                    <br>
                    <!--保存ボタン-->
                    <input class="btn" type="submit" value="保存してしおり一覧ページへ">
                </form>
            </div>
            <footer>
                <div class="footer-left"></div>
                <div class="copyright"><span>©︎2022 Shun Nakanishi</span></div>
                <div class="contact"><a href="/itineraries/contact/form">お問い合わせ</a></div>
            </footer>
        </div>
    </body>
</html>
