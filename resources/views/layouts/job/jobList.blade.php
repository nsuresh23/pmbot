{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @stack('css')
</head>

<body>
    <div class="wrapper theme-1-active pimary-color-blue">
        <div class="page-wrapper">
            @yield('content')
        </div>
    </div>
    @stack('js')
</body>

</html> --}}

@stack('css')
@yield('content')
@stack('js')
