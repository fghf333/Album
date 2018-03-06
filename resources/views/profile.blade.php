@extends('base')
@section('content')
    <!-- Page Heading -->
    <h1 class="home-message">Hello World!</h1>

    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" type="button" id="dropdownMenu2" aria-haspopup="true" aria-expanded="false">
            Dropdown
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
            <button class="dropdown-item" type="button">Action</button>
            <button class="dropdown-item" type="button">Another action</button>
            <button class="dropdown-item" type="button">Something else here</button>
        </div>
    </div>

@endsection
