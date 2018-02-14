<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/"><img class="logo" src="{{asset('images/logo.png')}}"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('albums') ? 'active' : '' }}" href="/albums">Альбомы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('images-list') ? 'active' : '' }}" href="/images-list">
                        Список фотографий
                    </a>
                </li>
                @if(Auth::guest())
                    <li class="nav-item">
                        <a class="btn btn-outline-success" href="{{route('login')}}">
                            Вход
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-success nav-button" href="{{route('register')}}">
                            Регистрация
                        </a>
                    </li>
                @else
                    <li>
                        <a class="btn btn-outline-primary" href="#">
                            Личный кабинет
                        </a>
                    </li>
                    <li>
                        <a class="btn btn-primary nav-button" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Выход
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
