<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Job Finder</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('/img/favicon.ico')}}">

    <!-- CSS here -->
    <link rel="stylesheet" href=" {{ asset('css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href=" {{ asset('css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href=" {{ asset('css/price_rangs.css') }}" type="text/css">
    <link rel="stylesheet" href=" {{ asset('css/flaticon.css') }}" type="text/css">
    <link rel="stylesheet" href=" {{ asset('css/slicknav.css') }}" type="text/css">
    <link rel="stylesheet" href=" {{ asset('css/animate.min.css') }}" type="text/css">
    <link rel="stylesheet" href=" {{ asset('css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href=" {{ asset('css/fontawesome-all.min.css') }}" type="text/css">
    <link rel="stylesheet" href=" {{ asset('css/slick.css') }}" type="text/css">
{{--    <link rel="stylesheet" href=" {{ asset('css/nice-select.css') }}" type="text/css">--}}
    <link rel="stylesheet" href=" {{ asset('css/style.css') }}" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div id="app">
    <App></App>
</div>
<script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
<script src=" {{ asset('js/vendor/modernizr-3.5.0.min.js') }}"></script>
<script src=" {{ asset('js/vendor/jquery-1.12.4.min.js') }}"></script>
<script src=" {{ asset('/js/popper.min.js') }}"></script>
<script src=" {{ asset('js/bootstrap.min.js') }}"></script>
<script src=" {{ asset('js/jquery.slicknav.min.js') }}"></script>
<script src=" {{ asset('js/owl.carousel.min.js') }}"></script>
<script src=" {{ asset('js/slick.min.js') }}"></script>
<script src=" {{ asset('js/price_rangs.js') }}"></script>
<script src=" {{ asset('js/wow.min.js') }}"></script>
<script src=" {{ asset('js/animated.headline.js') }}"></script>
<script src=" {{ asset('js/jquery.magnific-popup.js') }}"></script>
<script src=" {{ asset('js/jquery.scrollUp.min.js') }}"></script>
{{--<script src=" {{ asset('js/jquery.nice-select.min.js') }}"></script>--}}
<script src=" {{ asset('js/contact.js') }}"></script>
<script src=" {{ asset('js/jquery.form.js') }}"></script>
<script src=" {{ asset('js/jquery.validate.min.js') }}"></script>
<script src=" {{ asset('js/mail-script.js') }}"></script>
<script src=" {{ asset('js/jquery.ajaxchimp.min.js') }}"></script>
<script src=" {{ asset('js/plugins.js') }}"></script>
<script src=" {{ asset('js/main.js') }}"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
</body>
</html>
