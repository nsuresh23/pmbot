$(function() {

    $('.dashboard-recent-activity').slimScroll({
        height: '24.2em'
    });

    // $('#delayedJobList').slimScroll({
    //     height: '30.2em'
    // });

    function getJobList(selector, stage, status, gridType, getUrl, jobDetailUrl) {

        var dbClients = "";
        var pageSize = $('#currentUserInfo').attr('data-page-size');

        var readOnlyUser = $('#currentUserInfo').attr('data-read-only-user');

        var controlVisible = true;

        if (readOnlyUser != undefined && readOnlyUser == 'true') {

            controlVisible = false;

        }

        // if (stage != "") {
        //     getUrl = getUrl + "/" + stage;
        // }
        // if (status != "") {
        //     getUrl = getUrl + "/" + status;
        // }

        // if (selector == '#jobListGrid') {
        //     getUrl = getUrl + "?redirect=true"
        // }

        if ($(selector + ' .jsgrid-grid-header').attr('class') == undefined) {

            $(selector).jsGrid({
                height: "450px",
                width: "100%",

                filtering: false,
                editing: false,
                sorting: true,
                // paging: true,
                autoload: true,
                editButton: false,
                deleteButton: false,

                // pageSize: 10,
                // pageButtonCount: 5,

                noDataContent: "No data",

                controller: {

                    loadData: function(filter) {

                        return $.grep(dbClients, function(client) {

                            // return (!filter.job_id_value || client.job_id_value.toLowerCase().indexOf(filter.job_id_value.toLowerCase()) > -1)
                            //     && (!filter.book_id_value || client.book_id_value.toLowerCase().indexOf(filter.book_id_value.toLowerCase()) > -1)
                            //     && (!filter.title || client.title.toLowerCase().indexOf(filter.title.toLowerCase()) > -1)
                            //     && (!filter.series_title || client.series_title.toLowerCase().indexOf(filter.series_title.toLowerCase()) > -1)
                            //     && (!filter.category || client.category.toLowerCase().indexOf(filter.category.toLowerCase()) > -1)
                            //     && (!filter.copy_editing_level || client.copy_editing_level.toLowerCase().indexOf(filter.copy_editing_level.toLowerCase()) > -1)
                            //     && (!filter.author || client.author.toLowerCase().indexOf(filter.author.toLowerCase()) > -1)
                            //     && (!filter.publisher || client.publisher.toLowerCase().indexOf(filter.publisher.toLowerCase()) > -1)
                            //     && (!filter.status || client.status.toLowerCase().indexOf(filter.status.toLowerCase()) > -1)
                            //     && (!filter.start_date || client.start_date.toLowerCase().indexOf(filter.start_date.toLowerCase()) > -1)
                            //     && (!filter.due_date || client.due_date.toLowerCase().indexOf(filter.due_date.toLowerCase()) > -1)

                            return (!filter.job_id_value || (client.job_id_value != undefined && client.job_id_value != null && (client.job_id_value.toLowerCase().indexOf(filter.job_id_value.toLowerCase()) > -1))) &&
                                (!filter.isbn || (client.isbn != undefined && client.isbn != null && (client.isbn.toLowerCase().indexOf(filter.isbn.toLowerCase()) > -1))) &&
                                // (!filter.order_id || (client.order_id != undefined && client.order_id != null && (client.order_id.toLowerCase().indexOf(filter.order_id.toLowerCase()) > -1))) &&
                                (!filter.title || (client.title != undefined && client.title != null && (client.title.toLowerCase().indexOf(filter.title.toLowerCase()) > -1))) &&
                                (!filter.series_title || (client.series_title != undefined && client.series_title != null && (client.series_title.toLowerCase().indexOf(filter.series_title.toLowerCase()) > -1))) &&
                                (!filter.category || (client.category != undefined && client.category != null && (client.category.toLowerCase().indexOf(filter.category.toLowerCase()) > -1))) &&
                                (!filter.task_count || (client.task_count != undefined && client.task_count != null && (client.task_count.toLowerCase().indexOf(filter.task_count.toLowerCase()) > -1))) &&
                                (!filter.checklist_count || (client.checklist_count != undefined && client.checklist_count != null && (client.checklist_count.toLowerCase().indexOf(filter.checklist_count.toLowerCase()) > -1))) &&
                                (!filter.pm_empname || (client.pm_empname != undefined && client.pm_empname != null && (client.pm_empname.toLowerCase().indexOf(filter.pm_empname.toLowerCase()) > -1))) &&
                                (!filter.am_empname || (client.am_empname != undefined && client.am_empname != null && (client.am_empname.toLowerCase().indexOf(filter.am_empname.toLowerCase()) > -1))) &&
                                (!filter.project_type || (client.project_type != undefined && client.project_type != null && (client.project_type.toLowerCase().indexOf(filter.project_type.toLowerCase()) > -1))) &&
                                (!filter.copy_editing_level || (client.copy_editing_level != undefined && client.copy_editing_level != null && (client.copy_editing_level.toLowerCase().indexOf(filter.copy_editing_level.toLowerCase()) > -1))) &&
                                (!filter.author || (client.author != undefined && client.author != null && (client.author.toLowerCase().indexOf(filter.author.toLowerCase()) > -1))) &&
                                (!filter.stage || (client.stage != undefined && client.stage != null && (client.stage.toLowerCase().indexOf(filter.stage.toLowerCase()) > -1))) &&
                                (!filter.status || (client.status != undefined && client.status != null && (client.status.toLowerCase().indexOf(filter.status.toLowerCase()) > -1))) &&
                                (!filter.date_due || (client.date_due != undefined && client.date_due != null && (client.date_due.toLowerCase().indexOf(filter.date_due.toLowerCase()) > -1)));
                            // && (!filter.publisher || (client.publisher != undefined && client.publisher != null && (client.publisher.toLowerCase().indexOf(filter.publisher.toLowerCase()) > -1)));
                        });

                        // return $.ajax({
                        //     url: getUrl,
                        //     // data: filter,
                        //     dataType: "json"
                        // });

                    }
                },

                // fields: [
                //     { title: "JOB TITLE", name: "jobTitle", type: "text", width: 150 },
                //     { title: "PROJECT MANAGER", name: "projectManager", type: "text", width: 150 },
                //     { title: "AUTHOR", name: "author", type: "text", width: 150 },
                //     { title: "EDITOR", name: "editor", type: "text", width: 150 },
                //     { title: "PUBLISHER", name: "publisher", type: "text", width: 150 },
                //     { title: "START DATE", name: "start_date", type: "text", width: 150 },
                //     { title: "DUE DATE", name: "due_date", type: "text", width: 150 },
                //     // {
                //     //     type: "control",
                //     //     editButton: false,
                //     //     deleteButton: false,
                //     //     width: 60,
                //     //     // itemTemplate: function (value, item) {
                //     //     //     console.log(item);
                //     //     // }
                //     // }
                // ],

                // Book ID
                // Author
                // Title Name
                // Category
                // Copy_editing_level
                // Job Id
                // Publisher
                // Series Title

                fields: [
                    { title: "ID", name: "	job_id", type: "text", visible: false },
                    { title: "SPI JOB ID", name: "job_id_value", type: "text" },
                    { title: "ISBN", name: "isbn", type: "text" },
                    // { title: "BOOK ID", name: "order_id", type: "text"},
                    { title: "TITLE", name: "title", type: "text" },
                    // { title: "SERIES TITLE", name: "series_title", type: "text"},
                    { title: "CATEGORY", name: "category", type: "text" },
                    { title: "TASKS", name: "task_count", type: "text" },
                    { title: "CHECKLIST", name: "checklist_count", type: "text" },
                    { title: "PROJECT MANAGER", name: "pm_empname", type: "text" },
                    { title: "ACCOUNT MANAGER", name: "am_empname", type: "text" },
                    // { title: "COPY EDITING", name: "copy_editing_level", type: "text"},
                    { title: "AUTHOR", name: "author", type: "text" },
                    { title: "STAGE", name: "stage", type: "text" },
                    // { title: "PUBLISHER", name: "publisher", type: "text"},
                    { title: "STATUS", name: "status", type: "text" },
                    // { title: "DUE DATE", name: "date_due", type: "text"},
                    // {
                    //     type: "control",
                    //     editButton: false,
                    //     deleteButton: false,
                    //     width: 60,
                    //     // itemTemplate: function (value, item) {
                    //     //     console.log(item);
                    //     // }
                    // }

                    {
                        type: "control",
                        name: "Control",
                        editButton: false,
                        deleteButton: false,
                        headerTemplate: function() {

                            return this._createOnOffSwitchButton("filtering", this.searchModeButtonClass, false);

                        },
                        width: 60,
                    },

                ],

                // rowClick: function (args) {
                //     console.log(args.item.jobTitle);
                //     if (args.item.jobTitle != "") {

                //         var targetUrl = jobDetailUrl + '/' + encodeURIComponent(args.item.jobTitle).replace(/%20/g, '+');

                //         // window.location = jobDetailUrl + args.item.jobTitle;
                //         window.location = targetUrl;
                //     }
                // },
            });

        }

        var jobListPostData = {};

        if (gridType == 'dashboard') {

            if (status != undefined && status != '') {

                jobListPostData.status = status;

            }

            if (stage != undefined && stage != '') {

                jobListPostData.stage = stage;

            }

        }

        /* AJAX call to get Job status */
        $.ajax({

            url: getUrl,
            data: jobListPostData,
            dataType: "json"

        }).done(function(response) {

            if (response.success == "true") {

                if (response.data != "") {

                    response.data = formatDataItem(response.data);

                    dbClients = response.data;

                    $(selector).jsGrid("option", "data", response.data);

                    $('.jsgrid-grid-body').slimscroll({
                        height: '300px',
                    });

                }

            }

        });

        function formatDataItem(dataValue) {

            if (dataValue.length > 0) {

                for (var i = 0, len = dataValue.length; i < len; i++) {

                    dataValue[i].s_no = i + 1;

                    if (dataValue[i]["status"] != "" && dataValue[i]["status"] != undefined && (dataValue[i]["status"] == "true" || dataValue[i]["status"] == "false")) {

                        dataValue[i]["status"] = JSON.parse(dataValue[i]["status"]);

                    }
                }

            }

            return dataValue;

        }

        if (selector == '#jobListGrid') {

            $(selector).jsGrid("option", "filtering", true);

            // $('.list-modal-body').append($("#jobListGrid").html);
            $('.list-modal').modal('show');

        }
    }

    $(document).on('click', '.job-list', function() {

        var getUrl = "";
        var stage = "";
        var status = "";
        var count = "";
        var gridType = "";
        var selector = "#jobListGrid";
        // var jobDetailUrl = "http://localhost:81/pmbot/pmbot_v2/job/";
        var jobDetailUrl = "";
        jobDetailUrl = $('#job-list-data').attr('data-job-detail-base-url');
        getUrl = $('#job-list-data').attr('data-job-list-url');
        gridType = $('#job-list-data').attr('data-type');
        stage = $(this).attr('data-stage');
        status = $(this).attr('data-type');
        count = $(this).attr('data-count');

        if (count != undefined && count != '') {

            count = parseInt(count);

        }

        if (count > 0) {

            var jobModalTitleElement = $('.job-list-modal-title').attr('class');

            if (jobModalTitleElement != undefined && jobModalTitleElement != '') {

                var jobModalTitle = status + ' job list';

                $('.job-list-modal-title').text(jobModalTitle);

            }

            getJobList(selector, stage, status, gridType, getUrl, jobDetailUrl);

        }

    });

    $(document).on('click', '.stage-job-list', function() {

        var getUrl = "";
        var stage = "";
        var count = "";
        var type = "";
        var gridType = "";
        var selector = "#jobListGrid";
        // var jobDetailUrl = "http://localhost:81/pmbot/pmbot_v2/job/";
        var jobDetailUrl = "";
        jobDetailUrl = $('#job-list-data').attr('data-job-detail-base-url');
        getUrl = $('#job-list-data').attr('data-job-list-url');
        gridType = $('#job-list-data').attr('data-type');
        stage = $(this).attr('data-stage');
        type = $(this).attr('data-type');

        count = $(this).attr('data-count');

        if (count != undefined && count != '') {

            count = parseInt(count);

        }

        if (count > 0 && stage != undefined && stage != '' && type != undefined && type != '') {

            getJobList(selector, stage, type, gridType, getUrl, jobDetailUrl);

        }

    });

    $(document).on('click', '#jobDiaryTab', function() {

        var getUrl = '';

        getUrl = $('#jobDiaryTab').attr('data-job-history-url');

        if (getUrl != undefined && getUrl != '') {

            /* AJAX call to get Job history */
            $.ajax({

                url: getUrl,
                dataType: "json"

            }).done(function(response) {

                if (response.success == "true") {

                    if (response.data != "") {

                        $('.job-history-data').html(response.data);

                    }

                }

            });

        }

    });

    $(document).on('click', '#jobDiaryTab', function() {

        var getUrl = '';

        getUrl = $('#jobDiaryTab').attr('data-job-history-url');

        if (getUrl != undefined && getUrl != '') {

            /* AJAX call to get Job history */
            $.ajax({

                url: getUrl,
                dataType: "json"

            }).done(function(response) {

                if (response.success == "true") {

                    if (response.data != "") {

                        $('.job-history-data').html(response.data);

                    }

                }

            });

        }

    });

    $(document).on('click', '#jobTimelineTab', function() {

        var getUrl = '';

        getUrl = $('#jobTimelineTab').attr('data-job-timeline-url');

        if (getUrl != undefined && getUrl != '') {

            /* AJAX call to get Job timeline */
            $.ajax({

                url: getUrl,
                dataType: "json"

            }).done(function(response) {

                if (response.success == "true") {

                    if (response.data != "") {

                        $('.job-timeline-data').html(response.data);

                    }

                }

            });

        }

    });

    $(document).on('click', '#myDiaryTab', function() {

        var getUrl = '';

        getUrl = $('#myDiaryTab').attr('data-my-history-url');

        if (getUrl != undefined && getUrl != '') {

            /* AJAX call to get Job history */
            $.ajax({

                url: getUrl,
                dataType: "json"

            }).done(function(response) {

                if (response.success == "true") {

                    if (response.data != "") {

                        $('.my-history-data').html(response.data);

                        $('.my-history-data').slimscroll({

                            height: '300px',

                        });


                    }

                }

            });

        }

    });

    // $(document).on('click', '.job-add-submit-btn', function(e) {

    //     // e.preventDefault();

    //     if (/^[a-zA-Z0-9-_]*$/.test($('.job-isbn').val()) == false) {

    //         $('.job-isbn-error').addClass('text-danger');

    //         $('.job-isbn-error').text('ISBN contains only (-,_) special characters.');

    //         return false;

    //     }

    //     // return true;

    //     // $('.job-add-form').submit();

    // });

});

