@extends('layouts.default')

@push('css')
<!-- Custom CSS -->
<link href="{{ asset('public/css/custom/css/custom.css') }}" rel="stylesheet">
@endpush

<?php

$emailRuleListUrl = route("email-rules-fetch");
$emailRuleAddUrl = "";
$emailRuleEditUrl = "";
$emailRuleDeleteUrl = "";

?>

@section('content')
<!-- Main Content -->
<div class="container-fluid pa-0">

    <!-- Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default card-view">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div id="email-rules" class="tab-pane fade active in" role="tabpanel">
                            <div class="email-rules-grid fullwidth" data-list-url="{{ $emailRuleListUrl }}" data-add-url="{{ $emailRuleAddUrl }}"
                                data-edit-url="{{ $emailRuleEditUrl }}" data-delete-url="{{ $emailRuleDeleteUrl }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->

<!-- /Main Content -->
@endsection
