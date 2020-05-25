<!--  @extends('layouts.app') -->
     @section('sidebar')
        <!-- <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar" id="groupmenu">
          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="{{url('user/grouplist')}}">User Group List<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('user/addgroup')}}">Add User Group</a>
            </li>
          </ul>
          </nav> -->
     @show
    @section('content')
<?php //echo route('editgroup'); ?>
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Group List</h3>
          @if (session('status'))
            <div class="alert alert-success">
               <strong>Success!</strong> {{ session('status') }}
            </div>
          @endif 
          <div class="box-tools">
            
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive"><!--  no-padding -->
          <table class="table table-striped table-bordered table-hover"  id="grouplisttable">
            <thead>
              <tr>
                <th>ID</th>
                <th>Group Name</th>
                <th>Email Address</th>
                <?php echo ucfirst(str_replace("Validation_", " ", $theadstr)); ?>
                <th>Actions</th>
              </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        <div class="row col-md-12">
                  <a href="{{url('user/addgroup')}}" class="btn btn-primary">Add Group</a>
        </div>
        </div>
        <!-- /.box-body -->
      </div>
        <!-- Footer -->
      @include('layouts.footer')

      @include('layouts.scriptfooter')
            
        <script type="text/javascript">
           function confirmdelete(grpid,event)
                {
                  event.preventDefault();
                  

                  bootbox.confirm(usermsg+"Are you sure want to delete?",function(result){
                    if(result)
                      return true;
                    else
                       return false;
                  });
                }

             $(document).ready(function(){
                $(document).on("click", ".grpdelete", function(e) {
                  var id = $(this).data('id');
                  if($("#usercnt_"+id).val()>0)
                    var usermsg = 'This group has '+$("#usercnt_"+id).val()+' user(s). ';
                  else
                    var usermsg = '';
                  bootbox.confirm(usermsg+"Are you sure you want to delete?", function(result) {
                      if(result){
                        window.location = '<?php  echo url("/user/deletegroup"); ?>/' + id;
                      }
                  }); 
                });
                $('#grouplisttable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    autoWidth : false,
                    ajax: '<?php echo url('user/grouplistdata'); ?>', //
                    columns: [
                        {"searchable": false,
                         "orderable": false,"render": function (data, type, full, meta) {
                            return meta.settings._iDisplayStart + meta.row + 1; 
                            }
                        },
                        { data: 'group_name', name: 'group_name' },
                        { data: 'email', name: 'email' },
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
						{ data: 'validation_plos', name: 'validation_plos' },
						{ data: 'validation_sae', name: 'validation_sae' },
						{ data: 'validation_nature', name: 'validation_nature' },
                        { data: "id",
                                "searchable": false,
                                "sortable": false,
                                "render": function (id, type, full, meta) {
                                   var editurl = '<?php  echo url("/user/editgroup"); ?>';
                                   var delurl = '<?php  echo url("/user/deletegroup"); ?>/'+id;
                                    return '<a href="'+editurl+'/'+id+'" class="glyphicon glyphicon-edit"></a><a href="javascript:void(0);" data-id="'+id+'"  class="grpdelete glyphicon glyphicon-remove-circle marglft6"></a>';
                                } 
                        },
                        {data:"usercnt",visible: false}
                        
                    ]
                });
               
            });
        </script>
@endsection

