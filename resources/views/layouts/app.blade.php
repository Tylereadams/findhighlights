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

    {{--Bulma--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.min.css">

    {{--Font Awesome--}}
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    {{--Template--}}
    {{--<link rel="stylesheet" href="https://unpkg.com/bulma-modal-fx/dist/css/modal-fx.min.css" />--}}

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