@extends('layouts.annotator')

@push('css')
<!-- Custom CSS -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"/>
<link href="{{ asset('public/assets/src/css/bootstrap.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('public/assets/src/css/AdminLTE.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('public/assets/lib/annotator-full.1.2.9/annotator.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('public/assets/src/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('public/assets/lib/css/annotator.touch.css') }}" rel="stylesheet"/>
<link href="{{ asset('public/assets/select2/select2.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('public/assets/src/css/jquery.toggleinput.css') }}" rel="stylesheet"/>
<style>

    .attachment-block {
        padding-right: 10px;
        padding-left: 10px;
        margin-right: auto;
        margin-left: auto;
        background: none;
    }

    .download-blocks {
        margin-bottom: 10px !important;
        color: #878787;
    }

    .attachment-mail ul {
        margin-left: 0px !important;
        padding-left: 0px !important;
    }

    .attachment-mail li {
        display: inline-block;
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .attachment-mail li .attached-img-container {
        width: 120px;
        height: 120px;
        display: block;
        background-position: center top;
        background-size: cover;
        margin-bottom: 10px;
        border-radius: 2px;
    }

    .attachment-mail li:last-child {
        margin-right: 0;
    }

    .email-attachment-item-block {
        border: gray solid 1px;
        padding: 0.3em;
        pointer-events: visible;
    }

    .email-attachment-item-name {
        vertical-align: top;
        font-size: 0.8em;
    }

    .pr-10 {
        padding-right: 10px !important;
    }

    .pr-15 {
        padding-right: 15px !important;
    }

    .mb-10 {
        margin-bottom: 10px !important;
    }

    .mb-0 {
        margin-bottom: 0px !important;
    }

    .font-30 {
        font-size: 30px !important;
    }

    .mr-5 {
        margin-right: 5px !important;
    }

</style>
@endpush

@push('js')
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{ asset('public/assets/lib/jquery-1.9.1.js') }} "></script>
<script src="{{ asset('public/assets/lib/annotator-full.1.2.9/annotator-full.min.js') }} "></script>
<script src="{{ asset('public/assets/lib/jquery-i18n-master/jquery.i18n.min.js') }} "></script>
<script src="{{ asset('public/assets/lib/jquery.dateFormat.js') }} "></script>
<script src="{{ asset('public/assets/lib/jquery.slimscroll.js') }} "></script>
<script src="{{ asset('public/assets/locale/en/annotator.js') }} "></script>
<script src="{{ asset('public/assets/lib/annotator.touch.js') }} "></script>
<script src="{{ asset('public/assets/src/view_annotator.js') }} "></script>
<script src="{{ asset('public/assets/src/categories.js') }} "></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.7/highlight.min.js"></script>
<script src="{{ asset('public/assets/src/jquery.toggleinput.js') }} "></script>
<script src="{{ asset('public/assets/src/bootstrap-filestyle.min.js') }} "></script>
<script src="{{ asset('public/assets/select2/select2.full.min.js') }} "></script>

