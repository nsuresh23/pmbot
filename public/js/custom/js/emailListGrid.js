// $(function() {

function newTaskAdd(selector) {

    // if (gridType == 'detail') {

    var jobId = $(selector).attr('data-current-job-id');
    var gridType = $(selector).attr('data-category');
    var currentRoute = $(selector).attr('data-current-route');

    var url = $(selector).attr('data-add-url');

    if (gridType != undefined && gridType != '') {

        url = url + "?type=" + gridType;

    }

    if (jobId != undefined && jobId != '') {

        url = url + "&job_id=" + jobId;

    }

    if (currentRoute != undefined && currentRoute != '') {

        url = url + "&redirectTo=" + currentRoute;

    }

    window.location = url;


    // }

}

function getEmailTableList(gridSelector) {

    var gridType = $(gridSelector).attr('data-type');
    var gridCategory = $(gridSelector).attr('data-category');
    var gridEmailFilter = $(gridSelector).attr('data-email-filter');
    var gridEmailLabel = $(gridSelector).attr('data-email-label');
    var currentUserId = $(gridSelector).attr('data-current-user-id');
    var currentJobId = $(gridSelector).attr('data-current-job-id');
    var listUrl = $(gridSelector).attr('data-list-url');
    var currentRoute = $(gridSelector).attr('data-current-route');
    var readOnlyUser = $('#currentUserInfo').attr('data-read-only-user');

    var insertControlVisible = false;
    var editControlVisible = false;
    var deleteControlVisible = false;

    var dbClients = "";

    if ($(gridSelector + ' .jsgrid-grid-header').attr('class') == undefined) {

        $(gridSelector).jsGrid({

            height: "450px",
            width: "100%",

            filtering: false,
            inserting: insertControlVisible,
            editing: editControlVisible,
            sorting: true,
            paging: false,
            autoload: false,

            pageSize: 10,
            pageButtonCount: 5,

            // deleteConfirm: "Do you really want to delete the client?",

            confirmDeleting: false,

            noDataContent: "No data",

            invalidNotify: function(args) {

                $('#alert-error-not-submit').removeClass('hidden');

            },

            loadIndication: true,
            // loadIndicationDelay: 500,
            loadMessage: "Please, wait...",
            loadShading: true,

            controller: {

                loadData: function(filter) {

                    return $.grep(dbClients, function(client) {
                        return (!filter.created_date || (client.created_date != undefined && client.created_date != null && (client.created_date.toLowerCase().indexOf(filter.created_date.toLowerCase()) > -1))) &&
                            // (!filter.status_text || (client.status_text != undefined && client.status_text != null && (client.status_text.toLowerCase().indexOf(filter.status_text.toLowerCase()) > -1))) &&
                            (!filter.subject_link || (client.subject_link != undefined && client.subject_link != null && (client.subject_link.toLowerCase().indexOf(filter.subject_link.toLowerCase()) > -1))) &&
                            (!filter.email_from || (client.email_from != undefined && client.email_from != null && (client.email_from.toLowerCase().indexOf(filter.email_from.toLowerCase()) > -1))) &&
                            (!filter.email_to || (client.email_to != undefined && client.email_to != null && (client.email_to.toLowerCase().indexOf(filter.email_to.toLowerCase()) > -1))) &&
                            (!filter.message_start || (client.message_start != undefined && client.message_start != null && (client.message_start.toLowerCase().indexOf(filter.message_start.toLowerCase()) > -1)));
                        // (!filter.message || (client.message != undefined && client.message != null && (client.message.toLowerCase().indexOf(filter.message.toLowerCase()) > -1)));
                        // (!filter.message || (client.message != undefined && client.message != null && (client.message.toLowerCase().indexOf(filter.message.toLowerCase()) > -1))) &&
                        // (!filter.email_cc || (client.email_cc != undefined && client.email_cc != null && (client.email_cc.toLowerCase().indexOf(filter.email_cc.toLowerCase()) > -1))) &&
                        // (!filter.priority || (client.priority != undefined && client.priority != null && (client.priority.toLowerCase().indexOf(filter.priority.toLowerCase()) > -1))) &&
                        // (!filter.score || (client.score != undefined && client.score != null && (client.score.toLowerCase().indexOf(filter.score.toLowerCase()) > -1)));
                    });

                }
            },


            rowClass: function(item, itemIndex) {

                var rowClassName = '';

                if (item.view != undefined && item.view == '0') {

                    rowClassName = 'notification-unread-color';

                }

                return rowClassName;

            },

            rowClick: function(args) {

                $(gridSelector).jsGrid("cancelEdit");

            },

        });

    }

    var field = [];

    // field.push({
    //     title: "S.NO",
    //     name: "s_no",
    //     type: "number",
    //     inserting: false,
    //     filtering: false,
    //     editing: false,
    //     width: 50
    // });

    // field.push({
    //     title: "ID",
    //     name: "id",
    //     type: "text",
    //     inserting: false,
    //     editing: false,
    //     visible: false,
    // });



    if (gridEmailFilter != undefined && gridEmailFilter != '' && gridEmailFilter == 'sent') {
        field.push({
            title: "TO",
            name: "email_to",
            type: "text",
        });
    } else {
        field.push({
            title: "FROM",
            name: "email_from",
            type: "text",
        });
    }

    field.push({
        title: "",
        name: "is_priority",
        type: "text",
        filtering: false,
        width: 10,
    });

    field.push({
        title: "SUBJECT",
        name: "subject_link",
        type: "text",
    });

    // field.push({
    //     title: "STATUS",
    //     name: "status_text",
    //     type: "text",
    //     width: 20,
    // });

    field.push({
        title: "MESSAGE PREVIEW",
        name: "message_start",
        type: "text",
    });

    // field.push({
    //     title: "MESSAGE",
    //     name: "message",
    //     type: "text",
    // });

    field.push({
        title: "",
        name: "is_attachments",
        type: "text",
        filtering: false,
        width: 10,
    });

    field.push({
        title: "DATE",
        name: "created_date",
        type: "text",
        width: 50,
    });

    // field.push({
    //     title: "TO",
    //     name: "email_to",
    //     type: "text",
    // });

    // field.push({
    //     title: "CC",
    //     name: "email_cc",
    //     type: "text",
    // });

    // field.push({
    //     title: "PRIORITY",
    //     name: "priority",
    //     type: "text",
    // });

    // field.push({
    //     title: "SCORE",
    //     name: "score",
    //     type: "text",
    // });

    field.push({
        type: "control",
        name: "Control",
        editButton: editControlVisible,
        deleteButton: deleteControlVisible,
        headerTemplate: function() {

            return this._createOnOffSwitchButton("filtering", this.searchModeButtonClass, false);

        },
        width: 10,
    });

    $(gridSelector).jsGrid("option", "fields", field);

    var emailListPostData = {};

    var emailFilter = '';

    // var status = ['0', '1'];
    var status = ['0'];

    emailListPostData.type = 'pmbot';

    if (gridEmailFilter != undefined && gridEmailFilter != '') {

        emailListPostData.email_filter = gridEmailFilter;

        emailFilter = gridEmailFilter;

    }

    if (gridCategory != undefined && gridCategory != '') {

        emailListPostData.email_type = gridCategory;

        // if (emailFilter == 'draft') {

        //     status = ['4'];

        // }

        // if (emailFilter == 'outbox') {

        //     status = ['5'];

        // }

        // if (emailFilter == 'sent') {

        //     status = ['6'];

        // }

        if (gridCategory == 'nonBusinessEmail') {

            status = ['3'];

            if (emailFilter == 'draft') {

                status = ['4'];

            }

            if (emailFilter == 'outbox') {

                status = ['5'];

            }

            if (emailFilter == 'sent') {

                status = ['6'];

            }

            if (emailFilter == 'error') {

                status = ['99'];

            }

            emailListPostData.type = 'non_pmbot';

        }

        if (gridCategory == 'businessEmail') {

            status = ['1'];

            if (emailFilter == 'draft') {

                status = ['4'];

            }

            if (emailFilter == 'outbox') {

                status = ['5'];

            }

            if (emailFilter == 'sent') {

                status = ['6'];

            }

            if (emailFilter == 'error') {

                status = ['99'];

            }

            emailListPostData.type = 'generic';

        }

    }

    // if (gridEmailFilter != undefined && gridEmailFilter != '') {

    //     emailListPostData.email_filter = gridEmailFilter;

    // }

    if (gridType == 'jobDetail') {

        status = ['2'];


        if (emailFilter == 'draft') {

            status = ['4'];

        }

        if (emailFilter == 'outbox') {

            status = ['5'];

        }


        if (emailFilter == 'sent') {

            status = ['6'];

        }

        if (emailFilter == 'error') {

            status = ['99'];

        }

        if (currentJobId != undefined && currentJobId != '') {

            emailListPostData.job_id = currentJobId;

        }

    }

    emailListPostData.status = status;

    if (gridEmailLabel != undefined && gridEmailLabel != '') {

        emailListPostData.label_name = gridEmailLabel;

        delete emailListPostData.email_filter;
        delete emailListPostData.status;

    }

    $('.email-inbox-unread-count').html('');
    $('.email-result-count').html('');
    $('.email-last-updated').html('-');

    /* AJAX call to get list */
    $.ajax({

        url: listUrl,
        data: emailListPostData,
        dataType: "json"

    }).done(function(response) {

        if (response.success == "true") {

            response.data = formatDataItem(response.data);

            dbClients = response.data;

            // response.unread_count = '6669';

            $(gridSelector).jsGrid("option", "data", response.data);

            // $('.jsgrid-grid-body').slimscroll({
            //     height: '300px',
            // });

            if (gridSelector == '.nonBusinessEmailGrid') {

                $('.nonBusinessEmailGrid .jsgrid-grid-body').slimscroll({
                    height: '520px',
                });

                $('.nonBusinessEmails .email-inbox-nav').slimscroll({
                    height: '520px',
                });

            } else {

                $('.jsgrid-grid-body').slimscroll({
                    height: '300px',
                });

            }

            if ('result_count' in response) {

                // $(gridSelector).parent().prev().find('.result-count').html('(' + response.result_count + ')');
                // $(gridSelector).parent().prev().find('.result-count').addClass('result-count-icon-badge');

                $('.email-result-count').html('(' + response.result_count + ')');

            }

            if ('last_updated' in response) {

                $('.email-last-updated').html(response.last_updated);

            }

            if ('unread_count' in response && emailFilter == 'unread') {

                var unreadCount = response.unread_count;

                if (parseInt(unreadCount) != NaN && parseInt(unreadCount) > 0) {

                    if (parseInt(unreadCount) > 99) {

                        unreadCount = '99+'

                    }

                    $('.email-inbox-unread-count').html(unreadCount);

                }

            }

            // } else {

            //     // $(gridSelector).parent().prev().find('.result-count').html('');
            //     // $(gridSelector).parent().prev().find('.result-count').removeClass('result-count-icon-badge');

            //     $('.email-result-count').html('');

            // }

        }

        // } else {

        //     // $(gridSelector).parent().prev().find('.result-count').html('');
        //     // $(gridSelector).parent().prev().find('.result-count').removeClass('result-count-icon-badge');

        //     $('.email-result-count').html('');

        // }

    });

    function formatDataItem(dataValue) {

        if (dataValue.length > 0) {

            for (var i = 0, len = dataValue.length; i < len; i++) {

                dataValue[i].s_no = i + 1;

            }

        }

        return dataValue;

    }

}

