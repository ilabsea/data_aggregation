jQuery(function () {
    'use strict';

    // UPLOAD CLASS DEFINITION
    // ======================

    var uploadForm = document.getElementById('js-upload-form');

    var startUpload = function(files) {
        jQuery.ajax({
            url: "../../index.php/imports/upload",
            type: "POST",
            data: files,
            processData: false,
            contentType: false,
            success: function (result) {
                window.location.href = "show_validation/" + encodeURI(result);
            }
        });
    };

    uploadForm.addEventListener('submit', function(e) {
        var file_data = $('#js-upload-files').prop('files')[0];   
        var form_data = new FormData();                  
        form_data.append('file', file_data);
        e.preventDefault();

        startUpload(form_data);
    })


});