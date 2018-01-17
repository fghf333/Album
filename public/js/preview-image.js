
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
                    $( "output" ).empty();
                    var span = document.createElement('span');
                    span.innerHTML = ['<img class="thumb img-fluid rounded" src="', e.target.result,
                        '" title="', theFile.name, '"/>'].join('');
                    document.getElementById('list').insertBefore(span, null);
                    $('.upload_text').html(theFile.name);
                };
            })(f);

            // Read in the image file as a data URL.
            reader.readAsDataURL(f);
        }



    }

document.getElementById('files').addEventListener('change', handleFileSelect, false);
