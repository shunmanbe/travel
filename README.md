# 旅のしおり
旅行のしおりを簡単に作成できるサイトです。
大人になっても学生時代のように、旅行の時はしおりがほしい！という友人たちとの会話から着想を得て、作成に至りました。
ユーザー目線に立ち、さまざまな人からフィードバックをもらい、使いやすさを重視して作成しました。


## 使用技術
- PHP 8.0.23
- Laravel 6.20.44
- mysql 10.2.38-MariaDB
- AWS
- Google Places API
- Google Directions API

## 機能一覧
- ユーザー登録
- ログイン機能
- ログアウト機能
- 複数のしおり登録機能
- 日付登録機能
- 出発地・目的地登録機能
- 出発時間・到着時間登録機能
- Map選択機能（移動手段の選択可）
- 目的地ごとのメモ機能
- ルート検索機能
- お問い合わせ機能

## 注力した機能・工夫した点
- 出発・目的地検索機能
  - 行きたい場所についてはインターネットでや他の地図アプリで調べても良いですが、このサービス内で完結できた方が使いやすいのではと考え、機能を追加しました。
![]

- Map選択機能（Google Places API）
  - 検索したワードに対して複数の候補地を地図とともに返却します。
  - 地名だけでなく地図も一緒に表示することで、視覚的にもわかりやすくしました。
  - Googleの他にもYahoo, NAVITIMEのAPIを導入して比較し、今回のサービスではGoogleのAPIが最も使いやすいと判断しました。

- 出発地・目的地登録機能
  - マップを選択することで、選択した地名をしおりにそのまま反映させることができます。
  - この機能を追加したことで、しおりの作成をより簡単にすることができました。

- ルート検索機能
  - Mapで選択した際の情報を保持することで、簡単に地点間の経路を表示できるようにしました。
  - 移動方法を選択できるようにすることで、適切な経路を表示できるようにしました。

- お問い合わせ機能
  - ユーザーがエラーや使いにくさを発見した場合に、私のところに問い合わせができるようにしました。
  - この機能を実装することで、より多くの人からフィードバックを得ることができ、修正を加えてより良いものを提供し続けることができると考えています。
