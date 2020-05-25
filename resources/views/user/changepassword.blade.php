@extends('layouts.app') 
@section('content')
  <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Change Password</h3>
      </div>
  <div class="box-body">
    <div class="row">
        <div class="col-md-7">
           <!--  <div class="panel panel-default">
                <div class="panel-heading"><h1>Change Password</h1></div> -->
              
                 
                <!-- <div class="panel-body"> -->
                  @if(!empty($successmsg))
                    <div class="alert alert-success" style="text-align: center;">
                       <strong>Success!</strong> {{ $successmsg }}
                    </div>
                  @endif
                    <form class="form-horizontal" name="loginform" method="POST" action="{{ route('changepassword') }}">
                        {{ csrf_field() }}

                         <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Old Password</label>

                            <div class="col-md-6 has-feedback">
                                <input id="old_password" type="password" class="form-control" placeholder="Enter old password" value="{{$old_pass}}"  name="old_password" required>
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                @if ($errors->has('old_password'))
                                        <label id="old_password-error" class="error" for="old_password">{{ $errors->first('old_password') }}</label>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6 has-feedback">
                                <input id="password" type="password" class="form-control" placeholder="Enter new password" name="password" required>
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                @if ($errors->has('password'))
                                  <label id="password-error" class="error" for="password">{{ $errors->first('password') }}</label>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                           <?php echo Form::label('password', 'Confirm Pasword', array('for' => 'password','class'=>'col-md-4 control-label')); ?>
                           <div class="col-md-6 has-feedback">
                             <?php
                                    echo Form::password('password_confirmation', $attributes = array('placeholder'=>'Confirm new password','class'=>'form-control'));
                               ?>
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                @if ($errors->has('password_confirmation'))
                                <label id="password_confirmation-error" class="error" for="password_confirmation">{{ $errors->first('password_confirmation') }}</label>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                               {!! Form::submit('Save',  array('class'=>'btn btn-primary')) !!}
                               <?php $loc_path = URL::to('/'); ?>
                               <input type="button" class="btn btn-primary" value="Cancel" onclick="javascript:window.location.href='{{$loc_path}}'" />
                            </div>
                            <!-- <div class="col-md-8 col-md-offset-4">
                               
                            </div> -->
                        </div>
                    </form>
               <!--  </div> 
            </div>-->
        </div>
    </div>
  </div>
  <!-- /.box-body -->
</div> 
  <!-- Footer -->
  @include('layouts.footer')

  @include('layouts.scriptfooter')
<script type="text/javascript">
$(document).ready(function(){
        $("form[name='loginform']").validate({
          // Specify validation rules
          rules: {
            // The key name on the left side is the name attribute
            // of an input field. Validation rules are defined
            // on the right side
            old_password: {
              required: true,
              minlength: 6
            },
             password: {
              required: true,
              minlength: 6
            },
            password_confirmation: {
              required: true,
              minlength: 6
            },
            
          },
          // Specify validation error messages
          messages: {
            old_password: { 
             required: "The old password field is required",
             minlength: "The old password is wrong"
           },
            password: {
              required: "The password field is required",
              minlength: "The password must be at least 6 characters" //The password confirmation does not match.
            },
            password_confirmation:{
              required: "The confirm password field is required",
              minlength: "The confirm password must be at least 6 characters" 
            }
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
