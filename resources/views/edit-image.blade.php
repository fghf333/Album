@extends('base')
@section('content')
    <!-- Styles -->
    <style>

        .img {
            width: 350px;
            height: auto;
        }

        .editing_image{
            margin: auto;
        }
    </style>
    <div class="flex-center position-ref">
        <div class="content">
            <h1 class="PageHead">Page Heading
                <small>Secondary Text</small>
            </h1>
            <div class="editing_image">
                <img class="img" src="{{$image->image_url}}">
            </div>

            <form name="upload" method="post" action="{{ route('upload_file') }}" enctype="multipart/form-data">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <table class="table">
                    <tr>
                        <td>
                            <label for="name">Имя:</label>
                            <input name="name" id="name" type="text" value="{{$image->name}}">
                        </td>
                        <td>
                            <label for="album">Альбом:</label>
                            <select name="album" id="album" @if(empty($albums))
                            disabled>
                                <option value="empty">Альбомов нет</option>
                                @else
                                    >
                                    <option value="0">Выберите альбом</option>
                                @endif
                                @foreach($albums as $album)
                                    @if($album->id === $image->album)
                                        <option value="{{$album->id}}" selected>{{$album->name}}</option>

                                    @else
                                        <option value="{{$album->id}}">{{$album->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <label for="tags">Теги:</label>
                            <select name="tags" id="tags">
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
                            <input name="peoples" id="peoples" type="text">
                        </td>
                        <td>
                            <label for="place">Место:</label>
                            <input name="place" id="place" type="text">
                        </td>
                        <td>
                            <label for="CreatedAt"> Дата:</label>
                            <input name="CreatedAt" id="CreatedAt" type="date">
                        </td>
                    </tr>
                </table>
                <label for="files"> Фото:</label>
                <input class="files" id="files" accept="image/*" type="file" name="file[]">
                <button @if(count($albums) === 0) disabled @endif type="submit">Загрузить</button>
            </form>

        </div>

    </div>

    </body>
@endsection
