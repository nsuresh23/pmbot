$(function() {

    //display modal form for product editing
    $(document).on('click', '.job-list', function() {

        var getUrl = "";
        var stage = "";
        var status = "";
        getUrl = $(this).attr('data-url');
        stage = $(this).attr('data-stage');
        status = $(this).attr('data-status');
        if (stage != "") {
            getUrl = getUrl + "/" + stage;
        }
        if (status != "") {
            getUrl = getUrl + "/" + status;
        }

        // $('.list-modal-body').html(data);
        $("#jobList").jsGrid({
            height: "450px",
            width: "100%",

            filtering: true,
            editing: false,
            sorting: true,
            paging: true,
            autoload: true,
            editButton: false,
            deleteButton: false,
            sorter: "string",

            pageSize: 5,
            pageButtonCount: 5,

            noDataContent: "No orders found",

            // deleteConfirm: "Do you really want to delete the client?",

            // controller: db,

            controller: {
                loadData: function(filter) {


                    filter.stage = stage;
                    filter.status = status;
                    console.log(filter);

                    // data =  $.ajax({
                    //     url: getUrl,
                    //     // data: filter,
                    //     dataType: "json"
                    // });

                    // return $.grep(data, function (client) {
                    //     console.log("client");
                    //     console.log(client);
                    //     return (!filter.jobTitle || client.jobTitle.toLowerCase().indexOf(filter.jobTitle.toLowerCase()) > -1)
                    //         && (!filter.projectManager || client.projectManager.toLowerCase().indexOf(filter.projectManager.toLowerCase()) > -1)
                    //         && (!filter.author || client.author.toLowerCase().indexOf(filter.author.toLowerCase()) > -1)
                    //         && (!filter.editor || client.editor.toLowerCase().indexOf(filter.editor.toLowerCase()) > -1)
                    //         && (!filter.publisher || client.publisher.toLowerCase().indexOf(filter.publisher.toLowerCase()) > -1)
                    //         && (!filter.startDate || client.startDate.toLowerCase().indexOf(filter.startDate.toLowerCase()) > -1)
                    //         && (!filter.dueDate || client.dueDate.toLowerCase().indexOf(filter.dueDate.toLowerCase()) > -1);
                    // });

                    // return data;
                    return $.ajax({
                        url: getUrl,
                        data: filter,
                        dataType: "json"
                    });
                }
            },

            fields: [
                { title: "JOB TITLE", name: "jobTitle", type: "text", width: 150 },
                { title: "PROJECT MANAGER", name: "projectManager", type: "text", width: 150 },
                { title: "AUTHOR", name: "author", type: "text", width: 150 },
                { title: "EDITOR", name: "editor", type: "text", width: 150 },
                { title: "PUBLISHER", name: "publisher", type: "text", width: 150 },
                { title: "START DATE", name: "startDate", type: "text", width: 150 },
                { title: "DUE DATE", name: "dueDate", type: "text", width: 150 },
                { type: "control", editButton: false, deleteButton: false, width: 60 }
            ]
        });
        // $('.list-modal-body').append($("#jobList").html);
        $('.list-modal').modal('show');

        // $.get(url, function (data) {
        //     //success data
        //     $('.list-modal-body').html(data);
        //     $("#jobList").jsGrid({
        //         height: "450px",
        //         width: "100%",

        //         filtering: true,
        //         editing: true,
        //         sorting: true,
        //         paging: true,
        //         autoload: true,

        //         pageSize: 15,
        //         pageButtonCount: 5,

        //         deleteConfirm: "Do you really want to delete the client?",

        //         // controller: db,

        //         controller: {
        //             loadData: function (filter) {

        //                 return data;
        //                 // return $.ajax({
        //                 //     url: "https://api.github.com/repositories",
        //                 //     dataType: "json"
        //                 // });
        //             }
        //         },

        //         fields: [
        //             { title: "Name", { title: "Name", type: "text", width: 150 },
        //             { title: "Age", { title: "Age", type: "number", width: 50 },
        //             { title: "Address", { title: "Address", type: "text", width: 200 },
        //             { title: "Country", { title: "Country", type: "select", items: db.countries, valueField: "Id", textField: "Name" },
        //             { title: "Married", { title: "Married", type: "checkbox", title: "Is Married", sorting: false },
        //             { type: "control" }
        //         ]
        //     });
        //     $('.list-modal').modal('show');
        // })

        // var product_id = $(this).val();

        // $.get(url + '/' + product_id, function (data) {
        //     //success data
        //     console.log(data);
        //     $('#product_id').val(data.id);
        //     $('#name').val(data.name);
        //     $('#details').val(data.details);
        //     $('#btn-save').val("update");
        //     $('#myModal').modal('show');
        // })
    });

    var flashType = $('#flashMessage').attr('data-type');
    var flashMessage = $('#flashMessage').attr('data-message');

    if (flashType && flashMessage) {

        flashMessage(flashType, flashMessage);

    }


    function flashMessage(type, message) {

        var headingVariable = 'Success';
        var loaderBgVariable = '#fec107';
        var iconVariable = 'success';
        var textVariable = message;

        if (type == "error") {

            headingVariable = 'Error';
            iconVariable = 'error';

        }

        $.toast().reset('all');
        $("body").removeAttr('class');
        $.toast({
            heading: headingVariable,
            text: textVariable,
            position: 'top-right',
            loaderBg: loaderBgVariable,
            icon: iconVariable,
            hideAfter: 3500,
            stack: 6
        });
        return false;

    }

    function fieldMessage(field, message) {

        var headingVariable = 'Error';
        var loaderBgVariable = '#fec107';
        var iconVariable = 'error';
        var textVariable = message;

        $.toast().reset('all');
        $("body").removeAttr('class').removeClass("bottom-center-fullwidth").addClass("top-center-fullwidth");
        $.toast({
            heading: headingVariable,
            text: textVariable,
            position: 'top-center',
            loaderBg: loaderBgVariable,
            icon: iconVariable,
            hideAfter: 3500,
            stack: 6
        });
        return false;

    }

    function confirmAlert() {

        $.MessageBox({

            buttonDone: "Yes",
            buttonFail: "No",
            message: "Are You Sure?"

        }).done(function() {

            return true;

        }).fail(function() {

            return false;

        });
    }



    // $('.list-modal-body').html(data);
    var stakeholdersList = $("#stakeholdersList").jsGrid({
        height: "450px",
        width: "100%",

        filtering: true,
        editing: false,
        sorting: true,
        paging: true,
        autoload: true,
        editButton: false,
        deleteButton: false,
        sorter: "string",

        pageSize: 5,
        pageButtonCount: 5,

        noDataContent: "No stakeholders found",

        // deleteConfirm: "Do you really want to delete the client?",

        // controller: db,

        controller: {
            loadData: function(filter) {

                var getUrl = "";
                getUrl = $("#stakeholdersList").attr('data-url');
                console.log(filter);
                console.log(getUrl);

                // data =  $.ajax({
                //     url: getUrl,
                //     // data: filter,
                //     dataType: "json"
                // });

                // return $.grep(data, function (client) {
                //     console.log("client");
                //     console.log(client);
                //     return (!filter.jobTitle || client.jobTitle.toLowerCase().indexOf(filter.jobTitle.toLowerCase()) > -1)
                //         && (!filter.projectManager || client.projectManager.toLowerCase().indexOf(filter.projectManager.toLowerCase()) > -1)
                //         && (!filter.author || client.author.toLowerCase().indexOf(filter.author.toLowerCase()) > -1)
                //         && (!filter.editor || client.editor.toLowerCase().indexOf(filter.editor.toLowerCase()) > -1)
                //         && (!filter.publisher || client.publisher.toLowerCase().indexOf(filter.publisher.toLowerCase()) > -1)
                //         && (!filter.startDate || client.startDate.toLowerCase().indexOf(filter.startDate.toLowerCase()) > -1)
                //         && (!filter.dueDate || client.dueDate.toLowerCase().indexOf(filter.dueDate.toLowerCase()) > -1);
                // });

                // return data;
                return $.ajax({
                    url: getUrl,
                    data: filter,
                    dataType: "json"
                });
            }
        },

        fields: [
            { title: "ID", name: "id", type: "text", width: 150 },
            { title: "NAME", name: "name", type: "text", width: 150 },
            { title: "EMAIL", name: "email", type: "text", width: 150 },
            { title: "DESIGNATION", name: "designation", type: "text", width: 150 },
            { title: "PHONE", name: "phone", type: "text", width: 150 },
            { title: "MOBILE", name: "mobile", type: "text", width: 150 },
            // { type: "control", editButton: false, deleteButton: false, width: 60 }
            { type: "control", width: 60 }
        ]
    });

    $(".stakeholders-add").on('click', function() {

        $('#stakeholders-modal').modal('show');

    });

    // $('stakeholders-form').on('submit', function (e) {
    // $('#stakeholdersAddButton').on('click', function (e) {
    $(document).on('click', '#stakeholdersAddButton', function(e) {

        // if (this.checkValidity && !this.checkValidity()) return;
        // if ($('#stakeholders-form').checkValidity && !$('#stakeholders-form').checkValidity()) return;
        // e.preventDefault();
        var postUrl = '';
        postUrl = $('#stakeholdersAddButton').attr('data-url');
        // postUrl = $('#stakeholdersAddButton').attr('data-url');
        console.log("postUrl");
        console.log(postUrl);
        var row = $('#stakeholdersList').data('row');

        var return_first = function() {
            var tmp = null;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'json',
                'url': postUrl,
                'data': $('#stakeholders-form').serialize(),
                'success': function(data) {
                    $("#stakeholdersList").jsGrid().refresh
                    tmp = data;
                }
            });
            return tmp;
        }();

        console.log(return_first);



        // if (row instanceof FooTable.Row) {
        //     row.val(values);
        // } else {
        //     values.id = uid++;
        //     ft.rows.add(values);
        // }
        // $modal.modal('hide');
    });

    /*Init FooTable*/
    // $('#footable_1,#footable_3').footable();

    /*Editing FooTable*/

    // var $modal = $('#editor-modal'),
    //     $editor = $('#editor'),
    //     $editorTitle = $('#editor-title'),
    //     ft = FooTable.init('#footable_2', {
    //         editing: {
    //             enabled: true,
    //             addRow: function () {
    //                 $modal.removeData('row');
    //                 $editor[0].reset();
    //                 $editorTitle.text('Add a new stakeholders');
    //                 $modal.modal('show');
    //             },
    //             editRow: function (row) {
    //                 var values = row.val();
    //                 $editor.find('#id').val(values.id);
    //                 $editor.find('#name').val(values.name);
    //                 $editor.find('#email').val(values.email);
    //                 $editor.find('#designation').val(values.designation);
    //                 $editor.find('#phone').val(values.phone);
    //                 $editor.find('#mobile').val(values.mobile);

    //                 $modal.data('row', row);
    //                 $editorTitle.text('Edit row #' + values.id);
    //                 $modal.modal('show');
    //             },
    //             deleteRow: function (row) {
    //                 if (confirm('Are you sure you want to delete the row?')) {
    //                     row.delete();
    //                 }
    //             }
    //         }
    //     }),
    //     uid = 10;

    // $editor.on('submit', function (e) {
    //     if (this.checkValidity && !this.checkValidity()) return;
    //     e.preventDefault();
    //     var row = $modal.data('row'),

    //     // var return_first = function () {
    //     //     var tmp = null;
    //     //     $.ajax({
    //     //         'async': false,
    //     //         'type': "POST",
    //     //         'global': false,
    //     //         'dataType': 'json',
    //     //         'url': postUrl,
    //     //         'data': $editor,
    //     //         'success': function (data) {
    //     //             tmp = data;
    //     //         }
    //     //     });
    //     //     return tmp;
    //     // }();

    //         values = {
    //             id: $editor.find('#id').val(),
    //             name: $editor.find('#name').val(),
    //             email: $editor.find('#email').val(),
    //             designation: $editor.find('#designation').val(),
    //             phone: $editor.find('#phone').val(),
    //             mobile: $editor.find('#mobile').val()
    //             // startedOn: moment($editor.find('#startedOn').val(), 'YYYY-MM-DD'),
    //             // dob: moment($editor.find('#dob').val(), 'YYYY-MM-DD')
    //         };

    //     if (row instanceof FooTable.Row) {
    //         row.val(values);
    //     } else {
    //         values.id = uid++;
    //         ft.rows.add(values);
    //     }
    //     $modal.modal('hide');
    // });

    /*Job list modal*/
    // $(document).on('click','.job-list-modal',function(e) {
    //     var stage = $(this).attr('data-stage');
    //     var status = $(this).attr('data-status');
    //     return false;

    // });

});


