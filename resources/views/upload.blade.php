@extends('base')

@section('content')
    <script src="{{asset('js/typeahead.bundle.js')}}"></script>
    <script src="{{asset('js/bootstrap-tagsinput.js')}}"></script>
    <style>

        .FormTable {
            display: table;
            margin: auto;
            text-align: center;
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
    <!-- Page Heading -->
    <h1 class="PageHead">Page Heading
        <small>Secondary Text</small>
    </h1>
    <div class="FormTable">
        <form id="imageform" name="upload" method="post" action="{{ route('upload_file') }}" enctype="multipart/form-data">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <table class="table">
                <tr>
                    <td>
                        <label for="name">Имя:</label>
                        <input name="name" id="name" type="text">
                    </td>
                    <td>
                        <label for="album">Альбом:</label>
                        <select name="album" id="album" @if(empty($albums))
                        disabled>
                            <option value="0">Альбомов нет</option>
                            @else
                                >
                                <option value="select">Выберите альбом</option>
                            @endif
                            @foreach($albums as $album)
                                <option value="{{$album->id}}">{{$album->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <label for="tags-input">Теги:</label>
                        <input name="tags" type="text" id="tags-input-edit"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="peoples">Люди:</label>
                        <input name="peoples" id="peoples" type="text">
                    </td>
                    <td>
                        <label for="place">Место:</label>
                        <input name="place" id="place" type="text">
                    </td>
                    <td>
                        <label for="CreatedAt"> Дата:</label>
                        <input name="CreatedAt" id="CreatedAt" type="date">
                    </td>
                </tr>
            </table>
            <label for="files"> Фото:</label>
            <input class="files" id="files" accept="image/*" type="file" name="file[]">
            <button @if(count($albums) === 0) disabled @endif type="submit">Загрузить</button>
        </form>
    </div>

    <script>
window.tags = {!! $tags !!};
window.ImageTags = [];
    </script>
    <script src="{{asset('js/tags-input.js')}}"></script>
@endsection
