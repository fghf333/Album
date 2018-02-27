@extends('base')

@section('content')
    <h1 class="PageHead">Регистрация нового пользователя</h1>
    <div class="row">
        <div class="col-md-6 align-items-center offset-md-3 alert alert-success">
            После регистрации на указанный вами Имейл придёт письмо от <b>Cloudinary</b> с ссылкой подтверждения.

        </div>
        <div class="col-md-6 align-items-center offset-md-3">
            <form method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="username">Имя пользователя:</label>
                    <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}"
                           required autofocus>
                    @if ($errors->has('username'))
                        <span class="text-danger">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="email" class="">Имейл адрес:</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                           required>
                    @if ($errors->has('email'))
                        <span class="text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password">Пароль:</label>
                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <span class="text-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password-confirm">Подтверждение пароля:</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                           required>
                </div>

                <div class="form-group offset-md-4">
                    <button type="submit" class="btn btn-success">
                        Зарегистрироваться
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
