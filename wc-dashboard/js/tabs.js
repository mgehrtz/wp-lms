jQuery(document).ready(function($){
  
  $('button.tab-handle').on('click', function(e){
    e.preventDefault();
    const target = $(this).data('tab-id');
    $('.active').removeClass('active');
    $(this).addClass('active');
    $(`.tab-content[data-tab-content-id="${target}"`).addClass('active');
  });

});