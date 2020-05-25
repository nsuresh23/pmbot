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
                        return (!filter.created_date || client.created_date.indexOf(filter.created_date) > -1) &&
                            // (!filter.status_text || client.status_text.indexOf(filter.status_text) > -1) &&
                            (!filter.subject_link || client.subject_link.indexOf(filter.subject_link) > -1) &&
                            (!filter.email_from || client.email_from.indexOf(filter.email_from) > -1) &&
                            (!filter.email_to || client.email_to.indexOf(filter.email_to) > -1) &&
                            (!filter.message_start || client.message.indexOf(filter.message_start) > -1);
                        // (!filter.message || client.message.indexOf(filter.message) > -1);
                        // (!filter.message || client.message.indexOf(filter.message) > -1) &&
                        // (!filter.email_cc || client.email_cc.indexOf(filter.email_cc) > -1) &&
                        // (!filter.priority || client.priority.indexOf(filter.priority) > -1) &&
                        // (!filter.score || client.score.indexOf(filter.score) > -1);
                    });

                }
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

    var status = ['0', '1'];

    emailListPostData.type = 'pmbot';

    if (gridEmailFilter != undefined && gridEmailFilter != '') {

        emailListPostData.email_filter = gridEmailFilter;

        emailFilter = gridEmailFilter;

    }

    if (gridCategory != undefined && gridCategory != '') {

        emailListPostData.email_type = gridCategory;

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

            emailListPostData.type = 'non_pmbot';

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

        if (currentJobId != undefined && currentJobId != '') {

            emailListPostData.job_id = currentJobId;

        }

    }

    emailListPostData.status = status;

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

            $(gridSelector).jsGrid("option", "data", response.data);

            $('.jsgrid-grid-body').slimscroll({
                height: '300px',
            });

            if ('result_count' in response) {

                // $(gridSelector).parent().prev().find('.result-count').html('(' + response.result_count + ')');
                // $(gridSelector).parent().prev().find('.result-count').addClass('result-count-icon-badge');

                $('.email-result-count').html('(' + response.result_count + ')');

            }

            if ('last_updated' in response) {

                $('.email-last-updated').html(response.last_updated);

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
                        return (!filter.empname || client.empname.indexOf(filter.empname) > -1) &&
                            (!filter.count || client.count.indexOf(filter.count) > -1);
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
        title: "COUNT",
        name: "count",
        type: "number",
        // width: 40,
    });

    field.push({
        type: "control",
        name: "Control",
        editButton: editControlVisible,
        deleteButton: deleteControlVisible,
        headerTemplate: function() {

            return this._createOnOffSwitchButton("filtering", this.searchModeButtonClass, false);

        },
        width: 35,
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

$(document).on('click', '.pmbot-email-item', function(e) {

    e.preventDefault();


    var emailItemPostData = {};

    var emailId = $(this).attr('data-email-id');
    var postUrl = $(this).attr('data-email-geturl');

    if (emailId != undefined && emailId != '' && postUrl != undefined && postUrl != '') {

        emailItemPostData.emailid = emailId;

        $('.email-title').attr('data-email-id', '');

        $('.email-annotator-link').attr('href', 'javascript:void(0);');
        $('.email-annotator-link-block').hide();
        $('.email-draftbutton-group').hide();

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

                        }

                        if (response.data.status != undefined && response.data.status == '5') {

                            //$('.email-title').attr('data-email-id', response.data.id);
                            $('.email-button-group').hide();

                        }

                        if (response.data.status != undefined && response.data.status == '4') {

                            $('.email-button-group').hide();
                            $('.email-draftbutton-group').show();

                        }


                        if (response.data.email_annotator_link != undefined && response.data.email_annotator_link != '') {

                            $('.email-annotator-link').attr('href', response.data.email_annotator_link);
                            $('.email-annotator-link-block').show();

                        }

                        //alert(response.data.subject);


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

$(document).on('click', '.dashboard-inbox-email', function() {

    var gridSelector = ".nonBusinessEmailGrid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'inbox');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

});

$(document).on('click', '.dashboard-outbox-email', function() {

    var gridSelector = ".nonBusinessEmailGrid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'outbox');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

    // $(this).closest('li').addClass('active');

});

$(document).on('click', '.dashboard-sent-email', function() {

    var gridSelector = ".nonBusinessEmailGrid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'sent');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

    // $(this).closest('li').addClass('active');

});

$(document).on('click', '.dashboard-draft-email', function() {

    var gridSelector = ".nonBusinessEmailGrid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'draft');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

});

$(document).on('click', '.job-inbox-email', function() {

    var gridSelector = ".jobEmailGrid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'inbox');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

});

$(document).on('click', '.job-outbox-email', function() {

    var gridSelector = ".jobEmailGrid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'outbox');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

    // $(this).closest('li').addClass('active');

});

$(document).on('click', '.job-sent-email', function() {

    var gridSelector = ".jobEmailGrid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'sent');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

    // $(this).closest('li').addClass('active');

});

$(document).on('click', '.job-draft-email', function() {

    var gridSelector = ".jobEmailGrid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'draft');

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

    e.preventDefault();

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

    e.preventDefault();

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

    e.preventDefault();

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

        });

        //$(closeBtnSelector).trigger('click');
        if (closeBtnSelector == '#emailSendModal') {
            $('#to').val('');
            $('#cc').val('');
            $('#subject').val('');
            $('#body_html').val('');
            $('.compose_message').summernote('code', '');
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
    $(".reply_to ul").empty();
    showform(type, selector);
});
$(document).on('click', '.email-reply-all-btn', function(e) {
    e.preventDefault();
    $('.attachements').val('');
    var type = $(this).attr('data-type');
    var selector = $(this);
    $('.reply_email_type').val('reply');
    $(".reply_to ul").empty();
    showform(type, selector);
});
$(document).on('click', '.email-forward-btn', function(e) {
    e.preventDefault();
    $('.attachements').val('');
    var type = $(this).attr('data-type');
    var selector = $(this);
    $('.reply_email_type').val('forward');
    $(".reply_to ul").empty();
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
                    if (response.data.email_cc != '' && response.data.email_cc != null) {
                        var cc = response.data.email_cc.replace(/&quot;/g, "");
                        cc = cc.replace(/&quot;/g, "")
                        cc = cc.replace(/&lt;/g, "<");
                        cc = cc.replace(/&gt;/g, ">");
                        $('.email-reply-cc').val(cc + ';');
                    }
                    if (response.data.email_to != '' && response.data.email_to != null) {
                        var replyallto = response.data.email_to.replace(/&quot;/g, "");
                        replyallto = replyallto.replace(/&quot;/g, "")
                        replyallto = replyallto.replace(/&lt;/g, "<");
                        replyallto = replyallto.replace(/&gt;/g, ">");

                        var reto = $('.email-reply-to').val();

                        $('.email-reply-to').val(reto + replyallto + ';');
                    }


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

                var stamp = '<br><br><br><hr><b>From:</b> ' + response.data.email_from + '<br><b>Sent:</b> ' + response.data.email_received_date + '<br><b>To:</b> ' + response.data.email_to + '<br><b>Subject:</b> ' + response.data.subject + '<br><br>';
                message = stamp.concat(message);

                $('.email-reply-subject').val(subject);
                $('.email-reply-body_html').summernote('code', message);
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
                var subject = response.data.subject;
                $('.email-draft-subject').val(subject);

                var message = response.data.body_html;
                $('.email-draft-body_html').summernote('code', message);
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
$(document).on('click', '.email-compose-btn', function(e) {
    $('#to').val('');
    $('#cc').val('');
    $('#subject').val('');
    $('#body_html').val('');
    $('.compose_message').summernote('code', '');
    $('#composeto_value').val('');
    $('.attachements').val('');
    $(".compose_to ul").empty();
});


$('.myEmailGrid .jsgrid-grid-body').slimscroll({
    height: '520px',
});

$('.pmsEmailCountGrid .jsgrid-grid-body').slimscroll({
    height: '520px',
});


/*
var submitTextArea = document.getElementById("to");
submitTextArea.addEventListener("blur", function () {

   //$(".compose_to ul").empty();

});*/

// });