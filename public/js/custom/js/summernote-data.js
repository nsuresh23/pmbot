/*Summernote Init*/

$(function() {
    "use strict";
    // $('.summernote').summernote({
    //     height: 300,
    // });

    $('.textarea_editor').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['style']],
            ['fontsize', ['fontsize']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['fontname']],
            ['font', ['color']],
            ['insert', ['table']], // image and doc are customized buttons
            ['height', ['height']],
            ['para', ['ol', 'ul', 'paragraph']],
            ['insert', ['link']],
            // ['insert', ['link', 'image', 'doc', 'video']], // image and doc are customized buttons
            // ['misc', ['codeview', 'fullscreen']],
            ['misc', ['fullscreen']],
        ],
        fontsize: '18',
        height: 150, //set editable area's height
        blockquoteBreakingLevel: 2,
        disableDragAndDrop: true,
        codemirror: { // codemirror options
            theme: 'monokai'
        },
    });
    $('.email_textarea_editor').summernote({
        toolbar: [
            ['style', ['style']],
            ['fontsize', ['fontsize']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['fontname']],
            ['font', ['color']],
            ['insert', ['table']], // image and doc are customized buttons
            ['height', ['height']],
            ['para', ['ol', 'ul', 'paragraph']],
            ['insert', ['link']],
            // ['insert', ['link', 'image', 'doc', 'video']], // image and doc are customized buttons
            // ['misc', ['codeview', 'fullscreen']],
            ['misc', ['fullscreen']],
        ],
        fontsize: '18',
        height: 150, //set editable area's height
        blockquoteBreakingLevel: 2,
        disableDragAndDrop: true,
        codemirror: { // codemirror options
            theme: 'monokai'
        },
        enterHtml: '<br>',
    });

});

