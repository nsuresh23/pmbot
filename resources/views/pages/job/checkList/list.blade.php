@extends('layouts.default')

@push('css')
<!-- Custom CSS -->
<link href="{{ asset('public/css/custom/css/custom.css') }}" rel="stylesheet">
@endpush

<?php

$type =  __("job.check_list_detail_label");
$tableCaption =  __("job.check_list_label");
$listUrl = route(__("job.check_list_url"));
$addUrl = route(__("job.check_list_add_url"));
$editUrl = route(__("job.check_list_edit_url"), "");
$deleteUrl = route(__("job.check_list_delete_url"));

?>

@section('content')
<!-- Main Content -->
<div class="container-fluid pt-25">

    <div id="grid-data" >

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
                        </div>
                        {{-- <a class="pull-left inline-block" href="javascript:history.back()" data-effect="fadeOut">
                            <i class="zmdi zmdi-close job-status-i"></i>
                        </a> --}}
                        {{-- <div class="clearfix"></div> --}}
                    </div>
                    <div class="clearfix"></div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="table-wrap">
                                <div class="checkListGrid" data-type="{{ $type }}" data-list-url="{{ $listUrl }}" data-add-url="{{ $addUrl }}" data-edit-url="{{ $editUrl }}" data-delete-url="{{ $deleteUrl }}" data-current-route="{{ Route::currentRouteName() }}"></div>
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