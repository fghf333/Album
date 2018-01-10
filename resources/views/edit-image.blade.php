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


        .bootstrap-tagsinput .tag {
            background: #09F;
            padding: 5px;
            border-radius: 4px;

        }

        .bootstrap-tagsinput {
            width: 79%;
            text-align: start;
            line-height: 35px;
        }

        .bootstrap-tagsinput input{
            width: 100%;
        }
    </style>
    <div class="flex-center position-ref">
        <div class="content">
            <h1 class="PageHead">Редактирование фотографии
            </h1>
            <div class="editing_image">
                <img class="img" src="{{$image->image_url}}">
            </div>

            <form name="upload" method="post" action="{{ route('edit_image', ['ImageID' => $image->id])  }}" enctype="multipart/form-data" onkeypress="if(event.keyCode === 13) return false;">
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
                                <option value="0">Альбомов нет</option>
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
                            <label for="tags-input-edit">Теги:</label>
                            <input name="tags" type="text" value="{{$image->tags}}" id="tags-input-edit"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="peoples">Люди:</label>
                            <input name="peoples" id="peoples" type="text" value="{{$image->peoples}}">
                        </td>
                        <td>
                            <label for="place">Место:</label>
                            <input name="place" id="place" type="text" value="{{$image->place}}">
                        </td>
                        <td>
                            <label for="CreatedAt"> Дата:</label>
                            <input name="CreatedAt" id="CreatedAt" type="date" value="{{$image->createdAt}}">
                        </td>
                    </tr>
                </table>
                <button type="submit">Загрузить</button>
            </form>

        </div>

    </div>

    <script>
        window.tags = {!! $tags !!};
    </script>

@endsection
