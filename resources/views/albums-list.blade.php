@extends('base')

@section('content')
    <style>
        #buttons {
            width: 100%;
            top: 94%;
        }
    </style>
    <!-- Page Heading -->
    <h1 class="PageHead">Список альбомов
    </h1>
    <form action="create-album">
        <button class="btn-success btn-block">Создать новый Альбом</button>
    </form>
    <div class="row">
        <div class="col-lg-4 col-sm-6 portfolio-item">
            <div class="card h-100">
                <div class="text-center text-lg-left" id="buttons_div">

                    <img class="img-fluid" src="{{asset('images/albums/empty.png')}}">
                </div>
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="{{route('images-list', ['AlbumID' => 0])}}"> Неосортированное</a>
                    </h4>
                    <p class="card-text">
                        Фотографии без альбома
                    </p>
                    <div class="card_footer">
                        <p>Колличество фото:</p>
                    </div>
                </div>
            </div>
        </div>
        @foreach($list as $album)
            <div class="col-lg-4 col-sm-6 portfolio-item">
                <div class="card h-100">
                    <div class="text-center text-lg-left" id="buttons_div">

                        <img class="img-fluid" src="{{asset('images/albums/'.$album->preview_img)}}">
                        <div class="container" id="buttons">
                            <div class="control_buttons">
                                <a href="{{route('edit_album_form', ['ImageID' => $album->id])}}"><img class="icons"
                                                                                                       src="{{asset('images/edit.png')}}"></a>
                                <a href="#" onclick="modal({{$album->id}})"><img class="icons"
                                                                                 src="{{asset('images/delete.png')}}"></a>
                            </div>

                        </div>

                    </div>
                    <div class="card-body">
                        <h4 class="card-title">
                            <a href="{{route('images-list', ['AlbumID' => $album->id])}}"> {{$album->name}}</a>
                        </h4>
                        <p class="card-text">
                            {{$album->description}}
                        </p>
                        <div class="card_footer">
                            <p>Колличество фото: {{$album->photo_num}}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="delete" action="" method="post">
                    {{ method_field('DELETE') }}
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <div class="modal-header">
                        <h4 class="modal-title">Название модали</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Вы действительно хотите удалить этот альбом?</p>
                        <input type="hidden" value="" id="AlbumID" name="AlbumID">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Удалить</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script>
        function modal(AlbumID) {
            $('#myModal').modal();
            $('#AlbumID').val(AlbumID);
            $('#delete').attr('action', '/delete-album/' + AlbumID)
        }
    </script>
@endsection

