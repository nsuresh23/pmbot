$(function() {

    function getMemberList(gridSelector) {

        var gridType = $(gridSelector).attr('data-type');
        var gridCategory = $(gridSelector).attr('data-category');
        var currentUserId = $(gridSelector).attr('data-current-user-id');
        var listUrl = $(gridSelector).attr('data-list-url');
        var currentRoute = $(gridSelector).attr('data-current-route');

        var dbClients = "";

        if ($(gridSelector + ' .jsgrid-grid-header').attr('class') == undefined) {

            $(gridSelector).jsGrid({

                height: "450px",
                width: "100%",

                filtering: false,
                inserting: false,
                editing: false,
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
                            return (!filter.name || (client.name != undefined && client.name != null && (client.name.toLowerCase().indexOf(filter.name.toLowerCase()) > -1))) &&
                                (!filter.role || (client.role != undefined && client.role != null && (client.role.toLowerCase().indexOf(filter.role.toLowerCase()) > -1)));
                        });

                    }
                },


                rowClass: function(item, itemIndex) {

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
            width: 50
        });

        field.push({
            title: "Email",
            name: "email",
            type: "text",
        });

        field.push({
            title: "Role",
            name: "role",
            type: "text",
        });

        field.push({
            type: "control",
            name: "Control",
            editButton: false,
            deleteButton: false,
            headerTemplate: function() {

                return this._createOnOffSwitchButton("filtering", this.searchModeButtonClass, false);

            },
            width: 10,
        });

        $(gridSelector).jsGrid("option", "fields", field);

        var memberListPostData = {};

        // if (currentUserId != undefined && currentUserId != '') {

        //     memberListPostData.empcode = currentUserId;

        // }

        /* AJAX call to get list */
        $.ajax({

            url: listUrl,
            data: memberListPostData,
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

    $(document).on('click', '#membersTab', function() {

        var gridSelector = ".membersGrid";

        var dataUrl = $(gridSelector).attr('data-list-url');

        // dataUrl = "fd";

        if (dataUrl != undefined && dataUrl != "") {

            getMemberList(gridSelector);

            if ($('.membersTab').attr('class') != undefined) {

                $('.membersTab').show();

            }

        }



    });

});
