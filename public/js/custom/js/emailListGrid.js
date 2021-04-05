// $(function() {

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

function getEmailTableList(gridSelector) {

    var gridType = $(gridSelector).attr('data-type');
    var gridCategory = $(gridSelector).attr('data-category');
    var gridEmailFilter = $(gridSelector).attr('data-email-filter');
    var gridEmailLabel = $(gridSelector).attr('data-email-label');
    var currentUserId = $(gridSelector).attr('data-current-user-id');
    var currentJobId = $(gridSelector).attr('data-current-job-id');
    var jobPEEmail = $(gridSelector).attr('data-pe-email');
    var jobAuthorEmail = $(gridSelector).attr('data-author-email');
    var listUrl = $(gridSelector).attr('data-list-url');
    var currentRoute = $(gridSelector).attr('data-current-route');
    var emailId = $(gridSelector).attr('data-email-id');
    var emailFromDate = $(gridSelector).attr('data-email-from-date');
    var emailSubject = $(gridSelector).attr('data-email-subject');
    var empcode = $(gridSelector).attr('data-empcode');
    var dateRange = $(gridSelector).attr('data-date-range');
    var sortType = $(gridSelector).attr('data-sort-type');
    var sortLimit = $(gridSelector).attr('data-sort-limit');
    var readOnlyUser = $('#currentUserInfo').attr('data-read-only-user');
    var pageSize = $('#currentUserInfo').attr('data-page-size');
    var pageButtonCount = $('#currentUserInfo').attr('data-page-button-count');

    var insertControlVisible = false;
    var editControlVisible = false;
    var deleteControlVisible = false;

    var dbClients = "";

    var emailResultClass = '';

    // if ($(gridSelector + ' .jsgrid-grid-header').attr('class') == undefined) {

    var field = [];

    var scoreValue = [
        { Category: '', Id: '', Name: '' },
        { Category: '<i class="fa fa-circle inline-block txt-success font-16" title="positive"></i>', Id: 'positive', Name: 'Positive' },
        { Category: '<i class="fa fa-circle inline-block txt-danger font-16" title="negative"></i>', Id: 'negative', Name: 'Negative' },
        { Category: '<i class="fa fa-circle inline-block txt-light font-16" title="neutral"></i>', Id: 'neutral', Name: 'Neutral' },
        { Category: '<i class="fa fa-circle inline-block txt-light font-16" title="internal"></i>', Id: 'internal', Name: 'Internal' },
        { Category: '<i class="fa fa-circle inline-block txt-grey font-16" title="unknown"></i>', Id: 'error', Name: 'Unknown' },
    ];

    if (gridCategory != undefined && gridCategory != '' && gridCategory == 'myEmail') {

        field.push({
            headerTemplate: function() {
                return $("<input>").attr("type", "checkbox").attr("class", "selectAllCheckbox h-25-px");
            },
            itemTemplate: function(_, item) {
                return $("<input>").attr("type", "checkbox").attr("class", "singleCheckbox")
                    .attr("data-id", item.id)
                    .prop("checked", $.inArray(item.id, selectedItems) > -1)
                    .on("change", function() {
                        $(this).is(":checked") ? selectItem(item) : unselectItem(item);
                    });
            },
            align: "center",
            css: "user-group-jsgrid-checkbox-width text-center",
            inserting: false,
            filtering: false,
            editing: false,
            sorting: false,
            width: 30
        });

    }

    /* if (gridCategory != undefined && gridCategory != '' && gridCategory == 'qcEmail' && $('.currentUserInfo').attr('data-current-user-role') == 'account_manager') {

        field.push({
            headerTemplate: function() {
                return $("<a>").attr("href", "javascript:void(0);").attr("class", "btn btn-success pa-5").attr("title", "approve").text("Approve").on("click", function() {
                    approveSelectedItems();
                });
            },
            itemTemplate: function(_, item) {
                return $("<input>").attr("type", "checkbox").attr("class", "approveCheckbox")
                    .attr("data-id", item.id)
                    .prop("checked", $.inArray(item.id, selectedApprovedItems) > -1)
                    .on("change", function() {
                        $(this).is(":checked") ? selectApproveItem(item) : unselectApproveItem(item);
                    });
            },
            align: "center",
            css: "user-group-jsgrid-checkbox-width text-center",
            inserting: false,
            filtering: false,
            editing: false,
            sorting: false,
            width: 35
        });

    } */

    if (gridCategory != undefined && gridCategory != '' && gridEmailFilter != 'outbox' && gridEmailFilter != 'draft' && (gridCategory == 'nonBusinessEmail' || gridCategory == 'jobEmail')) {

        field.push({
            headerTemplate: function() {
                return $("<a>").attr("href", "javascript:void(0);").attr("class", "btn btn-success pa-5 font-12 email-forward-attachment").attr("title", "Forward").text("Forward");
                // return $("<button>").attr("class", "btn btn-success pa-5 font-12 email-forward-attachment").attr("title", "forward").text("Forward").on("click", function() {
                //     forwardSelectedItems();
                // });
            },
            itemTemplate: function(_, item) {
                return $("<input>").attr("type", "checkbox").attr("class", "forwardCheckbox")
                    .attr("data-id", item.id)
                    .prop("checked", $.inArray(item.id, selectedForwardItems) > -1)
                    .on("change", function() {
                        $(this).is(":checked") ? selectForwardItem(item) : unselectForwardItem(item);
                    });
            },
            align: "center",
            css: "user-group-jsgrid-checkbox-width text-center",
            inserting: false,
            filtering: false,
            editing: false,
            sorting: false,
            width: 35
        });

    }

    // field.push({
    //     title: "S.NO",
    //     name: "s_no",
    //     type: "number",
    //     inserting: false,
    //     filtering: false,
    //     editing: false,
    //     width: 50
    // });

    // field.push({
    //     title: "ID",
    //     name: "id",
    //     type: "text",
    //     inserting: false,
    //     editing: false,
    //     visible: false,
    // });

    if (gridEmailFilter != undefined && gridEmailFilter != '' && (gridEmailFilter == 'outbox' || gridEmailFilter == 'outboxwip' || gridEmailFilter == 'sent' || gridEmailFilter == 'hold' || gridEmailFilter == 'email_review' || gridEmailFilter == 'latest-sent')) {
        field.push({
            title: "TO",
            name: "email_to",
            type: "text",
        });
    } else {
        field.push({
            title: "FROM",
            name: "email_from",
            type: "text",
        });
    }

    if (gridCategory != undefined && gridCategory != '' && gridCategory == 'myEmail') {

        field.push({
            css: "text-center",
            align: "center",
            title: 'SCORE',
            name: "email_classification_category",
            type: "select",
            items: scoreValue,
            valueField: "Id",
            textField: "Name",
            itemTemplate: function(value, item) {

                if (item.email_classification_category == null || item.email_classification_category == '' || item.email_classification_category == 'not_set' || item.email_classification_category == 'neutral') {

                    return '<i class="fa fa-circle inline-block txt-light font-16" title="neutral"></i>';

                }

                if (item.email_classification_category == 'internal') {

                    return '<i class="fa fa-circle inline-block txt-light font-16" title="internal"></i>';

                }

                if (item.email_classification_category == 'positive') {

                    return '<i class="fa fa-circle inline-block txt-success font-16" title="positive"></i>';

                }

                if (item.email_classification_category == 'negative') {

                    return '<i class="fa fa-circle inline-block txt-danger font-16" title="negative"></i>';

                }

                if (item.email_classification_category == 'error') {

                    return '<i class="fa fa-circle inline-block txt-grey font-16" title="unknown"></i>';

                }

                return '';

            },
            width: 40,
        });

    }

    field.push({
        title: '<i class="fa fa-exclamation inline-block txt-danger font-16"></i>',
        name: "is_priority",
        type: "text",
        filtering: false,
        width: 10,
    });

    field.push({
        title: "SUBJECT",
        name: "subject_link",
        type: "text",
    });

    // field.push({
    //     title: "STATUS",
    //     name: "status_text",
    //     type: "text",
    //     width: 20,
    // });

    field.push({
        title: "MESSAGE PREVIEW",
        name: "message_start",
        type: "text",
    });

    // field.push({
    //     title: "MESSAGE",
    //     name: "message",
    //     type: "text",
    // });

    field.push({
        title: '<i class="zmdi zmdi-attachment inline-block font-16"></i>',
        name: "is_attachments",
        type: "text",
        filtering: false,
        width: 10,
    });

    field.push({
        title: "DATE",
        name: "created_date",
        type: "text",
        width: 60,
    });

    // field.push({
    //     title: "TO",
    //     name: "email_to",
    //     type: "text",
    // });

    // field.push({
    //     title: "CC",
    //     name: "email_cc",
    //     type: "text",
    // });

    // field.push({
    //     title: "PRIORITY",
    //     name: "priority",
    //     type: "text",
    // });

    // field.push({
    //     title: "SCORE",
    //     name: "score",
    //     type: "text",
    // });

    field.push({
        type: "control",
        name: "Control",
        editButton: editControlVisible,
        deleteButton: deleteControlVisible,
        itemTemplate: function(value, item) {

            if (gridCategory != 'emailSentCount' && gridCategory != 'qcEmail' && gridCategory != 'email-review' && gridCategory != 'email-review-latest') {

                if (item.view == '1') {

                    var icon = '';
                    var title = '';

                    if (item.view == '1') {

                        icon = 'fa-envelope-open-o';

                        title = 'Mark as unread';

                    }

                    if (item.view == '0') {

                        icon = 'fa-envelope-o';

                        title = 'Mark as read';

                    }

                    var $result = jsGrid.fields.control.prototype.itemTemplate.apply(this, arguments);

                    var $customUnreadButton = $("<a>").attr({ class: "mark-as-unread-btn fa " + icon + " font-16" }).attr({ title: title })
                        .click(function(e) {

                            var postData = {};

                            var postUrl = $('.email-read').attr('data-email-read-url');

                            postData.id = item.id;

                            if (item.view == '1') {

                                postData.view = '0';

                            }

                            if (item.view == '0') {

                                postData.view = '1';

                            }

                            var d = $.Deferred();

                            $.ajax({

                                url: postUrl,
                                data: postData,
                                dataType: 'json',
                                type: 'POST',
                                beforeSend: function() {
                                    $('.email_detail_loader').show();
                                },
                                complete: function() {
                                    $('.email_detail_loader').hide();
                                }

                            }).done(function(response) {

                                if (response.success == "true") {

                                    type = 'success';

                                } else {

                                    type = 'error';

                                    d.resolve();

                                }

                                message = response.message;

                                flashMessage(type, message);

                                if (item.status == '0') {

                                    $('#myTaskTab').trigger('click');

                                } else {

                                    $('.inbox-nav li.active').find('a').trigger('click');

                                }


                            });

                        });

                    return $("<div>").append($customUnreadButton);

                }

            }

            if (gridCategory == 'email-review') {

                if (item.reviewed != undefined && item.reviewed == '1') {

                    var icon = 'fa-star';
                    var title = 'Reviewed';

                    var $customUnreadButton = $("<a>").attr({ class: "fa " + icon + " font-16 txt-orange" }).attr({ title: title });

                    return $("<div>").append($customUnreadButton);

                }

            }

        },
        headerTemplate: function() {

            return this._createOnOffSwitchButton("filtering", this.searchModeButtonClass, false);

        },
        width: 18,
    });


    var selectedItems = [];

    var selectItem = function(item) {
        selectedItems.push(item.id);
        if ($(".singleCheckbox").length == $(".singleCheckbox:checked").length) {
            $(".selectAllCheckbox").prop("checked", true);
        } else {
            $(".selectAllCheckbox").prop("checked", false);
        }

        if (selectedItems.length > 0) {
            $('.dashboard-email-move-to-email-id').val(JSON.stringify(selectedItems));
        }

    };

    var unselectItem = function(item) {
        selectedItems = $.grep(selectedItems, function(i) {
            return i !== item.id;
        });
        if (selectedItems.length == 0) {
            $('.selectAllCheckbox').attr('checked', false);
        }
        if ($(".singleCheckbox").length == $(".singleCheckbox:checked").length) {
            $(".selectAllCheckbox").prop("checked", true);
        } else {
            $(".selectAllCheckbox").prop("checked", false);
        }

        if (selectedItems.length > 0) {
            $('.dashboard-email-move-to-email-id').val(JSON.stringify(selectedItems));
        }

    };

    $(document).on('click', '.selectAllCheckbox', function(item) {
        selectedItems = [];
        if (this.checked) { // check select status
            $('.singleCheckbox').each(function() {
                this.checked = true;
                itemData = {};
                if ($(this).attr('data-id') != undefined && $(this).attr('data-id') != '') {
                    itemData.id = $(this).attr('data-id');
                }
                selectItem(itemData);
            });
        } else {
            $('.singleCheckbox').each(function() {
                this.checked = false;
                itemData = {};
                if ($(this).attr('data-id') != undefined && $(this).attr('data-id') != '') {
                    itemData.id = $(this).attr('data-id');
                }
                unselectItem(itemData);
            });
            selectedItems = [];
        }

    });


    var selectedApprovedItems = [];

    var selectApproveItem = function(item) {
        selectedApprovedItems.push(item.id);
    };

    var unselectApproveItem = function(item) {
        selectedApprovedItems = $.grep(selectedApprovedItems, function(i) {
            return i !== item.id;
        });
    };

    var approveSelectedItems = function() {

        if (selectedApprovedItems.length == 0) {

            Swal.fire({

                title: '',
                text: "Please choose the email to approve!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }

        if (selectedApprovedItems.length) {

            Swal.fire({

                title: 'Are you sure?',
                text: "Do you want to approve the selected emails!",
                // icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            }).then((result) => {

                if (result.value != undefined && result.value == true) {

                    approveEscalationEmails(selectedApprovedItems);

                }
            });

        }

    }

    var approveEscalationEmails = function(selectedApprovedItems) {

        var postUrl = '';
        var params = {};
        params.id = selectedApprovedItems;

        if ($('.currentUserInfo').attr('data-current-user-role') == 'quality') {

            params.qc_approved = "1";

        }

        if ($('.currentUserInfo').attr('data-current-user-role') == 'account_manager') {

            params.am_approved = "1";

        }

        params.email_classification_category = "negative";
        postUrl = $('#job-list-data').attr('data-email-category-move-to-url');

        if (postUrl != undefined && postUrl != '') {

            /* AJAX call to email label update info */

            var d = $.Deferred();

            $.ajax({
                url: postUrl,
                data: params,
                dataType: 'json',
                type: 'POST',
            }).done(function(response) {

                if (response.success == "true") {

                    type = 'success';

                } else {

                    type = 'error';

                    d.resolve();

                }

                message = response.message;

                flashMessage(type, message);

                var gridSelector = ".myEmailGrid";

                if ($('.currentUserInfo').attr('data-current-user-role') == 'account_manager') {

                    gridSelector = ".emailQCCountGrid";

                    pmsEmailCountGrid = ".pmsEmailCountGrid";

                    var dataUrl = $(pmsEmailCountGrid).attr('data-list-url');

                    if (dataUrl != undefined && dataUrl != "") {

                        getPmsEmailCountTableList(pmsEmailCountGrid);

                    }

                }

                var dataUrl = $(gridSelector).attr('data-list-url');

                if (dataUrl != undefined && dataUrl != "") {

                    getEmailTableList(gridSelector);

                    selectedApprovedItems = [];

                }

            });

            return d.promise();

        }

    };

    var selectedForwardItems = [];

    var selectForwardItem = function(item) {

        selectedForwardItems.push(...[{
            'id': item.id,
            'subject': item.subject,
            'subject_min_width': item.subject_min_width,
            'email_filename': item.subject + '.eml',
            'email_download_path': item.email_download_path,
        }]);

    };

    var unselectForwardItem = function(item) {

        selectedForwardItems = $.grep(selectedForwardItems, function(i) {
            return i.id !== item.id;
        });

    };

    var forwardSelectedItems = function() {

        if (selectedForwardItems.length == 0) {

            /* Swal.fire({

                title: '',
                text: "Please select the email to forward!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            }); */

            return false;

        }

        if (selectedForwardItems.length) {

            /* Swal.fire({

                title: 'Are you sure?',
                text: "Do you want to forward the selected emails!",
                // icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            }).then((result) => {

                if (result.value != undefined && result.value == true) {

                    downloadForwardSelectedItems(selectedForwardItems);

                }
            }); */

            downloadForwardSelectedItems(selectedForwardItems);

        }

    };

    var downloadForwardSelectedItems = function(selectedForwardItems) {

        attachtedEmailFilesToUpload = [];

        $('.attached_file').html('');

        $('.email-compose-modal').modal({
            show: 'true'
        });

        for (i = 0; i < selectedForwardItems.length; i++) {

            var filename = selectedForwardItems[i].email_filename;

            var currentTimestamp = '';

            currentTimestamp = moment.utc().format('YYYYMMDDHHmmssSSS') + '_' + Math.floor(Math.random() * 101);

            attachtedEmailFilesToUpload[currentTimestamp] = selectedForwardItems[i].email_download_path;

            var htmlFile = '';
            htmlFile += '<li class="pb-5" id="new_attachements_' + currentTimestamp + '">';
            htmlFile += '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 email-attachment-item-block">';
            htmlFile += '<a href="javascript:void(0);" title="';
            htmlFile += filename;
            htmlFile += '" class="atch-thumb" style="text-decoration:none;">';
            htmlFile += '<span>';
            htmlFile += '<i class="font-30 mr-5 fa fa-';
            htmlFile += getFileType(filename);
            htmlFile += '-o"></i>';
            htmlFile += '</span>';
            htmlFile += '<span class="email-attachment-item-name ">';
            htmlFile += mb_strimwidth(filename, 0, 25, '...');
            htmlFile += '<i class="fa fa-times text-danger ml-5" onclick="removeAttachedEmailFile($(this))" type="button" value="Remove" data-remove-id="new_attachements_' + i + '" data-remove-filename="' + filename + '" data-src="' + currentTimestamp + '"></i></a>';
            htmlFile += '</span>';
            htmlFile += '</div></li>';

            $($.parseHTML(htmlFile)).appendTo('.attached_file');

            $('.attached_file_box').show();

        }

    };

    $(document).on('click', '.email-forward-attachment', function(e) {

        e.preventDefault();

        forwardSelectedItems();

    });

    $(gridSelector).jsGrid({

        height: "450px",
        width: "100%",
        autowidth: true,
        editing: editControlVisible,
        inserting: insertControlVisible,
        filtering: false,
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

            // $(gridSelector).jsGrid('option', 'pageIndex', '1');
            // $(gridSelector).jsGrid("reset");
            // return this.loadData(filter);

            // var sorting = $(gridSelector).jsGrid("getSorting");
            // $(gridSelector).jsGrid("sort", { field: sorting.field, order: sorting.order });
            // this._resetSorting();
            this._resetPager();
            return this.loadData(filter);

        },

        onPageChanged: function(args) {

            $('html, body').animate({
                scrollTop: $(".emailGrid").offset().top - 110
            }, 0);

            $(".selectAllCheckbox").prop("checked", false);
            $(".singleCheckbox").prop("checked", false);

            $('.dashboard-email-move-to-email-id').val('');

            selectedItems = [];

        },

        controller: {

            loadData: function(filter) {

                var d = $.Deferred();

                var emailListPostData = {};

                var emailFilter = '';

                // var status = ['0', '1'];
                var status = ['0'];

                emailListPostData.filter = filter

                emailListPostData.type = 'pmbot';

                if (gridEmailFilter != undefined && gridEmailFilter != '') {

                    emailListPostData.email_filter = gridEmailFilter;

                    emailFilter = gridEmailFilter;

                }

                if (gridCategory != undefined && gridCategory != '') {

                    emailListPostData.email_type = gridCategory;

                    // if (emailFilter == 'draft') {

                    //     status = ['4'];

                    // }

                    // if (emailFilter == 'outbox') {

                    //     status = ['5'];

                    // }

                    // if (emailFilter == 'sent') {

                    //     status = ['6'];

                    // }

                    if (gridCategory == 'nonBusinessEmail') {

                        status = ['3'];

                        if (emailFilter == 'draft') {

                            status = ['4'];

                        }

                        if (emailFilter == 'outbox') {

                            status = ['5'];

                        }

                        if (emailFilter == 'sent') {

                            status = ['6'];

                        }

                        if (emailFilter == 'archived') {

                            status = ['7'];

                        }

                        if (emailFilter == 'outlook-sent') {

                            status = ['8'];

                        }

                        if (emailFilter == 'error') {

                            status = ['99'];

                        }

                        emailListPostData.type = 'non_pmbot';

                    }

                    if (gridCategory == 'businessEmail') {

                        status = ['1'];

                        if (emailFilter == 'draft') {

                            status = ['4'];

                        }

                        if (emailFilter == 'outbox') {

                            status = ['5'];

                        }

                        if (emailFilter == 'sent') {

                            status = ['6'];

                        }

                        if (emailFilter == 'archived') {

                            status = ['7'];

                        }

                        if (emailFilter == 'outlook-sent') {

                            status = ['8'];

                        }

                        if (emailFilter == 'error') {

                            status = ['99'];

                        }

                        emailListPostData.type = 'generic';

                    }

                    if (gridCategory == 'emailSentCount') {

                        emailListPostData.type = '';

                        if (emailFilter == 'outbox') {

                            status = ['5'];

                        }

                        if (emailFilter == 'outboxwip') {

                            status = ['55'];

                        }

                        if (emailFilter == 'sent') {

                            status = ['6'];

                        }

                        if (emailFilter == 'hold') {

                            status = ['99'];

                        }

                        if (emailFilter == 'negative') {

                            emailListPostData.category = 'negative';

                            if (empcode != undefined && empcode != '') {

                                emailListPostData.empcode = empcode;

                            }

                        }

                        // if (emailFilter == 'positive') {

                        //     emailListPostData.category = 'positive';

                        // }

                    }

                    if (gridCategory == 'qcEmail') {

                        if (emailFilter == 'potentially_alarming' || emailFilter == 'alarming' || emailFilter == 'escalation') {

                            if (empcode != undefined && empcode != '') {

                                emailListPostData.empcode = empcode;

                            }

                        }

                    }

                    if (gridCategory == 'email-review') {

                        if (emailFilter == 'email_review') {

                            if (empcode != undefined && empcode != '') {

                                emailListPostData.empcode = empcode;

                            }

                            if (dateRange != undefined && dateRange != '') {

                                emailListPostData.range = dateRange;

                            }

                            if (sortType != undefined && sortType != '') {

                                emailListPostData.sort_type = sortType;

                            }

                            if (sortLimit != undefined && sortLimit != '') {

                                emailListPostData.sort_limit = sortLimit;

                            }

                        }

                    }

                    if (gridCategory == 'classificationEmail') {

                        emailListPostData.type = '';

                        if (emailFilter == 'negative') {

                            emailListPostData.category = 'negative';

                            if (empcode != undefined && empcode != '') {

                                emailListPostData.empcode = empcode;

                            }

                        }

                        // if (emailFilter == 'positive') {

                        //     emailListPostData.category = 'positive';

                        // }

                    }

                }

                // if (gridEmailFilter != undefined && gridEmailFilter != '') {

                //     emailListPostData.email_filter = gridEmailFilter;

                // }

                if (gridType == 'jobDetail') {

                    status = ['2'];


                    if (emailFilter == 'draft') {

                        status = ['4'];

                    }


                    if (emailFilter == 'outbox') {

                        status = ['5'];

                    }


                    if (emailFilter == 'sent') {

                        status = ['6'];

                    }

                    if (emailFilter == 'archived') {

                        status = ['7'];

                    }

                    if (emailFilter == 'error') {

                        status = ['99'];

                    }

                    if (currentJobId != undefined && currentJobId != '') {

                        emailListPostData.job_id = currentJobId;

                    }

                    if (emailFilter == 'pe') {

                        if (jobPEEmail != undefined && jobPEEmail != '') {

                            emailListPostData.pe_email = jobPEEmail;

                        }

                    }

                    if (emailFilter == 'author') {

                        if (jobAuthorEmail != undefined && jobAuthorEmail != '') {

                            emailListPostData.author_email = jobAuthorEmail;

                        }

                    }

                }

                emailListPostData.status = status;

                if (gridEmailLabel != undefined && gridEmailLabel != '') {

                    emailListPostData.label_name = gridEmailLabel;

                    delete emailListPostData.email_filter;
                    delete emailListPostData.status;

                }

                if (gridCategory != undefined && gridCategory == 'email-review') {

                    delete emailListPostData.status;

                }

                if (gridCategory != undefined && gridCategory == 'email-review-latest') {

                    if (emailId != undefined && emailId != '') {

                        emailListPostData.email_id = emailId;

                    }

                    if (empcode != undefined && empcode != '') {

                        emailListPostData.empcode = empcode;

                    }

                    if (emailSubject != undefined && emailSubject != '') {

                        emailListPostData.subject = emailSubject;

                    }

                    if (emailFromDate != undefined && emailFromDate != '') {

                        emailListPostData.fromdate = emailFromDate;

                    }

                    delete emailListPostData.status;

                }

                $('.email-item-count').html('');
                $('.email-inbox-unread-count').html('');

                if (gridCategory != 'emailSentCount') {

                    $('.email-result-count').html('');

                }

                $('.email-last-updated').html('-');
                $('.email-last-updated').removeClass('bg-danger pa-5 txt-light');

                /* AJAX call to get list */
                $.ajax({

                    url: listUrl,
                    data: emailListPostData,
                    dataType: "json"

                }).done(function(response) {

                    var dataResult = {};

                    dataResult.data = '';

                    if (response.success == "true") {

                        if (response.data != '') {

                            response.data = formatDataItem(response.data);

                            dbClients = response.data;

                            // response.unread_count = '6669';

                            dataResult.data = response.data;
                            dataResult.itemsCount = response.result_count;

                            d.resolve(dataResult);

                            // $(gridSelector).jsGrid("option", "data", response.data);
                            // $(gridSelector).jsGrid("option", "itemsCount", response.result_count);

                            // $('.jsgrid-grid-body').slimscroll({
                            //     height: '300px',
                            // });

                            if (gridSelector == '.nonBusinessEmailGrid') {

                                $('.nonBusinessEmailGrid .jsgrid-grid-body').slimscroll({
                                    height: '520px',
                                    alwaysVisible: 'true',
                                });

                                $('.nonBusinessEmails .email-inbox-nav').slimscroll({
                                    height: '520px',
                                    alwaysVisible: 'true',
                                });

                            } else {

                                $('.jsgrid-grid-body').slimscroll({
                                    height: '350px',
                                    alwaysVisible: 'true',
                                });

                            }

                            if ('result_count' in response) {

                                // $(gridSelector).parent().prev().find('.result-count').html('(' + response.result_count + ')');
                                // $(gridSelector).parent().prev().find('.result-count').addClass('result-count-icon-badge');

                                if (gridCategory != 'emailSentCount') {

                                    $('.email-result-count').html('(' + response.result_count + ')');

                                }

                                emailResultClass = emailFilter;

                                if (gridEmailLabel != undefined && gridEmailLabel != '') {

                                    emailResultClass = gridEmailLabel.replace(/,/g, '');

                                }

                                var resultCount = response.result_count;

                                if (parseInt(resultCount) != NaN && parseInt(resultCount) > 0) {

                                    if (parseInt(resultCount) > 99999) {

                                        resultCount = '99999+'

                                    }

                                    $('.email-' + emailResultClass + '-count').html(resultCount);

                                }


                            }

                            if ('last_updated' in response) {

                                if ('last_updated_delay' in response && response.last_updated_delay == 'true') {

                                    $('.email-last-updated').addClass('bg-danger pa-5 txt-light');

                                } else {

                                    $('.email-last-updated').removeClass('bg-danger pa-5 txt-light');

                                }

                                $('.email-last-updated').html(response.last_updated);

                            }

                            if ('unread_count' in response && emailFilter == 'unread') {

                                var unreadCount = response.unread_count;

                                if (parseInt(unreadCount) != NaN && parseInt(unreadCount) > 0) {

                                    if (parseInt(unreadCount) > 99) {

                                        unreadCount = '99+'

                                    }

                                    $('.email-inbox-unread-count').html(unreadCount);

                                }

                            }

                            if ('reviewed_count' in response && emailFilter == 'email_review') {

                                $('#emailReview .reviewed-email-count').html(response.reviewed_count);

                            }

                            // if (gridCategory == 'emailSentCount' || gridCategory == 'qcEmail') {

                            //     $(gridSelector).jsGrid("fieldOption", "Control", "width", 10);

                            // }


                            // } else {

                            //     // $(gridSelector).parent().prev().find('.result-count').html('');
                            //     // $(gridSelector).parent().prev().find('.result-count').removeClass('result-count-icon-badge');

                            //     $('.email-result-count').html('');

                            // }

                        } else {

                            d.resolve(dataResult);

                        }

                    } else {

                        d.resolve(dataResult);

                    }

                    // } else {

                    //     // $(gridSelector).parent().prev().find('.result-count').html('');
                    //     // $(gridSelector).parent().prev().find('.result-count').removeClass('result-count-icon-badge');

                    //     $('.email-result-count').html('');

                    // }

                });

                return d.promise();

                // return $.grep(dbClients, function(client) {
                //     return (!filter.created_date || (client.created_date != undefined && client.created_date != null && (client.created_date.toLowerCase().indexOf(filter.created_date.toLowerCase()) > -1))) &&
                //         // (!filter.status_text || (client.status_text != undefined && client.status_text != null && (client.status_text.toLowerCase().indexOf(filter.status_text.toLowerCase()) > -1))) &&
                //         (!filter.subject_link || (client.subject_link != undefined && client.subject_link != null && (client.subject_link.toLowerCase().indexOf(filter.subject_link.toLowerCase()) > -1))) &&
                //         (!filter.email_from || (client.email_from != undefined && client.email_from != null && (client.email_from.toLowerCase().indexOf(filter.email_from.toLowerCase()) > -1))) &&
                //         (!filter.email_to || (client.email_to != undefined && client.email_to != null && (client.email_to.toLowerCase().indexOf(filter.email_to.toLowerCase()) > -1))) &&
                //         (!filter.message_start || (client.message_start != undefined && client.message_start != null && (client.message_start.toLowerCase().indexOf(filter.message_start.toLowerCase()) > -1)));
                //     // (!filter.message || (client.message != undefined && client.message != null && (client.message.toLowerCase().indexOf(filter.message.toLowerCase()) > -1)));
                //     // (!filter.message || (client.message != undefined && client.message != null && (client.message.toLowerCase().indexOf(filter.message.toLowerCase()) > -1))) &&
                //     // (!filter.email_cc || (client.email_cc != undefined && client.email_cc != null && (client.email_cc.toLowerCase().indexOf(filter.email_cc.toLowerCase()) > -1))) &&
                //     // (!filter.priority || (client.priority != undefined && client.priority != null && (client.priority.toLowerCase().indexOf(filter.priority.toLowerCase()) > -1))) &&
                //     // (!filter.score || (client.score != undefined && client.score != null && (client.score.toLowerCase().indexOf(filter.score.toLowerCase()) > -1)));
                // });

            }
        },

        rowClass: function(item, itemIndex) {

            var rowClassName = '';

            if (item.view != undefined && item.view == '0') {

                rowClassName = 'notification-unread-color';

            }

            return rowClassName;

        },

        rowClick: function(args) {

            $(gridSelector).jsGrid("cancelEdit");

        },

    });

    // }

    function formatDataItem(dataValue) {

        if (dataValue.length > 0) {

            for (var i = 0, len = dataValue.length; i < len; i++) {

                dataValue[i].s_no = i + 1;

            }

        }

        return dataValue;

    }

}

function getPmsEmailCountTableList(gridSelector) {

    var gridType = $(gridSelector).attr('data-type');
    var listUrl = $(gridSelector).attr('data-list-url');
    var currentRoute = $(gridSelector).attr('data-current-route');
    var pageSize = $('#currentUserInfo').attr('data-page-size');

    var insertControlVisible = false;
    var editControlVisible = false;
    var deleteControlVisible = false;

    var dbClients = "";

    // if ($(gridSelector + ' .jsgrid-grid-header').attr('class') == undefined) {

    var field = [];

    field.push({
        title: "S.NO",
        name: "s_no",
        type: "number",
        inserting: false,
        filtering: false,
        // sorting: false,
        editing: false,
        width: '5%',
    });

    field.push({
        title: "NAME",
        name: "empname",
        type: "text",
        width: '10%',
    });

    field.push({
        title: "EMAIL COUNT",
        name: "email_count",
        type: "text",
        // filtering: false,
        // sorting: false,
        width: '6%',
    });

    field.push({
        title: "PRIORITY EMAIL",
        name: "priority_count",
        type: "text",
        // filtering: false,
        // sorting: false,
        width: '6%',
    });

    field.push({
        title: "CRITICAL EMAILS",
        name: "critical_jobs_email_count",
        type: "text",
        // filtering: false,
        // sorting: false,
        width: '6%',
    });

    //am=0 && qc=0
    field.push({
        title: "POTENTIAL ALARMING EMAILS",
        name: "negative_count_link",
        // name: "negative_count",
        type: "text",
        // filtering: false,
        // sorting: false,
        // width: 40,
    });

    //am=0 && qc=1
    field.push({
        title: "VERIFIED ALARMING EMAILS",
        name: "alarming_count_link",
        type: "text",
        // filtering: false,
        // sorting: false,
        width: '6%',
    });

    //am=1
    field.push({
        title: "ESCALATION EMAILS",
        name: "escalation_count_link",
        type: "text",
        // filtering: false,
        // sorting: false,
        width: '7%',
    });


    field.push({
        title: "CRITICAL JOBS",
        name: "critical_job_count",
        type: "text",
        // filtering: false,
        // sorting: false,
        width: '6%',
    });

    field.push({
        title: "TASK COUNT",
        name: "task_count",
        type: "text",
        // filtering: false,
        // sorting: false,
        width: '6%',
    });

    field.push({
        title: "OVER DUE TASK COUNT",
        name: "over_due_task_count",
        type: "text",
        // filtering: false,
        // sorting: false,
        // width: 40,
    });

    field.push({
        title: 'LAST ANNOTATED TIME',
        name: 'last_annotated_time',
        type: 'text',
        width: '12%',
    });

    field.push({
        title: 'LAST PROCEESED TIME',
        name: 'last_processed_time',
        type: 'text',
        width: '12%',
    });

    field.push({
        type: "control",
        name: "Control",
        editButton: editControlVisible,
        deleteButton: deleteControlVisible,
        headerTemplate: function() {

            return this._createOnOffSwitchButton("filtering", this.searchModeButtonClass, false);

        },
        width: '4%',
    });

    $(gridSelector).jsGrid({

        height: "450px",
        width: "100%",
        autowidth: true,
        editing: editControlVisible,
        inserting: insertControlVisible,
        filtering: false,
        sorting: true,
        autoload: false,
        paging: false,
        pageLoading: false,
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

        // onInit: function(args) {

        //     this._resetPager();

        // },

        // search: function(filter) {

        //     this._resetPager();
        //     return this.loadData(filter);

        // },

        // onPageChanged: function(args) {

        //     $('html, body').animate({
        //         scrollTop: $(".pmsEmailCountGrid").offset().top - 140
        //     }, 0);

        // },

        controller: {

            loadData: function(filter) {

                return $.grep(dbClients, function(client) {
                    return (!filter.empname || (client.empname != undefined && client.empname != null && (client.empname.toLowerCase().indexOf(filter.empname.toLowerCase()) > -1))) &&
                        (!filter.email_count || (client.email_count != undefined && client.email_count != null && (client.email_count.toLowerCase().indexOf(filter.email_count.toLowerCase()) > -1))) &&
                        (!filter.priority_count || (client.priority_count != undefined && client.priority_count != null && (client.priority_count.toLowerCase().indexOf(filter.priority_count.toLowerCase()) > -1))) &&
                        (!filter.critical_jobs_email_count || (client.critical_jobs_email_count != undefined && client.critical_jobs_email_count != null && (client.critical_jobs_email_count.toLowerCase().indexOf(filter.critical_jobs_email_count.toLowerCase()) > -1))) &&
                        (!filter.negative_count_link || (client.negative_count_link != undefined && client.negative_count_link != null && (client.negative_count_link.toLowerCase().indexOf(filter.negative_count_link.toLowerCase()) > -1))) &&
                        (!filter.critical_job_count || (client.critical_job_count != undefined && client.critical_job_count != null && (client.critical_job_count.toLowerCase().indexOf(filter.critical_job_count.toLowerCase()) > -1))) &&
                        (!filter.over_due_task_count || (client.over_due_task_count != undefined && client.over_due_task_count != null && (client.over_due_task_count.toLowerCase().indexOf(filter.over_due_task_count.toLowerCase()) > -1))) &&
                        (!filter.task_count || (client.task_count != undefined && client.task_count != null && (client.task_count.toLowerCase().indexOf(filter.task_count.toLowerCase()) > -1))) &&
                        (!filter.last_annotated_time || (client.last_annotated_time != undefined && client.last_annotated_time != null && (client.last_annotated_time.toLowerCase().indexOf(filter.last_annotated_time.toLowerCase()) > -1))) &&
                        (!filter.last_processed_time || (client.last_processed_time != undefined && client.last_processed_time != null && (client.last_processed_time.toLowerCase().indexOf(filter.last_processed_time.toLowerCase()) > -1)));
                });

            }
        },

        rowClick: function(args) {

            $(gridSelector).jsGrid("cancelEdit");

        },

    });

    // }

    $('.pms-email-count').html('');

    var d = $.Deferred();

    var pmsEmailCountPostData = {};

    // $('.pmsemailcount_loader').show();

    /* AJAX call to get list */
    $.ajax({

        url: listUrl,
        data: pmsEmailCountPostData,
        dataType: "json",
        beforeSend: function() {
            $('.pmsemailcount_loader').show();
        },
        complete: function() {
            $('.pmsemailcount_loader').hide();
        }

    }).done(function(response) {

        var dataResult = {};

        dataResult.data = '';

        if (response.success == "true") {

            if (response.data != '') {

                response.data = formatDataItem(response.data);

                dbClients = response.data;

                dataResult.data = response.data;
                dataResult.itemsCount = response.result_count;

                if ('result_count' in response) {

                    var resultCount = response.result_count;

                    if (parseInt(resultCount) != NaN && parseInt(resultCount) > 0) {

                        if (parseInt(resultCount) > 99999) {

                            resultCount = '99999+'

                        }

                        $('.pms-email-count').html('(' + resultCount + ')');

                    }


                }

                $(gridSelector).jsGrid("option", "data", response.data);

                $('.jsgrid-grid-body').slimscroll({
                    height: '300px',
                });

            }

        }

        // $('.pmsemailcount_loader').hide();

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

function findBrowser() {

    var navUserAgent = navigator.userAgent;
    var browserName = navigator.appName;
    var browserVersion = '' + parseFloat(navigator.appVersion);
    var majorVersion = parseInt(navigator.appVersion, 10);
    var tempNameOffset, tempVersionOffset, tempVersion;

    if ((tempVersionOffset = navUserAgent.indexOf("Opera")) != -1) {
        browserName = "Opera";
        browserVersion = navUserAgent.substring(tempVersionOffset + 6);
        if ((tempVersionOffset = navUserAgent.indexOf("Version")) != -1)
            browserVersion = navUserAgent.substring(tempVersionOffset + 8);
    } else if ((tempVersionOffset = navUserAgent.indexOf("MSIE")) != -1) {
        browserName = "Microsoft Internet Explorer";
        browserVersion = navUserAgent.substring(tempVersionOffset + 5);
    } else if ((tempVersionOffset = navUserAgent.indexOf("Chrome")) != -1) {
        browserName = "Chrome";
        browserVersion = navUserAgent.substring(tempVersionOffset + 7);
    } else if ((tempVersionOffset = navUserAgent.indexOf("Safari")) != -1) {
        browserName = "Safari";
        browserVersion = navUserAgent.substring(tempVersionOffset + 7);
        if ((tempVersionOffset = navUserAgent.indexOf("Version")) != -1)
            browserVersion = navUserAgent.substring(tempVersionOffset + 8);
    } else if ((tempVersionOffset = navUserAgent.indexOf("Firefox")) != -1) {
        browserName = "Firefox";
        browserVersion = navUserAgent.substring(tempVersionOffset + 8);
    } else if ((tempNameOffset = navUserAgent.lastIndexOf(' ') + 1) < (tempVersionOffset = navUserAgent.lastIndexOf('/'))) {
        browserName = navUserAgent.substring(tempNameOffset, tempVersionOffset);
        browserVersion = navUserAgent.substring(tempVersionOffset + 1);
        if (browserName.toLowerCase() == browserName.toUpperCase()) {
            browserName = navigator.appName;
        }
    }

    // trim version
    if ((tempVersion = browserVersion.indexOf(";")) != -1)
        browserVersion = browserVersion.substring(0, tempVersion);
    if ((tempVersion = browserVersion.indexOf(" ")) != -1)
        browserVersion = browserVersion.substring(0, tempVersion);

    return browserName;
}

var browserName = findBrowser();

var tinymceStyle = '<style>body {font-size: 11.0pt; font-family: Calibri; color: #1f497d;} p{margin: 0in; margin-bottom: .0001pt; font-size: 11.0pt; font-family: Calibri; color: #1F497D;}</style>';
var emailEditorParaTag = '<p class="pmbot_p" style="margin: 0in; margin-bottom: .0001pt; font-size: 11.0pt; font-family: Calibri; color: #1F497D;"><br></p>';
// var emailEditorParaTag = tinymceStyle + '<p class="pmbot_p" style="margin: 0in; margin-bottom: .0001pt; font-size: 11.0pt; font-family: Calibri; color: #1F497D;"><br></p>';
var emailSignatureEditorParaTag = '<p class="pmbot_p" style="margin: 0in; margin-bottom: .0001pt; font-size: 10.0pt; font-family: Arial; color: #1F497D;"><br></p>';

if (browserName == 'Firefox') {

    emailEditorParaTag = '<p class="pmbot_p" style="margin: 0in; margin-bottom: .0001pt; font-size: 11.0pt; font-family: Calibri; color: #1F497D;"></p>';
    // emailEditorParaTag = tinymceStyle + '<p class="pmbot_p" style="margin: 0in; margin-bottom: .0001pt; font-size: 11.0pt; font-family: Calibri; color: #1F497D;"></p>';
    emailSignatureEditorParaTag = '<p class="pmbot_p" style="margin: 0in; margin-bottom: .0001pt; font-size: 10.0pt; font-family: Arial; color: #1F497D;"></p>';

}

var gridSelector = ".myEmailGrid";

var dataUrl = $(gridSelector).attr('data-list-url');

if (dataUrl != undefined && dataUrl != "") {

    // $(".dashboard-inbox-email").trigger('click');

    getEmailTableList(gridSelector);

}

setInterval(function() {

    var gridSelector = ".myEmailGrid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    var gridPageIndex = $(gridSelector).jsGrid('option', 'pageIndex');

    if (gridPageIndex != undefined && gridPageIndex == "1" && dataUrl != undefined && dataUrl != "") {

        // $(".dashboard-inbox-email").trigger('click');

        getEmailTableList(gridSelector);

    }

}, '60000');

var jobEmailgridSelector = '.jobEmailGrid';

var jobEmailgridUrl = $(jobEmailgridSelector).attr('data-list-url');

if (jobEmailgridUrl != undefined && jobEmailgridUrl != "") {

    getEmailTableList(jobEmailgridSelector);

}

var pmsEmailCountGridSelector = '.pmsEmailCountGrid';

var pmsEmailCountGridUrl = $(pmsEmailCountGridSelector).attr('data-list-url');

if (pmsEmailCountGridUrl != undefined && pmsEmailCountGridUrl != "") {

    getPmsEmailCountTableList(pmsEmailCountGridSelector);

}

$(document).on('click', '.amEmailListTab', function() {

    var gridSelector = ".pmsEmailCountGrid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        getPmsEmailCountTableList(gridSelector);

    }

});

/*$(document).on('click', '.email-item', function(e) {

    e.preventDefault();

    var emailItemPostData = {};

    var itemUrl = $(this).attr('href');

    if (itemUrl != undefined && itemUrl != '') {

        // AJAX call to email item info
       // $.ajax({

        //     url: itemUrl,
        //     data: emailItemPostData,
        //     dataType: "json"

        // }).done(function(response) {

        //     if (response.success == "true") {}
        // });

        $('.email-list-body').hide();
       $('.email-detail-body').show();

    }

});*/

$(document).on('click', '.job-unmark-btn', function(e) {

    e.preventDefault();

    Swal.fire({

        title: 'Are you sure?',
        text: "Do you want to un-associate this email from this job? If yes, then it will delete all the task related to this email!",
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

            jobEmailUnmark();

        }

    });

});


function jobEmailUnmark() {

    var emailPostData = {};

    var postUrl = $('.job-unmark-btn').attr('data-email-status-update-url');
    var emailId = $('.email-title').attr('data-email-id');
    var jobId = $('.job-unmark-btn').attr('data-job-id');

    if (jobId != undefined && jobId != '' && emailId != undefined && emailId != '' && postUrl != undefined && postUrl != '') {

        emailPostData.id = emailId;
        emailPostData.job_id = jobId;
        emailPostData.type = 'pmbot';
        emailPostData.status = '0';

        var type = 'error';

        var message = '';

        var d = $.Deferred();

        // AJAX call to email status update
        $.ajax({

            url: postUrl,
            data: emailPostData,
            dataType: "json"

        }).done(function(response) {

            if (response.success == "true") {

                type = 'success';

            } else {

                type = 'error';

                d.resolve();

            }

            if (response.message != undefined && response.message != '') {

                message = response.message;

            }

            flashMessage(type, message);

            if (response.redirectTo != undefined && response.redirectTo != '') {

                window.location = response.redirectTo;

            }

        });

        return d.promise();

    }

}

$(document).on('click', '.non-business-unmark-btn', function(e) {

    e.preventDefault();

    var emailPostData = {};

    var postUrl = $(this).attr('data-email-status-update-url');
    var emailId = $('.email-title').attr('data-email-id');

    if (emailId != undefined && emailId != '' && postUrl != undefined && postUrl != '') {

        emailPostData.id = emailId;
        emailPostData.type = 'pmbot';
        emailPostData.status = '0';

        var type = 'error';

        var message = '';

        var d = $.Deferred();

        // AJAX call to email status update
        $.ajax({

            url: postUrl,
            data: emailPostData,
            dataType: "json"

        }).done(function(response) {

            if (response.success == "true") {

                type = 'success';

            } else {

                type = 'error';

                d.resolve();

            }

            if (response.message != undefined && response.message != '') {

                message = response.message;

            }

            flashMessage(type, message);

            if (response.redirectTo != undefined && response.redirectTo != '') {

                window.location = response.redirectTo;

            }

        });

        return d.promise();

    }

});

function emailDetailInfo(emailId, postUrl, emailCategory, emailgroupIds) {

    if (emailId != undefined && emailId != '' && postUrl != undefined && postUrl != '') {

        var emailListBlock = 'email-list-body';
        var emailDetailBlock = 'email-detail-body';

        var emailItemPostData = {};

        emailItemPostData.emailid = emailId;

        if (emailCategory != undefined && emailCategory != '') {

            emailItemPostData.type = emailCategory;

        }

        if (emailgroupIds != undefined && emailgroupIds != '') {

            emailItemPostData.email_group_ids = emailgroupIds;

        }

        emailItemPostData.view = '1';

        $('.email-title').attr('data-email-id', '');

        $('.email-unreview-btn').attr('data-group-ids', '');

        $('.non-business-unmark-btn-block').hide();
        $('.email-classification-move-to-block').hide();
        $('.email-escalation-close-block').hide();

        $('.job-unmark-btn-block').hide();
        $('.job-unmark-btn').attr('data-job-id', '');

        $('.email-annotator-link').attr('href', 'javascript:void(0);');
        $('.email-annotator-link-block').hide();
        $('.email-download-link').attr('href', 'javascript:void(0);');
        $('.email-download-link-block').hide();
        $('.email-draftbutton-group').hide();

        $('.email-move-to-block').hide();
        $('.email-move-to-email-id').val('');
        $('.email-move-to-input').select2().val('').trigger('change');
        $('.email-move-to-input').select2({ data: [] });

        $('.email-title').html('');
        $('.email-title').attr('data-email-empcode', '');
        $('.email-title').attr('data-subject-raw-text', '');
        $('.email-title-block').hide();

        $('.email-from').html('');
        $('.email-from-block').hide();

        $('.email-to').html('');
        $('.email-to-block').hide();

        $('.email-cc').html('');
        $('.email-cc-block').hide();

        $('.email-bcc').html('');
        $('.email-bcc-block').hide();

        $('.email-date').html('');
        $('.email-date-block').hide();

        $('.email-body').html();
        $('.email-body-block').hide();

        $('.attachment-count').html('');
        $('.attachment-items').html('');
        $('.attachment-block').hide();

        $('.email-button-group').show();

        $('.email-rating-form .star-block').rating('reset');
        // $('.email-rating-form .star-block').rating('update', 0);

        $.ajax({

            url: postUrl,
            data: emailItemPostData,
            dataType: 'json',
            type: 'POST',
            beforeSend: function() {
                $('.email_detail_loader').show();
            },
            complete: function() {
                $('.email_detail_loader').hide();
            }

        }).done(function(response) {

            if (response.success == "true") {

                if (response.data != undefined && response.data != '') {

                    if (response.data != undefined && response.data != '') {

                        if (response.data.id != undefined && response.data.id != '') {

                            $('.email-title').attr('data-email-id', response.data.id);
                            $('.email-move-to-email-id').val(response.data.id);
                            $('.email-classification-move-to-email-id').val(response.data.id);

                        }

                        if (response.data.status != undefined && response.data.status == '5') {

                            //$('.email-title').attr('data-email-id', response.data.id);
                            $('.email-button-group').hide();

                        }

                        if (response.data.status != undefined && response.data.status == '4') {

                            $('.email-button-group').hide();
                            $('.email-draftbutton-group').show();

                        }

                        if (response.data.status != undefined && response.data.status == '99') {

                            $('.email-button-group').hide();
                            $('.email-draftbutton-group').show();

                        }

                        if (response.data.type != undefined && response.data.type == 'non_pmbot') {

                            $('.non-business-unmark-btn-block').show();
                            $('.email-move-to-block').show();

                        }

                        if (response.data.type != undefined && response.data.type == 'pmbot') {

                            if (response.data.job_id != undefined && response.data.job_id != '' && response.data.status == '2') {

                                $('.job-unmark-btn').attr('data-job-id', response.data.job_id);

                                $('.job-unmark-btn-block').show();

                            }

                        }


                        if (response.data.email_annotator_link != undefined && response.data.email_annotator_link != '') {

                            $('.email-annotator-link').attr('href', response.data.email_annotator_link);
                            $('.email-annotator-link-block').show();

                        }

                        if (response.data.email_download_path != undefined && response.data.email_download_path != '') {

                            $('.email-download-link').attr('href', response.data.email_download_path);
                            $('.email-download-link-block').show();

                        }

                        if (response.data.group_ids != undefined && response.data.group_ids != '') {

                            $('#emailReview .email-unreview-btn').attr('data-group-ids', response.data.group_ids);

                        }

                        if (response.data.subject != undefined && response.data.subject != '') {

                            // $('.email-title').html(atob(response.data.subject));

                            $('.email-title').html(response.data.subject);
                            //$('.email-title').html("Special Day Wishes");

                            if (response.data.email_id != undefined && response.data.email_id != '') {

                                $('.email-title').attr('data-email-empcode', response.data.empcode);

                            }

                            if (response.data.subject_raw_text != undefined && response.data.subject_raw_text != '') {

                                $('.email-title').attr('data-subject-raw-text', response.data.subject_raw_text);

                            }

                            $('.email-title-block').show();

                        }

                        if (response.data.email_from != undefined && response.data.email_from != '') {

                            $('.email-from').html(response.data.email_from);
                            $('.email-from-block').show();

                        }

                        if (response.data.email_to != undefined && response.data.email_to != '') {

                            $('.email-to').html(response.data.email_to);
                            $('.email-to-block').show();

                        }

                        if (response.data.email_cc != undefined && response.data.email_cc != '') {

                            $('.email-cc').html(response.data.email_cc);
                            $('.email-cc-block').show();

                        }

                        if (response.data.email_bcc != undefined && response.data.email_bcc != '') {

                            $('.email-bcc').html(response.data.email_bcc);
                            $('.email-bcc-block').show();

                        }

                        if (response.data.create_date_formatted_text != undefined && response.data.create_date_formatted_text != '') {

                            $('.email-date').html(response.data.create_date_formatted_text);

                            if (response.data.create_date_text != undefined && response.data.create_date_text != '') {

                                $('.email-date').attr('data-email-date', response.data.create_date_text);

                            }

                            $('.email-date-block').show();

                        }

                        if (response.data.body_html != undefined && response.data.body_html != '') {

                            // $('.email-body').html(atob(response.data.body_html));
                            // $('.email-body').html(response.data.body_html);

                            if (tinymce.get('email-body') != undefined && tinymce.get('email-body') != '') {

                                tinymce.get('email-body').setContent(response.data.body_html);

                            }

                            if (emailCategory != undefined && emailCategory == 'emailSentCount') {

                                if (tinymce.get('sent-email-body') != undefined && tinymce.get('sent-email-body') != '') {

                                    tinymce.get('sent-email-body').setContent(response.data.body_html);

                                }

                            }

                            if (emailCategory != undefined && emailCategory == 'qcEmail') {

                                if (tinymce.get('qc-email-body') != undefined && tinymce.get('qc-email-body') != '') {

                                    tinymce.get('qc-email-body').setContent(response.data.body_html);

                                }

                            }

                            if ($('.currentUserInfo').attr('data-current-user-role') == 'quality') {

                                if (emailCategory != undefined && emailCategory == 'qcEmail') {

                                    if (tinymce.get('qc-email-body') != undefined && tinymce.get('qc-email-body') != '') {

                                        tinymce.get('qc-email-body').setContent(response.data.body_html);

                                    }

                                }

                            }

                            if (emailCategory != undefined && emailCategory == 'email-review') {

                                if (tinymce.get('email-review-body') != undefined && tinymce.get('email-review-body') != '') {

                                    tinymce.get('email-review-body').setContent(response.data.body_html);

                                }

                            }

                            if (emailCategory != undefined && emailCategory == 'email-review-latest') {

                                if (tinymce.get('review-email-modal-body') != undefined && tinymce.get('review-email-modal-body') != '') {

                                    tinymce.get('review-email-modal-body').setContent(response.data.body_html);

                                }

                            }

                            $('.email-body-block').show();

                        }

                        // if (response.label_list != undefined && response.label_list != '') {
                        if (response.label_list != undefined && response.label_list != '') {

                            $('.email-move-to-input').select2({ data: response.label_list });

                        }

                        if (response.data.label_name != undefined && response.data.label_name != '') {

                            $('.email-move-to-input').select2().val(response.data.label_name).trigger('change');

                        }

                        if (response.data.classification_list != undefined && response.data.classification_list != '') {

                            $('.email-classification-move-to-input').select2({ data: response.data.classification_list });

                        }

                        if (response.data.email_classification_category != undefined && response.data.email_classification_category != '') {

                            $('.email-classification-move-to-input').attr('previous_value', response.data.email_classification_category);
                            $('.email-classification-move-to-input').select2().val(response.data.email_classification_category).trigger('change');

                        }

                        if (response.data.am_approved != undefined && response.data.am_approved != '1') {

                            $('.email-classification-move-to-block').show();

                        } else {

                            $('.email-escalation-close-block').show();

                        }

                        if (response.data.email_attachment_count != undefined && response.data.email_attachment_count != '') {

                            $('.attachment-count').html(response.data.email_attachment_count);

                            if (response.data.email_attachment_html != undefined && response.data.email_attachment_html != '') {

                                $('.attachment-items').html(response.data.email_attachment_html);

                            }

                            $('.attachment-block').show();

                        }

                        if (emailCategory != undefined && emailCategory == 'email-review') {

                            $('.email-rating-form .email-rating-sumbit-btn').attr('data-email-get-url', postUrl);

                            if ('ratings' in response.data && response.data.ratings != '') {

                                if ('issue' in response.data.ratings && response.data.ratings.issue) {

                                    $('.email-rating-form .issue').rating('update', parseInt(response.data.ratings.issue));

                                }

                                if ('responded' in response.data.ratings && response.data.ratings.responded) {

                                    $('.email-rating-form .responded').rating('update', parseInt(response.data.ratings.responded));

                                }

                                if ('language' in response.data.ratings && response.data.ratings.language) {

                                    $('.email-rating-form .language').rating('update', parseInt(response.data.ratings.language));

                                }

                                if ('satisfaction' in response.data.ratings && response.data.ratings.satisfaction) {

                                    $('.email-rating-form .satisfaction').rating('update', parseInt(response.data.ratings.satisfaction));

                                }

                                if ('speed' in response.data.ratings && response.data.ratings.speed) {

                                    $('.email-rating-form .speed').rating('update', parseInt(response.data.ratings.speed));

                                }

                            }

                        }

                    }


                }
            }
        });

        if (emailCategory != undefined && emailCategory == 'email-review-latest') {

            emailListBlock = 'review-email-modal-list-body';
            emailDetailBlock = 'review-email-modal-detail-body';

        }

        $('.' + emailListBlock).hide();
        $('.' + emailDetailBlock).show();

    }

}

$(document).on('click', '.pmbot-email-item', function(e) {

    e.preventDefault();

    var emailId = $(this).attr('data-email-id');
    var postUrl = $(this).attr('data-email-geturl');
    var emailCategory = $(this).attr('data-email-category');
    var emailGroupIds = $(this).attr('data-email-group-ids');

    emailDetailInfo(emailId, postUrl, emailCategory, emailGroupIds);

});

$(document).on('click', '.email-detail-back-btn', function(e) {

    e.preventDefault();

    $('.email-list-body').show();
    $('.email-detail-body').hide();

    $('.inbox-nav li.active').find('a').trigger('click');

});

$(document).on('click', '.review-email-modal-detail-back-btn', function(e) {

    e.preventDefault();

    $('.review-email-modal-list-body').show();
    $('.review-email-modal-detail-body').hide();

});

$(document).on('click', '.email-move-to-btn', function(e) {

    e.preventDefault();

    var postUrl = '';
    var params = '';
    params = $('.email-move-to-form').serialize();

    postUrl = $('.email-move-to-form').attr('action');

    if (postUrl != undefined && postUrl != '') {

        if ($('.email-move-to-input').val() == null || $('.email-move-to-input').val() == '') {

            Swal.fire({

                title: '',
                text: "Invaild label!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }

        /* AJAX call to email label update info */

        var d = $.Deferred();

        $.ajax({
            url: postUrl,
            data: params,
            dataType: 'json',
            type: 'POST',
        }).done(function(response) {

            if (response.success == "true") {

                type = 'success';

            } else {

                type = 'error';

                d.resolve();

            }

            message = response.message;

            flashMessage(type, message);

            // $('.dashboard-nb-email-label').find('[data-label=" ' + $('.email-move-to-form .email-move-to-input').val() + '"]').trigger('click');

            // $('#nonBusinessEmailsTab').trigger('click');

            $('.dashboard-inbox-email').trigger('click');

        });

        return d.promise();


    }

    // emailSend(postUrl, params, '#emailSendModal', '');

});

function escalationEmailClasificationMoveTo(postUrl, params) {

    /* AJAX call to email label update info */

    var d = $.Deferred();

    $.ajax({
        url: postUrl,
        data: params,
        dataType: 'json',
        type: 'POST',
        beforeSend: function() {
            $('.email_detail_loader').show();
        },
        complete: function() {
            $('.email_detail_loader').hide();
        }
    }).done(function(response) {

        if (response.success == "true") {

            type = 'success';

        } else {

            type = 'error';

            d.resolve();

        }

        message = response.message;

        flashMessage(type, message);

        $('.email-detail-back-btn').trigger('click');

        var gridSelector = ".myEmailGrid";

        if ($('.currentUserInfo').attr('data-current-user-role') == 'account_manager') {

            // gridSelector = ".emailQCCountGrid";

            gridSelector = ".emailQCCountGrid";

            pmsEmailCountGrid = ".pmsEmailCountGrid";

            var dataUrl = $(pmsEmailCountGrid).attr('data-list-url');

            if (dataUrl != undefined && dataUrl != "") {

                getPmsEmailCountTableList(pmsEmailCountGrid);

            }

        }

        var dataUrl = $(gridSelector).attr('data-list-url');

        if (dataUrl != undefined && dataUrl != "") {

            getEmailTableList(gridSelector);

        }

    });

    return d.promise();

}

$('#QCEmailModal').on('shown.bs.modal', function() { $(document).off('focusin.modal') });

$(document).on('click', '.email-classification-move-to-btn', function(e) {

    e.preventDefault();

    var postUrl = '';

    var params = '';

    var move_to_confirmation = 'false';

    $('.email-classification-move-to-input').select2().val($('.email-classification-move-to-input').select2().val())

    // emailClassificationCategory = $('.email-classification-move-to-input').select2().val();

    // emailClassificationCategoryPreviousValue = $('.email-classification-move-to-input').attr('previous_value');

    // if (emailClassificationCategory != undefined && emailClassificationCategory != '') {

    //     if (emailClassificationCategoryPreviousValue != undefined && emailClassificationCategoryPreviousValue != '' && emailClassificationCategory == emailClassificationCategoryPreviousValue) {

    //         $('.email-classification-move-to-input').select2().val('').trigger('change');

    //     }

    // }

    params = $('.email-classification-move-to-form').serialize();

    postUrl = $('.email-classification-move-to-form').attr('action');

    if (postUrl != undefined && postUrl != '') {

        if ($('.email-classification-move-to-input').val() == null || $('.email-classification-move-to-input').val() == '' || $('.email-classification-move-to-input').val() == '0') {

            Swal.fire({

                title: '',
                text: "Invaild category!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }

        Swal.fire({

            title: 'Are you sure?',
            text: "Do you want to change the email category!",
            // icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            showClass: {
                popup: 'animated fadeIn faster'
            },
            hideClass: {
                popup: 'animated fadeOut faster'
            },

        }).then((result) => {

            if (result.value != undefined && result.value == true) {

                params = $('.email-classification-move-to-form').serialize();

                escalationEmailClasificationMoveTo(postUrl, params);

            }

        });

    }

});

$(document).on('click', '.email-escalation-close-btn', function(e) {

    e.preventDefault();

    var postUrl = '';

    var params = '';

    params = $('.email-escalation-close-form').serialize();

    postUrl = $('.email-escalation-close-form').attr('action');

    if (postUrl != undefined && postUrl != '') {

        if ($('.currentUserInfo').attr('data-current-user-role') == 'account_manager') {

            Swal.fire({

                html: '<textarea class="escalation-email-complete-remarks-field col-lg-12 col-md-12 col-sm-12 col-xs-12 pt-15" placeholder="Enter remarks"/>',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                showClass: {
                    popup: 'animated fadeInDownBig faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            }).then((result) => {

                if (result.value != undefined && result.value == true) {

                    $('.escalation-email-remarks').val('');

                    var remarksVal = $('.escalation-email-complete-remarks-field').val();

                    if (remarksVal == undefined || remarksVal == false || remarksVal == '') {

                        Swal.fire({

                            title: '',
                            text: "Please enter remarks!",
                            showClass: {
                                popup: 'animated fadeIn faster'
                            },
                            hideClass: {
                                popup: 'animated fadeOut faster'
                            },

                        });

                        return false
                    }

                    $('.escalation-email-remarks').val(remarksVal);

                    params = $('.email-escalation-close-form').serialize();

                    escalationEmailClasificationMoveTo(postUrl, params);

                }

            });

        }

    }

});


$(document).on('click', '.dashboard-email-move-to-btn', function(e) {

    e.preventDefault();

    var postUrl = '';
    var params = '';
    params = $('.dashboard-email-move-to-form').serialize();

    postUrl = $('.dashboard-email-move-to-form').attr('action');

    if (postUrl != undefined && postUrl != '') {

        if ($('.dashboard-email-move-to-input').val() == null || $('.dashboard-email-move-to-input').val() == '') {

            Swal.fire({

                title: '',
                text: "Invaild label!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }

        if ($('.dashboard-email-move-to-email-id').val() == null || $('.dashboard-email-move-to-email-id').val() == '') {

            Swal.fire({

                title: '',
                text: "Please select email!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }

        /* AJAX call to email label update info */

        var d = $.Deferred();

        $.ajax({
            url: postUrl,
            data: params,
            dataType: 'json',
            type: 'POST',
        }).done(function(response) {

            if (response.success == "true") {

                type = 'success';

            } else {

                type = 'error';

                d.resolve();

            }

            message = response.message;

            flashMessage(type, message);

            $('#myTaskTab').trigger('click');

        });

        return d.promise();


    }

});


$(document).on('click', '.dashboard-inbox-email', function() {

    // var gridSelector = ".nonBusinessEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'inbox');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

});

$(document).on('click', '.dashboard-unread-email', function() {

    // var gridSelector = ".nonBusinessEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'unread');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

});

$(document).on('click', '.dashboard-error-email', function() {

    // var gridSelector = ".nonBusinessEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'error');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

    // $(this).closest('li').addClass('active');

});

$(document).on('click', '.dashboard-outbox-email', function() {

    // var gridSelector = ".nonBusinessEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'outbox');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

    // $(this).closest('li').addClass('active');

});

$(document).on('click', '.dashboard-sent-email', function() {

    // var gridSelector = ".nonBusinessEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'sent');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

    // $(this).closest('li').addClass('active');

});

$(document).on('click', '.dashboard-draft-email', function() {

    // var gridSelector = ".nonBusinessEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'draft');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

});

$(document).on('click', '.dashboard-archived-email', function() {

    // var gridSelector = ".nonBusinessEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'archived');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

});

$(document).on('click', '.dashboard-outlook-sent-email', function() {

    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'outlook-sent');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

});

$(document).on('click', '.dashboard-nb-email-label', function() {

    // var gridSelector = ".nonBusinessEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var emailLabel = $(this).attr('data-label');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        if (emailLabel != undefined && emailLabel != "") {

            $(gridSelector).attr('data-email-label', emailLabel);

        }

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

});

$(document).on('click', '.job-all-email', function(e) {

    e.stopImmediatePropagation();

    $('.job-email-nav').show();

    $('.job-email-grid-block').removeClass('col-lg-12');
    $('.job-email-grid-block').addClass('col-lg-10');

    $('.job-email-grid-block').removeClass('col-md-12');
    $('.job-email-grid-block').addClass('col-md-10');

    $('.job-email-grid-block').removeClass('col-sm-12');
    $('.job-email-grid-block').addClass('col-sm-10');

    $('.job-email-grid-block').removeClass('col-xs-12');
    $('.job-email-grid-block').addClass('col-xs-10');

    $('.job-inbox-email').trigger('click');

});

$(document).on('click', '.job-pe-email', function(e) {

    e.stopImmediatePropagation();

    $('.email-list-body').show();
    $('.email-detail-body').hide();

    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    var jobPEEmail = $(gridSelector).attr('data-pe-email');

    if (dataUrl != undefined && dataUrl != "") {

        if (jobPEEmail == undefined || jobPEEmail == '') {

            Swal.fire({

                title: '',
                text: "Please update PE email to the job!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            $(this).addClass('disabled-block');

            $('.job-all-email').trigger('click');

            return false;

        } else {

            $(this).removeClass('disabled-block');

        }

        $('.job-email-nav').hide();

        $('.job-email-grid-block').removeClass('col-lg-10');
        $('.job-email-grid-block').addClass('col-lg-12');

        $('.job-email-grid-block').removeClass('col-md-10');
        $('.job-email-grid-block').addClass('col-md-12');

        $('.job-email-grid-block').removeClass('col-sm-10');
        $('.job-email-grid-block').addClass('col-sm-12');

        $('.job-email-grid-block').removeClass('col-xs-10');
        $('.job-email-grid-block').addClass('col-xs-12');

        $(gridSelector).attr('data-email-filter', 'pe');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

});

$(document).on('click', '.job-author-email', function(e) {

    e.stopImmediatePropagation();

    $('.email-list-body').show();
    $('.email-detail-body').hide();

    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var jobAuthorEmail = $(gridSelector).attr('data-author-email');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        if (jobAuthorEmail == undefined || jobAuthorEmail == '') {

            Swal.fire({

                title: '',
                text: "Please update author email to the job!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            $(this).addClass('disabled-block');

            $('.job-all-email').trigger('click');

            return false;

        } else {

            $(this).removeClass('disabled-block');

        }

        $('.job-email-nav').hide();

        $('.job-email-grid-block').removeClass('col-lg-10');
        $('.job-email-grid-block').addClass('col-lg-12');

        $('.job-email-grid-block').removeClass('col-md-10');
        $('.job-email-grid-block').addClass('col-md-12');

        $('.job-email-grid-block').removeClass('col-sm-10');
        $('.job-email-grid-block').addClass('col-sm-12');

        $('.job-email-grid-block').removeClass('col-xs-10');
        $('.job-email-grid-block').addClass('col-xs-12');

        $(gridSelector).attr('data-email-filter', 'author');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

});

$(document).on('click', '.job-inbox-email', function() {

    // var gridSelector = ".jobEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'inbox');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

});

$(document).on('click', '.job-error-email', function() {

    // var gridSelector = ".jobEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'error');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

    // $(this).closest('li').addClass('active');

});

$(document).on('click', '.job-outbox-email', function() {

    // var gridSelector = ".jobEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'outbox');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

    // $(this).closest('li').addClass('active');

});

$(document).on('click', '.job-sent-email', function() {

    // var gridSelector = ".jobEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'sent');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

    // $(this).closest('li').addClass('active');

});

$(document).on('click', '.job-draft-email', function() {

    // var gridSelector = ".jobEmailGrid";
    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        $(gridSelector).attr('data-email-filter', 'draft');

        $(gridSelector).attr('data-email-label', '');

        getEmailTableList(gridSelector);

    }

    $('.inbox-nav li.active').removeClass('active');
    $(this).closest('li').addClass('active');
    $('.email-list-body').show();
    $('.email-detail-body').hide();

});

$(document).on('click', '.dashboard-email-sent-count-btn', function(e) {

    e.preventDefault(false);

    var gridSelector = '.' + $(this).attr('data-grid-selector');

    var modalTitle = $(this).attr('data-grid-title');

    var emailFilter = $(this).attr('data-email-filter');

    var emailCategory = $(this).attr('data-email-category');

    var emailCount = $(this).attr('data-count');

    var epmcode = $(this).attr('data-empcode');

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (emailCount != undefined && emailCount != "0") {

        if (epmcode != undefined && epmcode != "") {

            $(gridSelector).attr('data-empcode', epmcode);

        }

        if (modalTitle != undefined && modalTitle != "") {

            $('.dashboard-email-sent-count-modal-title').html(modalTitle);
            $('.dashboard-email-qc-count-modal-title').html(modalTitle);

        }

        if (dataUrl != undefined && dataUrl != "" && emailFilter != undefined && emailFilter != "") {

            $(gridSelector).attr('data-email-filter', emailFilter);

            $(gridSelector).attr('data-email-label', '');

            if (emailCategory != undefined && emailCategory != "") {

                $(gridSelector).attr('data-category', emailCategory);

            }

            getEmailTableList(gridSelector);

        }

        $('.email-list-body').show();
        $('.email-detail-body').hide();

    }

});

$(document).on('click', '.email-send-btn-old', function(e) {

    e.preventDefault();

    $('.email-status').val('0');

    var postUrl = $('.email-send-form').attr('action');

    var params = $('.email-send-form').serialize();

    var file = $('#attachement')[0].files;

    emailSend(postUrl, params, '#emailSendModal');

});

$(document).on('click', '.email-send-btn', function(e) {

    tinymce.triggerSave(true, true);

    var type = $('.pmbottype').attr('data-pmbottype');
    $('.type').val(type);

    e.preventDefault();

    if ($('#to').val() == '') {
        $("#to").focus();
        return false;
    }
    if ($('#subject').val() == '') {
        $("#subject").focus();
        return false;
    }
    if ($('#body_html').val() == '') {
        $("#body_html").focus();
        return false;
    }

    $('.email-status').val('5');

    var postUrl = $('.email-send-form').attr('action');

    var emailfrm = $('.email-send-form');

    var params = new FormData($('.email-send-form')[0]);

    // $.each($('.attachements')[0].files, function(i, file) {
    //     params.append('file-' + i, file);
    // });

    if (filesToUpload != undefined && Object.keys(filesToUpload).length > 0) {

        var i = 0;

        for (var index in filesToUpload) {

            params.append('file-' + i, filesToUpload[index]);

            i = i + 1;

        }

    }

    if (attachtedEmailFilesToUpload != undefined && Object.keys(attachtedEmailFilesToUpload).length > 0) {

        var i = 0;

        for (var index in attachtedEmailFilesToUpload) {

            params.append('attached_email_file_' + i, attachtedEmailFilesToUpload[index]);

            i = i + 1;

        }

    }

    params.delete('attachement');

    emailSend(postUrl, params, '#emailSendModal', '.compose_loader');

    //$('.email-send-form').submit();

});

$(document).on('click', '.email-save-btn', function(e) {

    tinymce.triggerSave(true, true);

    var type = $('.pmbottype').attr('data-pmbottype');
    $('.type').val(type);

    e.preventDefault();

    var subject = $('#subject').val();
    if (subject.trim() == '') {
        $("#subject").focus();
        return false;
    }

    $('.email-status').val('4');

    var postUrl = $('.email-send-form').attr('action');

    //var params = $('.email-send-form').serialize();

    var params = new FormData($('.email-send-form')[0]);

    // $.each($('.attachements')[0].files, function(i, file) {
    //     params.append('file-' + i, file);
    // });

    if (filesToUpload != undefined && Object.keys(filesToUpload).length > 0) {

        var i = 0;

        for (var index in filesToUpload) {

            params.append('file-' + i, filesToUpload[index]);

            i = i + 1;

        }

    }

    if (attachtedEmailFilesToUpload != undefined && Object.keys(attachtedEmailFilesToUpload).length > 0) {

        var i = 0;

        for (var index in attachtedEmailFilesToUpload) {

            params.append('attached_email_file_' + i, attachtedEmailFilesToUpload[index]);

            i = i + 1;

        }

    }

    params.delete('attachement');

    emailSend(postUrl, params, '#emailSendModal', '.compose_loader');

});
$(document).on('click', '.email-reply-send-btn', function(e) {

    tinymce.triggerSave(true, true);

    if ($('#email-reply-to').val() == '') {
        $("#email-reply-to").focus();
        return false;
    }
    if ($('#email-reply-subject').val() == '') {
        $("#email-reply-subject").focus();
        return false;
    }
    if ($('#reply_body_html').val() == '') {
        $("#reply_body_html").focus();
        return false;
    }


    var type = $('.pmbottype').attr('data-pmbottype');
    $('.type').val(type);
    $('#email-type').val(type);

    e.preventDefault();

    $('.email-status').val('5');

    var postUrl = $('.email-reply-form').attr('action');

    // var params = $('.email-reply-form').serialize();

    var params = new FormData($('.email-reply-form')[0]);

    // $.each($('.replyattachements')[0].files, function(i, file) {
    //     params.append('file-' + i, file);
    // });

    if (filesToUpload != undefined && Object.keys(filesToUpload).length > 0) {

        var i = 0;

        for (var index in filesToUpload) {

            params.append('file-' + i, filesToUpload[index]);

            i = i + 1;

        }

    }

    params.delete('attachement');

    emailSend(postUrl, params, '#replymailModal', '.reply_loader');

});

$(document).on('click', '.email-reply-save-btn', function(e) {

    tinymce.triggerSave(true, true);

    var type = $('.pmbottype').attr('data-pmbottype');
    $('.type').val(type);
    $('#email-type').val(type);

    e.preventDefault();

    var subject = $('#email-reply-subject').val();
    if (subject.trim() == '') {
        $("#email-reply-subject").focus();
        return false;
    }

    $('.email-status').val('4');

    var postUrl = $('.email-reply-form').attr('action');

    //var params = $('.email-reply-form').serialize();

    var params = new FormData($('.email-reply-form')[0]);

    // $.each($('.replyattachements')[0].files, function(i, file) {
    //     params.append('file-' + i, file);
    // });

    if (filesToUpload != undefined && Object.keys(filesToUpload).length > 0) {

        var i = 0;

        for (var index in filesToUpload) {

            params.append('file-' + i, filesToUpload[index]);

            i = i + 1;

        }

    }

    params.delete('attachement');

    emailSend(postUrl, params, '#replymailModal', '.reply_loader');

});

$(document).on('click', '.email-draft-send-btn', function(e) {

    tinymce.triggerSave(true, true);

    var type = $('.pmbottype').attr('data-pmbottype');
    $('.type').val(type);
    $('#email-type').val(type);

    e.preventDefault();

    $('.email-status').val('5');

    var postUrl = $('.email-draft-form').attr('action');

    var params = new FormData($('.email-draft-form')[0]);

    // $.each($('.draftattachements')[0].files, function(i, file) {
    //     params.append('file-' + i, file);
    // });

    if (filesToUpload != undefined && Object.keys(filesToUpload).length > 0) {

        var i = 0;

        for (var index in filesToUpload) {

            params.append('file-' + i, filesToUpload[index]);

            i = i + 1;

        }

    }

    params.delete('attachement');

    emailSend(postUrl, params, '#draftymailModal', '.draft_loader');

});

$(document).on('click', '.email-draft-save-btn', function(e) {

    tinymce.triggerSave(true, true);

    var type = $('.pmbottype').attr('data-pmbottype');
    $('.type').val(type);
    $('#email-type').val(type);

    e.preventDefault();

    var subject = $('#email-draft-subject').val();
    if (subject.trim() == '') {
        $("#email-draft-subject").focus();
        return false;
    }

    $('.email-status').val('4');

    var postUrl = $('.email-draft-form').attr('action');

    var params = new FormData($('.email-draft-form')[0]);

    // $.each($('.draftattachements')[0].files, function(i, file) {
    //     params.append('file-' + i, file);
    // });

    if (filesToUpload != undefined && Object.keys(filesToUpload).length > 0) {

        var i = 0;

        for (var index in filesToUpload) {

            params.append('file-' + i, filesToUpload[index]);

            i = i + 1;

        }

    }

    params.delete('attachement');

    emailSend(postUrl, params, '#draftymailModal', '.draft_loader');

});

function validateEmail($email) {

    var returnData = {};

    var emailMatch = $email.match(/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/gi);

    if (emailMatch != undefined && emailMatch.length > 0 && emailMatch.length == 1) {

        $email = emailMatch[0];

    }

    if (emailMatch != undefined && emailMatch.length > 1) {

        return false;

    }

    var emailReg = /^([\w-\.\_]+@([\w-]+\.)+[\w-]{2,6})?$/;

    var externalEmailReg = /^[\w\.\_]+@(spi\-global\.com)?$/;

    returnData.valid = ($email.trim().length > 0 && emailReg.test($email.trim()));

    returnData.external = ($email.trim().length > 0 && externalEmailReg.test($email.trim()));

    return returnData;

    // return ($email.trim().length > 0 && emailReg.test($email.trim()));

}

function emailSend(sendUrl, params, closeBtnSelector, loader) {

    if (sendUrl != undefined && sendUrl != '') {

        var validEmailTo = validEmailCC = validEmailBCC = 'true';

        var externalEmail = 'false';

        if (params.get('to') != undefined && params.get('to') != '') {

            var emailArray = '';

            emailArray = params.get('to').split(';');

            $.each(emailArray, function(index, value) {

                if (value != '' && value.trim().length > 0) {

                    var emailValidationData = validateEmail(value);

                    if ('valid' in emailValidationData && emailValidationData.valid != undefined && !emailValidationData.valid) {

                        validEmailTo = 'false';

                        return false;

                    }

                    if (externalEmail == 'false' && 'external' in emailValidationData && emailValidationData.external != undefined && !emailValidationData.external) {

                        externalEmail = 'true';

                    }

                    // if (!validateEmail(value)) {

                    //     validEmailTo = 'false';

                    //     return false;

                    // }

                }

            });

        }

        if (params.get('cc') != undefined && params.get('cc') != '') {

            var emailArray = '';

            emailArray = params.get('cc').split(';');

            $.each(emailArray, function(index, value) {

                if (value != '' && value.trim().length > 0) {

                    var emailValidationData = validateEmail(value);

                    if ('valid' in emailValidationData && emailValidationData.valid != undefined && !emailValidationData.valid) {

                        validEmailTo = 'false';

                        return false;

                    }

                    if (externalEmail == 'false' && 'external' in emailValidationData && emailValidationData.external != undefined && !emailValidationData.external) {

                        externalEmail = 'true';

                    }

                    // if (!validateEmail(value)) {

                    //     validEmailCC = 'false';

                    //     return false;

                    // }

                }

            });

        }

        if (params.get('bcc') != undefined && params.get('bcc') != '') {

            var emailArray = '';

            emailArray = params.get('bcc').split(';');

            $.each(emailArray, function(index, value) {

                if (value != '' && value.trim().length > 0) {

                    var emailValidationData = validateEmail(value);

                    if ('valid' in emailValidationData && emailValidationData.valid != undefined && !emailValidationData.valid) {

                        validEmailTo = 'false';

                        return false;

                    }

                    if (externalEmail == 'false' && 'external' in emailValidationData && emailValidationData.external != undefined && !emailValidationData.external) {

                        externalEmail = 'true';

                    }

                    // if (!validateEmail(value)) {

                    //     validEmailBCC = 'false';

                    //     return false;

                    // }

                }

            });

        }

        if (validEmailTo == 'false') {

            Swal.fire({

                title: '',
                text: "Invalid to address!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            $('#to').focus();

            return false;

        }

        if (validEmailCC == 'false') {

            Swal.fire({

                title: '',
                text: "Invalid cc address!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            $('#cc').focus();

            return false;

        }

        if (validEmailBCC == 'false') {

            Swal.fire({

                title: '',
                text: "Invalid bcc address!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            $('#bcc').focus();

            return false;

        }

        if (externalEmail == 'true') {

            params.append('external_email', 'external');

        }

        if (params.get('body_html') != undefined && params.get('body_html') != '') {

            var email_data_html = $('<div/>').html(params.get('body_html')).contents();

            var email_template_variables = $('.email-template').attr('data-email-template-variables');

            if (email_template_variables != undefined && email_template_variables != '') {

                email_template_variables = JSON.parse(email_template_variables);

                if (Object.keys(email_template_variables).length > 0) {

                    for (const variable in email_template_variables) {

                        var validation_element = email_data_html.find('.' + variable);

                        if (validation_element != undefined && validation_element != '') {

                            if (variable in email_template_variables && email_template_variables[variable] != undefined && email_template_variables[variable] != '') {

                                var validation_text = '';

                                validation_text = validation_element.text();

                                if (variable == 'pm_signature') {

                                    validation_text = validation_element.find('span').text();

                                }

                                if (validation_text == email_template_variables[variable]) {

                                    Swal.fire({
                                        title: '',
                                        text: 'Invalid ' + email_template_variables[variable] + '!',
                                        showClass: {
                                            popup: 'animated fadeIn faster'
                                        },
                                        hideClass: {
                                            popup: 'animated fadeOut faster'
                                        },

                                    });

                                    return false;

                                }

                            }

                        }

                    }

                }

            }

        }


        /* AJAX call to email item info */

        var d = $.Deferred();
        $.ajax({
            url: sendUrl,
            data: params,
            dataType: 'json',
            type: 'POST',
            processData: false,
            contentType: false,
            enctype: "multipart/form-data",
            beforeSend: function() {
                $(loader).show();
            },
            complete: function() {

                emailSentCount();

                $('.sent-email-modal').modal('hide');

                $(loader).hide();

            }
        }).done(function(response) {

            if (response.success == "true") {

                type = 'success';

                if (closeBtnSelector == '#emailSendModal') {
                    $('#to').val('');
                    $('#cc').val('');
                    $('#subject').val('');
                    $('#body_html').val('');

                    // tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, '');
                    // tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, '');

                    tinymce.get('textarea_editor_email_compose').setContent('');
                    tinymce.get('textarea_editor_email_reply').setContent('');

                    // $('#textarea_editor_email_compose').html('');
                    // $('#textarea_editor_email_reply').html('');
                    $('.textarea_editor_email').html('');

                    // $('.compose_message').summernote('code', '');

                    // var activeEditor = tinymce.activeEditor;

                    // var content = '';

                    // if (activeEditor !== null) {

                    //     activeEditor.setContent(content);

                    // } else {

                    //     $('.compose_message').val(content);
                    // }

                }
                $(loader).hide();
                $(closeBtnSelector).modal('hide');

            } else {

                type = 'error';

                d.resolve();

                /* if (closeBtnSelector == '#emailSendModal') {
                    $('#to').val('');
                    $('#cc').val('');
                    $('#subject').val('');
                    $('#body_html').val('');
                    tinymce.get('textarea_editor_email_compose').setContent('');
                    tinymce.get('textarea_editor_email_reply').setContent('');
                    $('.textarea_editor_email').html('');
                }
                $(loader).hide(); */
                // $(closeBtnSelector).modal('hide');

            }

            message = response.message;

            flashMessage(type, message);

            if (response.redirectUrl != undefined && response.redirectUrl != '') {

                window.location = response.redirectUrl;

            }

        });

        if (params.get('email_type') != undefined && params.get('email_type') != '') {

            var typeSelector = '';
            var btnSelector = '';

            if (params.get('type') != undefined && params.get('type') != '') {

                if (params.get('type') == 'non_pmbot') {

                    typeSelector = 'dashboard';

                }

                if (params.get('type') == 'pmbot') {

                    typeSelector = 'job';

                }

                btnSelector = '.' + typeSelector + '-' + params.get('email_type') + '-email';

                $(btnSelector).trigger('click');

            }

        }

        //$(closeBtnSelector).trigger('click');
        return d.promise();


    }
}
$(document).on('click', '.email-reply-btn', function(e) {
    e.preventDefault();
    $('.attachements').val('');
    var type = $(this).attr('data-type');
    var selector = $(this);
    $('.reply_email_type').val('reply');
    $('.signature_change').val('');
    $(".reply_to ul").empty();
    $('.email-reply-to').val('');
    $('.email-reply-cc').val('');
    $('.email-reply-bcc').val('');
    $('.email-reply-form #start_time').val(moment().format('YYYY-MM-DD HH:mm:ss'));
    $('.email-template').select2().val('').trigger('change');
    showform(type, selector);
});
$(document).on('click', '.email-reply-all-btn', function(e) {
    e.preventDefault();
    $('.attachements').val('');
    var type = $(this).attr('data-type');
    var selector = $(this);
    $('.reply_email_type').val('reply');
    $('.signature_change').val('');
    $(".reply_to ul").empty();
    $('.email-reply-to').val('');
    $('.email-reply-cc').val('');
    $('.email-reply-bcc').val('');
    $('.email-reply-form #start_time').val(moment().format('YYYY-MM-DD HH:mm:ss'));
    showform(type, selector);
});
$(document).on('click', '.email-forward-btn', function(e) {
    e.preventDefault();
    $('.attachements').val('');
    var type = $(this).attr('data-type');
    var selector = $(this);
    $('.reply_email_type').val('forward');
    $('.signature_change').val('');
    $(".reply_to ul").empty();
    $('.email-reply-to').val('');
    $('.email-reply-cc').val('');
    $('.email-reply-bcc').val('');
    $('.email-reply-form #start_time').val(moment().format('YYYY-MM-DD HH:mm:ss'));
    showform(type, selector);
});
$(document).on('click', '.email-draft-btn', function(e) {
    e.preventDefault();
    $('.draftattachements').val('');
    var type = $(this).attr('data-type');
    var selector = $(this);
    $('.draft_email_type').val('draft');
    $(".draft_to ul").empty();
    $(".draft_cc ul").empty();

    $(".email-draft-to").val('');
    $(".email-draft-cc").val('');

    $('.email-draft-form #start_time').val(moment().format('YYYY-MM-DD HH:mm:ss'));

    $('.email-template').select2().val('').trigger('change');

    showdraftform(type, selector);
});
/*
function showform(type, selector) {
    var emailPostData = {};
    var emailid = $('.email-title').attr('data-email-id');
    var postUrl = $(selector).attr('data-email-geturl');
    emailPostData.emailid = emailid;

    $.ajax({

        url: postUrl,
        data: emailPostData,
        dataType: 'json',
        type: 'POST',

    }).done(function(response) {
        if (response.success == "true") {
            if (response.data != undefined && response.data != '') {
                if (type == "reply" || type == "replyall") {
                    $('.email-reply-to').val(response.data.email_from);
                } else {
                    $('.email-reply-to').val('');
                }
                if (type == 'replyall') {
                    $('.email-reply-cc').val(response.data.email_cc);
                } else {
                    $('.email-reply-cc').val('');
                }
                $('.email-reply-subject').val(atob(response.data.subject));
                $('.email-reply-body_html').summernote('code', atob(response.data.body_html));
                $('.email_messageid').val(response.data.email_messageid);
                //$('.email-reply-to').val('teest');
            }
            $('.email-reply-modal').modal({
                show: 'false'
            });
            //$('.email-reply-modal').show();


        } else {

            Swal.fire({

                title: '',
                text: "Email Data Not Found!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }
    });
}
 */

function showform(type, selector) {
    var emailPostData = {};
    filesToUpload = [];
    $('.attached_file').html('');
    var emailid = $('.email-title').attr('data-email-id');
    var postUrl = $(selector).attr('data-email-geturl');

    var editor_type = 'reply';

    $('.email-reply-body_html').attr('id', 'textarea_editor_email_reply');

    if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

        // tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, '');

        tinymce.get('textarea_editor_email_reply').setContent('');

        // tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, emailEditorParaTag);

    }

    emailPostData.emailid = emailid;
    if (type == 'replyall') {
        $('.modeltitle').html('Reply All');
    } else {
        $('.modeltitle').html(type);
    }

    $.ajax({

        url: postUrl,
        data: emailPostData,
        dataType: 'json',
        type: 'POST',
        beforeSend: function() {
            $('.reply_loader').show();
        },
        complete: function() {
            $('.reply_loader').hide();
        }
    }).done(function(response) {

        if (response.success == "true") {
            if (response.data != undefined && response.data != '') {
                var str2 = '';

                if (type == "reply" || type == "replyall") {
                    if (response.data.email_from != '' && response.data.email_from != null) {
                        var to = response.data.email_from.replace(/&quot;/g, "");
                        to = to.replace(/&quot;/g, "");
                        to = to.replace(/&lt;/g, "<");
                        to = to.replace(/&gt;/g, ">");
                        $('.email-reply-to').val(to + ';');

                    }
                    str2 = 'RE: ';
                } else {
                    $('.email-reply-to').val('');
                    str2 = 'FW: ';
                }
                if (type == 'replyall') {
                    if (response.data.email_reply_cc != '' && response.data.email_reply_cc != null) {
                        var cc = response.data.email_reply_cc.replace(/&quot;/g, "");
                        cc = cc.replace(/&quot;/g, "")
                        cc = cc.replace(/&lt;/g, "<");
                        cc = cc.replace(/&gt;/g, ">");

                        //$('.email-reply-cc').val(cc + ';');
                        $('.email-reply-cc').val(cc);
                    }
                    if (response.data.email_to != '' && response.data.email_to != null) {
                        var replyallto = response.data.email_to.replace(/&quot;/g, "");
                        replyallto = replyallto.replace(/&quot;/g, "")
                        replyallto = replyallto.replace(/&lt;/g, "<");
                        replyallto = replyallto.replace(/&gt;/g, ">");

                        var reto = $('.email-reply-to').val();

                        $('.email-reply-to').val(reto + replyallto + ';');
                    }
                    if (response.data.reply_all_to != '' && response.data.reply_all_to != null) {
                        var replyallto = response.data.reply_all_to.replace(/&quot;/g, "");
                        replyallto = replyallto.replace(/&quot;/g, "")
                        replyallto = replyallto.replace(/&lt;/g, "<");
                        replyallto = replyallto.replace(/&gt;/g, ">");

                        //var reto = $('.email-reply-to').val();

                        //$('.email-reply-to').val(reto + replyallto + ';');
                        $('.email-reply-to').val(replyallto + ';');
                    }
                    /*if (response.data.email_to != '' && response.data.email_to != null) {
						var reply_allto = response.data.email_reply_all.replace(/&quot;/g, "");
						reply_allto = reply_allto.replace(/&quot;/g, "")
						reply_allto = reply_allto.replace(/&lt;/g, "<");
						reply_allto = reply_allto.replace(/&gt;/g, ">");
                        $('.email-reply-to').val(reply_allto);
                    }*/

                } else {
                    $('.email-reply-cc').val('');
                }
                if (response.data.subject != '' && response.data.subject != null) {
                    //var subject = atob(response.data.subject);
                    var subject = response.data.subject;
                    subject = subject.replace("FW: ", "");
                    subject = subject.replace("RE: ", "");
                    subject = str2.concat(subject);
                } else {
                    var subject = '';
                }
                //var message = atob(response.data.body_html);
                var message = response.data.body_html;
                var sinmessage = '';

                if ('replyforward_signature' in response.data && response.data.replyforward_signature != '') {

                    var random = Math.random().toString(36).substring(7);
                    var sig_class = 'emailsig_block_' + random;
                    sessionStorage.setItem('signature_classname', sig_class);

                    var stamp = '<div class="emailsig_block ' + sig_class + '">' + response.data.replyforward_signature;
                    var msg = '</div>';
                    sinmessage = stamp + msg;

                }

                //var sig = response.data.replyforward_signature;
                var sentdate = '';

                if (response.data.email_received_date != null) {
                    sentdate = response.data.email_received_date;
                } else {
                    sentdate = response.data.created_date;
                }

                var stamp = sinmessage + '<div style="font-family:calibri;font-size:11pt;"><hr><b>From:</b> ' + response.data.email_from + '<br><b>Sent:</b> ' + sentdate + '<br><b>To:</b> ' + response.data.email_to + '<br><b>Subject:</b> ' + response.data.subject + '<br><br></div>';
                message = stamp.concat(message);

                $('.email-reply-subject').val(subject);

                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                    tinymce.get('textarea_editor_email_reply').setContent('');

                    tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, emailEditorParaTag + message);

                    tinymceEditorFocus('textarea_editor_email_reply');

                }
                if (type == 'forward' && response.data.email_forward_attachment_html != '' && response.data.email_forward_attachment_html != undefined) {
                    $('.attached_file_box').show();
                    $('.attached_file').html(response.data.email_forward_attachment_html);
                } else {
                    $('.attached_file').html('');
                    $('.attached_file_box').hide();
                }
                $('.email_id').val(response.data.id);

            }
            $('.email-reply-modal').modal({
                show: 'false'
            });
            //$('.email-reply-modal').show();
        } else {

            Swal.fire({

                title: '',
                text: "Email Data Not Found!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }
    });

    $('.mce-i-restoredraft').closest('div').addClass('disabled-block');

}

function showdraftform(type, selector) {
    var emailPostData = {};
    filesToUpload = [];
    $('.attached_file').html('');
    var emailid = $('.email-title').attr('data-email-id');
    var postUrl = $(selector).attr('data-email-geturl');

    if (tinymce.get('textarea_editor_email_draft') != undefined && tinymce.get('textarea_editor_email_draft') != null) {

        // tinymce.get('textarea_editor_email_draft').execCommand('mceInsertContent', false, '');
        tinymce.get('textarea_editor_email_draft').setContent('');

    }

    emailPostData.emailid = emailid;
    $('.modeltitle').html('Draft Mail');

    $.ajax({
        url: postUrl,
        data: emailPostData,
        dataType: 'json',
        type: 'POST',
        beforeSend: function() {
            $('.draft_loader').show();
        },
        complete: function() {
            $('.draft_loader').hide();
        }
    }).done(function(response) {

        if (response.success == "true") {
            if (response.data != undefined && response.data != '') {

                if (response.data.email_to != '' && response.data.email_to != null) {
                    var to = response.data.email_to.replace(/&quot;/g, "");
                    to = to.replace(/&quot;/g, "");
                    to = to.replace(/&lt;/g, "<");
                    to = to.replace(/&gt;/g, ">");
                    to = to.replace(/;/g, "");
                    $('.email-draft-to').val(to + ';');
                }
                if (response.data.email_cc != '' && response.data.email_cc != null) {
                    var cc = response.data.email_cc.replace(/&quot;/g, "");
                    cc = cc.replace(/&quot;/g, "")
                    cc = cc.replace(/&lt;/g, "<");
                    cc = cc.replace(/&gt;/g, ">");
                    cc = cc.replace(/;/g, "");
                    $('.email-draft-cc').val(cc + ';');
                }
                if (response.data.email_bcc != '' && response.data.email_bcc != null) {
                    var bcc = response.data.email_bcc.replace(/&quot;/g, "");
                    bcc = bcc.replace(/&quot;/g, "")
                    bcc = bcc.replace(/&lt;/g, "<");
                    bcc = bcc.replace(/&gt;/g, ">");
                    bcc = bcc.replace(/;/g, "");
                    $('.email-draft-bcc').val(bcc + ';');
                }
                var subject = response.data.subject;
                $('.email-draft-subject').val(subject);

                var message = response.data.body_html;

                if (tinymce.get('textarea_editor_email_draft') != undefined && tinymce.get('textarea_editor_email_draft') != null && message != null) {

                    tinymce.get('textarea_editor_email_draft').execCommand('mceInsertContent', false, message);

                    tinymceEditorFocus('textarea_editor_email_draft');

                    // $('#textarea_editor_email_draft').append(message);

                }

                if (response.data.email_forward_attachment_html != '' && response.data.email_forward_attachment_html != undefined) {
                    $('.attached_file_box').show();
                    $('.attached_file').html(response.data.email_forward_attachment_html);
                } else {
                    $('.attached_file').html('');
                    $('.attached_file_box').hide();
                }

                $('.email_id').val(response.data.id);

            }
            $('.email-draft-modal').modal({
                show: 'false'
            });
            //$('.email-draft-modal').show();

        } else {

            Swal.fire({

                title: '',
                text: "Email Data Not Found!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }
    });

    $('.mce-i-restoredraft').closest('div').addClass('disabled-block');

}

function listFocus(selector, event) {

    var key = event.which;

    if (key == 13) {

        if ($(selector + ' li.active') != undefined && $(selector + ' li.active').length != 0) {

            $(selector + ' li.active').trigger('click');

            return true;

        }

    }

    if (key == 38 || key == 40) {

        var storeTarget = "";

        if (key == 38) {

            if ($(selector + ' li.active').length != 0) {

                storeTarget = $(selector).find('li.active').prev();

                if (storeTarget.length == 0) {

                    storeTarget = $(selector).find('li:last');

                }

                $(selector + ' li.active').removeAttr('tabIndex');
                $(selector + ' li.active').removeClass('active email-autocomplete-list-style');
                storeTarget.focus().addClass('active email-autocomplete-list-style');
                storeTarget.focus().attr('tabIndex', '-1');
                $(selector).scrollTop(storeTarget.position().top - $(selector + ' li:first').position().top);

            } else {

                $(selector).find('li:first').focus().addClass('active email-autocomplete-list-style');
                $(selector).find('li:first').focus().attr('tabIndex', '-1');

            }

            return true;

        }

        if (key == 40) {

            if ($(selector + ' li.active').length != 0) {

                storeTarget = $(selector).find('li.active').next();

                if (storeTarget.length == 0) {

                    storeTarget = $(selector).find('li:first');

                }

                $(selector + ' li.active').removeAttr('tabIndex');
                $(selector + ' li.active').removeClass('active email-autocomplete-list-style');

                storeTarget.focus().addClass('active email-autocomplete-list-style');
                storeTarget.focus().attr('tabIndex', '-1');

                $(selector).scrollTop(storeTarget.position().top - $(selector + ' li:first').position().top);


            } else {

                $(selector).find('li:first').focus().addClass('active email-autocomplete-list-style');
                $(selector).find('li:first').focus().attr('tabIndex', '-1');

            }

            return true;

        }

    }

}

$(document).ready(function(e) {

    $("#to").keyup(function(e) {

        if (listFocus('.compose_to ul', e)) {

            return;

        }

        var search = $(this).val();

        var temp = new Array();
        temp = search.split(";");
        if (temp.length == '1') {
            $('#composeto_value').val('');
        }
        var postUrl = $('#getemailidURL').val();

        if (search != "") {
            $.ajax({
                url: postUrl,
                type: 'post',
                data: { search: search },
                dataType: 'json',
                success: function(response) {
                    var len = response.data.length;
                    $(".compose_to ul").empty();
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            // $(".compose_to ul").append("<li class='compose_emaillist' value='" + atob(response.data[i].email_from) + "'>" + atob(response.data[i].email_from) + "</li>");

                            if (response.data[i].name != '') {
                                var name = response.data[i].name + ',';
                            } else {
                                var name = '';
                            }
                            $(".compose_to ul").append("<li class='compose_emaillist' value='" + response.data[i].email_from + "'>" + name + response.data[i].email_from + "</li>");
                        }
                    } else {
                        $(".compose_to ul").empty();
                    }
                }
            });
        } else {
            $(".compose_to ul").empty();
        }

    });
    $("#cc").keyup(function(e) {

        if (listFocus('.compose_cc ul', e)) {

            return;

        }

        var search = $(this).val();

        var temp = new Array();
        temp = search.split(";");
        if (temp.length == '1') {
            $('#composecc_value').val('');
        }
        var postUrl = $('#getemailidURL').val();

        if (search != "") {
            $.ajax({
                url: postUrl,
                type: 'post',
                data: { search: search },
                dataType: 'json',
                success: function(response) {
                    var len = response.data.length;
                    $(".compose_cc ul").empty();
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            if (response.data[i].name != '') {
                                var name = response.data[i].name + ',';
                            } else {
                                var name = '';
                            }
                            $(".compose_cc ul").append("<li class='composecc_emaillist' value='" + response.data[i].email_from + "'>" + name + response.data[i].email_from + "</li>");
                        }
                    } else {
                        $(".compose_cc ul").empty();
                    }
                }
            });
        } else {
            $(".compose_cc ul").empty();
        }
    });
    $("#bcc").keyup(function(e) {

        if (listFocus('.compose_bcc ul', e)) {

            return;

        }

        var search = $(this).val();

        var temp = new Array();
        temp = search.split(";");
        if (temp.length == '1') {
            $('#composebcc_value').val('');
        }
        var postUrl = $('#getemailidURL').val();

        if (search != "") {
            $.ajax({
                url: postUrl,
                type: 'post',
                data: { search: search },
                dataType: 'json',
                success: function(response) {
                    var len = response.data.length;
                    $(".compose_cc ul").empty();
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            if (response.data[i].name != '') {
                                var name = response.data[i].name + ',';
                            } else {
                                var name = '';
                            }
                            $(".compose_bcc ul").append("<li class='composebcc_emaillist' value='" + response.data[i].email_from + "'>" + name + response.data[i].email_from + "</li>");
                        }
                    } else {
                        $(".compose_bcc ul").empty();
                    }
                }
            });
        } else {
            $(".compose_bcc ul").empty();
        }
    });
    $("#email-reply-to").keyup(function(e) {

        if (listFocus('.reply_to ul', e)) {

            return;

        }

        var search = $(this).val();

        var temp = new Array();
        temp = search.split(";");
        if (temp.length == '1') {
            $('#replyto_value').val('');
        }

        var postUrl = $('#getemailidURL').val();

        if (search != "") {
            $.ajax({
                url: postUrl,
                type: 'post',
                data: { search: search },
                dataType: 'json',
                success: function(response) {
                    var len = response.data.length;
                    $(".reply_to ul").empty();
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            if (response.data[i].name != '') {
                                var name = response.data[i].name + ',';
                            } else {
                                var name = '';
                            }
                            $(".reply_to ul").append("<li class='replyto_emaillist' value='" + response.data[i].email_from + "'>" + name + response.data[i].email_from + "</li>");
                        }
                    } else {
                        $(".reply_to ul").empty();
                    }
                }
            });
        } else {
            $(".reply_to ul").empty();
        }
    });
    $("#email-reply-cc").keyup(function(e) {

        if (listFocus('.reply_cc ul', e)) {

            return;

        }

        var search = $(this).val();

        var temp = new Array();
        temp = search.split(";");
        if (temp.length == '1') {
            $('#replycc_value').val('');
        }

        var postUrl = $('#getemailidURL').val();

        if (search != "") {
            $.ajax({
                url: postUrl,
                type: 'post',
                data: { search: search },
                dataType: 'json',
                success: function(response) {
                    var len = response.data.length;
                    $(".reply_cc ul").empty();
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            if (response.data[i].name != '') {
                                var name = response.data[i].name + ',';
                            } else {
                                var name = '';
                            }
                            $(".reply_cc ul").append("<li class='replycc_emaillist' value='" + response.data[i].email_from + "'>" + name + response.data[i].email_from + "</li>");
                        }
                    } else {
                        $(".reply_cc ul").empty();
                    }
                }
            });
        } else {
            $(".reply_cc ul").empty();
        }
    });
    $("#email-reply-bcc").keyup(function(e) {

        if (listFocus('.reply_bcc ul', e)) {

            return;

        }

        var search = $(this).val();

        var temp = new Array();
        temp = search.split(";");
        if (temp.length == '1') {
            $('#replybcc_value').val('');
        }

        var postUrl = $('#getemailidURL').val();

        if (search != "") {
            $.ajax({
                url: postUrl,
                type: 'post',
                data: { search: search },
                dataType: 'json',
                success: function(response) {
                    var len = response.data.length;
                    $(".reply_cc ul").empty();
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            if (response.data[i].name != '') {
                                var name = response.data[i].name + ',';
                            } else {
                                var name = '';
                            }
                            $(".reply_bcc ul").append("<li class='replybcc_emaillist' value='" + response.data[i].email_from + "'>" + name + response.data[i].email_from + "</li>");
                        }
                    } else {
                        $(".reply_bcc ul").empty();
                    }
                }
            });
        } else {
            $(".reply_bcc ul").empty();
        }
    });
    $("#email-draft-to").keyup(function(e) {

        if (listFocus('.draft_to ul', e)) {

            return;

        }

        var search = $(this).val();

        var temp = new Array();
        temp = search.split(";");
        if (temp.length == '1') {
            $('#draftto_value').val('');
        }

        var postUrl = $('#getemailidURL').val();

        if (search != "") {
            $.ajax({
                url: postUrl,
                type: 'post',
                data: { search: search },
                dataType: 'json',
                success: function(response) {
                    var len = response.data.length;
                    $(".draft_to ul").empty();
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            if (response.data[i].name != '') {
                                var name = response.data[i].name + ',';
                            } else {
                                var name = '';
                            }
                            $(".draft_to ul").append("<li class='draftto_emaillist' value='" + response.data[i].email_from + "'>" + name + response.data[i].email_from + "</li>");
                        }
                    } else {
                        $(".draft_to ul").empty();
                    }
                }
            });
        } else {
            $(".draft_to ul").empty();
        }
    });
    $("#email-draft-cc").keyup(function(e) {

        if (listFocus('.draft_cc ul', e)) {

            return;

        }

        var search = $(this).val();

        var temp = new Array();
        temp = search.split(";");
        if (temp.length == '1') {
            $('#draftcc_value').val('');
        }

        var postUrl = $('#getemailidURL').val();

        if (search != "") {
            $.ajax({
                url: postUrl,
                type: 'post',
                data: { search: search },
                dataType: 'json',
                success: function(response) {
                    var len = response.data.length;
                    $(".draft_cc ul").empty();
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            if (response.data[i].name != '') {
                                var name = response.data[i].name + ',';
                            } else {
                                var name = '';
                            }
                            $(".draft_cc ul").append("<li class='draftcc_emaillist' value='" + response.data[i].email_from + "'>" + name + response.data[i].email_from + "</li>");
                        }
                    } else {
                        $(".draft_cc ul").empty();
                    }
                }
            });
        } else {
            $(".draft_cc ul").empty();
        }
    });
    $("#email-draft-bcc").keyup(function(e) {

        if (listFocus('.draft_bcc ul', e)) {

            return;

        }

        var search = $(this).val();

        var temp = new Array();
        temp = search.split(";");
        if (temp.length == '1') {
            $('#draftbcc_value').val('');
        }

        var postUrl = $('#getemailidURL').val();

        if (search != "") {
            $.ajax({
                url: postUrl,
                type: 'post',
                data: { search: search },
                dataType: 'json',
                success: function(response) {
                    var len = response.data.length;
                    $(".draft_bcc ul").empty();
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            if (response.data[i].name != '') {
                                var name = response.data[i].name + ',';
                            } else {
                                var name = '';
                            }
                            $(".draft_bcc ul").append("<li class='draftbcc_emaillist' value='" + response.data[i].email_from + "'>" + name + response.data[i].email_from + "</li>");
                        }
                    } else {
                        $(".draft_bcc ul").empty();
                    }
                }
            });
        } else {
            $(".draft_bcc ul").empty();
        }
    });
});

$(document).on('click', '.compose_emaillist', function(e) {
    var value = $(this).attr('value');
    var tovalue = $('#composeto_value').val();
    value = value.replace(/"/g, "");
    $('#composeto_value').val(tovalue + value + ';');
    $('.composeto').val(tovalue + value + ';');
    $(".compose_to ul").empty();
});

$(document).on('click', '.composecc_emaillist', function(e) {
    var value = $(this).attr('value');
    var ccvalue = $('#composecc_value').val();
    value = value.replace(/"/g, "");
    $('#composecc_value').val(ccvalue + value + ';');
    $('.composecc').val(ccvalue + value + ';');
    $(".compose_cc ul").empty();
});
$(document).on('click', '.composebcc_emaillist', function(e) {
    var value = $(this).attr('value');
    var bccvalue = $('#composebcc_value').val();
    value = value.replace(/"/g, "");
    $('#composebcc_value').val(bccvalue + value + ';');
    $('.composebcc').val(bccvalue + value + ';');
    $(".compose_bcc ul").empty();
});
$(document).on('click', '.replyto_emaillist', function(e) {
    var value = $(this).attr('value');
    var tovalue = $('#replyto_value').val();
    value = value.replace(/"/g, "");
    $('#replyto_value').val(tovalue + value + ';');
    $('.email-reply-to').val(tovalue + value + ';');
    $(".reply_to ul").empty();
});
$(document).on('click', '.replycc_emaillist', function(e) {
    var value = $(this).attr('value');
    var reccvalue = $('#replycc_value').val();
    value = value.replace(/"/g, "");
    $('#replycc_value').val(reccvalue + value + ';');
    $('.email-reply-cc').val(reccvalue + value + ';');
    $(".reply_cc ul").empty();
});
$(document).on('click', '.replybcc_emaillist', function(e) {
    var value = $(this).attr('value');
    var rebccvalue = $('#replybcc_value').val();
    value = value.replace(/"/g, "");
    $('#replybcc_value').val(rebccvalue + value + ';');
    $('.email-reply-bcc').val(rebccvalue + value + ';');
    $(".reply_bcc ul").empty();
});
$(document).on('click', '.draftto_emaillist', function(e) {
    var value = $(this).attr('value');
    var reccvalue = $('#draftto_value').val();
    value = value.replace(/"/g, "");
    $('#draftto_value').val(reccvalue + value + ';');
    $('.email-draft-to').val(reccvalue + value + ';');
    $(".draft_to ul").empty();
});
$(document).on('click', '.draftcc_emaillist', function(e) {
    var value = $(this).attr('value');
    var reccvalue = $('#draftcc_value').val();
    value = value.replace(/"/g, "");
    $('#draftcc_value').val(reccvalue + value + ';');
    $('.email-draft-cc').val(reccvalue + value + ';');
    $(".draft_cc ul").empty();
});
$(document).on('click', '.draftbcc_emaillist', function(e) {
    var value = $(this).attr('value');
    var rebccvalue = $('#draftbcc_value').val();
    value = value.replace(/"/g, "");
    $('#draftbcc_value').val(rebccvalue + value + ';');
    $('.email-draft-bcc').val(rebccvalue + value + ';');
    $(".draft_bcc ul").empty();
});
$(document).on('click', '.email-compose-btn', function(e) {
    $('#to').val('');
    $('#cc').val('');
    $('#subject').val('');
    $('.email_id').val('');
    $('.email-template').select2().val('').trigger('change');
    attachtedEmailFilesToUpload = [];
    $('.email-send-form #start_time').val(moment().format('YYYY-MM-DD HH:mm:ss'));
    $('#textarea_editor_email_compose').val('');

    if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

        tinymce.get('textarea_editor_email_compose').setContent('');

        tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, emailEditorParaTag);

    }

    filesToUpload = [];
    $('.attached_file').html('');

    $('#composeto_value').val('');
    $('.attachements').val('');
    $('.signature_change').val('new_signature');
    $(".compose_to ul").empty();
    var emailPostData = {};
    var selector = '.signature';
    var postUrl = $(selector).attr('data-signature-geturl');

    $.ajax({

        url: postUrl,
        data: emailPostData,
        dataType: 'json',
        type: 'POST',
        beforeSend: function() {
            $('.compose_loader').show();
        },
        complete: function() {
            $('.compose_loader').hide();
        }
    }).done(function(response) {

        if (response.success == "true") {
            if (response.data != undefined && typeof response.data == 'object' && 'new_signature' in response.data && response.data.new_signature != '') {
                var random = Math.random().toString(36).substring(7);
                var sig_class = 'emailsig_block_' + random;
                //$.session.set('signature_classname', 'test');
                sessionStorage.setItem('signature_classname', sig_class);

                var message = response.data.new_signature;
                var stamp = '<div class="emailsig_block ' + sig_class + '">';
                message = stamp.concat(message);
                var msg = '</div>';
                message = msg.concat(message);

                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                    // tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, emailEditorParaTag + message);
                    tinymce.get('textarea_editor_email_compose').setContent(emailEditorParaTag + message);

                }

            }
        } else {

            Swal.fire({

                title: '',
                text: "Signature Data Not Found!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }
    });

    $('.mce-i-restoredraft').closest('div').addClass('disabled-block');

});

$('.nonBusinessEmails .email-inbox-nav').slimscroll({
    height: '520px',
    alwaysVisible: 'true',
});

$('.nonBusinessEmailGrid .jsgrid-grid-body').slimscroll({
    height: '520px',
    alwaysVisible: 'true',
});

$('.myEmailGrid .jsgrid-grid-body').slimscroll({
    height: '350px',
    alwaysVisible: 'true',
});

$('.pmsEmailCountGrid .jsgrid-grid-body').slimscroll({
    height: '520px',
    alwaysVisible: 'true',
});
$(document).on("click", function(event) {
    var $composeto = $(".composetolist");
    var $composecc = $(".composecclist");
    var $composebcc = $(".composebcclist");
    var $replyeto = $(".replytolist");
    var $replycc = $(".replycclist");
    var $replybcc = $(".replybcclist");
    var $draftto = $(".drafttolist");
    var $draftcc = $(".draftcclist");
    var $draftbcc = $(".draftbcclist");


    if ($composeto !== event.target && !$composeto.has(event.target).length) {
        $(".composetolist").empty();
    }
    if ($composecc !== event.target && !$composecc.has(event.target).length) {
        $(".composecclist").empty();
    }
    if ($composebcc !== event.target && !$composebcc.has(event.target).length) {
        $(".composebcclist").empty();
    }
    if ($replyeto !== event.target && !$replyeto.has(event.target).length) {
        $(".replytolist").empty();
    }
    if ($replycc !== event.target && !$replycc.has(event.target).length) {
        $(".replycclist").empty();
    }
    if ($replybcc !== event.target && !$replybcc.has(event.target).length) {
        $(".replybcclist").empty();
    }
    if ($draftto !== event.target && !$draftto.has(event.target).length) {
        $(".drafttolist").empty();
    }
    if ($draftcc !== event.target && !$draftcc.has(event.target).length) {
        $(".draftcclist").empty();
    }
    if ($draftbcc !== event.target && !$draftbcc.has(event.target).length) {
        $(".draftbcclist").empty();
    }
});

$(document).on('click', '.signature', function(e) {
    e.preventDefault();
    showsignatureform();
});

$(document).on('click', '.signature-save', function(e) {

    tinymce.triggerSave(true, true);

    e.preventDefault();

    var postUrl = $('.signature-form').attr('action');

    var params = new FormData($('.signature-form')[0]);
    // var params = {};

    // if (tinymce.get('textarea_editor_email_new_signature') != undefined && tinymce.get('textarea_editor_email_new_signature') != null) {

    //     params.new_signature = tinymce.get('textarea_editor_email_new_signature').getContent({ format: 'html' });
    //     // params.new_signature = tinymce.get('textarea_editor_email_new_signature').getContent();

    // }

    // if (tinymce.get('textarea_editor_email_replyforward_signature') != undefined && tinymce.get('textarea_editor_email_replyforward_signature') != null) {


    //     params.replyforward_signature = tinymce.get('textarea_editor_email_replyforward_signature').getContent({ format: 'html' });
    //     // params.replyforward_signature = tinymce.get('textarea_editor_email_replyforward_signature').getContent();

    // }

    signature(postUrl, params, '#signatureModal');

});

$(document).on('click', '.signature-cancel', function(e) {
    $('#signatureModal').modal('hide');

});

function signature(sendUrl, params, closeBtnSelector) {

    // params.new_signature = 'test';
    // params.replyforward_signature = 'testfgdhfd';

    // var new_signature = { 'test': 'test' };


    if (sendUrl != undefined && sendUrl != '') {

        /* AJAX call to email item info */

        var d = $.Deferred();

        $.ajax({
            url: sendUrl,
            data: params,
            dataType: 'json',
            type: 'POST',
            processData: false,
            contentType: false,
            enctype: "multipart/form-data",
        }).done(function(response) {

            if (response.success == "true") {

                type = 'success';

            } else {

                type = 'error';

                d.resolve();

            }

            message = response.message;

            flashMessage(type, message);

        });
        $(closeBtnSelector).modal('hide');
        return d.promise();


    }
}

function showsignatureform() {
    var emailPostData = {};

    if (tinymce.get('textarea_editor_email_new_signature') != undefined && tinymce.get('textarea_editor_email_new_signature') != null) {

        // tinymce.get('textarea_editor_email_new_signature').execCommand('mceInsertContent', false, '');
        tinymce.get('textarea_editor_email_new_signature').setContent('');


    }

    if (tinymce.get('textarea_editor_email_replyforward_signature') != undefined && tinymce.get('textarea_editor_email_replyforward_signature') != null) {

        // tinymce.get('textarea_editor_email_replyforward_signature').execCommand('mceInsertContent', false, '');
        tinymce.get('textarea_editor_email_replyforward_signature').setContent('');

    }

    //var postUrl = 'get-signature';
    var selector = '.signature';
    var postUrl = $(selector).attr('data-signature-geturl');
    $.ajax({

        url: postUrl,
        data: emailPostData,
        dataType: 'json',
        type: 'POST',

    }).done(function(response) {

        if (response.success == "true") {
            if (response.data != undefined && typeof response.data == 'object') {


                var str2 = '';

                if ('new_signature' in response.data && response.data.new_signature != '') {

                    var message = response.data.new_signature;

                    if (tinymce.get('textarea_editor_email_new_signature') != undefined && tinymce.get('textarea_editor_email_new_signature') != null) {

                        tinymce.get('textarea_editor_email_new_signature').execCommand('mceInsertContent', false, message);

                        // tinymce.get('textarea_editor_email_new_signature').setContent(message, { format: 'html' });

                        // $('#textarea_editor_email_new_signature').append(message);

                    }

                } else {

                    tinymce.get('textarea_editor_email_new_signature').execCommand('mceInsertContent', false, emailSignatureEditorParaTag);

                    // tinymce.get('textarea_editor_email_new_signature').setContent('<p style="margin: 0in; margin-bottom: .0001pt; font-size: 10.0pt; font-family: Arial;"><br></p>', { format: 'html' });

                }

                // tinymce.get("new_signature").setContent(message);

                // $('.new_signature').summernote('code', message);

                // var activeEditor = tinymce.activeEditor;

                // var content = message;

                // if (activeEditor !== null && content != '') {

                //     activeEditor.setContent(content);

                // } else {

                //     $('.new_signature').val(content);
                // }

                if ('replyforward_signature' in response.data && response.data.replyforward_signature != '') {

                    var message1 = response.data.replyforward_signature;

                    if (tinymce.get('textarea_editor_email_replyforward_signature') != undefined && tinymce.get('textarea_editor_email_replyforward_signature') != null) {

                        // tinymce.get('textarea_editor_email_replyforward_signature').setContent(message1, { format: 'html' });

                        tinymce.get('textarea_editor_email_replyforward_signature').execCommand('mceInsertContent', false, message1);
                        // $('#textarea_editor_email_replyforward_signature').append(message1);

                    }

                } else {

                    // tinymce.get('textarea_editor_email_replyforward_signature').setContent('<p style="margin: 0in; margin-bottom: .0001pt; font-size: 10.0pt; font-family: Arial;"><br></p>', { format: 'html' });

                    tinymce.get('textarea_editor_email_replyforward_signature').execCommand('mceInsertContent', false, emailSignatureEditorParaTag);

                }


                // $('.replyforward_signature').summernote('code', message1);

                // var activeEditor = tinymce.activeEditor;

                // var content = message;

                // if (activeEditor !== null && content != '') {

                //     activeEditor.setContent(content);

                // } else {

                //     $('.replyforward_signature').val(content);
                // }

            } else {

                if (tinymce.get('textarea_editor_email_new_signature') != undefined && tinymce.get('textarea_editor_email_new_signature') != null) {

                    tinymce.get('textarea_editor_email_new_signature').setContent('');

                    tinymce.get('textarea_editor_email_new_signature').execCommand('mceInsertContent', false, emailSignatureEditorParaTag);

                }

                if (tinymce.get('textarea_editor_email_replyforward_signature') != undefined && tinymce.get('textarea_editor_email_replyforward_signature') != null) {

                    tinymce.get('textarea_editor_email_replyforward_signature').setContent('');

                    tinymce.get('textarea_editor_email_replyforward_signature').execCommand('mceInsertContent', false, emailSignatureEditorParaTag);

                }

            }
        } else {

            Swal.fire({

                title: '',
                text: "Signature Data Not Found!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }
    });

}

$(document).on('change', '.email-template', function(e) {

    var postData = {};

    var modal = '';

    var job_id = '';

    var postUrl = '';

    var email_id = '';

    var template = '';

    var signature = '';

    var emailTemplateListUrl = '';

    template = $(this).val();

    job_id = $('#job_id').val();

    email_id = $('#email_id').val();

    modal = $(this).attr('data-modal');

    emailTemplateListUrl = $(this).attr('data-email-template-list-url');

    signature = $('.signature_change').val();

    if (emailTemplateListUrl != undefined && emailTemplateListUrl != '' && emailTemplateListUrl != null) {

        postUrl = emailTemplateListUrl;

    }

    if (email_id != undefined && email_id != '' && email_id != null) {

        postData.email_id = email_id;

    }

    if (job_id != undefined && job_id != '' && job_id != null) {

        postData.job_id = job_id;

    }

    if (template != undefined && template != '' && template != null) {

        postData.template = template;

    }

    if (signature != undefined && signature != '' && signature != null) {

        postData.signature = signature;

    }

    $.ajax({

        url: postUrl,
        data: postData,
        dataType: 'json',
        type: 'POST',
        beforeSend: function() {
            $('.email_detail_loader').show();
        },
        complete: function() {
            $('.email_detail_loader').hide();
        }

    }).done(function(response) {

        if (response.success == 'true') {

            if (response.data != undefined && response.data != '') {

                if (response.data != undefined && response.data != '') {

                    var email_template_data = '';

                    if (response.data.email_template_variables != undefined && response.data.email_template_variables != '') {

                        $('.email-template').attr('data-email-template-variables', JSON.stringify(response.data.email_template_variables));

                    }

                    if (response.data.template_variables != undefined && response.data.template_variables != '') {

                        if (Object.keys(response.data.template_variables).length > 0) {

                            if (response.data.template_variables.author_email != undefined && response.data.template_variables.author_email != '') {

                                if ($('#to').attr('class') != undefined && $('#to').attr('class') != '') {

                                    $('#to').val(response.data.template_variables.author_email + ';');

                                }

                                if ($('.email-reply-to').attr('class') != undefined && $('.email-reply-to').attr('class') != '') {

                                    $('.email-reply-to').val(response.data.template_variables.author_email + ';');

                                }

                            }

                        }

                    }

                    if (response.data.body_html != undefined && response.data.body_html != '') {

                        email_template_data = response.data.body_html;

                        var email_template_data_html = $('<div/>').html(email_template_data).contents();

                        if (response.data.template_variables != undefined && response.data.template_variables != '') {

                            if (Object.keys(response.data.template_variables).length > 0) {

                                for (const variable in response.data.template_variables) {

                                    var replace_element = email_template_data_html.find('.' + variable);

                                    if (replace_element != undefined && replace_element != '') {

                                        if (variable in response.data.template_variables && response.data.template_variables[variable] != undefined && response.data.template_variables[variable] != '') {

                                            replace_element.html(response.data.template_variables[variable]);

                                            replace_element.removeAttr('style');

                                        }

                                    }

                                }

                            }

                        }

                        email_template_data = email_template_data_html.html();

                    }

                    var text_editor = '';

                    if (modal == 'compose') {

                        text_editor = 'textarea_editor_email_compose';

                    }

                    if (modal == 'reply') {

                        text_editor = 'textarea_editor_email_reply';

                    }

                    if (modal == 'draft') {

                        text_editor = 'textarea_editor_email_draft';

                    }

                    if (tinymce.get(text_editor) != undefined && tinymce.get(text_editor) != '') {

                        var message = '';

                        // if (text_editor == 'textarea_editor_email_compose') {

                        //     tinymce.get(text_editor).setContent(response.data.body_html);

                        // } else {

                        var email_template_classname = sessionStorage.getItem('email_template_classname');

                        var email_template_class_exists = $('#' + text_editor + '_ifr').contents().find('.' + email_template_classname).text();

                        if (email_template_class_exists != '') {

                            if (email_template_data == '') {

                                $('#' + text_editor + '_ifr').contents().find('.' + email_template_classname).remove();

                            } else {

                                $('#' + text_editor + '_ifr').contents().find('.' + email_template_classname).html(email_template_data);

                            }

                        }

                        if (email_template_class_exists == '' && email_template_data != '') {

                            var random = Math.random().toString(36).substring(7);

                            var email_template_class = 'email_template_block_' + random;

                            sessionStorage.setItem('email_template_classname', email_template_class);

                            var email_template_html = '<div class="' + email_template_class + '">' + email_template_data + '</div>';

                            message = tinymce.get(text_editor).getContent({ format: 'html' });

                            message = email_template_html + message;

                            // tinymce.get(text_editor).execCommand('mceInsertContent', false, message);
                            tinymce.get(text_editor).setContent(message);

                        }

                        // }

                    }

                }
            }
        }

    });

});

$(document).on('change', '.signature_change', function(e) {
    var val = this.value;
    var pagetype = $(this).attr('data-signature-type');

    var emailPostData = {};
    var selector = '.signature';
    var postUrl = $(selector).attr('data-signature-geturl');


    $.ajax({

        url: postUrl,
        data: emailPostData,
        dataType: 'json',
        type: 'POST',

    }).done(function(response) {


        if (response.success == "true") {

            if (response.data != undefined && typeof response.data == 'object') {

                var classname = sessionStorage.getItem('signature_classname');
                var ed = tinyMCE.activeEditor;
                var hasMarkup = ed.dom.hasClass(ed.selection.getNode(), classname);
                var ele = tinyMCE.activeEditor.dom.get(classname);
                var classexisting = $('#textarea_editor_email_compose_ifr').contents().find('.' + classname).text()

                if (val == 'new_signature') {

                    if ('new_signature' in response.data && response.data.new_signature != '') {

                        //if ($("div").hasClass(classname) == true) {
                        if (classexisting != '') {

                            $('#textarea_editor_email_compose_ifr').contents().find('.' + classname).html(response.data.new_signature);

                            //$('.' + classname).html(response.data.new_signature);

                        } else {

                            var random = Math.random().toString(36).substring(7);

                            var sig_class = 'emailsig_block_' + random;

                            sessionStorage.setItem('signature_classname', sig_class);

                            if (pagetype == 'new') {

                                // var message = $('.compose_message').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    message = tinymce.get('textarea_editor_email_compose').getContent({ format: 'html' });

                                    // tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, '');
                                    tinymce.get('textarea_editor_email_compose').setContent('');

                                }

                                var stamp = '<div class="emailsig_block ' + sig_class + '">' + response.data.new_signature;
                                var msg = '</div>';
                                message = message + stamp + msg;
                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, message);
                                    // $('#textarea_editor_email_compose').append(message);

                                }



                            } else if (pagetype == 'reply') {

                                // var message = $('.email-reply-body_html').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    // tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, '');
                                    tinymce.get('textarea_editor_email_reply').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.new_signature;
                                var msg = '</div>';
                                message = stamp + msg + message;

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, message);

                                    // $('#textarea_editor_email_reply').append(message);

                                }



                            }

                        }

                    }

                } else if (val == 'replyforward_signature') {

                    //$('#textarea_editor_email_compose_ifr').contents().find('.anand').html('<div> blah </div>');
                    //return false;

                    if ('replyforward_signature' in response.data && response.data.replyforward_signature != '') {

                        //if ($("div").hasClass(classname) == true) {
                        if (classexisting != '') {
                            // $('.' + classname).html(response.data.replyforward_signature);

                            $('#textarea_editor_email_compose_ifr').contents().find('.' + classname).html(response.data.replyforward_signature);

                        } else {

                            var random = Math.random().toString(36).substring(7);
                            var sig_class = 'emailsig_block_' + random;
                            sessionStorage.setItem('signature_classname', sig_class);

                            if (pagetype == 'new') {
                                // var message = $('.compose_message').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    message = tinymce.get('textarea_editor_email_compose').getContent({ format: 'html' });



                                    tinymce.get('textarea_editor_email_compose').setContent('');

                                }

                                var stamp = '<div class="emailsig_block ' + sig_class + '">' + response.data.replyforward_signature;
                                var msg = '</div>';
                                message = message + stamp + msg;

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, message);

                                    // $('#textarea_editor_email_compose').append(message);

                                }


                            } else if (pagetype == 'reply') {
                                // var message = $('.email-reply-body_html').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    message = tinymce.get('textarea_editor_email_reply').getContent({ format: 'html' });

                                    // tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, '');
                                    tinymce.get('textarea_editor_email_reply').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.replyforward_signature;
                                var msg = '</div>';
                                message = stamp + msg + message;

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, message);

                                    // $('#textarea_editor_email_reply').append(message);

                                }

                            }

                        }

                    }

                }

            }
        } else {



            Swal.fire({

                title: '',
                text: "Signature Data Not Found!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }
    });
});
$(document).on('change', '.signature_reply_change', function(e) {
    var val = this.value;
    var pagetype = $(this).attr('data-signature-type');

    var emailPostData = {};
    var selector = '.signature';
    var postUrl = $(selector).attr('data-signature-geturl');


    $.ajax({

        url: postUrl,
        data: emailPostData,
        dataType: 'json',
        type: 'POST',

    }).done(function(response) {


        if (response.success == "true") {

            if (response.data != undefined && typeof response.data == 'object') {

                var classname = sessionStorage.getItem('signature_classname');
                var ed = tinyMCE.activeEditor;
                var hasMarkup = ed.dom.hasClass(ed.selection.getNode(), classname);
                var ele = tinyMCE.activeEditor.dom.get(classname);
                var classexisting = $('#textarea_editor_email_reply_ifr').contents().find('.' + classname).text()

                if (val == 'new_signature') {

                    if ('new_signature' in response.data && response.data.new_signature != '') {

                        //if ($("div").hasClass(classname) == true) {
                        if (classexisting != '') {

                            $('#textarea_editor_email_reply_ifr').contents().find('.' + classname).html(response.data.new_signature);

                            //$('.' + classname).html(response.data.new_signature);

                        } else {

                            var random = Math.random().toString(36).substring(7);

                            var sig_class = 'emailsig_block_' + random;

                            sessionStorage.setItem('signature_classname', sig_class);

                            if (pagetype == 'new') {

                                // var message = $('.compose_message').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    message = tinymce.get('textarea_editor_email_compose').getContent({ format: 'html' });

                                    // tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, '');
                                    tinymce.get('textarea_editor_email_compose').setContent('');

                                }

                                var stamp = '<div class="emailsig_block ' + sig_class + '">' + response.data.new_signature;
                                var msg = '</div>';
                                message = message + stamp + msg;
                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, message);
                                    // $('#textarea_editor_email_compose').append(message);

                                }



                            } else if (pagetype == 'reply') {

                                // var message = $('.email-reply-body_html').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    // tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, '');
                                    tinymce.get('textarea_editor_email_reply').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.new_signature;
                                var msg = '</div>';
                                message = stamp + msg + message;

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, message);

                                    // $('#textarea_editor_email_reply').append(message);

                                }



                            }

                        }

                    }

                } else if (val == 'replyforward_signature') {

                    //$('#textarea_editor_email_compose_ifr').contents().find('.anand').html('<div> blah </div>');
                    //return false;

                    if ('replyforward_signature' in response.data && response.data.replyforward_signature != '') {

                        //if ($("div").hasClass(classname) == true) {
                        if (classexisting != '') {
                            // $('.' + classname).html(response.data.replyforward_signature);

                            $('#textarea_editor_email_reply_ifr').contents().find('.' + classname).html(response.data.replyforward_signature);

                        } else {

                            var random = Math.random().toString(36).substring(7);
                            var sig_class = 'emailsig_block_' + random;
                            sessionStorage.setItem('signature_classname', sig_class);

                            if (pagetype == 'new') {
                                // var message = $('.compose_message').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    message = tinymce.get('textarea_editor_email_compose').getContent({ format: 'html' });



                                    tinymce.get('textarea_editor_email_compose').setContent('');

                                }

                                var stamp = '<div class="emailsig_block ' + sig_class + '">' + response.data.replyforward_signature;
                                var msg = '</div>';
                                message = message + stamp + msg;

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, message);

                                    // $('#textarea_editor_email_compose').append(message);

                                }


                            } else if (pagetype == 'reply') {
                                // var message = $('.email-reply-body_html').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    message = tinymce.get('textarea_editor_email_reply').getContent({ format: 'html' });

                                    // tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, '');
                                    tinymce.get('textarea_editor_email_reply').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.replyforward_signature;
                                var msg = '</div>';
                                message = stamp + msg + message;

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, message);

                                    // $('#textarea_editor_email_reply').append(message);

                                }

                            }

                        }

                    }

                }

            }
        } else {
            Swal.fire({

                title: '',
                text: "Signature Data Not Found!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }
    });
});
$(document).on('change', '.signature_draft_change', function(e) {
    var val = this.value;
    var pagetype = $(this).attr('data-signature-type');

    var emailPostData = {};
    var selector = '.signature';
    var postUrl = $(selector).attr('data-signature-geturl');


    $.ajax({

        url: postUrl,
        data: emailPostData,
        dataType: 'json',
        type: 'POST',

    }).done(function(response) {


        if (response.success == "true") {

            if (response.data != undefined && typeof response.data == 'object') {

                var classname = sessionStorage.getItem('signature_classname');
                var ed = tinyMCE.activeEditor;
                var hasMarkup = ed.dom.hasClass(ed.selection.getNode(), classname);
                var ele = tinyMCE.activeEditor.dom.get(classname);
                var classexisting = $('#textarea_editor_email_draft_ifr').contents().find('.' + classname).text()

                if (val == 'new_signature') {

                    if ('new_signature' in response.data && response.data.new_signature != '') {
                        if (classexisting != '') {
                            $('#textarea_editor_email_draft_ifr').contents().find('.' + classname).html(response.data.new_signature);
                        } else {

                            var random = Math.random().toString(36).substring(7);

                            var sig_class = 'emailsig_block_' + random;

                            sessionStorage.setItem('signature_classname', sig_class);

                            if (pagetype == 'new') {
                                var message = '';

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {
                                    message = tinymce.get('textarea_editor_email_compose').getContent({ format: 'html' });
                                    // tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, '');
                                    tinymce.get('textarea_editor_email_compose').setContent('');
                                }

                                var stamp = '<div class="emailsig_block ' + sig_class + '">' + response.data.new_signature;
                                var msg = '</div>';
                                message = message + stamp + msg;
                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {
                                    tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, message);
                                    // $('#textarea_editor_email_compose').append(message);

                                }



                            } else if (pagetype == 'reply') {
                                var message = '';

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {
                                    tinymce.get('textarea_editor_email_reply').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.new_signature;
                                var msg = '</div>';
                                message = stamp + msg + message;

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {
                                    tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, message);
                                }
                            }

                        }

                    }

                } else if (val == 'replyforward_signature') {

                    if ('replyforward_signature' in response.data && response.data.replyforward_signature != '') {
                        if (classexisting != '') {
                            $('#textarea_editor_email_draft_ifr').contents().find('.' + classname).html(response.data.replyforward_signature);

                        } else {

                            var random = Math.random().toString(36).substring(7);
                            var sig_class = 'emailsig_block_' + random;
                            sessionStorage.setItem('signature_classname', sig_class);

                            if (pagetype == 'new') {

                                var message = '';

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    message = tinymce.get('textarea_editor_email_compose').getContent({ format: 'html' });
                                    tinymce.get('textarea_editor_email_compose').setContent('');

                                }

                                var stamp = '<div class="emailsig_block ' + sig_class + '">' + response.data.replyforward_signature;
                                var msg = '</div>';
                                message = message + stamp + msg;

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {
                                    tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, message);
                                }


                            } else if (pagetype == 'reply') {
                                var message = '';

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    message = tinymce.get('textarea_editor_email_reply').getContent({ format: 'html' });
                                    tinymce.get('textarea_editor_email_reply').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.replyforward_signature;
                                var msg = '</div>';
                                message = stamp + msg + message;

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {
                                    tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, message);
                                }

                            }

                        }

                    }

                }

            }
        } else {
            Swal.fire({

                title: '',
                text: "Signature Data Not Found!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }
    });
});
$(document).on('change', '.signature_change_old', function(e) {
    var val = this.value;
    var pagetype = $(this).attr('data-signature-type');

    var emailPostData = {};
    var selector = '.signature';
    var postUrl = $(selector).attr('data-signature-geturl');


    $.ajax({

        url: postUrl,
        data: emailPostData,
        dataType: 'json',
        type: 'POST',

    }).done(function(response) {


        if (response.success == "true") {

            if (response.data != undefined && typeof response.data == 'object') {

                var classname = sessionStorage.getItem('signature_classname');
                var ed = tinyMCE.activeEditor;
                var hasMarkup = ed.dom.hasClass(ed.selection.getNode(), classname);
                var ele = tinyMCE.activeEditor.dom.get(classname);

                if (val == 'new_signature') {

                    if ('new_signature' in response.data && response.data.new_signature != '') {

                        //if ($("div").hasClass(classname) == true) {
                        if (hasMarkup == true) {
                            $('#textarea_editor_email_compose_ifr').contents().find('.' + classname).html(response.data.new_signature);

                            //$('.' + classname).html(response.data.new_signature);

                        } else {

                            var random = Math.random().toString(36).substring(7);

                            var sig_class = 'emailsig_block_' + random;

                            sessionStorage.setItem('signature_classname', sig_class);

                            if (pagetype == 'new') {

                                // var message = $('.compose_message').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    message = tinymce.get('textarea_editor_email_compose').getContent({ format: 'html' });

                                    // tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, '');
                                    tinymce.get('textarea_editor_email_compose').setContent('');

                                }

                                var stamp = '<div class="emailsig_block ' + sig_class + '">' + response.data.new_signature;
                                var msg = '</div>';
                                message = message + stamp + msg;

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, message);
                                    // $('#textarea_editor_email_compose').append(message);

                                }

                                // $('.compose_message').summernote('code', message);

                                // var activeEditor = tinymce.activeEditor;

                                // var content = message;

                                // if (activeEditor !== null && content != '') {

                                //     activeEditor.setContent(content);

                                // } else {

                                //     $('.compose_message').val(content);
                                // }

                            } else if (pagetype == 'reply') {

                                // var message = $('.email-reply-body_html').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    // tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, '');
                                    tinymce.get('textarea_editor_email_reply').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.new_signature;
                                var msg = '</div>';
                                message = stamp + msg + message;

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, message);

                                    // $('#textarea_editor_email_reply').append(message);

                                }

                                // $('.email-reply-body_html').summernote('code', message);

                                // var activeEditor = tinymce.activeEditor;

                                // var content = message;

                                // if (activeEditor !== null && content != '') {

                                //     activeEditor.setContent(content);

                                // } else {

                                //     $('.email-reply-body_html').val(content);
                                // }

                            }

                        }

                    }

                } else if (val == 'replyforward_signature') {

                    //$('#textarea_editor_email_compose_ifr').contents().find('.anand').html('<div> blah </div>');
                    //return false;

                    if ('replyforward_signature' in response.data && response.data.replyforward_signature != '') {

                        //if ($("div").hasClass(classname) == true) {
                        if (hasMarkup == true) {
                            // $('.' + classname).html(response.data.replyforward_signature);

                            $('#textarea_editor_email_compose_ifr').contents().find('.' + classname).html(response.data.replyforward_signature);

                        } else {

                            var random = Math.random().toString(36).substring(7);
                            var sig_class = 'emailsig_block_' + random;
                            sessionStorage.setItem('signature_classname', sig_class);

                            if (pagetype == 'new') {
                                // var message = $('.compose_message').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    message = tinymce.get('textarea_editor_email_compose').getContent({ format: 'html' });



                                    //var regex = '/<div class="'+classname+'">(.*?)</div>/g';

                                    //var found = paragraph.match(regex);
                                    //alert(classname);
                                    //alert(found);


                                    //alert(message);
                                    // tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, '');
                                    tinymce.get('textarea_editor_email_compose').setContent('');

                                }

                                var stamp = '<div class="emailsig_block ' + sig_class + '">' + response.data.replyforward_signature;
                                var msg = '</div>';
                                message = message + stamp + msg;

                                if (tinymce.get('textarea_editor_email_compose') != undefined && tinymce.get('textarea_editor_email_compose') != null) {

                                    tinymce.get('textarea_editor_email_compose').execCommand('mceInsertContent', false, message);

                                    // $('#textarea_editor_email_compose').append(message);

                                }

                                // $('.compose_message').summernote('code', message);

                                // var activeEditor = tinymce.activeEditor;

                                // var content = message;

                                // if (activeEditor !== null && content != '') {

                                //     activeEditor.setContent(content);

                                // } else {

                                //     $('.compose_message').val(content);
                                // }

                            } else if (pagetype == 'reply') {
                                // var message = $('.email-reply-body_html').val();

                                var message = '';

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    message = tinymce.get('textarea_editor_email_reply').getContent({ format: 'html' });

                                    // tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, '');
                                    tinymce.get('textarea_editor_email_reply').setContent('');

                                }

                                var stamp = '<div class="' + sig_class + '">' + response.data.replyforward_signature;
                                var msg = '</div>';
                                message = stamp + msg + message;

                                if (tinymce.get('textarea_editor_email_reply') != undefined && tinymce.get('textarea_editor_email_reply') != null) {

                                    tinymce.get('textarea_editor_email_reply').execCommand('mceInsertContent', false, message);

                                    // $('#textarea_editor_email_reply').append(message);

                                }

                                // $('.email-reply-body_html').summernote('code', message);

                                // var activeEditor = tinymce.activeEditor;

                                // var content = message;

                                // if (activeEditor !== null && content != '') {

                                //     activeEditor.setContent(content);

                                // } else {

                                //     $('.email-reply-body_html').val(content);
                                // }

                            }

                        }

                    }

                }

            }
        } else {

            Swal.fire({

                title: '',
                text: "Signature Data Not Found!",
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }
    });
});

