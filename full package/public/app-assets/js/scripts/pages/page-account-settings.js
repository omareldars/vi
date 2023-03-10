/*=========================================================================================
    File Name: page-account-settings.js
    Description: page user account settings
    ----------------------------------------------------------------------------------------
    Masterencode
==========================================================================================*/

$(document).ready(function () {
    // language select
    var languageselect = $("#languageselect2").select2({
        dropdownAutoWidth: true,
        width: '100%'
    });
    // music select
    var musicselect = $("#musicselect2").select2({
        dropdownAutoWidth: true,
        width: '100%'
    });
    // movies select
    var moviesselect = $("#moviesselect2").select2({
        dropdownAutoWidth: true,
        width: '100%'
    });
    // birthdate date
    $('.birthdate-picker').pickadate({
        format: 'mmmm, d, yyyy'
    });
    // profile image upload
    new Dropzone(document.body, { // Make the whole body a dropzone
        url: "#", // Set the url
        clickable: "#select-files" // Define the element that should be used as click trigger to select files.
    });
});
(function (window, document, $) {
    'use strict';
    // Input, Select, Textarea validations except submit button
    $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
})(window, document, jQuery);
