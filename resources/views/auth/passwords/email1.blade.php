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
                                <h3 class="text-center txt-dark mb-10">{{ __('auth.forgotPasswordTitle') }}</h3>
                                <h6 class="text-center txt-grey nonecase-font">{{ __('auth.forgotPasswordSubTitle') }}</h6>
                            </div>
                            <div class="form-wrap">
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label class="control-label mb-10" for="email">{{ __('auth.forgotPasswordEmailLabel') }}</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('auth.forgotPasswordEmailPlaceHolder') }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-primary btn-rounded">{{ __('auth.forgotPasswordButton') }}</button>
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
