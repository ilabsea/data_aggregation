jQuery(function () {
    'use strict';

    // UPLOAD CLASS DEFINITION
    // ======================

    var dropZone = document.getElementById('drop-zone');
    var uploadForm = document.getElementById('js-upload-form');

    var startUpload = function(files) {
        jQuery.ajax({
            url: "../../index.php/file/upload",
            type: "POST",
            data: files,
            processData: false,
            contentType: false,
            success: function (result) {
                console.log("Success");
                 // if all is well
                 // play the audio file
            }
        });
    }

    uploadForm.addEventListener('submit', function(e) {
        var file_data = $('#js-upload-files').prop('files')[0];   
        var form_data = new FormData();                  
        form_data.append('file', file_data);
        e.preventDefault();

        startUpload(form_data);
    })

    dropZone.ondrop = function(e) {
        e.preventDefault();
        this.className = 'upload-drop-zone';

        startUpload(e.dataTransfer.files)
    }

    dropZone.ondragover = function() {
        this.className = 'upload-drop-zone drop';
        return false;
    }

    dropZone.ondragleave = function() {
        this.className = 'upload-drop-zone';
        return false;
    }

});