@php

    $type = $message = $notificationItemReadUrl = "";

    $readOnlyUser = "true";

    if(session("success") == "true") {

        $type = "success";

    }

    if(session("error") == "true") {

        $type = "error";

    }

    if(session("message")) {

        $message = session("message");

    }

    if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) {

        $readOnlyUser = "false";

    }

    $userInitials = implode('', array_map(function($v) { return strtoupper($v[0]); }, explode(' ', trim(Auth::user()->empname))));

    if(strlen($userInitials) > 2) {

        $userInitials = substr($userInitials, 0, 2);

    }

    if(isset($returnData["data"]) && isset($returnData["data"]["notificationReadUrl"]) && $returnData["data"]["notificationReadUrl"] != "") {

        $notificationItemReadUrl = $returnData["data"]["notificationReadUrl"];

    }

    $notificationCountUrl = route(__("job.notification_count_url"));
    $notificationListUrl = route(__("job.notification_list_url"));
    $notificationReadUrl = route(__("job.notification_read_url"), '');
    $notificationReadAllUrl = route(__("job.notification_read_all_url"));

	$signatureUpdateUrl      = route(__("job.signature_update"));
	$getSignatureUrl         = route(__("job.get_signature"));

@endphp

{{-- @if (session('success') == "true")

    <div class="alert alert-success">
        <strong>Success!</strong> {{ session('message') }}
    </div>

@endif

@if (session('error') == "true")

    <div class="alert alert-danger">
        <strong>Error!</strong> {{ session('message') }}
    </div>

@endif --}}

<div id="flashMessage" class="d-none" data-type="{{ $type }}" data-message="{{ $message }}">
<div id="notificationRead" class="d-none" data-notification-read-url="{{ $notificationItemReadUrl }}">
<div id="currentUserInfo" class="currentUserInfo" data-current-user-role="{{ auth()->user()->role }}" data-read-only-user="{{ $readOnlyUser }}" data-file-upload-url="{{route(__('job.file_upload_url')) ?? ''}}">

