@extends('base')

@section('content')

    <style>

    </style>

    <!-- Page Heading -->
    @if(isset($AlbumName->name))
        <h1 class="PageHead">{{$AlbumName->name}}</h1>
    @else
        <h1 class="PageHead">Список фотографий</h1>
    @endif
    @if(\Illuminate\Support\Facades\Auth::user() !== null)
    <a href="{{route('upload_form', ['AlbumID' => $AlbumID])}}" class="btn btn-success btn-block">Загрузить фото</a>
    @endif
    <div class="row text-center text-lg-left">
        @forelse($list as $image)
            <div class="col-lg-3 col-md-4 col-6 md-4">
                <div class="img-container">
                    <a data-fancybox="image" href="{{$image->image_url}}">
                        <img class="rounded img-thumb" src="{{$image->image_url}}">
                    </a>
                    <div class="buttons">
                        <div class="name">{{$image->name}}</div>
                        <div class="control_buttons">
                            <a class="badge badge-light" href="{{route('edit_image_form', ['ImageID' => $image->id])}}">
                                <img class="icons" src="{{asset('images/edit.png')}}">
                            </a>
                            <a class="badge badge-light" href="#" onclick="modal({{$image->id}})">
                                <img class="icons" src="{{asset('images/delete.png')}}">
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="message">Вы не загрузили ни одной фотографии</div>
        @endforelse


    </div>
    <!-- Start delete confirmation -->
    <div class="modal fade" id="DeleteConfirm">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="delete" action="" method="post">
                    {{ method_field('DELETE') }}
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <div class="modal-header">
                        <h4 class="modal-title">Удалить фотографию?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Вы действительно хотите удалить эту фотографию?</p>
                        <input type="hidden" value="" id="ImageID" name="ImageID">
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

        function modal(ImageID) {
            $('#DeleteConfirm').modal();
            $('#ImageID').val(ImageID);
            $('#delete').attr('action', '/delete-image/' + ImageID)
        }
    </script>

    <!-- End delete confirmation -->

@endsection
