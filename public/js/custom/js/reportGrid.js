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
        { 'data': 's_no', 'className': 'datatable_border_right' },
        { 'data': 'pmname_link', 'className': 'datatable_border_right' },
    ];

    if (category != undefined && category != 'external_email' && category != 'reviewed_email' && category != 'classified_email') {

        columnFields.push(...[
            { 'data': 'formatted_date', 'className': 'text-center datatable_border_right' },
            { 'data': 'formatted_first_login', 'className': 'report-user-login-info-bg text-center' },
            { 'data': 'formatted_last_logout', 'className': 'report-user-login-info-bg text-center' },
            { 'data': 'overall_time', 'className': 'report-user-login-info-bg text-center datatable_border_right' },
        ]);

    }

    if (category != undefined && category == 'summary') {

        reportBlockId = "summary-report";

        columnFields.push(...[
            { 'data': 'email_received_count', 'className': 'report-email-info-bg text-center' },
            { 'data': 'email_received_time_in_minutes', 'className': 'report-email-info-bg text-center' },
            { 'data': 'email_received_average_time_in_minutes', 'className': 'report-email-info-bg text-center datatable_border_right' },
            { 'data': 'email_sent_count', 'className': 'report-email-info-bg text-center' },
            { 'data': 'email_sent_time_in_minutes', 'className': 'report-email-info-bg text-center' },
            { 'data': 'email_sent_average_time_in_minutes', 'className': 'report-email-info-bg text-center' },
        ]);

    }

    if (category != undefined && category == 'received_email') {

        reportBlockId = "received-email-report";

        columnFields.push(...[
            { 'data': 'receive_title_count', 'className': 'report-email-info-bg text-center' },
            { 'data': 'email_received_title_time_in_minutes', 'className': 'report-email-info-bg text-center' },
            { 'data': 'email_received_title_average_time_in_minutes', 'className': 'report-email-info-bg text-center datatable_border_right' },
            { 'data': 'receive_nonbusiness_count', 'className': 'report-email-info-bg text-center' },
            { 'data': 'email_received_nonbusiness_time_in_minutes', 'className': 'report-email-info-bg text-center' },
            { 'data': 'email_received_nonbusiness_average_time_in_minutes', 'className': 'report-email-info-bg text-center datatable_border_right' },
            { 'data': 'receive_generic_count', 'className': 'report-email-info-bg text-center' },
            { 'data': 'email_received_generic_time_in_minutes', 'className': 'report-email-info-bg text-center' },
            { 'data': 'email_received_generic_average_time_in_minutes', 'className': 'report-email-info-bg text-center' },
        ]);

    }

    if (category != undefined && category == 'sent_email') {

        reportBlockId = "sent-email-report";

        columnFields.push(...[
            { 'data': 'sent_title_count', 'className': 'report-email-info-bg text-center' },
            { 'data': 'email_sent_title_time_in_minutes', 'className': 'report-email-info-bg text-center' },
            { 'data': 'email_sent_title_average_time_in_minutes', 'className': 'report-email-info-bg text-center datatable_border_right' },
            { 'data': 'sent_nonbusiness_count', 'className': 'report-email-info-bg text-center' },
            { 'data': 'email_sent_nonbusiness_time_in_minutes', 'className': 'report-email-info-bg text-center' },
            { 'data': 'email_sent_nonbusiness_average_time_in_minutes', 'className': 'report-email-info-bg text-center datatable_border_right' },
            { 'data': 'sent_generic_count', 'className': 'report-email-info-bg text-center' },
            { 'data': 'email_sent_generic_time_in_minutes', 'className': 'report-email-info-bg text-center' },
            { 'data': 'email_sent_generic_average_time_in_minutes', 'className': 'report-email-info-bg text-center' },
        ]);

    }

    if (category != undefined && category == 'external_email') {

        reportBlockId = "external-email-report";

        columnFields.push(...[
            { 'data': 'formatted_emails_unresponded_count', 'className': 'text-center datatable_border_right' },
            { 'data': 'formatted_not_set_count', 'className': 'report-user-login-info-bg text-center' },
            { 'data': 'formatted_positive_count', 'className': 'report-user-login-info-bg text-center' },
            { 'data': 'formatted_neutral_count', 'className': 'report-user-login-info-bg text-center' },
            { 'data': 'formatted_negative_count', 'className': 'report-user-login-info-bg text-center datatable_border_right' },
            { 'data': 'formatted_emails_responded_count', 'className': 'report-email-info-bg text-center' },
            { 'data': 'formatted_average_response_time', 'className': 'report-email-info-bg text-center' },
        ]);

    }

    if (category != undefined && category == 'reviewed_email') {

        reportBlockId = "reviewed-email-report";

        columnFields.push(...[
            { 'data': 'formatted_reviewed_count', 'className': 'report-user-login-info-bg text-center' },
            { 'data': 'formatted_responded_average', 'className': 'report-user-login-info-bg text-center' },
            { 'data': 'formatted_language_average', 'className': 'report-user-login-info-bg text-center' },
            { 'data': 'formatted_issue_average', 'className': 'report-user-login-info-bg text-center' },
            { 'data': 'formatted_satisfaction_average', 'className': 'report-user-login-info-bg text-center' },
            { 'data': 'formatted_overall_average', 'className': 'report-user-login-info-bg text-center datatable_border_right' },
            { 'data': 'formatted_emails_responded_count', 'className': 'report-email-info-bg text-center' },
            { 'data': 'formatted_average_response_time', 'className': 'report-email-info-bg text-center' },
        ]);

    }

    if (category != undefined && category == 'classified_email') {

        reportBlockId = "classification-email-report";

        columnFields.push(...[
            { 'data': 'formatted_date', 'className': 'text-center datatable_border_right' },
            { 'data': 'positive', 'className': 'report-email-info-bg text-center' },
            { 'data': 'netural', 'className': 'report-email-info-bg text-center' },
            { 'data': 'negative', 'className': 'report-email-info-bg text-center' },
        ]);

    }

    if ($.fn.DataTable.isDataTable(gridSelector)) {

        $(gridSelector).DataTable().clear().destroy();

    }

    $.fn.dataTable.ext.errMode = 'none';

    var buttonCommon = {
        exportOptions: {
            format: {
                body: function(data, row, column, node) {

                    return data;

                    /* return column === 5 ?
                        data.replace(/[$,]/g, '') :
                        data; */
                    /* if (data.indexOf('<i class="fa fa-star font-20')) {

                        data.replace('<i class="fa fa-star font-20', '');
                        data.replace('"></i>"', '');
                        data.split('=')[1];

                    }

                    if (data.indexOf('<span class="badge')) {

                        data.replace('<span class="badge', '');
                        data.replace('</span>', '');
                        data.split('>')[1];

                    } */

                }
            }
        }
    };

    var reportTable = $(gridSelector).DataTable({
        // dom: 'Bfrtip',
        dom: 'lBrtip',
        retrieve: true,
        processing: true,
        serverSide: true,
        ordering: false,
        paging: false,
        autoWidth: false,
        scrollY: '60vh',
        scrollX: true,
        scrollCollapse: true,
        initComplete: function(settings, json) {
            $('.dataTables_scrollBody thead tr').css({ visibility: 'collapse' });
        },
        drawCallback: function(settings) {
            $('.dataTables_scrollBody thead tr').css({ visibility: 'collapse' });
        },
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
            /* $.extend(true, {}, buttonCommon, {
                extend: 'copyHtml5'
            }), */
            $.extend(true, {}, buttonCommon, {
                extend: 'excelHtml5',
                text: 'Download'
            }),
            /* $.extend(true, {}, buttonCommon, {
                extend: 'pdfHtml5'
            }) */
        ],
        /* buttons: [
            { extend: 'excel', text: 'Download' }
        ], */

        /* AJAX call to get list */
        ajax: {
            url: listUrl,
            type: 'POST',
            // data: [],
            data: function(d) {
                return $.extend({}, d, {
                    'filter_option': {
                        'range': $('#' + reportBlockId + ' .report-datepicker').val(),
                        'report_type': $('#' + reportBlockId + ' .report-type').val(),
                        'user_empcode': $('#' + reportBlockId + ' .user-empcode').val(),
                    },
                    'category': $(gridSelector).attr('data-category'),
                });
            },
            dataType: "json",
            dataSrc: function(response) {

                if (response.success == "true") {

                    if (response.data != '') {

                        if ('totallist' in response.data) {

                            if ('numberofpm' in response.data.totallist) {

                                $('.pm_total').html(response.data.totallist.numberofpm);

                            }

                            if ('notset' in response.data.totallist) {

                                $('.noset_total').html(response.data.totallist.notset);

                            }

                            if ('positive' in response.data.totallist) {

                                $('.positive_total').html(response.data.totallist.positive);

                            }

                            if ('neutral' in response.data.totallist) {

                                $('.neutral_total').html(response.data.totallist.neutral);

                            }

                            if ('negative' in response.data.totallist) {

                                $('.negative_total').html(response.data.totallist.negative);

                            }

                            if ('unresponded_count' in response.data.totallist) {

                                $('.emails_unresponded_total').html(response.data.totallist.unresponded_count);

                            }

                            if ('responded_count' in response.data.totallist) {

                                $('.emails_responded_total').html(response.data.totallist.responded_count);

                            }

                            if ('avg' in response.data.totallist) {

                                $('.average_response_time_total').html(response.data.totallist.avg);

                            }

                            return response.data.list;

                        }

                        return response.data;

                    } else {

                        return [];

                    }

                } else {

                    return [];

                }

                return [];

            }

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

    /* if ($('#' + reportBlockId + ' .report-datepicker') != undefined) {

        // $('.report-datepicker').val('');

    }

    $('#' + reportBlockId + ' .report-datepicker').on('apply.daterangepicker', function(ev, picker) {

        if (reportTable != undefined && reportTable != null) {

            // $('.report-datepicker').attr('from', picker.startDate.format('YYYY-MM-DD'));
            // $('.report-datepicker').attr('to', picker.endDate.format('YYYY-MM-DD'));

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

    }); */

    $('#' + reportBlockId + ' .report-filter-sumbit-btn').on('click', function(e) {

        e.preventDefault();

        if (reportTable != undefined && reportTable != null) {

            reportTable.draw();

        }

    });

    /*if (reportTable != undefined && reportTable != null) {

    	reportTable.columns.adjust();

    }*/

    if ($.fn.DataTable.isDataTable(gridSelector)) {

        $(gridSelector).DataTable().columns.adjust();

    }

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

$('.external-email-report-grid tbody').slimscroll({
    height: '520px',
    alwaysVisible: 'true',
});

$('.reviewed-email-report-grid tbody').slimscroll({
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

    // var gridSelector = "#summary-report-grid";

    var gridSelector = "#classified-email-report-grid";

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

$(document).on('click', '#externalEmailReportTab', function(e) {

    var gridSelector = "#external-email-report-grid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $('.pm_total').html('');
        $('.noset_total').html('');
        $('.positive_total').html('');
        $('.neutral_total').html('');
        $('.negative_total').html('');
        $('.emails_unresponded_total').html('');
        $('.emails_responded_total').html('');
        $('.average_response_time_total').html('');

        getSummaryReportTableList(gridSelector);

    }

});

$(document).on('click', '#reviewedEmailReportTab', function(e) {

    var gridSelector = "#reviewed-email-report-grid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        /* $('.pm_total').html('');
        $('.noset_total').html('');
        $('.positive_total').html('');
        $('.neutral_total').html('');
        $('.negative_total').html('');
        $('.emails_responded_total').html('');
        $('.average_response_time_total').html(''); */

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

    // field.push({
    //     title: "PM NAME",
    //     name: "empcode",
    //     type: "text",
    //     filtering: false,
    //     sorting: false,
    //     // width: 40,
    // });

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

$('.responded-email-grid .jsgrid-grid-body').slimscroll({
    height: '490px',
    alwaysVisible: 'true',
});

$(document).on('click', '.reviewed-report-mail-list', function(e) {

    $('.email-detail-body').hide();
    $('.email-list-body').show();

    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        var dateRange = $(this).attr('data-range');

        var userEmpcode = $(this).attr('data-empcode');

        var sortType = $(this).attr('data-sort-type');

        var sortLimit = $(this).attr('data-sort-limit');

        $(gridSelector).attr('data-empcode', '');
        $(gridSelector).attr('data-date-range', '');

        $(gridSelector).attr('data-sort-type', '');
        $(gridSelector).attr('data-sort-limit', '');

        if (userEmpcode != undefined && userEmpcode != '') {

            $(gridSelector).attr('data-empcode', userEmpcode);

        }

        if (dateRange != undefined && dateRange != '') {

            $(gridSelector).attr('data-date-range', dateRange);

        }

        if (sortType != undefined && sortType != '') {

            $(gridSelector).attr('data-sort-type', sortType);

        }

        if (sortLimit != undefined && sortLimit != '') {

            $(gridSelector).attr('data-sort-limit', sortLimit);

        }

        getEmailTableList(gridSelector);

        $('.reviewed-email-list-modal').modal('show');

    }

});

function respondedEmailTableList(gridSelector) {

    var gridType = $(gridSelector).attr('data-type');
    var gridCategory = $(gridSelector).attr('data-category');
    var gridEmailFilter = $(gridSelector).attr('data-email-filter');
    var listUrl = $(gridSelector).attr('data-list-url');
    var currentRoute = $(gridSelector).attr('data-current-route');
    var empcode = $(gridSelector).attr('data-empcode');
    var dateRange = $(gridSelector).attr('data-date-range');
    var pageSize = $('#currentUserInfo').attr('data-page-size');

    var insertControlVisible = false;
    var editControlVisible = false;
    var deleteControlVisible = false;

    var dbClients = "";

    var field = [];

    /* field.push({
        title: "S.NO",
        name: "s_no",
        type: "number",
        inserting: false,
        filtering: false,
        sorting: false,
        editing: false,
        width: 20,
    }); */

    /* field.push({
        title: "PM NAME",
        name: "pmname_link",
        type: "text",
        filtering: false,
        sorting: false,
        // width: 40,
    }); */

    field.push({
        title: "TO",
        name: "formatted_email_to",
        type: "text",
        filtering: false,
        sorting: false,
        // width: 40,
    });

    field.push({
        title: "SUBJECT",
        name: "subject_link",
        type: "text",
        filtering: false,
        sorting: false,
        // width: 40,
    });

    field.push({
        title: "MESSAGE PREVIEW",
        name: "formatted_message_start",
        type: "text",
        filtering: false,
        sorting: false,
        // width: 40,
    });

    field.push({
        title: "SENT DATE TIME",
        name: "formatted_email_sent_date",
        type: "text",
        filtering: false,
        sorting: false,
        // width: 40,
    });

    field.push({
        title: "PARENT EMAIL RECEIVED DATE TIME",
        name: "formatted_parent_email_received_date",
        type: "text",
        filtering: false,
        sorting: false,
        // width: 40,
    });

    field.push({
        title: "RESPONSE TIME",
        name: "formatted_response_time",
        type: "text",
        filtering: false,
        sorting: false,
        width: 75,
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

                $(gridSelector).jsGrid('option', 'data', []);

                $('.responded-email-count').html('');

                var d = $.Deferred();

                var respondedEmailPostData = {};

                respondedEmailPostData.filter = filter

                if (empcode != undefined && empcode != '') {

                    respondedEmailPostData.empcode = empcode;

                }

                if (dateRange != undefined && dateRange != '') {

                    respondedEmailPostData.range = dateRange;

                }

                if (gridCategory != undefined && gridCategory != '') {

                    respondedEmailPostData.email_category = gridCategory;

                }

                if (gridEmailFilter != undefined && gridEmailFilter != '') {

                    respondedEmailPostData.email_filter = gridEmailFilter;

                }

                /* AJAX call to get list */
                $.ajax({

                    url: listUrl,
                    data: respondedEmailPostData,
                    dataType: "json",
                    beforeSend: function() {
                        $('.responded_emaillist_loader').show();
                    },
                    complete: function() {
                        $('.responded_emaillist_loader').hide();
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

                                    $('.responded-email-count').html('(' + resultCount + ')');

                                }


                            }

                            $('.responded-email-grid .jsgrid-grid-body').slimscroll({
                                height: '490px',
                                alwaysVisible: 'true',
                            });

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

$(document).on('click', '.responded-email-list', function(e) {

    $('.email-detail-body').hide();
    $('.email-list-body').show();

    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        var dateRange = $(this).attr('data-range');

        var userEmpcode = $(this).attr('data-empcode');

        $(gridSelector).attr('data-empcode', '');
        $(gridSelector).attr('data-date-range', '');

        if (userEmpcode != undefined && userEmpcode != '') {

            $(gridSelector).attr('data-empcode', userEmpcode);

        }

        if (dateRange != undefined && dateRange != '') {

            $(gridSelector).attr('data-date-range', dateRange);

        }

        respondedEmailTableList(gridSelector);

        $('.responded-email-list-modal').modal('show');

    }

});