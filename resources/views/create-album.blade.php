@extends('base')

@section('content')

    <!-- Page Heading -->
    <h1 class="PageHead">Создание альбома
    </h1>
    <div class="FormTable">


            <form id="album" name="upload" method="post" action="{{route('create_album')}}"
                  enctype="multipart/form-data">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="name">Имя:</label>
                    <input class="form-control" name="name" id="name" type="text">
                </div>
                <div class="form-group">
                    <label for="description">Описание:</label>
                    <textarea class="form-control" name="description" id="description" type="text"
                              maxlength="255"></textarea>
                </div>
                <label for="preview"> Обложка:</label>
                <input class="preview" id="preview" accept="image/*" type="file" name="preview">
                <button type="submit">Загрузить</button>
            </form>
        </div>


@endsection
