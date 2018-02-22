@extends('base')

@section('content')
    <h1 class="PageHead">Редактирование фотографии
    </h1>
    <div class="row">
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <img class="edit_image img-responsive" src="{{$image->image_url}}">
        </div>
        <div class="col-md-6 align-items-center">
            <form role="form" name="upload" method="post" action="{{ route('edit_image', ['ImageID' => $image->id])  }}"
                  enctype="multipart/form-data" onkeypress="if(event.keyCode === 13) return false;">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="name">Имя:</label>
                    <input name="name" type="text" class="form-control" id="name" value="{{$image->name}}" required>
                </div>
                <div class="form-group">
                    <label for="album">Альбом:</label>
                    <select class="form-control" name="album" id="album" @if(count($albums) < 1)
                    disable>
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
                    <input class="form-control" name="peoples" id="peoples" type="text" value="{{$image->peoples}}" required>
                </div>
                <div class="form-group">
                    <label for="place">Место:</label>
                    <input class="form-control" name="place" id="place" type="text" value="{{$image->place}}" required>
                </div>
                <div class="form-group">
                    <label for="CreatedAt"> Дата:</label>
                    <input class="form-control" name="CreatedAt" id="CreatedAt" type="date"
                           value="{{$image->createdAt}}" required>
                </div>
                <button class="btn btn-success" type="submit">Загрузить</button>
            </form>
        </div>
    </div>

    <script>
        window.tags = {!! $tags !!};
    </script>

@endsection
