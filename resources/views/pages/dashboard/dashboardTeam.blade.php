<!-- Row -->
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
                                alt="default" data-toggle="modal"
                                data-stage="{{ __('dashboard.copy_editing_team_text') }}"
                                data-status="{{ __('dashboard.on_track_job_text') }}">
                                <i class="ti-new-window font-30 data-right-rep-icon txt-navi-blue"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $jobsData['pending'] }}</span></span>
                                <span
                                    class="counts-text block btn-text txt-navi-blue">{{ __('dashboard.on_track_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal"
                                data-stage="{{ __('dashboard.copy_editing_team_text') }}"
                                data-status="{{ __('dashboard.delay_job_text') }}">
                                <i class="ti-new-window font-30 data-right-rep-icon text-danger"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $jobsData['wip'] }}</span></span>
                                <span
                                    class="counts-text block btn-text text-danger">{{ __('dashboard.delay_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal"
                                data-stage="{{ __('dashboard.copy_editing_team_text') }}"
                                data-status="{{ __('dashboard.hold_job_text') }}">
                                <i class="ti-new-window font-30 data-right-rep-icon text-warning"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                <span
                                    class="counts-text block btn-text text-warning">{{ __('dashboard.hold_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal"
                                data-stage="{{ __('dashboard.copy_editing_team_text') }}"
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
                                alt="default" data-toggle="modal"
                                data-stage="{{ __('dashboard.production_team_text') }}"
                                data-status="{{ __('dashboard.on_track_job_text') }}">
                                <i class="ti-new-window font-30 data-right-rep-icon txt-navi-blue"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $jobsData['pending'] }}</span></span>
                                <span
                                    class="counts-text block btn-text txt-navi-blue">{{ __('dashboard.on_track_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal"
                                data-stage="{{ __('dashboard.production_team_text') }}"
                                data-status="{{ __('dashboard.delay_job_text') }}">
                                <i class="ti-new-window font-30 data-right-rep-icon text-danger"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $jobsData['wip'] }}</span></span>
                                <span
                                    class="counts-text block btn-text text-danger">{{ __('dashboard.delay_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal"
                                data-stage="{{ __('dashboard.production_team_text') }}"
                                data-status="{{ __('dashboard.hold_job_text') }}">
                                <i class="ti-new-window font-30 data-right-rep-icon text-warning"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $jobsData['completed'] }}</span></span>
                                <span
                                    class="counts-text block btn-text text-warning">{{ __('dashboard.hold_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal"
                                data-stage="{{ __('dashboard.production_team_text') }}"
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