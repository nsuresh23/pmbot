// $('#example').DataTable({
//     dom: 'Bfrtip',
//     buttons: [
//         'copy', 'csv', 'excel', 'pdf', 'print'
//     ]
// });

function getSummaryReportTableList(gridSelector) {

    var listUrl = $(gridSelector).attr('data-list-url');
    var pageSize = $('#currentUserInfo').attr('data-page-size');

    if ($.fn.DataTable.isDataTable(gridSelector)) {

        $(gridSelector).DataTable().clear().destroy();

    }

    $.fn.dataTable.ext.errMode = 'none';

    var reportTable = $(gridSelector).DataTable({
        // dom: 'Bfrtip',
        dom: 'lBrtip',
        retrieve: true,
        processing: true,
        serverSide: true,
        // stateSave: true,
        "language": {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
        },
        // pagingType: 'full',
        pageLength: 25,
        // lengthChange: true,
        stripeClasses: [],
        // buttons: [
        //     'copy', 'csv', 'excel', 'pdf', 'print'
        // ],
        buttons: [
            'excel'
        ],
        /* AJAX call to get list */
        ajax: {
            url: listUrl,
            type: 'POST',
            // data: [],
            data: function(d) {
                return $.extend({}, d, {
                    'filter_option': {
                        'range': $('.report-daterange-datepicker').val(),
                        'report_type': $('.report-type').val(),
                        'user_empcode': $('.user-empcode').val()
                    }
                });
            },
            dataType: "json",
            // dataSrc: function(response) {

            //     var d = $.Deferred();

            //     var dataResult = { draw: '', recordsTotal: '', recordsFiltered: '', data: [] };

            //     if (response.success == "true") {

            //         if (response.data != '') {

            //             response.data = formatDataItem(response.data);

            //             var dataResult = {
            //                 data: response.data,
            //                 recordsTotal: response.recordsTotal,
            //                 recordsFiltered: response.recordsFiltered,
            //             };

            //             return dataResult;

            //             d.resolve(dataResult);

            //             if ('result_count' in response) {

            //                 var resultCount = response.result_count;

            //                 if (parseInt(resultCount) != NaN && parseInt(resultCount) > 0) {

            //                     if (parseInt(resultCount) > 99999) {

            //                         resultCount = '99999+'

            //                     }

            //                     $('.email-rules-count').html('(' + resultCount + ')');

            //                 }


            //             }

            //         } else {

            //             d.resolve(dataResult);

            //         }

            //     } else {

            //         d.resolve(dataResult);

            //     }

            //     return d.promise();

            // }

        },
        // columnDefs:
        //     [
        //         {
        //             targets: 0,
        //             data: 's_no',
        //             title: "SNO",
        //             className: "never"
        //         },
        //     ],
        columns: [
            { 'data': 's_no' },
            { 'data': 'url' },
            { 'data': 'title' },
            { 'data': 'date' },
            { 'data': 's_no' },
            { 'data': 'url' },
            { 'data': 'title' },
            { 'data': 'date' },
            { 'data': 's_no' },
            { 'data': 'url' },
            { 'data': 'title' },
            { 'data': 'date' },
        ],

    });

    function formatDataItem(dataValue) {

        if (dataValue.length > 0) {

            for (var i = 0, len = dataValue.length; i < len; i++) {

                dataValue[i].s_no = i + 1;

            }

        }

        return dataValue;

    }

    if ($('.report-daterange-datepicker') != undefined) {

        // $('.report-daterange-datepicker').val('');

    }

    $('.report-daterange-datepicker').on('apply.daterangepicker', function(ev, picker) {

        if (reportTable != undefined && reportTable != null) {

            // $('.report-daterange-datepicker').attr('from', picker.startDate.format('YYYY-MM-DD'));
            // $('.report-daterange-datepicker').attr('to', picker.endDate.format('YYYY-MM-DD'));

            reportTable.draw();

        }

    });

    $('.report-type').on('change', function() {

        if (reportTable != undefined && reportTable != null) {

            reportTable.draw();

        }

    });

    $('.user-empcode').on('change', function() {

        if (reportTable != undefined && reportTable != null) {

            reportTable.draw();

        }

    });

    // if ($(gridSelector + ' .jsgrid-grid-header').attr('class') == undefined) {

    // window.dbClients = "";
    // window.folderLabels = "";

    // var field = [];

    // var DateField = function(config) {
    //     jsGrid.Field.call(this, config);
    // };

    // DateField.prototype = new jsGrid.Field({
    //     sorter: function(date1, date2) {
    //         return new Date(date1) - new Date(date2);
    //     },

    //     itemTemplate: function(value) {
    //         // return new Date(value).toDateString();
    //         return value;
    //     },

    //     filterTemplate: function() {
    //         var now = new Date();
    //         this._fromPicker = $("<input>").datetimepicker({ defaultDate: now.setFullYear(now.getFullYear() - 1) });
    //         this._toPicker = $("<input>").datetimepicker({ defaultDate: now.setFullYear(now.getFullYear() + 1) });
    //         return $("<input>").attr('class', 'form-control report-daterange-datepicker');
    //     },

    //     insertTemplate: function(value) {
    //         return this._insertPicker = $("<input>").attr('class', 'form-control input-daterange-datepicker');
    //     },

    //     editTemplate: function(value) {
    //         return this._editPicker = $("<input>").datetimepicker().datetimepicker("setDate", new Date(value));
    //     },

    //     insertValue: function() {
    //         return this._insertPicker.datetimepicker("getDate").toISOString();
    //     },

    //     editValue: function() {
    //         return this._editPicker.datetimepicker("getDate").toISOString();
    //     },

    //     filterValue: function() {
    //         return {
    //             from: this._fromPicker.datetimepicker("getDate"),
    //             to: this._toPicker.datetimepicker("getDate")
    //         };
    //     }
    // });

    // jsGrid.fields.date = DateField;

    // field.push({
    //     title: "S.NO",
    //     name: "s_no",
    //     type: "number",
    //     inserting: false,
    //     filtering: false,
    //     editing: false,
    //     sorting: false,
    //     width: 32,
    // });

    // field.push({
    //     title: "ID",
    //     name: "id",
    //     type: "text",
    //     inserting: false,
    //     editing: false,
    //     visible: false,
    //     // width: 150
    // });

    // field.push({
    //     title: "FROM",
    //     name: "from_name",
    //     type: "textarea",

    //     validate: [
    //         "required",
    //         function(value, item) {

    //             if (!IsEmail(value)) {

    //                 Swal.fire({

    //                     title: '',
    //                     text: "Enter valid email address!",
    //                     showClass: {
    //                         popup: 'animated fadeIn faster'
    //                     },
    //                     hideClass: {
    //                         popup: 'animated fadeOut faster'
    //                     },

    //                 });

    //                 return false;

    //             }

    //             return true;

    //         }

    //     ],

    //     // width: 100,

    // });

    // field.push({
    //     title: "SUBJECT (<span class='text-lowercase'>contains</span>)<p><span class='text-lowercase font-12'>(For multiple keywords use pipe (|) seperator)</span></p>",
    //     name: "subject",
    //     type: "textarea",
    //     validate: [
    //             "required",
    //             function(value, item) {

    //                 if (value == '') {

    //                     Swal.fire({

    //                         title: '',
    //                         text: "Enter valid keywords!",
    //                         showClass: {
    //                             popup: 'animated fadeIn faster'
    //                         },
    //                         hideClass: {
    //                             popup: 'animated fadeOut faster'
    //                         },

    //                     });

    //                     return false;

    //                 }

    //                 return true;

    //             }

    //         ]
    //         // width: 100,
    // });

    // field.push({
    //     title: "FOLDER",
    //     name: "label_name",
    //     type: "textarea",
    //     validate: [
    //             "required",
    //             function(value, item) {

    //                 if (value == '') {

    //                     Swal.fire({

    //                         title: '',
    //                         text: "Enter valid folder!",
    //                         showClass: {
    //                             popup: 'animated fadeIn faster'
    //                         },
    //                         hideClass: {
    //                             popup: 'animated fadeOut faster'
    //                         },

    //                     });

    //                     return false;

    //                 }

    //                 return true;

    //             }

    //         ]
    //         // width: 100,
    // });

    // field.push({
    //     title: "STATUS",
    //     name: "status",
    //     type: "checkbox",
    //     itemTemplate: function(value, item) {
    //         return $("<input>").attr("type", "checkbox")
    //             // .attr("class", "js-switch js-switch-1")
    //             // .attr("data-size", "small")
    //             // .attr("data-color", "#8BC34A")
    //             // .attr("data-secondary", "#F8B32D")
    //             .attr("checked", JSON.parse(value))
    //             .attr("disabled", true)
    //     },
    //     sorting: false,
    //     editing: true,
    //     css: "user-jsgrid-checkbox-width",
    //     width: 60
    // });

    // field.push({
    //     type: "control",
    //     name: "Control",
    //     // width: 30,
    // });

    // $(gridSelector).jsGrid({

    //     height: "450px",
    //     width: "100%",
    //     autowidth: true,
    //     editing: true,
    //     inserting: true,
    //     filtering: true,
    //     sorting: true,
    //     autoload: true,
    //     paging: true,
    //     pageLoading: true,
    //     pageSize: pageSize,
    //     pageIndex: 1,
    //     pageButtonCount: 5,

    //     confirmDeleting: false,

    //     noDataContent: "No data",

    //     invalidNotify: function(args) {

    //         $('#alert-error-not-submit').removeClass('hidden');

    //     },

    //     loadIndication: true,
    //     // loadIndicationDelay: 500,
    //     loadMessage: "Please, wait...",
    //     loadShading: true,

    //     fields: field,

    //     onInit: function(args) {

    //         this._resetPager();

    //     },

    //     search: function(filter) {

    //         this._resetPager();
    //         return this.loadData(filter);

    //     },

    //     onPageChanged: function(args) {

    //         $('html, body').animate({
    //             scrollTop: $(".email-rules-grid").offset().top - 140
    //         }, 0);

    //     },

    //     controller: {

    //         loadData: function(filter) {

    //             $('.email-rules-count').html('');

    //             var d = $.Deferred();

    //             var emailRulesListPostData = {};

    //             emailRulesListPostData.filter = filter;

    //             /* AJAX call to get list */
    //             $.ajax({

    //                 url: listUrl,
    //                 data: emailRulesListPostData,
    //                 dataType: "json"

    //             }).done(function(response) {

    //                 var dataResult = { data: [], itemsCount: '' };

    //                 if (response.success == "true") {

    //                     if (response.data != '') {

    //                         response.data = formatDataItem(response.data);

    //                         window.dbClients = response.data;

    //                         var dataResult = {
    //                             data: response.data,
    //                             itemsCount: response.result_count,
    //                         };

    //                         d.resolve(dataResult);

    //                         if (response.folder_labels != undefined && response.folder_labels != '') {

    //                             // window.folderLabels = response.folder_labels;

    //                             // $(gridSelector).jsGrid("option", "fields", response.folder_labels);

    //                             $(gridSelector).jsGrid("fieldOption", "folder", "items", response.folder_labels);

    //                         }

    //                         if ('result_count' in response) {

    //                             var resultCount = response.result_count;

    //                             if (parseInt(resultCount) != NaN && parseInt(resultCount) > 0) {

    //                                 if (parseInt(resultCount) > 99999) {

    //                                     resultCount = '99999+'

    //                                 }

    //                                 $('.email-rules-count').html('(' + resultCount + ')');

    //                             }


    //                         }

    //                         // $(gridSelector).jsGrid("option", "data", response.data);

    //                         $('.jsgrid-grid-body').slimscroll({
    //                             height: '300px',
    //                         });

    //                     } else {

    //                         d.resolve(dataResult);

    //                     }

    //                 } else {

    //                     d.resolve(dataResult);

    //                 }

    //             });

    //             return d.promise();

    //             // return $.grep(window.dbClients, function(client) {
    //             //     return (!filter.from_name || (client.from_name != undefined && client.from_name != null && (client.from_name.toLowerCase().indexOf(filter.from_name.toLowerCase()) > -1))) &&
    //             //         (!filter.subject || (client.subject != undefined && client.subject != null && (client.subject.toLowerCase().indexOf(filter.subject.toLowerCase()) > -1))) &&
    //             //         (!filter.label_name || (client.label_name != undefined && client.label_name != null && (client.label_name.toLowerCase().indexOf(filter.label_name.toLowerCase()) > -1))) &&
    //             //         (filter.status === undefined || (client.status != undefined && client.status != null && client.status === filter.status));
    //             // });

    //         },

    //     },

    //     rowClick: function(args) {

    //         $(gridSelector).jsGrid("cancelEdit");

    //     },


    //     onItemInserting: function(args, value) {

    //         if (itemEmptyOrExistsCheck(gridSelector, 'from_name', args.item.from_name, 'subject', args.item.subject, 'label_name', args.item.label_name)) {

    //             addItem(args, listUrl, gridSelector);

    //         } else {

    //             args.cancel = true;

    //         }

    //         // addItem(args, listUrl, gridSelector);

    //         // $('#emailRulesTab').trigger('click');

    //     },

    //     onItemUpdating: function(args) {

    //         if (args.item.status == false) {

    //             Swal.fire({

    //                 title: 'Are you sure?',
    //                 text: "Do you want to inactive this! Rules doesn't applied for future emails",
    //                 // icon: 'warning',
    //                 showCancelButton: true,
    //                 confirmButtonColor: '#3085d6',
    //                 cancelButtonColor: '#d33',
    //                 confirmButtonText: 'Yes',
    //                 showClass: {
    //                     popup: 'animated slideInDown'
    //                 },
    //                 hideClass: {
    //                     popup: 'animated fadeOut faster'
    //                 },

    //             }).then((result) => {

    //                 if (result.value != undefined && result.value == true) {

    //                     editItem(args, listUrl, gridSelector);

    //                 } else {

    //                     $("#emailRulesTab").trigger('click');

    //                 }

    //             });

    //         } else {

    //             editItem(args, listUrl, gridSelector);

    //         }

    //         return false;

    //     },

    //     onItemDeleting: function(args) {

    //         if (!args.item.deleteConfirmed) { // custom property for confirmation

    //             args.cancel = true; // cancel deleting

    //             Swal.fire({

    //                 title: 'Are you sure?',
    //                 text: "Do you want to inactive this! Rules doesn't applied for future emails",
    //                 // icon: 'warning',
    //                 showCancelButton: true,
    //                 confirmButtonColor: '#3085d6',
    //                 cancelButtonColor: '#d33',
    //                 confirmButtonText: 'Yes',
    //                 showClass: {
    //                     popup: 'animated slideInDown'
    //                 },
    //                 hideClass: {
    //                     popup: 'animated fadeOut faster'
    //                 },

    //             }).then((result) => {

    //                 if (result.value != undefined && result.value == true) {

    //                     deleteItem(args, listUrl, gridSelector);

    //                 }

    //             });

    //         }

    //     },

    // });

    // // }

    // function formatDataItem(dataValue) {

    //     if (dataValue.length > 0) {

    //         for (var i = 0, len = dataValue.length; i < len; i++) {

    //             dataValue[i].s_no = i + 1;

    //         }

    //     }

    //     return dataValue;

    // }

}

// $(document).on('shown.bs.tab', '#reportsTab', function(e) {

//     var gridSelector = ".summary-report-grid";

//     var dataUrl = $(gridSelector).attr('data-list-url');

//     if (dataUrl != undefined && dataUrl != "") {

//         getSummaryReportTableList(gridSelector);

//     }

// });

$(document).on('click', '#reportsTab', function(e) {

    var gridSelector = "#summary-report-grid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        getSummaryReportTableList(gridSelector);

    }

});

$(document).on('click', '#summaryReportTab', function(e) {

    var gridSelector = "#summary-report-grid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        getSummaryReportTableList(gridSelector);

    }

});
