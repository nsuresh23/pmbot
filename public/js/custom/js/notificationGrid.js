$(function() {

    function getNotificationTableList(gridSelector) {

        var gridType = $(gridSelector).attr('data-type');
        var currentUserId = $(gridSelector).attr('data-current-user-id');
        var currentJobId = $(gridSelector).attr('data-current-job-id');
        var listUrl = $(gridSelector).attr('data-list-url');
        var currentRoute = $(gridSelector).attr('data-current-route');
        var readUrl = $(gridSelector).attr('data-read-url');
        var readAllUrl = $(gridSelector).attr('data-read-all-url');
        var deleteUrl = $(gridSelector).attr('data-delete-url');
        var readOnlyUser = $('#currentUserInfo').attr('data-read-only-user');

        var controlVisible = true;

        // if (readOnlyUser != undefined && readOnlyUser == 'true') {

        //     controlVisible = false;

        // }

        var dbClients = "";

        if ($(gridSelector + ' .jsgrid-grid-header').attr('class') == undefined) {

            $(gridSelector).jsGrid({

                height: "450px",
                width: "100%",

                filtering: true,
                inserting: controlVisible,
                editing: controlVisible,
                sorting: true,
                paging: false,
                autoload: true,

                pageSize: 10,
                pageButtonCount: 5,

                // deleteConfirm: "Do you really want to delete the client?",

                confirmDeleting: false,

                noDataContent: "No data",

                invalidNotify: function(args) {

                    $('#alert-error-not-submit').removeClass('hidden');

                },

                controller: {

                    loadData: function(filter) {

                        return $.grep(dbClients, function(client) {
                            return (!filter.title || client.title.toLowerCase().indexOf(filter.title.toLowerCase()) > -1) &&
                                (!filter.message || client.stage.toLowerCase().indexOf(filter.message.toLowerCase()) > -1);
                        });
                    }
                },

                rowClick: function(args) {

                    $(gridSelector).jsGrid("cancelEdit");

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

                        $.MessageBox({

                            buttonDone: "Yes",
                            buttonFail: "No",
                            message: "Are You Sure?"

                        }).done(function() {

                            deleteItem(args, deleteUrl, gridSelector);

                        }).fail(function() {

                            return false;

                        });

                    }

                },

                // onDataLoading: loadGridItem(listUrl),

            });

        }

        var field = [];

        field = [{
                title: "S.NO",
                name: "s_no",
                type: "number",
                inserting: false,
                filtering: false,
                editing: false,
                width: 50
            },
            {
                title: "ID",
                name: "id",
                type: "text",
                inserting: false,
                editing: false,
                visible: false,
                width: 150
            },
            {
                title: "TITLE",
                name: "title",
                type: "text",
                width: 150
            },
            {
                title: "MESSAGE",
                name: "message",
                type: "text",
                width: 100
            },
            {
                title: "STATUS",
                name: "createdby_status",
                type: "text",
                width: 150
            },
            {
                // type: "control",
                // name: "Control",
                // editButton: controlVisible,
                // deleteButton: controlVisible,
                updateButtonClass: "jsgrid-update-button",

                type: "control",
                editButton: false,
                deleteButton: false,
                itemTemplate: function(value, item) {
                    var $iconPencil = $("<i>").attr({ class: "glyphicon glyphicon-pencil" });
                    var $iconTrash = $("<i>").attr({ class: "glyphicon glyphicon-trash" });

                    var $customEditButton = $("<button>")
                        .attr({ class: "btn btn-warning btn-xs" })
                        .attr({ role: "button" })
                        .attr({ title: jsGrid.fields.control.prototype.editButtonTooltip })
                        .attr({ id: "btn-edit-" + item.id })
                        .click(function(e) {
                            alert("ID: " + item.id);
                            // document.location.href = item.id + "/edit";
                            e.stopPropagation();
                        })
                        .append($iconPencil);
                    var $customDeleteButton = $("<button>")
                        .attr({ class: "btn btn-danger btn-outline" })
                        .attr({ role: "button" })
                        .attr({ title: jsGrid.fields.control.prototype.deleteButtonTooltip })
                        .attr({ id: "btn-delete-" + item.id })
                        .click(function(e) {
                            alert("ID: " + item.id);
                            // document.location.href = item.id + "/delete";
                            e.stopPropagation();
                        })
                        .append($iconTrash);

                    return $("<div>").attr({ class: "btn-toolbar" })
                        .append($customEditButton)
                        .append($customDeleteButton);
                }

            },
        ];


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

        if (gridType == 'dashboard') {

            if (currentUserId != undefined && currentUserId) {

                taskListPostData.user_id = currentUserId;

            }

        }

        if (gridType == 'jobDetail') {

            if (currentJobId != undefined && currentJobId) {

                taskListPostData.job_id = currentJobId;

            }

        }

        /* AJAX call to get list */
        $.ajax({

            url: listUrl,
            data: taskListPostData,
            dataType: "json"

        }).done(function(response) {

            if (response.success == "true") {

                // response.data = formatDataItem(response.data);

                dbClients = response.data;

                $(gridSelector).jsGrid("option", "data", response.data);

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

    }


    var gridSelector = ".notificationGrid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        getNotificationTableList(gridSelector);

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

        $(".taskGrid .jsgrid-insert-mode-button").on('click', function() {

            // if (gridType == 'detail') {

            var jobId = $('.taskGrid').attr('data-current-job-id');
            var gridType = $('.taskGrid').attr('data-category');
            var currentRoute = $('.taskGrid').attr('data-current-route');

            var url = $('.taskGrid').attr('data-add-url');

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

    });

});