$(document).on('click', '.fw-attachements', function(e) {

    e.preventDefault();

    var removedId = $(this).attr('data-attachement-id');
    if (removedId != undefined && removedId != '') {

        $('.' + removedId).remove();

    }

});

// Multiple files preview in browser
function filesPreview(input, placeToInsertFilePreview) {

    if (input.files) {

        var filesAmount = input.files.length;

        for (i = 0; i < filesAmount; i++) {

            var filename = input.files[i].name;

            var currentTimestamp = '';

            currentTimestamp = moment.utc().format('YYYYMMDDHHmmssSSS') + '_' + Math.floor(Math.random() * 101);

            filesToUpload[currentTimestamp] = input.files[i];

            var htmlFile = '';
            htmlFile += '<li class="pb-5" id="new_attachements_' + currentTimestamp + '">';
            htmlFile += '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 email-attachment-item-block">';
            htmlFile += '<a href="javascript:void(0);" title="';
            htmlFile += filename;
            htmlFile += '" class="atch-thumb" style="text-decoration:none;">';
            htmlFile += '<span>';
            htmlFile += '<i class="font-30 mr-5 fa fa-';
            htmlFile += getFileType(filename);
            htmlFile += '-o"></i>';
            htmlFile += '</span>';
            htmlFile += '<span class="email-attachment-item-name ">';
            htmlFile += mb_strimwidth(filename, 0, 25, '...');
            htmlFile += '<i class="fa fa-times text-danger ml-5" onclick="removeFile($(this))" type="button" value="Remove" data-remove-id="new_attachements_' + i + '" data-remove-filename="' + filename + '" data-src="' + currentTimestamp + '"></i></a>';
            htmlFile += '</span>';
            htmlFile += '</div></li>';

            $($.parseHTML(htmlFile)).appendTo(placeToInsertFilePreview);

            $('.attached_file_box').show();

            // var reader = new FileReader();

            // reader.onload = function(event) {

            //     //     // var htmlFile = '<div>';
            //     //     // htmlFile = htmlFile + '<img  src="' + event.target.result + '" />';
            //     //     // htmlFile = htmlFile + '<input onclick="removeFile($(this))" type="button" value="Delete" />';
            //     //     // htmlFile = htmlFile + '</div>';
            //     $($.parseHTML(htmlFile)).appendTo(placeToInsertFilePreview);
            // }

            // reader.readAsDataURL(input.files[i]);

        }

    }

    $('.fileupload').val('');

};

