@extends('layouts.auth.login')

@push('css')
<!-- Custom CSS -->
<link href="{{ asset('public/css/custom/css/custom.css') }}" rel="stylesheet">
@endpush

@section('content')

<!-- Main Content -->
<div class="page-wrapper pa-0 ma-0 auth-page">
    <div class="container-fluid">
        <!-- Row -->
        <div class="table-struct full-width full-height">
            <div class="table-cell vertical-align-middle auth-form-wrap">
                <div class="auth-form  ml-auto mr-auto no-float">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            @include('includes.loginHeader')
                            <div class="mb-30">
                                <h3 class="text-center txt-dark mb-10">{{ __('auth.loginTitle') }}</h3>
                                <h6 class="text-center nonecase-font txt-grey">{{ __('auth.loginSubTitle') }}</h6>
                            </div>
                            <?php

                                $userLoginPostUrl = route( __('auth.userLoginPostURl') );
                                $userMFAPostUrl = route( __('auth.userMFAPostURl') );

                                $login_field = (!empty(old('email'))) ? old('email'):old('username');

                                $error_login = "";
                                $error_password = "";
                                $password_error = "";
                                $error_ldap_password = "";
                                $ldap_password_error = "";

                                $error_mfa = "";
                                $mfa_error = "";

                                $qrCodeUrl = "";

                                // if(isset($errors)) {

                                //     if($errors->has('email')) {

                                //         $error_login = $errors->first('email');

                                //     }

                                //     if($errors->has('username')) {

                                //         $error_login = $errors->first('username');

                                //     }

                                //     if($errors->has('password')) {

                                //         $password_error = $errors->has('password');

                                //         $error_password = $errors->first('password');

                                //     }

                                //     if($errors->has('ldap_password')) {

                                //         $ldap_password_error = $errors->has('ldap_password');

                                //         $error_ldap_password = $errors->first('ldap_password');

                                //     }

                                // }

                                // if(isset($errors) && $errors->has('email'))
                                //     $error_login = $errors->first('email');
                                // else if(isset($errors) && $errors->has('username'))
                                //     $error_login = $errors->first('username');

                            ?>

                            @if (session('message'))

                            <?php

                                if(session("success") == "true") {

                                    $alertType = "alert-success";

                                }

                                if(session("error") == "true") {

                                    $alertType = "alert-danger";

                                }

                            ?>

                            <div class="alert {{$alertType}}" role="alert">
                                <ul>
                                    <li>
                                        <span class="help-block" style="color:#ffff;">
                                            <strong>{{ session('message') }}</strong>
                                        </span>
                                    </li>
                                </ul>
                            </div>

                            @endif

                            <div class="alert alert-warning has-error login-error-block hiddenBlock" role="alert">
                                <span class="login-error-message txt-light"></span>
                            </div>

                            <?php if(isset($errors)) { ?>
                                @if ($errors->any())
                                <div class="alert alert-warning has-error" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>
                                            <span class="help-block">
                                                <strong>{{ $error }}</strong>
                                            </span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            <?php } ?>

                            <div class="form-wrap">
                                <div id="loader" class="login_loader" style="display: none;width: 100%;height: 100%;position: absolute;padding: 2px;z-index: 1;text-align: center;">
                                    <img src="{{ asset('public/img/loader2.gif') }}" width="64" height="64" />
                                </div>
                                <form class="login-form" method="POST" action="">
                                    {{ csrf_field() }}

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 login-block pa-0">

                                        <div class="form-group">
                                            <div class="has-feedback">
                                                <label class="control-label mb-10" for="email">
                                                    {{ __('auth.loginUserNameLabel') }}
                                                </label>
                                                <input id="email_or_username" type="text"
                                                    class="form-control @if ($error_login) is-invalid @endif"
                                                    name="email_or_username" value="{{ old('email') }}" required
                                                    autocomplete="email_or_username" autofocus
                                                    placeholder="{{ __('auth.loginEmailPlaceHolder') }}">

                                                @if ($error_login)
                                                <span class="invalid-feedback help-block">
                                                    <strong>{{ $error_login }}</strong>
                                                </span>
                                                @endif

                                            </div>
                                        </div>
                                        {{-- <div class="form-group{{ $password_error ? ' has-error' : '' }}">
                                            <div class="has-feedback">

                                                <label class="pull-left control-label mb-10"
                                                    for="{{ __('auth.loginPasswordLabel') }}">
                                                    {{ __('auth.loginPasswordLabel') }}
                                                </label>
                                                <div class="clearfix"></div>

                                                <input id="password" type="password"
                                                    class="form-control @if ($password_error) is-invalid @endif"
                                                    name="password" required autocomplete="new-password"
                                                    placeholder="{{ __('auth.loginPasswordPlaceHolder') }}">

                                                @if ($password_error)
                                                    <span class="invalid-feedback help-block">
                                                        <strong>{{ $error_password }}</strong>
                                                    </span>
                                                @endif

                                            </div>
                                        </div> --}}

                                        <div class="form-group{{ $ldap_password_error ? ' has-error' : '' }}">
                                            <div class="has-feedback">
                                                <label class="pull-left control-label mb-10" for="{{ __('auth.loginLdapPasswordLabel') }}">
                                                    {{ __('auth.loginLdapPasswordLabel') }}
                                                </label>

                                                <div class="clearfix"></div>

                                                <input id="ldap-password" type="password" class="form-control @if ($ldap_password_error) is-invalid @endif"
                                                    name="ldap_password" autocomplete="new-password"
                                                    placeholder="{{ __('auth.loginLdapPasswordPlaceHolder') }}" required>
                                                @if ($ldap_password_error)
                                                <span class="invalid-feedback help-block">
                                                    <strong>{{ $error_ldap_password }}</strong>
                                                </span>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="has-feedback">
                                                <div class="checkbox checkbox-primary pr-10 pull-left">
                                                    <input class="form-check-input" type="checkbox" name="remember"
                                                        id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label for="remember">{{ __('auth.remember') }}</label>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group text-center">
                                            <button class="btn btn-primary btn-rounded login-btn" data-post-url={{$userLoginPostUrl ?? ''}}>{{ __('auth.loginButton') }}</button>
                                        </div>

                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mfa-block hiddenBlock pa-0">

                                        <div class="form-group login-qr-code-block">
                                            <img class="login-qr-code" src="" width="100%" height="80%" />
                                        </div>

                                        <div class="form-group{{ $mfa_error ? ' has-error' : '' }}">
                                            <div class="has-feedback">
                                                <label class="pull-left control-label mb-10" for="mfa-code-label">
                                                    {{ __('auth.mfaOTPLabel') }}
                                                </label>

                                                <div class="clearfix"></div>

                                                <input id="mfa-code" type="text" class="form-control @if ($mfa_error) is-invalid @endif" name="mfa_code" required autocomplete="off" placeholder="{{ __('auth.mfaOTPPlaceHolder') }}">

                                                @if ($mfa_error)
                                                    <span class="invalid-feedback help-block">
                                                        <strong>{{ $error_mfa }}</strong>
                                                    </span>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="form-group text-center">

                                            <button class="btn btn-primary  btn-rounded mfa-submit-btn" data-post-url={{$userMFAPostUrl ?? ''}}>{{ __('auth.mfaSubmitButton') }}</button>

                                        </div>

                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Row -->
    </div>

</div>
<!-- /Main Content -->

@endsection
