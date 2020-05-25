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
<div class="page-content email-title" data-email-id="<?php echo $returnData['id'];?>">
  <textarea id="taskuserlist" style="display:none;"></textarea>
  <textarea id="newtaskuserlist" style="display:none;"></textarea>
  <input type="hidden" name="createdpm" id="createdpm" value="<?php echo $returnData['empcode'];?>" />
  <textarea id="usertokencode" style="display:none;">{{ csrf_token() }}</textarea>
  <input type="hidden" name="annotatorfeature" id="annotatorfeature" />
  <div id="content">
  <div class="col-md-9">
      <?php /*?><div class="bs-btndata" id="myDIV" style="clear:both; float:left;"> <a href="#replymailModal" role="menuitem" data-toggle="modal" title="Reply All" class="padding-0 email-reply-all-btn" data-email-geturl = "{{ $emailGetUrl }}" data-type = "replyall">
        <button id="btnreplyall" class="btn btn-success btn-sm">Reply All</button>
        </a> <a href="#replymailModal" role="menuitem" data-toggle="modal" title="Reply" class="padding-0 email-reply-btn" data-email-geturl = "{{ $emailGetUrl }}" data-type = "reply">
        <button id="btnreply" class="btn btn-info btn-sm">Reply</button>
        </a> </div><?php */?>
      <div class="bs-btndata" id="myDIV" style="float:right;"> <?php /*?><a href="#replymailModal" role="menuitem" data-toggle="modal" title="Forward" class="padding-0 email-forward-btn" data-email-geturl = "{{ $emailGetUrl }}" data-type = "forward">
        <button id="btnfollowup" class="btn btn-primary btn-sm">Forward</button>
        </a><?php */?>
        <!--<button id="btnfollowup" class="btn btn-primary btn-sm">Followup</button>-->
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
    var jobid = $('#pmjobid').val();
    var postData = {
        "_token": "{{ csrf_token() }}",
        empcode:'<?php echo $returnData['empcode'];?>',
        id:'<?php echo $returnData['id'];?>',
        jobid:$('#pmjobid').val()
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
				window.location.href = "<?php echo env('APP_URL');?>/";
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
			$(function() { $("#pmjobid").select2({ tags: true,minimumResultsForSearch: -1 }); });

			$('#btnannatorcompleted').hide();

			if(associatejobid !=''){
				$("#mailbodycontent").removeClass();
				//$('#addisbn_form')[0].reset();
				$('#isbn').val('');
				//$('#queryfrm').modal('hide');
	 			$("#pmjobIDlist").html(data['message']);
				$(function() { $("#pmjobid").select2({ tags: true,minimumResultsForSearch: -1 }); });

				getjobID();
				//$('#createisbnfrm').toggle(500);
				$('#Myisbnbtn').hide();
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
			if(data[0]['title'] =='' && data[0]['description'] ==''){
				$('input[id=newtasktitle]').attr('value','');
				$('input[id=newtasktitle]').removeAttr('disabled');
				$("textarea[id=taskdescription]").text('');
				$('textarea[id=taskdescription]').removeAttr('disabled');
			} else {
				$('input[id=newtasktitle]').attr('value',oldtasktitle);
				$('input[id=newtasktitle]').prop('disabled','disabled');
				$("textarea#taskdescription").text(oldtaskdescription);
				$('textarea[id=taskdescription]').prop('disabled','disabled');
				$("textarea#newtasknotes").text(insertText);
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
	$.ajax({
			url: url,
			type: "POST",
			crossdomain:true,
			headers: {'X-CSRF-Token': $('meta[name=""]').attr('content')},
			data:  {"_token": "{{ csrf_token() }}",'id':'<?php echo $returnData['id'];?>'},
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


function Myisbnbtnfrm(){
	$('#createisbnfrm').toggle(500);
}


function saveisbntodb(){
    if($('#isbn').val() == ""){
        alert("ISBN is required");
        $('#isbn').focus();
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
