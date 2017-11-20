@extends('base')

@section('content')
    <!-- Page Heading -->
    <h1 class="PageHead">Page Heading
        <small>Secondary Text</small>
    </h1>
    <div class="row">
        @forelse($list as $album)
            <div class="album_card">
                <img class="img" src="{{$album->preview_img}}">
                <p>{{$album->name}}</p>
                <p>{{$album->description}}</p>
                <p>{{$album->photo_num}}</p>
                <p>{{$album->created_at}}</p>
                <p>{{$album->updated_at}}</p>
            </div>
        @empty
            <div class="message">Вы не создали ни одного альбома</div>
        @endforelse
    </div>

@endsection

