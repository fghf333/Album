

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/"><img style="width: 90px; height: auto;" src="{{asset('images/logo.png')}}"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item {{ Request::is('albums') ? 'active' : '' }}">
                    <a class="nav-link" href="/albums">Альбомы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('images-list') ? 'active' : '' }}" href="/images-list">Список фотографий</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
