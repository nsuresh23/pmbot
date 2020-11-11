// $(function() {

var description = $('#task-description-view').attr("data-value");

if (description != undefined && description != '') {

    $('#task-description-view').html(description);

}

var commonDescription = $('#task-common-description-view').attr("data-value");

if (commonDescription != undefined && commonDescription != '') {

    $('#task-common-description-view').html(commonDescription);

}

function getTaskActivitiesTableList(gridSelector) {

    var listUrl = $(gridSelector).attr('data-list-url');
    var taskClosedText = $(gridSelector).attr('data-task-closed-text');
    var taskId = $(gridSelector).attr('data-task-id');
    var taskStatus = $(gridSelector).attr('data-task-status');
    var taskCloseUrl = $(gridSelector).attr('data-task-close-url');

    var currentRoute = $(gridSelector).attr('data-current-route');
    var addUrl = $(gridSelector).attr('data-add-url') + "?redirectTo=" + currentRoute;
    var editUrl = $(gridSelector).attr('data-edit-url');
    var multiTask = $(gridSelector).attr('data-multi-task');
    var deleteUrl = $(gridSelector).attr('data-delete-url');
    var createdByEmpcode = $(gridSelector).attr('data-created-empcode');
    var currentEmpcode = $(gridSelector).attr('data-current-empcode');
    var currentUserRole = $('#currentUserInfo').attr('data-current-user-role');

    var dbClients = "";


    if ($(gridSelector + ' .jsgrid-grid-header').attr('class') == undefined) {

        $(gridSelector).jsGrid({

            height: "450px",
            width: "100%",

            heading: false,
            filtering: false,
            inserting: false,
            editing: true,
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

                        return (!filter.detail || (client.detail != undefined && client.detail != null && (client.detail.toLowerCase().indexOf(filter.detail.toLowerCase()) > -1))) &&
                            (!filter.note || (client.note != undefined && client.note != null && (client.note.toLowerCase().indexOf(filter.note.toLowerCase()) > -1)));
                    });
                }
            },

            rowClick: function(args) {

                $(gridSelector).jsGrid("cancelEdit");

            },

            rowClass: function(item, itemIndex) {

                // return 'parent-task-row';
                // return itemIndex % 2 == 0 ? 'default' : 'success';

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

                    // $.MessageBox({

                    //     buttonDone: "Yes",
                    //     buttonFail: "No",
                    //     message: "Are You Sure?"

                    // }).done(function() {

                    //     deleteItem(args, deleteUrl, gridSelector);

                    // }).fail(function() {

                    //     return false;

                    // });

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to remove this!",
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

                            deleteItem(args, deleteUrl, gridSelector);

                        }
                    });

                }

            }

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
            visible: false,
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
            title: "TASK ID",
            name: "task_id",
            type: "text",
            inserting: false,
            editing: false,
            visible: false,
            width: 150
        },
        {
            // title: "USER_DETAIL",
            name: "userDetail",
            type: "text",
            // width: 150
        },
        {
            // title: "NOTE_DETAIL",
            name: "noteDetail",
            type: "textarea",
            // width: 300
        },
        {
            type: "control",
            updateButtonClass: "jsgrid-update-button",

            itemTemplate: function(value, item) {

                var $result = $([]);

                var taskId = '';

                var taskNote = '';

                var taskJobId = '';

                var taskEmpname = '';

                var taskAttachmentPath = '';

                if (item.emprole == currentUserRole) {

                    $result = $result.add(this._createEditButton(item));
                    $result = $result.add(this._createDeleteButton(item));

                }

                if (item.task_id != undefined && item.task_id != '') {

                    taskId = item.task_id;

                }

                if (item.job_id != undefined && item.job_id != '') {

                    taskJobId = item.job_id;

                }

                if (item.empname != undefined && item.empname != '') {

                    taskEmpname = item.empname;

                }

                if (item.additional_note != undefined && item.additional_note != '') {

                    taskNote = item.additional_note;
                    // taskNote = item.additional_note.replace(/\"/g, "'").replace(/\</g, '-````-').replace(/\>/g, '-~~~~-');
                    // taskNote = JSON.stringify(item.additional_note);

                }

                if (item.attachment_path != undefined && item.attachment_path != '') {

                    taskAttachmentPath = item.attachment_path;
                    // taskAttachmentPath = item.attachment_path.replace(/\"/g, "'").replace(/\</g, '-````-').replace(/\>/g, '-~~~~-');
                    // taskAttachmentPath = JSON.stringify(item.attachment_path);

                }

                // var taskAcceptUrlUrl = "passwordUpdateUrl";

                // var $replyButton = $('<a title="Reply" class="note-reply" data-task-note="' + taskNote + '" data-toggle="collapse" href = "#noteReply" aria-expanded="false" aria-controls="collapseExample"><i class="jsgrid-reply-button font-20 ml-5 fa fa-mail-reply"></i></a>');
                var $replyButton = $('<a title="Reply" class="note-reply" data-task-id="' + taskId + '" data-task-empname="' + taskEmpname + '" data-task-note="' + taskNote + '" data-task-attachment-path="' + taskAttachmentPath + '" href="javascript:void(0)"><i class="jsgrid-reply-button font-20 ml-5 fa fa-mail-reply"></i></a>');
                // var $replyButton = $('<a title="Reply" class="note-reply" data-task-empname="' + taskEmpname + '" href="javascript:void(0)"><span class="note-reply-note hiddenBlock">' + taskNote + '</span><span class="note-reply-attachment-path hiddenBlock">' + taskAttachmentPath + '</span><i class="jsgrid-reply-button font-20 ml-5 fa fa-mail-reply"></i></a>');

                if (currentEmpcode != undefined && currentEmpcode != '' && item.empcode != currentEmpcode) {

                    $result = $result.add($replyButton);

                }


                if (taskCloseUrl != undefined && taskCloseUrl != '' && taskId != undefined && taskId != '' && taskStatus != undefined && taskStatus != '') {

                    var closeUrl = taskCloseUrl + '?task_id=' + taskId + '&status=' + taskStatus;

                    if (taskJobId != undefined && taskJobId != '') {

                        closeUrl = closeUrl + '&job_id=' + taskJobId;

                    }

                    var $acceptButton = $('<a title="Close" class="task-close-button" href="' + closeUrl + '"><i class="jsgrid-accept-button text-success font-20 ml-5 fa fa-check"></i></a>');

                    if (currentEmpcode != undefined && currentEmpcode != '' && item.empcode != currentEmpcode) {

                        if (createdByEmpcode == currentEmpcode) {

                            $result = $result.add($acceptButton);

                        }


                    }

                }

                // if (multiTask == 'true') {

                //     return $([]);

                // }

                if ((taskStatus != undefined && taskClosedText != undefined) && taskStatus == taskClosedText) {

                    return $([]);

                }

                return $result;
            }

        },
    ];

    $(gridSelector).jsGrid("option", "fields", field);

    $(gridSelector).jsGrid("option", "editItem", function(item) {

        // var noteDropzone = new Dropzone("#taskNoteMediaDropzone");

        // noteDropzone.files = Dropzone.DropzoneFile;

        // noteDropzone.removeAllFiles(true);

        // console.log(noteDropzone.files = Dropzone.DropzoneFile[]);


        // $("#taskNoteMediaDropzone").dropzone.removeAllFiles(true);

        // $('.taskNoteForm #task-note').data("wysihtml5").editor.setValue(item.additional_note);

        $('.taskNoteForm #task-note').summernote('code', item.additional_note);

        $('.taskNoteForm #task-note').attr('previous_value', item.additional_note);

        $('.taskNoteForm #task-note').attr('value', item.additional_note);

        $('.taskNoteForm #attachment').val(item.attachment_path);

        $('.taskNoteForm #id').val(item.id);

        $('.taskNoteForm').attr('action', $('.taskActivities').attr('data-edit-url'));

        $('.taskNoteForm #attachment').addClass("checkField");

        $('.taskNoteForm #task-note').addClass("checkField");

        $('.taskNoteForm .taskNoteFormSubmitButton').addClass("checkFormButton");

        if (item.job_id != undefined && item.job_id != '') {

            if ($('.taskNoteModalForm #note-job-id').attr('name') != undefined && $('.taskNoteModalForm #note-job-id').attr('name') != '') {

                $('.taskNoteModalForm #note-job-id').val(item.job_id);

            } else {

                $('.taskNoteModalForm').append('<input type="hidden" id="note-job-id" name="job_id" value=' + "'" + item.job_id + "'" + ' />');

            }

        }

        if (item.task_id != undefined && item.task_id != '') {

            if ($('.taskNoteModalForm #note-task-id').attr('name') != undefined && $('.taskNoteModalForm #note-task-id').attr('name') != '') {

                $('.taskNoteModalForm #note-task-id').val(item.task_id);

            } else {

                $('.taskNoteModalForm').append('<input type="hidden" id="note-task-id" name="task_id" value=' + "'" + item.task_id + "'" + ' />');

            }


        }

        if (item.empcode != undefined && item.empcode != '') {

            if ($('.taskNoteModalForm #note-empcode').attr('name') != undefined && $('.taskNoteModalForm #note-empcode').attr('name') != '') {

                $('.taskNoteModalForm #note-empcode').val(item.empcode);

            } else {

                $('.taskNoteModalForm').append('<input type="hidden" id="note-empcode" name="empcode" value=' + "'" + item.empcode + "'" + ' />');

            }

        }

        if (item.empname != undefined && item.empname != '') {

            if ($('.taskNoteModalForm #note-empname').attr('name') != undefined && $('.taskNoteModalForm #note-empname').attr('name') != '') {

                $('.taskNoteModalForm #note-empname').val(item.empname);

            } else {

                $('.taskNoteModalForm').append('<input type="hidden" id="note-empname" name="empname" value=' + "'" + item.empname + "'" + ' />');

            }

        }

        if (item.emprole != undefined && item.emprole != '') {

            if ($('.taskNoteModalForm #note-emprole').attr('name') != undefined && $('.taskNoteModalForm #note-emprole').attr('name') != '') {

                $('.taskNoteModalForm #note-emprole').val(item.emprole);

            } else {

                $('.taskNoteModalForm').append('<input type="hidden" id="note-emprole" name="emprole" value=' + "'" + item.emprole + "'" + ' />');

            }

        }

        if (item.parent_task_id != undefined && item.parent_task_id != '') {

            if ($('.taskNoteModalForm #note-parent-task-id').attr('name') != undefined && $('.taskNoteModalForm #note-parent-task-id').attr('name') != '') {

                $('.taskNoteModalForm #note-parent-task-id').val(item.parent_task_id);

            } else {

                $('.taskNoteModalForm').append('<input type="hidden" id="note-parent-task-id" name="parent_task_id" value=' + "'" + item.parent_task_id + "'" + ' />');

            }

        }


        // $("#taskNoteMediaDropzone").html('<div class="dz-default dz-message"><span>Drop files here to upload</span></div>');

        // $("#taskNoteMediaDropzone .dz-message").attr('style', 'display: block !important');

        // $("#taskNoteMediaDropzone .dz-preview").html("");

        // if (Dropzone.instances.length > 0) Dropzone.instances.forEach(dz => dz.destroy())

        // Dropzone.autoDiscover = false;


        // if (item.attachment.length > 0) {

        //     var attachmentData = "";

        //     var attachmentData = item.attachment;

        //     $("#taskNoteMediaDropzone").dropzone({

        //     // Dropzone.options.taskNoteMediaDropzone = {

        //         init: function () {

        //             myDropzone = this;

        //             // this.removeAllFiles(true);

        //             // this.on("complete", function (file) {
        //             //     this.removeAllFiles(true);
        //             // })

        //             // this.on("addedfile", function (file) {





        //             //     if (this.files.length) {
        //             //         var _i, _len;
        //             //         for (_i = 0, _len = this.files.length; _i < _len - 1; _i++) // -1 to exclude current file
        //             //         {
        //             //             if (this.files[_i].name === file.name && this.files[_i].size === file.size && this.files[_i].lastModifiedDate.toString() === file.lastModifiedDate.toString()) {
        //             //                 this.removeFile(file);
        //             //             }
        //             //         }
        //             //     }
        //             // });

        //             var noteAttachmentDataValue = [];



        //             if ($("#taskNoteForm input[name='attachment']").val().length > 0) {

        //                 // var noteAttachmentItems = JSON.parse($("#taskNoteForm input[name='attachment[]']").val())
        //                 var noteAttachmentDataValue =  JSON.parse($("#taskNoteForm input[name='attachment']").val())



        //                 // for (var i = 0; i < noteAttachmentItems.length; i++) {
        //                 //     noteAttachmentDataValue.push(noteAttachmentItems[i].value);
        //                 // }

        //             }





        //             if (attachmentData != undefined && attachmentData != "" && attachmentData.length > 0) {

        //                 $.each(attachmentData, function (key, value) {

        //                     if ($.inArray(value.name, noteAttachmentDataValue) == -1 ) {

        //                         var mockFile = { name: value.name, size: value.size };

        //                         // myDropzone.emit("addedfile", addMockFile);
        //                         myDropzone.emit("addedfile", mockFile);
        //                         myDropzone.emit("thumbnail", mockFile, value.url);
        //                         myDropzone.emit("complete", mockFile);

        //                         noteAttachmentDataValue.push(value.name);

        //                     }

        //                 });

        //             }

        //             $("#taskNoteForm input[name='attachment']").val(JSON.stringify(noteAttachmentDataValue));




        //         }

        //     // }

        //     });

        // }


        $('.note-modal').modal('show');
        $(".note-modal[aria-label!='note']").hide();
        $('.modal-backdrop').hide();

        // if (gridType == 'detail') {

        // window.location = editUrl + "/" + item.id + "?task_id=" + item.task_id + "&redirectTo=" + currentRoute;

        // }

    });

    /* AJAX call to get list */
    $.ajax({

        url: listUrl,
        dataType: "json"

    }).done(function(response) {

        if (response.success == "true") {

            if (response.data == '' || Object.keys(response.data).length == 0) {

                $('.taskActivities').hide();

                if ($('.task-details-tab').attr('class') != undefined) {

                    $('.task-details-tab').trigger('click');

                }

                return false;

            }

            response.data = formatDataItem(response.data);

            dbClients = response.data;

            $(gridSelector).jsGrid("option", "data", response.data);

            $('.jsgrid-grid-body').slimscroll({
                height: '300px',
            });


        } else {

            $('.taskActivities').hide();

        }

    });

    function deleteItem(args, deleteUrl, gridSelector) {

        var type = '';
        var message = '';

        var d = $.Deferred();

        /* AJAX call */
        $.ajax({

            url: deleteUrl,
            data: { 'id': args.item.id, 'task_id': args.item.task_id },
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

                dataValue[i].userDetail = formatDataItemUserDetail(dataValue[i].user_image, dataValue[i].empinitial, dataValue[i].empname, dataValue[i].empcode, dataValue[i].created_date, dataValue[i].emprole, dataValue[i].modified_date, dataValue[i].creator_empcode);

                dataValue[i].noteDetail = formatDataItemNoteDetail(dataValue[i]);

            }

        }

        return dataValue;

    }

    function formatDataItemUserDetail(image, initial, name, team, created_at, role, updated_at, creator_name) {

        var creatorHtml = '';

        if (creator_name != undefined && creator_name != '') {

            creatorHtml = '<p class="ma-0">' +
                '<span class="block weight-500 txt-warning' +
                '">' +
                // 'Designation: ' +
                '(' +
                'By ' +
                creator_name +
                ')' +
                '</span>' +
                '</p>';

        }

        var returnData = '<div class="row">' +
            '<div class="col-lg-12 col-md-12, col-sm-12 col-xs-12">' +
            '<div class="row">' +
            '<div class="col-lg-3 col-md-3, col-sm-12 col-xs-12">' +
            '<div class="pull-left profile-img-wrap">' +

            '<span class="user-boxed ' +
            'bg-' +
            role +
            '">' +
            '<span class="user-boxed-initials">' +
            initial +
            '</span>' +
            '</span>' +

            // '<img class="inline-block mb-10" src="' +
            // image +
            // '" alt="user" />' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-9 col-md-9, col-sm-12 col-xs-12">' +
            '<div class="pull-left">' +
            '<h5 class="block ma-0 weight-500 txt-primary">' +
            '<i class="fa fa-user grey"></i>' +
            '<span class="pl-5">' +
            name +
            '</span>' +
            '</h5>' +
            // '<h6 class="block capitalize-font">' +
            //     'Team: ' +
            //     team +
            // '</h6>' +
            '<p class="ma-0">' +
            '<span class="label label-sm ' +
            'bg-' +
            role +
            '">' +
            // 'Designation: ' +
            role +
            '</span>' +
            '</p>' +

            creatorHtml +

            '<p class="ma-0 small lighter">' +
            '<i class="fa fa-clock-o grey"></i>' +
            '<span class="pl-5">' +
            created_at +
            '</span>' +
            '</p>' +
            // '<p class="ma-0">' +
            //     '<span class="label label-sm label-default">' +
            //         // 'Designation: ' +
            //         role +
            //     '</span>' +
            // '</p>' +
            '<p class="ma-0 small lighter">' +
            '<i class="fa fa-retweet"></i>' +
            '<span class="pl-5">' +
            'Last edited: ' +
            updated_at +
            '</span>' +
            '</p>' +
            '</div>' +
            '</div>' +
            '</row>' +
            '</div>' +
            '</row>';

        return returnData;

    }

    function formatDataItemNoteDetail(item) {

        var note = item.additional_note_text;
        var attachment = item.attachment_path;

        // var noteData = '<p>' +
        //     note +
        //     '</p>';

        var noteData = $('<p/>').html('<p>' + note + '</p>').text();

        if (attachment != '' && attachment != null) {

            var attachmentData = formatDataItemAttachmentDetail(attachment);

            noteData = noteData + attachmentData;

        }

        returnData = noteData;

        return returnData;

    }

    function formatDataItemNoteUserDetail(item) {

        var empName = item.empname;
        var formatedCreatedDate = item.formated_created_date;

        var returnData = '<p class="mt-10 mb-0 font-italic">' +
            'Updated by' +
            '<span class="weight-500 capitalize-font txt-primary">' +
            '<span class="pl-5">' +
            empName +
            '</span>' +
            '</span>' +
            ' at ' +
            '<span>' +
            formatedCreatedDate +
            '</span>' +
            '</p>';

        return returnData;

    }

    // function formatDataItemNoteDetail(item) {

    //     var noteData = ''
    //     var note = item.additional_note;
    //     var attachment = item.attachment_path;
    //     var formatedCreatedDate = item.formated_created_date;

    //     if (note != undefined && note != '' && note != null) {

    //         noteData = noteData + '<p>' +
    //             note +
    //             '</p>';

    //     }

    //     if (attachment != '' && attachment != null) {

    //         var attachmentData = formatDataItemAttachmentDetail(attachment);

    //         noteData = noteData + attachmentData;

    //     }

    //     if (formatedCreatedDate != undefined && formatedCreatedDate != '' && formatedCreatedDate != null) {

    //         var formatedCreatedDateData = formatDataItemNoteUserDetail(item);

    //         noteData = noteData + formatedCreatedDateData;

    //     }

    //     returnData = noteData;

    //     return returnData;

    // }

    function formatDataItemAttachmentDetail(attachment) {

        var returnData = '<div>';

        returnData += '<div>' +
            // '<a href="' + attachment + '" download>' +
            '<a href="javascript:void(0)">' +
            attachment +
            '</a>' +
            '</div>';

        // for (var i = 0, len = attachment.length; i < len; i++) {

        //     if (attachment[i].name != "") {

        //         returnData += '<div>' +
        //                         '<a href="' + attachment[i].url + '" download>' +
        //                         attachment[i].name +
        //                         '</a>' +
        //                         '</div>';

        //     }
        // }

        returnData += '</div>';

        return returnData;

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

    $(".taskGrid .jsgrid-insert-mode-button").on('click', function() {

        // if (gridType == 'detail') {

        window.location = addUrl;

        // }

    });

}

