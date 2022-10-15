<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Itinerary</title>

        <!-- Fonts -->
        <link href="https:fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <!--ページトップリンク-->
        <link rel="stylesheet" type="text/css" href="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/reset.css">
        <!--アイコン表示-->
        <script src="https://kit.fontawesome.com/af4a7db726.js" crossorigin="anonymous"></script>
        <!--css読み込み-->
        <link rel="stylesheet" href="{{ asset('/css/contact.css')  }}" >
        <!--ヘッダー-->
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
            <form action="/itineraries/contact/confirm" method="POST">
                @csrf
                <div class="mail-address">
                    <label>メールアドレス</label>
                    <input name="email" value="{{ old('email') }}" type="text">
                    @if ($errors->has('email'))
                        <p class="error-message">{{ $errors->first('email') }}</p>
                    @endif
                </div>
                <br>
                <div class="title">
                    <label>タイトル</label>
                    <input name="title" value="{{ old('title') }}" type="text">
                    @if ($errors->has('title'))
                        <p class="error-message">{{ $errors->first('title') }}</p>
                    @endif
                </div>
                <br>
                <div class="contact-form">
                    <label>お問い合わせ内容</label>
                    <br>
                    <textarea name="body">{{ old('body') }}</textarea>
                    @if ($errors->has('body'))
                        <p class="error-message">{{ $errors->first('body') }}</p>
                    @endif
                </div>
                <br>
                <div class="center">
                    <button type="submit">入力内容確認</button>
                </div>
            </form>
        </div>
    </body>
</html>

