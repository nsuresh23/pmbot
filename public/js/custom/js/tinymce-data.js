/*Tinymce Init*/

$(function() {
    "use strict";

    tinymce.init({
        selector: '.tinymce',
        height: 300,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code'
        ],
        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',

    });

    emailEditorInitialize('#textarea_editor_email_compose');
    emailEditorInitialize('#textarea_editor_email_draft');
    emailEditorInitialize('#textarea_editor_email_reply');

    signatureEditorInitialize('#textarea_editor_email_new_signature');
    signatureEditorInitialize('#textarea_editor_email_replyforward_signature');

    function emailEditorInitialize(selector) {

        tinymce.init({
            selector: selector,
            height: 500,
            menubar: false,
            keep_styles: true,
            browser_spellcheck: true,
            paste_data_images: true,
            relative_urls: false,
            remove_script_host: false,
            valid_children: '+body[style]',
            plugins: 'advlist anchor autolink charmap code codesample colorpicker directionality fullscreen hr image imagetools insertdatetime link lists media nonbreaking pagebreak powerpaste print preview searchreplace table template textcolor textpattern visualblocks visualchars wordcount',
            fontsize_formats: '8pt 9pt 10pt 11pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 19pt 20pt 21pt 22pt 23pt 24pt 25pt 26pt 27pt 28pt 29pt 30pt 31pt 32pt 33pt 34pt 35pt 36pt',
            font_formats: ' Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Calibri=calibri; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats',
            // toolbar: 'formatselect | fontselect | fontsizeselect | forecolor | backcolor | bold italic underline strikethrough superscript subscript | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | link | removeformat | code | help',
            toolbar: 'formatselect | fontselect | fontsizeselect | forecolor | backcolor | bold italic underline strikethrough superscript subscript | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | link',
            // content_style: "body { font-size: 14pt; font-family: Arial; }",
            // content_style: "p { font-size: 11pt; font-family: Calibri; color: #1f497d; line-height: 8pt;}",
            // formats: {
            //     p: { block: 'p', styles: { 'margin': '0in', 'margin-bottom': '.0001pt', 'font-size': '11.0pt', 'font-family': 'Calibri', 'color': '#1F497D' } }
            // },
            // setup: function(ed) {
            //     ed.on('init', function(ed) {
            //         ed.target.editorCommands.execCommand("fontName", false, "calibri");
            //         ed.target.editorCommands.execCommand("fontSize", false, "11pt");
            //         ed.target.editorCommands.execCommand("lineheight", false, "8pt");
            //         ed.target.editorCommands.execCommand("foreColor", false, "#1F497D");
            //     });
            // },

            images_upload_handler: function(blobInfo, success, failure, progress) {

                var postUrl = $('.currentUserInfo').attr('data-file-upload-url');

                if (postUrl != undefined && postUrl != '') {

                    tinymce.triggerSave(true, true);

                    var xhr, formData;

                    xhr = new XMLHttpRequest();
                    xhr.withCredentials = true;
                    xhr.open('POST', postUrl);

                    xhr.upload.onprogress = function(e) {
                        progress(e.loaded / e.total * 100);
                    };

                    xhr.onload = function() {
                        var json;

                        if (xhr.status < 200 || xhr.status >= 300) {
                            failure('HTTP Error: ' + xhr.status);
                            return;
                        }

                        json = JSON.parse(xhr.responseText);

                        if (!json || typeof json.data != 'object' || typeof json.data.url != 'string') {
                            failure('Invalid JSON: ' + xhr.responseText);
                            return;
                        }

                        success(json.data.url);
                    };

                    xhr.onerror = function() {
                        failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                    };

                    var metas = document.getElementsByTagName('meta');

                    for (var i = 0; i < metas.length; i++) {
                        if (metas[i].getAttribute("name") == "csrf-token") {
                            xhr.setRequestHeader("X-CSRF-Token", metas[i].getAttribute("content"));
                        }
                    }

                    formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    xhr.send(formData);

                } else {

                    flashMessage('error', "Upload url not valid");

                    return;

                }
            },

            // images_upload_handler: function(blobInfo, success, failure, progress) {

            //     // tinymce.triggerSave(true, true);

            //     var postUrl = $('.currentUserInfo').attr('data-file-upload-url');

            //     if (postUrl != undefined && postUrl != '') {

            //         setTimeout(function() {

            //             var data = new FormData();

            //             data.append("file", blobInfo.blob());

            //             // var data = {};

            //             // data.file = blobInfo.blob();

            //             var d = $.Deferred();

            //             $.ajax({
            //                 data: data,
            //                 type: "POST",
            //                 url: postUrl,
            //                 cache: false,
            //                 contentType: false,
            //                 processData: false,
            //                 success: function(response) {

            //                     if (response.success != undefined && response.success == 'true') {

            //                         if (response.data != undefined && 'url' in response.data) {

            //                             success(response.data.url);

            //                         } else {

            //                             message = response.message;

            //                             flashMessage('error', message);

            //                             failure(message);

            //                             d.resolve();

            //                             return;

            //                         }

            //                     } else {

            //                         message = response.message;

            //                         flashMessage('error', message);

            //                         failure(message);

            //                         d.resolve();

            //                         return;

            //                     }
            //                 }
            //             });

            //         }, 2000);

            //         return;

            //     }

            // },
        });

    }

    function signatureEditorInitialize(selector) {

        tinymce.init({
            selector: selector,
            height: 500,
            menubar: true,
            keep_styles: true,
            browser_spellcheck: true,
            paste_data_images: true,
            relative_urls: false,
            remove_script_host: false,
            inline_styles: true,
            valid_children: '+body[style]',
            plugins: 'advlist anchor autolink charmap code codesample colorpicker directionality fullscreen hr image imagetools insertdatetime link lists media nonbreaking paste pagebreak print preview searchreplace table template textcolor textpattern visualblocks visualchars wordcount',
            fontsize_formats: '8pt 9pt 10pt 11pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 19pt 20pt 21pt 22pt 23pt 24pt 25pt 26pt 27pt 28pt 29pt 30pt 31pt 32pt 33pt 34pt 35pt 36pt',
            font_formats: ' Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Calibri=calibri; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats',
            toolbar: 'formatselect | fontselect | fontsizeselect | forecolor | backcolor | bold italic underline strikethrough superscript subscript | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | link',

            images_upload_handler: function(blobInfo, success, failure, progress) {

                var postUrl = $('.currentUserInfo').attr('data-file-upload-url');

                if (postUrl != undefined && postUrl != '') {

                    tinymce.triggerSave(true, true);

                    var xhr, formData;

                    xhr = new XMLHttpRequest();
                    xhr.withCredentials = true;
                    xhr.open('POST', postUrl);

                    xhr.upload.onprogress = function(e) {
                        progress(e.loaded / e.total * 100);
                    };

                    xhr.onload = function() {
                        var json;

                        if (xhr.status < 200 || xhr.status >= 300) {
                            failure('HTTP Error: ' + xhr.status);
                            return;
                        }

                        json = JSON.parse(xhr.responseText);

                        if (!json || typeof json.data != 'object' || typeof json.data.url != 'string') {
                            failure('Invalid JSON: ' + xhr.responseText);
                            return;
                        }

                        success(json.data.url);
                    };

                    xhr.onerror = function() {
                        failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                    };

                    var metas = document.getElementsByTagName('meta');

                    for (var i = 0; i < metas.length; i++) {
                        if (metas[i].getAttribute("name") == "csrf-token") {
                            xhr.setRequestHeader("X-CSRF-Token", metas[i].getAttribute("content"));
                        }
                    }

                    formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    xhr.send(formData);

                } else {

                    flashMessage('error', "Upload url not valid");

                    return;

                }
            },
        });

    }

});