var gridSelector = ".taskActivities";

var dataUrl = $(gridSelector).attr('data-list-url');

if (dataUrl != undefined && dataUrl != "") {

    getTaskActivitiesTableList(gridSelector);

}


// var noteAttachmentData = JSON.parse($('#taskNoteForm #attachment').val());

// var noteAttachmentDataValue = [];



// if ($("#taskNoteForm input[name='attachment']").val().length > 0) {

//     // var noteAttachmentItems = JSON.parse($("#taskNoteForm input[name='attachment[]']").val())
//     var noteAttachmentDataValue = JSON.parse($("#taskNoteForm input[name='attachment']").val())



//     // for (var i = 0; i < noteAttachmentItems.length; i++) {
//     //     noteAttachmentDataValue.push(noteAttachmentItems[i].value);
//     // }

// }

// });

$(document).on('click', '.task-note-modal', function() {

    // $('.note-modal-body').append($("#jobListGrid").html);
    // $('.taskNoteForm #task-note').data("wysihtml5").editor.setValue("");
    $('.taskNoteForm #task-note').summernote('code', '');

    $('.taskNoteForm #attachment').val("");

    $('.taskNoteForm #id').val("");

    $('.note-modal').modal('show');

});

$('.taskActivitiesScrollBlock').slimscroll({
    // height: '20rem',
    // height: '',
    allowPageScroll: true,
    alwaysVisible: true
});

