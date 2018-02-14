@extends('base')

@section('content')
    <h1 class="PageHead">Добро пожаловать!</h1>
    <div class="row">
        <div class="col-md-6 align-items-center offset-md-3">
            <form method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="email">Имейл адрес:</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                           required autofocus>

                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password">Пароль:</label>
                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group form-check">
                    <input id="remember" class="form-check-input" type="checkbox"
                           name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Запомнить меня</label>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Войти
                    </button>
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        Забыли пароль?
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
