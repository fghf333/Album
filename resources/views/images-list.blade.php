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

                        <a href="{{route('edit_form', ['ImageID' => $image->id])}}"><img class="icons"
                                                                                         src="{{asset('images/edit.png')}}"></a>
                        <a href="{{route('delete_image', ['ImageID' => $image->id])}}"><img class="icons"
                                                                                            src="{{asset('images/delete.png')}}"></a>
                    </div>

                </div>
            </div>
        @empty
            <div class="message">Вы не загрузили ни одной фотографии</div>
        @endforelse


    </div>
@endsection
