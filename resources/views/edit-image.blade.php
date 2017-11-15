<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

        .img {
            width: 350px;
            height: auto;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref">
    <div class="content">
        <div class="title m-b-md">
            Upload page

        </div>
        @include('links')

        <img class="img" src="{{$image->image_url}}">

        <form method="post" action="{{ route('edit_file') }}" enctype="multipart/form-data">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <table>
                <tr>
                    <td>Имя: <input name="name" type="text" value="{{$image->name}}"></td>
                    <td>Альбом: <input name="album" type="text" value="{{$image->album}}"></td>
                    <td>Теги: <input name="tags" type="text" value="{{$image->tags}}"></td>
                </tr>
                <tr>
                    <td>Люди: <input name="peoples" type="text" value="{{$image->peoples}}"></td>
                    <td>Место: <input name="place" type="text" value="{{$image->place}}"></td>
                    <td>Дата: <input name="CreatedAt" type="date" value="{{$image->createdAt}}"></td>
                </tr>
            </table>
            Фото: <input type="file" name="file[]">
            <button type="submit">Обновить</button>
            <input name="id" type="hidden" value="{{$image->id}}">
        </form>

    </div>

</div>

</body>
</html>
