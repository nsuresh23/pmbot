<?php
            $domain_name = '';   
            $useremail   = '';
            $user_name   = '';
			$name		 = '';
			$doj		 = '';
            $user_status = 1;
            $user_attr   = array();
            $but_lbl     = 'Add';
            $sub_url     = 'user/add_user';
            if(!empty($user_details))
              {
                  $domain_name =$user_details->group_id;
                  $useremail   = $user_details->email;
                  $user_name   = $user_details->username;
				  $name		   = $user_details->name;
				  $doj		   = $user_details->doj;
                  $user_status = $user_details->status;
                  $user_attr   = array("readonly"=>"readonly");
                  $but_lbl     = 'Edit';
                  $sub_url     = "user/edituser/{$user_details->id}";
              }
			  
       ?>
    <!--  @extends('layouts.app') -->
    @section('content')
     <div class="box box-default">
        <div class="box-header with-border">
  		      <h3 class="box-title">{{$but_lbl}} User</h3>
          @if (session('status'))
              <div class="alert alert-success">
                 <strong>Success!</strong> {{ session('status') }}
              </div>
          @endif 
        </div>
          <div class="box-body">
            <div class="row">
        		 {{ Form::open(array('url' => $sub_url, 'method' => 'post','class'=>'','name'=>'addinhouseuser')) }}
                    <div class="col-md-6">
                      <div class="form-group">
                         <?php echo Form::label('domainname', 'Domain Name: ', array('for' => 'domain_name','class'=>'frmlabel')); ?>
                           <?php
                                  echo Form::select('domain_name', [null => 'Select Domain Name'] + $usergroup,$domain_name,array('class'=>'form-control','id'=>'domain_name'));
                             ?>
                              {!! $errors->first('domain_name', '<p class="text-danger">:message</p>') !!}
                      </div>
                      <div class="form-group">
                         <?php echo Form::label('username', 'User Name:', array('for' => 'username','class'=>'frmlabel'));
                                echo Form::text('user_name', $value = $user_name, $attributes = array('placeholder'=>'Enter User Name','class'=>'form-control')+$user_attr);
                           ?>
                            {!! $errors->first('user_name', '<p class="text-danger">:message</p>') !!}
                      </div>
					  
					  <div class="form-group">
                         <?php echo Form::label('name', 'Name:', array('for' => 'name','class'=>'frmlabel'));
                                echo Form::text('name', $value = $name, $attributes = array('placeholder'=>'Enter Name','class'=>'form-control'));
                           ?>
                            {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                      </div>
					  
					  <div class="form-group">
                         <?php echo Form::label('doj', 'DOJ:', array('for' => 'doj','class'=>'frmlabel'));
                                echo Form::text('doj', $value = $doj, $attributes = array('placeholder'=>'Enter DOJ','class'=>'form-control doj'));
                           ?>
                            {!! $errors->first('doj', '<p class="text-danger">:message</p>') !!}
                      </div>
					  
					  
                      <div class="form-group">
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
                    <div class="col-md-6">
                        <div class="form-group">
                          <?php echo Form::label('email', 'E-Mail Address:', array('for' => 'email','class'=>'frmlabel'));
                                echo Form::email('email', $value = $useremail, $attributes = array('placeholder'=>'Enter email','class'=>'form-control'));
                           ?>
                           {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
                        </div>
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

										 echo Form::checkbox('user_tickettype[]', $value = $tkey,$checked_tkt, $attributes = array('placeholder'=>'Enter '.ucfirst($tvalue))).' '.ucfirst(str_replace("Validation_", "", $tvalue));
										
                                    ?>
                                </label>
                                </div>
                          <?php
                              }}
                            ?>
							
                        </div>
                    </div>
                    <div class="col-md-12 form-group txtcenter">
                             {!! Form::submit('Save',  array('class'=>'btn btn-primary')) !!}
                            <a class="btn btn-primary" href="{{url('user/user_list')}}"> Back to Userlist</a>
                    </div>
        
        		 {{ Form::close() }}
            </div>
            <!-- /.row -->
          </div>
          <!-- /.box-body -->
      </div>
  <!-- Footer -->
  @include('layouts.footer')

  @include('layouts.scriptfooter')
<script type="text/javascript">
  $('#user_type').on('change', function(e){
          var selectedval = $(this).val();
          if(selectedval=='in-house')
          {
              $('.inhouse_div').show();
          }
          $.ajax({
             type: 'POST',
            url: 'user/getusertype',
            data: selectedval,
            success: function(data){
                //jQuery("#grouplist").html(data);
                alert(data);
            },
          });
           /*$.ajax({url: "", success: function(result){
                $("#grouplist").html(result);
            }});*/

  });
  $(document).ready(function(){
        $("form[name='addinhouseuser']").validate({
          // Specify validation rules
          rules: {
            // The key name on the left side is the name attribute
            // of an input field. Validation rules are defined
            // on the right side
            domain_name: "required",
            user_name: "required",
            
          },
          // Specify validation error messages
          messages: {
            domain_name: "The domainname field is required",
            user_name: "The username field is required",
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