$(document).ready(function() {
    // $('.textarea_editor').summernote({
    //     onImageUpload: function(files, editor, welEditable) {
    //         sendFile(files[0], editor, welEditable);
    //     }
    // });

    tinymce.init({
        selector: '.textarea_editor_email',
        height: 500,
        menubar: false,
        keep_styles: true,
        browser_spellcheck: true,
        paste_data_images: true,
        plugins: 'advlist anchor autolink bootstrap charmap code codesample colorpicker directionality fullpage fullscreen hr image imagetools insertdatetime lineheight link lists media nonbreaking paste pagebreak print preview searchreplace table template textcolor textpattern visualblocks visualchars wordcount',
        fontsize_formats: '8pt 11pt 10pt 12pt 14pt 18pt 24pt 36pt',
        font_formats: ' Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Calibri=calibri; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats',
        toolbar: 'formatselect | fontselect | fontsizeselect | forecolor | backcolor | lineheightselect | bold italic underline strikethrough superscript subscript | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | link | removeformat | code | help',
        // content_style: "body { font-size: 14pt; font-family: Arial; }",
        setup: function(ed) {
            ed.on('init', function(ed) {
                ed.target.editorCommands.execCommand("fontName", false, "calibri");
                ed.target.editorCommands.execCommand("fontSize", false, "10pt");
                ed.target.editorCommands.execCommand("lineheight", false, "8pt");
                ed.target.editorCommands.execCommand("foreColor", false, "#1F497D");
            });
        },
        images_upload_handler: function(blobInfo, success, failure, progress) {

            var postUrl = $('.currentUserInfo').attr('data-file-upload-url');

            if (postUrl != undefined && postUrl != '') {

                setTimeout(function() {

                    data = new FormData();

                    data.append("file", blobInfo.blob());

                    var d = $.Deferred();

                    $.ajax({
                        data: data,
                        type: "POST",
                        url: postUrl,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {

                            if (response.success != undefined && response.success == 'true') {

                                if (response.data != undefined && 'url' in response.data) {

                                    success(response.data.url);

                                    // var image = $('<img>').attr('src', response.data.url).addClass("img-fluid");

                                    //$('.textarea_editor_email').attr('data-image-url', response.data.url);

                                    // $('.textarea_editor_email').summernote("insertNode", image[0]);
                                    // $('.textarea_editor_email').summernote("insertImage", response.data.url);
                                    // editor.insertImage(welEditable, response.data.url);
                                    // $('.textarea_editor').summernote('insertImage', response.data.url);
                                    //$('.textarea_editor').summernote('insertImage', response.data.url, response.data.filename);


                                } else {

                                    message = response.message;

                                    flashMessage('error', message);

                                    failure(message);

                                    d.resolve();

                                    return;

                                }

                            } else {

                                message = response.message;

                                flashMessage('error', message);

                                failure(message);

                                d.resolve();

                                return;

                            }
                        }
                    });

                    // var xhr, formData;

                    // xhr = new XMLHttpRequest();
                    // xhr.withCredentials = false;
                    // xhr.open('POST', postUrl);

                    // xhr.upload.onprogress = function (e) {
                    //     progress(e.loaded / e.total * 100);
                    // };

                    // xhr.onload = function() {
                    //     var json;

                    //     if (xhr.status < 200 || xhr.status >= 300) {
                    //         failure('HTTP Error: ' + xhr.status);
                    //         return;
                    //     }

                    //     json = JSON.parse(xhr.responseText);

                    //     if (!json || typeof json.data != 'object' || typeof json.url != 'string') {
                    //         failure('Invalid JSON: ' + xhr.responseText);
                    //         return;
                    //     }

                    //     success(json.url);

                    // };

                    // xhr.onerror = function () {
                    //     failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                    // };

                    // formData = new FormData();
                    // formData.append('file', blobInfo.blob(), blobInfo.filename());

                    // xhr.send(formData);

                }, 2000);

                return;

            }

        },
        // images_upload_handler: function (blobInfo, success, failure) {

        //     console.log(blobInfo);

        //     var postUrl = $('.currentUserInfo').attr('data-file-upload-url');

        //     if (postUrl != undefined && postUrl != '') {

        //         data = new FormData();
        //         data.append("file2", blobInfo.blob());

        //         var d = $.Deferred();

        //         $.ajax({
        //             data: data,
        //             type: "POST",
        //             url: postUrl,
        //             cache: false,
        //             contentType: false,
        //             processData: false,
        //             success: function(response) {

        //                 if (response.success != undefined && response.success == 'true') {

        //                     if (response.data != undefined && 'url' in response.data) {

        //                         success(response.data.url);

        //                         // var image = $('<img>').attr('src', response.data.url).addClass("img-fluid");

        //                         //$('.textarea_editor_email').attr('data-image-url', response.data.url);

        //                         // $('.textarea_editor_email').summernote("insertNode", image[0]);
        //                         // $('.textarea_editor_email').summernote("insertImage", response.data.url);
        //                         // editor.insertImage(welEditable, response.data.url);
        //                         // $('.textarea_editor').summernote('insertImage', response.data.url);
        //                         //$('.textarea_editor').summernote('insertImage', response.data.url, response.data.filename);


        //                     } else {

        //                         message = response.message;

        //                         flashMessage('error', message);

        //                         failure(message);

        //                         d.resolve();

        //                         return;

        //                     }

        //                 } else {

        //                     message = response.message;

        //                     flashMessage('error', message);

        //                     failure(message);

        //                     d.resolve();

        //                     return;

        //                 }
        //             }
        //         });

        //     }

        //     // sendFile(blobInfo.blob());

        //                         // var xhr, formData;

        //             // xhr = new XMLHttpRequest();
        //             // xhr.withCredentials = false;
        //             // xhr.open('POST', postUrl);

        //             // // xhr.upload.onprogress = function (e) {
        //             // //     progress(e.loaded / e.total * 100);
        //             // // };

        //             // xhr.onload = function() {

        //             //     var json;

        //             //     if (xhr.status < 200 || xhr.status >= 300) {

        //             //         failure('HTTP Error: ' + xhr.status);
        //             //         return;

        //             //     }

        //             //     json = JSON.parse(xhr.responseText);

        //             //     if (!json || typeof json.data != 'object' || typeof json.data.url != 'string') {

        //             //         failure('Invalid JSON: ' + xhr.responseText);
        //             //         return;

        //             //     }

        //             //     success(json.data.url);

        //             // };

        //             // xhr.onerror = function () {

        //             //     failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);

        //             // };

        //             // formData = new FormData();

        //             // formData.append('file', blobInfo.blob(), blobInfo.filename());

        //             // xhr.send(formData);

        // },
        // plugins : 'customsetfont',
    });

    tinymce.init({
        selector: '.textarea_editor_signature',
        height: 500,
        menubar: false,
        keep_styles: true,
        browser_spellcheck: true,
        paste_data_images: true,
        plugins: 'advlist anchor autolink bootstrap charmap code codesample colorpicker directionality fullpage fullscreen hr image imagetools insertdatetime lineheight link lists media nonbreaking paste pagebreak print preview searchreplace table template textcolor textpattern visualblocks visualchars wordcount',
        fontsize_formats: '8pt 11pt 10pt 12pt 14pt 18pt 24pt 36pt',
        font_formats: ' Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Calibri=calibri; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats',
        toolbar: 'formatselect | fontselect | fontsizeselect | forecolor | backcolor | lineheightselect | bold italic underline strikethrough superscript subscript | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | link | removeformat | code | help',
        // content_style: "body { font-size: 14pt; font-family: Arial; }",
        setup: function(ed) {
            ed.on('init', function(ed) {
                ed.target.editorCommands.execCommand("fontName", false, "calibri");
                ed.target.editorCommands.execCommand("fontSize", false, "10pt");
                ed.target.editorCommands.execCommand("lineheight", false, "8pt");
                ed.target.editorCommands.execCommand("foreColor", false, "#1F497D");
            });
        },
        images_upload_handler: function(blobInfo, success, failure, progress) {

            var postUrl = $('.currentUserInfo').attr('data-file-upload-url');

            if (postUrl != undefined && postUrl != '') {

                setTimeout(function() {

                    data = new FormData();

                    data.append("file", blobInfo.blob());

                    var d = $.Deferred();

                    $.ajax({
                        data: data,
                        type: "POST",
                        url: postUrl,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {

                            if (response.success != undefined && response.success == 'true') {

                                if (response.data != undefined && 'url' in response.data) {

                                    success(response.data.url);

                                    // var image = $('<img>').attr('src', response.data.url).addClass("img-fluid");

                                    //$('.textarea_editor_email').attr('data-image-url', response.data.url);

                                    // $('.textarea_editor_email').summernote("insertNode", image[0]);
                                    // $('.textarea_editor_email').summernote("insertImage", response.data.url);
                                    // editor.insertImage(welEditable, response.data.url);
                                    // $('.textarea_editor').summernote('insertImage', response.data.url);
                                    //$('.textarea_editor').summernote('insertImage', response.data.url, response.data.filename);


                                } else {

                                    message = response.message;

                                    flashMessage('error', message);

                                    failure(message);

                                    d.resolve();

                                    return;

                                }

                            } else {

                                message = response.message;

                                flashMessage('error', message);

                                failure(message);

                                d.resolve();

                                return;

                            }
                        }
                    });

                    // var xhr, formData;

                    // xhr = new XMLHttpRequest();
                    // xhr.withCredentials = false;
                    // xhr.open('POST', postUrl);

                    // xhr.upload.onprogress = function (e) {
                    //     progress(e.loaded / e.total * 100);
                    // };

                    // xhr.onload = function() {
                    //     var json;

                    //     if (xhr.status < 200 || xhr.status >= 300) {
                    //         failure('HTTP Error: ' + xhr.status);
                    //         return;
                    //     }

                    //     json = JSON.parse(xhr.responseText);

                    //     if (!json || typeof json.data != 'object' || typeof json.url != 'string') {
                    //         failure('Invalid JSON: ' + xhr.responseText);
                    //         return;
                    //     }

                    //     success(json.url);

                    // };

                    // xhr.onerror = function () {
                    //     failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                    // };

                    // formData = new FormData();
                    // formData.append('file', blobInfo.blob(), blobInfo.filename());

                    // xhr.send(formData);

                }, 2000);

                return;

            }

        },
        // images_upload_handler: function (blobInfo, success, failure) {

        //     console.log(blobInfo);

        //     var postUrl = $('.currentUserInfo').attr('data-file-upload-url');

        //     if (postUrl != undefined && postUrl != '') {

        //         data = new FormData();
        //         data.append("file2", blobInfo.blob());

        //         var d = $.Deferred();

        //         $.ajax({
        //             data: data,
        //             type: "POST",
        //             url: postUrl,
        //             cache: false,
        //             contentType: false,
        //             processData: false,
        //             success: function(response) {

        //                 if (response.success != undefined && response.success == 'true') {

        //                     if (response.data != undefined && 'url' in response.data) {

        //                         success(response.data.url);

        //                         // var image = $('<img>').attr('src', response.data.url).addClass("img-fluid");

        //                         //$('.textarea_editor_email').attr('data-image-url', response.data.url);

        //                         // $('.textarea_editor_email').summernote("insertNode", image[0]);
        //                         // $('.textarea_editor_email').summernote("insertImage", response.data.url);
        //                         // editor.insertImage(welEditable, response.data.url);
        //                         // $('.textarea_editor').summernote('insertImage', response.data.url);
        //                         //$('.textarea_editor').summernote('insertImage', response.data.url, response.data.filename);


        //                     } else {

        //                         message = response.message;

        //                         flashMessage('error', message);

        //                         failure(message);

        //                         d.resolve();

        //                         return;

        //                     }

        //                 } else {

        //                     message = response.message;

        //                     flashMessage('error', message);

        //                     failure(message);

        //                     d.resolve();

        //                     return;

        //                 }
        //             }
        //         });

        //     }

        //     // sendFile(blobInfo.blob());

        //                         // var xhr, formData;

        //             // xhr = new XMLHttpRequest();
        //             // xhr.withCredentials = false;
        //             // xhr.open('POST', postUrl);

        //             // // xhr.upload.onprogress = function (e) {
        //             // //     progress(e.loaded / e.total * 100);
        //             // // };

        //             // xhr.onload = function() {

        //             //     var json;

        //             //     if (xhr.status < 200 || xhr.status >= 300) {

        //             //         failure('HTTP Error: ' + xhr.status);
        //             //         return;

        //             //     }

        //             //     json = JSON.parse(xhr.responseText);

        //             //     if (!json || typeof json.data != 'object' || typeof json.data.url != 'string') {

        //             //         failure('Invalid JSON: ' + xhr.responseText);
        //             //         return;

        //             //     }

        //             //     success(json.data.url);

        //             // };

        //             // xhr.onerror = function () {

        //             //     failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);

        //             // };

        //             // formData = new FormData();

        //             // formData.append('file', blobInfo.blob(), blobInfo.filename());

        //             // xhr.send(formData);

        // },
        // plugins : 'customsetfont',
    });

    // $('.textarea_editor_email').summernote({

    //     toolbar: [
    //         // [groupName, [list of button]]
    //         ['style', ['style']],
    //         ['fontname', ['fontname']],
    //         ['fontsize', ['fontsize', 'fontsizeunit']],
    //         ['font', ['bold', 'underline', 'italic']],
    //         ['font', ['strikethrough', 'superscript', 'subscript']],

    //         ['font', ['color']],
    //         ['insert', ['table']], // image and doc are customized buttons
    //         ['height', ['height']],
    //         ['para', ['ol', 'ul', 'paragraph']],
    //         ['insert', ['link']],


    //         // ['insert', ['link', 'image', 'doc', 'video']], // image and doc are customized buttons
    //         //['misc', ['codeview', 'fullscreen']],
    //     ],
    //     fontSizeUnits: ['pt'],
    //     //fontSizes: ['8', '9', '10', '11', '12', '13','14','14.6','15','16', '18', '20', '22', '24' , '26', '28', '30','32','34','36','38','40','42','44'],
    //     fontNames: ['Calibri', 'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana'],
    //     defaultFontName: 'Calibri',
    //     fontsize: '11',
    //     height: 150, //set editable area's height
    //     // blockquoteBreakingLevel: 2,
    //     // codemirror: { // codemirror options
    //     //     theme: 'monokai'
    //     // },
    //     callbacks: {
    //         onImageUpload: function(files, editor, welEditable) {

    //             $('.textarea_editor_email').attr('data-image-url', '');
    //             sendFile(files[0], editor, welEditable);
    //             var $this = $(this);
    //             /*sendFile(files[0], function(url){

    //             	$this.summernote('insertImage', url);

    //             });
    //             */

    //             setTimeout(function() {

    //                 if ($('.textarea_editor_email').attr('data-image-url') != undefined && $('.textarea_editor_email').attr('data-image-url') != '') {

    //                     var image = $('<img>').attr('src', $('.textarea_editor_email').attr('data-image-url')).addClass("img-fluid");

    //                     $this.summernote("insertNode", image[0]);
    //                     //$this.summernote("insertImage", $('.textarea_editor_email').attr('data-image-url'));

    //                 }

    //             }, 2000);


    //             // for (var i = files.length - 1; i >= 0; i--) {
    //             //     sendFile(files[i], this);
    //             // }

    //         },
    //         /*onInit: function() {
    //           //$('.textarea_editor_email').html('');
    //          $('.textarea_editor_email').summernote('code', '<p style="font-family:Calibri !important;font-size:11pt !important;"></p>');
    //           //$('.textarea_editor_email').html('fontSize', '11');
    //         }*/
    //         /*onFocus: function() {
    //           $('.textarea_editor_email').summernote('fontSizeUnit', 'pt');
    //           $('.textarea_editor_email').summernote('fontSize', '11');
    //         }
    //         onKeydown: function() {
    //           $('.textarea_editor_email').summernote('fontSizeUnit', 'pt');
    //           $('.textarea_editor_email').summernote('fontSize', '11');

    //         }*/


    //     }
    //     /*}).on("summernote.init", function(we, e) {

    // 	//if($(this).summernote("isEmpty")) {

    // 		$(this).summernote("pasteHTML", '<p style="font-family:Calibri; font-size:11pt;margin:0px;"><br></p>');

    // 	//}
    // */
    // }).on("summernote.enter", function(we, e) {
    //     //$(this).summernote("pasteHTML", '<p style="font-family:Calibri; font-size:11pt;margin:0px;"><br></p>');

    //     var browserName = findBrowser();

    //     $(this).summernote("pasteHTML", '<p class="MsoNormal"style="font-family:Calibri;font-size:11pt;color:#1F497D;margin:0px;"><br></p>');

    //     if (browserName == 'Firefox') {

    //         $(this).summernote("pasteHTML", '<p class="MsoNormal" style="font-family:Calibri; font-size:11pt;color:#1F497D;margin:0px;"></p>');

    //     }
    //     e.preventDefault();
    // });


    //$('.textarea_editor_email').summernote('fontSizeUnit', 'pt');
    //$('.textarea_editor_email').summernote('fontSize', '11');
    //$('.textarea_editor_email').css('font-size', '11pt');

    // $('.email-reply-form .note-editable').css('font-size', '11pt');
    // //$('.email-reply-form .note-editable').css('color', '#337ab7');
    // $('.email-reply-form .note-editable').css('font-family', 'Calibri');
    // $('.email-reply-form .note-editable').css('line-height', 1);

    // $('.email-send-form .note-editable').css('font-size', '11pt');
    // //$('.email-send-form .note-editable').css('color', '#337ab7');
    // $('.email-send-form .note-editable').css('font-family', 'Calibri');
    // $('.email-send-form .note-editable').css('line-height', 1);



    // $('.textarea_editor_signature').summernote({

    //     toolbar: [
    //         // [groupName, [list of button]]
    //         ['style', ['style']],
    //         ['fontname', ['fontname']],
    //         ['fontsize', ['fontsize', 'fontsizeunit']],
    //         ['font', ['bold', 'underline', 'italic']],
    //         ['font', ['strikethrough', 'superscript', 'subscript']],

    //         ['font', ['color']],
    //         ['insert', ['table']], // image and doc are customized buttons
    //         ['height', ['height']],
    //         ['para', ['ol', 'ul', 'paragraph']],
    //         ['insert', ['link']],


    //         // ['insert', ['link', 'image', 'doc', 'video']], // image and doc are customized buttons
    //         //['misc', ['codeview', 'fullscreen']],
    //     ],
    //     fontSizeUnits: ['pt'],
    //     //fontSizes: ['8', '9', '10', '11', '12', '13','14','14.6','15','16', '18', '20', '22', '24' , '26', '28', '30','32','34','36','38','40','42','44'],
    //     fontNames: ['Calibri', 'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana'],
    //     defaultFontName: 'Arial',
    //     fontsize: '11',
    //     height: 150, //set editable area's height
    //     // blockquoteBreakingLevel: 2,
    //     // codemirror: { // codemirror options
    //     //     theme: 'monokai'
    //     // },
    //     callbacks: {
    //         onImageUpload: function(files, editor, welEditable) {

    //             $('.textarea_editor_signature').attr('data-image-url', '');
    //             sendFile(files[0], editor, welEditable);
    //             var $this = $(this);
    //             /*sendFile(files[0], function(url){

    //             	$this.summernote('insertImage', url);

    //             });
    //             */

    //             setTimeout(function() {

    //                 if ($('.textarea_editor_signature').attr('data-image-url') != undefined && $('.textarea_editor_signature').attr('data-image-url') != '') {

    //                     var image = $('<img>').attr('src', $('.textarea_editor_signature').attr('data-image-url')).addClass("img-fluid");

    //                     $this.summernote("insertNode", image[0]);
    //                     //$this.summernote("insertImage", $('.textarea_editor_signature').attr('data-image-url'));

    //                 }

    //             }, 2000);


    //             // for (var i = files.length - 1; i >= 0; i--) {
    //             //     sendFile(files[i], this);
    //             // }

    //         },

    //     }
    //     /* }).on("summernote.init", function(we, e) {

    // 	if($(this).summernote("isEmpty")) {

    // 		$(this).summernote('code', '');

    // 	}
    // */
    // }).on("summernote.enter", function(we, e) {

    //     var browserName = findBrowser();

    //     $(this).summernote("pasteHTML", '<p class="MsoNormal" style="font-family:Arial; font-size:11pt;color:#1F497D;margin:0px;"><br></p>');

    //     if (browserName == 'Firefox') {

    //         $(this).summernote("pasteHTML", '<p class="MsoNormal" style="font-family:Arial; font-size:11pt;color:#1F497D;margin:0px;"></p>');

    //     }
    //     e.preventDefault();
    // });

    // $('.signature-form .note-editable').css('font-size', '11pt');
    // $('.signature-form .note-editable').css('font-family', 'Arial');
    // $('.signature-form .note-editable').css('line-height', 1);

    //function sendFile(file, editor, welEditable) {
    function sendFile(file) {

        var postUrl = $('.currentUserInfo').attr('data-file-upload-url');

        if (postUrl != undefined && postUrl != '') {

            data = new FormData();
            data.append("file", file);

            var d = $.Deferred();

            $.ajax({
                data: data,
                type: "POST",
                url: postUrl,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.success != undefined && response.success == 'true') {

                        if (response.data != undefined && 'url' in response.data) {

                            // var image = $('<img>').attr('src', response.data.url).addClass("img-fluid");

                            $('.textarea_editor_email').attr('data-image-url', response.data.url);

                            // $('.textarea_editor_email').summernote("insertNode", image[0]);
                            // $('.textarea_editor_email').summernote("insertImage", response.data.url);
                            // editor.insertImage(welEditable, response.data.url);
                            // $('.textarea_editor').summernote('insertImage', response.data.url);
                            //$('.textarea_editor').summernote('insertImage', response.data.url, response.data.filename);


                        }

                    } else {

                        message = response.message;

                        flashMessage('error', message);

                        d.resolve();

                    }
                }
            });

        }

    }

    function findBrowser() {
        var navUserAgent = navigator.userAgent;
        var browserName = navigator.appName;
        var browserVersion = '' + parseFloat(navigator.appVersion);
        var majorVersion = parseInt(navigator.appVersion, 10);
        var tempNameOffset, tempVersionOffset, tempVersion;


        if ((tempVersionOffset = navUserAgent.indexOf("Opera")) != -1) {
            browserName = "Opera";
            browserVersion = navUserAgent.substring(tempVersionOffset + 6);
            if ((tempVersionOffset = navUserAgent.indexOf("Version")) != -1)
                browserVersion = navUserAgent.substring(tempVersionOffset + 8);
        } else if ((tempVersionOffset = navUserAgent.indexOf("MSIE")) != -1) {
            browserName = "Microsoft Internet Explorer";
            browserVersion = navUserAgent.substring(tempVersionOffset + 5);
        } else if ((tempVersionOffset = navUserAgent.indexOf("Chrome")) != -1) {
            browserName = "Chrome";
            browserVersion = navUserAgent.substring(tempVersionOffset + 7);
        } else if ((tempVersionOffset = navUserAgent.indexOf("Safari")) != -1) {
            browserName = "Safari";
            browserVersion = navUserAgent.substring(tempVersionOffset + 7);
            if ((tempVersionOffset = navUserAgent.indexOf("Version")) != -1)
                browserVersion = navUserAgent.substring(tempVersionOffset + 8);
        } else if ((tempVersionOffset = navUserAgent.indexOf("Firefox")) != -1) {
            browserName = "Firefox";
            browserVersion = navUserAgent.substring(tempVersionOffset + 8);
        } else if ((tempNameOffset = navUserAgent.lastIndexOf(' ') + 1) < (tempVersionOffset = navUserAgent.lastIndexOf('/'))) {
            browserName = navUserAgent.substring(tempNameOffset, tempVersionOffset);
            browserVersion = navUserAgent.substring(tempVersionOffset + 1);
            if (browserName.toLowerCase() == browserName.toUpperCase()) {
                browserName = navigator.appName;
            }
        }

        // trim version
        if ((tempVersion = browserVersion.indexOf(";")) != -1)
            browserVersion = browserVersion.substring(0, tempVersion);
        if ((tempVersion = browserVersion.indexOf(" ")) != -1)
            browserVersion = browserVersion.substring(0, tempVersion);

        return browserName;
    }

    // $('.textarea_editor').on('summernote.image.upload', function(we, files) {
    //     console.log("dfdf");
    // });

});

