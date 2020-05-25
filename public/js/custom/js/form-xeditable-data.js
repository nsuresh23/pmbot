/*FormXeditable Init*/
$(function() {
    "use strict";

    /* editables*/

    $('#dob').editable({
        format: 'YYYY-MM-DD',
        viewformat: 'DD.MM.YYYY',
        template: 'D / MMMM / YYYY',
        combodate: {
            minYear: 2000,
            maxYear: 2015,
            minuteStep: 1
        }
    });
    $('#snooze').editable({
        format: 'yyyy-mm-dd hh:ii',
        viewformat: 'dd/mm/yyyy hh:ii',
        inputClass: 'editable-input',
        mode: 'inline',
        datetimepicker: {
            weekStart: 1
        }
    });
    $('#remainder').editable({
        format: 'yyyy-mm-dd hh:ii',
        viewformat: 'dd/mm/yyyy hh:ii',
        datetimepicker: {
            weekStart: 1
        }
    });
    $('#followup-count').editable({
        type: 'text',
        pk: 1,
        name: 'followupCount',
        title: 'Enter followup count'
    });

    $('#username').editable({
        type: 'text',
        pk: 1,
        name: 'username',
        title: 'Enter username'
    });

    $('#firstname').editable({
        validate: function(value) {
            if ($.trim(value) == '') return 'This field is required';
        }
    });

    $('#sex').editable({
        prepend: "not selected",
        source: [
            { value: 1, text: 'Male' },
            { value: 2, text: 'Female' }
        ],
        display: function(value, sourceData) {
            var colors = { "": "#98a6ad", 1: "#5fbeaa", 2: "#5d9cec" },
                elem = $.grep(sourceData, function(o) { return o.value == value; });

            if (elem.length) {
                $(this).text(elem[0].text).css("color", colors[value]);
            } else {
                $(this).empty();
            }
        }
    });

    $('#status').editable();

    $('#group').editable({
        showbuttons: false
    });

    $('#dob').editable();

    $('#comments').editable({
        showbuttons: 'bottom'
    });

    /*inline*/
    $('#inline-username').editable({
        type: 'text',
        pk: 1,
        name: 'username',
        title: 'Enter username',
        mode: 'inline'
    });

    $('#inline-firstname').editable({
        validate: function(value) {
            if ($.trim(value) == '') return 'This field is required';
        },
        mode: 'inline'
    });

    $('#inline-sex').editable({
        prepend: "not selected",
        mode: 'inline',
        source: [
            { value: 1, text: 'Male' },
            { value: 2, text: 'Female' }
        ],
        display: function(value, sourceData) {
            var colors = { "": "#98a6ad", 1: "#5fbeaa", 2: "#5d9cec" },
                elem = $.grep(sourceData, function(o) { return o.value == value; });

            if (elem.length) {
                $(this).text(elem[0].text).css("color", colors[value]);
            } else {
                $(this).empty();
            }
        }
    });

    $('#inline-status').editable({ mode: 'inline' });

    $('#inline-group').editable({
        showbuttons: false,
        mode: 'inline'
    });

    $('#inline-dob').editable({ mode: 'inline' });

    $('#inline-comments').editable({
        showbuttons: 'bottom',
        mode: 'inline'
    });
});