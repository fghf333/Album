@extends('base')

@section('content')
    <!-- Page Heading -->
    <h1 class="PageHead">Список альбомов
    </h1>
    <a href="{{route('create_album_form')}}" class="btn btn-success btn-block">Создать новый Альбом</a>
    <div class="row">
        <div class="col-lg-4 col-sm-6 portfolio-item">
            <div class="card h-100">
                <img class="img-fluid" src="{{asset('images/albums/empty.png')}}">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{route('images-list', ['AlbumID' => 0])}}"> Неотсортированное</a>
                    </h5>
                    <p class="card-text">Фотографии без альбома</p>
                </div>
                <div class="card-footer bg-transparent text-right">
                </div>
            </div>
        </div>
        @foreach($list as $album)
            <div class="col-lg-4 col-sm-6 portfolio-item">
                <div class="card h-100">
                    <img class="img-fluid" src="{{asset('images/albums/'.$album->preview_img)}}">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{route('images-list', ['AlbumID' => $album->id])}}"> {{$album->name}}</a>
                        </h5>
                        <p class="card-text">{{$album->description}}</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="text-right">
                            <a class="badge badge-light" href="{{route('edit_album_form', ['ImageID' => $album->id])}}">
                                <img class="icons" src="{{asset('images/edit.png')}}">
                            </a>
                            <a class="badge badge-light text-right" href="#" onclick="modal({{$album->id}})">
                                <img class="icons" src="{{asset('images/delete.png')}}">
                            </a>
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
                        <h4 class="modal-title">Удалить альбом?</h4>
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

