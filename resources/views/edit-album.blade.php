@extends('base')

@section('content')
    <h1 class="PageHead">Редактирование альбома</h1>
    <div class="editing_image">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <img class="img" src="{{asset('images/albums/'.$album->preview_img)}}">
            </div>

            <div class="col-md-6 align-items-center">
                <form name="upload" method="post" action="{{ route('edit_album', ['AlbumID' => $album->id])  }}"
                      onkeypress="if(event.keyCode === 13) return false;">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="name">Имя:</label>
                        <input class="form-control" name="name" id="name" type="text" value="{{$album->name}}">
                    </div>
                    <div class="form-group">
                        <label for="description">Описание:</label>
                        <textarea class="form-control" name="description" id="description" type="text"
                                  maxlength="255">{{$album->description}}</textarea>
                    </div>
                    <button class="btn btn-primary mb-2" type="submit">Создать</button>
                </form>
            </div>
        </div>
    </div>

@endsection
