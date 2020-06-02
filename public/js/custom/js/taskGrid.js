$(function() {

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


    function getTaskTableList(gridSelector) {

        var gridType = $(gridSelector).attr('data-type');
        var gridCategory = $(gridSelector).attr('data-category');
        var addTaskOption = $(gridSelector).attr('data-add-task-option');
        var currentUserId = $(gridSelector).attr('data-current-user-id');
        var currentJobId = $(gridSelector).attr('data-current-job-id');
        var listUrl = $(gridSelector).attr('data-list-url');
        var currentRoute = $(gridSelector).attr('data-current-route');
        var addUrl = $(gridSelector).attr('data-add-url') + "?redirectTo=" + currentRoute;
        var editUrl = $(gridSelector).attr('data-edit-url');
        var deleteUrl = $(gridSelector).attr('data-delete-url');
        var readOnlyUser = $('#currentUserInfo').attr('data-read-only-user');

        var taskStatusFilter = $(gridSelector).attr('task-status-filter');

        var insertControlVisible = true;
        var editControlVisible = false;
        var deleteControlVisible = true;

        if (readOnlyUser != undefined && readOnlyUser == 'true') {

            insertControlVisible = false;
            editControlVisible = false;
            deleteControlVisible = false;

        }

        if (gridType == 'dashboard') {

            insertControlVisible = false;

        }

        if (gridCategory != undefined && (gridCategory == 'drafttask' || gridCategory == 'jobdrafttask')) {

            editControlVisible = true;

        }

        insertControlVisible = false;

        // if (addTaskOption == 'true') {

        //     insertControlVisible = true;

        // }

        var dbClients = "";

        deleteControlVisible = false;

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
                            return (!filter.title || client.title.indexOf(filter.title) > -1) &&
                                (!filter.type || client.type.indexOf(filter.type) > -1) &&
                                (!filter.assignedto_empname || client.assignedto_empname.indexOf(filter.assignedto_empname) > -1) &&
                                (!filter.createdby_empname || client.createdby_empname.indexOf(filter.createdby_empname) > -1) &&
                                (!filter.status || client.status.indexOf(filter.status) > -1) &&
                                (!filter.stage || client.stage.indexOf(filter.stage) > -1) &&
                                (!filter.category || client.category.indexOf(filter.category) > -1) &&
                                (!filter.book_job_id || client.book_job_id.indexOf(filter.book_job_id) > -1) &&
                                //(!filter.womat_job_id || client.womat_job_id.indexOf(filter.womat_job_id) > -1) &&
                                (!filter.job_title || client.job_title.indexOf(filter.job_title) > -1);
                        });

                    }
                },

                rowClick: function(args) {

                    $(gridSelector).jsGrid("cancelEdit");

                },

                rowClass: function(item, itemIndex) {

                    var rowClassName = 'parent-task-row';

                    if (item.parent_task_id != undefined && item.parent_task_id != 'null' && item.parent_task_id != '' && item.parent_task_id != '0') {

                        rowClassName = 'sub-task-row';

                    }

                    return rowClassName;

                },

                onItemInserting: function(args, value) {

                    if (itemEmptyOrExistsCheck(gridSelector, 'name', args.item.name)) {

                        addItem(args, addUrl, gridSelector);

                    } else {

                        args.cancel = true;

                    }

                },

                onItemUpdating: function(args) {

                    editItem(args, editUrl, gridSelector);

                    return false;

                },

                onItemDeleting: function(args) {

                    if (!args.item.deleteConfirmed) { // custom property for confirmation

                        args.cancel = true; // cancel deleting

                        Swal.fire({

                            title: 'Are you sure?',
                            text: "Do you want to remove this!",
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

                                deleteItem(args, deleteUrl, gridSelector);

                            }

                        });

                        // $.MessageBox({

                        //     buttonDone: "Yes",
                        //     buttonFail: "No",
                        //     message: "Are You Sure?"

                        // }).done(function() {

                        //     deleteItem(args, deleteUrl, gridSelector);

                        // }).fail(function() {

                        //     return false;

                        // });

                    }

                },

                // onDataLoading: loadGridItem(listUrl),

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
            width: 50
        });

        field.push({
            title: "ID",
            name: "id",
            type: "text",
            inserting: false,
            editing: false,
            visible: false,
            // width: 150
        });

        field.push({
            title: "TITLE",
            name: "title",
            type: "text",
            // width: 150
        });

        if ((gridCategory != undefined && gridCategory == 'mytask') || gridType == 'jobDetail') {

            field.push({
                title: "TYPE",
                name: "type",
                type: "text",
            });

        }

        if (gridCategory != undefined && gridCategory != 'mytask') {

            field.push({
                title: "ASSIGNEE",
                name: "assignedto_empname",
                type: "text",
                // width: 150
            });

        } else {

            field.push({
                title: "ASSIGNER",
                name: "createdby_empname",
                type: "text",
                // width: 150
            });

        }

        if (gridType == 'jobDetail') {

            field.push({
                title: "ASSIGNER",
                name: "createdby_empname",
                type: "text",
                // width: 150
            });

        }

        if (gridType == 'dashboard') {

            field.push({
                title: "STAGE",
                name: "stage",
                type: "text",
                // width: 50
            });

        }

        if ((gridType == 'dashboard' && gridCategory == 'opentask') ||
            (gridType == 'jobDetail' && gridCategory != undefined && gridCategory != 'jobdrafttask')
        ) {

            field.push({
                title: "STATUS",
                name: "status",
                type: "text",
                // width: 150
            });

        }

        field.push({
            title: "PRIORITY",
            name: "category",
            type: "text",
            // width: 100
        });

        if (gridType == 'dashboard') {

            field.push({
                title: "BOOK ID",
                name: "book_job_id",
                type: "text",
                // width: 100
            });

            /*             field.push({
                            title: "WOMAT JOB ID",
                            name: "womat_job_id",
                            type: "text",
                            // width: 150
                        });
             */
            field.push({
                title: "JOB TITLE",
                name: "job_title",
                type: "text",
                // width: 150
            });

        }

        field.push({
            type: "control",
            name: "Control",
            editButton: editControlVisible,
            deleteButton: deleteControlVisible,
            updateButtonClass: "jsgrid-update-button",
            headerTemplate: function() {

                var insertButton = '';
                var searchButton = '';

                if (gridCategory != undefined && (gridCategory == 'querylist' || gridCategory == 'opentask' || gridCategory == 'jobtask')) {

                    if (addTaskOption != undefined && addTaskOption == "true") {

                        insertButton = $("<button>").attr("type", "button").addClass("jsgrid-button jsgrid-mode-button jsgrid-insert-mode-button").on("click",
                            function() {

                                newTaskAdd(gridSelector);

                            }
                        );

                    }

                }

                searchButton = this._createOnOffSwitchButton("filtering", this.searchModeButtonClass, false);

                return result = [searchButton, insertButton];

                // return false;
            }
        });

        // field = [{
        //         title: "S.NO",
        //         name: "s_no",
        //         type: "number",
        //         inserting: false,
        //         filtering: false,
        //         editing: false,
        //         width: 50
        //     },
        //     {
        //         title: "ID",
        //         name: "id",
        //         type: "text",
        //         inserting: false,
        //         editing: false,
        //         visible: false,
        //         width: 150
        //     },
        //     {
        //         title: "TASK TITLE",
        //         name: "title",
        //         type: "text",
        //         width: 150
        //     },
        //     {
        //         title: "Assignee",
        //         name: "assignedto_empname",
        //         type: "text",
        //         width: 150
        //     },
        //     {
        //         title: "STAGE",
        //         name: "stage",
        //         type: "text",
        //         width: 50
        //     },
        //     {
        //         title: "PRIORITY",
        //         name: "category",
        //         type: "text",
        //         width: 100
        //     },
        //     {
        //         title: "BOOK ID",
        //         name: "order_id",
        //         type: "text",
        //         width: 100
        //     },
        //     {
        //         title: "WOMAT JOB ID",
        //         name: "womat_job_id",
        //         type: "text",
        //         width: 150
        //     },
        //     {
        //         title: "JOB TITLE",
        //         name: "job_title",
        //         type: "text",
        //         width: 150
        //     },
        //     {
        //         type: "control",
        //         name: "Control",
        //         editButton: editControlVisible,
        //         deleteButton: deleteControlVisible,
        //         updateButtonClass: "jsgrid-update-button",
        //         headerTemplate: function() {

        //             if (addTaskOption == 'true') {

        //                 return $("<button>").attr("type", "button").addClass("jsgrid-button jsgrid-mode-button jsgrid-insert-mode-button").on("click",
        //                     function() {
        //                         newTaskAdd(gridSelector);
        //                     }
        //                 );

        //             }

        //             return false;
        //         }
        //     },
        // ];

        // if (gridType == 'jobDetail') {

        //     field = [{
        //             title: "S.NO",
        //             name: "s_no",
        //             type: "number",
        //             inserting: false,
        //             filtering: false,
        //             editing: false,
        //             width: 50
        //         },
        //         {
        //             title: "ID",
        //             name: "id",
        //             type: "text",
        //             inserting: false,
        //             editing: false,
        //             visible: false,
        //             width: 150
        //         },
        //         {
        //             title: "TITLE",
        //             name: "title",
        //             type: "text",
        //             width: 150
        //         },
        //         {
        //             title: "STAGE",
        //             name: "stage",
        //             type: "text",
        //             width: 50
        //         },
        //         {
        //             title: "STATUS",
        //             name: "status",
        //             type: "text",
        //             width: 150
        //         },
        //         {
        //             title: "PRIORITY",
        //             name: "category",
        //             type: "text",
        //             width: 100
        //         },
        //         {
        //             type: "control",
        //             name: "Control",
        //             editButton: editControlVisible,
        //             deleteButton: deleteControlVisible,
        //             updateButtonClass: "jsgrid-update-button",
        //             headerTemplate: function() {

        //                 return $("<button>").attr("type", "button").addClass("jsgrid-button jsgrid-mode-button jsgrid-insert-mode-button").on("click",
        //                     function() {
        //                         newTaskAdd(gridSelector);
        //                     }
        //                 );

        //             }

        //             // type: "control", editButton: false, deleteButton: false,
        //             // itemTemplate: function (value, item) {
        //             //     var $iconPencil = $("<i>").attr({ class: "glyphicon glyphicon-pencil" });
        //             //     var $iconTrash = $("<i>").attr({ class: "glyphicon glyphicon-trash" });

        //             //     var $customEditButton = $("<button>")
        //             //         .attr({ class: "btn btn-warning btn-xs" })
        //             //         .attr({ role: "button" })
        //             //         .attr({ title: jsGrid.fields.control.prototype.editButtonTooltip })
        //             //         .attr({ id: "btn-edit-" + item.id })
        //             //         .click(function (e) {
        //             //             alert("ID: " + item.id);
        //             //             // document.location.href = item.id + "/edit";
        //             //             e.stopPropagation();
        //             //         })
        //             //         .append($iconPencil);
        //             //     var $customDeleteButton = $("<button>")
        //             //         .attr({ class: "btn btn-danger btn-outline" })
        //             //         .attr({ role: "button" })
        //             //         .attr({ title: jsGrid.fields.control.prototype.deleteButtonTooltip })
        //             //         .attr({ id: "btn-delete-" + item.id })
        //             //         .click(function (e) {
        //             //             alert("ID: " + item.id);
        //             //             // document.location.href = item.id + "/delete";
        //             //             e.stopPropagation();
        //             //         })
        //             //         .append($iconTrash);

        //             //     return $("<div>").attr({ class: "btn-toolbar" })
        //             //         .append($customEditButton)
        //             //         .append($customDeleteButton);
        //             // }

        //         },
        //     ];

        // }

        $(gridSelector).jsGrid("option", "fields", field);

        $(gridSelector).jsGrid("option", "editItem", function(item) {

            // if (gridType == 'detail') {

            var url = editUrl + "/" + item.task_id;

            var gridType = $(gridSelector).attr('data-category');

            var currentRoute = $(gridSelector).attr('data-current-route');

            var jobId = $(gridSelector).attr('data-job-id');

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

        });

        var taskListPostData = {};

        // if (gridType == 'dashboard') {

        //     if (currentUserId != undefined && currentUserId) {

        //         taskListPostData.user_id = currentUserId;

        //     }

        // }

        if (gridType == 'jobDetail') {

            if (currentJobId != undefined && currentJobId) {

                taskListPostData.job_id = currentJobId;

            }


            if (taskStatusFilter != undefined && taskStatusFilter) {

                taskListPostData.task_status_filter = taskStatusFilter;

            }

        }

        /* AJAX call to get list */
        $.ajax({

            url: listUrl,
            data: taskListPostData,
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

                    $(gridSelector).parent().prev().find('.result-count').html('(' + response.result_count + ')');
                    // $(gridSelector).parent().prev().find('.result-count').addClass('result-count-icon-badge');

                } else {

                    $(gridSelector).parent().prev().find('.result-count').html('');
                    // $(gridSelector).parent().prev().find('.result-count').removeClass('result-count-icon-badge');

                }

            } else {

                $(gridSelector).parent().prev().find('.result-count').html('');
                // $(gridSelector).parent().prev().find('.result-count').removeClass('result-count-icon-badge');

            }

        });

        function addItem(args, addUrl, gridSelector) {

            var type = '';
            var message = '';

            args.item.redirectTo = gridType;

            var d = $.Deferred();

            /* AJAX call to get grid data */
            $.ajax({
                url: addUrl,
                data: args.item,
                dataType: "json"
            }).done(function(response) {

                if (response.success == "true") {

                    // dbClients = response.data;

                    type = 'success';

                    response.data = formatDataItem(response.data);

                    $(gridSelector).jsGrid("option", "data", response.data);

                } else {

                    type = 'error';

                    d.resolve();

                }

                message = response.message;

                flashMessage(type, message);

            });

            return d.promise();

        }

        function editItem(args, editUrl, gridSelector) {

            var type = '';
            var message = '';

            args.item.redirectTo = gridType;

            var d = $.Deferred();

            /* AJAX call */
            $.ajax({

                url: editUrl,
                data: args.item,
                dataType: "json"

            }).done(function(response) {

                if (response.success == "true") {

                    type = 'success';

                    response.data = formatDataItem(response.data);

                    $(gridSelector).jsGrid("option", "data", response.data);

                } else {

                    type = 'error';

                    d.resolve();

                }

                message = response.message;

                flashMessage(type, message);

            });

            return d.promise();

        }

        function deleteItem(args, deleteUrl, gridSelector) {

            var type = '';
            var message = '';

            var taskDeletePostData = {};

            taskDeletePostData.task_id = args.item.task_id;

            if (gridType == 'dashboard') {

                taskDeletePostData.assignedto_empcode = currentUserId;

            }

            if (gridType != 'dashboard') {

                taskDeletePostData.job_id = args.item.job_id;

            }

            var d = $.Deferred();

            /* AJAX call */
            $.ajax({

                url: deleteUrl,
                data: taskDeletePostData,
                dataType: "json"

            }).done(function(response) {

                if (response.success == "true") {

                    type = 'success';

                    response.data = formatDataItem(response.data);

                    $(gridSelector).jsGrid("option", "data", response.data);

                } else {

                    type = 'error';

                    d.resolve();

                }

                message = response.message;

                flashMessage(type, message);

            });

            return d.promise();

        }

        function formatDataItem(dataValue) {

            if (dataValue.length > 0) {


                for (var i = 0, len = dataValue.length; i < len; i++) {


                    dataValue[i].s_no = i + 1;


                }

            }

            return dataValue;

        }

        function itemEmptyOrExistsCheck(gridSelector, field, value) {

            if (value == '') {

                message = field + ' is required field';

                fieldMessage(field, message);

                return false;

            }

            var gridData = $(gridSelector).jsGrid("option", "data");

            for (var i = 0, len = gridData.length; i < len; i++) {

                if (gridData[i][field] === value) {

                    message = field + ' value already exists';

                    fieldMessage(value, message);

                    return false;

                }
            }

            return true;

        }

        // $(".taskGrid .jsgrid-insert-mode-button").on('click', function () {

        //     // if (gridType == 'detail') {

        //         window.location = addUrl;

        //     // }

        // });

    }


    var getUrl = "";
    var postUrl = "";
    var gridType = "";
    var gridSelector = ".myTaskGrid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        getTaskTableList(gridSelector);

    }

    var jobTaskGridSelector = ".jobTaskGrid";

    var jobTaskGridDataUrl = $(jobTaskGridSelector).attr('data-list-url');

    if (jobTaskGridDataUrl != undefined && jobTaskGridDataUrl != "") {

        getTaskTableList(jobTaskGridSelector);

        setTimeout(() => {

            getCheckListTableList(".jobDetailTaskJobCheckList");

        }, 1000);

        setTimeout(() => {

            getCheckListTableList(".jobDetailTaskGlobalCheckList");

        }, 1000);

    }

    // $(document).on('click', '#taskViewSearch', function () {

    //     var targetUrl = $('#taskView').attr('data-url');

    //     if ($('#taskViewSearchInput').val() != "") {

    //         var detailUrl = $(this).attr('data-task-view-base-url');

    //         targetUrl = detailUrl + '/' + encodeURIComponent($('#taskViewSearchInput').val()).replace(/%20/g, '+');

    //     }

    //     if (targetUrl != "") {

    //         window.location = targetUrl;

    //     }

    // });

    // $(".taskGrid .jsgrid-insert-mode-button").on('click', function () {

    //     // if (gridType == 'detail') {

    //     window.location = addUrl;

    //     // }

    // });

    $(document).ready(function() {

        $("#jobTaskTab").on('click', function() {

            $('.email-detail-body').hide();

            var gridSelector = ".jobTaskGrid";

            var dataUrl = $(gridSelector).attr('data-list-url');

            $(gridSelector).attr('task-status-filter', '');

            if (dataUrl != undefined && dataUrl != "") {

                getTaskTableList(gridSelector);

            }

            // setTimeout(() => {

            //     getEmailTableList(".myEmailGrid");

            // }, 1000);

            setTimeout(() => {

                getCheckListTableList(".jobDetailTaskJobCheckList");

            }, 1000);

            setTimeout(() => {

                getCheckListTableList(".jobDetailTaskGlobalCheckList");

            }, 1000);

        });

        $(".jobClosedTaskTab").on('click', function() {

            $('.email-detail-body').hide();

            var gridSelector = ".jobTaskGrid";

            var dataUrl = $(gridSelector).attr('data-list-url');

            $(gridSelector).attr('task-status-filter', 'closed');

            if (dataUrl != undefined && dataUrl != "") {

                getTaskTableList(gridSelector);

            }

        });

        $("#jobEmailListTab").on('click', function() {

            $('.email-detail-body').hide();

            var gridSelector = ".jobEmailGrid";

            var dataUrl = $(gridSelector).attr('data-list-url');

            if (dataUrl != undefined && dataUrl != "") {

                getEmailTableList(gridSelector);

            }

            setTimeout(() => {

                getCheckListTableList(".jobDetailEmailJobCheckList");

            }, 1000);

            setTimeout(() => {

                getCheckListTableList(".jobDetailEmailGlobalCheckList");

            }, 1000);

        });

        $(".assignedUserDescTab").on('click', function() {

            var gridSelector = ".taskActivities";

            var dataUrl = $(gridSelector).attr('data-common-list-url');

            if (dataUrl != undefined && dataUrl != "") {

                // if ($(this).attr('data-assignee-id') != undefined && $(this).attr('data-assignee-id') != '') {

                //     dataUrl = dataUrl + '?assignedEmpcode=' + $(this).attr('data-assignee-id');

                // }

                // if ($(gridSelector).attr('data-created-empcode') != undefined && $(".assignedUserDescTab").attr('data-created-empcode') != '') {

                //     dataUrl = dataUrl + '&createdEmpcode=' + $(gridSelector).attr('data-created-empcode');

                // }

                if ($(this).attr('data-assignee-note-list-url') != undefined && $(this).attr('data-assignee-note-list-url') != '') {

                    dataUrl = $(this).attr('data-assignee-note-list-url');

                }

                $(gridSelector).attr('data-list-url', dataUrl);

                getTaskActivitiesTableList(gridSelector);

            }

        });


        $("#myTaskTab").on('click', function() {

            $('.email-detail-body').hide();

            var gridSelector = ".myTaskGrid";

            // if ($('.myTaskGrid .jsgrid-grid-header').attr('class') == undefined) {

            var dataUrl = $(gridSelector).attr('data-list-url');

            if (dataUrl != undefined && dataUrl != "") {

                getTaskTableList(gridSelector);

            }

            setTimeout(() => {

                getEmailTableList(".myEmailGrid");

            }, 1000);

            // } else {

            //     var dbClients = "";
            //     var gridType = $(gridSelector).attr('data-type');
            //     var listUrl = $(gridSelector).attr('data-list-url');

            //     loadGridItem(listUrl, gridSelector, gridType, dbClients);

            //     $(gridSelector).jsGrid("reset");

            // }

        });

        $("#queryListTab").on('click', function() {

            $('.email-detail-body').hide();

            var gridSelector = ".queryListGrid";

            var dataUrl = $(gridSelector).attr('data-list-url');

            if (dataUrl != undefined && dataUrl != "") {

                getTaskTableList(gridSelector);

            }

        });

        $("#openTaskTab").on('click', function() {

            $('.email-detail-body').hide();

            var gridSelector = ".openTaskGrid";

            var dataUrl = $(gridSelector).attr('data-list-url');

            if (dataUrl != undefined && dataUrl != "") {

                getTaskTableList(gridSelector);

            }

        });

        $("#nonBusinessEmailsTab").on('click', function() {

            $('.email-detail-body').hide();

            getEmailTableList(".nonBusinessEmailGrid");

        });

        $("#businessEmailsTab").on('click', function() {

            $('.email-detail-body').hide();

            getEmailTableList(".businessEmailGrid");

        });

        $("#draftTaskTab").on('click', function() {

            $('.email-detail-body').hide();

            var gridSelector = ".draftTaskGrid";

            var dataUrl = $(gridSelector).attr('data-list-url');

            if (dataUrl != undefined && dataUrl != "") {

                getTaskTableList(gridSelector);

            }

        });

        // $("#openTask .jsgrid-insert-mode-button").on('click', function() {

        //     newTaskAdd('.openTaskGrid');

        // });

        // $(".jobTaskGrid .jsgrid-insert-mode-button").on('click', function() {

        //     newTaskAdd('.jobTaskGrid');

        // });

    });

});

