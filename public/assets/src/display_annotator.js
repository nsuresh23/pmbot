	function groupBy(collection, property) {
    var i = 0, val, index,
        values = [], result = [];
    for (; i < collection.length; i++) {
        val = collection[i][property];
        index = values.indexOf(val);
        if (index > -1)
            result[index].push(collection[i]);
        else {
            values.push(val);
            result.push([collection[i]]);
        }
    }
    return result;
}


(function() {
  var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  //constants
  var IMAGE_DELETE =  'http://172.24.188.26:81/pmbot/assets/src/img/icono_eliminar.png',
  IMAGE_DELETE_OVER = 'http://172.24.188.26:81/pmbot/assets/src/img/papelera_over.png',
  SHARED_ICON = 'http://172.24.188.26:81/pmbot/assets/src/img/shared-icon.png';
  LOGO_ICON = 'http://172.24.188.26:81/pmbot/emailannotator/assets/img/logo.png';
  LOGOUT_ICON = 'http://172.24.188.26:81/pmbot/emailannotator/assets/img/logout.jpg';

  Annotator.Plugin.AnnotatorViewer = (function(_super) {
    __extends(AnnotatorViewer, _super);

    AnnotatorViewer.prototype.events = {
      'annotationsLoaded': 'onAnnotationsLoaded',
      'annotationCreated': 'onAnnotationCreated',
      'annotationDeleted': 'onAnnotationDeleted',
      'annotationUpdated': 'onAnnotationUpdated',
      ".annotator-viewer-delete click": "onDeleteClick",
      ".annotator-edit click": "onEditClick",
      ".annotator-viewer-delete mouseover": "onDeleteMouseover",
      ".annotator-viewer-delete mouseout": "onDeleteMouseout",
    };


    AnnotatorViewer.prototype.field = null;

    AnnotatorViewer.prototype.input = null;

    AnnotatorViewer.prototype.options = {
      AnnotatorViewer: {}
    };


    function AnnotatorViewer(element, options) {
      this.onAnnotationCreated = __bind(this.onAnnotationCreated, this);
      this.onAnnotationUpdated = __bind(this.onAnnotationUpdated, this);
      this.onDeleteClick = __bind(this.onDeleteClick, this);
      this.onEditClick = __bind(this.onEditClick, this);
      this.onDeleteMouseover = __bind(this.onDeleteMouseover, this);
      this.onDeleteMouseout = __bind(this.onDeleteMouseout, this);
      this.onCancelPanel = __bind(this.onCancelPanel,this);
      this.onSavePanel = __bind(this.onSavePanel,this);

      AnnotatorViewer.__super__.constructor.apply(this, arguments);

      $( "#content" ).append( this.createAnnotationPanel() );

      //$(".container-anotacions").toggle("slide");
      $("#annotations-panel").click(function(event) {
        $(".container-anotacions").toggle("slow");       
      });
     

    };

    AnnotatorViewer.prototype.pluginInit = function() {
      if (!Annotator.supported()) {
        return;
      }
      

      $('#type_share').click(this.onFilter);
      $('#type_own').click(this.onFilter);
     
    };

    /*
    Check the checkboxes filter to search the annotations to show.
    Shared annotations have the class shared
    My annotations have the me class
    */
    AnnotatorViewer.prototype.onFilter = function(event) {
      var annotations_panel = $(".container-anotacions").find('.annotator-marginviewer-element');
      $(annotations_panel).hide();  

      var class_view = "";
     
      var checkbox_selected = $('li.filter-panel').find('input:checked'); 
      if (checkbox_selected.length > 0) {
          $('li.filter-panel').find('input:checked').each(function () {
            class_view += $(this).attr('rel') + '.';
          });     
          $('.container-anotacions > li.' + class_view.substring(0,class_view.length-1)).show();
      } else {
        $(annotations_panel).show();   
      }
      

    };

    AnnotatorViewer.prototype.onDeleteClick = function(event) {
      event.stopPropagation();
      if(confirm(i18n_dict.confirm_delete)) {
        this.click;
        return this.onButtonClick(event, 'delete');
      }
      return false;
    };

     AnnotatorViewer.prototype.onEditClick = function(event) {
      event.stopPropagation();
      return this.onButtonClick(event, 'edit');     
    };

    AnnotatorViewer.prototype.onButtonClick = function(event, type) {
      var item;
      //item contains all the annotation information, this information is stored in an attribute called data-annotation.
      item = $(event.target).parents('.annotator-marginviewer-element');
      if (type=='delete') return this.annotator.deleteAnnotation(item.data('annotation'));
      if (type=='edit') { //We want to transform de div to a textarea
        //Find the text field
        var annotator_textArea = item.find('div.anotador_text');
        this.textareaEditor(annotator_textArea,item.data('annotation'));
       
      }
    };

    //Textarea editor controller
    AnnotatorViewer.prototype.textareaEditor = function(annotator_textArea,item) {
        //First we have to get the text, if no, we will have an empty text area after replace the div 
        if ($('li#annotation-'+item.id).find('textarea.panelTextArea').length==0) {
          var content = item.quote;
          var editableTextArea = $("<textarea id='textarea-"+item.id+"'' class='panelTextArea'>"+content+"</textarea>");
          var annotationCSSReference = 'li#annotation-'+item.id+' > div.annotator-marginviewer-text';

          annotator_textArea.replaceWith(editableTextArea);
          editableTextArea.css('height',editableTextArea[0].scrollHeight + 'px');
          editableTextArea.blur(); //Textarea blur
          if (typeof(this.annotator.plugins.RichEditor)!= 'undefined') {
            this.tinymceActivation(annotationCSSReference +' > textarea#textarea-'+item.id );
          }
          $('<div class="annotator-textarea-controls annotator-editor"></div>').insertAfter(editableTextArea); 
          var control_buttons = $( annotationCSSReference + '> .annotator-textarea-controls');
          $('<a href="#save" class="annotator-panel-save">Save</a>').appendTo(control_buttons).bind("click",{annotation:item},this.onSavePanel);
          $('<a href="#cancel" class="annotator-panel-cancel">Cancel</a>').appendTo(control_buttons).bind("click", {annotation:item},this.onCancelPanel);
        }
    };

      AnnotatorViewer.prototype.tinymceActivation = function(selector) {
            tinymce.init({
              selector: selector,
              plugins: "media image insertdatetime link paste",
              menubar: false,
              statusbar: false,             
              toolbar_items_size: 'small',
              extended_valid_elements : "",
              toolbar: "undo redo bold italic alignleft aligncenter alignright alignjustify | link image media"
            });
    }

    //Event triggered when save the content of the annotation
    AnnotatorViewer.prototype.onSavePanel = function(event) {
  
      var current_annotation = event.data.annotation;
      var textarea = $('li#annotation-'+current_annotation.id).find("#textarea-"+current_annotation.id);
      if (typeof(this.annotator.plugins.RichEditor)!='undefined') {
        current_annotation.text = tinymce.activeEditor.getContent();
        tinymce.remove("#textarea-"+current_annotation.id);
        tinymce.activeEditor.setContent(current_annotation.text);
      } else {
        current_annotation.text = textarea.val();  
		current_annotation.statusinfo = 'Pending'; 
        //this.normalEditor(current_annotation,textarea);     
     }
      var anotation_reference = "annotation-"+current_annotation.id;
      $('#'+anotation_reference).data('annotation', current_annotation);  
	  
    
      this.annotator.updateAnnotation(current_annotation);      
    };

     //Event triggered when save the content of the annotation
    AnnotatorViewer.prototype.onCancelPanel = function(event) {
      var current_annotation = event.data.annotation;
	 
      var styleHeight = 'style="height:12px"';
      if (current_annotation.text.length>0) styleHeight = '';

      if (typeof(this.annotator.plugins.RichEditor)!='undefined') {
        tinymce.remove("#textarea-"+current_annotation.id);
     
        var textAnnotation = '<div class="anotador_text" '+styleHeight+'>' + current_annotation.text + '</div>';
        var anotacio_capa =  '<div class="annotator-marginviewer-text"><div class="'+current_annotation.quote+' anotator_color_box"></div>'+ textAnnotation  + '</div><div>'+current_annotation.notes+'</div>';
        var textAreaEditor = $('li#annotation-'+current_annotation.id + ' > .annotator-marginviewer-text');
       
        textAreaEditor.replaceWith(anotacio_capa);
      } else {
        var textarea = $('li#annotation-'+current_annotation.id).find('textarea.panelTextArea');
        this.normalEditor(current_annotation,textarea);
      }

    };

       //Annotator in a non editable state
    AnnotatorViewer.prototype.normalEditor = function(annotation,editableTextArea) {
      var buttons = $('li#annotation-'+annotation.id).find('div.annotator-textarea-controls');
      var textAnnotation = this.removeTags('iframe',annotation.text);
      editableTextArea.replaceWith('<div class="anotador_text">'+textAnnotation+'</div>');
      buttons.remove();
    };

   

     AnnotatorViewer.prototype.onDeleteMouseover = function(event) {
       $(event.target).attr('src',IMAGE_DELETE_OVER);
    };

     AnnotatorViewer.prototype.onDeleteMouseout = function(event) {
      $(event.target).attr('src', IMAGE_DELETE);      
    };

    AnnotatorViewer.prototype.onAnnotationCreated = function(annotation) { 
		
      this.createReferenceAnnotation(annotation);
      $('#count-anotations').text($(".container-anotacions").find('.annotator-marginviewer-element').length );
    };

    AnnotatorViewer.prototype.onAnnotationUpdated = function(annotation) {
		
		

      $( "#annotation-"+annotation.id ).html( this.mascaraAnnotation(annotation) );       
    };

    AnnotatorViewer.prototype.onAnnotationsLoaded = function(annotations) {
      var annotation;
	  annotations = groupBy(annotations, "group_ID")
	   var pageidcommon = annotations[0];
	   var str = JSON.stringify(pageidcommon, null, 4);
	   
	   if(annotations.length == 0) {
		 var pageiddata = $( "#emailid" ).val();
	   } else {
		    var parsedData = JSON.parse(str);
			var pageiddata = annotations[0].page_id;
			
	   }
	   
	  // console.log($( "#emailid" ).val());
	  
	  $( "#emailidcontent" ).html( $("#emailid" ).val() ); 
      $('#count-anotations').text( $(".container-anotacions").find('.annotator-marginviewer-element').length );
      if (annotations.length > 0) {
        for(i=0, len = annotations.length; i < len; i++) {
			 annotation = annotations[i];
			 //console.log(annotation); 
			 this.createReferenceAnnotation(annotation); 
        }
		//  
		  //return false; 
        
      }
	  return false;
      
    };

    
    AnnotatorViewer.prototype.onAnnotationDeleted = function(annotation) {
      
      $( "li" ).remove( "#annotation-"+annotation.id );      
      $('#count-anotations').text( $(".container-anotacions").find('.annotator-marginviewer-element').length );
      
    };

    AnnotatorViewer.prototype.mascaraAnnotation = function(annotation) {
		var annotation_layer = '';
		if (annotation.length > 0) {
			for (var i = 0; i < annotation.length; i++) {
				console.log(annotation[i].group_ID);
				if(annotation[i].group_ID === null){
					if (annotation[i].category != null) {
						anotation_color = annotation[i].category;
					} else {
						anotation_color = "hightlight";
					}
					annotationgroupcheckbox= '&nbsp;&nbsp;<input type="checkbox"  name="actionmail" value="'+annotation[i].group_ID+'" id="actionmail" style="vertical-align:middle; margin:0px;">&nbsp;&nbsp;';
					annotation_layer+=  '<div class="annotator-marginviewer-text" ><div class="'+anotation_color+' anotator_color_box"><label  style="word-wrap:break-word">'+annotationgroupcheckbox+''+  annotation[i].category  + '</label></div></div>';
					annotation_layer+= '</div><div class="annotator-marginviewer-quote">&nbsp;&nbsp;'+ annotation[i].quote + '</div></div>';
				} else {
					if (annotation[i].category != null) {
						anotation_color = annotation[i].category;
					} else {
						anotation_color = "hightlight";
					}
					if(i==0){
						annotation_layer+= '&nbsp;&nbsp;<span class="btn btn-secondary btn-sg span10 active"><input type="checkbox"  name="actionmail" value="'+annotation[i].group_ID+'" id="actionmail" style="vertical-align:middle; margin:0px;">&nbsp;&nbsp;'+annotation[i].group_ID+'</span>';
					}
					annotation_layer+=  '<div class="annotator-marginviewer-text" ><div class="'+anotation_color+' anotator_color_box"><label  style="word-wrap:break-word">&nbsp;&nbsp;'+  annotation[i].category  + '</label></div></div>';
					annotation_layer+= '</div><div class="annotator-marginviewer-quote">&nbsp;&nbsp;'+ annotation[i].quote + '</div></div>';
				}
			}
		}
      return annotation_layer;
    };

    AnnotatorViewer.prototype.createAnnotationPanel = function(annotation) {  
	  logo_annotation = "<div><img src=\""+LOGO_ICON+"\" title='Email Annotation Logo' style=\"cursor:pointer; margin:5px; width: auto; height: 85px; background-size: 100%;\" /></div><div align='right'></div>";
	  
	  var EMAILID = '<div class="emailticketinfo"><div class="list-group"><a class="list-group-item" href="#"><span class="badge badge-success" id="emailidcontent"></span> Reference Mail ID </a> </div></div>';
	  var checboxes =  '<div>'+logo_annotation+EMAILID+'</div>';
	  checboxes = checboxes +'';
	  
      var annotation_layer =  '<div  class="annotations-list-uoc" style="background-color:#F1F2F2; -moz-box-shadow: -5px -5px 5px #888; -webkit-box-shadow: -5px -5px 5px #888; box-shadow: -5px -5px 5px #888;"><div id="annotations-panel"><span class="rotate" title="'+ i18n_dict.view_annotations +' '+ i18n_dict.pdf_resum +'" style="padding:5px;background-color:#F1F2F2;  position: absolute; top:20em;left: -50px; width: 155px; height: 110px;cursor:pointer">'+ i18n_dict.view_annotations +'<span class="label-counter" style="padding:0.2em 0.3em;float:right" id="count-anotations">0</span></span></div><form><div id="anotacions-uoc-panel" style="height:80%"><ul class="container-anotacions"><li class="filter-panel">'+checboxes+'</li><li><button type="button"  id="emailresponse" class="btn btn-success btn-sg span10 active">Immediate Response</button></li></ul></div></form></div>';
     

	 return annotation_layer;
    };

   
    AnnotatorViewer.prototype.createReferenceAnnotation = function(annotation) {     
     var anotation_reference = null;
     var data_owner = "me";
     var data_type = "";
     var myAnnotation=false;

      if (annotation.id != null) {
        anotation_reference = "annotation-"+annotation.id;
      } else {
        annotation.id = this.uniqId();
        //We need to add this id to the text anotation
        $element = $('span.annotator-hl:not([id])');
        if ($element) {
          $element.prop('id',annotation.id);
        }
        anotation_reference = "annotation-"+annotation.id;
      }

      //if (annotation.estat==1 || annotation.permissions.read.length===0 ) {
//        data_type = "shared";
//       
//      }
      if (annotation.propietary==0) {
        data_owner = "";
      } else {
         myAnnotation=true;
      }
	  
	  console.log('========================');
	  console.log(annotation);
	  console.log('========================');

      var annotation_layer =  '<li class="annotator-marginviewer-element '+data_type+' '+data_owner+'" id="'+anotation_reference +'">'+this.mascaraAnnotation(annotation)+'</li>';
      var malert = i18n_dict.anotacio_lost

      anotacioObject = $(annotation_layer).appendTo('.container-anotacions').click(function(event) {
          var viewPanelHeight = jQuery(window).height();
          var annotation_reference = annotation.id;

          $element= jQuery("#"+annotation.id); 
          if (!$element.length) {
            $element= jQuery("#"+annotation.order);   
            annotation_reference = annotation.order; //If exists a sorted annotations we put it in the right order, using order attribute
          }

          if ($element.length) {
            elOffset = $element.offset();
            //$(this).children(".annotator-marginviewer-quote").toggle(slow);
            $('html, body').animate({
              scrollTop: $("#"+annotation_reference).offset().top - (viewPanelHeight/2)
            }, 2000);
          } 
      })
      .mouseover(function() {
        $element = jQuery("span[id="+annotation.id+"]");
        if ($element.length) {
          $element.css({
            "border-color":"#000000",
            "border-width":"1px",
            "border-style":"solid"});
        }
      })
      .mouseout(function() {
        $element = jQuery("span[id="+annotation.id+"]");
        if ($element.length) {
          $element.css({
            "border-width":"0px"});
        }
      });


      
      //Adding annotation to data element for delete and link
      $('#'+anotation_reference).data('annotation', annotation);
      $(anotacioObject).fadeIn('fast');
    };

    AnnotatorViewer.prototype.uniqId = function() {
      return Math.round(new Date().getTime() + (Math.random() * 100));
    } 

     //Strip content tags
    AnnotatorViewer.prototype.removeTags = function(striptags, html) { 
      striptags = (((striptags || '') + '').toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(''); 
      var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
      
      return html.replace(commentsAndPhpTags, '').replace(tags, function($0, $1) {
        return html.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
      });
    };  

  

    return AnnotatorViewer;

  })(Annotator.Plugin);

}).call(this);
