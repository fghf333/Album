<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/3-col-portfolio.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-tagsinput.css') }}" rel="stylesheet">
    <link href="{{ asset('css/typeahead.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" rel="stylesheet">


    <title>Семейный альбом</title>

    <style>

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

        .buttons {
            background-color: white;
            opacity: 0.5;
            width: 85%;
            position: absolute;
            text-align: right;
            top: 89%;
            padding-left: 5px;
            -webkit-transform: translate(0, -50%);
            -ms-transform: translate(0, -50%);
            transform: translate(0, -50%);
            height: 30px;
            left: 0;
            right: 0;
            margin-right: 24px;
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

        .control_buttons {
            text-align: right;
        }

        .bootstrap-tagsinput .tag {
            background: #09F;
            padding: 5px;
            border-radius: 4px;

        }

        .bootstrap-tagsinput {
            width: 100%;
            text-align: start;
            line-height: 35px;
        }

        .bootstrap-tagsinput input {
            width: 100%;
        }

        span.twitter-typeahead {
            width: 50%;
        }

        .btn-primary {
            background-color: #09F;
        }

        html {
            position: relative;
            min-height: 100%;
        }

        body {
            margin-bottom: 60px; /* Margin bottom by footer height */
        }

        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 60px; /* Set the fixed height of the footer here */
            line-height: 60px; /* Vertically center the text there */
            background-color: #f5f5f5;
        }

        .col-md-6{
            margin-bottom: 25px;
            margin-top: 25px;
        }

        .edit_image {
            width: 100%;
            max-width: 500px;
        }

    </style>
</head>

<body>
<script>

</script>
@include('nav')

<!-- Page Content -->
<div role="main" class="container">

    @yield('content')

</div>
<!-- /.container -->
</body>
@include('footer')
<script src="{{asset('js/slider.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.js')}}"></script>
<script src="{{asset('js/typeahead.bundle.js')}}"></script>
<script src="{{asset('js/bootstrap-tagsinput.js')}}"></script>
<script src="{{asset('js/tags-input.js')}}"></script>
</html>

