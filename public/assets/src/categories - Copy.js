(function() {
  var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

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
      this.annotator.subscribe("annotationEditorSubmit",this.AnnotationSection);      

      //Call editor before show and write color checker
      this.annotator.subscribe("annotationEditorShown",this.AnnotationCategory);     

      //Annotation creation
      this.annotator.subscribe("annotationCreated",this.annotationCreated);    

      //Showing annotations
      this.annotator.subscribe("annotationViewerShown",this.AnnotationViewer);   

      this.annotator.subscribe("annotationUpdated ",this.updateAnnotation);  

    };

    //After loading annotations we want to change the annotation color and add the annotation id
    Categories.prototype.onAnnotationsLoaded = function(annotations) {
      var annotation;
      var _categories = this.options.categories; //Categories plug-in

      $('#count-anotations').text( annotations.length );
      if (annotations.length > 0) {
        for(i=0, len = annotations.length; i < len; i++) {
          annotation = annotations[i];    
          var category = "annotator-hl-" + annotation.category;
          if (annotation.category in _categories) {
             category = _categories[annotation.category];
           }           
          $(annotation.highlights).addClass(category);  
          $(annotation.highlights).attr('id', annotation.id ); 
        }
      }
    };

     //After loading annotations we want to change the annotation color and add the annotation id
    Categories.prototype.updateAnnotation = function(annotation) {     
      var category = this.options.categories[annotation.category]; 
     
      $(annotation.highlights).attr("class","annotator-hl " + category);   
     
    };

     //After loading annotations we want to change the annotation color and add the annotation id
    Categories.prototype.AnnotationViewer = function(viewer, annotations) {
      var annotation;
      var isShared = ""; 
      var class_label="label";
      
      if (annotations.length > 0) {
        for(i=0, len = annotations.length; i < len; i++) {
          annotation = annotations[i]; 
          
          /*if (annotation.estat==1 || annotation.permissions.read.length===0 ) {
            isShared = "<img src=\"../src/img/shared-icon.png\" title=\""+ i18n_dict.share +"\" style=\"margin-left:5px\"/>"
          }*/
          if (annotation.propietary==0) {
            class_label = "label-compartit";
          }
          $('ul.annotator-widget > li.annotator-item').prepend('<div class="'+annotation.category+'" style="border: 1px solid #b3b3b3;height:6px;margin:4px;padding:4px;"></div>');
          $( "div.annotator-user" ).html( "<span class='"+class_label+"'></span>"+isShared);
          
        }
      }
    }


    //Section order and section title
    Categories.prototype.AnnotationSection = function(editor,annotation) {
      //Assign a categoy to the annotation

      //Put the annotation section an annotation title
      var ref = $('.annotator-hl-temporary').closest('div[data-section]');
      if (ref) {
        annotation.section = ref.data('section');
        annotation.section_title = ref.data('title');
		annotation.notes = '';
      } else {
        console.log("Section not detected!!!")
      }
      annotation.order = $('.annotator-hl-temporary').closest('div[id]').attr('id');       
      annotation.category = $('input:radio[name=categories-annotation]:checked').val();

    }
	

     //Create the categories section inside the editor
    Categories.prototype.AnnotationCategory = function(editor,annotation) {
      var _categories = this.options.categories; //Categories plug-in
      var editor = $('form.annotator-widget > ul.annotator-listing'); //Place to add categories.
      if ($('li.annotator-radio').length == 0) { //If the category section not exists
       // editor.prepend("<li class='annotator-item annotator-radio btn-group' data-toggle='buttons' id='pad20'><button class='btn btn-success btn-sm' onclick='myFunction()' id='myDIVTaskbtn'>New Task</button><div id='myDIVTask' style='display:none'><div><div class='padfrm'><label>Task Title <span class='required'>*</span></label><input type='text' name='field1' class='field-long' placeholder='Task Title' /></div><div class='padfrm'><label>Task Description <span class='required'>*</span></label><textarea name='field5' id='field5' class='field-long field-textarea' placeholder='Task Description'></textarea></div></div></div></li>");
		
		 editor.prepend("<li class='annotator-item annotator-radio btn-group' data-toggle='buttons' id='pad20'><div id='taskTab' class='container'><ul class='nav nav-pills'><li class='active' id='tasklist'><a  href='#1b' data-toggle='tab'>Task</a></li><li id='tasklist'><a href='#2b' data-toggle='tab'>New Task</a> </li></ul><div class='tab-content clearfix'><div class='tab-pane active' id='1b'><div class='form-group'><label for='tasklist'>Task List</label><div id='tasklistapi'></div></div></div><div class='tab-pane' id='2b'><div class='form-group'><label for='email'>Title:</label><input type='text' name='tasktitle' id='tasktitle' value='' class='field-long form-control' placeholder='Task Title' /></div><div class='form-group'><label for='pwd'>Description:</label><textarea name='taskdescription' id='taskdescription' class='field-long field-textarea' placeholder='Task Description'></textarea></div><button type='submit' class='btn btn-primary btn-sm'>Submit</button></div></div></div></div></li>");
		
        var _radioGroup = $('li.annotator-radio > .mdb-select'); //Place to add radiobuttons
        var checked = "checked = 'checked'";
        i=1;
        for (cat in _categories) {
          if (i>1) checked="";
		  alert(i);
		   switch (i) {
				case 1:
					classname = 'warning1';
					startdiv  = '';
					enddiv    = '<hr style="clear:both; margin-bottom:0px;">';
				case 2:
					classname = 'warning1';
					startdiv  = '';
					enddiv    = '<hr style="clear:both; margin-bottom:0px;">';
					break;
				case 3:
				case 4:
					classname = 'primary1';
					startdiv1  = '<div class="sectionone btn btn-primary"><div class="row"><div class="col-md-6"><select class="md-form mdb-select colorful-select dropdown-primary"><option value="" disabled selected>Choose your option</option>';
					enddiv1    = '</select></div>';
					startdiv  = '';
					enddiv    = '<hr style="clear:both; margin-bottom:0px;">';
					break;
				case 5:
					classname = 'btn btn btn-success';
					startdiv  = '<hr style="clear:both; margin-bottom:0px;"><div class="sectiontwo btn">';
					enddiv    = '</div><hr style="clear:both; margin-bottom:0px;">';
					break;
				case 6:
				case 7:
				case 8:
				case 9:
				case 10:
				case 11:
					classname = 'warning1';
					startdiv  = '<div class="sectionthree btn btn-warning">';
					enddiv    = '</div>';
					break;
				case 12:
					classname = 'warning1';
					startdiv  = '<hr style="clear:both; margin-bottom:0px;"><div class="sectionfour btn btn-warning ">';
					enddiv    = '</div>';
					break;
					
		  
		   }
		   
		    var optionselect = "<select class='md-form mdb-select colorful-select dropdown-primary'><option value='' disabled selected>Choose your option</option>";
		    var radio = startdiv+"<option value='"+ cat +"'>"+ cat +"</option>"+enddiv;
			
			
		  
		 /* if(cat == 'Custommessage'){
			   var radio = startdiv+"<label class='btn1 btn-"+classname+"' onClick=\"shownotes('"+ cat+"')\" >"+$.i18n._(cat)+"<input id='"+ cat+"' type='radio' "+checked+" placeholder='"+ cat+"' name='categories-annotation' value='"+ cat +"' style='margin-left:5px' /></label>"+enddiv;
		  } else {
			   var radio = startdiv+"<label class='btn1 btn-"+classname+"' onClick=\"shownotes('"+ cat+"')\">"+$.i18n._(cat)+"<input id='"+ cat+"' type='radio' "+checked+" placeholder='"+ cat+"' name='categories-annotation' value='"+ cat +"' style='margin-left:5px'/></label>"+enddiv;
		  }*/
		  
		//radio = '<div class="row"><div class="col-md-6"><select class="md-form mdb-select colorful-select dropdown-primary"><option value="" disabled selected>Choose your option</option><option value="1">White</option><option value="2">Black</option><option value="3">Pink</option></select><label>Select color</label></div><div class="col-md-6"><select class="md-form mdb-select colorful-select dropdown-primary"><option value="" disabled selected>Choose your option</option><option value="1">XS</option><option value="2">S</option><option value="3">L</option></select><label>Select size</label></div></div>';  
         
          //radio = radio + '<label for="annotator-field-'+i+'" style="vertical-align: middle;text-transform:capitalize;"><div class="'+_categories[cat]+' square" style="display:inline-block;height:15px;width:30px;margin-top:3px;margin-bottom:3px;margin-rigth:5px;vertical-align:middle"></div><span style="margin-left:5px">'+$.i18n._(cat)+'</span></label><br/>';
		  
		   var radio = startdiv+"<label class='btn1 btn-"+classname+"' onClick=\"shownotes('"+ cat+"')\">"+$.i18n._(cat)+"<input id='"+ cat+"' type='radio' "+checked+" placeholder='"+ cat+"' name='categories-annotation' value='"+ cat +"' style='margin-left:5px'/></label>"+enddiv;
		  radio = radio;
          i = i + 1;
          _radioGroup.append(radio);
        } 

      }   
      if (annotation.category) {
        $('#' + annotation.category).prop('checked',true);
      }
    }

    //When an annotation is changed we have to change the attributes
    Categories.prototype.onAnnotationUpdated = function(annotation) {
     $( "span[id="+annotation.id+"]" ).attr('class','annotator-hl-'+annotation.category);
    };

    
    Categories.prototype.annotationCreated = function(annotation) {
      var cat, h, highlights, _i, _len, _results;
      
      $( "span[id="+annotation.id+"]" ).attr('id',annotation.id);
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
      console.log('updateField');
      return this.input.val(category);
    };

    Categories.prototype.updateViewer = function(field, annotation) {
      field = $(field);
      field.html('<span class="annotator-hl-' + annotation.category + '">' +$.i18n._(annotation.category).toUpperCase() + '</span>').addClass('annotator-hl-'+ annotation.category );
     
    };

    return Categories;

  })(Annotator.Plugin);

}).call(this);