function getPmsEmailCountTableList(gridSelector) {

    var gridType = $(gridSelector).attr('data-type');
    var listUrl = $(gridSelector).attr('data-list-url');
    var currentRoute = $(gridSelector).attr('data-current-route');

    var insertControlVisible = false;
    var editControlVisible = false;
    var deleteControlVisible = false;

    var dbClients = "";

    if ($(gridSelector + ' .jsgrid-grid-header').attr('class') == undefined) {

        $(gridSelector).jsGrid({

            height: "450px",
            width: "100%",

            filtering: false,
            inserting: insertControlVisible,
            editing: editControlVisible,
            sorting: true,
            paging: false,
            autoload: false,
            autowidth: true,

            pageSize: 10,
            pageButtonCount: 5,

            // deleteConfirm: "Do you really want to delete the client?",

            confirmDeleting: false,

            noDataContent: "No data",

            invalidNotify: function(args) {

                $('#alert-error-not-submit').removeClass('hidden');

            },

            loadIndication: true,
            // loadIndicationDelay: 500,
            loadMessage: "Please, wait...",
            loadShading: true,

            controller: {

                loadData: function(filter) {

                    return $.grep(dbClients, function(client) {
                        return (!filter.empname || (client.empname != undefined && client.empname != null && (client.empname.toLowerCase().indexOf(filter.empname.toLowerCase()) > -1))) &&
                            (!filter.email_count || (client.email_count != undefined && client.email_count != null && (client.email_count.toLowerCase().indexOf(filter.email_count.toLowerCase()) > -1))) &&
                            (!filter.priority_count || (client.priority_count != undefined && client.priority_count != null && (client.priority_count.toLowerCase().indexOf(filter.priority_count.toLowerCase()) > -1))) &&
                            (!filter.critical_jobs_email_count || (client.critical_jobs_email_count != undefined && client.critical_jobs_email_count != null && (client.critical_jobs_email_count.toLowerCase().indexOf(filter.critical_jobs_email_count.toLowerCase()) > -1))) &&
                            (!filter.critical_job_count || (client.critical_job_count != undefined && client.critical_job_count != null && (client.critical_job_count.toLowerCase().indexOf(filter.critical_job_count.toLowerCase()) > -1))) &&
                            (!filter.last_annotated_time || (client.last_annotated_time != undefined && client.last_annotated_time != null && (client.last_annotated_time.toLowerCase().indexOf(filter.last_annotated_time.toLowerCase()) > -1))) &&
                            (!filter.over_due_task_count || (client.over_due_task_count != undefined && client.over_due_task_count != null && (client.over_due_task_count.toLowerCase().indexOf(filter.over_due_task_count.toLowerCase()) > -1))) &&
                            (!filter.task_count || (client.task_count != undefined && client.task_count != null && (client.task_count.toLowerCase().indexOf(filter.task_count.toLowerCase()) > -1))) &&
                            (!filter.last_processed_time || (client.last_processed_time != undefined && client.last_processed_time != null && (client.last_processed_time.toLowerCase().indexOf(filter.last_processed_time.toLowerCase()) > -1)));
                    });

                }
            },

            rowClick: function(args) {

                $(gridSelector).jsGrid("cancelEdit");

            },

        });

    }

    var field = [];

    field.push({
        title: "S.NO",
        name: "s_no",
        type: "number",
        inserting: false,
        filtering: false,
        editing: false,
        // width: 10,
    });

    field.push({
        title: "NAME",
        name: "empname",
        type: "text",
        // width: 40,
    });

    field.push({
        title: "EMAIL COUNT",
        name: "email_count",
        type: "text",
        // width: 40,
    });

    field.push({
        title: "PRIORITY EMAIL",
        name: "priority_count",
        type: "text",
        // width: 40,
    });

    field.push({
        title: "CRITICAL EMAILS",
        name: "critical_jobs_email_count",
        type: "text",
        // width: 40,
    });



    field.push({
        title: "CRITICAL JOBS",
        name: "critical_job_count",
        type: "text",
        // width: 40,
    });

    field.push({
        title: 'LAST ANNOTATED TIME',
        name: 'last_annotated_time',
        type: 'text',
        width: 110,
    });

    field.push({
        title: "TASK COUNT",
        name: "task_count",
        type: "text",
        // width: 40,
    });

    field.push({
        title: "OVER DUE TASK COUNT",
        name: "over_due_task_count",
        type: "text",
        // width: 40,
    });

    field.push({
        title: 'LAST PROCEESED TIME',
        name: 'last_processed_time',
        type: 'text',
        width: 110,
    });

    field.push({
        type: "control",
        name: "Control",
        editButton: editControlVisible,
        deleteButton: deleteControlVisible,
        headerTemplate: function() {

            return this._createOnOffSwitchButton("filtering", this.searchModeButtonClass, false);

        },
        width: 70,
    });

    $(gridSelector).jsGrid("option", "fields", field);

    var pmsEmailCountPostData = {};

    /* AJAX call to get list */
    $.ajax({

        url: listUrl,
        data: pmsEmailCountPostData,
        dataType: "json"

    }).done(function(response) {

        if (response.success == "true") {

            response.data = formatDataItem(response.data);

            dbClients = response.data;

            $(gridSelector).jsGrid("option", "data", response.data);

            $('.jsgrid-grid-body').slimscroll({
                height: '300px',
            });

        }

    });

    function formatDataItem(dataValue) {

        if (dataValue.length > 0) {

            for (var i = 0, len = dataValue.length; i < len; i++) {

                dataValue[i].s_no = i + 1;

            }

        }

        return dataValue;

    }

}


function findBrowser() {

    var navUserAgent = navigator.userAgent;
    var browserName = navigator.appName;
    var browserVersion = '' + parseFloat(navigator.appVersion);
    var majorVersion = parseInt(navigator.appVersion, 10);
    var tempNameOffset, tempVersionOffset, tempVersion;

    if ((tempVersionOffset = navUserAgent.indexOf("Opera")) != -1) {
        browserName = "Opera";
        browserVersion = navUserAgent.substring(tempVersionOffset + 6);
        if ((tempVersionOffset = navUserAgent.indexOf("Version")) != -1)
            browserVersion = navUserAgent.substring(tempVersionOffset + 8);
    } else if ((tempVersionOffset = navUserAgent.indexOf("MSIE")) != -1) {
        browserName = "Microsoft Internet Explorer";
        browserVersion = navUserAgent.substring(tempVersionOffset + 5);
    } else if ((tempVersionOffset = navUserAgent.indexOf("Chrome")) != -1) {
        browserName = "Chrome";
        browserVersion = navUserAgent.substring(tempVersionOffset + 7);
    } else if ((tempVersionOffset = navUserAgent.indexOf("Safari")) != -1) {
        browserName = "Safari";
        browserVersion = navUserAgent.substring(tempVersionOffset + 7);
        if ((tempVersionOffset = navUserAgent.indexOf("Version")) != -1)
            browserVersion = navUserAgent.substring(tempVersionOffset + 8);
    } else if ((tempVersionOffset = navUserAgent.indexOf("Firefox")) != -1) {
        browserName = "Firefox";
        browserVersion = navUserAgent.substring(tempVersionOffset + 8);
    } else if ((tempNameOffset = navUserAgent.lastIndexOf(' ') + 1) < (tempVersionOffset = navUserAgent.lastIndexOf('/'))) {
        browserName = navUserAgent.substring(tempNameOffset, tempVersionOffset);
        browserVersion = navUserAgent.substring(tempVersionOffset + 1);
        if (browserName.toLowerCase() == browserName.toUpperCase()) {
            browserName = navigator.appName;
        }
    }

    // trim version
    if ((tempVersion = browserVersion.indexOf(";")) != -1)
        browserVersion = browserVersion.substring(0, tempVersion);
    if ((tempVersion = browserVersion.indexOf(" ")) != -1)
        browserVersion = browserVersion.substring(0, tempVersion);

    return browserName;
}

var browserName = findBrowser();

var emailEditorParaTag = '<p style="margin: 0in; margin-bottom: .0001pt; font-size: 11.0pt; font-family: Calibri; color: #1F497D;"><br></p>';
var emailSignatureEditorParaTag = '<p style="margin: 0in; margin-bottom: .0001pt; font-size: 10.0pt; font-family: Arial; color: #1F497D;"><br></p>';

if (browserName == 'Firefox') {

    emailEditorParaTag = '<p style="margin: 0in; margin-bottom: .0001pt; font-size: 11.0pt; font-family: Calibri; color: #1F497D;"></p>';
    emailSignatureEditorParaTag = '<p style="margin: 0in; margin-bottom: .0001pt; font-size: 10.0pt; font-family: Arial; color: #1F497D;"></p>';

}

var gridSelector = ".myEmailGrid";

var dataUrl = $(gridSelector).attr('data-list-url');

if (dataUrl != undefined && dataUrl != "") {

    // $(".dashboard-inbox-email").trigger('click');

    getEmailTableList(gridSelector);

}

var jobEmailgridSelector = '.jobEmailGrid';

var jobEmailgridUrl = $(jobEmailgridSelector).attr('data-list-url');

if (jobEmailgridUrl != undefined && jobEmailgridUrl != "") {

    getEmailTableList(jobEmailgridSelector);

}

var pmsEmailCountGridSelector = '.pmsEmailCountGrid';

var pmsEmailCountGridUrl = $(pmsEmailCountGridSelector).attr('data-list-url');

if (pmsEmailCountGridUrl != undefined && pmsEmailCountGridUrl != "") {

    getPmsEmailCountTableList(pmsEmailCountGridSelector);

}

$(document).on('click', '.amEmailListTab', function() {

    var gridSelector = ".pmsEmailCountGrid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        getPmsEmailCountTableList(gridSelector);

    }

});

/*$(document).on('click', '.email-item', function(e) {

    e.preventDefault();

    var emailItemPostData = {};

    var itemUrl = $(this).attr('href');

    if (itemUrl != undefined && itemUrl != '') {

        // AJAX call to email item info
       // $.ajax({

        //     url: itemUrl,
        //     data: emailItemPostData,
        //     dataType: "json"

        // }).done(function(response) {

        //     if (response.success == "true") {}
        // });

        $('.email-list-body').hide();
       $('.email-detail-body').show();

    }

});*/

$(document).on('click', '.job-unmark-btn', function(e) {

    e.preventDefault();

    Swal.fire({

        title: 'Are you sure?',
        text: "Do you want to un-associate this email from this job? If yes, then it will delete all the task related to this email!",
        // icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        showClass: {
            popup: 'animated slideInDown'
        },
        hideClass: {
            popup: 'animated fadeOut faster'
        },

    }).then((result) => {

        if (result.value != undefined && result.value == true) {

            jobEmailUnmark();

        }

    });

});


