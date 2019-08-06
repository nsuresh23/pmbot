@extends('layouts.default')

@push('css')
<!-- Custom CSS -->
<link href="{{ asset('css/custom/css/custom.css') }}" rel="stylesheet">
@endpush

@section('content')
<!-- Main Content -->
<div class="container-fluid pt-25">

    <!-- Row -->
    <div class="row">
        <!--<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h2 class="txt-dark">S5</h2>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body sm-data-box-1">
                        {{-- <span class="uppercase-font weight-500 font-14 block text-center txt-dark">customer satisfaction</span> --}}
                        <div class="cus-sat-stat weight-500 txt-primary text-center mt-5 model_img img-responsive no-underline job-list" alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s5" data-status="all">
                            <span class="counter-anim">50</span>
                            {{-- <span>%</span> --}}
                        </div>
                        <div class="progress-anim mt-20">
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary wow animated progress-animated" role="progressbar" aria-valuenow="100"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <ul class="flex-stat mt-5">
                            <li class="model_img img-responsive no-underline job-list" alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s5" data-status="pending">
                                <span class="block">Pending</span>
                                {{-- <span class="block weight-500 txt-dark font-15">30</span> --}}
                                <span class="block weight-500 txt-dark font-15">30</span>
                            </li>
                            <li class="model_img img-responsive no-underline job-list" alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s5" data-status="wip">
                                <span class="block">Work in progress</span>
                                {{-- <span class="block weight-500 txt-dark font-15">5</span> --}}
                                <span class="block weight-500 txt-dark font-15">5</span>
                            </li>
                            <li class="model_img img-responsive no-underline job-list" alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s5" data-status="completed">
                                <span class="block">Completed</span>
                                {{-- <span class="block weight-500 txt-dark font-15">15</span> --}}
                                <span class="block weight-500 txt-dark font-15">15</span>
                                {{-- <span class="block">
                                    <i class="zmdi zmdi-trending-up txt-dark font-20"></i>
                                </span> --}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h2 class="txt-dark text-capitalize">{{ $jobsData['stageTitle'] }}</h2>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body sm-data-box-1">
                        {{-- <span class="uppercase-font weight-500 font-14 block text-center txt-dark">customer satisfaction</span> --}}
                        <div class="cus-sat-stat weight-500 txt-primary text-center mt-5 model_img img-responsive no-underline job-list"
                            alt="default" data-toggle="modal" data-url="{{ route('job-list') }}"
                            data-stage="{{ $jobsData['stage'] }}" data-status="{{ $jobsData['allTitle'] }}">
                            <span class="counter-anim">{{ $jobsData['total'] }}</span>
                            {{-- <span>%</span> --}}
                        </div>
                        <div class="progress-anim mt-20">
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary wow animated progress-animated" role="progressbar"
                                    aria-valuenow="{{ $jobsData['completed'] }}" aria-valuemin="0" aria-valuemax="{{ $jobsData['total'] }}"></div>
                            </div>
                        </div>
                        <ul class="flex-stat mt-5">
                            <li class="model_img img-responsive no-underline job-list" alt="default" data-toggle="modal"
                                data-url="{{ route('job-list') }}" data-stage="{{ $jobsData['stage'] }}"
                                data-status="{{ $jobsData['pendingTitle'] }}">
                                <span class="block capitalize">{{ $jobsData['pendingTitle'] }}</span>
                                {{-- <span class="block weight-500 txt-dark font-15">30</span> --}}
                                <span class="block weight-500 txt-dark font-15">{{ $jobsData['pending'] }}</span>
                            </li>
                            <li class="model_img img-responsive no-underline job-list" alt="default" data-toggle="modal"
                                data-url="{{ route('job-list') }}" data-stage="{{ $jobsData['stage'] }}"
                                data-status="{{ $jobsData['wipTitle'] }}">
                                <span class="block capitalize">{{ $jobsData['wipTitle'] }}</span>
                                {{-- <span class="block weight-500 txt-dark font-15">5</span> --}}
                                <span class="block weight-500 txt-dark font-15">{{ $jobsData['wip'] }}</span>
                            </li>
                            <li class="model_img img-responsive no-underline job-list" alt="default" data-toggle="modal"
                                data-url="{{ route('job-list') }}" data-stage="{{ $jobsData['stage'] }}"
                                data-status="{{ $jobsData['completedTitle'] }}">
                                <span class="block capitalize">{{ $jobsData['completedTitle'] }}</span>
                                {{-- <span class="block weight-500 txt-dark font-15">15</span> --}}
                                <span class="block weight-500 txt-dark font-15">{{ $jobsData['completed'] }}</span>
                                {{-- <span class="block">
                                            <i class="zmdi zmdi-trending-up txt-dark font-20"></i>
                                        </span> --}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {{-- {{ route('job-stage-card', [
            'title' => 's5',
            'stageTitle' => 's5',
            'stage' => 's5',
            'total' => '50',
            'allTitle' => 'all',
            'pendingTitle' => 'pending',
            'pending' => '15',
            'wipTitle' => 'wip',
            'wip' => '20',
            'completedTitle' => 'completed',
            'completed' => '15'
        ]) }} --}}
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h2 class="txt-dark">S50</h2>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body sm-data-box-1">
                        {{-- <span class="uppercase-font weight-500 font-14 block text-center txt-dark">customer satisfaction</span> --}}
                        <div class="cus-sat-stat weight-500 txt-primary text-center mt-5 model_img img-responsive no-underline job-list" alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s50" data-status="all"">
                            <span class="counter-anim">100</span>
                            {{-- <span>%</span> --}}
                        </div>
                        <div class="progress-anim mt-20">
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary wow animated progress-animated" role="progressbar"
                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <ul class="flex-stat mt-5">
                            <li class="model_img img-responsive no-underline job-list" alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s50" data-status="pending">
                                <span class="block">Pending</span>
                                {{-- <span class="block weight-500 txt-dark font-15">30</span> --}}
                                <span class="block weight-500 txt-dark font-15">30</span>
                            </li>
                            <li class="model_img img-responsive no-underline job-list" alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s50" data-status="wip">
                                <span class="block">Work in progress</span>
                                {{-- <span class="block weight-500 txt-dark font-15">5</span> --}}
                                <span class="block weight-500 txt-dark font-15">5</span>
                            </li>
                            <li class="model_img img-responsive no-underline job-list" alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s50" data-status="completed">
                                <span class="block">Completed</span>
                                {{-- <span class="block weight-500 txt-dark font-15">15</span> --}}
                                <span class="block weight-500 txt-dark font-15">15</span>
                                {{-- <span class="block">
                                                    <i class="zmdi zmdi-trending-up txt-dark font-20"></i>
                                                </span> --}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h2 class="txt-dark">S100</h2>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body sm-data-box-1">
                        {{-- <span class="uppercase-font weight-500 font-14 block text-center txt-dark">customer satisfaction</span> --}}
                        <div class="cus-sat-stat weight-500 txt-primary text-center mt-5model_img img-responsive no-underline job-list" alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s100" data-status="all">
                            <span class="counter-anim">100</span>
                            {{-- <span>%</span> --}}
                        </div>
                        <div class="progress-anim mt-20">
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary wow animated progress-animated" role="progressbar"
                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <ul class="flex-stat mt-5">
                            <li class="model_img img-responsive no-underline job-list" alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s100" data-status="pending">
                                <span class="block">Pending</span>
                                {{-- <span class="block weight-500 txt-dark font-15">30</span> --}}
                                <span class="block weight-500 txt-dark font-15">30</span>
                            </li>
                            <li class="model_img img-responsive no-underline job-list" alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s100" data-status="wip">
                                <span class="block">Work in progress</span>
                                {{-- <span class="block weight-500 txt-dark font-15">5</span> --}}
                                <span class="block weight-500 txt-dark font-15">5</span>
                            </li>
                            <li class="model_img img-responsive no-underline job-list" alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s100" data-status="completed">
                                <span class="block">Completed</span>
                                {{-- <span class="block weight-500 txt-dark font-15">15</span> --}}
                                <span class="block weight-500 txt-dark font-15">15</span>
                                {{-- <span class="block">
                                                    <i class="zmdi zmdi-trending-up txt-dark font-20"></i>
                                                </span> --}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h2 class="txt-dark">S200</h2>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body sm-data-box-1">
                        {{-- <span class="uppercase-font weight-500 font-14 block text-center txt-dark">customer satisfaction</span> --}}
                        <div class="cus-sat-stat weight-500 txt-primary text-center mt-5model_img img-responsive no-underline job-list" alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s200" data-status="all">
                            <span class="counter-anim model_img img-responsive no-underline job-list" alt="default" data-toggle="modal"
                                data-url="{{ route('job-list') }}" data-stage="s200" data-status="all">100</span>
                            {{-- <span>%</span> --}}
                        </div>
                        <div class="progress-anim mt-20">
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary wow animated progress-animated" role="progressbar"
                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <ul class="flex-stat mt-5">
                            <li class="model_img img-responsive no-underline job-list" alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s200" data-status="pending">
                                <span class="block">Pending</span>
                                {{-- <span class="block weight-500 txt-dark font-15">30</span> --}}
                                <span class="block weight-500 txt-dark font-15">30</span>
                            </li>
                            <li class="model_img img-responsive no-underline job-list" alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s200" data-status="wip">
                                <span class="block">Work in progress</span>
                                {{-- <span class="block weight-500 txt-dark font-15">5</span> --}}
                                <span class="block weight-500 txt-dark font-15">5</span>
                            </li>
                            <li class="model_img img-responsive no-underline job-list" alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s200" data-status="completed">
                                <span class="block">Completed</span>
                                {{-- <span class="block weight-500 txt-dark font-15">15</span> --}}
                                <span class="block weight-500 txt-dark font-15">15</span>
                                {{-- <span class="block">
                                                    <i class="zmdi zmdi-trending-up txt-dark font-20"></i>
                                                </span> --}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->

    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h2 class="txt-dark">S300</h2>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body sm-data-box-1">
                        {{-- <span class="uppercase-font weight-500 font-14 block text-center txt-dark">customer satisfaction</span> --}}
                        <div class="cus-sat-stat weight-500 txt-primary text-center mt-5">
                            <span class="counter-anim model_img img-responsive no-underline job-list" alt="default" data-toggle="modal"
                                data-url="{{ route('job-list') }}" data-stage="s300" data-status="all">100</span>
                            {{-- <span>%</span> --}}
                        </div>
                        <div class="progress-anim mt-20">
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary wow animated progress-animated" role="progressbar"
                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <ul class="flex-stat mt-5">
                            <li>
                                <span class="block">Pending</span>
                                {{-- <span class="block weight-500 txt-dark font-15">30</span> --}}
                                <span class="block weight-500 txt-dark font-15 model_img img-responsive no-underline job-list"
                                    alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s300"
                                    data-status="pending">30</span>
                            </li>
                            <li>
                                <span class="block">Work in progress</span>
                                {{-- <span class="block weight-500 txt-dark font-15">5</span> --}}
                                <span class="block weight-500 txt-dark font-15 model_img img-responsive no-underline job-list"
                                    alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s300"
                                    data-status="wip">5</span>
                            </li>
                            <li>
                                <span class="block">Completed</span>
                                {{-- <span class="block weight-500 txt-dark font-15">15</span> --}}
                                <span class="block weight-500 txt-dark font-15 model_img img-responsive no-underline job-list"
                                    alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s300"
                                    data-status="completed">15</span>
                                {{-- <span class="block">
                                                    <i class="zmdi zmdi-trending-up txt-dark font-20"></i>
                                                </span> --}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h2 class="txt-dark">S500</h2>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body sm-data-box-1">
                        {{-- <span class="uppercase-font weight-500 font-14 block text-center txt-dark">customer satisfaction</span> --}}
                        <div class="cus-sat-stat weight-500 txt-primary text-center mt-5">
                            <span class="counter-anim model_img img-responsive no-underline job-list" alt="default" data-toggle="modal"
                                data-url="{{ route('job-list') }}" data-stage="s500" data-status="all">100</span>
                            {{-- <span>%</span> --}}
                        </div>
                        <div class="progress-anim mt-20">
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary wow animated progress-animated" role="progressbar"
                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <ul class="flex-stat mt-5">
                            <li>
                                <span class="block">Pending</span>
                                {{-- <span class="block weight-500 txt-dark font-15">30</span> --}}
                                <span class="block weight-500 txt-dark font-15 model_img img-responsive no-underline job-list"
                                    alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s500"
                                    data-status="pending">30</span>
                            </li>
                            <li>
                                <span class="block">Work in progress</span>
                                {{-- <span class="block weight-500 txt-dark font-15">5</span> --}}
                                <span class="block weight-500 txt-dark font-15 model_img img-responsive no-underline job-list"
                                    alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s500"
                                    data-status="wip">5</span>
                            </li>
                            <li>
                                <span class="block">Completed</span>
                                {{-- <span class="block weight-500 txt-dark font-15">15</span> --}}
                                <span class="block weight-500 txt-dark font-15 model_img img-responsive no-underline job-list"
                                    alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s500"
                                    data-status="completed">15</span>
                                {{-- <span class="block">
                                                    <i class="zmdi zmdi-trending-up txt-dark font-20"></i>
                                                </span> --}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h2 class="txt-dark">S600</h2>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body sm-data-box-1">
                        {{-- <span class="uppercase-font weight-500 font-14 block text-center txt-dark">customer satisfaction</span> --}}
                        <div class="cus-sat-stat weight-500 txt-primary text-center mt-5">
                            <span class="counter-anim model_img img-responsive no-underline job-list" alt="default" data-toggle="modal"
                                data-url="{{ route('job-list') }}" data-stage="s600" data-status="all">100</span>
                            {{-- <span>%</span> --}}
                        </div>
                        <div class="progress-anim mt-20">
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary wow animated progress-animated" role="progressbar"
                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <ul class="flex-stat mt-5">
                            <li>
                                <span class="block">Pending</span>
                                {{-- <span class="block weight-500 txt-dark font-15">30</span> --}}
                                <span class="block weight-500 txt-dark font-15 model_img img-responsive no-underline job-list"
                                    alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s600"
                                    data-status="pending">30</span>
                            </li>
                            <li>
                                <span class="block">Work in progress</span>
                                {{-- <span class="block weight-500 txt-dark font-15">5</span> --}}
                                <span class="block weight-500 txt-dark font-15 model_img img-responsive no-underline job-list"
                                    alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s600"
                                    data-status="wip">5</span>
                            </li>
                            <li>
                                <span class="block">Completed</span>
                                {{-- <span class="block weight-500 txt-dark font-15">15</span> --}}
                                <span class="block weight-500 txt-dark font-15 model_img img-responsive no-underline job-list"
                                    alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s600"
                                    data-status="completed">15</span>
                                {{-- <span class="block">
                                                    <i class="zmdi zmdi-trending-up txt-dark font-20"></i>
                                                </span> --}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h2 class="txt-dark">S650</h2>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body sm-data-box-1">
                        {{-- <span class="uppercase-font weight-500 font-14 block text-center txt-dark">customer satisfaction</span> --}}
                        <div class="cus-sat-stat weight-500 txt-primary text-center mt-5">
                            <span class="counter-anim model_img img-responsive no-underline job-list" alt="default" data-toggle="modal"
                                data-url="{{ route('job-list') }}" data-stage="s650" data-status="all">100</span>
                            {{-- <span>%</span> --}}
                        </div>
                        <div class="progress-anim mt-20">
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary wow animated progress-animated" role="progressbar"
                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <ul class="flex-stat mt-5">
                            <li>
                                <span class="block">Pending</span>
                                {{-- <span class="block weight-500 txt-dark font-15">30</span> --}}
                                <span class="block weight-500 txt-dark font-15 model_img img-responsive no-underline job-list"
                                    alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s650"
                                    data-status="pending">30</span>
                            </li>
                            <li>
                                <span class="block">Work in progress</span>
                                {{-- <span class="block weight-500 txt-dark font-15">5</span> --}}
                                <span class="block weight-500 txt-dark font-15 model_img img-responsive no-underline job-list"
                                    alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s650"
                                    data-status="wip">5</span>
                            </li>
                            <li>
                                <span class="block">Completed</span>
                                {{-- <span class="block weight-500 txt-dark font-15">15</span> --}}
                                <span class="block weight-500 txt-dark font-15 model_img img-responsive no-underline job-list"
                                    alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="s650"
                                    data-status="completed">15</span>
                                {{-- <span class="block">
                                                    <i class="zmdi zmdi-trending-up txt-dark font-20"></i>
                                                </span> --}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->

    <!-- Row -->
    {{-- <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                        <span class="txt-dark block counter"><span
                                                class="counter-anim">914,001</span></span>
                                        <span class="weight-500 uppercase-font block font-13">visits</span>
                                    </div>
                                    <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                        <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                        <span class="txt-dark block counter"><span class="counter-anim">46.43</span>%</span>
                                        <span class="weight-500 uppercase-font block">growth rate</span>
                                    </div>
                                    <div class="col-xs-6 text-center  pl-0 pr-0 pt-25  data-wrap-right">
                                        <div class="sp-small-chart" id="sparkline_4"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                        <span class="txt-dark block counter"><span class="counter-anim">46.41</span>%</span>
                                        <span class="weight-500 uppercase-font block">bounce rate</span>
                                    </div>
                                    <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                        <i class="icon-control-rewind data-right-rep-icon txt-light-grey"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                        <span class="txt-dark block counter"><span
                                                class="counter-anim">4,054,876</span></span>
                                        <span class="weight-500 uppercase-font block">pageviews</span>
                                    </div>
                                    <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                        <i class="icon-layers data-right-rep-icon txt-light-grey"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- /Row -->

    <!-- Row -->
    {{-- <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default card-view panel-refresh">
                <div class="refresh-container">
                    <div class="la-anim-1"></div>
                </div>
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Stakeholders</h6>
                    </div>
                    <div class="pull-right">
                        <a href="#" class="pull-left inline-block refresh mr-15">
                            <i class="zmdi zmdi-replay"></i>
                        </a>
                        <a href="#" class="pull-left inline-block full-screen mr-15">
                            <i class="zmdi zmdi-fullscreen"></i>
                        </a>
                        <div class="pull-left inline-block dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"
                                role="button"><i class="zmdi zmdi-more-vert"></i></a>
                            <ul class="dropdown-menu bullet dropdown-menu-right" role="menu">
                                <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i
                                            class="icon wb-reply" aria-hidden="true"></i>Edit</a></li>
                                <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i
                                            class="icon wb-share" aria-hidden="true"></i>Delete</a></li>
                                <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i
                                            class="icon wb-trash" aria-hidden="true"></i>New</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body row pa-0">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table class="table display product-overview border-none" id="support_table">
                                    <thead>
                                        <tr>
                                            <th>ticket ID</th>
                                            <th>Customer</th>
                                            <th>issue</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>#85457898</td>
                                            <td>Jens Brincker</td>
                                            <td>Goofy chart</td>
                                            <td>Oct 27</td>
                                            <td>
                                                <span class="label label-success">done</span>
                                            </td>
                                            <td><a href="javascript:void(0)" class="pr-10" data-toggle="tooltip" title="completed"><i
                                                        class="zmdi zmdi-check"></i></a> <a href="javascript:void(0)"
                                                    class="text-inverse" title="Delete" data-toggle="tooltip"><i
                                                        class="zmdi zmdi-delete"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>#85457897</td>
                                            <td>Mark Hay</td>
                                            <td>PSD resolution</td>
                                            <td>Oct 26</td>
                                            <td>
                                                <span class="label label-warning ">Pending</span>
                                            </td>
                                            <td><a href="javascript:void(0)" class="pr-10" data-toggle="tooltip" title="completed"><i
                                                        class="zmdi zmdi-check"></i></a> <a href="javascript:void(0)"
                                                    class="text-inverse" title="Delete" data-toggle="tooltip"><i
                                                        class="zmdi zmdi-delete"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>#85457896</td>
                                            <td>Anthony Davie</td>
                                            <td>Cinnabar</td>
                                            <td>Oct 25</td>
                                            <td>
                                                <span class="label label-success ">done</span>
                                            </td>
                                            <td><a href="javascript:void(0)" class="pr-10" data-toggle="tooltip" title="completed"><i
                                                        class="zmdi zmdi-check"></i></a> <a href="javascript:void(0)"
                                                    class="text-inverse" title="Delete" data-toggle="tooltip"><i
                                                        class="zmdi zmdi-delete"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>#85457895</td>
                                            <td>David Perry</td>
                                            <td>Felix PSD</td>
                                            <td>Oct 25</td>
                                            <td>
                                                <span class="label label-danger">pending</span>
                                            </td>
                                            <td><a href="javascript:void(0)" class="pr-10" data-toggle="tooltip" title="completed"><i
                                                        class="zmdi zmdi-check"></i></a> <a href="javascript:void(0)"
                                                    class="text-inverse" title="Delete" data-toggle="tooltip"><i
                                                        class="zmdi zmdi-delete"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>#85457894</td>
                                            <td>Anthony Davie</td>
                                            <td>Beryl iphone</td>
                                            <td>Oct 25</td>
                                            <td>
                                                <span class="label label-success ">done</span>
                                            </td>
                                            <td><a href="javascript:void(0)" class="pr-10" data-toggle="tooltip" title="completed"><i
                                                        class="zmdi zmdi-check"></i></a> <a href="javascript:void(0)"
                                                    class="text-inverse" title="Delete" data-toggle="tooltip"><i
                                                        class="zmdi zmdi-delete"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>#85457893</td>
                                            <td>Alan Gilchrist</td>
                                            <td>Pogody button</td>
                                            <td>Oct 22</td>
                                            <td>
                                                <span class="label label-warning ">Pending</span>
                                            </td>
                                            <td><a href="javascript:void(0)" class="pr-10" data-toggle="tooltip" title="completed"><i
                                                        class="zmdi zmdi-check"></i></a> <a href="javascript:void(0)"
                                                    class="text-inverse" title="Delete" data-toggle="tooltip"><i
                                                        class="zmdi zmdi-delete"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>#85457892</td>
                                            <td>Mark Hay</td>
                                            <td>Beavis sidebar</td>
                                            <td>Oct 18</td>
                                            <td>
                                                <span class="label label-success ">done</span>
                                            </td>
                                            <td><a href="javascript:void(0)" class="pr-10" data-toggle="tooltip" title="completed"><i
                                                        class="zmdi zmdi-check"></i></a> <a href="javascript:void(0)"
                                                    class="text-inverse" title="Delete" data-toggle="tooltip"><i
                                                        class="zmdi zmdi-delete"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>#85457891</td>
                                            <td>Sue Woodger</td>
                                            <td>Pogody header</td>
                                            <td>Oct 17</td>
                                            <td>
                                                <span class="label label-danger">pending</span>
                                            </td>
                                            <td><a href="javascript:void(0)" class="pr-10" data-toggle="tooltip" title="completed"><i
                                                        class="zmdi zmdi-check"></i></a> <a href="javascript:void(0)"
                                                    class="text-inverse" title="Delete" data-toggle="tooltip"><i
                                                        class="zmdi zmdi-delete"></i></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Row -->
</div>
<!-- /Main Content -->
@endsection
