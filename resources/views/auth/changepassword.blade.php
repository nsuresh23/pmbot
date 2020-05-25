@extends('layouts.auth')

@section('content')
 <div class="container login-box">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>Change Password</h1></div>

                <div class="panel-body">
                    <form class="form-horizontal" name="loginform" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6 has-feedback">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                <!-- <span class="glyphicon glyphicon-user form-control-feedback"></span> -->
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6 has-feedback">
                                <input id="password" type="password" class="form-control" name="password" required>
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                           <?php echo Form::label('password', 'Confirm Pasword', array('for' => 'password','class'=>'frmlabel'));
                                  echo Form::password('password_confirmation', $attributes = array('placeholder'=>'Enter Password','class'=>'form-control'));
                             ?>
                              {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                               {!! Form::submit('Save',  array('class'=>'btn btn-primary')) !!}
                            </div>
                            <div class="col-md-8 col-md-offset-4">
                               <input type="button" value="Cancel" onclick="history.back();" />
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
            email: {
              required: true,
              // Specify that email should be validated
              // by the built-in "email" rule
              email: true
            },
             password: {
              required: true,
              minlength: 6
            },
            
          },
          // Specify validation error messages
          messages: {
            email: "Please enter a valid email address",
            password: {
              required: "The password field is required",
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
