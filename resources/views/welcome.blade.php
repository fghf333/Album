@extends('base')
@section('content')
    <!-- Page Heading -->
    <h1 class="home-message">Семейный альбом</h1>
    <?php //dd($images) ?>
    <div class="row text-center text-lg-left" id="buttons_div">
        @forelse($images as $image)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="img-container">
                    <a data-fancybox="image" href="{{$image->image_url}}">
                        <img class="rounded img-thumb" src="{{$image->preview_img_url}}">
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