<!-- Main Content -->
<div class="header_top"></div>
<?php  date_default_timezone_set("Asia/Calcutta");  ?>
<div class="page-content email-title" data-email-id="<?php echo $returnData['id'];?>" data-job-detail-url="{{route("getselectedjob") ?? ''}}">
  <textarea id="taskuserlist" style="display:none;"></textarea>
  <textarea id="newtaskuserlist" style="display:none;"></textarea>
  <input type="hidden" name="createdpm" id="createdpm" value="<?php echo $returnData['empcode'];?>" />
  <textarea id="usertokencode" style="display:none;">{{ csrf_token() }}</textarea>
  <input type="hidden" name="annotatorfeature" id="annotatorfeature" />
  <div id="content">
  <div class="col-md-9">
      <?php /*?><div class="bs-btndata" id="myDIV" style="clear:both; float:left;"> <a href="#replymailModal" role="menuitem" data-toggle="modal" title="Reply All" class="padding-0 email-reply-all-btn" data-email-geturl = "{{ $emailGetUrl ?? '' }}" data-type = "replyall">
        <button id="btnreplyall" class="btn btn-success btn-sm">Reply All</button>
        </a> <a href="#replymailModal" role="menuitem" data-toggle="modal" title="Reply" class="padding-0 email-reply-btn" data-email-geturl = "{{ $emailGetUrl ?? '' }}" data-type = "reply">
        <button id="btnreply" class="btn btn-info btn-sm">Reply</button>
        </a> </div><?php */?>
      <div class="bs-btndata" id="myDIV" style="float:right;"> <?php /*?><a href="#replymailModal" role="menuitem" data-toggle="modal" title="Forward" class="padding-0 email-forward-btn" data-email-geturl = "{{ $emailGetUrl ?? '' }}" data-type = "forward">
        <button id="btnfollowup" class="btn btn-primary btn-sm">Forward</button>
        </a><?php */?>
        <!--<button id="btnfollowup" class="btn btn-primary btn-sm">Followup</button>-->

        <a href="{{route('email-forward') . '?redirectTo=' . $returnData['id'] ?? "#"}}" title="forward" class="btn btn-sm btn-success email-forward-button email-button-group">
            Forward
        </a>
        <a href="{{route('email-reply-all') . '?redirectTo=' . $returnData['id'] ?? "#"}}" title="reply all" class="btn btn-sm btn-success email-reply-all-button email-button-group">
            Reply all
        </a>
        <a href="{{route('email-reply') . '?redirectTo=' . $returnData['id'] ?? "#"}}" title="reply" class="btn btn-sm btn-success email-reply-button email-button-group">
            Reply
        </a>

	<a id="btnhome" class="btn btn-primary btn-sm" href="{{route('home')}}">Back to home</a>
        <button id="btnnonbusiness" class="btn btn-warning btn-sm">Non Business</button>
      </div>
    </div>


    <div id="pagination-result">
      <input type="hidden" name="emailid" id="emailid" value="<?php echo $returnData['id'];?>"/>
      <input type="hidden" name="ajaxannotationdata" id="ajaxannotationdata" />
    </div>
  </div>
</div>
<div id="overlay">
  <div> <img src="{{ asset('public/assets/img/logo-icon.svg') }}" width="90px" height="90px"/>
    <p style="color:#fff; padding:10px 0px;">Please wait...</p>
  </div>
</div>
<style>
	.mailbox-attachment-name { text-transform:none !important;}
</style>
@endpush
@section('content')
@php
$page = '1';
$emailAnnotatorStartTime = date('Y-m-d H:i:s');
@endphp
@push('js')
<script>
// JavaScript Document
jQuery(function($) {
	$.i18n.load(i18n_dict);
	// Customise the default plugin options with the third argument.
	var annotator = $('#content').annotator().annotator().data('annotator');

	$('#content').annotator().annotator("addPlugin", "Touch");
	//$(":file").filestyle();
	var explode = function(){
		$('#content').annotator().annotator('addPlugin', 'Store', {
			prefix: '<?php echo env('EMAIL_ANNOTATOR_BASE_URL');?>',
			loadFromSearch: {
				page: $('#emailid').val()
			},
			/*annotationData: {
				//_token: "{{ csrf_token() }}"
			},*/
			annotationData: {
				_token:'{{ csrf_token() }}'
			},
			urls: {
				create: '/store',
				update: '/update/:id',
				destroy: '/delete/:id',
				//search: '/search',
			}
		});
	}
	setTimeout(explode, 200);
	//Annotation scroll
	$('#anotacions-uoc-panel').slimscroll({
		height: '100%'
	});
});


function updateddate(textval) {
	$("#annotatorlabel").val(textval);
}

