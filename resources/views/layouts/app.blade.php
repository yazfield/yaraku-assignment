<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">

    <title>{{ config('app.name', 'The book list') }}</title>

</head>
<body>
    <div id="app" class="container">
        <header class="header clearfix">
            <h3 class="text-muted">{{ config('app.name', 'The book list') }}</h3>
            @include('layouts.breadcrumb', ['breadcrumb' => $breadcrumb])
        </header>
        <main role="main">
            @yield('main-heading')
            @include('layouts.alert')
            @yield('content')
        </main>
        <footer class="footer">
            <p>&copy; {{ config('app.name', 'The book list') }} 2017</p>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" 
        integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" 
        integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
