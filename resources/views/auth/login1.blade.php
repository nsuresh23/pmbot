@extends('layouts.auth')

@section('content')
<div class="container login-box">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style='text-align:center;'>
                    <img src="{{URL::to('/img/RAZOR_slogo.png')}}" width='200' />
                    <h1 style='margin:0px;font-size:25px;margin-top:10px;'>RAZOR Management</h1>

                </div>
                <?php 
                    $login_field = (!empty(old('email'))) ? old('email'):old('username');
                    //$error_login = () ? old('email'):old('username');
                    $error_login = '';
                    if($errors->has('email'))
                        $error_login = $errors->first('email');
                    else if($errors->has('username'))
                        $error_login = $errors->first('username');

                ?>
                <div class="panel-body">
                    <form class="form-horizontal" name="loginform" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div
                            class="form-group{{ ($errors->has('email')|| $errors->has('username')) ? ' has-error' : '' }}">
                            <div class="col-md-3"></div>

                            <div class="col-md-6 has-feedback">
                                <input id="email_or_username" type="text" placeholder="UserName / E-Mail Address"
                                    class="form-control" name="email_or_username" value="{{ $login_field }}" required
                                    autofocus>
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                <!-- <span class="glyphicon glyphicon-user form-control-feedback"></span> -->
                                @if ($error_login)
                                <span class="help-block">
                                    <strong>{{ $error_login }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-3"></div>

                            <div class="col-md-6 has-feedback">
                                <input id="password" type="password" placeholder="Password" class="form-control"
                                    name="password" required>
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-3">
                                <button type="submit" style='color: #ffffff;background-color: #00a651;;width:73%;'
                                    class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" style=' margin-left:20%' href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.authscript')
<script type="text/javascript">
    $(document).ready(function(){
        $("form[name='loginform']").validate({
          // Specify validation rules
          rules: {
            // The key name on the left side is the name attribute
            // of an input field. Validation rules are defined
            // on the right side
             password: {
              required: true,
              minlength: 6
            },
            
          },
          // Specify validation error messages
          messages: {
            password: {
              required: "The field is required",
              minlength: "The password must be at least 6 characters" //The password confirmation does not match.
            },
          },
          // Make sure the form is submitted to the destination defined
          // in the "action" attribute of the form when valid
          submitHandler: function(form) {
            form.submit();
          }
        });
    });
</script>
@endsection