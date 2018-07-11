@extends('base')

@section('content')

    <!-- Page Heading -->
    <h1 class="PageHead">
        @if($edit)
            Редактирование фотографии
        @else
            Загрузка фотографии
        @endif
    </h1>
    <div class="row">
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            @if($edit)
                <img class="edit_image img-responsive" src="{{$image->image_url}}">
            @else
                <img class="edit_image img-responsive"
                     src="http://res.cloudinary.com/happy-moments/image/upload/c_fill,h_200,w_500/logo_o299ll.png">
            @endif
        </div>
        <div class="col-md-6 align-items-center">
            @if($edit)
                <form role="form" name="upload" method="post"
                      action="{{ route('edit_image', ['ImageID' => $image->id])  }}"
                      enctype="multipart/form-data" onkeypress="if(event.keyCode === 13) return false;">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="name">Имя:</label>
                        <input name="name" type="text" class="form-control" id="name" value="{{old('name') !== null ? old('name') : $image->name}}" required
                               maxlength="250">

                        @if ($errors->has('name'))
                            <span class="text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif

                    </div>
                    <div class="form-group">
                        <label for="album">Альбом:</label>
                        <select class="form-control" name="album" id="album">
                            @foreach($albums as $album)
                                @if($album->id === $image->album or (int)old('album') === $album->id)
                                    <option value="{{$album->id}}" selected>{{$album->name}}</option>
                                @else
                                    <option value="{{$album->id}}">{{$album->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tags-input-edit">Теги:</label>
                            <input name="tags" id="tags-input-edit" style="display: none;">
                    </div>
                    <div class="form-group">
                        <label for="peoples">Люди:</label>
                        <input class="form-control" name="peoples" id="peoples" type="text" value="{{old('peoples') !== null ? old('peoples') : $image->peoples}}"
                               maxlength="250">

                        @if ($errors->has('peoples'))
                            <span class="text-danger">
                                        <strong>{{ $errors->first('peoples') }}</strong>
                                    </span>
                        @endif

                    </div>
                    <div class="form-group">
                        <label for="place">Место:</label>
                        <input class="form-control" name="place" id="place" type="text" value="{{old('place') !== null ? old('place') : $image->place}}"
                               maxlength="250">

                        @if ($errors->has('place'))
                            <span class="text-danger">
                                        <strong>{{ $errors->first('place') }}</strong>
                                    </span>
                        @endif

                    </div>
                    <div class="form-group">
                        <label for="CreatedAt"> Дата:</label>
                        <input class="form-control" name="CreatedAt" id="CreatedAt" type="date"
                               value="{{old('CreatedAt') !== null ? old('CreatedAt') : $image->createdAt}}" required>

                        @if ($errors->has('CreatedAt'))
                            <span class="text-danger">
                                        <strong>{{ $errors->first('CreatedAt') }}</strong>
                                    </span>
                        @endif

                    </div>
                    <button class="btn btn-success" id="submit_button" type="submit">Обновить</button>

                    @if ($errors->has('file'))
                        <span class="text-danger">
                                        <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                    @endif

                </form>
            @else
                <form id="imageform" name="upload" method="post" action="{{ route('upload_file') }}"
                      enctype="multipart/form-data">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="name">Имя:</label>
                        <input name="name" type="text" class="form-control" id="name" required maxlength="250"
                               value="{{old('name')}}">

                        @if ($errors->has('name'))
                            <span class="text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif

                    </div>
                    <div class="form-group">
                        <label for="album">Альбом:</label>
                        <select class="form-control" name="album" id="album">
                            @foreach($albums as $album)
                                @if(isset($default_album) and $default_album === $album->id or (int)old('album') === $album->id)
                                    <option value="{{$album->id}}" selected>{{$album->name}}</option>
                                @else
                                    <option value="{{$album->id}}">{{$album->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tags-input-edit">Теги:</label>
                        <input name="tags" id="tags-input-edit" style="display: none;">
                    </div>
                    <div class="form-group">
                        <label for="peoples">Люди:</label>
                        <input class="form-control" name="peoples" id="peoples" type="text" maxlength="250"
                               value="{{ old('peoples') }}">

                        @if ($errors->has('peoples'))
                            <span class="text-danger">
                                        <strong>{{ $errors->first('peoples') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="place">Место:</label>
                        <input class="form-control" name="place" id="place" type="text" maxlength="250"
                               value="{{ old('place') }}">

                        @if ($errors->has('place'))
                            <span class="text-danger">
                                        <strong>{{ $errors->first('place') }}</strong>
                                    </span>
                        @endif

                    </div>
                    <div class="form-group">
                        <label for="CreatedAt"> Дата:</label>
                        <input class="form-control" name="CreatedAt" id="CreatedAt" type="date" required
                               value="{{old('CreatedAt')}}">

                        @if ($errors->has('CreatedAt'))
                            <span class="text-danger">
                                        <strong>{{ $errors->first('CreatedAt') }}</strong>
                                    </span>
                        @endif

                    </div>
                    <div class="form-group">

                        <input class="inputfile" id="files" accept="image/*" type="file" name="file">
                        <label class="btn btn-success mb-2" for="files">
                            <svg class="upload-svg" xmlns="http://www.w3.org/2000/svg" width="20" height="17"
                                 viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                            </svg>
                            <span class="upload_text">Выберите фото</span></label>
                    </div>
                    @if ($errors->has('file'))
                        <span class="text-danger">
                                        <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                    @endif
                    <div class="form-group">
                        <button class="btn btn-success mb-2" id="submit_button" type="submit" disabled>Загрузить
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
    @if($edit)
        <script>
            var addurl = "{{url('add-tags')}}" + "/{{$image->image_id}}"
        </script>
        @else
        <script src="{{asset('js/preview-image.js')}}"></script>
    @endif
    <script>
        var url = "{{url('tags')}}";
        window.ImageTags = [];
    </script>
    <script src="{{asset('js/typeahead.bundle.js')}}"></script>
    <script src="{{asset('js/bootstrap-tagsinput.js')}}"></script>
    <script src="{{asset('js/tags-input.js')}}"></script>
@endsection
