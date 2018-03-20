@extends('base')
@section('content')
    <!-- Page Heading -->
    <h1 class="home-message">Ваш профиль</h1>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if($tab == 'default') active @endif text-success" id="first-tab" data-toggle="tab"
               href="#first" role="tab" aria-controls="home" @if($tab == 'default') aria-selected="true"
               @else aria-selected="false" @endif >Основные данные</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if($tab == 'password') active @endif text-success" id="profile-tab" data-toggle="tab"
               href="#password" role="tab" aria-controls="profile" @if($tab == 'password') aria-selected="true"
               @else aria-selected="false" @endif>Поменять пароль</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-success" id="stats-tab" data-toggle="tab" href="#stats" role="tab"
               aria-controls="contact" aria-selected="false">Статистика</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade @if($tab == 'default') show active @endif" id="first" role="tabpanel"
             aria-labelledby="first-tab">
            @foreach($data as $key => $value)
                <div class="row justify-content-center user-data">
                    <div class="col-lg-3">
                        {{$key}}
                    </div>
                    <div class="col-lg-3">
                        {{$value}}
                    </div>
                </div>
                <hr>
            @endforeach

        </div>
        <div class="tab-pane fade @if($tab == 'password') show active @endif" id="password" role="tabpanel"
             aria-labelledby="profile-tab">
            <div class="row">
                <div class="col-md-6 align-items-center offset-md-3">
                    <div class="panel-body">
                        <form method="POST" action="{{ route('password_change') }}">
                            {{ csrf_field() }}
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
                                <label for="password-confirm">Подтвердите пароль:</label>
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation"
                                       required>
                                @if ($errors->has('password_confirmation'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group flex-center">
                                <button type="submit" class="btn btn-success">
                                    Поменять пароль
                                </button>
                            </div>
                        </form>
                        @if(isset($message))
                            <div class="col-md-12 align-items-center alert alert-success">
                                {{$message}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="stats" role="tabpanel" aria-labelledby="stats-tab">
            <div class="row stats">
                <div class="col-md-3">
                    <canvas id="bandwidth" width="250" height="250"></canvas>
                </div>
                <div class="col-md-3">
                    <canvas id="storage" width="250" height="250"></canvas>
                </div>
                <div class="col-md-3">
                    <canvas id="images" width="250" height="250"></canvas>
                </div>
                <div class="col-md-3">
                    <canvas id="transformations" width="250" height="250"></canvas>
                </div>
            </div>
            <div id="legend" class="row legend justify-content-center"></div>
        </div>
    </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
    <script>
        var url = "{{url('charts')}}";
    </script>
    <script src="{{asset('js/stats.js')}}"></script>
@endsection
