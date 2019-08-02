$(function () {

    //display modal form for product editing
    $(document).on('click', '.job-list', function () {

        var getUrl = "";
        var stage = "";
        var status = "";
        var resData;
        var resItemsCount;
        var resFields;
        getUrl = $(this).attr('data-url');
        stage = $(this).attr('data-stage');
        status = $(this).attr('data-status');
        if (stage != "") {
            getUrl = getUrl + "/" + stage;
        }
        if (status != "") {
            getUrl = getUrl + "/" + status;
        }

        var return_first = function () {
            var tmp = null;
            $.ajax({
                'async': false,
                'type': "GET",
                'global': false,
                'dataType': 'json',
                'url': getUrl,
                // data: filter,
                'success': function (data) {
                    tmp = data;
                }
            });
            return tmp;
        }();

        // $.get(getUrl, function (data) {
        //     console.log(data);
        //     resFields = data.fields;
        //     resData = data.data;
        //     resItemsCount = data.itemCount;
        //     console.log(resData);
        //     console.log(resFields);
        //     console.log(resItemsCount);
        //     // return returnData
        // });


        console.log(return_first);
        resFields = return_first.fields;
        resData = return_first.data;
        resItemsCount = return_first.itemCount;
        // console.log(resData);
        // console.log(resFields);
        // console.log(resItemsCount);

        // console.log(returnData);

        // var resData = res.data;
        // var resItemCount = res.itemCount;
        // var resFields = res.fields;

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

            data: resData,
            itemsCount: resItemsCount,
            fields: resFields,

            // controller: {

            //     loadData: function (filter) {

            //         data =  $.ajax({
            //             url: getUrl,
            //             // data: filter,
            //             dataType: "json"
            //         });

            //         // return $.grep(data, function (client) {
            //         //     console.log("client");
            //         //     console.log(client);
            //         //     return (!filter.jobTitle || client.jobTitle.indexOf(filter.jobTitle) > -1)
            //         //         && (!filter.projectManager || client.projectManager.indexOf(filter.projectManager) > -1)
            //         //         && (!filter.author || client.author.indexOf(filter.author) > -1)
            //         //         && (!filter.editor || client.editor.indexOf(filter.editor) > -1)
            //         //         && (!filter.publisher || client.publisher.indexOf(filter.publisher) > -1)
            //         //         && (!filter.startDate || client.startDate.indexOf(filter.startDate) > -1)
            //         //         && (!filter.dueDate || client.dueDate.indexOf(filter.dueDate) > -1);
            //         // });

            //         // return data;
            //         return $.ajax({
            //             url: getUrl,
            //             data: filter,
            //             dataType: "json"
            //         });
            //     }
            // },

            // fields: [
            //     { title: "JOB TITLE", name: "jobTitle", type: "text", width: 150 },
            //     { title: "PROJECT MANAGER", name: "projectManager", type: "text", width: 150 },
            //     { title: "AUTHOR", name: "author", type: "text", width: 150 },
            //     { title: "EDITOR", name: "editor", type: "text", width: 150 },
            //     { title: "PUBLISHER", name: "publisher", type: "text", width: 150 },
            //     { title: "START DATE", name: "startDate", type: "text", width: 150 },
            //     { title: "DUE DATE", name: "dueDate", type: "text", width: 150 },
            //     { type: "control", editButton: false, deleteButton: false, width: 60 }
            // ]
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
