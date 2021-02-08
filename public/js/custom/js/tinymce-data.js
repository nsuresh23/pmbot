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

    function emailViewEditor(selector) {

        tinymce.init({
            selector: selector,
            height: 500,
            menubar: false,
            toolbar: false,
            statusbar: false,
            readonly: 1,
            keep_styles: true,
            browser_spellcheck: true,
            paste_data_images: true,
            relative_urls: false,
            remove_script_host: false,
            convert_urls: false,
            protect: [
                /\<\!\[(if !supportLists|endif)\]\>/g, // Protect <![if !supportLists]> & <![endif]>
                /\&lt;\!\[(if !supportLists|endif)\]\&gt;/g, // Protect &lt;![if !supportLists]&gt; & &lt;![endif]&gt;
            ],
            valid_children: '+body[style]',
            plugins: 'advlist anchor autolink charmap code codesample colorpicker directionality fullscreen hr image imagetools insertdatetime link lists media nonbreaking pagebreak powerpaste print preview searchreplace table template textcolor textpattern visualblocks visualchars wordcount',
            fontsize_formats: '8pt 9pt 10pt 11pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 19pt 20pt 21pt 22pt 23pt 24pt 25pt 26pt 27pt 28pt 29pt 30pt 31pt 32pt 33pt 34pt 35pt 36pt',
            font_formats: ' Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Calibri=calibri; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats',
        });

    }

    emailViewEditor('#email-body');
    emailViewEditor('#qc-email-body');
    emailViewEditor('#sent-email-body');

    emailEditorInitialize('#textarea_editor_email_compose');
    emailEditorInitialize('#textarea_editor_email_draft');
    emailEditorInitialize('#textarea_editor_email_reply');

    signatureEditorInitialize('#textarea_editor_email_new_signature');
    signatureEditorInitialize('#textarea_editor_email_replyforward_signature');

    function emailEditorInitialize(selector) {

        var tinymceStyle = '<style>html { height: 100%; cursor: text } body { background-color: #FFFFFF; font-size: 11.0pt; font-family: Calibri; color: #1f497d; scrollbar-3dlight-color: #F0F0EE; scrollbar-arrow-color: #676662; scrollbar-base-color: #F0F0EE; scrollbar-darkshadow-color: #DDDDDD; scrollbar-face-color: #E0E0DD; scrollbar-highlight-color: #F0F0EE; scrollbar-shadow-color: #F0F0EE; scrollbar-track-color: #F5F5F5 } p { margin: 0in; margin-bottom: .0001pt; } td, th { font-size: 11.0pt; font-family: Calibri; } .mce-content-body .mce-reset { margin: 0; padding: 0; border: 0; outline: 0; vertical-align: top; background: transparent; text-decoration: none; font-size: 11.0pt; font-family: Calibri; color: #1f497d; text-shadow: none; float: none; position: static; width: auto; height: auto; white-space: nowrap; cursor: inherit; /* line-height: normal; */ line-height: 6pt; font-weight: normal; text-align: left; -webkit-tap-highlight-color: transparent; -moz-box-sizing: content-box; -webkit-box-sizing: content-box; box-sizing: content-box; direction: ltr; max-width: none } .mce-object { border: 1px dotted #3A3A3A; background: #D5D5D5 url(img/object.gif) no-repeat center } .mce-preview-object { display: inline-block; position: relative; margin: 0 2px 0 2px; line-height: 0; border: 1px solid gray } .mce-preview-object[data-mce-selected="2"] .mce-shim { display: none } .mce-preview-object .mce-shim { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: url(data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7) } figure.align-left { float: left } figure.align-right { float: right } figure.image.align-center { display: table; margin-left: auto; margin-right: auto } figure.image { display: inline-block; border: 1px solid gray; margin: 0 2px 0 1px; background: #f5f2f0 } figure.image img { margin: 8px 8px 0 8px } figure.image figcaption { margin: 6px 8px 6px 8px; text-align: center } .mce-toc { border: 1px solid gray } .mce-toc h2 { margin: 4px } .mce-toc li { list-style-type: none } .mce-pagebreak { cursor: default; display: block; border: 0; width: 100%; height: 5px; border: 1px dashed #666; margin-top: 15px; page-break-before: always } @media print { .mce-pagebreak { border: 0 } } .mce-item-anchor { cursor: default; display: inline-block; -webkit-user-select: all; -webkit-user-modify: read-only; -moz-user-select: all; -moz-user-modify: read-only; user-select: all; user-modify: read-only; width: 9px !important; height: 9px !important; border: 1px dotted #3A3A3A; background: #D5D5D5 url(img/anchor.gif) no-repeat center } .mce-nbsp, .mce-shy { background: #AAA } .mce-shy::after { content: "-" } hr { cursor: default } .mce-match-marker { background: #AAA; color: #fff } .mce-match-marker-selected { background: #3399ff; color: #fff } .mce-spellchecker-word { border-bottom: 2px solid #F00; cursor: default } .mce-spellchecker-grammar { border-bottom: 2px solid #008000; cursor: default } .mce-item-table, .mce-item-table td, .mce-item-table th, .mce-item-table caption { border: 1px solid grey; border-spacing: 0px; } table, table td, table th, table caption { border: 1px solid grey; border-spacing: 0px; } td[data-mce-selected], th[data-mce-selected] { background-color: #3399ff !important } .mce-edit-focus { outline: 1px dotted #333 } .mce-content-body *[contentEditable=false] *[contentEditable=true]:focus { outline: 2px solid #2d8ac7 } .mce-content-body *[contentEditable=false] *[contentEditable=true]:hover { outline: 2px solid #7ACAFF } .mce-content-body *[contentEditable=false][data-mce-selected] { outline: 2px solid #2d8ac7 } .mce-resize-bar-dragging { background-color: blue; opacity: .25; filter: alpha(opacity=25); zoom: 1 }</style>';

        tinymce.init({
            selector: selector,
            height: 500,
            menubar: false,
            keep_styles: true,
            browser_spellcheck: true,
            paste_data_images: true,
            relative_urls: false,
            remove_script_host: false,
            convert_urls: false,
            protect: [
                /\<\!\[(if !supportLists|endif)\]\>/g, // Protect <![if !supportLists]> & <![endif]>
                /\&lt;\!\[(if !supportLists|endif)\]\&gt;/g, // Protect &lt;![if !supportLists]&gt; & &lt;![endif]&gt;
            ],
            valid_children: '+body[style]',
            plugins: 'advlist anchor autolink charmap code codesample colorpicker directionality fullscreen hr image imagetools insertdatetime link lists media nonbreaking pagebreak powerpaste print preview searchreplace table template textcolor textpattern visualblocks visualchars wordcount',
            fontsize_formats: '8pt 9pt 10pt 11pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 19pt 20pt 21pt 22pt 23pt 24pt 25pt 26pt 27pt 28pt 29pt 30pt 31pt 32pt 33pt 34pt 35pt 36pt',
            font_formats: ' Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Calibri=calibri; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats',
            // toolbar: 'formatselect | fontselect | fontsizeselect | forecolor | backcolor | bold italic underline strikethrough superscript subscript | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | link | removeformat | code | help',
            toolbar: 'formatselect | fontselect | fontsizeselect | forecolor | backcolor | bold italic underline strikethrough superscript subscript | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | link',

            // content_style: 'html { height: 100%; cursor: text } body { background-color: #FFFFFF; font-size: 11.0pt; font-family: Calibri; color: #1f497d; scrollbar-3dlight-color: #F0F0EE; scrollbar-arrow-color: #676662; scrollbar-base-color: #F0F0EE; scrollbar-darkshadow-color: #DDDDDD; scrollbar-face-color: #E0E0DD; scrollbar-highlight-color: #F0F0EE; scrollbar-shadow-color: #F0F0EE; scrollbar-track-color: #F5F5F5 } p { margin: 0in; margin-bottom: .0001pt; } td, th { font-size: 11.0pt; font-family: Calibri; } .mce-content-body .mce-reset { margin: 0; padding: 0; border: 0; outline: 0; vertical-align: top; background: transparent; text-decoration: none; font-size: 11.0pt; font-family: Calibri; color: #1f497d; text-shadow: none; float: none; position: static; width: auto; height: auto; white-space: nowrap; cursor: inherit; /* line-height: normal; */ line-height: 6pt; font-weight: normal; text-align: left; -webkit-tap-highlight-color: transparent; -moz-box-sizing: content-box; -webkit-box-sizing: content-box; box-sizing: content-box; direction: ltr; max-width: none } .mce-object { border: 1px dotted #3A3A3A; background: #D5D5D5 url(img/object.gif) no-repeat center } .mce-preview-object { display: inline-block; position: relative; margin: 0 2px 0 2px; line-height: 0; border: 1px solid gray } .mce-preview-object[data-mce-selected="2"] .mce-shim { display: none } .mce-preview-object .mce-shim { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: url(data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7) } figure.align-left { float: left } figure.align-right { float: right } figure.image.align-center { display: table; margin-left: auto; margin-right: auto } figure.image { display: inline-block; border: 1px solid gray; margin: 0 2px 0 1px; background: #f5f2f0 } figure.image img { margin: 8px 8px 0 8px } figure.image figcaption { margin: 6px 8px 6px 8px; text-align: center } .mce-toc { border: 1px solid gray } .mce-toc h2 { margin: 4px } .mce-toc li { list-style-type: none } .mce-pagebreak { cursor: default; display: block; border: 0; width: 100%; height: 5px; border: 1px dashed #666; margin-top: 15px; page-break-before: always } @media print { .mce-pagebreak { border: 0 } } .mce-item-anchor { cursor: default; display: inline-block; -webkit-user-select: all; -webkit-user-modify: read-only; -moz-user-select: all; -moz-user-modify: read-only; user-select: all; user-modify: read-only; width: 9px !important; height: 9px !important; border: 1px dotted #3A3A3A; background: #D5D5D5 url(img/anchor.gif) no-repeat center } .mce-nbsp, .mce-shy { background: #AAA } .mce-shy::after { content: ' - ' } hr { cursor: default } .mce-match-marker { background: #AAA; color: #fff } .mce-match-marker-selected { background: #3399ff; color: #fff } .mce-spellchecker-word { border-bottom: 2px solid #F00; cursor: default } .mce-spellchecker-grammar { border-bottom: 2px solid #008000; cursor: default } .mce-item-table, .mce-item-table td, .mce-item-table th, .mce-item-table caption { border: 1px solid grey; border-spacing: 0px; } td[data-mce-selected], th[data-mce-selected] { background-color: #3399ff !important } .mce-edit-focus { outline: 1px dotted #333 } .mce-content-body *[contentEditable=false] *[contentEditable=true]:focus { outline: 2px solid #2d8ac7 } .mce-content-body *[contentEditable=false] *[contentEditable=true]:hover { outline: 2px solid #7ACAFF } .mce-content-body *[contentEditable=false][data-mce-selected] { outline: 2px solid #2d8ac7 } .mce-resize-bar-dragging { background-color: blue; opacity: .25; filter: alpha(opacity=25); zoom: 1 }',

            // content_style: "body { font-size: 14pt; font-family: Arial; }",
            // content_style: "p { font-size: 11pt; font-family: Calibri; color: #1f497d; line-height: 8pt;}",
            // formats: {
            //     p: { block: 'p', styles: { 'margin': '0in', 'margin-bottom': '.0001pt', 'font-size': '11.0pt', 'font-family': 'Calibri', 'color': '#1F497D' } }
            // },
            setup: function(ed) {
                ed.on('PostProcess', function(o) {
                    // tinymce.activeEditor.dom.setStyles(tinymce.activeEditor.dom.select('table'), { 'border': '1px solid grey', 'border-spacing': '0px' });
                    // tinymce.activeEditor.dom.setStyles(tinymce.activeEditor.dom.select('table td'), { 'border': '1px solid grey', 'border-spacing': '0px' });
                    // tinymce.activeEditor.dom.setStyles(tinymce.activeEditor.dom.select('table th'), { 'border': '1px solid grey', 'border-spacing': '0px' });
                    // tinymce.activeEditor.dom.setStyles(tinymce.activeEditor.dom.select('table caption'), { 'border': '1px solid grey', 'border-spacing': '0px' });
                    // o.content = tinymceStyle + o.content;
                });
                ed.on('keyup', function(evt) {
                    if (evt.keyCode == 32) {
                        ed.undoManager.add();
                        ed.execCommand('mceSave');
                    }
                });
                // ed.on('init', function(ed) {
                //     ed.target.editorCommands.execCommand("fontName", false, "calibri");
                //     ed.target.editorCommands.execCommand("fontSize", false, "11pt");
                //     ed.target.editorCommands.execCommand("lineheight", false, "8pt");
                //     ed.target.editorCommands.execCommand("foreColor", false, "#1F497D");
                // });
                // ed.on('init', function() {
                //     this.getDoc().body.style.fontSize = "11pt";
                //     this.getDoc().body.style.fontFamily = 'calibri';
                //     this.getDoc().body.style.color = '#1F497D';
                // });
            },

            // init_instance_callback: function (editor) {
            //     //On Paste: remove the dash from the beginning of li elements.
            //     editor.on('PastePreProcess', function (e) {
            //         e.content = e.content.replace(/<li>- /g, "<li>")
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
            convert_urls: false,
            inline_styles: true,
            protect: [
                /\<\!\[(if !supportLists|endif)\]\>/g, // Protect <![if !supportLists]> & <![endif]>
                /\&lt;\!\[(if !supportLists|endif)\]\&gt;/g, // Protect &lt;![if !supportLists]&gt; & &lt;![endif]&gt;
            ],
            valid_children: '+body[style]',
            plugins: 'advlist anchor autolink charmap code codesample colorpicker directionality fullscreen hr image imagetools insertdatetime link lists media nonbreaking paste pagebreak print preview searchreplace table template textcolor textpattern visualblocks visualchars wordcount',
            fontsize_formats: '8pt 9pt 10pt 11pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 19pt 20pt 21pt 22pt 23pt 24pt 25pt 26pt 27pt 28pt 29pt 30pt 31pt 32pt 33pt 34pt 35pt 36pt',
            font_formats: ' Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Calibri=calibri; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats',
            toolbar: 'formatselect | fontselect | fontsizeselect | forecolor | backcolor | bold italic underline strikethrough superscript subscript | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | link',

            setup: function(ed) {
                ed.on('keyup', function(evt) {
                    if (evt.keyCode == 32) {
                        ed.undoManager.add();
                        ed.execCommand('mceSave');
                    }
                });
            },

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

    $(document).on('focusin', function(e) {
        if ($(e.target).closest(".mce-window").length) {
            e.stopImmediatePropagation();
        }
    });

});