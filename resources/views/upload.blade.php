@extends('base')

@section('content')
    <!-- Page Heading -->
    <h1 class="PageHead">Загрузка фотографии
    </h1>
        <form id="imageform" name="upload" method="post" action="{{ route('upload_file') }}"
              enctype="multipart/form-data">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <div class="form-group">
                <label for="name">Имя:</label>
                <input name="name" type="text" class="form-control" id="name">
            </div>
            <div class="form-group">
                <label for="album">Альбом:</label>
                <select class="form-control" name="album" id="album" @if(empty($albums))
                disabled>
                    <option value="0">Альбомов нет</option>
                    @else
                        >
                        <option value="0">Выберите альбом</option>
                    @endif
                    @foreach($albums as $album)
                        @if($default_album === $album->id)
                            <option value="{{$album->id}}" selected>{{$album->name}}</option>
                        @else
                            <option value="{{$album->id}}">{{$album->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="tags-input-edit">Теги:</label>
                <input class="form-control" name="tags" type="text" id="tags-input-edit"/>
            </div>
            <div class="form-group">
                <label for="peoples">Люди:</label>
                <input class="form-control" name="peoples" id="peoples" type="text">
            </div>
            <div class="form-group">
                <label for="place">Место:</label>
                <input class="form-control" name="place" id="place" type="text">
            </div>
            <div class="form-group">
                <label for="CreatedAt"> Дата:</label>
                <input class="form-control" name="CreatedAt" id="CreatedAt" type="date">
            </div>
            <div class="form-group">
                <label for="files"> Фото:</label>
                <input class="files" id="files" accept="image/*" type="file" name="file[]">
            </div>
                <button class="btn btn-primary mb-2" type="submit">Загрузить</button>

        </form>

    <script>
        window.tags = {!! $tags !!};
        window.ImageTags = [];
    </script>

@endsection