function removeFile(item) {

    var fileSrc = item.attr('data-src');

    if (filesToUpload != undefined && Object.keys(filesToUpload).length > 0) {

        for (var index in filesToUpload) {

            if (index == fileSrc) {

                delete filesToUpload[index];

                item.closest('li').remove();

            }

        }

    }

    if (Object.keys(filesToUpload).length == 0) {

        $('.attached_file_box').hide();

    }

}

function removeAttachedEmailFile(item) {

    var fileSrc = item.attr('data-src');

    if (attachtedEmailFilesToUpload != undefined && Object.keys(attachtedEmailFilesToUpload).length > 0) {

        for (var index in attachtedEmailFilesToUpload) {

            if (index == fileSrc) {

                delete attachtedEmailFilesToUpload[index];

                item.closest('li').remove();

            }

        }

    }

    if (Object.keys(attachtedEmailFilesToUpload).length == 0) {

        $('.attached_file_box').hide();

    }

}


var filesToUpload = [];

var attachtedEmailFilesToUpload = [];

$('.fileupload').on('change', function() {
    filesPreview(this, '.attached_file');
});

function tinymceEditorFocus(editorId) {

    /* var ed = tinymce.activeEditor;

    if (ed != undefined && ed != null) {

        ed.getBody().firstChild.scrollIntoView();
        ed.selection.setCursorLocation(ed.getBody().children[0], 0);

    } */

    if ($('.pmbot_p') != undefined) {

        var editor = tinymce.get(editorId);

        editor.execCommand('mceSave');

        if ($(editor.getBody()).find('.pmbot_p') != undefined && $(editor.getBody()).find('.pmbot_p').get(0) != undefined) {

            $(editor.getBody()).find('.pmbot_p').get(0).scrollIntoView();

            editor.selection.setCursorLocation($(editor.getBody()).find('.pmbot_p').get(0), 0);

        }

        $('.modal').animate({ scrollTop: 0 }, 0);

        $('html, body').animate({

            scrollTop: $('.email-reply-form').offset().top - 150

        }, 0);

    }

}

