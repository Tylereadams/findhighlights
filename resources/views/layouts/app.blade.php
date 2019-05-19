<html>
<head>
    <title>Find Highlights - @yield('title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{--<link href="{{ asset('css/hero.css') }}" rel="stylesheet">--}}

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-137036648-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-137036648-1');
    </script>

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    {{--Font Awesome--}}
    <script defer src="https://use.fontawesome.com/releases/v5.8.2/js/all.js"></script>
    {{--jQuery--}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    {{--jQuery UI--}}
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <style type="text/css">
        a:visited, a:link, a:active
        {
            text-decoration: none !important;
        }
    </style>

</head>
<body>
    <section class="has-text-grey-dark">

        @include('includes.header')

        @yield('content')
    </section>

    @include('includes.footer')

    @stack('scripts')
</body>
</html>