# 旅のしおり

## リンク
URL:https://radiant-mountain-36845.herokuapp.com

#### テストアカウント
##### （日々修正を行っているため、デプロイのタイミングによってはお試し用アカウントが作成されていない場合がございます。その場合は、新規登録していただけると助かります。）
メールアドレス：travel_sevice_test@gmail.com

パスワード:traveltravel

お問い合わせ機能を使用する場合は、自分のメールアドレスを用いて新規登録してから使用することで、確認メールが届きます。

## サービス概要
旅行のしおりを簡単に作成できるサービスです。
大人になっても学生時代のように、旅行の時はしおりがほしい！という友人たちとの会話から着想を得て、作成に至りました。
ユーザー目線に立ち、さまざまな人からフィードバックをもらい、使いやすさを重視して作成しました。

![スクリーンショット 2022-11-03 15 38 36](https://user-images.githubusercontent.com/111550037/199669423-983ce279-bef8-4178-95cf-cea4713569ca.png)



## 使用技術
- PHP 8.0.23
- Laravel 6.20.44
- jQuery 3.4.1
- MySQL 10.2.38-MariaDB
- AWS
- Google Places API
- Google Directions API
- Google Maps Embed API
- Google Geocoding API

## 機能一覧
- ユーザー登録
- ログイン機能
- Googleアカウントでのログイン
- ログイン時のバリデーション強化
- ログアウト機能
- 他の人のしおりに対するいいね機能
- レスポンシブデザイン
- 複数のしおり登録機能
- 日付登録機能
- 出発地・目的地登録機能
- 出発時間・到着時間登録機能
- Map選択機能（移動手段の選択可）
- 目的地ごとのメモ機能
- ルート検索機能
- お問い合わせ機能
- しおり公開機能

## 注力した機能・工夫した点
- 出発・目的地検索機能
  - 行きたい場所についてはインターネットでや他の地図アプリで調べても良いですが、このサービス内で完結できた方が使いやすいのではと考え、機能を追加しました。

<img width="597" alt="スクリーンショット 2022-10-23 14 54 42" src="https://user-images.githubusercontent.com/111550037/197376406-05910cbe-a7b2-4668-90db-83b9569fc755.png">

- Map選択機能（Google Places API）
  - 検索したワードに対して複数の候補地を地図とともに返却します。
  - 地名だけでなく地図も一緒に表示することで、視覚的にもわかりやすくしました。
  - Googleの他にもYahoo, NAVITIMEのAPIを導入して比較し、今回のサービスではGoogleのAPIが最も使いやすいと判断しました。
  - 住所情報だけでも地図表示はできますが、たまに地図がエラーを起こします。そこでジオコーディングを用いて住所から緯度・経度を出力し、これらを用いて地図を表示することで、より正確な地図を表示できるようにしました。

![スクリーンショット 2022-11-03 15 39 28](https://user-images.githubusercontent.com/111550037/199669663-b2c256d4-c765-4779-b430-57ea245d164c.png)


- 出発地・目的地登録機能
  - マップを選択することで、選択した地名をしおりにそのまま反映させることができます。
  - この機能を追加したことで、しおりの作成をより簡単にすることができました。

![スクリーンショット 2022-11-03 15 40 02](https://user-images.githubusercontent.com/111550037/199669759-23e486ea-96c5-43b6-9aea-88a0de5504c3.png)


- ルート検索機能
  - Mapで選択した際の情報を保持することで、簡単に地点間の経路を表示できるようにしました。
  - 移動方法を選択できるようにすることで、適切な経路を表示できるようにしました。
  - 経路がない場合はエラーが出て表示されません。

<img width="1440" alt="スクリーンショット 2022-11-03 16 52 11" src="https://user-images.githubusercontent.com/111550037/199670341-093bf201-503c-4d51-bd4a-4fd2b33f8d74.png">


- お問い合わせ機能
  - ユーザーがエラーや使いにくさを発見した場合に、私のところに問い合わせができるようにしました。
  - この機能を実装することで、より多くの人からフィードバックを得ることができ、修正を加えてより良いものを提供し続けることができると考えています。

<img width="1440" alt="スクリーンショット 2022-10-23 15 03 12" src="https://user-images.githubusercontent.com/111550037/197376746-5b02edb9-e660-4cc1-ae04-79746960cfe7.png">


## 今後実装予定の機能
- フォローフォロワー機能
- 写真投稿機能
- プロフィール編集機能
- 経路時間表示機能
- 電車乗り換えアプリとの連携（2022/11/8現在 実装中）
- 複数経路表示
- 周辺地域のおすすめ情報表示
