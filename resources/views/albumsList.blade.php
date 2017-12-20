@extends('base')

@section('content')
    <style>
        #buttons {
            width: 100%;
            top: 94%;
        }
    </style>
    <!-- Page Heading -->
    <h1 class="PageHead">Page Heading
        <small>Secondary Text</small>
    </h1>
    <form action="#">
        <button class="btn-success btn-block">Создать новый Альбом</button>
    </form>
    <div class="row">
        @forelse($list as $album)
            <div class="col-lg-4 col-sm-6 portfolio-item">
                <div class="card h-100">
                    <div class="text-center text-lg-left" id="buttons_div">

                        <img class="img-fluid " src="{{$album->preview_img}}">
                        <div class="container" id="buttons">
                            <div class="control_buttons">
                                <a href="{{route('edit_form', ['ImageID' => $image->id])}}"><img class="icons"
                                                 src="{{asset('images/edit.png')}}"></a>
                                <a href="#"><img class="icons" src="{{asset('images/delete.png')}}"></a>
                            </div>

                        </div>

                    </div>
                    <div class="card-body">
                        <h4 class="card-title">
                            <a href="#"> {{$album->name}}</a>
                        </h4>
                        <p class="card-text">
                            {{$album->description}}
                        </p>
                        <div class="card_footer">
                            <p>Колличество фото: {{$album->photo_num}}</p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="message">Вы не создали ни одного альбома</div>
        @endforelse
    </div>

@endsection

