
    <!--  @extends('layouts.app') -->
    @section('content')
      <div class="box">
        <div class="box-header">
          @if (session('status'))
              <div class="alert alert-success">
                 <strong>Success!</strong> {{ session('status') }}
              </div>
          @endif 
          <div class="box-tools">
            
          </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-striped table-bordered table-hover"  id="inhouselist">
              <thead>
                <tr>
					<th>#</th>
					<th>PG CODE</th>
					<th>User Name</th>
					<th>DOJ</th>
					<th>Domain Name</th>
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
               
              <tbody>
          </tbody>
        </table>
        <div class="box-footer clearfix">
			<a style="width:15%" class="btn btn-primary" href="{{url('user/add_user')}}">Add User</a>
        </div>
        </div>
        <!-- /.box-body -->
      </div>
        <!-- Footer -->
      @include('layouts.footer')

      @include('layouts.scriptfooter')
            
        <script type="text/javascript">
             $(document).ready(function(){
                $('#inhouselist').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: '<?php echo url('user/userlistdata'); ?>', //
                    columns: [
                        {"searchable": false,"sortable": false,
                         "ordering": false,"render": function (data, type, full, meta) {
                            return meta.settings._iDisplayStart + meta.row + 1; 
                            }
                        },
                        { data: 'username', name: 'username'},
						{ data: 'name', name: 'name'},
						{ data: 'doj', name: 'doj'},
                        { data: 'group_name', name: 'group_name'},
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
						{ data: "finalqc",
                                "searchable": false,
                                "sortable": false,                                
                        },								
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
