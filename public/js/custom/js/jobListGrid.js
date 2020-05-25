$(function() {

    $('.dashboard-recent-activity').slimScroll({
        height: '24.2em'
    });

    // $('#delayedJobList').slimScroll({
    //     height: '30.2em'
    // });

    function getJobList(selector, stage, status, gridType, getUrl, jobDetailUrl) {

        var dbClients = "";

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

                            // return (!filter.job_id_value || client.job_id_value.indexOf(filter.job_id_value) > -1)
                            //     && (!filter.book_id_value || client.book_id_value.indexOf(filter.book_id_value) > -1)
                            //     && (!filter.title || client.title.indexOf(filter.title) > -1)
                            //     && (!filter.series_title || client.series_title.indexOf(filter.series_title) > -1)
                            //     && (!filter.category || client.category.indexOf(filter.category) > -1)
                            //     && (!filter.copy_editing_level || client.copy_editing_level.indexOf(filter.copy_editing_level) > -1)
                            //     && (!filter.author || client.author.indexOf(filter.author) > -1)
                            //     && (!filter.publisher || client.publisher.indexOf(filter.publisher) > -1)
                            //     && (!filter.status || client.status.indexOf(filter.status) > -1)
                            //     && (!filter.start_date || client.start_date.indexOf(filter.start_date) > -1)
                            //     && (!filter.due_date || client.due_date.indexOf(filter.due_date) > -1)

                            return (!filter.job_id_value || client.job_id_value.indexOf(filter.job_id_value) > -1) &&
                                (!filter.order_id || client.order_id.indexOf(filter.order_id) > -1) &&
                                (!filter.title || client.title.indexOf(filter.title) > -1) &&
                                (!filter.series_title || client.series_title.indexOf(filter.series_title) > -1) &&
                                (!filter.task_count || client.task_count.indexOf(filter.task_count) > -1) &&
                                (!filter.checklist_count || client.checklist_count.indexOf(filter.checklist_count) > -1) &&
                                (!filter.pm_empname || client.pm_empname.indexOf(filter.pm_empname) > -1) &&
                                (!filter.am_empname || client.am_empname.indexOf(filter.am_empname) > -1) &&
                                (!filter.project_type || client.project_type.indexOf(filter.project_type) > -1) &&
                                (!filter.copy_editing_level || client.copy_editing_level.indexOf(filter.copy_editing_level) > -1) &&
                                (!filter.author || client.author.indexOf(filter.author) > -1) &&
                                (!filter.stage || client.stage.indexOf(filter.stage) > -1) &&
                                (!filter.status || client.status.indexOf(filter.status) > -1) &&
                                (!filter.date_due || client.date_due.indexOf(filter.date_due) > -1);
                            // && (!filter.publisher || client.publisher.indexOf(filter.publisher) > -1)
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
                    // { title: "CATEGORY", name: "project_type", type: "text"},
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

});