function jobEmailUnmark() {

    var emailPostData = {};

    var postUrl = $('.job-unmark-btn').attr('data-email-status-update-url');
    var emailId = $('.email-title').attr('data-email-id');
    var jobId = $('.job-unmark-btn').attr('data-job-id');

    if (jobId != undefined && jobId != '' && emailId != undefined && emailId != '' && postUrl != undefined && postUrl != '') {

        emailPostData.id = emailId;
        emailPostData.job_id = jobId;
        emailPostData.type = 'pmbot';
        emailPostData.status = '0';

        var type = 'error';

        var message = '';

        var d = $.Deferred();

        // AJAX call to email status update
        $.ajax({

            url: postUrl,
            data: emailPostData,
            dataType: "json"

        }).done(function(response) {

            if (response.success == "true") {

                type = 'success';

            } else {

                type = 'error';

                d.resolve();

            }

            if (response.message != undefined && response.message != '') {

                message = response.message;

            }

            flashMessage(type, message);

            if (response.redirectTo != undefined && response.redirectTo != '') {

                window.location = response.redirectTo;

            }

        });

        return d.promise();

    }

}

$(document).on('click', '.non-business-unmark-btn', function(e) {

    e.preventDefault();

    var emailPostData = {};

    var postUrl = $(this).attr('data-email-status-update-url');
    var emailId = $('.email-title').attr('data-email-id');

    if (emailId != undefined && emailId != '' && postUrl != undefined && postUrl != '') {

        emailPostData.id = emailId;
        emailPostData.type = 'pmbot';
        emailPostData.status = '0';

        var type = 'error';

        var message = '';

        var d = $.Deferred();

        // AJAX call to email status update
        $.ajax({

            url: postUrl,
            data: emailPostData,
            dataType: "json"

        }).done(function(response) {

            if (response.success == "true") {

                type = 'success';

            } else {

                type = 'error';

                d.resolve();

            }

            if (response.message != undefined && response.message != '') {

                message = response.message;

            }

            flashMessage(type, message);

            if (response.redirectTo != undefined && response.redirectTo != '') {

                window.location = response.redirectTo;

            }

        });

        return d.promise();

    }

});

$(document).on('click', '.pmbot-email-item', function(e) {

    e.preventDefault();

    var emailItemPostData = {};

    var emailId = $(this).attr('data-email-id');
    var postUrl = $(this).attr('data-email-geturl');

    if (emailId != undefined && emailId != '' && postUrl != undefined && postUrl != '') {

        emailItemPostData.emailid = emailId;
        emailItemPostData.view = '1';

        $('.email-title').attr('data-email-id', '');

        $('.non-business-unmark-btn-block').hide();

        $('.job-unmark-btn-block').hide();
        $('.job-unmark-btn').attr('data-job-id', '');

        $('.email-annotator-link').attr('href', 'javascript:void(0);');
        $('.email-annotator-link-block').hide();
        $('.email-draftbutton-group').hide();

        $('.email-move-to-block').hide();
        $('.email-move-to-email-id').val('');
        $('.email-move-to-input').select2().val('').trigger('change');
        $('.email-move-to-input').select2({ data: [] });

        $('.email-title').html('');
        $('.email-title-block').hide();

        $('.email-from').html('');
        $('.email-from-block').hide();

        $('.email-to').html('');
        $('.email-to-block').hide();

        $('.email-cc').html('');
        $('.email-cc-block').hide();

        $('.email-bcc').html('');
        $('.email-bcc-block').hide();

        $('.email-date').html('');
        $('.email-date-block').hide();

        $('.email-body').html();
        $('.email-body-block').hide();

        $('.attachment-count').html('');
        $('.attachment-items').html('');
        $('.attachment-block').hide();

        $('.email-button-group').show();

        $.ajax({

            url: postUrl,
            data: emailItemPostData,
            dataType: 'json',
            type: 'POST',

        }).done(function(response) {

            //alert("test0");

            if (response.success == "true") {

                //alert("test");
                if (response.data != undefined && response.data != '') {

                    //alert("test1");

                    if (response.data != undefined && response.data != '') {

                        //alert("test2");

                        if (response.data.id != undefined && response.data.id != '') {

                            $('.email-title').attr('data-email-id', response.data.id);
                            $('.email-move-to-email-id').val(response.data.id);

                        }

                        if (response.data.status != undefined && response.data.status == '5') {

                            //$('.email-title').attr('data-email-id', response.data.id);
                            $('.email-button-group').hide();

                        }

                        if (response.data.status != undefined && response.data.status == '4') {

                            $('.email-button-group').hide();
                            $('.email-draftbutton-group').show();

                        }

                        if (response.data.type != undefined && response.data.type == 'non_pmbot') {

                            $('.non-business-unmark-btn-block').show();
                            $('.email-move-to-block').show();

                        }

                        if (response.data.type != undefined && response.data.type == 'pmbot') {

                            if (response.data.job_id != undefined && response.data.job_id != '' && response.data.status == '2') {

                                $('.job-unmark-btn').attr('data-job-id', response.data.job_id);

                                $('.job-unmark-btn-block').show();

                            }

                        }


                        if (response.data.email_annotator_link != undefined && response.data.email_annotator_link != '') {

                            $('.email-annotator-link').attr('href', response.data.email_annotator_link);
                            $('.email-annotator-link-block').show();

                        }

                        if (response.data.subject != undefined && response.data.subject != '') {

                            // $('.email-title').html(atob(response.data.subject));

                            $('.email-title').html(response.data.subject);
                            //$('.email-title').html("Special Day Wishes");

                            $('.email-title-block').show();

                        }

                        if (response.data.email_from != undefined && response.data.email_from != '') {

                            $('.email-from').html(response.data.email_from);
                            $('.email-from-block').show();

                        }

                        if (response.data.email_to != undefined && response.data.email_to != '') {

                            $('.email-to').html(response.data.email_to);
                            $('.email-to-block').show();

                        }

                        if (response.data.email_cc != undefined && response.data.email_cc != '') {

                            $('.email-cc').html(response.data.email_cc);
                            $('.email-cc-block').show();

                        }

                        if (response.data.email_bcc != undefined && response.data.email_bcc != '') {

                            $('.email-bcc').html(response.data.email_bcc);
                            $('.email-bcc-block').show();

                        }

                        if (response.data.create_date_formatted_text != undefined && response.data.create_date_formatted_text != '') {

                            $('.email-date').html(response.data.create_date_formatted_text);
                            $('.email-date-block').show();

                        }

                        if (response.data.body_html != undefined && response.data.body_html != '') {

                            // $('.email-body').html(atob(response.data.body_html));
                            $('.email-body').html(response.data.body_html);
                            $('.email-body-block').show();

                        }

                        // if (response.label_list != undefined && response.label_list != '') {
                        if (response.label_list != undefined && response.label_list != '') {

                            $('.email-move-to-input').select2({ data: response.label_list });

                        }

                        if (response.data.label_name != undefined && response.data.label_name != '') {

                            $('.email-move-to-input').select2().val(response.data.label_name).trigger('change');

                        }

                        if (response.data.email_attachment_count != undefined && response.data.email_attachment_count != '') {

                            $('.attachment-count').html(response.data.email_attachment_count);

                            if (response.data.email_attachment_html != undefined && response.data.email_attachment_html != '') {

                                $('.attachment-items').html(response.data.email_attachment_html);

                            }

                            $('.attachment-block').show();

                        }

                    }


                }
            }
        });

        /* AJAX call to email item info */
        // $.ajax({

        //     url: itemUrl,
        //     data: emailItemPostData,
        //     dataType: "json"

        // }).done(function(response) {

        //     if (response.success == "true") {}
        // });

        $('.email-list-body').hide();
        $('.email-detail-body').show();

    }

});

$(document).on('click', '.email-detail-back-btn', function(e) {

    e.preventDefault();

    $('.email-list-body').show();
    $('.email-detail-body').hide();

});

