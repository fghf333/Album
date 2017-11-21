@extends('base')

@section('content')
    <!-- Page Heading -->
    <h1 class="PageHead">Page Heading
        <small>Secondary Text</small>
    </h1>
    <div class="row">
        @forelse($list as $image)
            <div class="image_preview">
                <img class="img" src="{{$image->image_url}}">
                <p>{{$image->name}}</p>
                <p>{{$image->album}}</p>
                <p>{{$image->peoples}}</p>
                <p>{{$image->place}}</p>
                <p>{{$image->tags}}</p>
                <a href="{{url('edit-image/'.$image->id)}}"><img class="icons" src="{{asset('images/edit.png')}}"></a>
                <a href="{{url('#')}}"><img class="icons" src="{{asset('images/delete.png')}}"></a>
            </div>
        @empty
            <div class="message">Вы не загрузили ни одной фотографии</div>
        @endforelse


    </div>
    </div>
@endsection
