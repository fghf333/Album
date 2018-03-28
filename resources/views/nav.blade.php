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
                    <a class="nav-link {{ Request::is('albums') ? 'active' : '' }}" href="{{route('albums_list')}}">Альбомы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('images-list') ? 'active' : '' }}" href="{{route('images-list')}}">
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
                    <li class="dropdown">
                        <a href="#" class="btn btn-outline-success dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">
                            {{ Auth::user()->username }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a class="dropdown-item" href="{{route('profile', ['UserID' => Auth::user()->id])}}"> Профиль
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{route('family_list', ['FamilyID' => Auth::user()['family_id']])}}"> Семья </a>
                            </li>
                        </ul>
                    <li>
                        <a class="btn btn-success nav-button" href="{{ route('logout') }}"
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