<!-- Top Menu Items -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="mobile-only-brand pull-left">
        <div class="nav-header pull-left">
            <div class="logo-wrap">
                <a href="{{ route('home') }}">
                    <img class="brand-img mr-10" src="{{ asset('public/img/logo.png') }}" alt="{{ __('general.appTitle') }}" />
                    <span class="brand-text">{{ __('general.appTitle') }}</span>
                </a>
            </div>
        </div>
        <a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-apps"></i></a>
    </div>
    <div id="mobile_only_nav" class="mobile-only-nav pull-right">
        <ul class="nav navbar-right top-nav pull-right">
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('auth.loginButton') }}</a>
                </li>
            @else

            <li class="dropdown app-drp">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="zmdi zmdi-apps top-nav-icon"></i></a>
                <ul class="dropdown-menu app-dropdown" data-dropdown-in="slideInRight" data-dropdown-out="flipOutX" style="min-width: max-content;">
                    <li>
                        <div class="app-nicescroll-bar">
                            <ul class="app-icon-wrap pa-10">
                                <li>
                                    <a href="{{ route('home') }}" class="connection-item">
                                        <i class="zmdi zmdi-view-dashboard txt-warning"></i>
                                        <span class="block capitalize-font">{{ __('general.dashboard_label') }}</span>
                                    </a>
                                </li>
                                @if (in_array(auth()->user()->role, config('constants.amUserRoles')))
                                <li>
                                    <a href="{{ route(__('user.user_list_url')) }}" class="connection-item">
                                        <i class="fa fa-list txt-success"></i>
                                        <span class="block capitalize-font">{{ __('general.user_label') }}</span>
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <a href="#signatureModal" class="connection-item" role="menuitem" data-toggle="modal" title="signature" data-signature-geturl="{{ $getSignatureUrl ?? '#'}}" data-type="forward">
                                        <i class="fa fa-credit-card txt-info"></i>
                                        <span class="block capitalize-font">Signature</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>

            {{-- <li class="dropdown app-drp">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="zmdi zmdi-apps top-nav-icon"></i></a>
                <ul class="dropdown-menu app-dropdown" data-dropdown-in="slideInRight" data-dropdown-out="flipOutX">
                    <li>
                        <div class="app-nicescroll-bar">
                            <ul class="app-icon-wrap pa-10">
                                @if (Route::currentRouteName() != __('dashboard.dashboard_url'))
                                    <li>
                                        <a href="{{ route('home') }}" class="connection-item">
                                            <i class="zmdi zmdi-view-dashboard txt-info"></i>
                                        <span class="block capitalize-font">{{ __('general.dashboard_label') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (Route::currentRouteName() != __('user.user_list_url') && auth()->user()->role == "admin")
                                    <li>
                                        <a href="{{ route(__('user.user_list_url')) }}" class="connection-item">
                                            <i class="zmdi zmdi-view-dashboard txt-info"></i>
                                            <span class="block capitalize-font">{{ __('general.user_label') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (Route::currentRouteName() != __('user.user_group_list_url'))
                                    <li>
                                        <a href="{{ route(__('user.user_group_list_url')) }}" class="connection-item">
                                            <i class="zmdi zmdi-view-dashboard txt-info"></i>
                                            <span class="block capitalize-font">{{ __('general.user_group_label') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (Route::currentRouteName() != __('user.user_role_list_url'))
                                    <li>
                                        <a href="{{ route(__('user.user_role_list_url')) }}" class="connection-item">
                                            <i class="zmdi zmdi-view-dashboard txt-info"></i>
                                            <span class="block capitalize-font">{{ __('general.user_role_label') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (Route::currentRouteName() != __('user.user_location_list_url'))
                                    <li>
                                        <a href="{{ route(__('user.user_location_list_url')) }}" class="connection-item">
                                            <i class="zmdi zmdi-view-dashboard txt-info"></i>
                                            <span class="block capitalize-font">{{ __('general.user_location_label') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if (Route::currentRouteName() != __('user.job_stage_list_url'))
                                <li>
                                    <a href="{{ route(__('user.job_stage_list_url')) }}" class="connection-item">
                                        <i class="zmdi zmdi-view-dashboard txt-info"></i>
                                        <span class="block capitalize-font">{{ __('general.job_stage_label') }}</span>
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <a href="weather.html" class="connection-item">
                                        <i class="zmdi zmdi-cloud-outline txt-info"></i>
                                        <span class="block">weather</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="inbox.html" class="connection-item">
                                        <i class="zmdi zmdi-email-open txt-success"></i>
                                        <span class="block">e-mail</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="calendar.html" class="connection-item">
                                        <i class="zmdi zmdi-calendar-check txt-primary"></i>
                                        <span class="block">calendar</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="vector-map.html" class="connection-item">
                                        <i class="zmdi zmdi-map txt-danger"></i>
                                        <span class="block">map</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="chats.html" class="connection-item">
                                        <i class="zmdi zmdi-comment-outline txt-warning"></i>
                                        <span class="block">chat</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="contact-card.html" class="connection-item">
                                        <i class="zmdi zmdi-assignment-account"></i>
                                        <span class="block">contact</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li> --}}


            <?php if(session()->has("current_empcode") && session()->get("current_empcode") != auth()->user()->empcode){ ?>
                {{-- <li class="dropdown alert-drp selected-member-header-block" style="display:none;"> --}}
                    {{-- <a href="javascript:void(0)" class="dropdown-toggle selected-member-header btn btn-outline btn-info"></a> --}}
                {{-- </li> --}}
                <li class="dropdown alert-drp">
                <a href="{{ route(__('dashboard.current_user_login_url')) ?? 'javascript:void(0);'}}" class="dropdown-toggle btn btn-outline btn-info" style="text-transform:none;">{{ session()->get("current_empcode") ?? ''}}</a>
                </li>
            <?php } ?>

			<!--<li class="dropdown alert-drp">
                <a href="javascript:void(0)" class="dropdown-toggle settings-count-button" data-toggle="dropdown"><i
                        class="zmdi zmdi-settings top-nav-icon"></i>

                </a>
                <ul class="dropdown-menu alert-dropdown" data-dropdown-in="slideInRight" data-dropdown-out="flipOutX">
                      <li>
                        <div class="notification-box-head-wrap">
                            <span class="notification-box-head pull-left inline-block">Settings</span>

                            <div class="clearfix"></div>
                            <hr class="light-grey-hr ma-0" />
                        </div>
                    </li>
                    <li>
                        <div class="streamline signature-list-block message-nicescroll-bar">
							<div style="float: left;padding: 10px;color: #878787;border-radius: 4px;text-align:center;width:100%;margin-left: 5px;">
								<a href="#signatureModal" role="menuitem" data-toggle="modal" title="reply" class="dashboard-draft-email signature" data-signature-geturl = "{{ $getSignatureUrl ?? '#'}}" data-type = "forward">
									Signature
								</a>

							</div>

						</div>
                    </li>

                </ul>

            </li>-->
			{{-- <li class="dropdown alert-drp">
				<div style="float: left;padding: 5px;color: #878787;border-radius: 4px;border:2px solid #0fc5bb;text-align:center;width:100%;margin-top: 20px;">
					<a href="#signatureModal" role="menuitem" data-toggle="modal" title="reply" class="dashboard-draft-email signature" data-signature-geturl = "{{ $getSignatureUrl ?? '#'}}" data-type = "forward">
						Signature
					</a>

				</div>
			</li> --}}
            <li class="dropdown alert-drp">
                <a href="javascript:void(0)" class="dropdown-toggle notification-count-button"
                    data-notification-count-url="{{$notificationCountUrl ?? ''}}"
                    data-notification-list-url="{{$notificationListUrl ?? ''}}" data-toggle="dropdown"><i
                        class="zmdi zmdi-notifications top-nav-icon"></i>
                    <span class="notification-count">
                        {{-- <span class="top-nav-icon-badge">0</span> --}}
                    </span>
                </a>
                <ul class="dropdown-menu alert-dropdown" data-dropdown-in="slideInRight" data-dropdown-out="flipOutX">
                    <li>
                        <div class="notification-box-head-wrap">
                            <span class="notification-box-head pull-left inline-block">{{__('job.notification_title_label')}}</span>
                            {{-- <a class="txt-danger pull-right clear-notifications inline-block" href="javascript:void(0)">{{__('job.notification_view_all_label')}}</a>
                            --}}
                            <div class="clearfix"></div>
                            <hr class="light-grey-hr ma-0" />
                        </div>
                    </li>
                    <li>
                        <div class="streamline notification-list-block message-nicescroll-bar">
                        </div>
                    </li>
                    <li>
                        <div class="notification-box-bottom-wrap">
                            <hr class="light-grey-hr ma-0" />
                            <a class="block text-center notification-read-all capitalize-font" href="javascript:void(0)"
                                data-notification-read-all-url="{{$notificationReadAllUrl ?? ''}}">{{__('job.notification_read_all_label')}}</a>
                            <div class="clearfix"></div>
                        </div>
                    </li>
                </ul>
            </li>

            <li class="dropdown auth-drp">
                <a href="javascript:void(0)" class="dropdown-toggle pr-0" data-toggle="dropdown">
                    {{-- <img src="{{ asset('public/img/user1.png') }}" alt="user_auth" class="user-auth-img img-circle" /> --}}
                    {{-- <span class="user-online-status"></span> --}}
                    <span class="user-circle bg-{{Auth::user()->role}}">
                        <span class="user-initials">
                            {{ $userInitials ?? '' }}
                        </span>
                    </span>
                    <span class="font-16">
                        {{ Auth::user()->empname }}
                    </span>
                </a>
                {{-- <ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="slideInRight" data-dropdown-out="flipOutX">
                    <li>
                        <a href="#signatureModal" role="menuitem" data-toggle="modal" title="reply" class="dashboard-draft-email signature"
                            data-signature-geturl="{{ $getSignatureUrl ?? '#'}}" data-type="forward">
                            <i class="zmdi zmdi-card txt-warning"></i>
                            <span>
                                Signature
                            </span>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="zmdi zmdi-power txt-danger"></i>
                            <span>Log Out</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul> --}}
            </li>
            <li class="dropdown app-drp">
                <div class="button-list ml-10">
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <button class="btn btn-danger btn-icon-anim btn-circle btn-sm">
                            <i class="zmdi zmdi-power"></i>
                        </button>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>
            @endguest
        </ul>
    </div>
</nav>
<!-- /Top Menu Items -->

{{-- <title>
    {{ ($breadcrumb = Breadcrumbs::current()) ? "$breadcrumb->title –" : '' }}
    {{ ($page = (int) request('page')) > 1 ? "Page $page –" : '' }}
    Demo App
</title> --}}

{{-- @include('includes.breadcrumb') --}}
@include('pages.email.signatureModal')
