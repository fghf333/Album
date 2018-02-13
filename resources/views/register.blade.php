@extends('base')
@section('content')
    <h1 class="PageHead">Регистрация нового пользователя</h1>
    <div class="row">
        <div class="col-md-6 align-items-center offset-md-3">
            <form name="upload" method="post" action="{{ route('register_as')  }}"
                  onkeypress="if(event.keyCode === 13) return false;">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="username">Имя:</label>
                    <input class="form-control" name="username" id="username" type="text" required>
                </div>
                <div class="form-group">
                    <label for="email">Имейл:</label>
                    <input class="form-control" name="email" id="email" type="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Пароль:</label>
                    <input class="form-control" name="password" id="password" type="password" required>
                </div>
                <button class="btn btn-primary mb-2" type="submit">Создать</button>
            </form>
        </div>
    </div>

@endsection