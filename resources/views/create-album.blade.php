@extends('base')

@section('content')

    <!-- Page Heading -->
    <h1 class="PageHead">Создание альбома
    </h1>
    <div class="FormTable">
        <form id="imageform" name="upload" method="post" action="{{ route('create_album') }}"
              enctype="multipart/form-data">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <table class="table">
                <tr>
                    <td>
                        <label for="name">Имя:</label>
                        <input name="name" id="name" type="text">
                    </td>
                    <td>
                        <label for="description">Описание:</label>
                        <textarea name="description" id="description" type="text" maxlength="255"></textarea>
                    </td>
                </tr>
            </table>
            <label for="preview"> Обложка:</label>
            <input class="preview" id="preview" accept="image/*" type="file" name="preview">
            <button type="submit">Загрузить</button>
        </form>
    </div>
@endsection
