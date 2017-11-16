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
        }

        .title {
            font-size: 84px;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        input[type=file].files {
            display: inline-block;
        }

        *[disabled] {
            cursor: not-allowed;
            color: #cacaca;
            border-color: #c5c5c5;
        }

    </style>
</head>
<body>
<div class="flex-center position-ref">
    <div class="content">
        <div class="title m-b-md">
            Загрузить фото

        </div>
        @include('links')

        <form name="upload" method="post" action="{{ route('upload_file') }}" enctype="multipart/form-data">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <table class="table">
                <tr>
                    <td>
                        <label for="name">Имя:</label>
                        <input id="name" type="text">
                    </td>
                    <td>
                        <label for="album">Альбом:</label>
                        <select @if(count($albums) === 0)
                                disabled>
                            <option value="empty">Альбомов нет</option>
                            @else
                                <option value="select">Выберите альбом</option>
                            @endif
                            @foreach($albums as $album)
                                <option value="{{$album->id}}">{{$album->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <label for="tags">Теги:</label>
                        <select>
                            @if(count($tags) === 0)
                                <option value="empty">Тегов нет</option>
                            @else
                                <option value="select">Выберите теги</option>
                            @endif
                            @foreach($tags as $tag)
                                <option value="{{$tag->id}}">{{$tag->name}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="peoples">Люди:</label>
                        <input id="peoples" type="text">
                    </td>
                    <td>
                        <label for="place">Место:</label>
                        <input id="place" type="text">
                    </td>
                    <td>
                        <label for="CreatedAt"> Дата:</label>
                        <input id="CreatedAt" type="date">
                    </td>
                </tr>
            </table>
            <label for="files"> Фото:</label>
            <input class="files" id="files" accept="image/*" type="file" multiple name="file[]">
            <button @if(count($albums) === 0) disabled @endif type="submit">Загрузить</button>
        </form>

    </div>

</div>

</body>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
</html>
