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
            <form action="/itineraries/contact/send" method="POST">
                @csrf
                <label>メールアドレス：</label>
                {{ $inputs['email'] }}
                <input name="email" value="{{ $inputs['email'] }}" type="hidden">
                <br>
                <label>タイトル：</label>
                {{ $inputs['title'] }}
                <input name="title" value="{{ $inputs['title'] }}" type="hidden">
                <br>
                <label>お問い合わせ内容</label>
                <br>
                {!! nl2br(e($inputs['body'])) !!}
                <input name="body" value="{{ $inputs['body'] }}" type="hidden">
                <br>
                <div class="center">
                    <button class="btn" type="submit" name="action" value="back">入力内容修正</button>
                    <button class="btn" type="submit" name="action" value="submit">送信する</button>
                </div>
            </form>
        </div>
    </body>
</html>

