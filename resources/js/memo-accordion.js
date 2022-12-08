$(function(){
    $('.memo').click(function(){
    const $memo_body = $(this).find('.memo-body');
    if($memo_body.hasClass('open')) { 
      $memo_body.removeClass('open');
      // $memo_bodyを隠す
      $memo_body.slideUp();
      // spanタグの中身を書き換える
      $(this).find('.memo-display').text('open');
      
    } else {
      $memo_body.addClass('open'); 
      // $memo_bodyを表示
      $memo_body.slideDown();
      
      // spanタグの中身を書き換える
      $(this).find('.memo-display').text('close');
      
    }
  });
});