@extends('layouts.default')

@push('css')
<!-- Custom CSS -->
<link href="{{ asset('public/css/custom/css/custom.css') }}" rel="stylesheet">
@endpush

<?php

$type =  __("user.user_type_label");
$tableCaption =  __("user.user_label");
$listUrl = route(__("user.user_list_url"));
$addUrl = route(__("user.user_add_url"));
$editUrl = route(__("user.user_edit_url"), "");
$deleteUrl = route(__("user.user_delete_url"));
$passwordUpdateUrl = route(__("user.user_password_update_url"), "");

if(Route::currentRouteName() == __("user.user_group_list_url")) {

    $type =  __("user.user_group_type_label");
    $tableCaption =  __("user.user_group_label");
    $listUrl = route(__("user.user_group_list_url"));
    $addUrl = route(__("user.user_group_add_url"));
    $editUrl = route(__("user.user_group_edit_url"));
    $deleteUrl = route(__("user.user_group_delete_url"));

}

if(Route::currentRouteName() == __("user.user_role_list_url")) {

    $type =  __("user.user_role_type_label");
    $tableCaption =  __("user.user_role_label");
    $listUrl = route(__("user.user_role_list_url"));
    $addUrl = route(__("user.user_role_add_url"));
    $editUrl = route(__("user.user_role_edit_url"));
    $deleteUrl = route(__("user.user_role_delete_url"));

}

if(Route::currentRouteName() == __("user.user_location_list_url")) {

    $type =  __("user.user_location_type_label");
    $tableCaption =  __("user.user_location_label");
    $listUrl = route(__("user.user_location_list_url"));
    $addUrl = route(__("user.user_location_add_url"));
    $editUrl = route(__("user.user_location_edit_url"));
    $deleteUrl = route(__("user.user_location_delete_url"));

}

if(Route::currentRouteName() == __("user.job_stage_list_url")) {

    $type =  __("user.job_stage_type_label");
    $tableCaption =  __("user.job_stage_label");
    $listUrl = route(__("user.job_stage_list_url"));
    $addUrl = route(__("user.job_stage_add_url"));
    $editUrl = route(__("user.job_stage_edit_url"));
    $deleteUrl = route(__("user.job_stage_delete_url"));

}

?>

@section('content')
<!-- Main Content -->
<div class="container-fluid">

    <div id="grid-data" data-type="{{ $type }}" data-list-url="{{ $listUrl }}" data-add-url="{{ $addUrl }}" data-edit-url="{{ $editUrl }}" data-delete-url="{{ $deleteUrl }}" data-password-update-url="{{ $passwordUpdateUrl }}">

        <!-- Row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                        <h6 class="panel-title txt-dark">{{ $tableCaption }}</h6>
                        </div>
                        <div class="pull-right">
                            <a href="#" class="pull-left inline-block full-screen mr-15">
                                <i class="zmdi zmdi-fullscreen job-status-i"></i>
                            </a>
                            <a id="job-status-close" class="pull-left inline-block" href="{{ route(__("home")) }}"
                                data-effect="fadeOut">
                                <i class="zmdi zmdi-close job-status-i"></i>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="table-wrap">
                                <div id="userGrid"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Row -->

    </div>
</div>
<!-- /Main Content -->
@endsection