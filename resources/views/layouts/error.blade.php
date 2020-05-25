<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('includes.head')
    @stack('css')
</head>

<body>

    <!-- #wrapper -->
    <div class="wrapper error-page pa-0">

        @include('includes.errorHeader')
        @yield('content')
        @include('includes.copyRight')
        @include('includes.footer')
         
    </div>
    <!-- /#wrapper -->
    @stack('js')
</body>

</html>
