<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<!--Preloader-->
<div class="preloader-it">
    <div class="la-anim-1"></div>
</div>
<!--/Preloader-->

<head>
    @include('includes.head')
    @stack('css')
</head>

<body>
    <div class="wrapper theme-1-active pimary-color-blue">
        <div class="page-wrapper pt-55 pl-0 pr-0">
            @include('includes.header')
            {{-- {!! Breadcrumbs::render() !!} --}}
            @include('includes.breadcrumb')
            @include('includes.listModal')
            @include('includes.noteModal')
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
            <div class="minmaxCon">
                <div id="minimized-modal-dock" class="modal minimized-modal-dock in min" style="display: none;">
                    <div class="">
                        <div class="modal-content txt-light border-none">
                            <div class="modal-header bg-success">

                                <button type="button" class="minimized-modal-dock-close minimized-modal-dock-btn txt-light" data-modal-type=""> <i
                                        class="fa fa-times"></i> </button>
                                <button class="minimized-modal-dock-max minimized-modal-dock-btn txt-light" data-modal-type=""> <i
                                        class="fa fa-clone"></i> </button>

                                <h5 class="minimized-modal-dock-title mt-8"></h5>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
        </div>
    </div>
    @stack('js')
</body>

</html>
