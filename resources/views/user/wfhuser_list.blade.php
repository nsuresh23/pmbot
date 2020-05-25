
    <!--  @extends('layouts.app') -->
    @section('content')
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">User List</h3>
          @if (session('status'))
              <div class="alert alert-success">
                 <strong>Success!</strong> {{ session('status') }}
              </div>
          @endif 
    		 <div class="box-tools">
            
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
            <div class="row col-md-12">
                  <a href="{{url('user/addwfhuser/'.$groupid)}}" class="btn btn-primary">Add User</a>
            </div>
          </div>
        <!-- /.box-body -->
        </div>
        <!-- Footer -->
      @include('layouts.footer')

      @include('layouts.scriptfooter')
            
        <script type="text/javascript">
             $(document).ready(function(){
                $('#wfhuserlist').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: '<?php echo url('user/groupuserlistdata'); ?>?grpid='+$('#grpid').val(), //
                    columns: [
                        {"searchable": false,
                         "orderable": false,"render": function (data, type, full, meta) {
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
                        
                    ]
                });
            });
        </script>
    @endsection
