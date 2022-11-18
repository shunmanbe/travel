$(function () { //$()はjQueryのセレクターの書き方。$はjQueryの略。
  let like = $('.like-toggle'); //like-toggleのついたiタグを取得し代入。
  let likeItineraryId; //変数を宣言
  like.on('click', function () { //.onはイベントハンドラー。第一パラメータにイベントの種類、第二パラメータにハンドラとして無名関数。
    let $this = $(this); //this=イベントの実行した要素＝iタグを代入
    likeItineraryId = $this.data('itinerary-id'); //iタグに仕込んだdata-itinerary-idの値を取得
    
    //ajax処理スタート
    $.ajax({
      headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') //attrはattributeの略。属性。指定された属性の値を取ってくる。
      },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
      url: '/like', //通信先アドレスで、このURLでweb.phpに接続
      method: 'POST', //HTTPメソッドの種別を指定
      data: { //サーバーに送信するデータ
        'itinerary_id': likeItineraryId //いいねされた投稿のidを送る.HTML内に仕込んだカスタムdata属性の値を取得する。
      },
    })
    //通信成功した時の処理
    .done(function (data) { // dataにjson($param)が入って帰ってくる
      //toggleClassメソッドは 指定したクラス名の CSS がある場合は削除を行い、なければ追加するメソッド
      $this.toggleClass('liked'); //likedクラスのON/OFF切り替え。
      // $this.next(".like-counter")の場合は、$thisで指定したHTML要素の、次にあるHTML要素を指定して、
      // その要素に.like-counterクラスが追いてる場合に、.html以降のコードを実行する。
      $this.next('.like-counter').html(data.itinerary_likes_count); 
      //html(htmlString)はHTMLエンコード済みの文字列を表すオブジェクト。itinerary_likes_countは{itinerary_likes_count:1}というjsonの形で渡ってくる。
    })
    //通信失敗した時の処理
    .fail(function () {
      console.log('fail'); 
    });
  });
  });