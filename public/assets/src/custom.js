// JavaScript Document

jQuery(function($) {
	$.i18n.load(i18n_dict);
	// Customise the default plugin options with the third argument.
	var annotator = $('#content').annotator().annotator().data('annotator');
	$('#content').annotator().annotator("addPlugin", "AnnotatorViewer");
	$('#content').annotator().annotator("addPlugin", "Touch");
	var explode = function(){
		$('#content').annotator().annotator('addPlugin', 'Store', {
			prefix: '/annotation',
			loadFromSearch: {
				page: $('#emailid').val()
			},
			annotationData: {
				//page: $('#emailid').val()
			},
			urls: {
				create: '/store',
				update: '/update/:id',
				destroy: '/delete/:id',
				search: '/search',
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
		data:  {taskid:taskid,userid:userid},
		//beforeSend: function(){$("#overlay").show();},
		success: function(data){
			$("#pmjobIDlist").html(data['message']);
		},
		error: function() 
		{} 	        
   });
}

function changePagination(option) {
	if(option!= "") {
		getresult("/annotation/getresult");
	}
}
	
function getpmbotjoblist(url) {
	var mailsubject = $("#mailsubject").val();		
	var annotationID = $("#annotationID").val();
	$.ajax({
		url: url,
		type: "POST",
		crossdomain:true,
		data:  {subject:mailsubject,annotationID:annotationID,empcode:'<?php echo $_REQUEST['empcode'];?>'},
		//beforeSend: function(){$("#overlay").show();},
		success: function(data){
			$("#pmjobIDlist").html(data['message']);
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
	var x = document.getElementById("pmjobid").value;
	if(x !=''){
		$("#mailbodycontent").removeClass();
			
		var Tasklist_url = '/annotation/gettasklist/'
		$.ajax({
			url: Tasklist_url,
			type: "POST",
			crossdomain:true,
			data:  'jobid='+x+'&empcode=<?php echo $_REQUEST['empcode'];?>',
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
	
function annotationjobID() {
	var x = document.getElementById("annotationID").value;
	if(x !=''){
		$("#mailbodycontent").removeClass('no-copy');
		var Tasklist_url = '/annotation/gettasklist/'
		$.ajax({
			url: Tasklist_url,
			type: "POST",
			crossdomain:true,
			data:  'jobid='+x+'&empcode=<?php echo $_REQUEST['empcode'];?>',
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
	url = '/annotation/gettaskdetail/'
	$.ajax({
		url: url,
		type: "POST",
		crossdomain:true,
		data:  'taskid='+sel.value,
		beforeSend: function(){$("#overlay").show();},
		success: function(data){
			var oldtasktitle = data[0]['title'];
			var oldtaskdescription = data[0]['description'];
			$('input[id=oldtasktitle]').attr('value',oldtasktitle);
			$('textarea[id=oldtaskdescription]').text(oldtaskdescription);
			$('textarea[id=oldtaskdescription]').prop("disabled", true);
			$('input[id=oldtasktitle]').prop("disabled", true);
		},
		error: function() 
		{} 	        
   });
}
	
function getuserlist(){
	url = '/annotation/getpmuserlist/'
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
	url = '/annotation/statusupdate/'+$('#emailid').val()
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
			url = '/annotation/getdataresult/'
			$.ajax({
				url: url,
				type: "POST",
				crossdomain:true,
				data:  'actionid='+emailaction.join(","),
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
	
	url = '/annotation/updategroupingdata/';
	$.ajax({
			url: url,
			type: "POST",
			crossdomain:true,
			data:  'actionid='+actionID+'&referenceid='+refID+'&content='+groupingContent,
			beforeSend: function(){$("#overlay").show();},
			success: function(data){
				location.reload();	
				return false;
			},
			error: function() 
			{} 	        
	   });
	});
});

