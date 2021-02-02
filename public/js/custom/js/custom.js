function flashMessage(type, message) {

    var headingVariable = 'Success';
    var loaderBgVariable = '#fec107';
    var iconVariable = 'success';
    var textVariable = message;

    if (type == "error") {

        headingVariable = 'Error';
        iconVariable = 'error';

    }

    $.toast().reset('all');
    $("body").removeAttr('class');
    $.toast({
        heading: headingVariable,
        text: textVariable,
        position: 'top-right',
        loaderBg: loaderBgVariable,
        icon: iconVariable,
        hideAfter: 3500,
        stack: 6
    });
    return false;

}

function fieldMessage(field, message) {

    var headingVariable = 'Error';
    var loaderBgVariable = '#fec107';
    var iconVariable = 'error';
    var textVariable = message;

    $.toast().reset('all');
    $("body").removeAttr('class').removeClass("bottom-center-fullwidth").addClass("top-center-fullwidth");
    $.toast({
        heading: headingVariable,
        text: textVariable,
        position: 'top-center',
        loaderBg: loaderBgVariable,
        icon: iconVariable,
        hideAfter: 3500,
        stack: 6
    });
    return false;

}

function confirmAlert() {

    $.MessageBox({

        buttonDone: "Yes",
        buttonFail: "No",
        message: "Are You Sure?"

    }).done(function() {

        return true;

    }).fail(function() {

        return false;

    });
}

$(window).on("load", function() {

    var flashType = $('#flashMessage').attr('data-type');
    var flashMsg = $('#flashMessage').attr('data-message');

    if (flashType && flashMsg) {

        flashMessage(flashType, flashMsg);

    }

});

$(function() {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

});

// if (!!window.performance && window.performance.navigation.type === 2) {
//     // value 2 means "The page was accessed by navigating into the history"
//     console.log('Reloading');
//     window.location.reload(); // reload whole page

// }

// window.onpageshow = function (event) {
//     if (event.persisted) {
//         window.location.reload();
//     }
// };

// $(document).ready(function () {
//     window.history.pushState(null, "", window.location.href);
//     window.onpopstate = function () {
//         window.history.pushState(null, "", window.location.href);
//     };
// });

// function fieldCheck(selector) {

//     var selectorElement = selector + ' input, ' + selector +' select';

//     $(selectorElement).each(
//         function (index) {
//             var input = $(this);
//             alert('Type: ' + input.attr('type') + 'Name: ' + input.attr('name') + 'Value: ' + input.val());

//             $(document).on('focusin', input, function () {
//                 console.log("Saving value " + $(this).val());
//                 $(this).data('val', $(this).val());
//             }).on('change', 'input', function () {
//                 var previousName = $(this).data('name') + "_previous_value";
//                 var prev = $(this).data('val');
//                 var current = $(this).val();

//                 if (prev != current) {

//                     $(selector).append('<input type="hidden" name=' + previousName + ' value="' + prev +'" />');

//                 }
//                 console.log("Prev value " + prev);
//                 console.log("New value " + current);
//             });


//         }
//     );

// }

// $(document).on('focus', '.checkField', function () {

//     console.log("Saving value " + $(this).val());
//     $(this).attr('previous_value', $(this).val());

// }).on('change', '.checkField', function () {

//     var selector = $(this).closest("form").attr('id');
//     var previousName = $(this).attr('name') + "_previous_value";
//     var prev = $(this).attr('previous_value');
//     var current = $(this).val();

//     if (prev != current) {

//         $(selector).append('<input type="hidden" name=' + previousName + ' value="' + prev + '" />');

//     }
//     console.log("selector " + selector);
//     console.log("previousName " + previousName);
//     console.log("Prev value " + prev);
//     console.log("New value " + current);
// });

// $(document).on('focusin focus', '.checkField', function () {

//     console.log("Saving value " + $(this).val());
//     $(this).attr('previous_value', $(this).val());

//     if ($(this).attr('name') == "description") {

//         var selector = $(this).closest("form").attr('id');
//         var previousName = $(this).attr('name') + "_previous_value";
//         var prev = $(this).attr('previous_value');

//         $('#' + selector).append('<input type="hidden" name=' + previousName + ' value="' + prev + '" />');

//     }

// }).on('change', '.checkField', function () {

//     var selector = $(this).closest("form").attr('id');
//     var previousName = $(this).attr('name') + "_previous_value";
//     var prev = $(this).attr('previous_value');
//     var current = $(this).val();

//     if (prev != current) {

