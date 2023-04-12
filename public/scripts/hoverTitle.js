$(function() { 
    $('img').hover(
    function () {
      $(this).next().css('display', 'inline-block');
      $(this).css('opacity','0.5');
    }, function () {
      $(this).next().css('display', 'none');
      $(this).css('opacity','1');
    });
  });// document ready