$(function() {

    function getUserTableList(selector, gridSelector, gridType) {

        var listUrl = $(selector).attr('data-list-url');
        var addUrl = $(selector).attr('data-add-url');
        var editUrl = $(selector).attr('data-edit-url');
        var deleteUrl = $(selector).attr('data-delete-url');
        var passwordUpdateUrl = $(selector).attr('data-password-update-url');
        var pageSize = $('#currentUserInfo').attr('data-page-size');

        var dbClients = "";

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
                title: "NAME",
                name: "name",
                type: "text",
                // validate: function (value, item) {

                //     return itemEmptyOrExistsCheck(gridSelector, 'name', value);

                //     // if (value == '') {

                //     //     message = 'Name is required field';

                //     //     fieldMessage(item, message);

                //     //     $(gridSelector).jsGrid("fieldOption", "name", "css", "error-field");

                //     // } else {

                //     //     message = 'Value already exists';

                //     //     itemExistsCheck(gridSelector, 'name', value, message);

                //     // }


                // },
                width: 150
            },
            {
                title: "STATUS",
                name: "status",
                type: "checkbox",
                // itemTemplate: function (value, item) {

                //     return $("<input>").attr("type", "checkbox")
                //         // .attr("class", "js-switch js-switch-1")
                //         // .attr("data-size", "small")
                //         // .attr("data-color", "#8BC34A")
                //         // .attr("data-secondary", "#F8B32D")
                //         .attr("checked", JSON.parse(value))
                // },
                sorting: false,
                css: "user-group-jsgrid-checkbox-width",
                width: 50
            },
            { title: "CREATED AT", name: "created_at", type: "text", inserting: false, editing: false, width: 150 },
            { title: "UPDATED AT", name: "updated_at", type: "text", inserting: false, editing: false, width: 150 },
            {
                type: "control",
                updateButtonClass: "jsgrid-update-button",
            },
        ];

        if (gridType == 'user') {

            field = [{
                    title: "S.NO",
                    name: "s_no",
                    type: "number",
                    inserting: false,
                    filtering: false,
                    editing: false,
                    sorting: false,
                    width: 50
                },
                {
                    title: "ID",
                    name: "id",
                    type: "text",
                    inserting: false,
                    editing: false,
                    visible: false,
                    width: 50
                },
                {
                    title: "NAME",
                    name: "empname",
                    type: "text",
                    width: 150
                },
                {
                    title: "CODE",
                    name: "spi_empcode",
                    type: "text",
                    width: 100
                },
                {
                    title: "EMAIL",
                    name: "email",
                    type: "text",
                    width: 150
                },
                {
                    title: "ROLE",
                    name: "role",
                    type: "text",
                    width: 100
                },
                {
                    title: "LOCATION",
                    name: "location",
                    type: "text",
                    width: 100
                },
                {
                    title: "MOBILE",
                    name: "mobile",
                    type: "text",
                    width: 100
                },
                // {
                //     title: "CISCO",
                //     name: "cisco",
                //     type: "text",
                //     width: 100
                // },
                {
                    title: "STATUS",
                    name: "status",
                    type: "checkbox",
                    itemTemplate: function(value, item) {
                        return $("<input>").attr("type", "checkbox")
                            // .attr("class", "js-switch js-switch-1")
                            // .attr("data-size", "small")
                            // .attr("data-color", "#8BC34A")
                            // .attr("data-secondary", "#F8B32D")
                            .attr("checked", JSON.parse(value))
                            .attr("disabled", true)
                    },
                    sorting: false,
                    css: "user-jsgrid-checkbox-width",
                    width: 60
                },
                // {
                //     title: "CREATED AT",
                //     name: "created_at",
                //     type: "text",
                //     inserting: false,
                //     editing: false,
                //     width: 100
                // },
                // {
                //     title: "UPDATED AT",
                //     name: "updated_at",
                //     type: "text",
                //     inserting: false,
                //     editing: false,
                //     width: 100
                // },
                {
                    type: "control",
                    updateButtonClass: "jsgrid-update-button edit-alert",
                    width: 70,
                    itemTemplate: function(value, item) {
                        var $result = jsGrid.fields.control.prototype.itemTemplate.apply(this, arguments);
                        // var $myButton = $('<a href="change_password"><i class="fa fa-retweet"></i></a>');

                        var $myButton = $('<a title="Change password" href="' + passwordUpdateUrl + '/' + item.id + '"><i class="jsgrid-reset-button fa fa-retweet"></i></a>');


                        return $result.add($myButton);
                    },
                },
            ];

            // if ($(gridSelector + ' .jsgrid-grid-header').attr('class') == undefined) {

            $(gridSelector).jsGrid({

                height: "450px",
                width: "100%",
                autowidth: true,
                editing: true,
                inserting: true,
                filtering: true,
                sorting: true,
                autoload: true,
                paging: true,
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
                        scrollTop: $("#userGrid").offset().top - 140
                    }, 0);

                },

                controller: {

                    loadData: function(filter) {

                        $('.user-count').html('');

                        var d = $.Deferred();

                        var userListPostData = {};

                        userListPostData.filter = filter;

                        /* AJAX call to get grid data */
                        $.ajax({
                            // url: listUrl + '?' + Math.random(),
                            url: listUrl,
                            // dataType: "json",
                            data: userListPostData,
                            // cache: false,
                            // headers: {
                            //     "Vary": "X-Requested-With"
                            // },
                        }).done(function(response) {

                            var dataResult = {};
                            dataResult.data = '';

                            if (response.success == "true") {

                                if (response.data != '') {

                                    response.data = formatDataItem(response.data);

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

                                            $('.user-count').html(' (' + resultCount + ')');

                                        }


                                    }

                                    // $(gridSelector).jsGrid("option", "data", response.data);

                                    $('.jsgrid-grid-body').slimscroll({
                                        height: '300px',
                                    });

                                } else {

                                    d.resolve(dataResult);

                                }

                            } else {

                                d.resolve(dataResult);

                            }

                        });

                        return d.promise();

                        // if (gridType == 'user') {

                        //     return $.grep(dbClients, function(client) {

                        //         return (!filter.id || (client.id != undefined && client.id != null && (client.id.toLowerCase().indexOf(filter.id.toLowerCase()) > -1))) &&
                        //             (!filter.spi_empcode || (client.spi_empcode != undefined && client.spi_empcode != null && (client.spi_empcode.toLowerCase().indexOf(filter.spi_empcode.toLowerCase()) > -1))) &&
                        //             (!filter.empname || (client.empname != undefined && client.empname != null && (client.empname.toLowerCase().indexOf(filter.empname.toLowerCase()) > -1))) &&
                        //             (!filter.email || (client.email != undefined && client.email != null && (client.email.toLowerCase().indexOf(filter.email.toLowerCase()) > -1))) &&
                        //             (!filter.role || (client.role != undefined && client.role != null && (client.role.toLowerCase().indexOf(filter.role.toLowerCase()) > -1))) &&
                        //             (!filter.location || (client.location != undefined && client.location != null && (client.location.toLowerCase().indexOf(filter.location.toLowerCase()) > -1))) &&
                        //             (!filter.mobile || (client.mobile != undefined && client.mobile != null && (client.mobile.toLowerCase().indexOf(filter.mobile.toLowerCase()) > -1))) &&
                        //             (!filter.cisco || (client.cisco != undefined && client.cisco != null && (client.cisco.toLowerCase().indexOf(filter.cisco.toLowerCase()) > -1))) &&
                        //             (filter.status === undefined || (client.status != undefined && client.status != null && client.status === filter.status));
                        //         // && (filter.status === undefined || (client.status != undefined && client.status != null && (client.status.toLowerCase().indexOf(filter.status.toLowerCase()) > -1)));
                        //         // && (!filter.created_at || (client.created_at != undefined && client.created_at != null && (client.created_at.toLowerCase().indexOf(filter.created_at.toLowerCase()) > -1))) &&
                        //         // && (!filter.updated_at || (client.updated_at != undefined && client.updated_at != null && (client.updated_at.toLowerCase().indexOf(filter.updated_at.toLowerCase()) > -1))) &&
                        //     });

                        // } else {

                        //     return $.grep(dbClients, function(client) {

                        //         return (!filter.id || (client.id != undefined && client.id != null && (client.id.toLowerCase().indexOf(filter.id.toLowerCase()) > -1))) &&
                        //             (!filter.name || (client.name != undefined && client.name != null && (client.name.toLowerCase().indexOf(filter.name.toLowerCase()) > -1))) &&
                        //             (filter.status === undefined || (client.status != undefined && client.status != null && client.status === filter.status)) &&
                        //             // (filter.status === undefined || (client.status != undefined && client.status != null && client.status === filter.status)) &&
                        //             (!filter.created_at || (client.created_at != undefined && client.created_at != null && (client.created_at.toLowerCase().indexOf(filter.created_at.toLowerCase()) > -1))) &&
                        //             (!filter.updated_at || (client.updated_at != undefined && client.updated_at != null && (client.updated_at.toLowerCase().indexOf(filter.updated_at.toLowerCase()) > -1)));
                        //     });

                        // }
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
                // insertItem: function (args) { addItem(args, addUrl) },
                // onItemInserting: addItem(args),
                // onDataLoading: loadGridItem(listUrl),

            });

            // }

            $(gridSelector).jsGrid("option", "editItem", function(item) {

                if (gridType == 'user') {

                    window.location = editUrl + "/" + item.id;

                }

            });

        }

        function addItem(args, addUrl, gridSelector) {

            // $(".jsgrid-cell").removeClass("error-field");

            var type = '';
            var message = '';

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

                    // $(selector).jsGrid("option", "data", response.data);

                } else {

                    type = 'error';

                    // args.cancel = true;
                    // $(gridSelector).jsGrid("clearInsert");

                    // grid.insertFailed = true;

                    d.resolve();

                }

                message = response.message;

                flashMessage(type, message);

                // getUserTableList(selector, gridSelector);

            });


            // $(gridSelector).jsGrid("loadData");
            // $(gridSelector).jsGrid("refresh");

            // getUserTableList(selector, gridSelector);


            return d.promise();

        }

        function editItem(args, editUrl, gridSelector) {

            var type = '';
            var message = '';

            var d = $.Deferred();

            /* AJAX call to get grid data */
            $.ajax({
                url: editUrl,
                data: args.item,
                dataType: "json"
            }).done(function(response) {

                if (response.success == "true") {

                    // dbClients = response.data;

                    type = 'success';

                    response.data = formatDataItem(response.data);

                    $(gridSelector).jsGrid("option", "data", response.data);

                    // $(selector).jsGrid("option", "data", response.data);

                } else {

                    type = 'error';

                    // args.cancel = true;
                    // $(gridSelector).jsGrid("clearInsert");

                    // grid.insertFailed = true;

                    d.resolve();

                }

                message = response.message;

                flashMessage(type, message);

                // getUserTableList(selector, gridSelector);

            });


            // $(gridSelector).jsGrid("loadData");
            // $(gridSelector).jsGrid("refresh");

            // getUserTableList(selector, gridSelector);


            return d.promise();

        }

        function deleteItem(args, deleteUrl, gridSelector) {

            var type = '';
            var message = '';

            var d = $.Deferred();

            /* AJAX call to get grid data */
            $.ajax({
                url: deleteUrl,
                data: { 'id': args.item.id },
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

                // getUserTableList(selector, gridSelector);

            });

            return d.promise();

        }

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

        function itemEmptyOrExistsCheck(gridSelector, field, value) {

            if (value == '') {

                message = field + ' is required field';

                fieldMessage(field, message);

                // $(gridSelector).jsGrid("fieldOption", field, "css", "error-field");

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

            // $.grep(gridData, function (data) {

            //     if (data[field] == value) {




            //         message = field + ' value already exists';

            //         fieldMessage(value, message);

            //         return false;

            //     }

            // });

            return true;

        }

        $("#userGrid .jsgrid-insert-mode-button").on('click', function(e) {

            e.preventDefault();

            if (gridType == 'user') {

                window.location = addUrl;

            }

        });

    }


    var getUrl = "";
    var postUrl = "";
    var gridType = "";
    var gridSelector = "#userGrid";
    var selector = "#grid-data";
    gridType = $(selector).attr('data-type');
    postUrl = $(selector).attr('data-list-url');
    getUrl = $(selector).attr('data-user-group-list-url');
    // stage = $(this).attr('data-stage');
    // status = $(this).attr('data-status');

    if (postUrl != undefined && postUrl != "") {

        getUserTableList(selector, gridSelector, gridType);

    }

});

function checkRole(item) {

    console.log($('#lead-pm').is(':checked'));

    if (item.value != 'project_manager') {

        if ($('#lead-pm').is(':checked') == true) {

            $('#lead-pm').trigger("click");

        }

    }

}

$('.user_role_select').on('change', function() {

    checkRole(this);

});
