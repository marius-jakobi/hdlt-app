<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', env('APP_NAME', 'Laravel'))</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include('navbar')
        <main class="main-content">
            <div class="container-fluid">
                @if(session('error'))
                    <div class="alert bg-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert bg-success mt-3 alert-dismissable fade show">
                        {{ session('success') }}
                        <button class="close" data-dismiss="alert">
                            &times;
                        </button>
                    </div>
                @endif
                <div class="row mt-3">
                    <div class="col-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
        @include('footer')
    </div>
</body>
</html>
