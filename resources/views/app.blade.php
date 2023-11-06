<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <link href="/img/favicon.ico" rel="shortcut icon">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Scripts -->
    @routes
    <script src="{{ mix('js/app.js') }}" defer></script>
    @if (config('app.env') == 'local')
    <script src="{{asset('js/app.js')}}"></script>
    @else
    <script src="{{asset(mix('js/app.js'), true)}}"></script>
    @endif
</head>

<body class="font-sans antialiased">
    @inertia

    @env ('local')
    <script src="http://127.0.0.1:8000/browser-sync/browser-sync-client.js"></script>
    @endenv

</body>

</html>