function emailSentCount() {

    $('.dashboard-email-outbox-count').html('0');
    $('.dashboard-email-outboxwip-count').html('0');
    $('.dashboard-email-sent-count').html('0');
    $('.dashboard-email-hold-count').html('0');

    $('.dashboard-email-sent-count-btn').addClass('disabled');

    var postUrl = $('.dashboard-email-sent-count').attr('data-email-sent-count-url');

    var postData = {};

    if (postUrl != undefined && postUrl != '') {

        $.ajax({

            url: postUrl,
            // data: postData,
            dataType: 'json',
            type: 'POST',

        }).done(function(response) {

            if (response.success == "true") {

                if (response.data != undefined && typeof response.data == 'object') {

                    if (response.data.outbox_count != undefined && response.data.outbox_count != '' && response.data.outbox_count != '0') {

                        $('.dashboard-email-outbox-count').html(response.data.outbox_count);
                        $('.dashboard-email-outbox-count').attr('data-count', response.data.outbox_count);
                        $('.dashboard-email-outbox-count').parent().removeClass('disabled');

                    }

                    if (response.data.outbox_wip_count != undefined && response.data.outbox_wip_count != '' && response.data.outbox_wip_count != '0') {

                        $('.dashboard-email-outboxwip-count').html(response.data.outbox_wip_count);
                        $('.dashboard-email-outboxwip-count').attr('data-count', response.data.outbox_wip_count);
                        $('.dashboard-email-outboxwip-count').parent().removeClass('disabled');

                    }

                    if (response.data.sent_count != undefined && response.data.sent_count != '' && response.data.sent_count != '0') {

                        $('.dashboard-email-sent-count').html(response.data.sent_count);
                        $('.dashboard-email-sent-count').attr('data-count', response.data.sent_count);
                        $('.dashboard-email-sent-count').parent().removeClass('disabled');

                    }

                    if (response.data.hold_count != undefined && response.data.hold_count != '' && response.data.hold_count != '0') {

                        $('.dashboard-email-hold-count').html(response.data.hold_count);
                        $('.dashboard-email-hold-count').attr('data-count', response.data.hold_count);
                        $('.dashboard-email-hold-count').parent().removeClass('disabled');

                    }

                }

            }

        });

    }

}

