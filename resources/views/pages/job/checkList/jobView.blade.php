@extends('layouts.default')

@push('css')
<!-- Custom CSS -->
<link href="{{ asset('public/css/custom/css/custom.css') }}" rel="stylesheet">
@endpush

@section('content')

<!-- Main Content -->
<div class="container-fluid pt-25">

    <?php
    
        $selectedStatus = "checked";
        
        $redirectTo = $checkListId = $title = "";
        
        $title = __('job.check_list_detail_label');
        
        $viewUrl = $postUrl = $mediaPostUrl= '#';
        
        $redirectTo = __("dashboard.dashboard_url");
        
        $postUrl = route(__("job.check_list_store_url"));
        
        $mediaPostUrl = route(__("job.check_list_media_store_url"));
        
        if(isset($returnData["data"]) && $returnData["data"]) {
        
            if(isset($returnData["data"]["c_id"]) && $returnData["data"]["c_id"]) {
            
                $checkListId = $returnData["data"]["c_id"];
                
                $viewUrl = route(__("job.check_list_view_url"), $returnData["data"]["c_id"]);
            
            }
        
            if(isset($returnData["data"]["status"]) && $returnData["data"]["status"] == "0") {
            
                $selectedStatus = "";
            
            }
        
        }
    
    ?>
    
    @include('pages.job.checkList.detail')

</div>
<!-- /Main Content -->
@endsection