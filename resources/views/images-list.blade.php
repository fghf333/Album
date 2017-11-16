<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
            width: 100%;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;

        }

        .image_preview {
            height: 350px;
            display: inline-block;
            width: 15%;
            border: 4px double black;
            margin: 10px;
        }

        .image_preview .img {
            width: auto;
            height: 30%;
        }

        .icons {
            width: 30px;
            height: auto;
        }

        .message {
            padding-top: 20vh;
            font-size: 45px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref">
    <div class="content">
        <div class="title m-b-md">
            Список фотографий

        </div>
        @include('links')

        @forelse($list as $image)
            <div class="image_preview">
                <img class="img" src="{{$image->image_url}}">
                <p>{{$image->name}}</p>
                <p>{{$image->album}}</p>
                <p>{{$image->peoples}}</p>
                <p>{{$image->place}}</p>
                <p>{{$image->tags}}</p>
                <a href="{{url('edit-image/'.$image->id)}}"><img class="icons" src="{{asset('images/edit.png')}}"></a>
                <a href="{{url('#')}}"><img class="icons" src="{{asset('images/delete.png')}}"></a>
            </div>
        @empty
            <div class="message">Вы не загрузили ни одной фотографии</div>
        @endforelse


    </div>

</div>

</body>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
</html>
