/*FormPicker Init*/

$(document).ready(function() {
    "use strict";

    /* Bootstrap Colorpicker Init*/
    $('.colorpicker').colorpicker();

    $('.colorpicker-rgb').colorpicker({
        color: '#AA3399',
        format: 'rgba'
    });

    $('.colorpicker-inline').colorpicker({
        color: '#ffaa00',
        container: true,
        inline: true
    });

    /* Datetimepicker Init*/
    $('#datetimepicker1').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false,
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        },
    }).on('dp.show', function() {
        if ($(this).data("DateTimePicker").date() === null)
            $(this).data("DateTimePicker").date(moment());
    });

    /* Datetimepicker Init*/
    $('.datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
        useCurrent: false,
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        },
    }).on('dp.show', function() {
        if ($(this).data("DateTimePicker").date() === null)
            $(this).data("DateTimePicker").date(moment());
    });

    // $('#datetimepicker2').datetimepicker({
    // 		format: 'LT',
    // 		useCurrent: false,
    // 		icons: {
    //                 time: "fa fa-clock-o",
    //                 date: "fa fa-calendar",
    //                 up: "fa fa-arrow-up",
    //                 down: "fa fa-arrow-down"
    //             },
    // 	}).data("DateTimePicker").date(moment());;

    $('#datetimepicker3').datetimepicker({
        format: 'DD-MM-YYYY',
        inline: true,
        sideBySide: true,
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        },
    });

    // $('#datetimepicker4').datetimepicker({
    // 		inline:true,
    // 		sideBySide: true,
    // 		useCurrent: false,
    // 		icons: {
    //                 time: "fa fa-clock-o",
    //                 date: "fa fa-calendar",
    //                 up: "fa fa-arrow-up",
    //                 down: "fa fa-arrow-down"
    //             },
    // }).data("DateTimePicker").date(moment());

    /* Daterange picker Init*/
    $('.input-daterange-datepicker').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-info',
        cancelClass: 'btn-default'
    });
    $('.report-daterange-datepicker').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-info',
        cancelClass: 'btn-default',
        // format: 'Y-m-d H:i:s',
        locale: {
            format: 'YYYY-MM-DD',
            separator: ' to ',
        },
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    });
    $('.report-daterange-timepicker').daterangepicker({
        timePicker: true,
        timePickerIncrement: 5,
        timePicker24Hour: true,
        timePickerSeconds: false,
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-info',
        cancelClass: 'btn-default',
        // format: 'Y-m-d H:i:s',
        locale: {
            format: 'YYYY-MM-DD HH:mm:ss',
            separator: ' to ',
        },
    });
    $('.input-daterange-timepicker').daterangepicker({
        timePicker: true,
        format: 'MM/DD/YYYY h:mm A',
        timePickerIncrement: 30,
        timePicker12Hour: true,
        timePickerSeconds: false,
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-info',
        cancelClass: 'btn-default'
    });
    $('.input-limit-datepicker').daterangepicker({
        format: 'MM/DD/YYYY',
        minDate: '06/01/2015',
        maxDate: '06/30/2015',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-info',
        cancelClass: 'btn-default',
        dateLimit: {
            days: 6
        }
    });

    $(".star-block").rating({
        theme: 'krajee-fa',
        filledStar: '<i class="fa fa-star star-color"></i>',
        emptyStar: '<i class="fa fa-star-o"></i>',
        step: 1,
        min: 0,
        max: 3,
        stars: 3,
        starCaptionClasses: function(val) {
            if (val == undefined || val == 0) {
                return 'badge badge-default';
            } else if (val == 1) {
                return 'badge badge-danger';
            } else if (val == 2) {
                return 'badge badge-warning';
            } else if (val > 2) {
                return 'badge badge-success';
            } else {
                return 'badge badge-default';
            }
        },
        // starCaptions: { 1: 'Very Poor', 2: 'Poor', 3: 'Ok', 4: 'Good', 5: 'Very Good' },
        // starCaptionClasses: { 1: 'text-danger', 2: 'text-warning', 3: 'text-info', 4: 'text-primary', 5: 'text-success' }
    }).on("rating:clear", function(event, value, caption) {
        // alert("Your rating is reset " + value)
    }).on("rating:change", function(event, value, caption) {

        // if (value == undefined || value == 0) {

        //     $('.star-color').addClass('txt-default');

        // }

        // if (value == 1) {

        //     $('.star-color').addClass('txt-danger');

        // }

        // if (value == 2) {

        //     $('.star-color').addClass('txt-warning');

        // }

        // if (value > 2) {

        //     $('.star-color').addClass('txt-success');

        // }

        // alert("You rated: " + value + " = " + $(caption).text());
    }).on("rating:hover", function(event, value, caption) {

        // if (value == undefined || value == 0) {

        //     $('.star-color').addClass('txt-default');

        // }

        // if (value == 1) {

        //     $('.star-color').addClass('txt-danger');

        // }

        // if (value == 2) {

        //     $('.star-color').addClass('txt-warning');

        // }

        // if (value > 2) {

        //     $('.star-color').addClass('txt-success');

        // }

        // alert("You rated: " + value + " = " + $(caption).text());
    });

});
