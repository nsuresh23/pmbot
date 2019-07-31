<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('includes.head')
    @stack('css')
</head>

<body>
    <div class="wrapper theme-1-active pimary-color-blue">
        @include('includes.header')
        @yield('content')
        @include('includes.footer')
        {{-- <header class="row">
            @include('includes.header')
        </header>
        <div id="main" class="row">
            @yield('content')
        </div>
        <footer class="row">
            @include('includes.footer')
        </footer> --}}
    </div>
    @stack('js')
</body>

</html>
