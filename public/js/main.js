function modalImage(ID) {
    $('#DeleteConfirm').modal();
    $('#ImageID').val(ID);
    $('#delete').attr('action', '/delete-image/' + ID)
}

function modalAlbum(ID){
    $('#myModal').modal();
    $('#AlbumID').val(ID);
    $('#delete').attr('action', '/delete-album/' + ID)
}

$('form').submit(function () {
    $('#submit_button').prop('disabled', true);
});

