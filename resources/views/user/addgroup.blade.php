<?php
     $group_name = '';
     $email_address = '';
     $mobile_number = '';
     $grb_url     = "user/addgroup";
     $but_lbl     = 'Add';
     $group_id    = '';

     if(!empty($usergroup) && count($usergroup)>0)
     {
        $group_name = $usergroup->group_name;
        $email_address = $usergroup->email;
        $mobile_number = $usergroup->mobile_number;
        $grb_url     = "user/editgroup/{$usergroup->id}";
        $but_lbl     = 'Edit';
        $group_id    = $usergroup->id;
     }
    ?>
    <!--  @extends('layouts.app') -->
    @section('content')
    <div class="box box-default">
      <div class="box-header with-border">
  		  <h3 class="box-title">{{$but_lbl}} User Group</h3>
      </div>
      <div class="box-body">
        <div class="row">
      		 {{ Form::open(array('url' => $grb_url, 'method' => 'post','name'=>'groupregistration')) }}
                <div class="col-md-12">
                  <div class="col-md-6 form-group">
                     <?php 
                            echo Form::label('groupname', 'Group Name', array('for' => 'groupname'));
                            echo Form::text('group_name', $value = $group_name, $attributes = array('placeholder'=>'Enter Group Name','class'=>'form-control'));
                       ?>
                        {!! $errors->first('group_name', '<p class="text-danger">:message</p>') !!}
                  </div>
            			<div class="col-md-6 form-group">
                            <?php echo Form::label('email', 'E-Mail Address', array('for' => 'email'));
                                  echo Form::email('email', $value = $email_address, $attributes = array('placeholder'=>'Enter email','class'=>'form-control'));
                             ?>
                             {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
            			</div>
                </div>
                <div class="col-md-12 form-group chglink" style="padding-left: 30px;">
                    <a href="javascript:void(0);" onclick="showpass();">Change Password</a>
                </div>
                <div class="col-md-12 form-group" id="changepassword" style="display:none;">
                     <div class="col-md-6 form-group">
                           <?php echo Form::label('password', 'Pasword', array('for' => 'password','class'=>'frmlabel'));
                                  echo Form::password('password', $attributes = array('placeholder'=>'Enter Password','class'=>'form-control'));
                             ?>
                              {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
                      </div>
                      <div class="col-md-6 form-group">
                           <?php echo Form::label('password', 'Confirm Pasword', array('for' => 'password','class'=>'frmlabel'));
                                  echo Form::password('password_confirmation', $attributes = array('placeholder'=>'Enter Password','class'=>'form-control'));
                             ?>
                              {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
                      </div>
                  </div>
                <div class="col-md-12">
            			<div class="col-md-6 form-group">
            			  <?php echo Form::label('mobile', 'Mobile Number', array('for' => 'mobile'));
                                  //echo Form::text('mobile', $value = $mobile_number, $attributes = array('placeholder'=>'Enter Mobile Number','class'=>'form-control'));
                            ?>
                            <!-- data-inputmask='"mask": "(999) 999-9999"' data-mask -->
                            <!-- <p class="help-block">+91 </p> --><input type="text" id="mobile" value="{{$mobile_number}}" name="mobile" class="form-control valid" placeholder="Enter Mobile Number" data-inputmask='"mask": "9999999999"' data-mask>
            			</div>
                </div>
                <div class="col-md-12"> {{Form::label('tickettype', 'Ticket Type:', array('for' => 'tickettype','class'=>'frmlabel'))}}</div>
                <div class="col-md-12">
                  <?php 
                  foreach($tickettypelist as $tkey=>$tvalue)
                  { ?>
                    <div class="col-md-6 form-group">
                      <?php 
                        $lbl_name = formatstring($tvalue['ticket_type_name']);
                        $tkt_val  = (!empty($usergroup->$lbl_name))? $usergroup->$lbl_name:'';
                       echo Form::label('lbl'.$lbl_name, str_replace("_", " ", $tvalue['ticket_type_name']));
                       echo Form::number($lbl_name, $value = $tkt_val, $attributes = array('placeholder'=>'Alloted Volume','class'=>'form-control numeric'));
                      ?>
                    </div>
              <?php
                  }
                ?>
                </div>
                <div class="col-md-12 form-group txtcenter">
                 {!! Form::submit('Save',  array('class'=>'btn btn-primary')) !!}
                 <a class="btn btn-primary" href="{{url('user/grouplist')}}"> Back to UserGroup</a>
            		 {{ Form::close() }}
                </div>
        </div>
          <!-- /.row -->
      </div>
        <!-- /.box-body -->
    </div>
  <!-- Footer -->
  @include('layouts.footer')

  @include('layouts.scriptfooter')
  <script type="text/javascript">
    @if ($errors->first('password')|| empty($group_id))
      showpass();
    @endif 
    function showpass(){
      $("#changepassword").show();
      $(".chglink").hide();
    }
    $('[data-mask]').inputmask();
    //$(".numeric").inputmask('/^[0-9]+$/');//{ decimal : ".",  negative : false, scale: 3 }
    //$(function() {
      $(document).ready(function(){
        // Initialize form validation on the registration form.
        // It has the name attribute "registration"
        $("form[name='groupregistration']").validate({
          // Specify validation rules
          rules: {
            // The key name on the left side is the name attribute
            // of an input field. Validation rules are defined
            // on the right side
            group_name: "required",
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
            password_confirmation: {
              required: true,
              minlength: 6
            }
          },
          // Specify validation error messages
          messages: {
            group_name: "The group name field is required",
            password: {
              required: "The password field is required",
              minlength: "The password must be at least 6 characters" //The password confirmation does not match.
            },
            password_confirmation: {
              required: "The confirm password field is required",
              minlength: "The confirm password must be at least 6 characters" //The password confirmation does not match.
            },
            email: "Please enter a valid email address"
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
