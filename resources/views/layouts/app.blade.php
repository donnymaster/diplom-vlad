<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    {{-- <script src="{{ asset('js/rating.js') }}"></script> --}}

    <!-- Fonts -->
    {{-- @yield('in-top-css') --}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/rating.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom-css.css') }}">
    <link rel="shortcut icon" href="{{ asset('img/icons.ico') }}" type="image/x-icon">
    @yield('custom-css')
</head>
<body class="bg-default">
    <div id="app">

        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
          
            <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <!-- Navbar links -->
            <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    @if (Auth::check())
                    @include('blocks.user-menu')
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Вхід</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Реєстрація</a>
                        </li>
                    @endif
                </ul>
                </div>
            </div>
          </nav>
        @if(isset($is_not_top_main))
        <main>
        @else
        <main class="py-4">
        @endif
            @yield('content')
        </main>
    </div>
    @yield('custom-js')
    @yield('chat-js')
</body>
</html>
