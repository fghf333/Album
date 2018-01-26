
    function handleFileSelect(evt) {
        var files = evt.target.files; // FileList object

        // Loop through the FileList and render image files as thumbnails.
        for (var i = 0, f; f = files[i]; i++) {

            // Only process image files.
            if (!f.type.match('image.*')) {
                continue;
            }

            var reader = new FileReader();

            // Closure to capture the file information.
            reader.onload = (function (theFile) {
                return function (e) {
                    // Render thumbnail.

                    $('.edit_image').attr('src', e.target.result);
                    $('.upload_text').html(theFile.name);
                    $('button[type=submit]').prop("disabled", false);
                };
            })(f);

            // Read in the image file as a data URL.
            reader.readAsDataURL(f);
        }



    }

document.getElementById('files').addEventListener('change', handleFileSelect, false);