function fieldErrorMsg(msg) {

    Swal.fire({

        title: '',
        text: msg,
        showClass: {
            popup: 'animated fadeIn faster'
        },
        hideClass: {
            popup: 'animated fadeOut faster'
        },

    });

}

function emailReviewList() {

    $('.email-detail-body').hide();
    $('.email-list-body').show();

    var gridSelector = ".reviewEmailGrid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        var sortLimit = $('#emailReview .sort-limit').val();
        var dateRange = $('#emailReview .date-range-picker').val();
        var sortType = $('#emailReview .sort-type').select2().val();
        var userEmpcode = $('#emailReview .user-empcode').select2().val();

        $(gridSelector).attr('data-empcode', '');
        $(gridSelector).attr('data-date-range', '');

        $(gridSelector).attr('data-sort-type', '');
        $(gridSelector).attr('data-sort-limit', '');

        $('#emailReview .reviewed-email-count').html('0');

        if (userEmpcode != undefined && userEmpcode != '') {

            $(gridSelector).attr('data-empcode', userEmpcode);

        }

        if (dateRange != undefined && dateRange != '') {

            $(gridSelector).attr('data-date-range', dateRange);

        }

        if (sortType != undefined && sortType != '') {

            $(gridSelector).attr('data-sort-type', sortType);

        }

        if (sortLimit != undefined && sortLimit != '') {

            $(gridSelector).attr('data-sort-limit', sortLimit);

        }

        getEmailTableList(gridSelector);

    }

}