function annotatorcompleted(){
    url = '<?php echo env('EMAIL_ANNOTATOR_BASE_URL');?>/completetaskdetail'
	var jobId = $('#pmjobid').val();

	var jobTitle = $('#pmjobid option:selected').text();

	if(jobId == undefined || jobId == '') {	//CODED ADDED ON 2020-07-02 :: OVER-RIDING THE COMPLETED BUTTON TO DEFAULT SHOW(SURESH)
	 alert('Please select the job');
	 return false;
	}


    var postData = {
        "_token": "{{ csrf_token() }}",
        empcode:'<?php echo $returnData['empcode'];?>',
        id:'<?php echo $returnData['id'];?>',
        jobid:jobId
	}

	if(jobTitle == 'pmbot_generic') {

		postData.is_generic = 'true';

	}

    var emailAnnotatorStartTime = '<?php echo isset($emailAnnotatorStartTime)? $emailAnnotatorStartTime : "" ?>';

    if(emailAnnotatorStartTime) {

        postData.start_time = emailAnnotatorStartTime;

    }

	$.ajax({
		url: url,
		type: "POST",
		crossdomain:true,
		headers: {'X-CSRF-Token': $('meta[name=""]').attr('content')},
		data:  postData,
		beforeSend: function(){$("#overlay").show();},
		success: function(data){
			alert(data['message']);
			if(data['status'] == '1'){
                // window.location.href = "<?php echo env('APP_URL');?>/";

                window.location.reload();

			}
		},
		error: function()
		{}
   });

}

function shownotes(textval) {
	if(textval =='Custom message'){
		$("#annotator-field-0").show();
	} else {
		$("#annotator-field-0").hide();
	}
}

