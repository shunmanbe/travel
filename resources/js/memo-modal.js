$(function(){
    $('.open-memo').click(function(){
        $('.memo-modal').fadeIn();
        $('.memo-body').fadeIn();
    });
    
    $('.close-memo').click(function(){
        $('.memo-modal').fadeOut();
        $('.memo-body').fadeOut();
    });
    
});