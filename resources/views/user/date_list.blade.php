
    <!--  @extends('layouts.app') -->
    @section('content')
    <div class="box">
        <div class="box-header">
        @if (session('datestatus'))
            <div class="alert alert-success">
               <strong>Success!</strong> {{ session('datestatus') }}
            </div>
        @endif 
         <div class="box-tools">
            
          </div>
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
        @if(!empty($grp_id))
         <div class="box-footer clearfix">
              <a style="width:15%" class="btn btn-primary" href="{{url('user/overridedate/'.$grp_id)}}">Add Date Ranges</a>
          </div>
        @endif
        </div>
        <!-- /.box-body -->
      </div>

      <!-- Footer -->
      @include('layouts.footer')

      @include('layouts.scriptfooter')
            
        <script type="text/javascript">
             $(document).ready(function(){
             
                $('#datelist').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: '<?php echo url('user/datelistdata'); ?>?grpid=<?php echo $grp_id; ?>', //
                    columns: [{"searchable": false,
                         "sortable": false,"render": function (data, type, full, meta) {
                            return meta.settings._iDisplayStart + meta.row + 1; 
                            }
                        },
                        { data: 'group_name', name: 'group_name' },
                        { data: 'daterange', name: 'daterange' },
                        { data: 'reference', name: 'reference',"render": function (data, type, full, meta) {
                            return (data>=0) ? data:'-'; 
                            } 
                        },
                        { data: 'affiliation', name: 'affiliation',"render": function (data, type, full, meta) {
                            return (data>=0) ? data:'-'; 
                            }  
                        },
                        { data: 'item_type', name: 'item_type',"render": function (data, type, full, meta) {
                            return (data>=0) ? data:'-'; 
                            }  
                        },
                        { data: 'grant', name: 'grant',"render": function (data, type, full, meta) {
                            return (data>=0) ? data:'-'; 
                            }  
                        },
                        { data: 'validation_springer', name: 'validation_springer',"render": function (data, type, full, meta) {
                            return (data>=0) ? data:'-'; 
                            }  
                        },
                        { data: 'math_expression', name: 'math_expression',"render": function (data, type, full, meta) {
                            return (data>=0) ? data:'-'; 
                            }  
                        },
						{ data: 'validation_tf', name: 'validation_tf',"render": function (data, type, full, meta) {
                            return (data>=0) ? data:'-'; 
                            }  
                        },
						{ data: 'validation_wiley', name: 'validation_wiley',"render": function (data, type, full, meta) {
                            return (data>=0) ? data:'-'; 
                            }  
                        },
						{ data: 'validation_emerald', name: 'validation_emerald',"render": function (data, type, full, meta) {
                            return (data>=0) ? data:'-'; 
                            }  
                        },
						{ data: 'validation_sage', name: 'validation_sage',"render": function (data, type, full, meta) {
                            return (data>=0) ? data:'-'; 
                            }  
                        },
						{ data: 'validation_sae', name: 'validation_sae',"render": function (data, type, full, meta) {
                            return (data>=0) ? data:'-'; 
                            }  
                        },
						{ data: 'validation_plos', name: 'validation_plos',"render": function (data, type, full, meta) {
                            return (data>=0) ? data:'-'; 
                            }  
                        },
						{ data: 'validation_nature', name: 'validation_nature',"render": function (data, type, full, meta) {
                            return (data>=0) ? data:'-'; 
                            }  
                        },
                        { data: "actions",
                                "searchable": false,
                                "sortable": false,
                        },
                    ]
                });
            });
        </script>
    @endsection
