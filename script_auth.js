$(function() {
    $('#reg-button').on('click', function() {
        $('#block-reg').css("display", "block");
        $('#block-auth').css("display", "none");
    });
    $('.auth-block__icon').on('click', function() {
        $('.auth-background').css("display", "none");
        $('body').css("overflow", "unset");
        $('#block-reg').css("display", "none");
        $('#block-auth').css("display", "block");
    });
    $('#auth-button').on('click', function() {
        $('.auth-background').css("display", "flex");
        $('body').css("overflow", "hidden");
    });
    $('#auth-block__back').on('click', function() {
        $('#block-reg').css("display", "none");
        $('#block-auth').css("display", "block");
    });
});