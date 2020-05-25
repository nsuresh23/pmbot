@php

if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) {

@endphp

<!-- Row -->
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view pa-0 mb-10">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row job-list" data-toggle="modal" data-type="{{ __('dashboard.in_hand_job_text') }}"
                                data-count="{{ $returnResponse['data'][__('dashboard.in_hand_job_text')]['count'] ?? '0'}}">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <span class="txt-dark block counter">
                                        <span
                                            class="counter-anim">{{ $returnResponse['data'][__('dashboard.in_hand_job_text')]['count'] ?? '0'}}</span></span>
                                    <span class="weight-500 uppercase-font block">{{ __('dashboard.jobs_in_hand_label') }}</span>
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
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view pa-0 mb-10">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row job-list" data-toggle="modal" data-type="{{ __('dashboard.on_track_job_text') }}" data-count="{{ $returnResponse['data'][__('dashboard.on_track_job_text')]['count'] ?? '0'}}">
                                <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6 text-center pa-0 data-wrap-left">
                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 text-center pl-0 pr-0 data-wrap-left">
                                        <span class="txt-dark block counter">
                                            <span
                                                class="counter-anim">{{ $returnResponse['data'][__('dashboard.on_track_job_text')]['count'] ?? '0'}}</span></span>
                                        <span class="weight-500 uppercase-font block">{{ __('dashboard.on_track_job_label') }}</span>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center data-wrap-right">
                                        <i class="icon-graph data-right-rep-icon txt-navi-blue"></i>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 text-center pa-5 data-wrap-right">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 task-box-shadow text-center btn btn-default btn-outline border-none btn-anim">
                                        <i class="font-17 capitalize-font txt-purple">{{ __('dashboard.task_job_label') }}</i>
                                        <span class="counts block head-font btn-text">
                                            <span class="counter-anim font-20">
                                                {{ $returnResponse['data'][__('dashboard.on_track_job_text')]['task_count'] ?? '0'}}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 task-box-shadow mt-5 text-center btn btn-default btn-outline border-none btn-anim">
                                        <i class="font-17 capitalize-font txt-purple">{{ __('dashboard.check_list_job_label') }}</i>
                                        <span class="counts block head-font btn-text">
                                            <span class="counter-anim font-20">
                                                {{ $returnResponse['data'][__('dashboard.on_track_job_text')]['job_checklist_count'] ?? '0'}}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view pa-0 mb-10">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row job-list" data-toggle="modal"
                                data-type="{{ __('dashboard.delay_job_text') }}"
                                data-count="{{ $returnResponse['data'][__('dashboard.delay_job_text')]['count'] ?? '0'}}">
                                <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6 text-center pa-0 data-wrap-left">
                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 text-center pl-0 pr-0 data-wrap-left">
                                        <span class="txt-dark block counter"><span
                                                class="counter-anim">{{ $returnResponse['data'][__('dashboard.delay_job_text')]['count'] ?? '0'}}</span></span>
                                        <span
                                            class="weight-500 uppercase-font block">{{ __('dashboard.delay_job_label') }}</span>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center data-wrap-right">
                                        <i class="fa fa-exclamation-triangle data-right-rep-icon text-danger"></i>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 text-center pa-5 data-wrap-right">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 task-box-shadow text-center btn btn-default btn-outline border-none btn-anim">
                                        <i class="font-17 capitalize-font txt-purple">{{ __('dashboard.task_job_label') }}</i>
                                        <span class="counts block head-font btn-text">
                                            <span class="counter-anim font-20">
                                                {{ $returnResponse['data'][__('dashboard.delay_job_text')]['task_count'] ?? '0'}}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 task-box-shadow mt-5 text-center btn btn-default btn-outline border-none btn-anim">
                                        <i class="font-17 capitalize-font txt-purple">{{ __('dashboard.check_list_job_label') }}</i>
                                        <span class="counts block head-font btn-text">
                                            <span class="counter-anim font-20">
                                                {{ $returnResponse['data'][__('dashboard.delay_job_text')]['job_checklist_count'] ?? '0'}}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view pa-0 mb-10">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row job-list" data-toggle="modal"
                                data-type="{{ __('dashboard.hold_job_text') }}"
                                data-count="{{ $returnResponse['data'][__('dashboard.hold_job_text')]['count'] ?? '0'}}">
                                <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6 text-center pa-0 data-wrap-left">
                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 text-center pl-0 pr-0 data-wrap-left">
                                        <span class="txt-dark block counter"><span
                                                class="counter-anim">{{ $returnResponse['data'][__('dashboard.hold_job_text')]['count'] ?? '0'}}</span></span>
                                        <span
                                            class="weight-500 uppercase-font block">{{ __('dashboard.hold_job_label') }}</span>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center data-wrap-right">
                                        <i class="fa fa-lock data-right-rep-icon txt-warning"></i>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 text-center pa-5 data-wrap-right">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 task-box-shadow text-center btn btn-default btn-outline border-none btn-anim">
                                        <i class="font-17 capitalize-font txt-purple">{{ __('dashboard.task_job_label') }}</i>
                                        <span class="counts block head-font btn-text">
                                            <span class="counter-anim font-20">
                                                {{ $returnResponse['data'][__('dashboard.hold_job_text')]['task_count'] ?? '0'}}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 task-box-shadow mt-5 text-center btn btn-default btn-outline border-none btn-anim">
                                        <i class="font-17 capitalize-font txt-purple">{{ __('dashboard.check_list_job_label') }}</i>
                                        <span class="counts block head-font btn-text">
                                            <span class="counter-anim font-20">
                                                {{ $returnResponse['data'][__('dashboard.hold_job_text')]['job_checklist_count'] ?? '0'}}
                                            </span>
                                        </span>
                                    </div>
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
        <div class="panel panel-default card-view pa-0 mb-10">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row job-list" data-toggle="modal" data-type="{{ __('dashboard.appreciation_job_text') }}"
                                data-count="{{ $returnResponse['data'][__('dashboard.appreciation_job_text')]['count'] ?? '0'}}">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <span class="txt-dark block counter"><span
                                            class="counter-anim">{{ $returnResponse['data'][__('dashboard.appreciation_job_text')]['count'] ?? '0'}}</span></span>
                                    <span class="weight-500 uppercase-font block">{{ __('dashboard.appreciation_job_label') }}</span>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="ti-medall data-right-rep-icon txt-gold"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view pa-0 mb-10">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row job-list" data-toggle="modal" data-type="{{ __('dashboard.escalation_job_text') }}" data-count="{{ $returnResponse['data'][__('dashboard.escalation_job_text')]['count'] ?? '0'}}">
                                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 text-center">
                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 text-center pl-0 pr-0 data-wrap-left">
                                        <span class="txt-dark block counter">
                                            <span
                                                class="counter-anim">{{ $returnResponse['data'][__('dashboard.escalation_job_text')]['count'] ?? '0'}}</span></span>
                                        <span class="weight-500 uppercase-font block">{{ __('dashboard.escalation_job_label') }}</span>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center pl-0 pr-0 data-wrap-right">
                                        <i class="glyphicon glyphicon-fire data-right-rep-icon txt-orange"></i>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-center pa-5 pr-0 data-wrap-right">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pa-5 pt-0">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 task-box-shadow text-center btn btn-default btn-outline border-none btn-anim">
                                            <i class="font-17 capitalize-font txt-purple">{{ __('dashboard.stakeholders_job_label') }}</i>
                                            <span class="counts block head-font btn-text">
                                                <span class="counter-anim font-20">
                                                    {{ $returnResponse['data'][__('dashboard.escalation_job_text')]['job_stakeholders_count'] ?? '0'}}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-5 pr-0 pt-0 pb-0">
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 mr-10 task-box-shadow text-center btn btn-default btn-outline border-none btn-anim">
                                            <i class="font-17 capitalize-font txt-purple">{{ __('dashboard.pm_job_label') }}</i>
                                            <span class="counts block head-font btn-text">
                                                <span class="counter-anim font-20">
                                                    {{ $returnResponse['data'][__('dashboard.escalation_job_text')]['pm_count'] ?? '0'}}
                                                </span>
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 task-box-shadow text-center btn btn-default btn-outline border-none btn-anim pl-0 pr-0">
                                            <i class="font-17 capitalize-font txt-purple">{{ __('dashboard.non_spi_job_label') }}</i>
                                            <span class="counts block head-font btn-text">
                                                <span class="counter-anim font-20">
                                                    {{ $returnResponse['data'][__('dashboard.escalation_job_text')]['job_non_spi_count'] ?? '0'}}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view pa-0 mb-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row job-list" data-toggle="modal" data-type="{{ __('dashboard.completed_job_text') }}" data-count="{{ $returnResponse['data'][__('dashboard.completed_job_text')]['count'] ?? '0'}}">
                                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 text-center">
                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 text-center pl-0 pr-0 data-wrap-left">
                                        <span class="txt-dark block counter">
                                            <span class="counter-anim">{{ $returnResponse['data'][__('dashboard.completed_job_text')]['count'] ?? '0'}}</span></span>
                                        <span class="weight-500 uppercase-font block">{{ __('dashboard.completed_job_label') }}</span>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center pl-0 pr-0 data-wrap-right">
                                        <i class="fa fa-graduation-cap data-right-rep-icon txt-success"></i>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-center pa-5 pt-0 pr-0 data-wrap-right">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pa-5">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 task-box-shadow text-center btn btn-default btn-outline border-none btn-anim">
                                            <i class="font-17 capitalize-font txt-purple">{{ __('dashboard.ontime_job_label') }}</i>
                                            <span class="counts block head-font btn-text">
                                                <span class="counter-anim font-20">
                                                    {{ $returnResponse['data'][__('dashboard.completed_job_text')]['job_ontime_count'] ?? '0'}}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-5 pt-0 pb-0 pr-0">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 task-box-shadow text-center btn btn-default btn-outline border-none btn-anim">
                                            <i class="font-17 capitalize-font txt-purple">{{ __('dashboard.ahead_job_label') }}</i>
                                            <span class="counts block head-font btn-text">
                                                <span class="counter-anim font-20">
                                                    {{ $returnResponse['data'][__('dashboard.completed_job_text')]['ahead_count'] ?? '0'}}
                                                </span>
                                            </span>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 ml-10 task-box-shadow text-center btn btn-default btn-outline border-none btn-anim pl-0 pr-0">
                                           <i class="font-17 capitalize-font txt-purple">{{ __('dashboard.delay_job_label') }}</i>
                                            <span class="counts block head-font btn-text">
                                                <span class="counter-anim font-20">
                                                    {{ $returnResponse['data'][__('dashboard.completed_job_text')]['job_delay_count'] ?? '0'}}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
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

@php

}

@endphp