$(document).on('click', '.note-reply', function() {

    $("#taskEdit").hide();

    $("#noteReply").show();



    var taskId = $(this).attr('data-task-id');
    var taskNote = $(this).attr('data-task-note');
    // var taskNote = JSON.parse($(this).attr('data-task-note').replace(/\'/g, '"'));
    var taskEmpname = $(this).attr('data-task-empname');
    var taskAttachmentPath = $(this).attr('data-task-attachment-path');
    // var taskAttachmentPath = JSON.parse($(this).attr('data-task-attachment-path').replace(/\'/g, '"'));

    if (taskId != undefined && taskId != "null" && taskId != "") {

        $('#noteReplyTaskId').val(taskId);

    }

    $('.task_additional_note').summernote('code', '');

    if ((taskNote != undefined && taskNote != "null" && taskNote != "") ||
        (taskAttachmentPath != undefined && taskAttachmentPath != "null" && taskAttachmentPath != "")
    ) {

        // taskNote = $('.note-reply-note').text();
        // taskAttachmentPath = $('.note-reply-attachment-path').text();

        // taskNote = taskNote.replace(/\'/g, '"').replace(/\-````-/g, '<').replace(/\-~~~~-/g, '>');
        // taskAttachmentPath = taskAttachmentPath.replace(/\'/g, '"').replace(/\-````-/g, '<').replace(/\-~~~~-/g, '>');
        // taskAttachmentPath = taskAttachmentPath.replace(/\-gggg-/g, '<').replace(/\-pppp-/g, '>');

        if (taskEmpname != undefined && taskEmpname != "null" && taskEmpname != "") {

            var noteHtmlStr = '';

            var taskEmpnameHtml = '<p>' + taskEmpname + ' wrote:' + '</p>';

            noteHtmlStr += taskEmpnameHtml;

            if (taskNote != '') {

                var taskNoteHtml = '<p class="ml-15">' + taskNote + '</p>';

                noteHtmlStr += taskNoteHtml;

            }

            if (taskAttachmentPath != '') {

                var taskAttachmentHtml = '<p class="ml-15"><a href="javascript:void(0)">' + taskAttachmentPath + '</a></p>';

                noteHtmlStr += taskAttachmentHtml;

            }

            var note = $('<blockquote />').html(noteHtmlStr);

            if (note != undefined) {

                $('.task_additional_note').summernote('insertNode', note[0]);

                var codeHtml = $('.task_additional_note').summernote('code');

                if (codeHtml != undefined && codeHtml != '') {

                    codeHtml = codeHtml.replace('<p><br></p>', '');

                    $('.task_additional_note').summernote('code', codeHtml);

                    $('.task_additional_note').summernote('focus');

                }

            }

            // $('.task_additional_note').summernote('pasteHTML', note);

            // $('.task_additional_note').summernote('code', note);

        }

    }

    $('html,body').animate({
            scrollTop: $("#noteReply").offset().top
        },
        'slow');
});

$(document).on('click', '.note-reply-cancel', function() {

    $("#noteReply").hide();

});

$(document).on('click', '.task-close-button', function(e) {

    e.preventDefault();

    var taskCheckList = taskCheckListCheck();

    if (taskCheckList == false) {

        return false;

    }

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to close this!",
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

            window.location = $('.task-close-button').attr('href') + '&checklist=' + taskCheckList;

        }
    });

});


function taskCheckListCheck() {

    var selected = [];

    if ($('.task-check-list').attr('class') == undefined) {

        return true;

    }

    if ($('.task-check-list').attr('class') != undefined && $('.task-check-list input[type="checkbox"]').not(':checked').length == 0) {

        $('.task-check-list input:checked').each(function() {

            if ($(this).attr('data-checklist-id') != undefined) {

                selected.push($(this).attr('data-checklist-id'));

            }

        });

    } else {
        Swal.fire({

            title: '',
            text: "Please complete the checklist!",
            showClass: {
                popup: 'animated fadeIn faster'
            },
            hideClass: {
                popup: 'animated fadeOut faster'
            },

        });

        return false;
    }

    return selected;

}
