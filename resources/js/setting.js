$(function(){
    $('.setting').click(function(){
      const $setting_body = $(this).find('.setting_body');
      if($setting_body.hasClass('open')) {
        $setting_body.removeClass('open');
        // $setting_bodyを隠す
        $setting_body.slideUp();
      }else{
        $setting_body.addClass('open');
        // $setting_bodyを表示
        $setting_body.slideDown();
      }
    });
    
});