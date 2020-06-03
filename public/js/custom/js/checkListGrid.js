// $(function() {

function newCheckListAdd(selector) {

    var jobId = $(selector).attr('data-job-id');
    var gridType = $(selector).attr('data-category');
    var gridCategory = $(selector).attr('data-checklist-type');
    var currentRoute = $(selector).attr('data-current-route');

    var url = $(selector).attr('data-add-url');

    if (gridType != undefined && gridType != '') {

        url = url + "?type=" + gridType;

    }

    if (gridCategory != undefined && gridCategory != '') {

        url = url + "&category=" + gridCategory;

    }

    if (jobId != undefined && jobId != '') {

        url = url + "&job_id=" + jobId;

    }

    if (currentRoute != undefined && currentRoute != '') {

        url = url + "&redirectTo=" + currentRoute;

    }

    var addUrl = url;

    window.location = addUrl;

}

function getCheckListTableList(gridSelector) {

    var gridType = $(gridSelector).attr('data-type');
    var jobId = $(gridSelector).attr('data-job-id');
    var gridCategory = $(gridSelector).attr('data-category');
    var type = $(gridSelector).attr('data-checklist-type');
    var addCheckListOption = $(gridSelector).attr('data-add-option');
    var listUrl = $(gridSelector).attr('data-list-url');
    var currentRoute = $(gridSelector).attr('data-current-route');
    var addUrl = $(gridSelector).attr('data-add-url') + "?redirectTo=" + currentRoute;
    var editUrl = $(gridSelector).attr('data-edit-url');
    var deleteUrl = $(gridSelector).attr('data-delete-url');
    var readOnlyUser = $('#currentUserInfo').attr('data-read-only-user');

    var insertControlVisible = true;
    var editControlVisible = false;
    var deleteControlVisible = false;

    var dbClients = "";

    if (gridType == 'jobDetail' && gridCategory == 'global') {

        insertControlVisible = false;

    }

    if (readOnlyUser != undefined && readOnlyUser == 'true') {

        insertControlVisible = false;
        editControlVisible = false;
        deleteControlVisible = false;

    }

    insertControlVisible = false;

    // controlVisible = false;

    if ($(gridSelector + ' .jsgrid-grid-header').attr('class') == undefined) {

        $(gridSelector).jsGrid({

            height: "450px",
            width: "100%",

            filtering: false,
            inserting: insertControlVisible,
            editing: editControlVisible,
            sorting: true,
            paging: false,
            autoload: true,

            pageSize: 10,
            pageButtonCount: 5,

            // deleteConfirm: "Do you really want to delete the client?",

            confirmDeleting: false,

            noDataContent: "No data",

            loadIndication: true,
            // loadIndicationDelay: 500,
            loadMessage: "Please, wait...",
            loadShading: true,

            invalidNotify: function(args) {

                $('#alert-error-not-submit').removeClass('hidden');

            },

            controller: {

                loadData: function(filter) {

                    if (gridType == 'jobDetail' && gridCategory == 'job') {

                        return $.grep(dbClients, function(client) {
                            return (!filter.title || client.title.indexOf(filter.title) > -1) &&
                                (!filter.task_title || client.task_title.indexOf(filter.task_title) > -1) &&
                                (!filter.empcode || client.empcode.indexOf(filter.empcode) > -1);
                        });

                    } else {

                        return $.grep(dbClients, function(client) {

                            return (!filter.title || client.title.indexOf(filter.title) > -1) &&
                                (!filter.location || client.location.indexOf(filter.location) > -1) &&
                                (!filter.empcode || client.empcode.indexOf(filter.empcode) > -1);
                        });

                    }
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
        name: "c_id",
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
    });

    if (gridCategory == 'global') {

        field.push({
            title: "LOCATION",
            name: "location",
            type: "text",
        });

    }

    // if (gridCategory == 'job') {

    // field.push({
    //     title: "TASK TITLE",
    //     name: "task_title",
    //     type: "text",
    // });

    // }

    field.push({
        title: "CREATED BY",
        name: "empname",
        type: "text",
    });

    field.push({
        type: "control",
        name: "Control",
        editButton: editControlVisible,
        deleteButton: deleteControlVisible,
        updateButtonClass: "jsgrid-update-button",
        headerTemplate: function() {

            var insertButton = '';
            var searchButton = '';

            if (addCheckListOption != undefined && addCheckListOption == "true") {

                insertButton = $("<button>").attr("type", "button").addClass("jsgrid-button jsgrid-mode-button jsgrid-insert-mode-button").on("click",
                    function() {

                        newCheckListAdd(gridSelector);

                    }
                );

            }

            searchButton = this._createOnOffSwitchButton("filtering", this.searchModeButtonClass, false);

            return result = [searchButton, insertButton];

        }
    });

    $(gridSelector).jsGrid("option", "fields", field);

    $(gridSelector).jsGrid("option", "editItem", function(item) {

        // if (gridType == 'detail') {

        var url = editUrl + "/" + item.c_id;

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

        // var addUrl = $('.checkListGrid').attr('data-add-url') + "?type=" + gridType + "&redirectTo=" + currentRoute;

        // window.location = editUrl + "/" + item.c_id + "?type=" + gridType;
        window.location = url;

        // }

    });


    var checkListPostData = {};

    $(gridSelector).parent().prev().find('.result-count').html('');

    if (type != undefined && type != '') {

        checkListPostData.type = type;

    }

    if (gridType == 'jobDetail') {

        if (jobId != undefined && jobId != '') {

            checkListPostData.job_id = jobId;

        }

        // if (gridCategory != undefined && gridCategory) {

        //     checkListPostData.category = gridCategory;

        //     if (jobId != undefined && jobId != '') {

        //         checkListPostData.job_id = jobId;

        //     }

        // }

    }

    /* AJAX call to get list */
    $.ajax({

        url: listUrl,
        data: checkListPostData,
        dataType: "json"

    }).done(function(response) {

        if (response.success == "true") {

            if (response.data != "") {

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

        }

    });

    function loadGridItem(getUrl) {

        /* AJAX call to get grid data */
        $.ajax({

            url: getUrl,
            dataType: "json"

        }).done(function(response) {

            if (response.success == "true") {

                if (response.data != "") {

                    response.data = formatDataItem(response.data);

                    dbClients = response.data;

                    $(gridSelector).jsGrid("option", "data", response.data);

                }

            }

        });
    }

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

                if (response.data != "") {

                    response.data = formatDataItem(response.data);

                    $(gridSelector).jsGrid("option", "data", response.data);

                }

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

                if (response.data != "") {

                    response.data = formatDataItem(response.data);

                    $(gridSelector).jsGrid("option", "data", response.data);

                }

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

        var d = $.Deferred();

        var checkListPostData = { 'c_id': args.item.c_id };

        if (gridType == 'jobDetail') {

            if (jobId != undefined && jobId != '') {

                checkListPostData.job_id = jobId;

            }

        }

        /* AJAX call */
        $.ajax({

            url: deleteUrl,
            data: checkListPostData,
            dataType: "json"

        }).done(function(response) {

            if (response.success == "true") {

                type = 'success';

                if (response.data != "") {

                    response.data = formatDataItem(response.data);

                    $(gridSelector).jsGrid("option", "data", response.data);

                }

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

    $(".checkListGrid .jsgrid-insert-mode-button").on('click', function() {

        var jobId = $('.checkListGrid').attr('data-job-id');
        var gridType = $('.checkListGrid').attr('data-category');
        var currentRoute = $('.checkListGrid').attr('data-current-route');

        var url = $('.checkListGrid').attr('data-add-url');

        if (gridType != undefined && gridType != '') {

            url = url + "?type=" + gridType;

        }

        if (jobId != undefined && jobId != '') {

            url = url + "&job_id=" + jobId;

        }

        if (currentRoute != undefined && currentRoute != '') {

            url = url + "&redirectTo=" + currentRoute;

        }

        // var currentRoute = $('.checkListGrid').attr('data-current-route');

        // var addUrl = $('.checkListGrid').attr('data-add-url') + "?type=" + gridType + "&redirectTo=" + currentRoute;
        // var addUrl = $('.checkListGrid').attr('data-add-url') + "?type=" + gridType + "&job_id=" + jobId;
        var addUrl = url;

        window.location = addUrl;

    });

}


var getUrl = "";
var postUrl = "";
var gridType = "";
var gridSelector = ".checkListGrid";

// getCheckListTableList(".jobDetailJobCheckList");

// getCheckListTableList(".jobDetailGlobalCheckList");

$("#jobCheckListTab").on("click", function() {

    getCheckListTableList(".jobDetailJobCheckList");

    setTimeout(() => {

        getCheckListTableList(".jobDetailGlobalCheckList");

    }, 1000);


});

$("#checkListTab").on("click", function() {

    getCheckListTableList(".taskCheckList");

    setTimeout(() => {

        getCheckListTableList(".emailCheckList");

    }, 1000);

});

// $("#emailCheckListTab").on("click", function() {

//     getCheckListTableList(".emailCheckListGrid");

// });

var currentUserRole = $('.currentUserInfo').attr('data-current-user-role');

if (currentUserRole != undefined && currentUserRole == "account_manager") {

    // $("#checkListTab").trigger('click');

}

$('.checklist-tasks').slimscroll({
    height: '250px',
});

// });