@extends('base')

@section('content')
    <style>
        body {
            padding-top: 54px;
        }

        @media (min-width: 992px) {
            body {
                padding-top: 56px;
            }
        }

        .container .name {
            position: absolute;
            text-align: left;
            top: 50%;
            -webkit-transform: translate(0, -50%);
            -ms-transform: translate(0, -50%);
            transform: translate(0, -50%);
            height: 30px;
            white-space: nowrap;
            overflow: hidden;
            background: white;
            padding: 5px;
            width: 60%;

        }

        .container .name::after {
            content: ''; /* Выводим элемент */
            position: absolute;
            right: 0;
            top: 0; /* Положение элемента */
            width: 40px; /* Ширина градиента*/
            height: 100%; /* Высота родителя */
            /* Градиент */
            background: -moz-linear-gradient(left, rgba(255, 255, 255, 0.2), #ffffff 100%);
            background: -webkit-linear-gradient(left, rgba(255, 255, 255, 0.2), #ffffff 100%);
            background: -o-linear-gradient(left, rgba(255, 255, 255, 0.2), #ffffff 100%);
            background: -ms-linear-gradient(left, rgba(255, 255, 255, 0.2), #ffffff 100%);
            background: linear-gradient(to right, rgba(255, 255, 255, 0.2), #ffffff 100%);
        }

    </style>
    <!-- Page Heading -->
    <h1 class="PageHead">Page Heading
        <small>Secondary Text</small>
    </h1>
    <form action="upload">
        <button class="btn-success btn-block">Загрузить фото</button>
    </form>
    <div class="row text-center text-lg-left" id="buttons_div">
        @forelse($list as $image)
            <div class="col-lg-3 col-md-4 col-xs-6 mb-4">
                <img class="img-fluid img-thumbnail imglist" src="{{$image->image_url}}">
                <div class="container" id="buttons">
                    <div class="name">{{$image->name}}</div>
                    <div class="control_buttons">

                        <a href="{{route('edit_image_form', ['ImageID' => $image->id])}}"><img class="icons"
                                                                                         src="{{asset('images/edit.png')}}"></a>
                        <a href="#" onclick="modal({{$image->id}})"><img class="icons"
                                                                         src="{{asset('images/delete.png')}}"></a>
                    </div>

                </div>
            </div>
        @empty
            <div class="message">Вы не загрузили ни одной фотографии</div>
        @endforelse


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
                        <p>Вы действительно хотите удалить это изображение?</p>
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
            $('#myModal').modal()
            $('#ImageID').val(ImageID);
            $('#delete').attr('action', '/delete/' + ImageID)
        }
    </script>


@endsection