//         var historyValues = [];
//         var historyValue = {};

//         historyValue.field_value = $(this).attr('name');
//         historyValue.original_value = prev;
//         historyValue.modified_value = current;

//         historyValues.push(historyValue);

//         $('#' + selector).append('<input type="hidden" name="history[]" value=' + "'" + JSON.stringify(historyValue) + "'"  + ' />');


//         // if ($('#' + selector +" input[name=history]").length == 0) {

//         //     // $(selector).append('<input type="hidden" name=' + previousName + ' value="' + prev + '" />');
//         //     $('#' + selector).append('<input type="hidden" name="history[]" value="' + JSON.stringify(historyValue) + '" />');

//         // } else {

//         //     if ($('#' + selector +" input[name=history]").val() != "") {

//         //         var historyObj = JSON.parse($('#' + selector +" input[name=history]").val());

//         //         console.log("historyObj");
//         //         console.log(historyObj);


//         //         historyObj.append(historyValue);

//         //         $('#' + selector +" input[name=history]").val(JSON.stringify(historyValue));

//         //     }

//         // }


//     }

//     console.log("historyValue " + JSON.stringify(historyValue));
//     console.log("selector " + selector);
//     console.log("previousName " + previousName);
//     console.log("Prev value " + prev);
//     console.log("New value " + current);

// });


$(document).on('focus', '.checkField', function() {

    $(this).attr('previous_value', $(this).val());

    // if ($(this).attr('name') == "description") {

    //     var selector = $(this).closest("form").attr('id');
    //     var previousName = $(this).attr('name') + "_previous_value";
    //     var prev = $(this).attr('previous_value');

    //     $('#' + selector).append('<input type="hidden" name=' + previousName + ' value="' + prev + '" />');

    // }

});

// $('.checkField').on('focus', function () {

//     console.log("Saving value " + $(this).val());
//     $(this).attr('previous_value', $(this).val());

//     if ($(this).attr('name') == "description") {

//         var selector = $(this).closest("form").attr('id');
//         var previousName = $(this).attr('name') + "_previous_value";
//         var prev = $(this).attr('previous_value');

//         $('#' + selector).append('<input type="hidden" name=' + previousName + ' value="' + prev + '" />');

//     }

// });

$(document).on('click', '.checkFormButton', function(e) {

    e.preventDefault(); //Prevent the normal submission action

    var selector = $('.checkFormButton').closest("form").attr('id');

    // var selector = $('.checkForm').attr('id');

    // console.log('#' + selector + ' input, ' + '#' + selector + ' select');


    $('#' + selector + ' input, ' + '#' + selector + ' select, ' + '#' + selector + ' textarea').each(
        // $('#' + selector).find('.checkField').each(

        function(index) {

            // var input = $(this);

            var previousName = $(this).attr('name') + "_previous_value";
            var prev = $(this).attr('previous_value');

            var current = $(this).val();

            // if (current == 'on') {

            //     current = 'checked';

            // }

            if (prev != undefined && prev != current) {

                // var historyValue = {};

                var fieldName = $(this).attr('name');

                // historyValue.field_value = $(this).attr('name');
                $('#' + selector).append('<input type="hidden" name="history~' + fieldName + '~field_value' + '" value=' + "'" + fieldName + "'" + ' />');
                // historyValue.original_value = prev;
                $('#' + selector).append('<input type="hidden" name="history~' + fieldName + '~original_value' + '" value=' + "'" + prev + "'" + ' />');
                // historyValue.modified_value = current;
                $('#' + selector).append('<input type="hidden" name="history~' + fieldName + '~modified_value' + '" value=' + "'" + current + "'" + ' />');

                // $('#' + selector).append('<input type="hidden" name="history[]" value=' + "'" + JSON.stringify(historyValue) + "'" + ' />');

            }

        }
    );

    $('#' + selector).submit();

});

