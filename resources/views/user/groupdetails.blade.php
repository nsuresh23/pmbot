
    <!--  @extends('layouts.app') -->
    @section('content')
      <div class="box box-primary">
        <div class="box-header">
          <h2 class="box-title">User List</h2>
          @if (session('status'))
              <div class="alert alert-success">
                 <strong>Success!</strong> {{ session('status') }}
              </div>
          @endif 
    		 <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body table-responsive">
          <input type="Hidden" name="grpid" id="grpid" value="{{$groupid}}">
          <table class="table table-striped table-bordered table-hover" id="wfhuserlist">
            <thead>
              <tr>
				<th>#</th>
				<th>UserName</th>
				<th>Reference</th>
				<th>Affiliation</th>
				<th>Item Type</th>
				<th>Grant</th>
				<th>Math Expression</th>
				<th>Final QC</th>
				<th>Action</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
          <div class="box-footer clearfix moreusers" style="text-align: right;display:none;">
              <a style="width:9%" class="btn btn-primary" href="{{url('user/groupuserlist/'.$groupid)}}">More</a>
          </div>
          <div class="box-footer clearfix">
            <a href="{{url('user/addwfhuser/'.$groupid)}}" class="btn btn-primary" style="width:15%">Add User</a>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
<!-- mac address -->
<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Allowed Mac Addrress</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <div class="alert alert-success macmsg" style="display:none;">
              </div>
            </div>
            <!-- /.box-header -->
              <div class="box-body table-responsive mactable">
                <table class="table table-striped table-bordered" id="maciplist">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Mac Address</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            <div class="box-footer clearfix">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">Add Mac Address</button>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.modal -->
          <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              {{ Form::open(array('url' => 'user/saveip/'.$groupid, 'method' => 'post','id'=>'ipform','onsubmit' => 'return validatemac();')) }}
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Mac Address</h4>
              </div>
              <div class="modal-body">
                  <div class="form-group addmore">
                          <label class="frmlabel" for="mac_address">List of Mac IP Address:</label>
                          <br>
                          <div class="form-group">
                              <input type="text" placeholder="Enter Mac Address" class="form-control mactext" id="mac_ip" name="mac_ip[]" value="" style="" data-inputmask="'alias': 'ip'" data-mask><a id="append" class="required appendbutton"><img src="{{url('img/plus.png')}}" /></a><p class="macerror" id="macerror0" ></p>
                          </div> 
                  </div>
              </div>
              <div class="modal-footer">
               <!--  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button> -->
               {!! Form::submit('Save changes',  array('class'=>'btn btn-primary','id'=>'savemacip')) !!}
               <!--  <button type="button" class="btn btn-primary">Save changes</button> -->
              </div>
              {{ Form::close() }}
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
<!-- mac address -->
        <div class="box box-warning">
            <div class="box-header">
              <h2 class="box-title">Overrided Date Ranges</h2>
             <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
               @if (session('datestatus'))
                <div class="alert alert-success">
                   <strong>Success!</strong> {{ session('datestatus') }}
                </div>
             @endif 
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover"  id="datelist">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>GroupName</th>
                    <th>Dates</th>
                     <?php
                      foreach($tickettypelist as $tkey=>$tvalue)
                      {  ?>                        
						 <th><b><?php echo ucfirst(str_replace("Validation_", " ", $tvalue)); ?></b></th>
              <?php
                      }
                  ?>
                  <th>Action</th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
             <div class="box-footer clearfix moreitems" style="text-align: right;display:none;">
              <a style="width:9%" class="btn btn-primary" href="{{url('user/datelist/'.$groupid)}}">More</a>
            </div>
            <div class="box-footer clearfix">
              <a style="width:15%" class="btn btn-primary" href="{{url('user/overridedate/'.$groupid)}}">Add Date Ranges</a>
            </div>
            </div>
            <!-- /.box-body -->
      </div>
      <!-- box -->

        <!-- Footer -->
      @include('layouts.footer')

      @include('layouts.scriptfooter')
        <script type="text/javascript">
          $("#append").click( function(e) {
                var chks = document.getElementsByName('mac_ip[]').length;
                $(".addmore").append('<div class="form-group"><input type="text" value="" name="mac_ip[]" class="mactext form-control" placeholder="Enter Mac Address" data-inputmask="\'alias\': \'ip\'" data-mask><span class="macdelete"><img src="../../img/cross.png" /></span><p class="macerror" id="macerror'+chks+'"></p></div>');
                //validatedynamic();
                 $('[data-mask]').inputmask();
                e.preventDefault();
            });
            jQuery(document).on('click', '.macdelete', function() {
              jQuery(this).parent().remove();
               return false;
            });
            
            function validatemac() {
                var chks = document.getElementsByName('mac_ip[]');
                $('.macerror').html('');
                for (var i = 0; i < chks.length; i++)
                {        
                  if (chks[i].value=="")
                  {
                    $('#macerror'+i).html('This field is required');
                    chks[i].focus();
                    return false;            
                  }
                }
            }
             /*$(document).ready(function(){*/
                $('#wfhuserlist').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: '<?php echo url('user/groupuserlistdata'); ?>?grpid='+$('#grpid').val(), //
                    columns: [
                        {"searchable": false,
                         "sortable": false,"render": function (data, type, full, meta) {
                            return meta.settings._iDisplayStart + meta.row + 1; 
                            }
                        },
                        { data: 'username', name: 'username' },
                        { data: 'reference', name: 'reference',
                                "searchable": false,
                                "sortable": false },
                        { data: 'affiliation', name: 'affiliation',
                                "searchable": false,
                                "sortable": false },
                        { data: 'item_type', name: 'item_type',
                                "searchable": false,
                                "sortable": false },
                        { data: 'grant', name: 'grant',
                                "searchable": false,
                                "sortable": false },					
                        { data: 'math_expression', name: 'math_expression',
                                "searchable": false,
                                "sortable": false },
						
						{ data: 'finalqc',
                                "searchable": false,
                                "sortable": false },
                        { data: "actions",
                                "searchable": false,
                                "sortable": false,
                                /*"render": function (id, type, full, meta) {
                                   var editurl = '<?php  echo url("/user/editgroup"); ?>';
                                   var addurl = '<?php  echo url("/user/addwfhuser"); ?>';
                                    return '<a href="'+editurl+'/'+id+'" class="btn btn-primary">Edit</a><a href="'+addurl+'/'+id+'" class="btn btn-primary">Add User</a>';
                                } */
                        },
                        
                    ],
                    "pageLength": 5,
                    "bPaginate": true,
                    "initComplete": function(settings, json) {
                      $("#wfhuserlist_paginate").css("display", "none");
                      $("#wfhuserlist_length").css("display", "none");
                        if(json.recordsTotal>5)
                          $('.moreusers').show();
                        else
                          $('.moreusers').hide();
                    }
                });

               var maciptable = $('#maciplist').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: '<?php echo url('user/macipdata'); ?>?grpid='+$('#grpid').val(),
                    columns: [
                        {"searchable": false,
                         "sortable": false,"render": function (data, type, full, meta) {
                            return meta.settings._iDisplayStart + meta.row + 1; 
                            }
                        },
                        { data: 'ip_address', name: 'ip_address' },
                        { data: "actions",
                                "searchable": false,
                                "sortable": false, 
                        },
                        
                    ],
                    "pageLength": 5,
                    "bPaginate": true,
                    "initComplete": function(settings, json) {
                      $("#datelist_paginate").css("display", "none");
                      $("#datelist_length").css("display", "none");
                        if(json.recordsTotal>5)
                          $('.moreitems').show();
                        else
                          $('.moreitems').hide();
                    }
                });

                $('#datelist').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: '<?php echo url('user/datelistdata'); ?>?grpid='+$('#grpid').val(), //
                    columns: [
                        {"searchable": false,
                         "sortable": false,"render": function (data, type, full, meta) {
                            return meta.settings._iDisplayStart + meta.row + 1; 
                            }
                        },
                        { data: 'group_name', name: 'group_name' },
                        { data: 'daterange', name: 'daterange' },
                        { data: 'reference', name: 'reference' },
                        { data: 'affiliation', name: 'affiliation' },
                        { data: 'item_type', name: 'item_type' },
                        { data: 'grant', name: 'grant' },
                        { data: 'validation_springer', name: 'validation_springer' },
                        { data: 'math_expression', name: 'math_expression' },
						{ data: 'validation_tf', name: 'validation_tf' },
						{ data: 'validation_wiley', name: 'validation_wiley' },
						{ data: 'validation_emerald', name: 'validation_emerald' },
						{ data: 'validation_sage', name: 'validation_sage' },
						{ data: 'validation_sae', name: 'validation_sae' },
						{ data: 'validation_plos', name: 'validation_plos' },
						{ data: 'validation_nature', name: 'validation_nature' },
                        { data: "actions",
                                "searchable": false,
                                "sortable": false,
                        },
                    ],
                    "pageLength": 5,
                    "bPaginate": true,
                    "initComplete": function(settings, json) {
                      $("#datelist_paginate").css("display", "none");
                      $("#datelist_length").css("display", "none");
                        if(json.recordsTotal>5)
                          $('.moreitems').show();
                        else
                          $('.moreitems').hide();
                    }
                });
                
            /*});*/
            function deleteMacIp(thisobj){
              $('.macmsg').hide();
                  if(confirm("Are you sure want to delete?"))
                    {
                      $.ajax({url: "<?php echo url('user/deleteip'); ?>",
                              type:'POST',
                              data: {
                              "_token": "{{ csrf_token() }}",
                              "id": $(thisobj).data("id")
                              },
                             success: function(result){
                                  maciptable.ajax.reload();
                                  $('.macmsg').html(result);
                                  $('.macmsg').show();
                      }});
                    }
               }
            $('[data-mask]').inputmask();
        </script>
    @endsection
