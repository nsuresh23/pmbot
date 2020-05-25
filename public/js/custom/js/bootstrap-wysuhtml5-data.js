/*Bootstrap wysihtml5 Init*/

$(document).ready(function() {
    "use strict";

    $('.textarea_editor1').wysihtml5({
        toolbar: {
            //   fa: true,
            //   "link": true,
            // "font-styles": true, // Font styling, e.g. h1, h2, etc.
            // "emphasis": true, // Italics, bold, etc.
            // "lists": true, // (Un)ordered lists, e.g. Bullets, Numbers.
            // "html": false, // Button which allows you to edit the generated HTML.
            "link": false, // Button to insert a link.
            "image": false, // Button to insert an image.
            // "color": false, // Button to change color of font
            // "blockquote": true, // Blockquote
            // "size": <buttonsize> // options are xs, sm, lg
        }
    });

    $('.textarea_view_editor').wysihtml5({
        toolbar: {
            //   fa: true,
            "font-styles": false, // Font styling, e.g. h1, h2, etc.
            "emphasis": false, // Italics, bold, etc.
            "lists": false, // (Un)ordered lists, e.g. Bullets, Numbers.
            "html": false, // Button which allows you to edit the generated HTML.
            "link": false, // Button to insert a link.
            "image": false, // Button to insert an image.
            "color": false, // Button to change color of font
            "blockquote": false, // Blockquote
        },
        "events": {
            "load": function() {
                var $body = $(this.composer.element);
                $body.removeAttr('contenteditable');
            }
        }
    });

});