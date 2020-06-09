(function() {
    var __bind = function(fn, me) { return function() { return fn.apply(me, arguments); }; },
        __hasProp = {}.hasOwnProperty,
        __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; }

            function ctor() { this.constructor = child; }
            ctor.prototype = parent.prototype;
            child.prototype = new ctor();
            child.__super__ = parent.prototype; return child; };

    Annotator.Plugin.Categories = (function(_super) {
        __extends(Categories, _super);


        Categories.prototype.events = {
            'annotationsLoaded': 'onAnnotationsLoaded'
        };

        Categories.prototype.field = null;
        Categories.prototype.input = null;
        Categories.prototype.options = {
            categories: {}
        };




        function Categories(element, categories) {
            //categories = document.getElementById("categoriestab").value;

            this.setAnnotationCat = __bind(this.setAnnotationCat, this);
            this.updateField = __bind(this.updateField, this);
            this.onAnnotationUpdated = __bind(this.onAnnotationUpdated, this);
            this.annotationCreated = __bind(this.annotationCreated, this);
            this.AnnotationSection = __bind(this.AnnotationSection, this);
            this.AnnotationCategory = __bind(this.AnnotationCategory, this);
            this.updateAnnotation = __bind(this.updateAnnotation, this);

            this.options.categories = categories;
            Categories.__super__.constructor.apply(this, arguments);
        }


        Categories.prototype.pluginInit = function() {
            if (!Annotator.supported()) {
                return;
            }

            //Call editor after submit.
            this.annotator.subscribe("annotationEditorSubmit", this.AnnotationSection);

            //Call editor before show and write color checker
            this.annotator.subscribe("annotationEditorShown", this.AnnotationCategory);

            //Annotation creation
            this.annotator.subscribe("annotationCreated", this.annotationCreated);

            //Showing annotations
            this.annotator.subscribe("annotationViewerShown", this.AnnotationViewer);

            this.annotator.subscribe("annotationUpdated ", this.updateAnnotation);

        };

        //After loading annotations we want to change the annotation color and add the annotation id
        Categories.prototype.onAnnotationsLoaded = function(annotations) {
            var annotation;
            var _categories = this.options.categories; //Categories plug-in


            $('#count-anotations').text(annotations.length);
            if (annotations.length > 0) {
                for (i = 0, len = annotations.length; i < len; i++) {
                    annotation = annotations[i];
                    var category = "annotator-hl-" + annotation.category;
                    if (annotation.category in _categories) {
                        category = _categories[annotation.category];
                    }
                    $(annotation.highlights).addClass(category);
                    $(annotation.highlights).attr('id', annotation.id);
                }
            }
        };

        //After loading annotations we want to change the annotation color and add the annotation id
        Categories.prototype.updateAnnotation = function(annotation) {
            var category = this.options.categories[annotation.category];

            $(annotation.highlights).attr("class", "annotator-hl " + category);

        };

        //After loading annotations we want to change the annotation color and add the annotation id
        Categories.prototype.AnnotationViewer = function(viewer, annotations) {
            var annotation;
            var isShared = "";
            var class_label = "label";



            if (annotations.length > 0) {
                for (i = 0, len = annotations.length; i < len; i++) {
                    annotation = annotations[i];

                    /*if (annotation.estat==1 || annotation.permissions.read.length===0 ) {
                      isShared = "<img src=\"../src/img/shared-icon.png\" title=\""+ i18n_dict.share +"\" style=\"margin-left:5px\"/>"
                    }*/
                    if (annotation.propietary == 0) {
                        class_label = "label-compartit";
                    }

                    var pmassigneduser = '';
                    if (annotation.userid != null) {
                        var sectionAnnotation = annotation.userid.split(",");
                        $.each(sectionAnnotation, function(i) {
                            pmassigneduser += '<span style="color:#FFF; float:right; margin-right:5px;float:left; " class="label label-info">' + sectionAnnotation[i] + '</span>';
                        });

                    } else {
                        $.each(annotation.section, function(key, value) {
                            pmassigneduser += '<span style="color:#FFF; float:right; margin-right:5px; float:left; " class="label label-info">' + value + '</span>';
                        });
                    }

                    var randomColor = Math.floor(Math.random() * 16777215).toString(16);


                    $('ul.annotator-widget > li.annotator-item').prepend('<div class="' + annotation.category + '" style="margin:4px;padding:4px; float:left;  clear:both;">' + pmassigneduser + '</div>');
                    $("div.annotator-user").html("<span class='" + class_label + "'></span>" + isShared);

                }
            }
        }


        //Section order and section title
        Categories.prototype.AnnotationSection = function(editor, annotation) {
            //Assign a categoy to the annotation

            //Put the annotation section an annotation title
            var ref = $('.annotator-hl-temporary').closest('div[data-section]');
            if (ref) {
                annotation.section = ref.data('section');
                annotation.section_title = '';
                annotation.notes = '';
                annotation.newattachment = null;
                annotation.emailnotation = null;
            } else {
                console.log("Section not detected!!!")
            }
            // annotation.order = $('.annotator-hl-temporary').closest('div[id]').attr('id');       
            //annotation.category = $('input:radio[name=categories-annotation]:checked').val();

            annotation.order = $('.annotator-hl-temporary').closest('div[id]').attr('id');
            annotation.category = $("#jobtaskid").val();
            annotation.section_title = $("#tasklistapi option:selected").text();
            annotation.section = $("#multi-select-user").val();
            annotation.jobid = $("#pmjobid").val();
            var usertokencode = document.getElementById("usertokencode").value;
            annotation._token = usertokencode;


            /*annotation.oldtasktitle		= $("#oldtasktitle").val();	
            annotation.oldtaskdesc		= $("#oldtaskdescription").val();
            annotation.newtasktitle		= $("#newtasktitle").val();	
            annotation.newtaskdesc		= $("#taskdescription").val();
            annotation.newtasknotes		= $("#newtasknotes").val();
            annotation.oldtasknotes		= $("#oldtasknotes").val();*/

            annotation.createdempcode = $("#createdpm").val();






            //annotation.oldattachment	= $("#attachmentlist").val();





            if (annotation.section_title == 'Choose your option' || annotation.section_title == null || annotation.section_title == '') {
                annotation.section_title = $("#newtasktitle").val();
            }


            if (annotation.category == null) {
                annotation.category = '0';
                /*annotation.attachment	= $("#newattachmentlist").val();
                annotation.tasktitle	= $("#newtasktitle").val();	
                annotation.taskdesc		= $("#taskdescription").val();
                annotation.tasknotes	= $("#newtasknotes").val();
                annotation.section_title = $("#newtasktitle").val();*/


            }

            annotation.attachment = $("#newattachmentlist").val();
            annotation.tasktitle = $("#newtasktitle").val();
            annotation.taskdesc = $("#taskdescription").val();
            annotation.tasknotes = $("#newtasknotes").val();
            annotation.section_title = $("#newtasktitle").val();
            annotation.emailnotation = $("input[name='emailnotation']:checked").val();
            annotation.section = $("#multi-select-user-newtask").val();

            annotation.jobid = $("#select-jobid").val();

            if (annotation.section == null) {
                annotation.section = null;
            }
            if (annotation.emailnotation == null) {
                annotation.emailnotation = null;
            }

            $("#tasklistapi").val('');
        }


        //Create the categories section inside the editor
        Categories.prototype.AnnotationCategory = function(editor, annotation, annotations) {
            var _categories = this.options.categories; //Categories plug-in

            if ($.isEmptyObject(_categories)) {
                var hidestye = "style= display:none;";
                var showstye = ' active';
            } else {
                var hidestye = "";
                var showstye = ' active';
            }

            var editor = $('form.annotator-widget > ul.annotator-listing'); //Place to add categories.
            // //If the category section not exists
            // editor.prepend("<li class='annotator-item annotator-radio btn-group' data-toggle='buttons' id='pad20'><button class='btn btn-success btn-sm' onclick='myFunction()' id='myDIVTaskbtn'>New Task</button><div id='myDIVTask' style='display:none'><div><div class='padfrm'><label>Task Title <span class='required'>*</span></label><input type='text' name='field1' class='field-long' placeholder='Task Title' /></div><div class='padfrm'><label>Task Description <span class='required'>*</span></label><textarea name='field5' id='field5' class='field-long field-textarea' placeholder='Task Description'></textarea></div></div></div></li>");

            // alert(annotation.quote);
            var userlistapidata = document.getElementById("taskuserlist").value;
            var newuserlistapidata = document.getElementById("newtaskuserlist").value;
            var usertokencode = document.getElementById("usertokencode").value;
            //annotation.quote	= document.getElementById("annotationdescription").value;
            //alert(document.getElementById("annotationdescription").value);
            //var getjobgetdetails	=	$("#pmjobid").val();

            var getselectedjoburl = $('.page-content').attr('data-job-detail-url');

            if (getselectedjoburl == undefined || getselectedjoburl == '') {

                return false;

            }

            var jobid = $('#pmjobid').select2("val");
            //alert(jobid);
            //return false;
            $("#mailbodycontent").removeClass();
            $("#btnannatorcompleted").show();
            $("#btnnonbusiness").show();

            if (jobid.length == '1') {
                var singlejob = '&singlejob=1';
            } else {
                var singlejob = '';
            }
            $.ajax({
                // url: '/pmbot_v/v4/annotation/getselectedjob',
                url: getselectedjoburl,
                type: "POST",
                crossdomain: true,
                headers: { 'X-CSRF-Token': usertokencode },
                data: '_token=' + usertokencode + '&jobid=' + jobid + singlejob,
                success: function(data) {
                    $("#userselectedjoblist").html(data['message']);
                    //if(jobid.length == '1'){
                    getjob_tasklist(jobid);
                    //}
                },
                error: function() {}
            });

            //if ($('li.annotator-radio').length == 0) {
            editor.html("<li class='annotator-item annotator-radio btn-group' data-toggle='buttons' id='pad20'><div id='taskTab' class='container'><ul class='nav nav-pills'><li id='tasklist' class='" + showstye + "'><a href='#2b' data-toggle='tab'>New Task</a> </li></ul><div class='tab-content clearfix'><div class='tab-pane " + showstye + "' id='2b'><div class='row'><div class='col-xs-6'><div class='form-group'><label for='tasklist' class='tasklabel'>Job ID</label><div id='userselectedjoblist'></div></div></div><div class='col-xs-6' id='showtaskselection'><div class='form-group'><label for='tasklist' class='tasklabel'>Task ID <span class='red'>*</span></label><div id='jobtasklist'></div></div></div></div><div class='row'><div class='col-xs-6'><div class='form-group'><label for='taskuserlist' class='tasklabel'>User List <span class='red'>*</span></label>" + newuserlistapidata + " </div></div><div class='col-xs-6'><div class='form-group'><label for='tasktitlelist' class='taskTitlelabel'>Title <span class='red'>*</span></label><input type='text' name='tasktitle' id='newtasktitle' value='' class='field-long form-control' placeholder='Task Title' /></div></div></div><div class='row'><div class='col-xs-6'><div class='form-group'><label for='mailcontent'>Description</label><textarea name='taskdescription' id='taskdescription' class='field-long field-textarea' placeholder='Task Description'>" + annotation.quote + "</textarea></div></div><div class='col-xs-6'><div class='form-group'><label for='mailcontent'>Notes</label><textarea name='newtasknotes' id='newtasknotes' class='field-long field-textarea' placeholder='Task Notes'></textarea></div></div></div><div class='row'><div class='col-xs-6'><div class='form-group'><label for='attachmentlistlabel'>Attachment</label><select class='form-control' multiple='multiple'  id='newattachmentlist' ></select></div></div><div class='col-xs-6'><div class='form-group'><label for='mailcontent'>New Attachment</label><div class='input-group'  style='padding:6px 0px;'><input name='additionalattach' id='filecount' multiple='multiple' type='file'></div><div class='form-group'><label><button id='clear' class='btn btn-default btn-sm' type='button'>Clear</button></label></div></div></div></div><div class='row'><div class='col-xs-8'><div class='form-group radio-toggle'><div class='form-check'><label class='form-check-label'><input class='form-check-input' type='radio' name='emailnotation' id='Escalation' value='Escalation'>Escalation </label><label class='form-check-label'><input class='form-check-input' type='radio' name='emailnotation' id='Appreciation' value='Appreciation'>Appreciation </label></div></div></div></div></div></div></div></div></div></li>");

            //}

            $('.radio-toggle').toggleInput();
            jQuery(function($) {
                $('.radio-toggle').toggleInput();
            });
            $('#browseButton2').on('click', function() {
                $('#fileUploader2').click();
            });
            $('#fileUploader2').change(function() {
                $('#fileName2').val($(this).val());
            });

            var _radioGroup = $('#tasklistapi'); //Place to add radiobuttons
            var checked = "checked = 'checked'";
            //var _radioGroup = $('li.annotator-radio > .mdb-select'); //Place to add radiobuttons
            //var checked = "checked = 'checked'";
            i = 1;
            $('#multi-select-user').select2({
                includeSelectAllOption: true,
                buttonWidth: 250,
                enableFiltering: false
            });

            $('#multi-select-user-newtask').select2({
                includeSelectAllOption: true,
                buttonWidth: 250,
                enableFiltering: false
            });

            $('#select-jobid').select2({
                includeSelectAllOption: true,
                enableFiltering: false
            });




            $('#filecount').filestyle({
                badgeName: "badge-danger",
                onChange: function(param) {
                    var fileInput = $("#filecount");
                    var data = new FormData();
                    for (var i = 0; i < fileInput[0].files.length; ++i) {
                        data.append('keysfile[]', fileInput[0].files[i]);
                    }
                    data.append("_token", usertokencode);
                    annotation.newattachment = null;
                    $.ajax({
                        url: '/pmbot_v/v4/annotation/newattachment',
                        type: "POST",
                        crossdomain: true,
                        processData: false,
                        contentType: false,
                        data: data,
                        //beforeSend: function(){$("#overlay").show();},
                        success: function(data) {
                            //$("#pmjobIDlist").html(data['message']);
                            annotation.newattachment = null;
                            annotation.newattachment = data['message'];
                        },
                        error: function() {}
                    });

                }
            });

            $('#clear').click(function() {
                $('#filecount').filestyle('clear');
            });

            /*$('.mailbox-attachments').each(function(){// id of ul
            	var li = $(this).find('li')//get each li in ul
            	console.log(li.innerText)//get text of each li
            })*/


            $(".mailbox-attachments li").each(function(index) {
                //console.log( index + ": " + $( this ).text() );
                $('#newattachmentlist').append('<option value="' + $(this).text() + '">' + $(this).text() + '</option>');
                $('#attachmentlist').append('<option value="' + $(this).text() + '">' + $(this).text() + '</option>');
            });

            $('#newattachmentlist,#attachmentlist ').select2({
                includeSelectAllOption: true,
                buttonWidth: 250,
                enableFiltering: false
            });



            for (cat in _categories) {
                var array = cat.split('||');
                startselectoption = "<option value='' disabled selected>Choose your option</option>";
                if (i > 1) checked = "";

                switch (i) {
                    case 1:
                        //startselectoption  = "<option value='' disabled selected>Choose your option</option><option ></option>";

                    case 2:
                        classname = 'warning1';
                        startdiv = '<select class="md-form mdb-select colorful-select dropdown-primary"><option value="" disabled selected>Choose your option</option>';
                        enddiv = '</select>';
                        //startselectoption  = "<option value='' disabled selected>Choose your option</option><option ></option>";

                        break;
                    case 3:
                    case 4:
                        classname = 'primary1';
                        startdiv1 = '<div class="sectionone btn btn-primary"><div class="row"><div class="col-md-6"><select class="md-form mdb-select colorful-select dropdown-primary"><option value="" disabled selected>Choose your option</option>';
                        enddiv1 = '</select></div>';
                        startdiv = '';
                        enddiv = '<hr style="clear:both; margin-bottom:0px;">';
                        //startselectoption  = "<option value='' disabled selected>Choose your option</option><option ></option>";
                        break;
                    case 5:
                        classname = 'btn btn btn-success';
                        startdiv = '<hr style="clear:both; margin-bottom:0px;"><div class="sectiontwo btn">';
                        enddiv = '</div><hr style="clear:both; margin-bottom:0px;">';
                        //startselectoption  = "<option value='' disabled selected>Choose your option</option><option ></option>";
                        break;
                    case 6:
                    case 7:
                    case 8:
                    case 9:
                    case 10:
                    case 11:
                        classname = 'warning1';
                        startdiv = '<div class="sectionthree btn btn-warning">';
                        enddiv = '</div>';
                        //startselectoption  = "<option value='' disabled selected>Choose your option</option><option ></option>";
                        break;
                    case 12:
                        classname = 'warning1';
                        startdiv = '<hr style="clear:both; margin-bottom:0px;"><div class="sectionfour btn btn-warning ">';
                        enddiv = '</div>';
                        //startselectoption  = "<option value='' disabled selected>Choose your option</option><option ></option>";
                        break;


                }

                // var optionstart = "";
                //var optionend 	="</select>";
                //var radio = optionstart+"<option value='"+ array[1] +"'>"+ array[0] +"</option>"+optionend;



                /* if(cat == 'Custommessage'){
			   var radio = startdiv+"<label class='btn1 btn-"+classname+"' onClick=\"shownotes('"+ cat+"')\" >"+$.i18n._(cat)+"<input id='"+ cat+"' type='radio' "+checked+" placeholder='"+ cat+"' name='categories-annotation' value='"+ cat +"' style='margin-left:5px' /></label>"+enddiv;
		  } else {
			   var radio = startdiv+"<label class='btn1 btn-"+classname+"' onClick=\"shownotes('"+ cat+"')\">"+$.i18n._(cat)+"<input id='"+ cat+"' type='radio' "+checked+" placeholder='"+ cat+"' name='categories-annotation' value='"+ cat +"' style='margin-left:5px'/></label>"+enddiv;
		  }*/

                //radio = '<div class="row"><div class="col-md-6"><select class="md-form mdb-select colorful-select dropdown-primary"><option value="" disabled selected>Choose your option</option><option value="1">White</option><option value="2">Black</option><option value="3">Pink</option></select><label>Select color</label></div><div class="col-md-6"><select class="md-form mdb-select colorful-select dropdown-primary"><option value="" disabled selected>Choose your option</option><option value="1">XS</option><option value="2">S</option><option value="3">L</option></select><label>Select size</label></div></div>';  

                //radio = radio + '<label for="annotator-field-'+i+'" style="vertical-align: middle;text-transform:capitalize;"><div class="'+_categories[cat]+' square" style="display:inline-block;height:15px;width:30px;margin-top:3px;margin-bottom:3px;margin-rigth:5px;vertical-align:middle"></div><span style="margin-left:5px">'+$.i18n._(cat)+'</span></label><br/>';

                /*if(cat == 'Custommessage'){
			   var radio = startdiv+"<label class='btn1 btn-"+classname+"' onClick=\"shownotes('"+ cat+"')\" >"+$.i18n._(cat)+"<input id='"+ cat+"' type='radio' "+checked+" placeholder='"+ cat+"' name='categories-annotation' value='"+ cat +"' style='margin-left:5px' /></label>"+enddiv;
		  } else {
			   var radio = startdiv+"<label class='btn1 btn-"+classname+"' onClick=\"shownotes('"+ cat+"')\">"+$.i18n._(cat)+"<input id='"+ cat+"' type='radio' "+checked+" placeholder='"+ cat+"' name='categories-annotation' value='"+ cat +"' style='margin-left:5px'/></label>"+enddiv;
		  }
		  */

                if (i == '1') {
                    var radio = startselectoption + "<option value='" + array[1] + "'>" + array[0] + "</option>";
                } else {
                    var radio = "<option value='" + array[1] + "'>" + array[0] + "</option>";
                }
                // var radio = startdiv+"<label class='btn1 btn-"+classname+"' onClick=\"shownotes('"+ cat+"')\">"+$.i18n._(cat)+"<input id='"+ cat+"' type='radio' "+checked+" placeholder='"+ cat+"' name='categories-annotation' value='"+ cat +"' style='margin-left:5px'/></label>"+enddiv;



                radio = radio;
                i = i + 1;
                _radioGroup.append(radio);
            }

            //}   
            if (annotation.category) {
                $('#' + annotation.category).prop('checked', true);
            }
        }

        //When an annotation is changed we have to change the attributes
        Categories.prototype.onAnnotationUpdated = function(annotation) {

            $("span[id=" + annotation.id + "]").attr('class', 'annotator-hl-' + annotation.category);
        };


        Categories.prototype.annotationCreated = function(annotation) {
            var cat, h, highlights, _i, _len, _results;

            $("span[id=" + annotation.id + "]").attr('id', annotation.id);
            cat = annotation.category;
            highlights = annotation.highlights;
            if (cat) { //If have a category
                _results = [];
                for (_i = 0, _len = highlights.length; _i < _len; _i++) {
                    h = highlights[_i];
                    _results.push(h.className = h.className + ' ' + this.options.categories[cat]);
                }
                return _results;
            }
        };

        Categories.prototype.updateField = function(field, annotation) {
            var category;
            category = '';
            if (field.checked = 'checked') {
                category = annotation.category;
            }
            //console.log('updateField');
            return this.input.val(category);
        };

        Categories.prototype.updateViewer = function(field, annotation) {
            field = $(field);
            field.html('<span class="annotator-hl-' + annotation.category + '">' + $.i18n._(annotation.category).toUpperCase() + '</span>').addClass('annotator-hl-' + annotation.category);

        };

        return Categories;

    })(Annotator.Plugin);

}).call(this);