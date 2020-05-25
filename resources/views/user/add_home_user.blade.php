
    <!--  @extends('layouts.app') -->
    @section('content')
  		  <h1>Add User</h1>
        <!-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif -->
  		 {{ Form::open(array('url' => 'user/adduser', 'method' => 'post')) }}
            <div class="form-group">
                  <?php echo Form::label('email', 'E-Mail Address', array('for' => 'email'));
                        echo Form::email('email', $value = null, $attributes = array('placeholder'=>'Enter email','class'=>'form-control'));
                   ?>
                   {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
            </div>
      			<div class="ticket_type">
        <?php 
                foreach($tickettypelist as $tkey=>$tvalue)
                { ?>
                  <div class="checkbox">
                    <label>
                      <?php 
                        $lbl_name = formatstring($tvalue['ticket_type_name']);
                       echo Form::checkbox($lbl_name, $value = $lbl_name,'', $attributes = array('placeholder'=>'Enter '.ucfirst($tvalue['ticket_type_name']))).' '.ucfirst($tvalue['ticket_type_name']);
                      ?>
                  </label>
                  </div>
            <?php
                }
              ?>
      			</div>

       {!! Form::submit('Add User!',  array('class'=>'btn btn-primary')) !!}
  		 {{ Form::close() }}

 @endsection
