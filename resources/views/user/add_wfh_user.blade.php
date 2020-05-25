<?php
            $useremail   = '';
            $user_name   = '';
            $user_attr   = array();
            $but_lbl     = 'Add';
            $sub_url     = 'user/addwfhuser/'.$group_id;
            $user_status = 1;
            if(!empty($user_details) && count($user_details)>0)
              {
                  $group_id    = $user_details->group_id;
                  $useremail   = $user_details->email;
                  $user_name   = $user_details->username;
                  $user_status = $user_details->status;
                  $but_lbl     = 'Edit';
                  $sub_url     = "user/editwfhuser/{$user_details->id}";
              }
              $group_txt   = !empty($usergroup[$group_id]) ? ' in '.$usergroup[$group_id]:'';
       ?>
    <!--  @extends('layouts.app') -->
    @section('content')
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">{{$but_lbl}} User {{$group_txt}}</h3>
          @if (session('status'))
              <div class="alert alert-success">
                 <strong>Success!</strong> {{ session('status') }}
              </div>
          @endif 
        </div>
        <div class="box-body">
            <!-- <div class="row"> -->
           {{ Form::open(array('url' => $sub_url, 'method' => 'post','class'=>'','name'=>'addwfhuser')) }}
                  <div class="row form-group">
                      <div class="col-md-6 mb-3">
                       <?php //echo Form::label('groupname', 'Group Name: ', array('for' => 'group_name','class'=>'frmlabel')); ?>
                         <?php
                                echo Form::hidden('group_name', $value = $group_id,array('class'=>'form-control','id'=>'group_name'));
                                //echo Form::text('group_name_txt', $value = $usergroup[$group_id],array('class'=>'form-control','id'=>'group_name_txt','readonly'=>'readonly','disabled'=>'disabled'));
                           ?>
                            {!! $errors->first('group_name', '<p class="text-danger">:message</p>') !!}
                    </div>
                  </div>
                  <div class="row form-group">
                    <div class="col-md-6">
                       <?php echo Form::label('username', 'User Name:', array('for' => 'username','class'=>'frmlabel'));
                              echo Form::text('user_name', $value = $user_name, $attributes = array('placeholder'=>'Enter User Name','class'=>'form-control'));
                         ?>
                          {!! $errors->first('user_name', '<p class="text-danger">:message</p>') !!}
                    </div>
                    <div class="col-md-6">
                        <?php echo Form::label('email', 'E-Mail Address:', array('for' => 'email','class'=>'frmlabel'));
                              echo Form::email('email', $value = $useremail, $attributes = array('placeholder'=>'Enter email','class'=>'form-control'));
                         ?>
                         {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
                      </div>
                  </div>
                  <div class="row col-md-12 form-group chglink">
                    <a href="javascript:void(0);" onclick="showpass();">Change Password</a>
                  </div>
                  <div class="row form-group" id="changepassword"  style="display:none;">
                     <div class="col-md-6 mb-3">
                           <?php echo Form::label('password', 'Pasword', array('for' => 'password','class'=>'frmlabel'));
                                  echo Form::password('password', $attributes = array('placeholder'=>'Enter Password','class'=>'form-control'));
                             ?>
                              {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
                      </div>
                      <div class="col-md-6 mb-3">
                           <?php echo Form::label('password_confirmation', 'Confirm Pasword', array('for' => 'password_confirmation','class'=>'frmlabel'));
                                  echo Form::password('password_confirmation', $attributes = array('placeholder'=>'Enter Password','class'=>'form-control'));
                             ?>
                              {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
                      </div>
                  </div>
                  <div class="row">

                    <div class="col-md-6 mb-3 ticket_type">
                       <div style='float:left;width:50%;' class="form-group ticket_type">
                          {{Form::label('tickettype', 'Ticket Type:', array('for' => 'tickettype','class'=>'frmlabel'))}}
						  
						  
                             <?php 
                              foreach($tickettypelist as $tkey=>$tvalue)
                              {  if($tkey == '1' || $tkey == '2' || $tkey == '3' || $tkey == '4' || $tkey == '6') {?>
                                <div class="checkbox">
                                  <label>
                                    <?php 
									 
										  $lbl_name = formatstring($tvalue);

										  $checked_tkt = (!empty($userticket_type) && in_array($tkey,$userticket_type)) ? true:false;

										 echo Form::checkbox('user_tickettype[]', $value = $tkey,$checked_tkt, $attributes = array('placeholder'=>'Enter '.ucfirst($tvalue))).' '.ucfirst($tvalue);
										
                                    ?>
                                </label>
                                </div>
                          <?php
                              }}
                            ?>
							
                        </div>
						<div style='float:left;width:50%;' class="form-group ticket_type">
                          <label for="tickettype" class="frmlabel">Final QC</label>
                             <?php 
                              foreach($tickettypelist as $tkey=>$tvalue)
                              {  if($tkey != '1' && $tkey != '2' && $tkey != '3' && $tkey != '4' && $tkey != '6') {?>
                                <div class="checkbox">
                                  <label>
                                    <?php 
									 
										  $lbl_name = formatstring($tvalue);

										  $checked_tkt = (!empty($userticket_type) && in_array($tkey,$userticket_type)) ? true:false;

										 echo Form::checkbox('user_tickettype[]', $value = $tkey,$checked_tkt, $attributes = array('placeholder'=>'Enter '.ucfirst($tvalue))).' '.ucfirst(str_replace("Validation_", " ", $tvalue));
										
                                    ?>
                                </label>
                                </div>
                          <?php
                              }}
                            ?>
							
                        </div>
                        </div>
                        <div class="col-md-6">
                          <?php echo Form::label('status', 'Status:', array('for' => 'status','class'=>'frmlabel'));

                            $active_status = 'true';
                            $in_active_status = '';
                            if($user_status!=1)
                            {
                              $active_status = '';
                              $in_active_status = 'true';
                            }

                           ?>
                           <br>
                           <label class="radio-inline">
                            {{ Form::radio('status', 1, $active_status, ['class' => 'radio']) }} Active
                            </label>
                            <label class="radio-inline">
                            {{ Form::radio('status', 0, $in_active_status, ['class' => 'radio']) }} In Active
                            </label>
                       </div>
                        
                  </div>
                  <!-- <div class="row"> -->
                           {!! Form::submit('Save',  array('class'=>'btn btn-primary')) !!}
                          <a class="btn btn-primary" href="{{url('user/groupuserlist/'.$group_id)}}"> Back to Userlist</a>
                  <!-- </div> -->
      
           {{ Form::close() }}
           </div>
          <!-- /.box-body -->
      </div>
    <!-- Footer -->
  @include('layouts.footer')

  @include('layouts.scriptfooter')
<script type="text/javascript">
  @if ($errors->first('password')|| empty($user_details->id))
    showpass();
  @endif 
  function showpass(){
    $("#changepassword").show();
    $(".chglink").hide();
  }
  $(document).ready(function(){
        $("form[name='addwfhuser']").validate({
          // Specify validation rules
          rules: {
            // The key name on the left side is the name attribute
            // of an input field. Validation rules are defined
            // on the right side
            user_name: "required",
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
            user_name: "The username field is required",
            password: {
              required: "The password field is required",
              minlength: "The password must be at least 6 characters" //The password confirmation does not match.
            },
            password_confirmation: {
              required: "The confirm password field is required",
              minlength: "The confirm password must be at least 6 characters" //The password confirmation does not match.
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