// var clients = [
//     {
//         "Name": "Otto Clay",
//         "Age": 61,
//         "Address": "Ap #897-1459 Quam Avenue",
//         "Deletable": true
//     },
//     {
//         "Name": "Connor Johnston",
//         "Age": 73,
//         "Address": "Ap #370-4647 Dis Av.",
//         "Deletable": true,
//         "Editable": true
//     },
//     {
//         "Name": "Lacey Hess",
//         "Age": 29,
//         "Address": "Ap #365-8835 Integer St.",
//         "Editable": true
//     },
//     {
//         "Name": "Timothy Henson",
//         "Age": 78,
//         "Address": "911-5143 Luctus Ave"
//     },
//     {
//         "Name": "Ramona Benton",
//         "Age": 43,
//         "Address": "Ap #614-689 Vehicula Street",
//         "Editable": true
//     }
// ];

// $("#jsGrid").jsGrid({
//     height: 300,
//     width: "100%",

//     filtering: true,
//     editing: true,
//     autoload: true,

//     deleteConfirm: "Do you really want to delete the client?",

//     controller: {
//         loadData: function () {
//             return clients;
//         }
//     },

//     rowClick: function (args) {
//         if (args.item.Editable) {
//             jsGrid.Grid.prototype.rowClick.call(this, args);
//         }
//     },

//     fields: [
//         { title: "Name", { title: "Name", type: "textarea", width: 150 },
//         { title: "Age", { title: "Age", type: "number", width: 50 },
//         { title: "Address", { title: "Address", type: "text", width: 200 },
//         {
//             type: "control",
//             itemTemplate: function (value, item) {
//                 var $result = $([]);

//                 if (item.Editable) {
//                     $result = $result.add(this._createEditButton(item));
//                 }

//                 if (item.Deletable) {
//                     $result = $result.add(this._createDeleteButton(item));
//                 }

//                 return $result;
//             }
//         }
//     ]
// });