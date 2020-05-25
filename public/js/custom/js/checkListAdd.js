$(document).ready(function(e) {

    var checkListDescription = $('#check-list-description-view').attr("data-value");

    if (checkListDescription != undefined && $.trim(checkListDescription) != '') {

        // $('#check-list-description').data("wysihtml5").editor.setValue($('#check-list-description').attr('data-value'));
        // $('#check-list-description').summernote('code', $('#check-list-description').attr('data-value'));

        $('#check-list-description-view').html(checkListDescription);

    }

    var checkListDescriptionValue = $('#check-list-description').attr('data-value');

    if (checkListDescriptionValue != undefined && $.trim(checkListDescriptionValue) != "") {

        $('#check-list-description').summernote('code', checkListDescriptionValue);



    }

    $(document).on('click', '#checkListViewSearch', function() {

        checkListSearch();

    });

    $('#checkListViewSearchForm').submit(function(e) {

        e.preventDefault();

        checkListSearch();

    });

    function checkListSearch() {

        var targetUrl = $('#checkListView').attr('data-url');
        var jobId = $('#checkListViewSearchInput').attr('data-job-id');

        if ($('#checkListViewSearchInput').val() != "") {

            var detailUrl = $('#checkListViewSearch').attr('data-check-list-view-base-url');

            detailUrl = detailUrl + 'c_no=' + encodeURIComponent($('#checkListViewSearchInput').val()).replace(/%20/g, '+');

            if (jobId != undefined && jobId != '') {

                detailUrl = detailUrl + '&job_id =' + jobId;

            }

            targetUrl = detailUrl;

        }

        if (targetUrl != "") {

            window.location = targetUrl;

        }

    }

});


$(document).on('click', '.check-list-edit', function() {

    $("#checkListEdit").show();

    $('html,body').animate({
            scrollTop: $("#checkListEdit").offset().top
        },
        'slow');
});

$(document).on('click', '.check-list-edit-cancel', function(e) {

    e.preventDefault();

    if ($("#checkListEdit").attr('class') == undefined) {

        window.location = $(".check-list-edit-cancel").attr('href');

    }

    $("#checkListEdit").hide();

});

$(document).on('click', '.check-list-delete', function(e) {

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

            window.location = $('.check-list-delete').attr('href');

        }
    });

});

checklistWorkflowCheck();

function checklistWorkflowCheck() {

    if ($('.checklist-workflow').attr('class') != undefined) {

        $('.checklist-workflow').prop('disabled', 'true');

        if ($('.checklist-task-list').attr('class') != undefined) {

            var selectedChecklistTask = $('.checklist-task-list').val();

            // if (selectedChecklistTask != undefined && (selectedChecklistTask == '' || selectedChecklistTask == 'null')) {
            if (selectedChecklistTask == null) {

                $('.checklist-workflow').removeAttr('disabled');

            }

        }

    }
}

$(document).on('change', '.checklist-task-list', function(e) {
    checklistWorkflowCheck();
});

function workflowTasks(ajaxUrl, responseSelector) {

    if (ajaxUrl != undefined && ajaxUrl != '') {

        /* AJAX call to get list */
        $.ajax({

            url: ajaxUrl,
            dataType: "json",

            beforeSend: function() {
                $('#loader').css('visibility', 'visible');
            },

            complete: function() {
                $('#loader').css('visibility', 'hidden');
            }

        }).done(function(response) {

            if (response.success == "true") {

                if (response.data != "") {

                    if ($(responseSelector).attr('class') != undefined) {

                        // $(responseSelector).html(response.data);

                        $(responseSelector).empty();

                        $.each(response.data, function(key, value) {

                            $(responseSelector).append('<option value="' + key + '">' + value + '</option>');

                        })

                    }

                }

            }

        });

    }

}

$(document).on('change', '.checklist-workflow', function(e) {

    var url = $('.checklist-workflow').attr('data-workflow-task-list-url');

    var workflowId = $('.checklist-workflow').val()

    if (url != undefined && url != '' && workflowId != undefined && workflowId != '') {

        $('.workflow-version').val(workflowId);

        url = url + '?workflow_id=' + workflowId;

        workflowTasks(url, '.checklist-task-list');

    }

});