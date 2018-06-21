@extends('base')

@section('content')

    <h1 class="PageHead">Семья
    </h1>
    <div class="row justify-content-center">
        <ul class="list-group">
            @foreach($data as $user)
                <li class="list-group-item">{{$user->first_name}} {{$user->last_name}} @if($user->family_admin == 1)
                        <span class="badge badge-secondary">Админ</span> @endif</li>
            @endforeach
        </ul>
    </div>

@endsection