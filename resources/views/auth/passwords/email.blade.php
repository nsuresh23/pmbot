@extends('layouts.auth')

@section('content')
<div class="container login-box">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>Reset Password</h1></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}" name="resetform">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6 has-feedback">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary hidehelp">
                                    Send Password Reset Link
                                </button>
                                <a class="btn btn-link" href="{{ route('login') }}">
                                    Login
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
    $( ".hidehelp" ).click(function() {
        $('.help-block').hide();
        });
        $("form[name='resetform']").validate({
          // Specify validation rules
          rules: {
            // The key name on the left side is the name attribute
            // of an input field. Validation rules are defined
            // on the right side
            email: {
              required: true,
              // Specify that email should be validated
              // by the built-in "email" rule
              email: true
            },
            
          },
          // Specify validation error messages
          messages: {
            email: "Please enter a valid email address",
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
