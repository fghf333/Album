@extends('base')

@section('content')
    <h1 class="PageHead">Редактирование альбома</h1>
    <div class="editing_image">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <img class="img" src="{{$album->preview_img}}">
            </div>

            <div class="col-md-6 align-items-center">
                <form name="upload" method="post" action="{{ route('edit_album', ['AlbumID' => $album->id])  }}"
                      onkeypress="if(event.keyCode === 13) return false;">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="name">Имя:</label>
                        <input class="form-control" name="name" id="name" type="text" value="{{$album->name}}" required maxlength="250">

                        @if ($errors->has('name'))
                            <span class="text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif

                    </div>
                    <div class="form-group">
                        <label for="description">Описание:</label>
                        <textarea class="form-control" name="description" id="description" type="text"
                                  maxlength="250">{{$album->description}}</textarea>

                        @if ($errors->has('description'))
                            <span class="text-danger">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                        @endif

                    </div>
                    <button class="btn btn-success mb-2" type="submit">Создать</button>

                    @if ($errors->has('file'))
                        <span class="text-danger">
                                        <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                    @endif

                </form>
            </div>
        </div>
    </div>

@endsection
