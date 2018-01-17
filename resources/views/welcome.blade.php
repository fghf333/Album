@extends('base')
@section('content')
    <!-- Page Heading -->
    <h1 class="home-message">Семейный альбом</h1>
    <div class="row text-center text-lg-left" id="buttons_div">
        @forelse($images as $image)
            <div class="col-lg-3 col-md-4 col-6 md-4">
                <div class="img-container">
                    <a data-fancybox="image" href="{{$image->image_url}}">
                        <img class="rounded img-thumb" src="{{$image->image_url}}">
                    </a>
                    <div class="buttons">
                        <div class="name">{{$image->name}}</div>
                    </div>
                </div>
            </div>
        @empty
            <div class="message">Вы не загрузили ни одной фотографии</div>
        @endforelse
    </div>
@endsection
