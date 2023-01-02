/*=========================================================================================
    File Name: BuilderForm-Repeater.js
    Description: form repeater page specific js
    ----------------------------------------------------------------------------------------
    Masterencode
==========================================================================================*/

$(document).ready(function () {
  // form repeater jquery
  $('.file-repeater, .contact-repeater, .repeater-default').repeater({
    show: function () {
      $(this).slideDown();
    },
    hide: function (deleteElement) {
      if (confirm('Are you sure you want to delete this element?')) {
        $(this).slideUp(deleteElement);
      }
    }
  });

});
