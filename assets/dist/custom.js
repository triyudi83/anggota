jQuery(document).ready(function ($) {
    /* Initialization of input elements and ImageUploader.js */
    $("input.image_kasus").each(function (index) {
        var id = $(this).attr('data-id');
        var id_product = $(this).attr('data-product');
        var uploader = new ImageUploader({
            'inputElement': $(this).get(0),
            'onProgress': function (info) {
                /* Updating the progress bar */
                if (info['currentItemTotal'] <= 0)
                    return;
                var progress = info['currentItemDone'] * 100.0 / info['currentItemTotal'];
                $('#upload-progress-' + id + ' div').css('width', progress + '%');
            },
            'onComplete': function () {
                /* Enable upload button */
                $('#upload-button-' + id).removeProp('disabled');
                /* Hide progress bar */
                $("#upload-container-" + id).addClass("uk-hidden");
            },
            /* Add rand parameter to prevent accidental caching of the image by the server */
            'uploadUrl': 'Front/upload_images',
            'debug': true
        });
    });

    /* The function below is triggered every time the user selects a file */
    $("input.image_kasus").change(function (index) {
        /* We will check additionally the extension of the image if it's correct and we support it */
        var extension = $(this).val();
        if (extension.length > 0) {
            extension = extension.match(/[^.]+$/).pop().toLowerCase();
            extension = ~$.inArray(extension, ['jpg', 'jpeg', 'png']);
        }
        else {
            event.preventDefault();
            return;
        }

        if (!extension) {
            event.preventDefault();
            console.error('Unsupported image format');
            return;
        }
        var id = $(this).attr('data-id');
        /* Disable upload button until current upload completes */
        $('#upload-button-' + id).prop('disabled', true);
        /* Show progress bar */
        $("#upload-container-" + id).removeClass("uk-hidden");
        /* If you want, you can show a preview of the selected image to the user, but to keep the code simple, we will skip this step */
    });
});
