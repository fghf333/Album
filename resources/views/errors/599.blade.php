@extends('base')

@section('content')

    <!-- Page Heading -->
    <h1 class="PageHead">СТОП!</h1>
    <h2 class="PageHead">Ваш email находится в спам базе. Если это не так - свяжитесь с <a
                href="mailto:{{env('APP_EMAIL')}}">администратором</a>.</h2>

@endsection
