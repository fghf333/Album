@extends('base')

@section('content')
    <h1 class="PageHead">Сброс пароля</h1>
    <div class="row">
        <div class="col-md-6 align-items-center offset-md-3">
            <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="email">Имейл адрес:</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                               required>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group flex-center">
                        <button type="submit" class="btn btn-primary">
                            Отправить ссылку для восстановления
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
