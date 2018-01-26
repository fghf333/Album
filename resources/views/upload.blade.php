@extends('base')

@section('content')

    <!-- Page Heading -->
    <h1 class="PageHead">Загрузка фотографии
    </h1>
    <div class="row">
        <div class="col-md-6 d-flex justify-content-center align-items-center">
<img class="edit_image img-responsive" src="{{asset('images/logo.png')}}">
        </div>
        <div class="col-md-6 align-items-center">
            <form id="imageform" name="upload" method="post" action="{{ route('upload_file') }}"
                  enctype="multipart/form-data">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="name">Имя:</label>
                    <input name="name" type="text" class="form-control" id="name" required maxlength="255">
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
                    <input class="form-control" name="tags" type="text" id="tags-input-edit">
                </div>
                <div class="form-group">
                    <label for="peoples">Люди:</label>
                    <input class="form-control" name="peoples" id="peoples" type="text" required>
                </div>
                <div class="form-group">
                    <label for="place">Место:</label>
                    <input class="form-control" name="place" id="place" type="text" required>
                </div>
                <div class="form-group">
                    <label for="CreatedAt"> Дата:</label>
                    <input class="form-control" name="CreatedAt" id="CreatedAt" type="date" required>
                </div>
                <div class="form-group">

                    <input class="inputfile" id="files" accept="image/*" type="file" name="file[]" required>
                    <label class="btn btn-primary mb-2" for="files">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                            <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                        </svg>
                        <span class="upload_text">Выберите фото</span></label>
                </div>
                <button class="btn btn-primary mb-2" type="submit" disabled>Загрузить</button>

            </form>
        </div>
    </div>
    <script>
        window.tags = {!! $tags !!};
        window.ImageTags = [];
    </script>
    <script src="{{asset('js/preview-image.js')}}"></script>
@endsection
