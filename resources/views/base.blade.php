<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/3-col-portfolio.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-tagsinput.css') }}" rel="stylesheet">
    <link href="{{ asset('css/typeahead.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.js"></script>
    <script src="{{asset('js/slider.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.js')}}"></script>


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

        #buttons {
            background-color: white;
            opacity: 0.5;
            width: 90%;
            position: absolute;
            text-align: right;
            top: 89%;
            padding-left: 5px;
            -webkit-transform: translate(0, -50%);
            -ms-transform: translate(0, -50%);
            transform: translate(0, -50%);
            height: 30px;
        }

        #buttons_div {
            position: relative;

        }

        img.card-img-top {
            height: 35%;
            width: auto;
        }

        .btn-success.btn-block {
            margin-bottom: 5px;
        }

        .img-thumbnail {
            height: 185px;
            width: 250px;
        }

    </style>
    <script>

    </script>

</head>

<body>
<script>

</script>
@include('nav')

<!-- Page Content -->
<div class="container wrapper">

    @yield('content')
    <script src="{{asset('js/tags-input.js')}}"></script>
</div>
<!-- /.container -->
</body>
@include('footer')

</html>