function getRandomColor() {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
	color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

function saveassociatetask(){
	taskid = $("#tasklistapi").val();
	userid = $("#multi-select-user").val();
	$.ajax({
		url: url,
		type: "POST",
		crossdomain:true,
		headers: {'X-CSRF-Token': $('meta[name=""]').attr('content')},
		data:  {"_token": "{{ csrf_token() }}",taskid:taskid,userid:userid},
		success: function(data){
			$("#pmjobIDlist").html(data['message']);
		},
		error: function()
		{}
   });
}

function changePagination(option) {
	if(option!= "") {
		getresult("<?php echo env('EMAIL_ANNOTATOR_BASE_URL');?>/getresult");
	}
}

function getpmbotjoblist(url) {
	var mailsubject 	= $("#mailsubject").val();
	var annotationID 	= $("#annotationID").val();
	var associatejobid 	= $("#associatejobid").val();

	$.ajax({
		url: url,
		type: "POST",
		crossdomain:true,
		headers: {'X-CSRF-Token': $('meta[name=""]').attr('content')},
		data:  {"_token": "{{ csrf_token() }}",subject:mailsubject,annotationID:annotationID,empcode:'<?php echo $returnData['empcode'];?>',associatejobid:associatejobid},
		success: function(data){
			$("#pmjobIDlist").html(data['message']);
            // $(function() { $("#pmjobid").select2({ tags: true,minimumResultsForSearch: -1 }); });
            $(function() { $("#pmjobid").select2({ tags: true }); });

			$('#btnannatorcompleted').show();  //CODED ADDED ON 2020-07-02 :: OVER-RIDING THE COMPLETED BUTTON TO DEFAULT SHOW FROM HIDE(SURESH)

			if(associatejobid !=''){
				$("#mailbodycontent").removeClass();
				//$('#addisbn_form')[0].reset();
				$('#isbn').val('');
				//$('#queryfrm').modal('hide');
	 			$("#pmjobIDlist").html(data['message']);
				// $(function() { $("#pmjobid").select2({ tags: true,minimumResultsForSearch: -1 }); });
				$(function() { $("#pmjobid").select2({ tags: true }); });

				getjobID();
				//$('#createisbnfrm').toggle(500);
				//$('#Myisbnbtn').hide();
				$('#btnannatorcompleted').show();
			}




		},
		error: function()
		{}
   });
}

function myFunction() {
  var x = document.getElementById("myDIVTask");
  if (x.style.display === "none") {
	x.style.display = "block";
  } else {
	x.style.display = "none";
  }
}

function getjobID() {
	var jobid = $('#pmjobid').select2("val");

	if(jobid != ''){
		if(jobid.length != ''){
			$("#mailbodycontent").removeClass();
			$("#btnannatorcompleted").show();
			$("#btnnonbusiness").show();
			var Tasklist_url = '<?php echo env('EMAIL_ANNOTATOR_BASE_URL');?>/gettasklist';
			$.ajax({
				url: Tasklist_url,
				type: "POST",
				crossdomain:true,
				headers: {
                    'X-CSRF-Token': $('meta[name=""]').attr('content')
               },
			   data:  '_token={{ csrf_token() }}&jobid='+jobid+'&empcode=<?php echo $returnData['empcode'];?>',
				beforeSend: function(){$("#overlay").show();},
				success: function(data){
					$('#content').annotator().annotator('addPlugin', 'Categories', data);
					getuserlist();
				},
				error: function()
				{}
		   });
		}else{
			getuserlist();
			$.ajax({
						url: '<?php echo env('EMAIL_ANNOTATOR_BASE_URL');?>/getselectedjob',
						type: "POST",
						crossdomain:true,
						headers: {'X-CSRF-Token': $('meta[name=""]').attr('content')},
						data:  {"_token": "{{ csrf_token() }}",jobid:jobid},
						success: function(data){
							$("#userselectedjoblist").html(data['message']);
						},
						error: function()
						{}
					});
		}
	}else{
			getuserlist()
		}
}

function getjob_tasklist(val) {
	//alert(val);
	$("#mailbodycontent").removeClass();
		var Tasklist_url = '<?php echo env('EMAIL_ANNOTATOR_BASE_URL');?>/getjobtasklist';
		$.ajax({
			url: Tasklist_url,
			type: "POST",
			crossdomain:true,
			headers: {'X-CSRF-Token': $('meta[name=""]').attr('content')},
			data:  '_token={{ csrf_token() }}&jobid='+val+'&empcode=<?php echo $returnData['empcode'];?>',
			beforeSend: function(){$("#overlay").show();},
			success: function(data){
				$("#jobtasklist").html(data['message']);
				if(data['taskstatus'] == null || data['taskstatus'] == '0') {
					$("#jobtasklist").attr('disabled', 'disabled');
					$("#jobtaskid").attr('disabled', 'disabled');
					$("#showtaskselection").children().attr("disabled","disabled");
				} else {
					$("#showtaskselection").removeAttr('disabled');
				}
				getuserlist()
			},
			error: function()
			{}
	   });
}

function annotationjobID() {
	var x = document.getElementById("annotationID").value;
	if(x !=''){
		$("#mailbodycontent").removeClass('no-copy');
		var Tasklist_url = '<?php echo env('EMAIL_ANNOTATOR_BASE_URL');?>/gettasklist'
		$.ajax({
			url: Tasklist_url,
			type: "POST",
			crossdomain:true,
			headers: {'X-CSRF-Token': $('meta[name=""]').attr('content')},
			data:  {"_token": "{{ csrf_token() }}",jobid:x,empcode:'<?php echo $returnData['empcode'];?>'},
			beforeSend: function(){$("#overlay").show();},
			success: function(data){
				$('#content').annotator().annotator('addPlugin', 'Categories', data);
				getuserlist()
			},
			error: function()
			{}
	   });
	}
}

function gettaskval(sel){
	url = '<?php echo env('EMAIL_ANNOTATOR_BASE_URL');?>/gettaskdetail'
	$.ajax({
		url: url,
		type: "POST",
		crossdomain:true,
		headers: {'X-CSRF-Token': $('meta[name=""]').attr('content')},
		data:  {"_token": "{{ csrf_token() }}",taskid:sel},
		beforeSend: function(){$("#overlay").show();},
		success: function(data){
			var insertText = $('#taskdescription').val();
			var oldtasktitle = data[0]['title'];
			var oldtaskdescription = data[0]['description']+' '+ insertText;
			var oldAssignedtoEmpcode = data[0]['assignedto_empcode'];
			if(data[0]['title'] =='' && data[0]['description'] ==''){
				$('input[id=newtasktitle]').attr('value','');
				$('input[id=newtasktitle]').removeAttr('disabled');
				$("textarea[id=taskdescription]").text('');
				$('textarea[id=taskdescription]').removeAttr('disabled');
				$('#multi-select-user-newtask').select2().prop('multiple', 'multiple');
				$('#multi-select-user-newtask').select2().val('').trigger('change');
				$('#multi-select-user-newtask').removeAttr('disabled');
			} else {
				$('input[id=newtasktitle]').attr('value',oldtasktitle);
				$('input[id=newtasktitle]').prop('disabled','disabled');
				$("textarea#taskdescription").text(oldtaskdescription);
				$('textarea[id=taskdescription]').prop('disabled','disabled');
				$("textarea#newtasknotes").text(insertText);
				$('#multi-select-user-newtask').select2().prop('multiple', '');
				$('#multi-select-user-newtask').select2().val(oldAssignedtoEmpcode).trigger('change');
				// $('#multi-select-user-newtask').prop('disabled','disabled');
			}
		},
		error: function()
		{}
   });
}

function getuserlist(){
	url = '<?php echo env('EMAIL_ANNOTATOR_BASE_URL');?>/getpmuserlist'
	$.ajax({
		url: url,
		type: "GET",
		crossdomain:true,
		data:  '',
		beforeSend: function(){$("#overlay").show();},
		success: function(data){
			$("#taskuserlist").html(data['message']);
			$("#newtaskuserlist").html(data['newtaskmessage']);
		},
		error: function()
		{}
   });
}

$("#pmjobid").change(function() {
	var vale =document.getElementById("pmjobid").value;
})

/* Code highlighting */
hljs.initHighlightingOnLoad();

function updatedata(url) {
	url = '<?php echo env('EMAIL_ANNOTATOR_BASE_URL');?>/statusupdate/'+$('#emailid').val()
	$.ajax({
		url: url,
		type: "PUT",
		crossdomain:true,
		data:  '',
		beforeSend: function(){$("#overlay").show();},
		success: function(data){
			location.reload();
			return false;
		},
		error: function()
		{}
   });
}

$(document).ready(function() {
	  $("#actionplan").click(function() {
		var emailaction = [];
		$.each($("input[name='actionannotator']:enabled:checked"), function() {
		  emailaction.push($(this).val());
		});
		if(emailaction !='' && emailaction.length >=2) {
		$('#modalForm').modal('show').on('shown.bs.modal', function() {
			url = '<?php echo env('EMAIL_ANNOTATOR_BASE_URL');?>/getdataresult'
			$.ajax({
				url: url,
				type: "POST",
				crossdomain:true,
				headers: {'X-CSRF-Token': $('meta[name=""]').attr('content')},
				data:  {"_token": "{{ csrf_token() }}",actionid:emailaction.join(",")},
				//data:  'actionid='+emailaction.join(","),
				beforeSend: function(){$("#overlay").show();},
				success: function(data){
					 $("#checkid").html(data);
				},
				error: function()
				{}
		   });
		});
		} else {
			alert('Please select your Grouping of 2 annotation or more!! ');
		}
	  });

$("#groupingannotate").click(function() {
	var actionID 	= $("#actionid").val();
	var refID 		= $("#referenceid").val();
	var groupingContent	= $("#post_content").val();

	url = '<?php echo env('EMAIL_ANNOTATOR_BASE_URL');?>/updategroupingdata';
	$.ajax({
			url: url,
			type: "POST",
			crossdomain:true,
			headers: {'X-CSRF-Token': $('meta[name=""]').attr('content')},
			data:  {"_token": "{{ csrf_token() }}",actionid:actionID,referenceid:refID,content:groupingContent},
			beforeSend: function(){$("#overlay").show();},
			success: function(data){
				location.reload();
				return false;
			},
			error: function()
			{}
	   });
	});


$("#btnnonbusiness").click(function() {
	url = '<?php echo env('EMAIL_ANNOTATOR_BASE_URL');?>/nonbusiness';
	var associatejobid 	= $("#associatejobid").val();

	var postData = {
		"_token": "{{ csrf_token() }}",
		'id':'<?php echo $returnData['id'];?>'
	};

	var emailAnnotatorStartTime = '<?php echo isset($emailAnnotatorStartTime)? $emailAnnotatorStartTime : "" ?>';

	if(emailAnnotatorStartTime) {

		postData.start_time = emailAnnotatorStartTime;

	}

	$.ajax({
			url: url,
			type: "POST",
			crossdomain:true,
			headers: {'X-CSRF-Token': $('meta[name=""]').attr('content')},
			data:  postData,
			beforeSend: function(){$("#overlay").show();},
			success: function(data){
				alert('Successfully updated email belongs to Non Business category!!');
				window.location.href = "<?php echo env('APP_URL');?>";
				return false;
			},
			error: function()
			{}
	   });
	});

});

function getresult(url) {

	$.ajax({
		url: url,
		type: "GET",
		crossdomain:true,
		data:  {rowcount:$("#rowcount").val(),"pagination_setting":'prev-next','id':'<?php echo $returnData['id'];?>','empcode':'<?php echo $returnData['empcode'];?>'},
		beforeSend: function(){$("#overlay").show();},
		success: function(data){
			if(data['status'] == '-1'){
				alert('You dont have an access permission to view the page!!');
				window.location.href = "<?php echo env('APP_URL');?>";
				return false;

			} else {
				$("#pagination-result").html(data['msg']);
				$("#annotatorfeature").val(data['status']);
				$('#content').annotator().annotator("addPlugin", "AnnotatorViewer");
				if(data['status'] !='0'){
					$("#btnnonbusiness").hide();
                }

                if(data['status'] =='2'){

                    $(".email-button-group").show();

                }

                $('.email-subject').html('');
                $('.email-subject').html($('.mailbox-read-info').find('h3:first').html());

                $.ajax({
                    url: '<?php echo env('EMAIL_ANNOTATOR_BASE_URL');?>/search?page='+<?php echo $returnData['id'];?>,
                    type: "GET",
                    crossdomain:true,
                    data:  '',
                    beforeSend: function(){$("#overlay").show();},
                    success: function(data){
                    $("#refemailid").val($('#emailid').val());
                        getpmbotjoblist("<?php echo env('EMAIL_ANNOTATOR_BASE_URL');?>/getpmbotjoblist");
                        annotationjobID();
                        },
                    error: function()
                    {}
                });

				setInterval(function() {$("#overlay").hide(); },500);
			}


		},
		error: function()
		{}
   });
}
getresult("<?php echo env('EMAIL_ANNOTATOR_BASE_URL');?>/getresult");

$('.email-button-group').hide();

function Myisbnbtnfrm(){
	$('#createisbnfrm').toggle(500);
	$('#create-generic-job-frm').hide();
}

function genericBtnFrm(){
	$('#create-generic-job-frm').toggle(500);
	$('#createisbnfrm').hide();
}

function maskAsGeneric()
{

    $('#pmjobid').select2().val('pmbot_generic');
    $('#pmjobid').select2().trigger('change');

}

function genericJobAdd(){

	var isbn = 'pmbot_generic';

	var existsSelected = 'false';

    $('#pmjobid option').select2().each(function(){

        if (this.text == isbn) {

            $('#pmjobid').select2().val(this.value);
			$('#pmjobid').select2().trigger('change');

			existsSelected = 'true';

            return false;

        }

    });

	if(existsSelected == 'false') {

		var postData = {
			"_token": "{{ csrf_token() }}",
			'emailid':'<?php echo $returnData['id'];?>',
			'empcode':'<?php echo $returnData['empcode'];?>',
			isbn:isbn,
			'generic':'generic',
		};

		var emailAnnotatorStartTime = '<?php echo isset($emailAnnotatorStartTime)? $emailAnnotatorStartTime : "" ?>';

		if(emailAnnotatorStartTime) {

			postData.start_time = emailAnnotatorStartTime;

		}

		url = '<?php echo env('EMAIL_ANNOTATOR_BASE_URL');?>/createisbn';

		$.ajax({
				url: url,
				type: "POST",
				crossdomain:true,
				headers: {'X-CSRF-Token': $('meta[name=""]').attr('content')},
				data:  postData,
				beforeSend: function(){$("#overlay").show();},
				success: function(data){
					$("#mailbodycontent").removeClass();
					//$('#addisbn_form')[0].reset();
					$('#isbn').val('');
					//$('#queryfrm').modal('hide');
					$("#pmjobIDlist").html(data['message']);
					$(function() { $("#pmjobid").select2({ tags: true,minimumResultsForSearch: -1 }); });

					getjobID();
					// $('#createisbnfrm').toggle(500);
					// $('.mark-as-generic').hide();
					$('#btnannatorcompleted').show();
					return false;
				},
				error: function()
				{}
		});

	}

}

function saveisbntodb(){
    if($('#isbn').val() == ""){
        alert("ISBN is required");
        $('#isbn').focus();
	} else if(/^[a-zA-Z0-9-_]*$/.test($('#isbn').val()) == false) {
		alert('ISBN contains only (-,_) special characters.');
	} else {
        var isbn = $('#isbn').val();
        // var emailid = 92;
        //var empcode = pmbot@spi-global.com;

        var postData = {
            "_token": "{{ csrf_token() }}",
            'emailid':'<?php echo $returnData['id'];?>',
            'empcode':'<?php echo $returnData['empcode'];?>',
            isbn:isbn
        };

        var emailAnnotatorStartTime = '<?php echo isset($emailAnnotatorStartTime)? $emailAnnotatorStartTime : "" ?>';

        if(emailAnnotatorStartTime) {

        postData.start_time = emailAnnotatorStartTime;

        }

        url = '<?php echo env('EMAIL_ANNOTATOR_BASE_URL');?>/createisbn';
        $.ajax({
                url: url,
                type: "POST",
                crossdomain:true,
                headers: {'X-CSRF-Token': $('meta[name=""]').attr('content')},
                data:  postData,
                beforeSend: function(){$("#overlay").show();},
                success: function(data){
                    $("#mailbodycontent").removeClass();
                    //$('#addisbn_form')[0].reset();
                    $('#isbn').val('');
                    //$('#queryfrm').modal('hide');
                    $("#pmjobIDlist").html(data['message']);
                    $(function() { $("#pmjobid").select2({ tags: true,minimumResultsForSearch: -1 }); });

                    getjobID();
                    $('#createisbnfrm').toggle(500);
                    $('#Myisbnbtn').hide();
                    $('#btnannatorcompleted').show();
                    return false;
                },
                error: function()
                {}
        });
    }
}

function saveGenericToDB(){
    if($('#generic-job-title').val() == ""){
        alert("Title is required");
        $('#generic-job-title').focus();
	} else {
        var isbn = $('#generic-job-title').val();
        // var emailid = 92;
        //var empcode = pmbot@spi-global.com;

        var postData = {
            "_token": "{{ csrf_token() }}",
            'emailid':'<?php echo $returnData['id'];?>',
            'empcode':'<?php echo $returnData['empcode'];?>',
			isbn:isbn,
			'generic':'generic',
        };

        var emailAnnotatorStartTime = '<?php echo isset($emailAnnotatorStartTime)? $emailAnnotatorStartTime : "" ?>';

        if(emailAnnotatorStartTime) {

        	postData.start_time = emailAnnotatorStartTime;

        }

        url = '<?php echo env('EMAIL_ANNOTATOR_BASE_URL');?>/createisbn';
        $.ajax({
                url: url,
                type: "POST",
                crossdomain:true,
                headers: {'X-CSRF-Token': $('meta[name=""]').attr('content')},
                data:  postData,
                beforeSend: function(){$("#overlay").show();},
                success: function(data){
                    $("#mailbodycontent").removeClass();
                    //$('#addisbn_form')[0].reset();
                    $('#generic-job-title').val('');
                    //$('#queryfrm').modal('hide');
                    $("#pmjobIDlist").html(data['message']);
                    $(function() { $("#pmjobid").select2({ tags: true,minimumResultsForSearch: -1 }); });

                    getjobID();
                    $('#create-generic-job-frm').toggle(500);
                    $('#generic-btn').hide();
                    $('#btnannatorcompleted').show();
                    return false;
                },
                error: function()
                {}
        });
    }
}

jQuery(function($) {
	$('.radio-toggle').toggleInput();
});

$('#browseButton2').on('click', function () {
	$('#fileUploader2').click();
});

$('#fileUploader2').change(function () {
	$('#fileName2').val($(this).val());
});

</script>
@endpush
