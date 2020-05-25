@extends('layouts.default')

@push('css')
<!-- Bootstrap Dropzone CSS -->
<link href="{{ asset('public/js/custom/vendors/bower_components/dropzone/dist/dropzone.css') }}" rel="stylesheet"
    type="text/css" />
<!-- Custom CSS -->
<link href="{{ asset('public/css/custom/css/custom.css') }}" rel="stylesheet">
@endpush

@section('content')

<!-- Main Content -->
<div class="container-fluid pt-25">

    <div id="taskNoteForm">

        @php

        // $disabled = $disabledClass = $selectedCategory = $selectedParent = $selectedStage = $selectedStatus =
        // $selectedCreatedUser = "";

        $disabled = $selectedCreatedUser = $taskId = "";
        
        $redirectTo = __("dashboard.dashboard_url");

        $postUrl = route(__("job.task_note_store_url")) . "?redirectTo=" . __("job.task_view_url");

        $mediaPostUrl = route(__("job.task_media_store_url"));

        $title = __('job.task_note_title_label');

        if(Route::currentRouteName() == __("job.task_note_edit_url")) {

        $title = __('job.task_note_edit_label');

        $postUrl = route(__("job.task_note_update_url"));

        $disabled = "disabled";

        $disabledClass = "disabled-block";

        }

        if(isset($returnData["redirectTo"]) && $returnData["redirectTo"]) {
        
            $redirectTo = __("job.task_view_url");
        
        }

        if(isset($returnData["data"]) && $returnData["data"]) {

        if(isset($returnData["data"]["id"]) && $returnData["data"]["id"]) {
        
        $taskId = $returnData["data"]["id"];
        
        }

        if(isset($returnData["data"]["parent_id"]) && $returnData["data"]["parent_id"]) {
        
        $selectedParent = $returnData["data"]["parent_id"];
        
        }

        }

        @endphp

        @include('pages.job.task.note')

    </div>
</div>
<!-- /Main Content -->
@endsection

@push('js')

<script>
    $(document).ready(function (e) {


        if ($.trim($('#taskMediaDropzone').attr('data-is-attachment')) == "true") {

            Dropzone.autoDiscover = false;

            var attachmentData = "";
            
            var attachmentData =
            <?php echo isset($returnData['data']['attachment'])?json_encode($returnData['data']['attachment']) : 'undefined' ?>;
            
            // var attachmentData = $('#taskDropzone').attr('data-value');

            $("#taskMediaDropzone").dropzone({

                init: function() {

                    myDropzone = this;

                    if(attachmentData != undefined && attachmentData !="" && attachmentData.length > 0) {

                        $.each(attachmentData, function (key, value) {
                        
                            var mockFile = { name: value.name, size: value.size };
                            
                            // myDropzone.emit("addedfile", addMockFile);
                            myDropzone.emit("addedfile", mockFile);
                            myDropzone.emit("thumbnail", mockFile, value.url);
                            myDropzone.emit("complete", mockFile);
                        
                        });

                    }
                    
                }

            });

        }

    });

</script>

@endpush