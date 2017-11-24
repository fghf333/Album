<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/3-col-portfolio.css') }}" rel="stylesheet">
    <link href="{{ asset('css/typeahead.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-tagsinput.css') }}" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="{{asset('js/typeahead.bundle.js')}}"></script>
    <script src="{{asset('js/bootstrap-tagsinput.js')}}"></script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <title>Семейный альбом</title>

    <style>

        .row {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .row .text-center .text-lg-left {
            position: relative;
            width: 100%; /* for IE 6 */
        }

        *, ::after, ::before {
            box-sizing: border-box;

        }

        .message {
            margin: auto;
        }

        .container .wrapper {
            text-align: center;
            width: 100%;
            height: 100%;
        }

        .PageHead {
            padding-top: 10vh;
            text-align: center;
        }

        .image_preview {
            height: 350px;
            display: inline-block;
            width: 15%;
            border: 4px double black;
            margin: 10px;
        }

        .image_preview .img {
            width: auto;
            height: 30%;
        }

        .icons {
            width: 25px;
            height: auto;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .FormTable {
            display: table;
            margin: auto;
            text-align: center;
        }

    </style>

</head>

<body>

@include('nav')

<!-- Page Content -->
<div class="container wrapper">

    @yield('content')

</div>
<!-- /.container -->

@include('footer')


</body>

</html>
