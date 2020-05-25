<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('includes.head')
    @stack('css')
</head>

{{-- <body style="background-image: url('{{ asset('img/bg.png') }}');"> --}}
{{-- <body style="background:#1f6e9c;"> --}}

<body>
    <!--Preloader-->
    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div>
    <!--/Preloader-->

    <div class="wrapper pa-0">
        {{-- @include('includes.loginHeaderNav') --}}
        @yield('content')
        @include('includes.footer')
    </div>

    @stack('js')
</body>

</html>
