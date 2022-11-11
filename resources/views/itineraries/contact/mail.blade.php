<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <h1>旅のしおり</h1>
        <div class="container">
            お問い合わせ内容を受け付けました。<br>
                <br>
                ■メールアドレス<br>
                {!! $email !!}<br>
                <br>
                ■タイトル<br>
                {!! $title !!}<br>
                <br>
                ■お問い合わせ内容<br>
                {!! nl2br($body) !!}<br>
        </div>
    </body>
</html>