$("#emailReviewTab").on('click', function() {

    emailReviewList();

});

$(".reviewed-email-sumbit-btn").on('click', function() {

    var sortLimit = $('#emailReview .sort-limit').val();
    var dateRange = $('#emailReview .date-range-picker').val();
    var sortType = $('#emailReview .sort-type').select2().val();
    var userEmpcode = $('#emailReview .user-empcode').select2().val();

    if (userEmpcode == undefined || userEmpcode == '') {

        fieldErrorMsg('please select valid PM');

        return false;

    }

    if (dateRange == undefined || dateRange == '') {

        fieldErrorMsg('please select valid date range');

        return false;

    }

    if (sortType == undefined || sortType == '') {

        fieldErrorMsg('please select valid sort type');

        return false;

    }

    if (sortLimit == undefined || sortLimit == '') {

        fieldErrorMsg('please enter valid sort limit');

        return false;

    }

    emailReviewList();

});

$(".email-rating-sumbit-btn").on('click', function(e) {

    e.preventDefault();

    var postUrl = '';
    var emailGetUrl = '';
    var params = '';
    var emailCategory = 'email-review';
    var emailGetUrl = $('.email-rating-form .email-rating-sumbit-btn').attr('data-email-get-url');
    var email_id = $('#emailReview .email-title').attr('data-email-id');
    params = new FormData($('.email-rating-form')[0]);

    if (email_id != undefined && email_id != '') {

        params.append('email_id', email_id);

    }

    postUrl = $('.email-rating-form').attr('action');

    if (postUrl != undefined && postUrl != '') {

        /* AJAX call to email label update info */

        var d = $.Deferred();

        $.ajax({
            url: postUrl,
            data: params,
            dataType: 'json',
            type: 'POST',
            processData: false,
            contentType: false,
            enctype: "multipart/form-data",
            beforeSend: function() {
                $('.email_detail_loader').show();
            },
            complete: function() {
                $('.email_detail_loader').hide();
                $('.reviewed-email-sumbit-btn').trigger('click');
                // emailDetailInfo(email_id, emailGetUrl, emailCategory);
            }
        }).done(function(response) {

            if (response.success == "true") {

                type = 'success';

            } else {

                type = 'error';

                d.resolve();

            }

            message = response.message;

            flashMessage(type, message);

        });

        return d.promise();


    }

});

