<!-- Top Menu Items -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="mobile-only-brand pull-left">
        <div class="nav-header pull-left">
            <div class="logo-wrap">
                <a href="{{ route('dashboard') }}">
                    <img class="brand-img mr-10" src="{{ asset('img/logo.png') }}" alt="brand" />
                    <span class="brand-text">{{ __('general.appTitle') }}</span>
                </a>
            </div>
        </div>
    </div>
    <div id="mobile_only_nav" class="mobile-only-nav pull-right">
        <ul class="nav navbar-right top-nav pull-right">

            @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('auth.loginButton') }}</a>
            </li>
            @else
            <li class="dropdown alert-drp">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="zmdi zmdi-notifications top-nav-icon"></i><span
                        class="top-nav-icon-badge">5</span></a>
                <ul class="dropdown-menu alert-dropdown" data-dropdown-in="bounceIn" data-dropdown-out="bounceOut">
                    <li>
                        <div class="notification-box-head-wrap">
                            <span class="notification-box-head pull-left inline-block">notifications</span>
                            <a class="txt-danger pull-right clear-notifications inline-block" href="javascript:void(0)"> clear all
                            </a>
                            <div class="clearfix"></div>
                            <hr class="light-grey-hr ma-0" />
                        </div>
                    </li>
                    <li>
                        <div class="streamline message-nicescroll-bar">
                            <div class="sl-item">
                                <a href="javascript:void(0)">
                                    <div class="icon bg-green">
                                        <i class="zmdi zmdi-flag"></i>
                                    </div>
                                    <div class="sl-content">
                                        <span class="inline-block capitalize-font  pull-left truncate head-notifications">
                                            New subscription created</span>
                                        <span class="inline-block font-11  pull-right notifications-time">2pm</span>
                                        <div class="clearfix"></div>
                                        <p class="truncate">Your customer subscribed for the basic plan. The customer will pay $25
                                            per month.</p>
                                    </div>
                                </a>
                            </div>
                            <hr class="light-grey-hr ma-0" />
                            <div class="sl-item">
                                <a href="javascript:void(0)">
                                    <div class="icon bg-yellow">
                                        <i class="zmdi zmdi-trending-down"></i>
                                    </div>
                                    <div class="sl-content">
                                        <span
                                            class="inline-block capitalize-font  pull-left truncate head-notifications txt-warning">Server
                                            #2 not responding</span>
                                        <span class="inline-block font-11 pull-right notifications-time">1pm</span>
                                        <div class="clearfix"></div>
                                        <p class="truncate">Some technical error occurred needs to be resolved.</p>
                                    </div>
                                </a>
                            </div>
                            <hr class="light-grey-hr ma-0" />
                            <div class="sl-item">
                                <a href="javascript:void(0)">
                                    <div class="icon bg-blue">
                                        <i class="zmdi zmdi-email"></i>
                                    </div>
                                    <div class="sl-content">
                                        <span class="inline-block capitalize-font  pull-left truncate head-notifications">2 new
                                            messages</span>
                                        <span class="inline-block font-11  pull-right notifications-time">4pm</span>
                                        <div class="clearfix"></div>
                                        <p class="truncate"> The last payment for your G Suite Basic subscription failed.</p>
                                    </div>
                                </a>
                            </div>
                            <hr class="light-grey-hr ma-0" />
                            <div class="sl-item">
                                <a href="javascript:void(0)">
                                    <div class="sl-avatar">
                                        <img class="img-responsive" src="../img/avatar.jpg" alt="avatar" />
                                    </div>
                                    <div class="sl-content">
                                        <span class="inline-block capitalize-font  pull-left truncate head-notifications">Sandy
                                            Doe</span>
                                        <span class="inline-block font-11  pull-right notifications-time">1pm</span>
                                        <div class="clearfix"></div>
                                        <p class="truncate">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet,
                                            consectetur, adipisci velit</p>
                                    </div>
                                </a>
                            </div>
                            <hr class="light-grey-hr ma-0" />
                            <div class="sl-item">
                                <a href="javascript:void(0)">
                                    <div class="icon bg-red">
                                        <i class="zmdi zmdi-storage"></i>
                                    </div>
                                    <div class="sl-content">
                                        <span
                                            class="inline-block capitalize-font  pull-left truncate head-notifications txt-danger">99%
                                            server space occupied.</span>
                                        <span class="inline-block font-11  pull-right notifications-time">1pm</span>
                                        <div class="clearfix"></div>
                                        <p class="truncate">consectetur, adipisci velit.</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="notification-box-bottom-wrap">
                            <hr class="light-grey-hr ma-0" />
                            <a class="block text-center read-all" href="javascript:void(0)"> read all </a>
                            <div class="clearfix"></div>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="dropdown auth-drp">
                <a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown">
                    <img src="{{ asset('img/user1.png') }}" alt="user_auth" class="user-auth-img img-circle" />
                    <span class="user-online-status"></span>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>
                <ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                    {{-- <li class="divider"></li> --}}
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('auth.loginOutButton') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
            @endguest
        </ul>
    </div>
</nav>
<!-- /Top Menu Items -->
