$(function(){
    $('.setting-icon').click(function(){
        $('.setting-background').fadeIn();
        $('.setting-list').slideDown();
    });
    
    $('.close-setting').click(function(){
        $('.setting-background').fadeOut();
        $('.setting-list').slideUp();
    });
    
});