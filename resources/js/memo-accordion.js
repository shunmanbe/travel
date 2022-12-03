$(function(){
    $('.memo').click(function() {
    var $memo_body = $(this).find('.memo-body');
    if($memo_body.hasClass('open')) { 
      $memo_body.removeClass('open');
      // slideUpメソッドを用いて、$memo_bodyを隠してください
      $memo_body.slideUp();

      // 子要素のspanタグの中身をtextメソッドを用いて書き換えてください
      $(this).find('.memo-display').text('open');
      
    } else {
      $memo_body.addClass('open'); 
      // slideDownメソッドを用いて、$memo_bodyを表示してください
      $memo_body.slideDown();
      
      // 子要素のspanタグの中身をtextメソッドを用いて書き換えてください
      $(this).find('.memo-display').text('close');
      
    }
  });
    
});