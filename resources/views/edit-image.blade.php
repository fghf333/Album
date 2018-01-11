@extends('base')

@section('content')
    <style>
        .edit_image {
            width: 100%;
            max-width: 500px;
        }
    </style>
    <h1 class="PageHead">Редактирование фотографии
    </h1>
    <div class="row">
        <div class="col-md-6">
            <img class="edit_image" src="{{$image->image_url}}">
        </div>
        <div class="col-md-6">
            <form role="form" name="upload" method="post" action="{{ route('edit_image', ['ImageID' => $image->id])  }}" enctype="multipart/form-data" onkeypress="if(event.keyCode === 13) return false;">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="name">Имя:</label>
                    <input name="name" type="text" class="form-control" id="name" value="{{$image->name}}">
                </div>
                <div class="form-group">
                    <label for="album">Альбом:</label>
                    <select class="form-control" name="album" id="album" @if(count($albums) < 1)
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
                </div>
                <div class="form-group">
                    <label for="tags-input-edit">Теги:</label>
                    <input class="form-control" name="tags" type="text" value="{{$image->tags}}" id="tags-input-edit"/>
                </div>
                <div class="form-group">
                    <label for="peoples">Люди:</label>
                    <input class="form-control" name="peoples" id="peoples" type="text" value="{{$image->peoples}}">
                </div>
                <div class="form-group">
                    <label for="place">Место:</label>
                    <input class="form-control" name="place" id="place" type="text" value="{{$image->place}}">
                </div>
                <div class="form-group">
                    <label for="CreatedAt"> Дата:</label>
                    <input class="form-control" name="CreatedAt" id="CreatedAt" type="date" value="{{$image->createdAt}}">
                </div>
                <button class="btn btn-primary" type="submit">Загрузить</button>
            </form>
        </div>
    </div>

    <script>
        window.tags = {!! $tags !!};
    </script>

@endsection
