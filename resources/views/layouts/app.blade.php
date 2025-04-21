<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="website icon" type="png" href="{{ asset('images/LogoTiximus.png') }}">

    <link rel="stylesheet" href="{{ asset('LTE/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('LTE/plugins/fontawesome-free/css/all.min.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="hold-transition {{ Auth::check() && Auth::user()->role == 'admin' ? 'sidebar-mini' : '' }}">
    <div class="wrapper">

        @include('layouts.navigation')

        @if (Auth::check() && Auth::user()->role == 'admin')
            @include('layouts.sidebar')
        @endif

        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    {{ $slot }}
                </div>
            </section>
        </div>

        @if (Auth::check() && Auth::user()->role == 'user')
            @include('layouts.footer')
        @endif
    </div>

    <script src="{{ asset('LTE/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('LTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('LTE/dist/js/adminlte.min.js') }}"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://kit.fontawesome.com/YOUR_KIT_CODE.js" crossorigin="anonymous"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let isAdmin = @json(Auth::check() && Auth::user()->is_admin);
            if (!isAdmin) {
                document.body.classList.add("sidebar-collapse");
            }
        });
    </script>
</body>

</html>
