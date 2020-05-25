function multipleTaskAssigneeCheck() {

    if ($('#multipleTaskAssignee').attr('type') != undefined) {

        if ($('#multipleTaskAssignee').prop('checked') == true) {

            if ($('.subTaskDescHead').attr('class') != undefined) {

                $('.subTaskDescHead').show();

            }

        } else {

            if ($('.subTaskDescHead').attr('class') != undefined) {

                $('.subTaskDescHead').hide();

            }

        }

    } else {

        if ($('.subTaskDescHead').attr('class') != undefined) {

            $('.subTaskDescHead').hide();

        }

    }

}

// $(document).ready(function(e) {

// multipleTaskAssigneeCheck();

if ($.trim($('#task-description').attr('data-value')) != "") {

    // $('#task-description').data("wysihtml5").editor.setValue($('#task-description').attr('data-value'));
    $('#task-description').summernote('code', $('#task-description').attr('data-value'));



}

$(document).on('click', '#taskViewSearch', function() {

    taskSearch();

});

function checkAllRemoved() {

    var previousUserList = {};

    var returnData = 'true';

    if ($('.task_desc_tab_list').attr('data-tab-user-list') != undefined && $.trim($('.task_desc_tab_list').attr('data-tab-user-list')) != "") {

        previousUserList = JSON.parse($('.task_desc_tab_list').attr('data-tab-user-list').replace(/\'/g, '"'));

    }

    if (Object.keys(previousUserList).length > 0) {

        $.each(previousUserList, function(key, previousTaskDetail) {

            if (previousTaskDetail.deleted != undefined && previousTaskDetail.deleted == '0') {

                returnData = 'false';

                return false;

            }

        });

    }

    return returnData;

}

$(document).on('click', '.remove-task-user-tab', function(e) {

    e.preventDefault();

    var removedId = $(this).attr('data-user-empcode');

    if (removedId != undefined && removedId != '') {

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

                $('#' + removedId).remove();
                $('#' + removedId + 'Tab').remove();

                $('.task_desc_tab_list a:last').tab('show');

                var previousAssigneeId = $('.task_desc_tab_list a:last').attr('data-assignee-id');

                if (previousAssigneeId != undefined && previousAssigneeId != '') {

                    $('.task-assignee').select2().val(previousAssigneeId);
                    $('.task-assignee').select2().trigger('change');

                } else {

                    $(".task-assignee").select2().val(null);
                    $('.task-assignee').select2().trigger('change');

                }

                var previousUserList = {};

                if ($('.task_desc_tab_list').attr('data-tab-user-list') != undefined && $.trim($('.task_desc_tab_list').attr('data-tab-user-list')) != "") {

                    previousUserList = JSON.parse($('.task_desc_tab_list').attr('data-tab-user-list').replace(/\'/g, '"'));

                }

                if (removedId in previousUserList) {

                    var subTaskInfo = {};

                    // $('#taskForm').append("<input type='hidden' name='deletedSubTask[]' value='" + JSON.stringify(previousUserList[removedId]) + "'>");

                    // delete previousUserList[removedId];

                    previousUserList[removedId].deleted = "1";

                    $('.task_desc_tab_list').attr('data-tab-user-list', JSON.stringify(previousUserList));

                }

                var allSubTaskRemoved = checkAllRemoved();

                if (allSubTaskRemoved == 'true') {

                    $('#multipleTaskAssignee').removeAttr('disabled');

                    $('#multipleTaskAssignee').trigger("click");

                    // $('#multipleTaskAssignee').prop('checked', false);

                }

                // $(this).closest("li").focus().addClass("active");

                // $("li.third-item").prev().css("background-color", "red");

                // $('.task-assignee').select2();
            }

        });

    }

});

$(document).on('click', '#multipleTaskAssignee', function(e) {

    if ($(this).prop("checked") == true) {

        $('.multiple-task-assignee').addClass('task-assignee');

        $('.subTaskDescHead').show();

        var selectedVal = $('.task-assignee option:selected').val();
        var selectedText = $('.task-assignee option:selected').text();

        if (selectedVal != undefined && selectedVal != '') {

            includeAssigneeTaskTab(selectedVal, selectedText);

        }

    } else if ($(this).prop("checked") == false) {

        var previousUserList = {};

        if ($('.task_desc_tab_list').attr('data-tab-user-list') != undefined && $.trim($('.task_desc_tab_list').attr('data-tab-user-list')) != "") {

            previousUserList = JSON.parse($('.task_desc_tab_list').attr('data-tab-user-list').replace(/\'/g, '"'));

        }

        var allSubTaskRemoved = checkAllRemoved();

        if (allSubTaskRemoved != 'true') {

            // $.MessageBox("Please remove assigned users to proceed!");

            // swal("", "Please remove assigned users to proceed!", "warning");

            Swal.fire({

                title: '',
                text: "Please remove assigned users to proceed!",
                // icon: 'warning',
                // showCancelButton: true,
                // confirmButtonColor: '#3085d6',
                // cancelButtonColor: '#d33',
                // confirmButtonText: 'Yes',
                showClass: {
                    popup: 'animated fadeIn faster'
                },
                hideClass: {
                    popup: 'animated fadeOut faster'
                },

            });

            return false;

        }

        $('.multiple-task-assignee').removeClass('task-assignee');

        $('.subTaskDescHead').hide();

    }

    // $(".task-assignee").val("");

    // $(".task-assignee").select2("val", '');

    // $('.task-assignee option:selected').val()

});

function includeAssigneeTaskTab(selectedVal, selectedText) {

    var previousUserList = {};

    if (selectedVal != undefined && $.trim(selectedVal) != "") {

        if ($('.task_desc_tab_list').attr('data-tab-user-list') != undefined && $.trim($('.task_desc_tab_list').attr('data-tab-user-list')) != "") {

            previousUserList = JSON.parse($('.task_desc_tab_list').attr('data-tab-user-list').replace(/\'/g, '"'));

        }

        var tabName = selectedVal + '_desc';

        if (tabName in previousUserList) {

            if ($('.' + tabName + '_textarea_editor').attr('data-assignee-id') != undefined) {

                // $('.' + tabName + '_textarea_editor').data("wysihtml5").editor.setValue(previousUserList[tabName].description);
                $('.' + tabName + '_textarea_editor').summernote('code', previousUserList[tabName].description);

            } else {

                addTaskAssigneeTab(previousUserList[tabName].task_id, previousUserList[tabName].empcode, previousUserList[tabName].empname, previousUserList[tabName].description, previousUserList[tabName].status);

            }


        } else {

            addTaskAssigneeTab('', selectedVal, selectedText, '', '');

        }

        var selectedTab = '#' + selectedVal + '_descTab';

        $(selectedTab).tab('show');

        // var tabName = selectedVal + '_desc';

        // if ($('.task_desc_tab_list').attr('data-tab-user-list') != undefined && $.trim($('.task_desc_tab_list').attr('data-tab-user-list')) != "") {

        //     previousUserList = JSON.parse($('.task_desc_tab_list').attr('data-tab-user-list'));

        // }

        // if (!(tabName in previousUserList)) {

        //     var tabNameList = '<li role="presentation" class="">' +
        //         '<a data-toggle="tab" id="' +
        //         tabName + 'Tab' +
        //         '" role="tab" href="#' +
        //         tabName +
        //         '" aria-expanded="false">' +
        //         selectedText +
        //         '<i class="fa fa-times font-20 remove-task-user-tab text-danger ml-5" data-user-empcode="' +
        //         tabName +
        //         '"></i >' +
        //         '</a>' +
        //         '</li>';

        //     // var tabNameList = '<li role="presentation"><a aria-expanded="true" data-toggle="tab" role="tab" id="' + tabName + '" href="#' + tabName + '">' + selectedText + '</a></li>';

        //     // var tabContentList = '<div id="' + tabName + '" class="tab-pane fade" role="tabpanel">' +
        //     //     '<textarea class="textarea_editor form-control" rows="15" id="' + tabName + '" name="' + tabName + '" placeholder = "" >' +
        //     //     '</textarea >' +
        //     //     '<div class="help-block with-errors"></div>' +
        //     //     '</div >';

        //     var tabContentList = '<div id="' +
        //         tabName +
        //         '" class="tab-pane fade" role="tabpanel">' +
        //         '<textarea class="' +
        //         tabName + '_textarea_editor' +
        //         ' form-control user_desc" rows="15" id="' +
        //         tabName + '_description' +
        //         '" name="' + tabName + '_description"' +
        //         'placeholder="Enter description" data-user-id="' +
        //         selectedVal +
        //         '">' +
        //         '</textarea>' +
        //         '<div class="help-block with-errors">' +
        //         '</div>'
        //     '</div>';

        //     $('.task_desc_tab_content').append(tabContentList);
        //     $('.task_desc_tab_list').append(tabNameList);

        //     // $('#' + tabName + '_description').refresh();
        //     $('.' + tabName + '_textarea_editor').wysihtml5({
        //         toolbar: {
        //             //   fa: true,
        //             //   "link": true,
        //             // "font-styles": true, // Font styling, e.g. h1, h2, etc.
        //             // "emphasis": true, // Italics, bold, etc.
        //             // "lists": true, // (Un)ordered lists, e.g. Bullets, Numbers.
        //             // "html": false, // Button which allows you to edit the generated HTML.
        //             "link": false, // Button to insert a link.
        //             "image": false, // Button to insert an image.
        //             // "color": false, // Button to change color of font
        //             // "blockquote": true, // Blockquote
        //             // "size": <buttonsize> // options are xs, sm, lg
        //         }
        //     });

        //     previousUserList[tabName] = tabName;

        //     $('.task_desc_tab_list').attr('data-tab-user-list', JSON.stringify(previousUserList));

        //     // $('.task-assignee').select2();

        //     $(".task-assignee").select2("destroy");

        //     $(".task-assignee").select2();

        // }

    }

}

$(document).on('change', '.task-assignee', function() {

    var previousUserList = {};

    var selectedVal = $('.task-assignee option:selected').val();
    var selectedText = $('.task-assignee option:selected').text();

    includeAssigneeTaskTab(selectedVal, selectedText);

});

subTaskDetails('.multiple-task-assignee');

multipleTaskAssigneeCheck();

function subTaskDetails(selector) {

    var subTaskDetails = {};

    if ($(selector).attr('data-value') != undefined && $.trim($(selector).attr('data-value')) != "") {

        subTaskDetails = JSON.parse($(selector).attr('data-value'));

        if (Object.keys(subTaskDetails).length > 0) {

            $.each(subTaskDetails, function(key, subTaskDetail) {

                if (subTaskDetail.empcode != undefined && subTaskDetail.empcode != '') {

                    if (subTaskDetail.empname != undefined && subTaskDetail.empname != '') {

                        if (subTaskDetail.task_id != undefined && subTaskDetail.task_id != '') {

                            if (subTaskDetail.status != undefined && subTaskDetail.status != '') {

                                addTaskAssigneeTab(subTaskDetail.task_id, subTaskDetail.empcode, subTaskDetail.empname, subTaskDetail.description, subTaskDetail.status);

                            }

                        }

                    }

                }

            });

        }

    }

}

function addTaskAssigneeTab(taskId, empcode, empname, description, status) {

    var previousUserList = {};

    var tabSelector = '.task_desc_tab_list';

    var contentSelector = '.task_desc_tab_content';

    var multipleTaskAssigneeSelector = '#multipleTaskAssignee';

    if ($(tabSelector).attr('data-tab-user-list') != undefined && $.trim($(tabSelector).attr('data-tab-user-list')) != "") {

        previousUserList = JSON.parse($(tabSelector).attr('data-tab-user-list').replace(/\'/g, '"'));

    }

    var tabLabel = empname;

    var tabName = empcode + '_desc';

    // if (!(tabName in previousUserList)) {

    var tabNameList = '<li role="presentation" class="">' +
        '<a data-toggle="tab" id="' +
        tabName + 'Tab' +
        '" class=assignedUserDescTab"' +
        '" data-assignee-id="' +
        empcode +
        '" role="tab" href="#' +
        tabName +
        '" aria-expanded="false">' +
        tabLabel +
        '<i class="fa fa-times font-20 remove-task-user-tab text-danger ml-5" data-user-empcode="' +
        tabName +
        '"></i >' +
        '</a>' +
        '</li>';

    var tabContentList = '<div id="' +
        tabName +
        '" class="tab-pane fade" role="tabpanel">' +
        '<textarea class="' +
        tabName + '_textarea_editor' +
        ' form-control assignee_desc user_desc" rows="15" id="' +
        tabName + '_description' +
        '" name="' + tabName + '_description"' +
        'placeholder="Enter description" data-assignee-id="' +
        empcode +
        '" data-assignee-task-id="' +
        taskId +
        '">' +
        '</textarea>' +
        '<div class="help-block with-errors">' +
        '</div>'
    '</div>';

    $(contentSelector).append(tabContentList);
    $(tabSelector).append(tabNameList);

    $('.' + tabName + '_textarea_editor').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['fontname']],
            ['font', ['fontsize', 'color']],
            ['insert', ['table']], // image and doc are customized buttons
            ['height', ['height']],
            ['para', ['ol', 'ul', 'paragraph']],
            // ['insert', ['link', 'image', 'doc', 'video']], // image and doc are customized buttons
            // ['misc', ['codeview', 'fullscreen']],
            ['misc', ['fullscreen']],
        ],
        height: 150, //set editable area's height
        blockquoteBreakingLevel: 2,
        disableDragAndDrop: true,
        codemirror: { // codemirror options
            theme: 'monokai'
        },
    });

    // $('.' + tabName + '_textarea_editor').data("wysihtml5").editor.setValue(description);
    $('.' + tabName + '_textarea_editor').summernote('code', description);

    previousUserList[tabName] = {
        'tab': tabName,
        'empcode': empcode,
        'empname': empname,
        'task_id': taskId,
        'description': description,
        'status': status,
        'deleted': '0',
    };

    // $(tabSelector).attr('data-tab-user-list', JSON.stringify(previousUserList));

    $(tabSelector).attr('data-tab-user-list', JSON.stringify(previousUserList).replace(/\"/g, "'"));

    $(multipleTaskAssigneeSelector).prop('checked', true);
    $(multipleTaskAssigneeSelector).attr('disabled', 'disabled');

    $('.multiple-task-assignee').addClass('task-assignee');

    $(".task-assignee").select2().val(empcode);

    // $(".task-assignee").select2("destroy");

    // $(".task-assignee").select2();

    // }

}

$(document).on('click', '#taskFormSubmitButton', function(e) {

    e.preventDefault();

    var userList = {};

    formHistory('#taskFormSubmitButton');

    $(".user_desc").each(function() {

        var userId = $(this).attr('data-assignee-id');
        var taskId = $(this).attr('data-assignee-task-id');
        var description = $(this).val();

        if (userId != undefined && userId != '') {

            // var userInfo = {};

            if (taskId != undefined && taskId != '') {

                // userInfo['task_id'] = taskId;

                $('#taskForm').append("<input type='hidden' name='" + 'assignee~' + userId + '~task_id' + "' value='" + taskId + "'>");

            }

            // userInfo['empcode'] = userId;

            $('#taskForm').append("<input type='hidden' name='" + 'assignee~' + userId + '~empcode' + "' value='" + userId + "'>");

            if (description != undefined && description != '') {

                // userInfo['description'] = JSON.stringify(description);

                $('#taskForm').append("<input type='hidden' name='" + 'assignee~' + userId + '~description' + "' value='" + description + "'>");

            }

            // $('#taskForm').append("<input type='hidden' name='users[]' value='" + JSON.stringify(userInfo) + "'>");

            $(this).remove();

        }

    });

    // $('#taskForm').append("<input type='hidden' name='partialcomplete' value='1'>");

    $('#partialcomplete').val('0');

    if (taskCheckList()) {

        $('#taskForm').submit();

    }


});

$(document).on('click', '#taskFormSaveButton', function(e) {

    e.preventDefault();

    var userList = {};

    $(".user_desc").each(function() {

        var userId = $(this).attr('data-assignee-id');
        var taskId = $(this).attr('data-assignee-task-id');
        var description = $(this).val();

        if (userId != undefined && userId != '') {

            // var userInfo = {};

            if (taskId != undefined && taskId != '') {

                // userInfo['task_id'] = taskId;

                $('#taskForm').append("<input type='hidden' name='" + 'assignee~' + userId + '~task_id' + "' value='" + taskId + "'>");

            }

            // userInfo['empcode'] = userId;

            $('#taskForm').append("<input type='hidden' name='" + 'assignee~' + userId + '~empcode' + "' value='" + userId + "'>");

            if (description != undefined && description != '') {

                // userInfo['description'] = description;

                $('#taskForm').append("<input type='hidden' name='" + 'assignee~' + userId + '~description' + "' value='" + description + "'>");

            }

            // $('#taskForm').append("<input type='hidden' name='users[]' value='" + JSON.stringify(userInfo) + "'>");

            $(this).remove();

        }

    });

    // $('#taskForm').append("<input type='hidden' name='partialcomplete' value='1'>");

    $('#partialcomplete').val('1');

    $('#taskForm').submit();

});

$('#taskViewSearchForm').submit(function(e) {

    e.preventDefault();

    taskSearch();

});

function taskSearch() {

    var targetUrl = $('#taskView').attr('data-url');

    if ($('#taskViewSearchInput').val() != "") {

        var detailUrl = $('#taskViewSearch').attr('data-task-view-base-url');

        targetUrl = detailUrl + '/' + encodeURIComponent($('#taskViewSearchInput').val()).replace(/%20/g, '+');

    }

    if (targetUrl != "") {

        window.location = targetUrl;

    }

}

// });

$(document).on('click', '.task-edit', function() {

    $("#noteReply").hide();

    $("#taskEdit").show();

    multipleTaskAssigneeCheck();

    $('html,body').animate({
            scrollTop: $("#taskEdit").offset().top
        },
        'slow');
});

$(document).on('click', '.task-edit-cancel', function(e) {

    e.preventDefault();

    if ($("#taskEdit").attr('class') == undefined) {

        window.location = $(".task-edit-cancel").attr('href');

    }

    $("#taskEdit").hide();

});

$(document).on('click', '.task-delete', function(e) {

    e.preventDefault();

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

            window.location = $('.task-delete').attr('href');

        }
    });

});

$(document).on('change', '.task_category', function(e) {

    $('#followup_type').val('snooze');

    var taskCategoryFollowupTimeList = {};

    var selectedCategory = $('.task_category option:selected').val();

    var taskCategoryFollowupTime = $('.task_category').attr('data-task-category_followup_time');

    if (selectedCategory != undefined && selectedCategory != '' && taskCategoryFollowupTime != undefined && taskCategoryFollowupTime != '') {

        taskCategoryFollowupTimeList = JSON.parse(taskCategoryFollowupTime);

        if (Object.keys(taskCategoryFollowupTimeList).length > 0) {

            $.each(taskCategoryFollowupTimeList, function(index, value) {

                if (selectedCategory == index) {

                    var taskFollowupDatetime = taskFollowupDataTime(value);

                    if (taskFollowupDatetime != undefined && taskFollowupDatetime != '') {

                        $('.followup_date').val(taskFollowupDatetime);

                    }

                }

            });

        }

    }

});

function taskFollowupDataTime(hours) {

    // const today = new Date();

    // const finalDate = new Date(today);

    // finalDate.setDate(today.getHours() + hours);

    var returned_endate = moment(new Date()).add(hours, 'hours').format("YYYY-MM-DD HH:mm:ss");

    return returned_endate;

    // return new Date(new Date().getHours() + hours);

    // var currentTime = new Date();

    // var followupDateTime = currentTime.getHours() + hours;

    return finalDate;

}

// taskCheckList();

function taskCheckList() {

    var selected = [];

    if ($('.taskEditForm').attr('class') != undefined) {

        // var selectedStatus = $('.taskEditForm input[name:status option:selected]').val();

        var selectedStatus = $('.taskEditForm select[name="status"]').val();

        if (selectedStatus != undefined && selectedStatus == 'closed') {

            if ($('.task-check-list').attr('class') == undefined) {

                return true;

            }

            if ($('.task-check-list').attr('class') != undefined && $('.task-check-list input[type="checkbox"]').not(':checked').length == 0) {

                $('.task-check-list input:checked').each(function() {

                    if ($(this).attr('data-checklist-id') != undefined) {

                        selected.push($(this).attr('data-checklist-id'));

                    }

                });

                if (selected.length > 0) {

                    if ($('.taskEditForm').attr('class') != undefined) {

                        $('.taskEditForm .checklist').val(selected);

                    }

                }

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

        }

    }

    return true;

}

$('.task-follow-up-datetime').submit(function() {

    e.preventDefault();
    var formObj = $(this);
    var formURL = formObj.attr("action");
    var formData = new FormData(this);

    var d = $.Deferred();

    /* AJAX call */
    $.ajax({

        url: formURL,
        data: formData,
        dataType: "json"

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

});

$(document).on('click', '#taskDiaryTab', function() {

    var getUrl = '';

    getUrl = $('#taskDiaryTab').attr('data-task-history-url');

    if (getUrl != undefined && getUrl != '') {

        /* AJAX call to get Job history */
        $.ajax({

            url: getUrl,
            dataType: "json"

        }).done(function(response) {

            if (response.success == "true") {

                if (response.data != "") {

                    $('.task-history-data').html(response.data);

                }

            }

        });

    }

});