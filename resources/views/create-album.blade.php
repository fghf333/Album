@extends('base')

@section('content')

    <!-- Page Heading -->
    <h1 class="PageHead">Создание альбома</h1>
    <div class="row">
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <img class="edit_image img-responsive"
                 src="http://res.cloudinary.com/happy-moments/image/upload/c_fill,h_200,w_500/logo_zt2vwd.png">
        </div>
        <div class="col-md-6 align-items-center">
            <form id="album" name="upload" method="post" action="{{route('create_album')}}"
                  enctype="multipart/form-data">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="name">Имя:</label>
                    <input class="form-control" name="name" id="name" type="text" required maxlength="250">

                    @if ($errors->has('name'))
                        <span class="text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif

                </div>
                <div class="form-group">
                    <label for="description">Описание:</label>
                    <textarea class="form-control" name="description" id="description" type="text"
                              maxlength="250"></textarea>

                    @if ($errors->has('description'))
                        <span class="text-danger">
                                        <strong>{{ $errors->first('description') }}</strong>
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
                        <span class="upload_text">Выбрать обложку</span></label>
                </div>
                <button class="btn btn-success mb-2" type="submit" id="submit_button" disabled>Создать</button>

                @if ($errors->has('file'))
                    <span class="text-danger">
                                        <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                @endif

            </form>
        </div>
    </div>
    <script src="{{asset('js/preview-image.js')}}"></script>

@endsection