function emailUnreview(postUrl, params) {

    if (postUrl != undefined && postUrl != '') {

        /* AJAX call to email label update info */

        var d = $.Deferred();

        $.ajax({
            url: postUrl,
            data: params,
            dataType: 'json',
            type: 'POST',
            beforeSend: function() {
                $('.email_detail_loader').show();
            },
            complete: function() {
                $('.email_detail_loader').hide();
                $('.reviewed-email-sumbit-btn').trigger('click');
                // var emailCategory = 'email-review';
                // var email_id = $('.email-title').attr('data-email-id');
                // var emailGetUrl = $('.email-rating-form .email-rating-sumbit-btn').attr('data-email-get-url');
                // emailDetailInfo(email_id, emailGetUrl, emailCategory);
            }
        }).done(function(response) {

            if (response.success == "true") {

                type = 'success';

            } else {

                type = 'error';

                d.resolve();

            }

            message = response.message;

            flashMessage(type, message);

        });

        return d.promise();

    }

}

$(document).on('click', '.email-unreview-btn', function(e) {

    e.preventDefault();

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to remove this email!",
        // icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        showClass: {
            popup: 'animated fadeInDownBig faster'
        },
        hideClass: {
            popup: 'animated fadeOut faster'
        },
    }).then((result) => {

        if (result.value != undefined && result.value == true) {

            var params = {};
            var postUrl = '';
            var postUrl = $('#emailReview .email-unreview-btn').attr('data-email-review-update-url');
            var email_id = $('#emailReview .email-unreview-btn').attr('data-group-ids');

            if (email_id != undefined && email_id != '') {

                params.id = email_id;
                params.unreview = '1';

                emailUnreview(postUrl, params);

            }

        }
    });

});