function formHistory(buttonSelector) {

    var selector = $(buttonSelector).closest("form").attr('id');

    $('#' + selector + ' input, ' + '#' + selector + ' select, ' + '#' + selector + ' textarea').each(
        // $('#' + selector).find('.checkField').each(

        function(index) {

            // var input = $(this);

            var previousName = $(this).attr('name') + "_previous_value";
            var prev = $(this).attr('previous_value');

            var current = $(this).val();

            // if (current == 'on') {

            //     current = 'checked';

            // }

            if (prev != undefined && prev != current) {

                // var historyValue = {};

                var fieldName = $(this).attr('name');

                // historyValue.field_value = $(this).attr('name');
                $('#' + selector).append('<input type="hidden" name="history~' + fieldName + '~field_value' + '" value=' + "'" + fieldName + "'" + ' />');
                // historyValue.original_value = prev;
                $('#' + selector).append('<input type="hidden" name="history~' + fieldName + '~original_value' + '" value=' + "'" + prev + "'" + ' />');
                // historyValue.modified_value = current;
                $('#' + selector).append('<input type="hidden" name="history~' + fieldName + '~modified_value' + '" value=' + "'" + current + "'" + ' />');

                // $('#' + selector).append('<input type="hidden" name="history[]" value=' + "'" + JSON.stringify(historyValue) + "'" + ' />');

            }

        }
    );

}

$(".select-all").click(function() {
    if ($(".select-all").is(':checked')) {
        $(this).parent().next().find('option').prop('selected', 'selected');
        $(this).parent().next().trigger("change");
    } else {
        $(this).parent().next().find('option').removeAttr("selected");
        $(this).parent().next().find('option').trigger("change");
    }
});

$('a[rel=popover]').popover({
    html: 'true',
    placement: 'right'
});

function getFileType(filename) {

    var type = "file";

    var extension = filename.split('.').pop();

    switch (extension) {
        case 'pdf':
        case 'PDF':
            type = 'pdf';
            break;
        case 'txt':
            type = 'text';
            break;
        case 'docx':
        case 'doc':
            type = 'word';
            break;
        case 'xls':
        case 'xlsx':
        case 'csv':
            type = 'excel';
            break;
        case 'mp3':
        case 'ogg':
        case 'wav':
            type = 'audio';
            break;
        case 'mp4':
        case 'mov':
            type = 'video';
            break;
        case 'zip':
        case '7z':
        case 'rar':
            type = 'archive';
            break;
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'PNG':
            type = 'image';
            break;
        case 'html':
            type = 'code';
            break;
        case 'txt':
            type = 'txt';
            break;
        case 'eml':
            type = 'envelope';
            break;
        default:
            type = 'picture';
    }

    return type;
}

/**
 * mb_strwidth
 * @param String
 * @return int
 * @see http://php.net/manual/ja/function.mb-strwidth.php
 */
function mb_strwidth(str) {

    var i = 0,
        l = str.length,
        c = '',
        length = 0;

    for (i; i < l; i++) {

        c = str.charCodeAt(i);

        if (0x0000 <= c && c <= 0x0019) {

            length += 0;

        } else if (0x0020 <= c && c <= 0x1FFF) {

            length += 1;

        } else if (0x2000 <= c && c <= 0xFF60) {

            length += 2;

        } else if (0xFF61 <= c && c <= 0xFF9F) {

            length += 1;

        } else if (0xFFA0 <= c) {

            length += 2;

        }

    }

    return length;
};

/**
 * mb_strimwidth
 * @param String
 * @param int
 * @param int
 * @param String
 * @return String
 * @see http://www.php.net/manual/ja/function.mb-strimwidth.php
 */
function mb_strimwidth(str, start, width, trimmarker) {

    if (typeof trimmarker === 'undefined') trimmarker = '';

    var trimmakerWidth = mb_strwidth(trimmarker),
        i = start,
        l = str.length,
        trimmedLength = 0,
        trimmedStr = '';

    for (i; i < l; i++) {

        var charCode = str.charCodeAt(i),
            c = str.charAt(i),
            charWidth = mb_strwidth(c),
            next = str.charAt(i + 1),
            nextWidth = mb_strwidth(next);
        trimmedLength += charWidth;
        trimmedStr += c;

        if (trimmedLength + trimmakerWidth + nextWidth > width) {

            trimmedStr += trimmarker;
            break;

        }
    }

    return trimmedStr;

}

function unauthorizedAjaxRequest(exception) {

    if (exception == 'Unauthorized') {

        // Prompt user if they'd like to be redirected to the login page

        Swal.fire({

            title: 'Your session has expired.',
            text: "Please login again!",
            closeOnClickOutside: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            // confirmButtonText: 'Yes',
            showClass: {
                popup: 'animated fadeIn faster'
            },
            hideClass: {
                popup: 'animated fadeOut faster'
            },

        }).then((result) => {

            if (result.value != undefined && result.value == true) {

                window.location.reload();

            }

        });

    }

}

$(document).ajaxError(function(event, jqxhr, settings, exception) {

    unauthorizedAjaxRequest(exception);

});