$(document).on('click', '.email-move-to-btn', function(e) {

    e.preventDefault();

    var postUrl = '';
    var params = '';
    params = $('.email-move-to-form').serialize();

    postUrl = $('.email-move-to-form').attr('action');

    if (postUrl != undefined && postUrl != '') {

        if ($('.email-move-to-input').val() == null || $('.email-move-to-input').val() == '') {

            Swal.fire({

                title: '',
                text: "Invaild label!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }

        /* AJAX call to email label update info */

        var d = $.Deferred();

        $.ajax({
            url: postUrl,
            data: params,
            dataType: 'json',
            type: 'POST',
        }).done(function(response) {

            if (response.success == "true") {

                type = 'success';

            } else {

                type = 'error';

                d.resolve();

            }

            message = response.message;

            flashMessage(type, message);

            // $('.dashboard-nb-email-label').find('[data-label=" ' + $('.email-move-to-form .email-move-to-input').val() + '"]').trigger('click');

            // $('#nonBusinessEmailsTab').trigger('click');

            $('.dashboard-inbox-email').trigger('click');

        });

        return d.promise();


    }

    emailSend(postUrl, params, '#emailSendModal');

});

$(document).on('click', '.dashboard-inbox-email', function() {

    // var gridSelector = ".nonBusinessEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'inbox');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

});

$(document).on('click', '.dashboard-unread-email', function() {

    // var gridSelector = ".nonBusinessEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'unread');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

});

$(document).on('click', '.dashboard-error-email', function() {

    // var gridSelector = ".nonBusinessEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'error');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

    // $(this).closest('li').addClass('active');

});

$(document).on('click', '.dashboard-outbox-email', function() {

    // var gridSelector = ".nonBusinessEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'outbox');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

    // $(this).closest('li').addClass('active');

});

$(document).on('click', '.dashboard-sent-email', function() {

    // var gridSelector = ".nonBusinessEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'sent');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

    // $(this).closest('li').addClass('active');

});

$(document).on('click', '.dashboard-draft-email', function() {

    // var gridSelector = ".nonBusinessEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'draft');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

});

$(document).on('click', '.dashboard-nb-email-label', function() {

    // var gridSelector = ".nonBusinessEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var emailLabel = $(this).attr('data-label');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        if (emailLabel != undefined && emailLabel != "") {

            $(gridSelector).attr('data-email-label', emailLabel);

        }

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

});

$(document).on('click', '.job-inbox-email', function() {

    // var gridSelector = ".jobEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'inbox');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

});

$(document).on('click', '.job-error-email', function() {

    // var gridSelector = ".jobEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'error');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

    // $(this).closest('li').addClass('active');

});

$(document).on('click', '.job-outbox-email', function() {

    // var gridSelector = ".jobEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'outbox');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

    // $(this).closest('li').addClass('active');

});

$(document).on('click', '.job-sent-email', function() {

    // var gridSelector = ".jobEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'sent');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

    // $(this).closest('li').addClass('active');

});

$(document).on('click', '.job-draft-email', function() {

    // var gridSelector = ".jobEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'draft');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

});

$(document).on('click', '.email-send-btn-old', function(e) {

    e.preventDefault();

    $('.email-status').val('0');

    var postUrl = $('.email-send-form').attr('action');

    var params = $('.email-send-form').serialize();

    var file = $('#attachement')[0].files;

    emailSend(postUrl, params, '#emailSendModal');

});

$(document).on('click', '.email-send-btn', function(e) {

    tinymce.triggerSave(true, true);

    var type = $('.pmbottype').attr('data-pmbottype');
    $('.type').val(type);

    e.preventDefault();

    if ($('#to').val() == '') {
        $("#to").focus();
        return false;
    }
    if ($('#subject').val() == '') {
        $("#subject").focus();
        return false;
    }
    if ($('#body_html').val() == '') {
        $("#body_html").focus();
        return false;
    }

    $('.email-status').val('5');

    var postUrl = $('.email-send-form').attr('action');

    var emailfrm = $('.email-send-form');

    var params = new FormData($('.email-send-form')[0]);

    $.each($('.attachements')[0].files, function(i, file) {
        params.append('file-' + i, file);
    });



    params.delete('attachement');

    emailSend(postUrl, params, '#emailSendModal');

    //$('.email-send-form').submit();

});

$(document).on('click', '.email-save-btn', function(e) {

    tinymce.triggerSave(true, true);

    var type = $('.pmbottype').attr('data-pmbottype');
    $('.type').val(type);

    e.preventDefault();

    var subject = $('#subject').val();
    if (subject.trim() == '') {
        $("#subject").focus();
        return false;
    }

    $('.email-status').val('4');

    var postUrl = $('.email-send-form').attr('action');

    //var params = $('.email-send-form').serialize();

    var params = new FormData($('.email-send-form')[0]);

    $.each($('.attachements')[0].files, function(i, file) {
        params.append('file-' + i, file);
    });

    params.delete('attachement');

    emailSend(postUrl, params, '#emailSendModal');

});
$(document).on('click', '.email-reply-send-btn', function(e) {

    tinymce.triggerSave(true, true);

    if ($('#email-reply-to').val() == '') {
        $("#email-reply-to").focus();
        return false;
    }
    if ($('#email-reply-subject').val() == '') {
        $("#email-reply-subject").focus();
        return false;
    }
    if ($('#reply_body_html').val() == '') {
        $("#reply_body_html").focus();
        return false;
    }


    var type = $('.pmbottype').attr('data-pmbottype');
    $('.type').val(type);
    $('#email-type').val(type);

    e.preventDefault();

    $('.email-status').val('5');

    var postUrl = $('.email-reply-form').attr('action');

    // var params = $('.email-reply-form').serialize();

    var params = new FormData($('.email-reply-form')[0]);

    $.each($('.replyattachements')[0].files, function(i, file) {
        params.append('file-' + i, file);
    });

    params.delete('attachement');

    emailSend(postUrl, params, '#replymailModal');

});

$(document).on('click', '.email-reply-save-btn', function(e) {

    tinymce.triggerSave(true, true);

    var type = $('.pmbottype').attr('data-pmbottype');
    $('.type').val(type);
    $('#email-type').val(type);

    e.preventDefault();

    var subject = $('#email-reply-subject').val();
    if (subject.trim() == '') {
        $("#email-reply-subject").focus();
        return false;
    }

    $('.email-status').val('4');

    var postUrl = $('.email-reply-form').attr('action');

    //var params = $('.email-reply-form').serialize();

    var params = new FormData($('.email-reply-form')[0]);

    $.each($('.replyattachements')[0].files, function(i, file) {
        params.append('file-' + i, file);
    });

    params.delete('attachement');

    emailSend(postUrl, params, '#replymailModal');

});

$(document).on('click', '.email-draft-send-btn', function(e) {

    tinymce.triggerSave(true, true);

    var type = $('.pmbottype').attr('data-pmbottype');
    $('.type').val(type);
    $('#email-type').val(type);

    e.preventDefault();

    $('.email-status').val('5');

    var postUrl = $('.email-draft-form').attr('action');

    var params = new FormData($('.email-draft-form')[0]);

    $.each($('.draftattachements')[0].files, function(i, file) {
        params.append('file-' + i, file);
    });

    params.delete('attachement');

    emailSend(postUrl, params, '#draftymailModal');

});

$(document).on('click', '.email-draft-save-btn', function(e) {

    tinymce.triggerSave(true, true);

    var type = $('.pmbottype').attr('data-pmbottype');
    $('.type').val(type);
    $('#email-type').val(type);

    e.preventDefault();

    var subject = $('#email-draft-subject').val();
    if (subject.trim() == '') {
        $("#email-draft-subject").focus();
        return false;
    }

    $('.email-status').val('4');

    var postUrl = $('.email-draft-form').attr('action');

    var params = new FormData($('.email-draft-form')[0]);

    $.each($('.draftattachements')[0].files, function(i, file) {
        params.append('file-' + i, file);
    });

    params.delete('attachement');

    emailSend(postUrl, params, '#draftymailModal');

});

function emailSend(sendUrl, params, closeBtnSelector) {

    if (sendUrl != undefined && sendUrl != '') {

        /* AJAX call to email item info */

        var d = $.Deferred();

        $.ajax({
            url: sendUrl,
            data: params,
            dataType: 'json',
            type: 'POST',
            processData: false,
            contentType: false,
            enctype: "multipart/form-data",
        }).done(function(response) {

            if (response.success == "true") {

                type = 'success';

            } else {

                type = 'error';

                d.resolve();

            }

            message = response.message;

            flashMessage(type, message);

            if (response.redirectUrl != undefined && response.redirectUrl != '') {

                window.location = response.redirectUrl;

            }

        });

        //$(closeBtnSelector).trigger('click');
        if (closeBtnSelector == '#emailSendModal') {
            $('#to').val('');
            $('#cc').val('');
            $('#subject').val('');
            $('#body_html').val('');

            // tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, '');
            // tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, '');

            tinymce.get('textarea_editor_email_compose').setContent('');
            tinymce.get('textarea_editor_email_reply').setContent('');

            // $('#textarea_editor_email_compose').html('');
            // $('#textarea_editor_email_reply').html('');
            $('.textarea_editor_email').html('');

            // $('.compose_message').summernote('code', '');

            // var activeEditor = tinymce.activeEditor;

            // var content = '';

            // if (activeEditor !== null) {

            //     activeEditor.setContent(content);

            // } else {

            //     $('.compose_message').val(content);
            // }

        }

        $(closeBtnSelector).modal('hide');
        return d.promise();


    }
}
$(document).on('click', '.email-reply-btn', function(e) {
    e.preventDefault();
    $('.attachements').val('');
    var type = $(this).attr('data-type');
    var selector = $(this);
    $('.reply_email_type').val('reply');
    $('.signature_change').val('');
    $(".reply_to ul").empty();
    $('.email-reply-to').val('');
    $('.email-reply-cc').val('');
    $('.email-reply-bcc').val('');
    showform(type, selector);
});
$(document).on('click', '.email-reply-all-btn', function(e) {
    e.preventDefault();
    $('.attachements').val('');
    var type = $(this).attr('data-type');
    var selector = $(this);
    $('.reply_email_type').val('reply');
    $('.signature_change').val('');
    $(".reply_to ul").empty();
    $('.email-reply-to').val('');
    $('.email-reply-cc').val('');
    $('.email-reply-bcc').val('');
    showform(type, selector);
});
$(document).on('click', '.email-forward-btn', function(e) {
    e.preventDefault();
    $('.attachements').val('');
    var type = $(this).attr('data-type');
    var selector = $(this);
    $('.reply_email_type').val('forward');
    $('.signature_change').val('');
    $(".reply_to ul").empty();
    $('.email-reply-to').val('');
    $('.email-reply-cc').val('');
    $('.email-reply-bcc').val('');
    showform(type, selector);
});
$(document).on('click', '.email-draft-btn', function(e) {
    e.preventDefault();
    $('.draftattachements').val('');
    var type = $(this).attr('data-type');
    var selector = $(this);
    $('.draft_email_type').val('draft');
    $(".draft_to ul").empty();
    $(".draft_cc ul").empty();

    $(".email-draft-to").val('');
    $(".email-draft-cc").val('');

    showdraftform(type, selector);
});
/*
function showform(type, selector) {
    var emailPostData = {};
    var emailid = $('.email-title').attr('data-email-id');
    var postUrl = $(selector).attr('data-email-geturl');
    emailPostData.emailid = emailid;

    $.ajax({

        url: postUrl,
        data: emailPostData,
        dataType: 'json',
        type: 'POST',

    }).done(function(response) {
        if (response.success == "true") {
            if (response.data != undefined && response.data != '') {
                if (type == "reply" || type == "replyall") {
                    $('.email-reply-to').val(response.data.email_from);
                } else {
                    $('.email-reply-to').val('');
                }
                if (type == 'replyall') {
                    $('.email-reply-cc').val(response.data.email_cc);
                } else {
                    $('.email-reply-cc').val('');
                }
                $('.email-reply-subject').val(atob(response.data.subject));
                $('.email-reply-body_html').summernote('code', atob(response.data.body_html));
                $('.email_messageid').val(response.data.email_messageid);
                //$('.email-reply-to').val('teest');
            }
            $('.email-reply-modal').modal({
                show: 'false'
            });
            //$('.email-reply-modal').show();


        } else {

            Swal.fire({

                title: '',
                text: "Email Data Not Found!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }
    });
}
 */

function showform(type, selector) {
    var emailPostData = {};
    var emailid = $('.email-title').attr('data-email-id');
    var postUrl = $(selector).attr('data-email-geturl');

    var editor_type = 'reply';

    $('.email-reply-body_html').attr('id', 'textarea_editor_email_' + editor_type);

    if (tinymce.get('textarea_editor_email_' + editor_type) != undefined && tinymce.get('textarea_editor_email_' + editor_type) != null) {

        // tinymce.get('textarea_editor_email_' + editor_type).execCommand('mceInsertContent', false, '');

        tinymce.get('textarea_editor_email_' + editor_type).setContent('');

        // tinymce.get('textarea_editor_email_' + editor_type).execCommand('mceInsertContent', false, emailEditorParaTag);

    }

    emailPostData.emailid = emailid;
    if (type == 'replyall') {
        $('.modeltitle').html('Reply All');
    } else {
        $('.modeltitle').html(type);
    }

    $.ajax({

        url: postUrl,
        data: emailPostData,
        dataType: 'json',
        type: 'POST',

    }).done(function(response) {

        if (response.success == "true") {
            if (response.data != undefined && response.data != '') {
                var str2 = '';

                if (type == "reply" || type == "replyall") {
                    if (response.data.email_from != '' && response.data.email_from != null) {
                        var to = response.data.email_from.replace(/&quot;/g, "");
                        to = to.replace(/&quot;/g, "");
                        to = to.replace(/&lt;/g, "<");
                        to = to.replace(/&gt;/g, ">");
                        $('.email-reply-to').val(to + ';');

                    }
                    str2 = 'RE: ';
                } else {
                    $('.email-reply-to').val('');
                    str2 = 'FW: ';
                }
                if (type == 'replyall') {
                    if (response.data.email_reply_cc != '' && response.data.email_reply_cc != null) {
                        var cc = response.data.email_reply_cc.replace(/&quot;/g, "");
                        cc = cc.replace(/&quot;/g, "")
                        cc = cc.replace(/&lt;/g, "<");
                        cc = cc.replace(/&gt;/g, ">");

                        //$('.email-reply-cc').val(cc + ';');
                        $('.email-reply-cc').val(cc);
                    }
                    if (response.data.email_to != '' && response.data.email_to != null) {
                        var replyallto = response.data.email_to.replace(/&quot;/g, "");
                        replyallto = replyallto.replace(/&quot;/g, "")
                        replyallto = replyallto.replace(/&lt;/g, "<");
                        replyallto = replyallto.replace(/&gt;/g, ">");

                        var reto = $('.email-reply-to').val();

                        $('.email-reply-to').val(reto + replyallto + ';');
                    }
                    if (response.data.reply_all_to != '' && response.data.reply_all_to != null) {
                        var replyallto = response.data.reply_all_to.replace(/&quot;/g, "");
                        replyallto = replyallto.replace(/&quot;/g, "")
                        replyallto = replyallto.replace(/&lt;/g, "<");
                        replyallto = replyallto.replace(/&gt;/g, ">");

                        //var reto = $('.email-reply-to').val();

                        //$('.email-reply-to').val(reto + replyallto + ';');
                        $('.email-reply-to').val(replyallto + ';');
                    }
                    /*if (response.data.email_to != '' && response.data.email_to != null) {
						var reply_allto = response.data.email_reply_all.replace(/&quot;/g, "");
						reply_allto = reply_allto.replace(/&quot;/g, "")
						reply_allto = reply_allto.replace(/&lt;/g, "<");
						reply_allto = reply_allto.replace(/&gt;/g, ">");
                        $('.email-reply-to').val(reply_allto);
                    }*/

                } else {
                    $('.email-reply-cc').val('');
                }
                if (response.data.subject != '' && response.data.subject != null) {
                    //var subject = atob(response.data.subject);
                    var subject = response.data.subject;
                    subject = subject.replace("FW: ", "");
                    subject = subject.replace("RE: ", "");
                    subject = str2.concat(subject);
                } else {
                    var subject = '';
                }
                //var message = atob(response.data.body_html);
                var message = response.data.body_html;
                var sinmessage = '';

                if ('replyforward_signature' in response.data && response.data.replyforward_signature != '') {

                    var random = Math.random().toString(36).substring(7);
                    var sig_class = 'emailsig_block_' + random;
                    sessionStorage.setItem('signature_classname', sig_class);

                    var stamp = '<div class="' + sig_class + '">' + response.data.replyforward_signature;
                    var msg = '</div>';
                    sinmessage = stamp + msg;

                }

                //var sig = response.data.replyforward_signature;
                var sentdate = '';

                if (response.data.email_received_date != null) {
                    sentdate = response.data.email_received_date;
                } else {
                    sentdate = response.data.created_date;
                }

                var stamp = sinmessage + '<div style="font-family:calibri;font-size:11pt;"><hr><b>From:</b> ' + response.data.email_from + '<br><b>Sent:</b> ' + sentdate + '<br><b>To:</b> ' + response.data.email_to + '<br><b>Subject:</b> ' + response.data.subject + '<br><br></div>';
                message = stamp.concat(message);

                $('.email-reply-subject').val(subject);

                if (tinymce.get('textarea_editor_email_' + editor_type) != undefined && tinymce.get('textarea_editor_email_' + editor_type) != null) {

                    tinymce.get('textarea_editor_email_' + editor_type).setContent('');
                    tinymce.get('textarea_editor_email_' + editor_type).execCommand('mceInsertContent', false, emailEditorParaTag + message);
                    // tinymce.get('textarea_editor_email_' + editor_type).setContent(message, { format: 'html' });

                    // tinymce.get('textarea_editor_email_reply').setContent(message, { format: 'html' });

                    // $('#textarea_editor_email_' + editor_type).append(message);

                }

                // tinymce.get('body_html').setContent(message, { format: 'raw' });

                // tinymce.get('body_html').execCommand('mceInsertRawHTML', false, message);
                // tinymce.get('body_html').execCommand('mceInsertContent', false, message);

                // $('.email-reply-body_html').summernote('code', message);

                // var activeEditor = tinymce.activeEditor;

                // var content = message;

                // if (activeEditor !== null && content != '') {

                //     activeEditor.setContent(content);

                // } else {

                //     $('.email-reply-body_html').val(content);

                // }
                if (type == 'forward' && response.data.email_forward_attachment_html != '') {
                    $('#attached_file_box').show();
                    $('#attached_file').html(response.data.email_forward_attachment_html);
                } else {
                    $('#attached_file').html('');
                    $('#attached_file_box').hide();
                }
                $('.email_id').val(response.data.id);

            }
            $('.email-reply-modal').modal({
                show: 'false'
            });
            //$('.email-reply-modal').show();


        } else {

            Swal.fire({

                title: '',
                text: "Email Data Not Found!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }
    });
}

function showdraftform(type, selector) {
    var emailPostData = {};
    var emailid = $('.email-title').attr('data-email-id');
    var postUrl = $(selector).attr('data-email-geturl');

    if (tinymce.get('textarea_editor_email_draft') != undefined && tinymce.get('textarea_editor_email_draft') != null) {

        // tinymce.get('textarea_editor_email_draft').execCommand('mceInsertContent', false, '');
        tinymce.get('textarea_editor_email_draft').setContent('');

    }

    emailPostData.emailid = emailid;
    $('.modeltitle').html('Draft Mail');

    $.ajax({
        url: postUrl,
        data: emailPostData,
        dataType: 'json',
        type: 'POST',

    }).done(function(response) {

        if (response.success == "true") {
            if (response.data != undefined && response.data != '') {

                if (response.data.email_to != '' && response.data.email_to != null) {
                    var to = response.data.email_to.replace(/&quot;/g, "");
                    to = to.replace(/&quot;/g, "");
                    to = to.replace(/&lt;/g, "<");
                    to = to.replace(/&gt;/g, ">");
                    to = to.replace(/;/g, "");
                    $('.email-draft-to').val(to + ';');
                }
                if (response.data.email_cc != '' && response.data.email_cc != null) {
                    var cc = response.data.email_cc.replace(/&quot;/g, "");
                    cc = cc.replace(/&quot;/g, "")
                    cc = cc.replace(/&lt;/g, "<");
                    cc = cc.replace(/&gt;/g, ">");
                    cc = cc.replace(/;/g, "");
                    $('.email-draft-cc').val(cc + ';');
                }
                if (response.data.email_bcc != '' && response.data.email_bcc != null) {
                    var bcc = response.data.email_bcc.replace(/&quot;/g, "");
                    bcc = bcc.replace(/&quot;/g, "")
                    bcc = bcc.replace(/&lt;/g, "<");
                    bcc = bcc.replace(/&gt;/g, ">");
                    bcc = bcc.replace(/;/g, "");
                    $('.email-draft-bcc').val(bcc + ';');
                }
                var subject = response.data.subject;
                $('.email-draft-subject').val(subject);

                var message = response.data.body_html;

                if (tinymce.get('textarea_editor_email_draft') != undefined && tinymce.get('textarea_editor_email_draft') != null) {

                    tinymce.get('textarea_editor_email_draft').execCommand('mceInsertContent', false, message);

                    // $('#textarea_editor_email_draft').append(message);

                }

                // $('.email-draft-body_html').summernote('code', message);

                // var activeEditor = tinymce.activeEditor;

                // var content = message;

                // if (activeEditor !== null && content != '') {

                //     activeEditor.setContent(content);

                // } else {

                //     $('.email-draft-body_html').val(content);
                // }

                $('.email_id').val(response.data.id);

            }
            $('.email-draft-modal').modal({
                show: 'false'
            });
            //$('.email-draft-modal').show();

        } else {

            Swal.fire({

                title: '',
                text: "Email Data Not Found!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }
    });
}
$(document).ready(function() {

    $("#to").keyup(function() {
        var search = $(this).val();

        var temp = new Array();
        temp = search.split(";");
        if (temp.length == '1') {
            $('#composeto_value').val('');
        }
        var postUrl = $('#getemailidURL').val();

        if (search != "") {
            $.ajax({
                url: postUrl,
                type: 'post',
                data: { search: search },
                dataType: 'json',
                success: function(response) {
                    var len = response.data.length;
                    $(".compose_to ul").empty();
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            // $(".compose_to ul").append("<li class='compose_emaillist' value='" + atob(response.data[i].email_from) + "'>" + atob(response.data[i].email_from) + "</li>");
                            $(".compose_to ul").append("<li class='compose_emaillist' value='" + response.data[i].email_from + "'>" + response.data[i].email_from + "</li>");
                        }
                    } else {
                        $(".compose_to ul").empty();
                    }
                }
            });
        } else {
            $(".compose_to ul").empty();
        }
    });
    $("#cc").keyup(function() {
        var search = $(this).val();

        var temp = new Array();
        temp = search.split(";");
        if (temp.length == '1') {
            $('#composecc_value').val('');
        }
        var postUrl = $('#getemailidURL').val();

        if (search != "") {
            $.ajax({
                url: postUrl,
                type: 'post',
                data: { search: search },
                dataType: 'json',
                success: function(response) {
                    var len = response.data.length;
                    $(".compose_cc ul").empty();
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            $(".compose_cc ul").append("<li class='composecc_emaillist' value='" + response.data[i].email_from + "'>" + response.data[i].email_from + "</li>");
                        }
                    } else {
                        $(".compose_cc ul").empty();
                    }
                }
            });
        } else {
            $(".compose_cc ul").empty();
        }
    });
    $("#bcc").keyup(function() {
        var search = $(this).val();

        var temp = new Array();
        temp = search.split(";");
        if (temp.length == '1') {
            $('#composebcc_value').val('');
        }
        var postUrl = $('#getemailidURL').val();

        if (search != "") {
            $.ajax({
                url: postUrl,
                type: 'post',
                data: { search: search },
                dataType: 'json',
                success: function(response) {
                    var len = response.data.length;
                    $(".compose_cc ul").empty();
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            $(".compose_bcc ul").append("<li class='composebcc_emaillist' value='" + response.data[i].email_from + "'>" + response.data[i].email_from + "</li>");
                        }
                    } else {
                        $(".compose_bcc ul").empty();
                    }
                }
            });
        } else {
            $(".compose_bcc ul").empty();
        }
    });
    $("#email-reply-to").keyup(function() {
        var search = $(this).val();

        var temp = new Array();
        temp = search.split(";");
        if (temp.length == '1') {
            $('#replyto_value').val('');
        }

        var postUrl = $('#getemailidURL').val();

        if (search != "") {
            $.ajax({
                url: postUrl,
                type: 'post',
                data: { search: search },
                dataType: 'json',
                success: function(response) {
                    var len = response.data.length;
                    $(".reply_to ul").empty();
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            $(".reply_to ul").append("<li class='replyto_emaillist' value='" + response.data[i].email_from + "'>" + response.data[i].email_from + "</li>");
                        }
                    } else {
                        $(".reply_to ul").empty();
                    }
                }
            });
        } else {
            $(".reply_to ul").empty();
        }
    });
    $("#email-reply-cc").keyup(function() {
        var search = $(this).val();

        var temp = new Array();
        temp = search.split(";");
        if (temp.length == '1') {
            $('#replycc_value').val('');
        }

        var postUrl = $('#getemailidURL').val();

        if (search != "") {
            $.ajax({
                url: postUrl,
                type: 'post',
                data: { search: search },
                dataType: 'json',
                success: function(response) {
                    var len = response.data.length;
                    $(".reply_cc ul").empty();
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            $(".reply_cc ul").append("<li class='replycc_emaillist' value='" + response.data[i].email_from + "'>" + response.data[i].email_from + "</li>");
                        }
                    } else {
                        $(".reply_cc ul").empty();
                    }
                }
            });
        } else {
            $(".reply_cc ul").empty();
        }
    });
    $("#email-reply-bcc").keyup(function() {
        var search = $(this).val();

        var temp = new Array();
        temp = search.split(";");
        if (temp.length == '1') {
            $('#replybcc_value').val('');
        }

        var postUrl = $('#getemailidURL').val();

        if (search != "") {
            $.ajax({
                url: postUrl,
                type: 'post',
                data: { search: search },
                dataType: 'json',
                success: function(response) {
                    var len = response.data.length;
                    $(".reply_cc ul").empty();
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            $(".reply_bcc ul").append("<li class='replybcc_emaillist' value='" + response.data[i].email_from + "'>" + response.data[i].email_from + "</li>");
                        }
                    } else {
                        $(".reply_bcc ul").empty();
                    }
                }
            });
        } else {
            $(".reply_bcc ul").empty();
        }
    });
    $("#email-draft-to").keyup(function() {
        var search = $(this).val();

        var temp = new Array();
        temp = search.split(";");
        if (temp.length == '1') {
            $('#draftto_value').val('');
        }

        var postUrl = $('#getemailidURL').val();

        if (search != "") {
            $.ajax({
                url: postUrl,
                type: 'post',
                data: { search: search },
                dataType: 'json',
                success: function(response) {
                    var len = response.data.length;
                    $(".draft_to ul").empty();
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            $(".draft_to ul").append("<li class='draftto_emaillist' value='" + response.data[i].email_from + "'>" + response.data[i].email_from + "</li>");
                        }
                    } else {
                        $(".draft_to ul").empty();
                    }
                }
            });
        } else {
            $(".draft_to ul").empty();
        }
    });
    $("#email-draft-cc").keyup(function() {
        var search = $(this).val();

        var temp = new Array();
        temp = search.split(";");
        if (temp.length == '1') {
            $('#draftcc_value').val('');
        }

        var postUrl = $('#getemailidURL').val();

        if (search != "") {
            $.ajax({
                url: postUrl,
                type: 'post',
                data: { search: search },
                dataType: 'json',
                success: function(response) {
                    var len = response.data.length;
                    $(".draft_cc ul").empty();
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            $(".draft_cc ul").append("<li class='draftcc_emaillist' value='" + response.data[i].email_from + "'>" + response.data[i].email_from + "</li>");
                        }
                    } else {
                        $(".draft_cc ul").empty();
                    }
                }
            });
        } else {
            $(".draft_cc ul").empty();
        }
    });
    $("#email-draft-bcc").keyup(function() {
        var search = $(this).val();

        var temp = new Array();
        temp = search.split(";");
        if (temp.length == '1') {
            $('#draftbcc_value').val('');
        }

        var postUrl = $('#getemailidURL').val();

        if (search != "") {
            $.ajax({
                url: postUrl,
                type: 'post',
                data: { search: search },
                dataType: 'json',
                success: function(response) {
                    var len = response.data.length;
                    $(".draft_bcc ul").empty();
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            $(".draft_bcc ul").append("<li class='draftbcc_emaillist' value='" + response.data[i].email_from + "'>" + response.data[i].email_from + "</li>");
                        }
                    } else {
                        $(".draft_bcc ul").empty();
                    }
                }
            });
        } else {
            $(".draft_bcc ul").empty();
        }
    });
});
$(document).on('click', '.compose_emaillist', function(e) {
    var value = $(this).attr('value');
    var tovalue = $('#composeto_value').val();
    value = value.replace(/"/g, "");
    $('#composeto_value').val(tovalue + value + ';');
    $('.composeto').val(tovalue + value + ';');
    $(".compose_to ul").empty();
});
$(document).on('click', '.composecc_emaillist', function(e) {
    var value = $(this).attr('value');
    var ccvalue = $('#composecc_value').val();
    value = value.replace(/"/g, "");
    $('#composecc_value').val(ccvalue + value + ';');
    $('.composecc').val(ccvalue + value + ';');
    $(".compose_cc ul").empty();
});
$(document).on('click', '.composebcc_emaillist', function(e) {
    var value = $(this).attr('value');
    var bccvalue = $('#composebcc_value').val();
    value = value.replace(/"/g, "");
    $('#composebcc_value').val(bccvalue + value + ';');
    $('.composebcc').val(bccvalue + value + ';');
    $(".compose_bcc ul").empty();
});
$(document).on('click', '.replyto_emaillist', function(e) {
    var value = $(this).attr('value');
    var tovalue = $('#replyto_value').val();
    value = value.replace(/"/g, "");
    $('#replyto_value').val(tovalue + value + ';');
    $('.email-reply-to').val(tovalue + value + ';');
    $(".reply_to ul").empty();
});
$(document).on('click', '.replycc_emaillist', function(e) {
    var value = $(this).attr('value');
    var reccvalue = $('#replycc_value').val();
    value = value.replace(/"/g, "");
    $('#replycc_value').val(reccvalue + value + ';');
    $('.email-reply-cc').val(reccvalue + value + ';');
    $(".reply_cc ul").empty();
});
$(document).on('click', '.replybcc_emaillist', function(e) {
    var value = $(this).attr('value');
    var rebccvalue = $('#replybcc_value').val();
    value = value.replace(/"/g, "");
    $('#replybcc_value').val(rebccvalue + value + ';');
    $('.email-reply-bcc').val(rebccvalue + value + ';');
    $(".reply_bcc ul").empty();
});
$(document).on('click', '.draftto_emaillist', function(e) {
    var value = $(this).attr('value');
    var reccvalue = $('#draftto_value').val();
    value = value.replace(/"/g, "");
    $('#draftto_value').val(reccvalue + value + ';');
    $('.email-draft-to').val(reccvalue + value + ';');
    $(".draft_to ul").empty();
});
$(document).on('click', '.draftcc_emaillist', function(e) {
    var value = $(this).attr('value');
    var reccvalue = $('#draftcc_value').val();
    value = value.replace(/"/g, "");
    $('#draftcc_value').val(reccvalue + value + ';');
    $('.email-draft-cc').val(reccvalue + value + ';');
    $(".draft_cc ul").empty();
});
$(document).on('click', '.draftbcc_emaillist', function(e) {
    var value = $(this).attr('value');
    var rebccvalue = $('#draftbcc_value').val();
    value = value.replace(/"/g, "");
    $('#draftbcc_value').val(rebccvalue + value + ';');
    $('.email-draft-bcc').val(rebccvalue + value + ';');
    $(".draft_bcc ul").empty();
});
$(document).on('click', '.email-compose-btn', function(e) {
    $('#to').val('');
    $('#cc').val('');
    $('#subject').val('');
    $('#textarea_editor_email_compose').val('');

    if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

        // tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, '');
        tinymce.get('textarea_editor_email_compose').setContent('');

        tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, emailEditorParaTag);


    }


    // $('.compose_message').summernote('code', '');

    // var activeEditor = tinymce.activeEditor;

    // var content = '';

    // if (activeEditor !== null) {

    //     activeEditor.setContent(content);

    // } else {

    //     $('.compose_message').val(content);
    // }

    $('#composeto_value').val('');
    $('.attachements').val('');
    $('.signature_change').val('new_signature');
    $(".compose_to ul").empty();
    var emailPostData = {};
    var selector = '.signature';
    var postUrl = $(selector).attr('data-signature-geturl');

    $.ajax({

        url: postUrl,
        data: emailPostData,
        dataType: 'json',
        type: 'POST',

    }).done(function(response) {

        if (response.success == "true") {
            if (response.data != undefined && typeof response.data == 'object' && 'new_signature' in response.data && response.data.new_signature != '') {
                var random = Math.random().toString(36).substring(7);
                var sig_class = 'emailsig_block_' + random;
                //$.session.set('signature_classname', 'test');
                sessionStorage.setItem('signature_classname', sig_class);

                var message = response.data.new_signature;
                var stamp = '<div class="' + sig_class + '">';
                message = stamp.concat(message);
                var msg = '</div>';
                message = msg.concat(message);

                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                    // tinymce.get('textarea_editor_email_compose').setContent(message, { format: 'html' });
                    // tinymce.get('textarea_editor_email_compose').setContent('<p style="font-size: 11pt; font-family: Calibri; color: #1f497d; line-height: 8pt;"></p>', { format: 'html' });
                    tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, emailEditorParaTag + message);
                    // $('#textarea_editor_email_compose').append(message);

                }

                // $('.compose_message').summernote('code', message);

                // var activeEditor = tinymce.activeEditor;

                // var content = message;

                // if (activeEditor !== null && content != '') {

                //     activeEditor.setContent(content);

                // } else {

                //     $('.compose_message').val(content);
                // }

                // tinymce.get('my_textarea_id').setContent(my_value_to_set);

            }
        } else {

            Swal.fire({

                title: '',
                text: "Signature Data Not Found!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }
    });


});

$('.nonBusinessEmails .email-inbox-nav').slimscroll({
    height: '520px',
});

$('.nonBusinessEmailGrid .jsgrid-grid-body').slimscroll({
    height: '520px',
});

$('.myEmailGrid .jsgrid-grid-body').slimscroll({
    height: '520px',
});

$('.pmsEmailCountGrid .jsgrid-grid-body').slimscroll({
    height: '520px',
});
$(document).on("click", function(event) {
    var $composeto = $(".composetolist");
    var $composecc = $(".composecclist");
    var $composebcc = $(".composebcclist");
    var $replyeto = $(".replytolist");
    var $replycc = $(".replycclist");
    var $replybcc = $(".replybcclist");
    var $draftto = $(".drafttolist");
    var $draftcc = $(".draftcclist");
    var $draftbcc = $(".draftbcclist");


    if ($composeto !== event.target && !$composeto.has(event.target).length) {
        $(".composetolist").empty();
    }
    if ($composecc !== event.target && !$composecc.has(event.target).length) {
        $(".composecclist").empty();
    }
    if ($composebcc !== event.target && !$composebcc.has(event.target).length) {
        $(".composebcclist").empty();
    }
    if ($replyeto !== event.target && !$replyeto.has(event.target).length) {
        $(".replytolist").empty();
    }
    if ($replycc !== event.target && !$replycc.has(event.target).length) {
        $(".replycclist").empty();
    }
    if ($replybcc !== event.target && !$replybcc.has(event.target).length) {
        $(".replybcclist").empty();
    }
    if ($draftto !== event.target && !$draftto.has(event.target).length) {
        $(".drafttolist").empty();
    }
    if ($draftcc !== event.target && !$draftcc.has(event.target).length) {
        $(".draftcclist").empty();
    }
    if ($draftbcc !== event.target && !$draftbcc.has(event.target).length) {
        $(".draftbcclist").empty();
    }
});

$(document).on('click', '.signature', function(e) {
    e.preventDefault();
    showsignatureform();
});

$(document).on('click', '.signature-save', function(e) {

    tinymce.triggerSave(true, true);

    e.preventDefault();

    var postUrl = $('.signature-form').attr('action');

    var params = new FormData($('.signature-form')[0]);
    // var params = {};

    // if (tinymce.get('textarea_editor_email_new_signature') != undefined && tinymce.get('textarea_editor_email_new_signature') != null) {

    //     params.new_signature = tinymce.get('textarea_editor_email_new_signature').getContent({ format: 'html' });
    //     // params.new_signature = tinymce.get('textarea_editor_email_new_signature').getContent();

    // }

    // if (tinymce.get('textarea_editor_email_replyforward_signature') != undefined && tinymce.get('textarea_editor_email_replyforward_signature') != null) {


    //     params.replyforward_signature = tinymce.get('textarea_editor_email_replyforward_signature').getContent({ format: 'html' });
    //     // params.replyforward_signature = tinymce.get('textarea_editor_email_replyforward_signature').getContent();

    // }

    signature(postUrl, params, '#signatureModal');

});

$(document).on('click', '.signature-cancel', function(e) {
    $('#signatureModal').modal('hide');

});

function signature(sendUrl, params, closeBtnSelector) {

    // params.new_signature = 'test';
    // params.replyforward_signature = 'testfgdhfd';

    // var new_signature = { 'test': 'test' };


    if (sendUrl != undefined && sendUrl != '') {

        /* AJAX call to email item info */

        var d = $.Deferred();

        $.ajax({
            url: sendUrl,
            data: params,
            dataType: 'json',
            type: 'POST',
            processData: false,
            contentType: false,
            enctype: "multipart/form-data",
        }).done(function(response) {

            if (response.success == "true") {

                type = 'success';

            } else {

                type = 'error';

                d.resolve();

            }

            message = response.message;

            flashMessage(type, message);

        });
        $(closeBtnSelector).modal('hide');
        return d.promise();


    }
}

function showsignatureform() {
    var emailPostData = {};

    if (tinymce.get('textarea_editor_email_new_signature') != undefined && tinymce.get('textarea_editor_email_new_signature') != null) {

        // tinymce.get('textarea_editor_email_new_signature').execCommand('mceInsertContent', false, '');
        tinymce.get('textarea_editor_email_new_signature').setContent('');


    }

    if (tinymce.get('textarea_editor_email_replyforward_signature') != undefined && tinymce.get('textarea_editor_email_replyforward_signature') != null) {

        // tinymce.get('textarea_editor_email_replyforward_signature').execCommand('mceInsertContent', false, '');
        tinymce.get('textarea_editor_email_replyforward_signature').setContent('');

    }

    //var postUrl = 'get-signature';
    var selector = '.signature';
    var postUrl = $(selector).attr('data-signature-geturl');
    $.ajax({

        url: postUrl,
        data: emailPostData,
        dataType: 'json',
        type: 'POST',

    }).done(function(response) {

        if (response.success == "true") {
            if (response.data != undefined && typeof response.data == 'object') {


                var str2 = '';

                if ('new_signature' in response.data && response.data.new_signature != '') {

                    var message = response.data.new_signature;

                    if (tinymce.get('textarea_editor_email_new_signature') != undefined && tinymce.get('textarea_editor_email_new_signature') != null) {

                        tinymce.get('textarea_editor_email_new_signature').execCommand('mceInsertContent', false, message);

                        // tinymce.get('textarea_editor_email_new_signature').setContent(message, { format: 'html' });

                        // $('#textarea_editor_email_new_signature').append(message);

                    }

                } else {

                    tinymce.get('textarea_editor_email_new_signature').execCommand('mceInsertContent', false, emailSignatureEditorParaTag);

                    // tinymce.get('textarea_editor_email_new_signature').setContent('<p style="margin: 0in; margin-bottom: .0001pt; font-size: 10.0pt; font-family: Arial;"><br></p>', { format: 'html' });

                }

                // tinymce.get("new_signature").setContent(message);

                // $('.new_signature').summernote('code', message);

                // var activeEditor = tinymce.activeEditor;

                // var content = message;

                // if (activeEditor !== null && content != '') {

                //     activeEditor.setContent(content);

                // } else {

                //     $('.new_signature').val(content);
                // }

                if ('replyforward_signature' in response.data && response.data.replyforward_signature != '') {

                    var message1 = response.data.replyforward_signature;

                    if (tinymce.get('textarea_editor_email_replyforward_signature') != undefined && tinymce.get('textarea_editor_email_replyforward_signature') != null) {

                        // tinymce.get('textarea_editor_email_replyforward_signature').setContent(message1, { format: 'html' });

                        tinymce.get('textarea_editor_email_replyforward_signature').execCommand('mceInsertContent', false, message1);
                        // $('#textarea_editor_email_replyforward_signature').append(message1);

                    }

                } else {

                    // tinymce.get('textarea_editor_email_replyforward_signature').setContent('<p style="margin: 0in; margin-bottom: .0001pt; font-size: 10.0pt; font-family: Arial;"><br></p>', { format: 'html' });

                    tinymce.get('textarea_editor_email_replyforward_signature').execCommand('mceInsertContent', false, emailSignatureEditorParaTag);

                }


                // $('.replyforward_signature').summernote('code', message1);

                // var activeEditor = tinymce.activeEditor;

                // var content = message;

                // if (activeEditor !== null && content != '') {

                //     activeEditor.setContent(content);

                // } else {

                //     $('.replyforward_signature').val(content);
                // }

            } else {

                if (tinymce.get('textarea_editor_email_new_signature') != undefined && tinymce.get('textarea_editor_email_new_signature') != null) {

                    tinymce.get('textarea_editor_email_new_signature').setContent('');

                    tinymce.get('textarea_editor_email_new_signature').execCommand('mceInsertContent', false, emailSignatureEditorParaTag);

                }

                if (tinymce.get('textarea_editor_email_replyforward_signature') != undefined && tinymce.get('textarea_editor_email_replyforward_signature') != null) {

                    tinymce.get('textarea_editor_email_replyforward_signature').setContent('');

                    tinymce.get('textarea_editor_email_replyforward_signature').execCommand('mceInsertContent', false, emailSignatureEditorParaTag);

                }

            }
        } else {

            Swal.fire({

                title: '',
                text: "Signature Data Not Found!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }
    });

}
$(document).on('change', '.signature_change', function(e) {
    var val = this.value;
    var pagetype = $(this).attr('data-signature-type');

    var emailPostData = {};
    var selector = '.sig_change';
    var postUrl = $(selector).attr('data-signature-geturl');


    $.ajax({

        url: postUrl,
        data: emailPostData,
        dataType: 'json',
        type: 'POST',

    }).done(function(response) {


        if (response.success == "true") {

            if (response.data != undefined && typeof response.data == 'object') {

                var classname = sessionStorage.getItem('signature_classname');
                var ed = tinyMCE.activeEditor;
                var hasMarkup = ed.dom.hasClass(ed.selection.getNode(), classname);
                var ele = tinyMCE.activeEditor.dom.get(classname);
                var classexisting = $('#textarea_editor_email_compose_ifr').contents().find('.' + classname).text()

                if (val == 'new_signature') {

                    if ('new_signature' in response.data && response.data.new_signature != '') {

                        //if ($("div").hasClass(classname) == true) {
                        if (classexisting != '') {

                            $('#textarea_editor_email_compose_ifr').contents().find('.' + classname).html(response.data.new_signature);

                            //$('.' + classname).html(response.data.new_signature);

                        } else {

                            var random = Math.random().toString(36).substring(7);

                            var sig_class = 'emailsig_block_' + random;

                            sessionStorage.setItem('signature_classname', sig_class);

                            if (pagetype == 'new') {

                                // var message = $('.compose_message').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    message = tinymce.get('textarea_editor_email_compose').getContent({ format: 'html' });

                                    // tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, '');
                                    tinymce.get('textarea_editor_email_compose').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.new_signature;
                                var msg = '</div>';
                                message = message + stamp + msg;
                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, message);
                                    // $('#textarea_editor_email_compose').append(message);

                                }



                            } else if (pagetype == 'reply') {

                                // var message = $('.email-reply-body_html').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    // tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, '');
                                    tinymce.get('textarea_editor_email_reply').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.new_signature;
                                var msg = '</div>';
                                message = stamp + msg + message;

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, message);

                                    // $('#textarea_editor_email_reply').append(message);

                                }



                            }

                        }

                    }

                } else if (val == 'replyforward_signature') {

                    //$('#textarea_editor_email_compose_ifr').contents().find('.anand').html('<div> blah </div>');
                    //return false;

                    if ('replyforward_signature' in response.data && response.data.replyforward_signature != '') {

                        //if ($("div").hasClass(classname) == true) {
                        if (classexisting != '') {
                            // $('.' + classname).html(response.data.replyforward_signature);

                            $('#textarea_editor_email_compose_ifr').contents().find('.' + classname).html(response.data.replyforward_signature);

                        } else {

                            var random = Math.random().toString(36).substring(7);
                            var sig_class = 'emailsig_block_' + random;
                            sessionStorage.setItem('signature_classname', sig_class);

                            if (pagetype == 'new') {
                                // var message = $('.compose_message').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    message = tinymce.get('textarea_editor_email_compose').getContent({ format: 'html' });



                                    tinymce.get('textarea_editor_email_compose').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.replyforward_signature;
                                var msg = '</div>';
                                message = message + stamp + msg;

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, message);

                                    // $('#textarea_editor_email_compose').append(message);

                                }


                            } else if (pagetype == 'reply') {
                                // var message = $('.email-reply-body_html').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    message = tinymce.get('textarea_editor_email_reply').getContent({ format: 'html' });

                                    // tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, '');
                                    tinymce.get('textarea_editor_email_reply').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.replyforward_signature;
                                var msg = '</div>';
                                message = stamp + msg + message;

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, message);

                                    // $('#textarea_editor_email_reply').append(message);

                                }

                            }

                        }

                    }

                }

            }
        } else {



            Swal.fire({

                title: '',
                text: "Signature Data Not Found!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }
    });
});
$(document).on('change', '.signature_reply_change', function(e) {
    var val = this.value;
    var pagetype = $(this).attr('data-signature-type');

    var emailPostData = {};
    var selector = '.sig_change';
    var postUrl = $(selector).attr('data-signature-geturl');


    $.ajax({

        url: postUrl,
        data: emailPostData,
        dataType: 'json',
        type: 'POST',

    }).done(function(response) {


        if (response.success == "true") {

            if (response.data != undefined && typeof response.data == 'object') {

                var classname = sessionStorage.getItem('signature_classname');
                var ed = tinyMCE.activeEditor;
                var hasMarkup = ed.dom.hasClass(ed.selection.getNode(), classname);
                var ele = tinyMCE.activeEditor.dom.get(classname);
                var classexisting = $('#textarea_editor_email_reply_ifr').contents().find('.' + classname).text()

                if (val == 'new_signature') {

                    if ('new_signature' in response.data && response.data.new_signature != '') {

                        //if ($("div").hasClass(classname) == true) {
                        if (classexisting != '') {

                            $('#textarea_editor_email_reply_ifr').contents().find('.' + classname).html(response.data.new_signature);

                            //$('.' + classname).html(response.data.new_signature);

                        } else {

                            var random = Math.random().toString(36).substring(7);

                            var sig_class = 'emailsig_block_' + random;

                            sessionStorage.setItem('signature_classname', sig_class);

                            if (pagetype == 'new') {

                                // var message = $('.compose_message').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    message = tinymce.get('textarea_editor_email_compose').getContent({ format: 'html' });

                                    // tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, '');
                                    tinymce.get('textarea_editor_email_compose').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.new_signature;
                                var msg = '</div>';
                                message = message + stamp + msg;
                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, message);
                                    // $('#textarea_editor_email_compose').append(message);

                                }



                            } else if (pagetype == 'reply') {

                                // var message = $('.email-reply-body_html').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    // tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, '');
                                    tinymce.get('textarea_editor_email_reply').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.new_signature;
                                var msg = '</div>';
                                message = stamp + msg + message;

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, message);

                                    // $('#textarea_editor_email_reply').append(message);

                                }



                            }

                        }

                    }

                } else if (val == 'replyforward_signature') {

                    //$('#textarea_editor_email_compose_ifr').contents().find('.anand').html('<div> blah </div>');
                    //return false;

                    if ('replyforward_signature' in response.data && response.data.replyforward_signature != '') {

                        //if ($("div").hasClass(classname) == true) {
                        if (classexisting != '') {
                            // $('.' + classname).html(response.data.replyforward_signature);

                            $('#textarea_editor_email_reply_ifr').contents().find('.' + classname).html(response.data.replyforward_signature);

                        } else {

                            var random = Math.random().toString(36).substring(7);
                            var sig_class = 'emailsig_block_' + random;
                            sessionStorage.setItem('signature_classname', sig_class);

                            if (pagetype == 'new') {
                                // var message = $('.compose_message').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    message = tinymce.get('textarea_editor_email_compose').getContent({ format: 'html' });



                                    tinymce.get('textarea_editor_email_compose').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.replyforward_signature;
                                var msg = '</div>';
                                message = message + stamp + msg;

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, message);

                                    // $('#textarea_editor_email_compose').append(message);

                                }


                            } else if (pagetype == 'reply') {
                                // var message = $('.email-reply-body_html').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    message = tinymce.get('textarea_editor_email_reply').getContent({ format: 'html' });

                                    // tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, '');
                                    tinymce.get('textarea_editor_email_reply').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.replyforward_signature;
                                var msg = '</div>';
                                message = stamp + msg + message;

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, message);

                                    // $('#textarea_editor_email_reply').append(message);

                                }

                            }

                        }

                    }

                }

            }
        } else {
            Swal.fire({

                title: '',
                text: "Signature Data Not Found!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }
    });
});
$(document).on('change', '.signature_draft_change', function(e) {
    var val = this.value;
    var pagetype = $(this).attr('data-signature-type');

    var emailPostData = {};
    var selector = '.sig_change';
    var postUrl = $(selector).attr('data-signature-geturl');


    $.ajax({

        url: postUrl,
        data: emailPostData,
        dataType: 'json',
        type: 'POST',

    }).done(function(response) {


        if (response.success == "true") {

            if (response.data != undefined && typeof response.data == 'object') {

                var classname = sessionStorage.getItem('signature_classname');
                var ed = tinyMCE.activeEditor;
                var hasMarkup = ed.dom.hasClass(ed.selection.getNode(), classname);
                var ele = tinyMCE.activeEditor.dom.get(classname);
                var classexisting = $('#textarea_editor_email_draft_ifr').contents().find('.' + classname).text()

                if (val == 'new_signature') {

                    if ('new_signature' in response.data && response.data.new_signature != '') {
                        if (classexisting != '') {
                            $('#textarea_editor_email_draft_ifr').contents().find('.' + classname).html(response.data.new_signature);
                        } else {

                            var random = Math.random().toString(36).substring(7);

                            var sig_class = 'emailsig_block_' + random;

                            sessionStorage.setItem('signature_classname', sig_class);

                            if (pagetype == 'new') {
                                var message = '';

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {
                                    message = tinymce.get('textarea_editor_email_compose').getContent({ format: 'html' });
                                    // tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, '');
                                    tinymce.get('textarea_editor_email_compose').setContent('');
                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.new_signature;
                                var msg = '</div>';
                                message = message + stamp + msg;
                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {
                                    tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, message);
                                    // $('#textarea_editor_email_compose').append(message);

                                }



                            } else if (pagetype == 'reply') {
                                var message = '';

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {
                                    tinymce.get('textarea_editor_email_reply').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.new_signature;
                                var msg = '</div>';
                                message = stamp + msg + message;

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {
                                    tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, message);
                                }
                            }

                        }

                    }

                } else if (val == 'replyforward_signature') {

                    if ('replyforward_signature' in response.data && response.data.replyforward_signature != '') {
                        if (classexisting != '') {
                            $('#textarea_editor_email_draft_ifr').contents().find('.' + classname).html(response.data.replyforward_signature);

                        } else {

                            var random = Math.random().toString(36).substring(7);
                            var sig_class = 'emailsig_block_' + random;
                            sessionStorage.setItem('signature_classname', sig_class);

                            if (pagetype == 'new') {

                                var message = '';

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    message = tinymce.get('textarea_editor_email_compose').getContent({ format: 'html' });
                                    tinymce.get('textarea_editor_email_compose').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.replyforward_signature;
                                var msg = '</div>';
                                message = message + stamp + msg;

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {
                                    tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, message);
                                }


                            } else if (pagetype == 'reply') {
                                var message = '';

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    message = tinymce.get('textarea_editor_email_reply').getContent({ format: 'html' });
                                    tinymce.get('textarea_editor_email_reply').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.replyforward_signature;
                                var msg = '</div>';
                                message = stamp + msg + message;

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {
                                    tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, message);
                                }

                            }

                        }

                    }

                }

            }
        } else {
            Swal.fire({

                title: '',
                text: "Signature Data Not Found!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }
    });
});
$(document).on('change', '.signature_change_old', function(e) {
    var val = this.value;
    var pagetype = $(this).attr('data-signature-type');

    var emailPostData = {};
    var selector = '.sig_change';
    var postUrl = $(selector).attr('data-signature-geturl');


    $.ajax({

        url: postUrl,
        data: emailPostData,
        dataType: 'json',
        type: 'POST',

    }).done(function(response) {


        if (response.success == "true") {

            if (response.data != undefined && typeof response.data == 'object') {

                var classname = sessionStorage.getItem('signature_classname');
                var ed = tinyMCE.activeEditor;
                var hasMarkup = ed.dom.hasClass(ed.selection.getNode(), classname);
                var ele = tinyMCE.activeEditor.dom.get(classname);

                if (val == 'new_signature') {

                    if ('new_signature' in response.data && response.data.new_signature != '') {

                        //if ($("div").hasClass(classname) == true) {
                        if (hasMarkup == true) {
                            $('#textarea_editor_email_compose_ifr').contents().find('.' + classname).html(response.data.new_signature);

                            //$('.' + classname).html(response.data.new_signature);

                        } else {

                            var random = Math.random().toString(36).substring(7);

                            var sig_class = 'emailsig_block_' + random;

                            sessionStorage.setItem('signature_classname', sig_class);

                            if (pagetype == 'new') {

                                // var message = $('.compose_message').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    message = tinymce.get('textarea_editor_email_compose').getContent({ format: 'html' });

                                    // tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, '');
                                    tinymce.get('textarea_editor_email_compose').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.new_signature;
                                var msg = '</div>';
                                message = message + stamp + msg;

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, message);
                                    // $('#textarea_editor_email_compose').append(message);

                                }

                                // $('.compose_message').summernote('code', message);

                                // var activeEditor = tinymce.activeEditor;

                                // var content = message;

                                // if (activeEditor !== null && content != '') {

                                //     activeEditor.setContent(content);

                                // } else {

                                //     $('.compose_message').val(content);
                                // }

                            } else if (pagetype == 'reply') {

                                // var message = $('.email-reply-body_html').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    // tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, '');
                                    tinymce.get('textarea_editor_email_reply').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.new_signature;
                                var msg = '</div>';
                                message = stamp + msg + message;

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, message);

                                    // $('#textarea_editor_email_reply').append(message);

                                }

                                // $('.email-reply-body_html').summernote('code', message);

                                // var activeEditor = tinymce.activeEditor;

                                // var content = message;

                                // if (activeEditor !== null && content != '') {

                                //     activeEditor.setContent(content);

                                // } else {

                                //     $('.email-reply-body_html').val(content);
                                // }

                            }

                        }

                    }

                } else if (val == 'replyforward_signature') {

                    //$('#textarea_editor_email_compose_ifr').contents().find('.anand').html('<div> blah </div>');
                    //return false;

                    if ('replyforward_signature' in response.data && response.data.replyforward_signature != '') {

                        //if ($("div").hasClass(classname) == true) {
                        if (hasMarkup == true) {
                            // $('.' + classname).html(response.data.replyforward_signature);

                            $('#textarea_editor_email_compose_ifr').contents().find('.' + classname).html(response.data.replyforward_signature);

                        } else {

                            var random = Math.random().toString(36).substring(7);
                            var sig_class = 'emailsig_block_' + random;
                            sessionStorage.setItem('signature_classname', sig_class);

                            if (pagetype == 'new') {
                                // var message = $('.compose_message').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    message = tinymce.get('textarea_editor_email_compose').getContent({ format: 'html' });



                                    //var regex = '/<div class="'+classname+'">(.*?)</div>/g';

                                    //var found = paragraph.match(regex);
                                    //alert(classname);
                                    //alert(found);


                                    //alert(message);
                                    // tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, '');
                                    tinymce.get('textarea_editor_email_compose').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.replyforward_signature;
                                var msg = '</div>';
                                message = message + stamp + msg;

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, message);

                                    // $('#textarea_editor_email_compose').append(message);

                                }

                                // $('.compose_message').summernote('code', message);

                                // var activeEditor = tinymce.activeEditor;

                                // var content = message;

                                // if (activeEditor !== null && content != '') {

                                //     activeEditor.setContent(content);

                                // } else {

                                //     $('.compose_message').val(content);
                                // }

                            } else if (pagetype == 'reply') {
                                // var message = $('.email-reply-body_html').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    message = tinymce.get('textarea_editor_email_reply').getContent({ format: 'html' });

                                    // tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, '');
                                    tinymce.get('textarea_editor_email_reply').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.replyforward_signature;
                                var msg = '</div>';
                                message = stamp + msg + message;

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, message);

                                    // $('#textarea_editor_email_reply').append(message);

                                }

                                // $('.email-reply-body_html').summernote('code', message);

                                // var activeEditor = tinymce.activeEditor;

                                // var content = message;

                                // if (activeEditor !== null && content != '') {

                                //     activeEditor.setContent(content);

                                // } else {

                                //     $('.email-reply-body_html').val(content);
                                // }

                            }

                        }

                    }

                }

            }
        } else {

            Swal.fire({

                title: '',
                text: "Signature Data Not Found!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }
    });
});

$(document).on('click', '.fw-attachements', function(e) {

    e.preventDefault();

    var removedId = $(this).attr('data-attachement-id');
    if (removedId != undefined && removedId != '') {

        $('#' + removedId).remove();

    }

});