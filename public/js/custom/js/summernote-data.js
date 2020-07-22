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

    // $('.textarea_editor_email').summernote({
    $('.textarea_editor_email').summernote({
		toolbar: [
            // [groupName, [list of button]]
            ['style', ['style']],
			['fontsize', ['fontsize']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['fontname','fontsizeunit']],
            ['font', ['color']],
            ['insert', ['table']], // image and doc are customized buttons
            ['height', ['height']],
            ['para', ['ol', 'ul', 'paragraph']],
            ['insert', ['link']],
			
            // ['insert', ['link', 'image', 'doc', 'video']], // image and doc are customized buttons
            // ['misc', ['codeview', 'fullscreen']],
        ],  
		fontSizeUnits: ['pt'],
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

            }
        }
    });

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