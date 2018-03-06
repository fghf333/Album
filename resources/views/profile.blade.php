@extends('base')
@section('content')
    <!-- Page Heading -->
    <h1 class="home-message">Hello World!</h1>

    <table class="table">
        <tbody>
@foreach($data as $key => $value)
    <tr>
        <td>{{$key}}</td>
        <td>{{$value}}</td>
    </tr>
    @endforeach
        </tbody>
    </table>

@endsection
