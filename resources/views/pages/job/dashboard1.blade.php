@extends('layouts.default')

@push('css')
<!-- Custom CSS -->
<link href="{{ asset('public/css/custom/css/custom.css') }}" rel="stylesheet">
@endpush

@section('content')
<!-- Main Content -->
<div class="container-fluid pt-25">
    <?php 
        $previoustUrl = Session::get('previousUrl');
        $r = explode('/', $previoustUrl);
        if(count($r) > 2) {

            $previousUrlIsJobDetail = $r[count($r)-2];
        }

        $redirectToDashboard = $jobsData['redirectToDashboard'];

        // $redirectToDashboard = isset($jobsData['redirectToDashboard'])?'true':'false';

    ?>
    <!-- Row -->
    {{-- <div class="row" id="job-list-data" data-dashboard-job-stage="{{ $_session['data_dashboard_job_stage'] }}"
    data-dashboard-job-status="{{ $_session['data_dashboard_job_status'] }}" > --}}

    {{-- <div class="row" id="job-list-data" data-dashboard-job-stage="{{ Session::get('data_dashboard_job_stage') }}"
    data-dashboard-job-status="{{ Session::get('data_dashboard_job_status') }}"
    data-job-list-url="{{ route('job-list') }}" data-job-detail-base-url="{{ route('job') }}"
    data-redirect-to-dashboard="{{ $redirectToDashboard }}"> --}}

    <div id="job-list-data"
        data-dashboard-job-stage="{{ Session::get('data_dashboard_job_stage') }}"
        data-dashboard-job-status="{{ Session::get('data_dashboard_job_status') }}"
        data-job-list-url="{{ route('job-list') }}" data-delayed-job-list-url="{{ route('delayed-job-list') }}" data-job-detail-base-url="{{ route('job') }}"
        data-redirect-to-dashboard="{{ $redirectToDashboard }}">

        <!-- Row -->
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <div class="pills-struct">
                                <ul role="tablist" class="nav nav-pills nav-pills-outline" id="myTabs_7">
                                    <li class="active" role="presentation"><a aria-expanded="true" data-toggle="tab" role="tab" id="overviewTab"
                                            href="#overview">{{ __('dashboard.overview_tab_label') }}</a></li>
                                    <li role="presentation" class=""><a data-toggle="tab" id="stageTab" role="tab" href="#stage"
                                            aria-expanded="false">{{ __('dashboard.stage_tab_label') }}</a></li>
                                    <li role="presentation" class=""><a data-toggle="tab" id="teamTab" role="tab" href="#team"
                                            aria-expanded="false">{{ __('dashboard.team_tab_label') }}</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="pull-right">
                            <a href="#" class="pull-left inline-block full-screen mr-15">
                                <i class="zmdi zmdi-fullscreen job-status-i"></i>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="pills-struct">
                                <div class="tab-content" id="myTabContent_7">
                                    <div id="overview" class="tab-pane fade active in" role="tabpanel">
                                        <!-- Row -->
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                                <div class="panel panel-default card-view pa-0">
                                                    <div class="panel-wrapper collapse in">
                                                        <div class="panel-body pa-0">
                                                            <div class="sm-data-box">
                                                                <div class="container-fluid">
                                                                    <div class="row job-list" data-toggle="modal" data-stage="{{ __('dashboard.all_job_text') }}"
                                                                data-status="{{ __('dashboard.new_job_text') }}">
                                                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                                            <span class="txt-dark block counter"><span
                                                                                    class="counter-anim">10</span></span>
                                                                            <span class="weight-500 uppercase-font block font-13">{{ __('dashboard.new_job_label') }}</span>
                                                                        </div>
                                                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                                            <i class="icon-layers data-right-rep-icon txt-purple"></i>
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
                                                                    <div class="row job-list" data-toggle="modal" data-stage="all"
                                                                data-status="wip">
                                                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                                            <span class="txt-dark block counter"><span
                                                                                    class="counter-anim">5</span></span>
                                                                            <span class="weight-500 uppercase-font block">{{ __('dashboard.on_track_job_label') }}</span>
                                                                        </div>
                                                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                                            <i class="icon-graph data-right-rep-icon txt-navi-blue"></i>
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
                                                                    <div class="row job-list" data-toggle="modal" data-stage="{{ __('dashboard.all_job_text') }}"
                                                                data-status="{{ __('dashboard.delay_job_text') }}">
                                                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                                            <span class="txt-dark block counter"><span
                                                                                    class="counter-anim">3</span></span>
                                                                            <span class="weight-500 uppercase-font block">{{ __('dashboard.delay_job_label') }}</span>
                                                                        </div>
                                                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                                            <i class="fa fa-exclamation-triangle data-right-rep-icon text-danger"></i>
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
                                                                    <div class="row job-list" data-toggle="modal" data-stage="{{ __('dashboard.all_job_text') }}"
                                                                data-status="{{ __('dashboard.hold_job_text') }}">
                                                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                                            <span class="txt-dark block counter"><span
                                                                                    class="counter-anim">2</span></span>
                                                                            <span class="weight-500 uppercase-font block">{{ __('dashboard.hold_job_label') }}</span>
                                                                        </div>
                                                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                                            <i class="fa fa-lock data-right-rep-icon txt-warning"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Row -->

                                        <!-- Row -->
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                                <div class="panel panel-default card-view pa-0">
                                                    <div class="panel-wrapper collapse in">
                                                        <div class="panel-body pa-0">
                                                            <div class="sm-data-box">
                                                                <div class="container-fluid">
                                                                    <div class="row job-list" data-toggle="modal" data-stage="{{ __('dashboard.all_job_text') }}" data-status="{{ __('dashboard.in_hand_job_text') }}">
                                                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                                            <span class="txt-dark block counter"><span class="counter-anim">5</span></span>
                                                                            <span
                                                                                class="weight-500 uppercase-font block">{{ __('dashboard.jobs_in_hand_label') }}</span>
                                                                        </div>
                                                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                                            <i class="fa fa-cubes data-right-rep-icon txt-primary"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                                <div class="panel panel-default card-view pa-0">
                                                    <div class="panel-wrapper collapse in">
                                                        <div class="panel-body pa-0">
                                                            <div class="sm-data-box">
                                                                <div class="container-fluid">
                                                                    <div class="row job-list" data-toggle="modal" data-stage="{{ __('dashboard.all_job_text') }}" data-status="{{ __('dashboard.escalation_job_text') }}">
                                                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                                            <span class="txt-dark block counter"><span class="counter-anim">3</span></span>
                                                                            <span
                                                                                class="weight-500 uppercase-font block">{{ __('dashboard.escalation_job_label') }}</span>
                                                                        </div>
                                                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                                            <i class="glyphicon glyphicon-fire data-right-rep-icon txt-orange"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                                <div class="panel panel-default card-view pa-0">
                                                    <div class="panel-wrapper collapse in">
                                                        <div class="panel-body pa-0">
                                                            <div class="sm-data-box">
                                                                <div class="container-fluid">
                                                                    <div class="row job-list" data-toggle="modal" data-stage="{{ __('dashboard.all_job_text') }}" data-status="{{ __('dashboard.completed_job_text') }}">
                                                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                                            <span class="txt-dark block counter"><span class="counter-anim">2</span></span>
                                                                            <span
                                                                                class="weight-500 uppercase-font block">{{ __('dashboard.completed_job_label') }}</span>
                                                                        </div>
                                                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                                            <i class="fa fa-graduation-cap data-right-rep-icon txt-success"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Row -->
                            
                                        <!-- Row -->
                                        <div class="row pt-15">
                                            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                                                <div class="panel panel-default card-view panel-refresh">
                                                    <div class="refresh-container">
                                                        <div class="la-anim-1"></div>
                                                    </div>
                                                    <div class="panel-heading">
                                                        <div class="pull-left">
                                                            <h6 class="panel-title txt-dark">{{ __('dashboard.graph_label') }}</h6>
                                                        </div>
                                                        <div class="pull-right">
                                                            <a href="#" class="pull-left inline-block full-screen mr-15">
                                                                <i class="zmdi zmdi-fullscreen"></i>
                                                            </a>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="panel-wrapper collapse in">
                                                        <div id="e_chart_1" class="" style="height:338px;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                                <div class="panel panel-default border-panel card-view">
                                                    <div class="panel-heading">
                                                        <div class="pull-left">
                                                            <h6 class="panel-title txt-dark">{{ __('dashboard.recent_activity_label') }}</h6>
                                                        </div>
                                                        {{-- <a class="txt-danger pull-right right-float-sub-text inline-block"
                                                            href="javascript:void(0)"> clear
                                                            all
                                                        </a> --}}
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="panel-wrapper dashboard-recent-activity task-panel collapse in">
                                                        <div class="panel-body row pa-0">
                                                            <div class="list-group mb-0">
                                                                <a href="#" class="list-group-item">
                                                                    <span class="badge transparent-badge badge-info capitalize-font">just
                                                                        now</span>
                                                                    <i class="zmdi zmdi-calendar-check pull-left"></i>
                                                                    <p class="pull-left">Calendar updated</p>
                                                                    <div class="clearfix"></div>
                                                                </a>
                                                                <a href="#" class="list-group-item">
                                                                    <span class="badge transparent-badge badge-success capitalize-font">4
                                                                        min</span>
                                                                    <i class="zmdi zmdi-comment-alert pull-left"></i>
                                                                    <p class=" pull-left">Commented on a post</p>
                                                                    <div class="clearfix"></div>
                                                                </a>
                                                                <a href="#" class="list-group-item">
                                                                    <span class="badge transparent-badge badge-warning capitalize-font">23
                                                                        min </span>
                                                                    <i class="zmdi zmdi-truck pull-left"></i>
                                                                    <p class=" pull-left">Order 392 shipped</p>
                                                                    <div class="clearfix"></div>
                                                                </a>
                                                                <a href="#" class="list-group-item">
                                                                    <span class="badge transparent-badge badge-success capitalize-font">46
                                                                        min</span>
                                                                    <i class="zmdi zmdi-money pull-left"></i>
                                                                    <p class=" pull-left">Invoice 653 has been paid
                                                                    </p>
                                                                    <div class="clearfix"></div>
                                                                </a>
                                                                <a href="#" class="list-group-item">
                                                                    <span class="badge transparent-badge badge-danger capitalize-font">1
                                                                        hr</span>
                                                                    <i class="zmdi zmdi-account pull-left"></i>
                                                                    <p class="pull-left">A new user has been added
                                                                    </p>
                                                                    <div class="clearfix"></div>
                                                                </a>
                                                                <a href="#" class="list-group-item">
                                                                    <span class="badge transparent-badge badge-warning capitalize-font">just
                                                                        now</span>
                                                                    <i class="zmdi zmdi-picture-in-picture pull-left"></i>
                                                                    <p class=" pull-left">Finance report has been
                                                                        released</p>
                                                                    <div class="clearfix"></div>
                                                                </a>
                                                                <a href="#" class="list-group-item">
                                                                    <span class="badge transparent-badge badge-success capitalize-font">1
                                                                        hr</span>
                                                                    <i class="zmdi zmdi-device-hub pull-left"></i>
                                                                    <p class="pull-left">Web server hardware updated
                                                                    </p>
                                                                    <div class="clearfix"></div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Row -->
                            
                                        <!-- Row -->
                                        <div class="row pt-15">
                                            <div class="col-lg-12 col-md-12 col-xs-12">
                                                <div class="panel panel-default card-view panel-refresh">
                                                    {{-- <div class="refresh-container">
                                                        <div class="la-anim-1"></div>
                                                    </div> --}}
                                                    <div class="panel-heading">
                                                        <div class="pull-left">
                                                            <h6 class="panel-title txt-dark">{{ __('dashboard.job_list_label') }}</h6>
                                                        </div>
                                                        <div class="pull-right">
                                                            <a href="#" class="pull-left inline-block full-screen mr-15">
                                                                <i class="zmdi zmdi-fullscreen job-status-i"></i>
                                                            </a>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="panel-wrapper collapse in">
                                                        <div class="panel-body row pa-0">
                                                            <div id="delayedJobList"> </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Row -->
                            
                                    </div>
                                    <div id="stage" class="tab-pane fade" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                                <div class="panel panel-default card-view">
                                                    <div class="panel-heading">
                                                        <div class="pull-left">
                                                            <h2 class="txt-dark text-capitalize">{{ __('dashboard.s5_job_label') }}</h2>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="profile-box panel-wrapper collapse in">
                                                        <div class="panel-body sm-data-box-1">
                                                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5 model_img img-responsive no-underline job-list"
                                                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s5_job_text') }}"
                                                                data-status="{{ __('dashboard.all_job_text') }}">
                                                                <span class="counter-anim">{{ $jobsData['total'] }}</span>
                                                            </div>
                                                            <div class="social-info border-none">
                                                                <div class="row">
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim" alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s5_job_text') }}" data-status="{{ __('dashboard.on_track_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-navi-blue"></i>
                                                                        <span class="counts block head-font btn-text"><span class="counter-anim">{{ $jobsData['pending'] }}</span></span>
                                                                        <span class="counts-text block btn-text txt-navi-blue">{{ __('dashboard.on_track_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s5_job_text') }}"
                                                                        data-status="{{ __('dashboard.delay_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-danger"></i>
                                                                        <span class="counts block head-font btn-text"><span class="counter-anim">{{ $jobsData['wip'] }}</span></span>
                                                                        <span class="counts-text block btn-text text-danger">{{ __('dashboard.delay_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s5_job_text') }}" data-status="{{ __('dashboard.hold_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-warning"></i>
                                                                        <span class="counts block head-font btn-text"><span class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span class="counts-text block btn-text text-warning">{{ __('dashboard.hold_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s5_job_text') }}"
                                                                        data-status="{{ __('dashboard.escalation_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-orange"></i>
                                                                        <span class="counts block head-font btn-text"><span class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span class="counts-text block btn-text txt-orange">{{ __('dashboard.escalation_job_label') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                                <div class="panel panel-default card-view">
                                                    <div class="panel-heading">
                                                        <div class="pull-left">
                                                            <h2 class="txt-dark text-capitalize">{{ __('dashboard.s50_job_label') }}</h2>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="profile-box panel-wrapper collapse in">
                                                        <div class="panel-body sm-data-box-1">
                                                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5 model_img img-responsive no-underline job-list"
                                                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s50_job_text') }}"
                                                                data-status="{{ __('dashboard.all_job_text') }}">
                                                                <span class="counter-anim">{{ $jobsData['total'] }}</span>
                                                            </div>
                                                            <div class="social-info border-none">
                                                                <div class="row">
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s50_job_text') }}"
                                                                        data-status="{{ __('dashboard.on_track_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-navi-blue"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['pending'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text txt-navi-blue">{{ __('dashboard.on_track_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s50_job_text') }}"
                                                                        data-status="{{ __('dashboard.delay_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-danger"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['wip'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text text-danger">{{ __('dashboard.delay_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s50_job_text') }}"
                                                                        data-status="{{ __('dashboard.hold_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-warning"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text text-warning">{{ __('dashboard.hold_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s50_job_text') }}"
                                                                        data-status="{{ __('dashboard.escalation_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-orange"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text txt-orange">{{ __('dashboard.escalation_job_label') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                                <div class="panel panel-default card-view">
                                                    <div class="panel-heading">
                                                        <div class="pull-left">
                                                            <h2 class="txt-dark text-capitalize">{{ __('dashboard.s200_job_label') }}</h2>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="profile-box panel-wrapper collapse in">
                                                        <div class="panel-body sm-data-box-1">
                                                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5 model_img img-responsive no-underline job-list"
                                                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s200_job_text') }}"
                                                                data-status="{{ __('dashboard.all_job_text') }}">
                                                                <span class="counter-anim">{{ $jobsData['total'] }}</span>
                                                            </div>
                                                            <div class="social-info border-none">
                                                                <div class="row">
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s200_job_text') }}"
                                                                        data-status="{{ __('dashboard.on_track_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-navi-blue"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['pending'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text txt-navi-blue">{{ __('dashboard.on_track_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s200_job_text') }}"
                                                                        data-status="{{ __('dashboard.delay_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-danger"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['wip'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text text-danger">{{ __('dashboard.delay_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s200_job_text') }}"
                                                                        data-status="{{ __('dashboard.hold_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-warning"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text text-warning">{{ __('dashboard.hold_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s200_job_text') }}"
                                                                        data-status="{{ __('dashboard.escalation_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-orange"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text txt-orange">{{ __('dashboard.escalation_job_label') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Row -->
                            
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                                <div class="panel panel-default card-view">
                                                    <div class="panel-heading">
                                                        <div class="pull-left">
                                                            <h2 class="txt-dark text-capitalize">{{ __('dashboard.s300_job_label') }}</h2>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="profile-box panel-wrapper collapse in">
                                                        <div class="panel-body sm-data-box-1">
                                                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5 model_img img-responsive no-underline job-list"
                                                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s300_job_text') }}"
                                                                data-status="{{ __('dashboard.all_job_text') }}">
                                                                <span class="counter-anim">{{ $jobsData['total'] }}</span>
                                                            </div>
                                                            <div class="social-info border-none">
                                                                <div class="row">
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s300_job_text') }}"
                                                                        data-status="{{ __('dashboard.on_track_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-navi-blue"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['pending'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text txt-navi-blue">{{ __('dashboard.on_track_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s300_job_text') }}"
                                                                        data-status="{{ __('dashboard.delay_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-danger"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['wip'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text text-danger">{{ __('dashboard.delay_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s300_job_text') }}"
                                                                        data-status="{{ __('dashboard.hold_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-warning"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text text-warning">{{ __('dashboard.hold_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s300_job_text') }}"
                                                                        data-status="{{ __('dashboard.escalation_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-orange"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text txt-orange">{{ __('dashboard.escalation_job_label') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                                <div class="panel panel-default card-view">
                                                    <div class="panel-heading">
                                                        <div class="pull-left">
                                                            <h2 class="txt-dark text-capitalize">{{ __('dashboard.s600_job_label') }}</h2>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="profile-box panel-wrapper collapse in">
                                                        <div class="panel-body sm-data-box-1">
                                                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5 model_img img-responsive no-underline job-list"
                                                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s600_job_text') }}"
                                                                data-status="{{ __('dashboard.all_job_text') }}">
                                                                <span class="counter-anim">{{ $jobsData['total'] }}</span>
                                                            </div>
                                                            <div class="social-info border-none">
                                                                <div class="row">
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s600_job_text') }}"
                                                                        data-status="{{ __('dashboard.on_track_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-navi-blue"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['pending'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text txt-navi-blue">{{ __('dashboard.on_track_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s600_job_text') }}"
                                                                        data-status="{{ __('dashboard.delay_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-danger"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['wip'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text text-danger">{{ __('dashboard.delay_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s600_job_text') }}"
                                                                        data-status="{{ __('dashboard.hold_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-warning"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text text-warning">{{ __('dashboard.hold_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s600_job_text') }}"
                                                                        data-status="{{ __('dashboard.escalation_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-orange"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text txt-orange">{{ __('dashboard.escalation_job_label') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                                <div class="panel panel-default card-view">
                                                    <div class="panel-heading">
                                                        <div class="pull-left">
                                                            <h2 class="txt-dark text-capitalize">{{ __('dashboard.s650_job_label') }}</h2>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="profile-box panel-wrapper collapse in">
                                                        <div class="panel-body sm-data-box-1">
                                                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5 model_img img-responsive no-underline job-list"
                                                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s650_job_text') }}"
                                                                data-status="{{ __('dashboard.all_job_text') }}">
                                                                <span class="counter-anim">{{ $jobsData['total'] }}</span>
                                                            </div>
                                                            <div class="social-info border-none">
                                                                <div class="row">
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s650_job_text') }}"
                                                                        data-status="{{ __('dashboard.on_track_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-navi-blue"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['pending'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text txt-navi-blue">{{ __('dashboard.on_track_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s650_job_text') }}"
                                                                        data-status="{{ __('dashboard.delay_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-danger"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['wip'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text text-danger">{{ __('dashboard.delay_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s650_job_text') }}"
                                                                        data-status="{{ __('dashboard.hold_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-warning"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text text-warning">{{ __('dashboard.hold_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s650_job_text') }}"
                                                                        data-status="{{ __('dashboard.escalation_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-orange"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text txt-orange">{{ __('dashboard.escalation_job_label') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Row -->
                                    </div>
                                    <div id="team" class="tab-pane fade" role="tabpanel">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                                <div class="panel panel-default card-view">
                                                    <div class="panel-heading">
                                                        <div class="pull-left">
                                                            <h2 class="txt-dark text-capitalize">{{ __('dashboard.logistics_team_label') }}</h2>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="profile-box panel-wrapper collapse in">
                                                        <div class="panel-body sm-data-box-1">
                                                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5 model_img img-responsive no-underline job-list"
                                                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.logistics_team_text') }}"
                                                                data-status="{{ __('dashboard.all_job_text') }}">
                                                                <span class="counter-anim">{{ $jobsData['total'] }}</span>
                                                            </div>
                                                            <div class="social-info border-none">
                                                                <div class="row">
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.logistics_team_text') }}"
                                                                        data-status="{{ __('dashboard.on_track_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-navi-blue"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['pending'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text txt-navi-blue">{{ __('dashboard.on_track_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.logistics_team_text') }}"
                                                                        data-status="{{ __('dashboard.delay_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-danger"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['wip'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text text-danger">{{ __('dashboard.delay_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.logistics_team_text') }}"
                                                                        data-status="{{ __('dashboard.hold_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-warning"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text text-warning">{{ __('dashboard.hold_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.logistics_team_text') }}"
                                                                        data-status="{{ __('dashboard.escalation_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-orange"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text txt-orange">{{ __('dashboard.escalation_job_label') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                                <div class="panel panel-default card-view">
                                                    <div class="panel-heading">
                                                        <div class="pull-left">
                                                            <h2 class="txt-dark text-capitalize">{{ __('dashboard.copy_editing_team_label') }}</h2>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="profile-box panel-wrapper collapse in">
                                                        <div class="panel-body sm-data-box-1">
                                                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5 model_img img-responsive no-underline job-list"
                                                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.copy_editing_team_text') }}"
                                                                data-status="{{ __('dashboard.all_job_text') }}">
                                                                <span class="counter-anim">{{ $jobsData['total'] }}</span>
                                                            </div>
                                                            <div class="social-info border-none">
                                                                <div class="row">
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.copy_editing_team_text') }}"
                                                                        data-status="{{ __('dashboard.on_track_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-navi-blue"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['pending'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text txt-navi-blue">{{ __('dashboard.on_track_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.copy_editing_team_text') }}"
                                                                        data-status="{{ __('dashboard.delay_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-danger"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['wip'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text text-danger">{{ __('dashboard.delay_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.copy_editing_team_text') }}"
                                                                        data-status="{{ __('dashboard.hold_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-warning"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text text-warning">{{ __('dashboard.hold_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.copy_editing_team_text') }}"
                                                                        data-status="{{ __('dashboard.escalation_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-orange"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text txt-orange">{{ __('dashboard.escalation_job_label') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                                <div class="panel panel-default card-view">
                                                    <div class="panel-heading">
                                                        <div class="pull-left">
                                                            <h2 class="txt-dark text-capitalize">{{ __('dashboard.art_team_label') }}</h2>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="profile-box panel-wrapper collapse in">
                                                        <div class="panel-body sm-data-box-1">
                                                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5 model_img img-responsive no-underline job-list"
                                                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.art_team_text') }}"
                                                                data-status="{{ __('dashboard.all_job_text') }}">
                                                                <span class="counter-anim">{{ $jobsData['total'] }}</span>
                                                            </div>
                                                            <div class="social-info border-none">
                                                                <div class="row">
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.art_team_text') }}"
                                                                        data-status="{{ __('dashboard.on_track_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-navi-blue"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['pending'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text txt-navi-blue">{{ __('dashboard.on_track_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.art_team_text') }}"
                                                                        data-status="{{ __('dashboard.delay_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-danger"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['wip'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text text-danger">{{ __('dashboard.delay_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.art_team_text') }}"
                                                                        data-status="{{ __('dashboard.hold_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-warning"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text text-warning">{{ __('dashboard.hold_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.art_team_text') }}"
                                                                        data-status="{{ __('dashboard.escalation_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-orange"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text txt-orange">{{ __('dashboard.escalation_job_label') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Row -->
                                    
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                                <div class="panel panel-default card-view">
                                                    <div class="panel-heading">
                                                        <div class="pull-left">
                                                            <h2 class="txt-dark text-capitalize">{{ __('dashboard.indexing_team_label') }}</h2>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="profile-box panel-wrapper collapse in">
                                                        <div class="panel-body sm-data-box-1">
                                                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5 model_img img-responsive no-underline job-list"
                                                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.indexing_team_text') }}"
                                                                data-status="{{ __('dashboard.all_job_text') }}">
                                                                <span class="counter-anim">{{ $jobsData['total'] }}</span>
                                                            </div>
                                                            <div class="social-info border-none">
                                                                <div class="row">
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.indexing_team_text') }}"
                                                                        data-status="{{ __('dashboard.on_track_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-navi-blue"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['pending'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text txt-navi-blue">{{ __('dashboard.on_track_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.indexing_team_text') }}"
                                                                        data-status="{{ __('dashboard.delay_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-danger"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['wip'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text text-danger">{{ __('dashboard.delay_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.indexing_team_text') }}"
                                                                        data-status="{{ __('dashboard.hold_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-warning"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text text-warning">{{ __('dashboard.hold_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.indexing_team_text') }}"
                                                                        data-status="{{ __('dashboard.escalation_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-orange"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text txt-orange">{{ __('dashboard.escalation_job_label') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                                <div class="panel panel-default card-view">
                                                    <div class="panel-heading">
                                                        <div class="pull-left">
                                                            <h2 class="txt-dark text-capitalize">{{ __('dashboard.production_team_label') }}</h2>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="profile-box panel-wrapper collapse in">
                                                        <div class="panel-body sm-data-box-1">
                                                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5 model_img img-responsive no-underline job-list"
                                                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.production_team_text') }}"
                                                                data-status="{{ __('dashboard.all_job_text') }}">
                                                                <span class="counter-anim">{{ $jobsData['total'] }}</span>
                                                            </div>
                                                            <div class="social-info border-none">
                                                                <div class="row">
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.production_team_text') }}"
                                                                        data-status="{{ __('dashboard.on_track_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-navi-blue"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['pending'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text txt-navi-blue">{{ __('dashboard.on_track_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.production_team_text') }}"
                                                                        data-status="{{ __('dashboard.delay_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-danger"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['wip'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text text-danger">{{ __('dashboard.delay_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.production_team_text') }}"
                                                                        data-status="{{ __('dashboard.hold_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-warning"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text text-warning">{{ __('dashboard.hold_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.production_team_text') }}"
                                                                        data-status="{{ __('dashboard.escalation_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-orange"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text txt-orange">{{ __('dashboard.escalation_job_label') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                                <div class="panel panel-default card-view">
                                                    <div class="panel-heading">
                                                        <div class="pull-left">
                                                            <h2 class="txt-dark text-capitalize">{{ __('dashboard.packing_team_label') }}</h2>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="profile-box panel-wrapper collapse in">
                                                        <div class="panel-body sm-data-box-1">
                                                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5 model_img img-responsive no-underline job-list"
                                                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.packing_team_text') }}"
                                                                data-status="{{ __('dashboard.all_job_text') }}">
                                                                <span class="counter-anim">{{ $jobsData['total'] }}</span>
                                                            </div>
                                                            <div class="social-info border-none">
                                                                <div class="row">
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.packing_team_text') }}"
                                                                        data-status="{{ __('dashboard.on_track_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-navi-blue"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['pending'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text txt-navi-blue">{{ __('dashboard.on_track_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.packing_team_text') }}"
                                                                        data-status="{{ __('dashboard.delay_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-danger"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['wip'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text text-danger">{{ __('dashboard.delay_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.packing_team_text') }}"
                                                                        data-status="{{ __('dashboard.hold_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon text-warning"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text text-warning">{{ __('dashboard.hold_job_label') }}</span>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                                                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.packing_team_text') }}"
                                                                        data-status="{{ __('dashboard.escalation_job_text') }}">
                                                                        <i class="ti-new-window font-30 data-right-rep-icon txt-orange"></i>
                                                                        <span class="counts block head-font btn-text"><span
                                                                                class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                                                        <span
                                                                            class="counts-text block btn-text txt-orange">{{ __('dashboard.escalation_job_label') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Row -->
                                    </div>
                                </div>
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