function lastestEmailList(email_id, empcode, emailSubject, from_date, filter) {

    $('.review-email-modal-detail-body').hide();
    $('.review-email-modal-list-body').show();

    var gridSelector = ".review-email-modal-grid";

    var dataUrl = $(gridSelector).attr('data-list-url');

    if (dataUrl != undefined && dataUrl != "") {

        if (email_id != undefined && email_id != '') {

            $(gridSelector).attr('data-email-id', email_id);

        }

        if (empcode != undefined && empcode != '') {

            $(gridSelector).attr('data-empcode', empcode);

        }

        if (emailSubject != undefined && emailSubject != '') {

            $(gridSelector).attr('data-email-subject', emailSubject);

        }

        if (from_date != undefined && from_date != '') {

            $(gridSelector).attr('data-email-from-date', from_date);

        }

        $('.dashboard-email-review-modal-title').html('');

        if (filter == 'latest-sent') {

            $('.dashboard-email-review-modal-title').html('Sent Mails');

        }

        if (filter == 'latest-received') {

            $('.dashboard-email-review-modal-title').html('Received Mails');

        }

        $(gridSelector).attr('data-email-filter', filter);

        getEmailTableList(gridSelector);

    }

}

$(document).on('click', '.email-latest-received-btn', function(e) {

    e.preventDefault();

    var email_id = $('#emailReview .email-title').attr('data-email-id');

    if (email_id != undefined && email_id != '') {

        var from_date = $('#emailReview .email-date').attr('data-email-date');

        var empcode = $('#emailReview .email-title').attr('data-email-empcode');

        var emailSubject = $('#emailReview .email-title').attr('data-subject-raw-text');

        lastestEmailList(email_id, empcode, emailSubject, from_date, 'latest-received');

        $('.review-email-modal').modal('show');

    }

});

$(document).on('click', '.email-latest-sent-btn', function(e) {

    e.preventDefault();

    var email_id = $('#emailReview .email-title').attr('data-email-id');

    if (email_id != undefined && email_id != '') {

        var from_date = $('#emailReview .email-date').attr('data-email-date');

        var empcode = $('#emailReview .email-title').attr('data-email-empcode');

        var emailSubject = $('#emailReview .email-title').attr('data-subject-raw-text');

        lastestEmailList(email_id, empcode, emailSubject, from_date, 'latest-sent');

        $('.review-email-modal').modal('show');

    }

});

$('.email-template-list').hide();