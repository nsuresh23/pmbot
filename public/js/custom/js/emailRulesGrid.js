function getEmailRulesTableList(gridSelector) {

    var listUrl = $(gridSelector).attr('data-list-url');

    if ($(gridSelector + ' .jsgrid-grid-header').attr('class') == undefined) {

        window.dbClients = "";
        window.folderLabels = "";

        $(gridSelector).jsGrid({

            height: "450px",
            width: "100%",

            filtering: true,
            inserting: true,
            editing: true,
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

                    return $.grep(window.dbClients, function(client) {
                        return (!filter.from_name || (client.from_name != undefined && client.from_name != null && (client.from_name.toLowerCase().indexOf(filter.from_name.toLowerCase()) > -1))) &&
                            (!filter.subject || (client.subject != undefined && client.subject != null && (client.subject.toLowerCase().indexOf(filter.subject.toLowerCase()) > -1))) &&
                            (!filter.label_name || (client.label_name != undefined && client.label_name != null && (client.label_name.toLowerCase().indexOf(filter.label_name.toLowerCase()) > -1)));;
                    });

                },

            },

            rowClick: function(args) {

                $(gridSelector).jsGrid("cancelEdit");

            },


            onItemInserting: function(args, value) {

                if (itemEmptyOrExistsCheck(gridSelector, 'from_name', args.item.from_name, 'subject', args.item.subject, 'label_name', args.item.label_name)) {

                    addItem(args, listUrl, gridSelector);

                } else {

                    args.cancel = true;

                }

                // addItem(args, listUrl, gridSelector);

                // $('#emailRulesTab').trigger('click');

            },

            onItemUpdating: function(args) {

                editItem(args, listUrl, gridSelector);

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

                            deleteItem(args, listUrl, gridSelector);

                        }

                    });

                }

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
        width: 32,
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
        title: "FROM",
        name: "from_name",
        type: "textarea",

        validate: [
            "required",
            function(value, item) {

                if (!IsEmail(value)) {

                    Swal.fire({

                        title: '',
                        text: "Enter valid email address!",
                        showClass: {
                            popup: 'animated fadeIn faster'
                        },
                        hideClass: {
                            popup: 'animated fadeOut faster'
                        },

                    });

                    return false;

                }

                return true;

            }

        ],

        // width: 100,

    });

    field.push({
        title: "SUBJECT (contains)",
        name: "subject",
        type: "textarea",
        validate: [
                "required",
                function(value, item) {

                    if (value == '') {

                        Swal.fire({

                            title: '',
                            text: "Enter valid keywords!",
                            showClass: {
                                popup: 'animated fadeIn faster'
                            },
                            hideClass: {
                                popup: 'animated fadeOut faster'
                            },

                        });

                        return false;

                    }

                    return true;

                }

            ]
            // width: 100,
    });

    field.push({
        title: "FOLDER",
        name: "label_name",
        type: "textarea",
        validate: [
                "required",
                function(value, item) {

                    if (value == '') {

                        Swal.fire({

                            title: '',
                            text: "Enter valid folder!",
                            showClass: {
                                popup: 'animated fadeIn faster'
                            },
                            hideClass: {
                                popup: 'animated fadeOut faster'
                            },

                        });

                        return false;

                    }

                    return true;

                }

            ]
            // width: 100,
    });

    field.push({
        type: "control",
        name: "Control",
        // width: 30,
    });

    $(gridSelector).jsGrid("option", "fields", field);

    var emailRulesListPostData = {};

    /* AJAX call to get list */
    $.ajax({

        url: listUrl,
        data: emailRulesListPostData,
        dataType: "json"

    }).done(function(response) {

        if (response.success == "true") {

            response.data = formatDataItem(response.data);

            window.dbClients = response.data;

            if (response.folder_labels != undefined && response.folder_labels != '') {

                // window.folderLabels = response.folder_labels;

                // $(gridSelector).jsGrid("option", "fields", response.folder_labels);

                $(gridSelector).jsGrid("fieldOption", "folder", "items", response.folder_labels);

            }

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

    function itemEmptyOrExistsCheck(gridSelector, field1, value1, field2, value2, field3, value3) {

        if (value1 == '') {

            message = field1 + ' is required field';

            fieldMessage(field1, message);

            return false;

        }

        if (value2 == '') {

            message = field2 + ' is required field';

            fieldMessage(field2, message);

            return false;

        }

        if (value3 == '') {

            message = field3 + ' is required field';

            fieldMessage(field2, message);

            return false;

        }

        var gridData = $(gridSelector).jsGrid("option", "data");

        for (var i = 0, len = gridData.length; i < len; i++) {

            if (gridData[i][field1] === value1 && gridData[i][field2] === value2 && gridData[i][field3] === value3) {

                message = 'Rule already exists';

                fieldMessage(value2, message);

                return false;

            }
        }

        return true;

    }

    function addItem(args, addUrl, gridSelector) {

        var type = '';
        var message = '';

        var d = $.Deferred();

        /* AJAX call to get grid data */
        $.ajax({
            url: addUrl,
            type: 'POST',
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

        var d = $.Deferred();

        /* AJAX call */
        $.ajax({

            url: editUrl,
            type: 'PUT',
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

        var postData = {};

        postData.id = args.item.id;

        var d = $.Deferred();

        /* AJAX call */
        $.ajax({

            url: deleteUrl,
            type: 'DELETE',
            data: postData,
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

    function IsEmail(email) {
        var regex = /^([\w-\.]+@spi-global.com)$/;
        if (!regex.test(email)) {
            return false;
        } else {
            return true;
        }
    }

}
$("#emailRulesTab").on('click', function() {

    var emailRulesGridSelector = ".email-rules-grid";

    var emailRulesGridDataUrl = $(emailRulesGridSelector).attr('data-list-url');

    if (emailRulesGridDataUrl != undefined && emailRulesGridDataUrl != "") {

        getEmailRulesTableList(emailRulesGridSelector);

    }

});
