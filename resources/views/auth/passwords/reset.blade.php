@extends('base')

@section('content')
    <h1 class="PageHead">Сброс пароля</h1>
    <div class="row">
        <div class="col-md-6 align-items-center offset-md-3">
            <div class="panel-body">
                <form method="POST" action="{{ route('password.request') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group">
                        <label for="email">Имейл адрес:</label>
                        <input id="email" type="email" class="form-control" name="email"
                               value="{{ $email or old('email') }}" required autofocus>
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
                    <div class="form-group">
                        <label for="password-confirm">Подтвердите пароль:</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                               required>
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group flex-center">
                        <button type="submit" class="btn btn-primary">
                            Сбросить пароль
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
