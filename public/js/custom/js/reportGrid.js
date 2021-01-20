// $('#example').DataTable({
//     dom: 'Bfrtip',
//     buttons: [
//         'copy', 'csv', 'excel', 'pdf', 'print'
//     ]
// });

function getSummaryReportTableList(gridSelector) {

    var reportBlockId = "summary-report";
    var listUrl = $(gridSelector).attr('data-list-url');
    var category = $(gridSelector).attr('data-category');
    var pageSize = $('#currentUserInfo').attr('data-page-size');

    var columnFields = [
        { 'data': 's_no' },
        { 'data': 'pmname_link' },
        { 'data': 'formatted_date' },
        { 'data': 'formatted_first_login', 'className': 'report-user-login-info-bg' },
        { 'data': 'formatted_last_logout', 'className': 'report-user-login-info-bg' },
        { 'data': 'overall_time', 'className': 'report-user-login-info-bg' },
    ];

    if (category != undefined && category == 'summary') {

        reportBlockId = "summary-report";

        columnFields.push(...[
            { 'data': 'email_received_count', 'className': 'report-email-info-bg' },
            { 'data': 'email_received_time_in_minutes', 'className': 'report-email-info-bg' },
            { 'data': 'email_received_average_time_in_minutes', 'className': 'report-email-info-bg' },
            { 'data': 'email_sent_count', 'className': 'report-email-info-bg' },
            { 'data': 'email_sent_time_in_minutes', 'className': 'report-email-info-bg' },
            { 'data': 'email_sent_average_time_in_minutes', 'className': 'report-email-info-bg' },
        ]);

    }

    if (category != undefined && category == 'received_email') {

        reportBlockId = "received-email-report";

        columnFields.push(...[
            { 'data': 'email_received_title_count', 'className': 'report-email-info-bg' },
            { 'data': 'email_received_title_time_in_minutes', 'className': 'report-email-info-bg' },
            { 'data': 'email_received_title_average_time_in_minutes', 'className': 'report-email-info-bg' },
            { 'data': 'email_received_nonbusiness_count', 'className': 'report-email-info-bg' },
            { 'data': 'email_received_nonbusiness_time_in_minutes', 'className': 'report-email-info-bg' },
            { 'data': 'email_received_nonbusiness_average_time_in_minutes', 'className': 'report-email-info-bg' },
            { 'data': 'email_received_generic_count', 'className': 'report-email-info-bg' },
            { 'data': 'email_received_generic_time_in_minutes', 'className': 'report-email-info-bg' },
            { 'data': 'email_received_generic_average_time_in_minutes', 'className': 'report-email-info-bg' },
        ]);

    }

    if (category != undefined && category == 'sent_email') {

        reportBlockId = "sent-email-report";

        columnFields.push(...[
            { 'data': 'email_sent_title_count', 'className': 'report-email-info-bg' },
            { 'data': 'email_sent_title_time_in_minutes', 'className': 'report-email-info-bg' },
            { 'data': 'email_sent_title_average_time_in_minutes', 'className': 'report-email-info-bg' },
            { 'data': 'email_sent_nonbusiness_count', 'className': 'report-email-info-bg' },
            { 'data': 'email_sent_nonbusiness_time_in_minutes', 'className': 'report-email-info-bg' },
            { 'data': 'email_sent_nonbusiness_average_time_in_minutes', 'className': 'report-email-info-bg' },
            { 'data': 'email_sent_generic_count', 'className': 'report-email-info-bg' },
            { 'data': 'email_sent_generic_time_in_minutes', 'className': 'report-email-info-bg' },
            { 'data': 'email_sent_generic_average_time_in_minutes', 'className': 'report-email-info-bg' },
        ]);

    }

    if (category != undefined && category == 'classified_email') {

        reportBlockId = "classification-email-report";

        columnFields.push(...[
            { 'data': 'positive', 'className': 'report-email-info-bg' },
            { 'data': 'netural', 'className': 'report-email-info-bg' },
            { 'data': 'negative', 'className': 'report-email-info-bg' },
        ]);

    }

    if ($.fn.DataTable.isDataTable(gridSelector)) {

        $(gridSelector).DataTable().clear().destroy();

    }

    $.fn.dataTable.ext.errMode = 'none';

    var reportTable = $(gridSelector).DataTable({
        // dom: 'Bfrtip',
        dom: 'lBrtip',
        retrieve: true,
        processing: true,
        serverSide: true,
        ordering: false,
        paging: false,
        autoWidth: false,
        // scrollY: '50vh',
        // scrollCollapse: true,
        // stateSave: true,
        "language": {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
        },
        'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': ['nosort']
        }],
        // pagingType: 'full',
        pageLength: 25,
        // lengthChange: true,
        stripeClasses: [],
        // buttons: [
        //     'copy', 'csv', 'excel', 'pdf', 'print'
        // ],
        buttons: [
            { extend: 'csv', text: 'Download' }
        ],
        /* AJAX call to get list */
        ajax: {
            url: listUrl,
            type: 'POST',
            // data: [],
            data: function(d) {
                return $.extend({}, d, {
                    'filter_option': {
                        'range': $('#' + reportBlockId + ' .report-daterange-datepicker').val(),
                        'report_type': $('#' + reportBlockId + ' .report-type').val(),
                        'user_empcode': $('#' + reportBlockId + ' .user-empcode').val(),
                    },
                    'category': $(gridSelector).attr('data-category'),
                });
            },
            dataType: "json",
            // dataSrc: function(response) {

            //     var d = $.Deferred();

            //     var dataResult = { draw: '', recordsTotal: '', recordsFiltered: '', data: [] };

            //     if (response.success == "true") {

            //         if (response.data != '') {

            //             response.data = formatDataItem(response.data);

            //             var dataResult = {
            //                 data: response.data,
            //                 recordsTotal: response.recordsTotal,
            //                 recordsFiltered: response.recordsFiltered,
            //             };

            //             return dataResult;

            //             d.resolve(dataResult);

            //             if ('result_count' in response) {

            //                 var resultCount = response.result_count;

            //                 if (parseInt(resultCount) != NaN && parseInt(resultCount) > 0) {

            //                     if (parseInt(resultCount) > 99999) {

            //                         resultCount = '99999+'

            //                     }

            //                     $('.email-rules-count').html('(' + resultCount + ')');

            //                 }


            //             }

            //         } else {

            //             d.resolve(dataResult);

            //         }

            //     } else {

            //         d.resolve(dataResult);

            //     }

            //     return d.promise();

            // }

        },
        // columnDefs:
        //     [
        //         {
        //             targets: 0,
        //             data: 's_no',
        //             title: "SNO",
        //             className: "never"
        //         },
        //     ],
        // columns: [
        //     { 'data': 's_no' },
        //     { 'data': 'pmname' },
        //     { 'data': 'date' },
        //     { 'data': 'first_login' },
        //     { 'data': 'last_logout' },
        //     { 'data': 'overall_time' },
        //     { 'data': 'email_received_count' },
        //     { 'data': 'email_received_time' },
        //     { 'data': 'email_received_average_time' },
        //     { 'data': 'email_sent_count' },
        //     { 'data': 'email_sent_time_in_minutes' },
        //     { 'data': 'email_sent_average_time_in_minutes' },
        // ],
        columns: columnFields,

    });

    if ($('#' + reportBlockId + ' .report-daterange-datepicker') != undefined) {

        // $('.report-daterange-datepicker').val('');

    }

    $('#' + reportBlockId + ' .report-daterange-datepicker').on('apply.daterangepicker', function(ev, picker) {

        if (reportTable != undefined && reportTable != null) {

            // $('.report-daterange-datepicker').attr('from', picker.startDate.format('YYYY-MM-DD'));
            // $('.report-daterange-datepicker').attr('to', picker.endDate.format('YYYY-MM-DD'));

            reportTable.draw();

        }

    });

    $('#' + reportBlockId + ' .report-type').on('change', function() {

        if (reportTable != undefined && reportTable != null) {

            reportTable.draw();

        }

    });

    $('#' + reportBlockId + ' .user-empcode').on('change', function() {

        if (reportTable != undefined && reportTable != null) {

            reportTable.draw();

        }

    });

}


