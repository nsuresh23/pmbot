@extends('layouts.login')

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
                                <h3 class="text-center txt-dark mb-10">{{ __('auth.resetPasswordTitle') }}</h3>
                            </div>
                            <div class="form-wrap">
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    <div class="form-group">
                                        {{-- <label class="pull-left control-label mb-10" for="exampleInputpwd_1">Old Password</label>
                                        <input type="password" class="form-control" required="" id="exampleInputpwd_1"
                                            placeholder="Enter pwd"> --}}
                                        <label class="control-label mb-10"
                                            for="email">{{ __('auth.resetPasswordEmailLabel') }}</label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
                                            placeholder="{{ __('auth.resetPasswordEmailPlaceHolder') }}">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="pull-left control-label mb-10"
                                            for="exampleInputpwd_2">{{ __('auth.resetNewPasswordLabel') }}</label>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password"
                                            placeholder="{{ __('auth.resetNewPasswordPlaceHolder') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="pull-left control-label mb-10"
                                            for="exampleInputpwd_3">{{ __('auth.resetConfirmPasswordLabel') }}</label>
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password"
                                            placeholder="{{ __('auth.resetConfirmPasswordPlaceHolder') }}">
                                    </div>
                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-primary btn-rounded">{{ __('auth.resetButton') }}</button>
                                        <a class="btn  btn-primary btn-outline btn-rounded" href="{{ route('login') }}">{{ __('auth.loginButton') }}</a>
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