$(document).on('click', '.job-hold-btn', function(e) {

    e.preventDefault();

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to hold this job!",
        // icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        showClass: {
            popup: 'animated fadeInDownBig faster'
        },
        hideClass: {
            popup: 'animated fadeOut faster'
        },
    }).then((result) => {

        if (result.value != undefined && result.value == true) {

            $("#job_status_update_status").val('hold');
            $("#job_status_update_remarks").val('');
            $(".job-status-update-form").submit();

        }
    });

});

$(document).on('click', '.job-resume-btn', function(e) {

    e.preventDefault();

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to resume this job!",
        // icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        showClass: {
            popup: 'animated fadeInDownBig faster'
        },
        hideClass: {
            popup: 'animated fadeOut faster'
        },
    }).then((result) => {

        if (result.value != undefined && result.value == true) {

            $("#job_status_update_status").val('progress');
            $("#job_status_update_remarks").val('');
            $(".job-status-update-form").submit();

        }
    });

});

$(document).on('click', '.job-complete-btn', function(e) {

    // e.preventDefault();

    // const { value: text } = await Swal.fire({
    //     input: 'textarea',
    //     inputPlaceholder: 'Type your message here...',
    //     showCancelButton: true
    // })

    // if (text) {
    //     Swal.fire(text)
    // }

    Swal.fire({
        // title: 'Are you sure?',
        // text: "Do you want to close this job!",
        // text: "Please enter remarks:",
        // icon: 'warning',
        // type: "input",
        // inputPlaceholder: "remarks",
        html: '<textarea class="job-complete-remarks-field col-lg-12 col-md-12 col-sm-12 col-xs-12 pt-15" placeholder="Enter remarks"/>',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        showClass: {
            popup: 'animated fadeInDownBig faster'
        },
        hideClass: {
            popup: 'animated fadeOut faster'
        },
    }).then((result) => {

        if (result.value != undefined && result.value == true) {
			
			var remarksVal = $('.job-complete-remarks-field').val();

			if (remarksVal == undefined || remarksVal == false || remarksVal == '') {

				Swal.fire({

					title: '',
					text: "Please enter remarks!",
					showClass: {
						popup: 'animated fadeIn faster'
					},
					hideClass: {
						popup: 'animated fadeOut faster'
					},

				});

				return false
			}

            $("#job_status_update_status").val('completed');
            $("#job_status_update_remarks").val(remarksVal);

            $(".job-status-update-form").submit();

        }
    });

});