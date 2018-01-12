@extends('base')

@section('content')
    <div class="flex-center position-ref">
        <div class="content">
            <h1 class="PageHead">Редактирование альбома
            </h1>
            <div class="editing_image">
                <img class="img" src="{{asset('images/albums/'.$album->preview_img)}}">
            </div>

            <form name="upload" method="post" action="{{ route('edit_album', ['AlbumID' => $album->id])  }}"
                  onkeypress="if(event.keyCode === 13) return false;">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <table class="table">
                    <tr>
                        <td>
                            <label for="name">Имя:</label>
                            <input name="name" id="name" type="text" value="{{$album->name}}">
                        </td>
                        <td>
                            <label for="description">Описание:</label>
                            <textarea name="description" id="description" type="text"
                                      maxlength="255">{{$album->description}}</textarea>
                        </td>
                    </tr>
                </table>
                <button type="submit">Обновить</button>
            </form>

        </div>

    </div>
@endsection