$('.summary-report-grid tbody').slimscroll({
    height: '520px',
    alwaysVisible: 'true',
});

$('.received-email-report-grid tbody').slimscroll({
    height: '520px',
    alwaysVisible: 'true',
});

$('.sent-email-report-grid tbody').slimscroll({
    height: '520px',
    alwaysVisible: 'true',
});

$('.classified-email-report-grid tbody').slimscroll({
    height: '520px',
    alwaysVisible: 'true',
});

// $(document).on('shown.bs.tab', '#reportsTab', function(e) {

//     var gridSelector = ".summary-report-grid";

//     var dataUrl = $(gridSelector).attr('data-list-url');

//     if (dataUrl != undefined && dataUrl != "") {

//         getSummaryReportTableList(gridSelector);

//     }

// });

$(document).on('click', '#reportsTab', function(e) {

    var gridSelector = "#summary-report-grid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        getSummaryReportTableList(gridSelector);

    }

});

$(document).on('click', '#summaryReportTab', function(e) {

    var gridSelector = "#summary-report-grid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        getSummaryReportTableList(gridSelector);

    }

});

$(document).on('click', '#receivedEmailReportTab', function(e) {

    var gridSelector = "#received-email-report-grid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        getSummaryReportTableList(gridSelector);

    }

});

$(document).on('click', '#sentEmailReportTab', function(e) {

    var gridSelector = "#sent-email-report-grid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        getSummaryReportTableList(gridSelector);

    }

});

$(document).on('click', '#classificationEmailReportTab', function(e) {

    var gridSelector = "#classified-email-report-grid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        getSummaryReportTableList(gridSelector);

    }

});

