/*Summernote Init*/

$(function() {
    "use strict";
    $('.summernote').summernote({
        height: 300,
    });

    $('.textarea_editor').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['fontname']],
            ['font', ['fontsize', 'color']],
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

});