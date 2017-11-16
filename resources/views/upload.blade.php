<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref">
                      <div class="content">
                <div class="title m-b-md">
                    Загрузить фото

                </div>
                          @include('links')

                          <label name="upload" method="post" action="{{ route('upload_file') }}" enctype="multipart/form-data">
                              <input name="_token" type="hidden" value="{{ csrf_token() }}">
                              <table>
                              <tr>
                                  <td>
                                      <label for="name">Имя:</label>
                                      <input  id="name" type="text">
                                  </td>
                                  <td>
                                      <label for="album">Альбом:</label>
                                      <select @if(count($albums) === 0)
                                              disabled >
                                          <option value="empty">Альбомов нет</option>
                                          @else
                                          <option value="select">Выберите альбом</option>
                                          @endif
                                          @foreach($albums as $album)
                                          <option value="{{$album->id}}">{{$album->name}}</option>
                                              @endforeach
                                      </select>
                                  </td>
                                  <td>
                                      <label for="tags">Теги:</label>
                                      <input id="tags" type="text">
                                  </td>
                              </tr>
                              <tr>
                                  <td>
                                      <label for="peoples">Люди:</label>
                                      <input id="peoples" type="text">
                                  </td>
                                  <td>
                                      <label for="place">Место:</label>
                                      <input id="place" type="text">
                                  </td>
                                  <td>
                                      <label for="CreatedAt"> Дата:</label>
                                      <input id="CreatedAt" type="date">
                                  </td>
                              </tr>
                              </table>
                              <label for="files"></label> Фото:</label>
                              <input id="files" accept="image/*" type="file" multiple name="file[]">
                              <button type="submit">Загрузить</button>
                          </form>

            </div>

        </div>

    </body>
</html>
