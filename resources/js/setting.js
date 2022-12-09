$(function(){
    $('.setting-icon').click(function(){
        $('.setting-background').fadeIn();
        $('.setting-list').fadeIn();
    });
    
    $('.close-setting').click(function(){
        $('.setting-background').fadeOut();
        $('.setting-list').fadeOut();
    });
    
});