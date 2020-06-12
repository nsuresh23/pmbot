/*Jsgrid Init*/


$(function() {

    //display modal form for product editing
    $(document).on('click', '#jobGridTab', function() {

        var getUrl = "";
        var dbClients = "";
        getUrl = $(this).attr('data-url');

        if ($('#jobStatusGrid .jsgrid-grid-header').attr('class') == undefined) {

            $("#jobStatusGrid").jsGrid({
                height: "450px",
                width: "100%",

                filtering: true,
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
                            return (!filter.jobId || client.jobId.toLowerCase().indexOf(filter.jobId.toLowerCase()) > -1) &&
                                (!filter.orderId || client.orderId.toLowerCase().indexOf(filter.orderId.toLowerCase()) > -1) &&
                                (!filter.currentStatus || client.currentStatus.toLowerCase().indexOf(filter.currentStatus.toLowerCase()) > -1) &&
                                (!filter.projectManager || client.projectManager.toLowerCase().indexOf(filter.projectManager.toLowerCase()) > -1) &&
                                (!filter.author || client.author.toLowerCase().indexOf(filter.author.toLowerCase()) > -1) &&
                                (!filter.editor || client.editor.toLowerCase().indexOf(filter.editor.toLowerCase()) > -1) &&
                                (!filter.publisher || client.publisher.toLowerCase().indexOf(filter.publisher.toLowerCase()) > -1) &&
                                (!filter.startDate || client.startDate.toLowerCase().indexOf(filter.startDate.toLowerCase()) > -1) &&
                                (!filter.dueDate || client.dueDate.toLowerCase().indexOf(filter.dueDate.toLowerCase()) > -1)
                        });

                        // return $.ajax({
                        //     url: getUrl,
                        //     // data: filter,
                        //     dataType: "json"
                        // });

                    }
                },

                fields: [
                    { title: "JOB ID", name: "jobId", type: "text", width: 150 },
                    { title: "ORDER ID", name: "orderId", type: "text", width: 150 },
                    { title: "CURRENT STATUS", name: "currentStatus", type: "text", width: 150 },
                    { title: "PROJECT MANAGER", name: "projectManager", type: "text", width: 150 },
                    { title: "AUTHOR", name: "author", type: "text", width: 150 },
                    { title: "EDITOR", name: "editor", type: "text", width: 150 },
                    { title: "PUBLISHER", name: "publisher", type: "text", width: 150 },
                    { title: "START DATE", name: "startDate", type: "text", width: 150 },
                    { title: "DUE DATE", name: "dueDate", type: "text", width: 150 },
                    { type: "control", editButton: false, deleteButton: false, width: 60 }
                ]
            });

        }

        /* AJAX call to get Job status */
        $.ajax({
            url: getUrl,
            dataType: "json"
        }).done(function(response) {

            if (response.success == "true") {

                if (typeof response.data != "undefined" && response.data != "" && typeof response.data.jobTicketInfo != "undefined" && response.data.jobTicketInfo != "") {

                    dbClients = response.data;

                    $("#jobStatusGrid").jsGrid("option", "data", response.data.jobTicketInfo);

                }

            }

        });

    });

    $(document).on('click', '#jobStatusSearch', function() {

        var targetUrl = $('#jobGridTab').attr('data-url');

        if ($('#jobStatusSearchInput').val() != "") {

            var jobDetailUrl = $(this).attr('data-job-detail-base-url');

            targetUrl = jobDetailUrl + '/' + encodeURIComponent($('#jobStatusSearchInput').val()).replace(/%20/g, '+');

            // $('#jobGridTab').attr("data-job-id", $('#jobStatusSearchInput').val);

        }

        if (targetUrl != "") {

            window.location = targetUrl;

        }


        // $('#jobGridTab').click();

    });
});