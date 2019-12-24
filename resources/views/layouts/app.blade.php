<html lang="en">
<head>
    <title>Find Highlights - @yield('title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-137036648-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-137036648-1');
    </script>


    {{--jQuery--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha256-KM512VNnjElC30ehFwehXjx1YCHPiQkOPmqnrWtpccM=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha256-rByPlHULObEjJ6XQxW/flG2r+22R5dKiAoef+aXWfik=" crossorigin="anonymous" />


    {{--Custom CSS--}}
    <style type="text/css">
        a:visited, a:link, a:active
        {
            text-decoration: none !important;
            /*color: darkgray;*/
        }
    </style>

    {{--Bootstrap 4--}}
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    {{--Font Awesome--}}
    <script defer src="https://use.fontawesome.com/releases/v5.8.2/js/all.js"></script>

    {{--Google Fonts--}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        ul.navbar-nav .active{
            border-bottom: 5px solid black;
        //text-decoration: underline;
        }
    </style>


    @yield('metaTags')

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