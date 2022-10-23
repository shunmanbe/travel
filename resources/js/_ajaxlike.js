$(function () {
    
//定義
var like = $('.js-like-toggle');
var likeItineraryId;

//クリックされた時に実行
like.on('click', function () {
    var $this = $(this);
    likeItineraryId = $this.data('itineraryid');
    $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') //通信するために必要なCSRFトークン
            },
            url: '/ajaxlike',  //取得したURLまたはディレクトリを記述(routeの記述)
            type: 'POST', //受け取り方法
            data: {
                'post_id': likePostId //コントローラーの$requestに値を渡す
            },
    })

        // Ajaxリクエストが成功した場合
        .done(function (data) {
            //lovedクラスを追加
            $this.toggleClass('loved'); 

            //.likesCountの次の要素のhtmlを「data.postLikesCount」の値に書き換える
            $this.next('.likesCount').html(data.postLikesCount); 

        })
        // Ajaxリクエストが失敗した場合
        .fail(function (data, xhr, err) {
            //エラー内容詳細
            console.log('エラー');
            console.log(err);
            console.log(xhr); //XHR：スクリプトからHTTPを利用してWebサーバにアクセスする機能を提供するもの
        });
    
    return false;
});
});