@extends('layouts.auth.login')

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
                            <div class="form-wrap">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label class="control-label mb-10" for="email">
                                            {{ __('auth.loginUserNameLabel') }}
                                        </label>
                                        {{-- <input id="username" type="username"
                                            class="form-control @error('username') is-invalid @enderror"" name="
                                            username" value="{{ old('username') }}" required autocomplete="username"
                                            autofocus placeholder="{{ __('auth.loginUserNamePlaceHolder') }}">
                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror --}}
                                        <input id="email" type="email"
                                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                                value="{{ old('email') }}" required
                                        autocomplete="email" autofocus
                                        placeholder="{{ __('auth.loginEmailPlaceHolder') }}">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="pull-left control-label mb-10"
                                            for="{{ __('auth.loginPasswordLabel') }}">
                                            {{ __('auth.loginPasswordLabel') }}
                                        </label>
                                        @if (Route::has('password.request'))
                                        <a class="capitalize-font txt-primary block mb-10 pull-right font-12"
                                            href="{{ route('password.request') }}">
                                            {{ __('auth.forgotPassword') }}
                                        </a>
                                        @endif

                                        <div class="clearfix"></div>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password"
                                            placeholder="{{ __('auth.loginPasswordPlaceHolder') }}">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="checkbox checkbox-primary pr-10 pull-left">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label for="remember">{{ __('auth.remember') }}</label>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button type="submit"
                                            class="btn btn-primary  btn-rounded">{{ __('auth.loginButton') }}</button>
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
