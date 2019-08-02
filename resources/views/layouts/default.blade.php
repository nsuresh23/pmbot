<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('includes.head')
    @stack('css')
</head>

<body>
    <div class="wrapper theme-1-active pimary-color-blue">
        <div class="page-wrapper">
            @include('includes.header')
            @include('includes.listModal')
            @yield('content')
            @include('includes.copyRight')
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
    </div>
    @stack('js')
</body>

</html>