function getUserLoginHistoryReportTableList(gridSelector) {

    var listUrl = $(gridSelector).attr('data-list-url');
    var category = $(gridSelector).attr('data-category');
    var date = $(gridSelector).attr('data-date');
    var empcode = $(gridSelector).attr('data-empcode');
    var pageSize = $('#currentUserInfo').attr('data-page-size');

    var insertControlVisible = false;
    var editControlVisible = false;
    var deleteControlVisible = false;

    var dbClients = "";

    var field = [];

    field.push({
        title: "S.NO",
        name: "s_no",
        type: "number",
        inserting: false,
        filtering: false,
        sorting: false,
        editing: false,
        // width: 10,
    });

    field.push({
        title: "PM NAME",
        name: "empcode",
        type: "text",
        filtering: false,
        sorting: false,
        // width: 40,
    });

    field.push({
        title: "LOGGED IN BY",
        name: "creator_empcode",
        type: "text",
        filtering: false,
        sorting: false,
        // width: 40,
    });

    field.push({
        title: "IP ADDRESS",
        name: "ipaddress",
        type: "text",
        filtering: false,
        sorting: false,
        // width: 40,
    });

    field.push({
        title: "STATUS",
        name: "type",
        type: "text",
        filtering: false,
        sorting: false,
        // width: 40,
    });

    field.push({
        title: "ACTION",
        name: "action_type",
        // name: "negative_count",
        type: "text",
        filtering: false,
        sorting: false,
        // width: 40,
    });

    field.push({
        title: "Date",
        name: "created_date",
        // name: "negative_count",
        type: "text",
        filtering: false,
        sorting: false,
        // width: 40,
    });

    // field.push({
    //     type: "control",
    //     name: "Control",
    //     editButton: editControlVisible,
    //     deleteButton: deleteControlVisible,
    //     headerTemplate: function() {

    //         return this._createOnOffSwitchButton("filtering", this.searchModeButtonClass, false);

    //     },
    //     width: 70,
    // });

    $(gridSelector).jsGrid({

        height: "450px",
        width: "100%",
        autowidth: true,
        editing: editControlVisible,
        inserting: insertControlVisible,
        filtering: false,
        sorting: false,
        autoload: true,
        paging: false,
        pageLoading: true,
        pageSize: pageSize,
        pageIndex: 1,
        pageButtonCount: 5,

        confirmDeleting: false,

        noDataContent: "No data",

        invalidNotify: function(args) {

            $('#alert-error-not-submit').removeClass('hidden');

        },

        loadIndication: true,
        // loadIndicationDelay: 500,
        loadMessage: "Please, wait...",
        loadShading: true,

        fields: field,

        onInit: function(args) {

            this._resetPager();

        },

        search: function(filter) {

            this._resetPager();
            return this.loadData(filter);

        },

        onPageChanged: function(args) {

            $('html, body').animate({
                scrollTop: $(".emailGrid").offset().top - 110
            }, 0);

        },

        controller: {

            loadData: function(filter) {

                $('.user-login-history-count').html('');

                var d = $.Deferred();

                var userLoginHistoryPostData = {};

                userLoginHistoryPostData.filter = filter

                userLoginHistoryPostData.date = date;

                userLoginHistoryPostData.empcode = empcode;

                /* AJAX call to get list */
                $.ajax({

                    url: listUrl,
                    data: userLoginHistoryPostData,
                    dataType: "json",
                    beforeSend: function() {
                        $('.userLoginHistory_loader').show();
                    },
                    complete: function() {
                        $('.userLoginHistory_loader').hide();
                    }

                }).done(function(response) {

                    var dataResult = {};

                    dataResult.data = '';

                    if (response.success == "true") {

                        if (response.data != '') {

                            dbClients = response.data;

                            dataResult.data = response.data;
                            dataResult.itemsCount = response.result_count;

                            d.resolve(dataResult);

                            if ('result_count' in response) {

                                var resultCount = response.result_count;

                                if (parseInt(resultCount) != NaN && parseInt(resultCount) > 0) {

                                    if (parseInt(resultCount) > 99999) {

                                        resultCount = '99999+'

                                    }

                                    $('.user-login-history-count').html('(' + resultCount + ')');

                                }


                            }

                        } else {

                            d.resolve(dataResult);

                        }

                    } else {

                        d.resolve(dataResult);

                    }


                });

                return d.promise();

            }
        },

        rowClick: function(args) {

            $(gridSelector).jsGrid("cancelEdit");

        },

    });

}

$(document).on('click', '.user-login-history-btn', function(e) {

    e.preventDefault(false);

    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var modalTitle = $(this).attr('data-grid-title');

    var date = $(this).attr('data-date');

    var epmcode = $(this).attr('data-empcode');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (date != undefined && date != "") {

        $(gridSelector).attr('data-date', date);

        if (epmcode != undefined && epmcode != "") {

            $(gridSelector).attr('data-empcode', epmcode);

        }

        if (modalTitle != undefined && modalTitle != "") {

            $('.user-login-history-modal-title').html(modalTitle);

        }

        if (dataUrl != undefined && dataUrl != "" && epmcode != undefined && epmcode != "") {

            getUserLoginHistoryReportTableList(gridSelector);

        }

        $(".user-login-history-modal").modal('show');

    }

});

$('.user-login-history-grid .jsgrid-grid-body').slimscroll({
    height: '520px',
    alwaysVisible: 'true',
});
