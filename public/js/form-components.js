(function($) {
  'use strict';
  $(function() {
    $('.file-upload-browse').on('click', function() {
      var file = $(this).parent().parent().parent().find('.file-upload-default');
      file.trigger('click');
    });
    $('.file-upload-default').on('change', function() {
      $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
    });


      $('.has-repeater').repeater({
          show: function () {
              $(this).slideDown();
          },
          hide: function (deleteElement) {
              if(confirm('למחוק שורה ?')) {
                  $(this).slideUp(deleteElement);
              }
          },
      });






  });
})(jQuery);
