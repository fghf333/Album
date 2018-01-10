@extends('base')
@section('content')
    <!-- Page Heading -->
    <h1 style="padding-top: 10vh; text-align: center;">Семейный альбом</h1>
    <div class="row text-center text-lg-left" id="buttons_div">
        @forelse($images as $image)
            <div class="col-lg-3 col-md-4 col-xs-6 mb-4">
                <a data-fancybox="image" href="{{$image->image_url}}"><img class="img-thumbnail"
                                                                           src="{{$image->image_url}}"></a>
                <div class="container buttons" id="buttons">
                    <div class="name">{{$image->name}}</div>
                </div>
            </div>
        @empty
            <div class="message">Вы не загрузили ни одной фотографии</div>
        @endforelse
    </div>
@endsection