// $('.myTaskGrid .jsgrid-grid-body').slimscroll({
//     height: '520px',
// });

// $('.draftTaskGrid .jsgrid-grid-body').slimscroll({
//     height: '520px',
// });

// $('.openTaskGrid .jsgrid-grid-body').slimscroll({
//     height: '520px',
// });

// $('.my-history-data').slimscroll({
//     height: '520px',
// });

// $('.jobTaskGrid .jsgrid-grid-body').slimscroll({
//     height: '520px',
// });

// $('.task-checklists').slimscroll({
//     height: '250px',
// });

if ($('.countdown').attr('class') != undefined && $('.countdown').attr('data-date') != undefined && $('.countdown').attr('data-date') != '') {

    var finalDate = $('.countdown').attr('data-date');

    finalDate = moment(finalDate).format('YYYY/MM/DD, H:mm:ss');

    $('.countdown').countdown(finalDate, { elapse: true })
        .on('update.countdown', function(event) {
            var $this = $(this).html(event.strftime('' +
                '<span>%-w</span> week%!w ' +
                '<span>%-d</span> day%!d ' +
                '<span>%H</span> hr ' +
                '<span>%M</span> min ' +
                '<span>%S</span> sec'));
            if (event.elapsed) {
                $this.removeClass('text-warning');
                $this.addClass('text-danger');
            }
        });

}