/*
$(document).ready(function() {
    // $('.textarea_editor').summernote({
    //     onImageUpload: function(files, editor, welEditable) {
    //         sendFile(files[0], editor, welEditable);
    //     }
    // });

    $('.textarea_editor_signature').summernote({

		toolbar: [
            // [groupName, [list of button]]
            ['style', ['style']],
			['fontname', ['fontname']],
			['fontsize', ['fontsize','fontsizeunit']],
            ['font', ['bold', 'underline']],
			['font', ['strikethrough', 'superscript', 'subscript']],
            ['font', ['color']],
            ['insert', ['table']], // image and doc are customized buttons
            ['height', ['height']],
            ['para', ['ol', 'ul', 'paragraph']],
            ['insert', ['link','picture']],


            // ['insert', ['link', 'image', 'doc', 'video']], // image and doc are customized buttons
            // ['misc', ['codeview', 'fullscreen']],
        ],
		fontSizeUnits: ['pt'],
		//fontSizes: ['8', '9', '10', '11', '12', '13','14','14.6','15','16', '18', '20', '22', '24' , '26', '28', '30','32','34','36','38','40','42','44'],
		fontNames: ['Arial','Calibri', 'Arial Black', 'Comic Sans MS', 'Courier New','Helvetica','Impact','Tahoma','Times New Roman','Verdana'],
		defaultFontName:'Arial',
		fontsize:'11',

        height: 150, //set editable area's height
        // blockquoteBreakingLevel: 2,
        // codemirror: { // codemirror options
        //     theme: 'monokai'
        // },
        callbacks: {
            onImageUpload: function(files, editor, welEditable) {

                sendFile(files[0], editor, welEditable);

                // for (var i = files.length - 1; i >= 0; i--) {
                //     sendFile(files[i], this);
                // }

            },

        }
    }).on("summernote.enter", function(we, e) {
        $(this).summernote("pasteHTML", '<p style="font-family:Arial; font-size:11pt;margin:0px;"><br></p>');
        e.preventDefault();
    });


	//$('.textarea_editor_email').summernote('fontSizeUnit', 'pt');
	//$('.textarea_editor_email').summernote('fontSize', '11');
	//$('.textarea_editor_email').css('font-size', '11pt');

	$('.note-editable').css('font-size', '11pt');
	$('.note-editable').css('font-family', 'Arial');
	$('.note-editable').css("line-height", 1);

    function sendFile(file, editor, welEditable) {

        var postUrl = $('.currentUserInfo').attr('data-file-upload-url');

        if (postUrl != undefined && postUrl != '') {

            data = new FormData();
            data.append("file", file);

            var d = $.Deferred();

            $.ajax({
                data: data,
                type: "POST",
                url: postUrl,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {

                    if (response.success != undefined && response.success == 'true') {

                        if (response.data != undefined && 'url' in response.data) {

                            var image = $('<img>').attr('src', response.data.url).addClass("img-fluid");
                            $('.textarea_editor_email').summernote("insertNode", image[0]);
                            // editor.insertImage(welEditable, response.data.url);
                            // $('.textarea_editor').summernote('insertImage', response.data.url);
                            // $('.textarea_editor').summernote('insertImage', response.data.url, response.data.filename);


                        }

                    } else {

                        message = response.message;

                        flashMessage('error', message);

                        d.resolve();

                    }
                }
            });

        }

    }

    // $('.textarea_editor').on('summernote.image.upload', function(we, files) {
    //     console.log("dfdf");
    // });

});

*/
