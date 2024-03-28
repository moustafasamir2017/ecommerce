$(function(){

    'use strict';

    $('[placeholder]').focus(function(){
        $(this).attr('data-text',$(this).attr('placeholder'));
        $(this).attr('placeholder','');
    }).blur(function(){
        $(this).attr('placeholder',$(this).attr('data-text'));
    });

    // Add Aserisk on required field

    $('input').each(function(){
        if( $(this).attr('required') == 'required' ){
            $(this).after('<span class="aserisk">*</span>');
        }
    });

    // convert passfield on hover
    $('.show-pass').on('click',function(){
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $(this).siblings("input");
        if (input.attr("type") === "password") {
          input.attr("type", "text");
        } else {
          input.attr("type", "password");
        }
    });

    // confirmation message
    $('.confirm').on('click',function(){
        return confirm('Are you sure ?');
    });


});