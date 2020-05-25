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
                    <div class="cus-sat-stat weight-500 txt-primary text-center mt-5 model_img img-responsive no-underline stage-job-list"
                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s5_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s5']['total'] ?? 0 }}"
                        >
                        <span class="counter-anim">{{ $returnResponse['data']['stage_count']['s5']['total'] ?? 0 }}</span>
                    </div>
                    <div class="social-info border-none">
                        <div class="row">
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s5_job_text') }}"
                                data-type="{{ __('dashboard.on_track_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s5']['ontrack'] ?? 0 }}">
                                <i class="ti-new-window font-30 data-right-rep-icon txt-navi-blue"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s5']['ontrack'] ?? 0 }}</span></span>
                                <span
                                    class="counts-text block btn-text txt-navi-blue">{{ __('dashboard.on_track_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s5_job_text') }}"
                                data-type="{{ __('dashboard.delay_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s5']['delay'] ?? 0 }}">
                                <i class="ti-new-window font-30 data-right-rep-icon text-danger"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s5']['delay'] ?? 0 }}</span></span>
                                <span
                                    class="counts-text block btn-text text-danger">{{ __('dashboard.delay_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s5_job_text') }}"
                                data-type="{{ __('dashboard.hold_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s5']['hold'] ?? 0 }}">
                                <i class="ti-new-window font-30 data-right-rep-icon text-warning"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s5']['hold'] ?? 0 }}</span></span>
                                <span
                                    class="counts-text block btn-text text-warning">{{ __('dashboard.hold_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s5_job_text') }}"
                                data-type="{{ __('dashboard.escalation_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s5']['escalation'] ?? 0 }}">
                                <i class="ti-new-window font-30 data-right-rep-icon txt-orange"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s5']['escalation'] ?? 0 }}</span></span>
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
                    <h2 class="txt-dark text-capitalize">{{ __('dashboard.s50_job_label') }}</h2>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="profile-box panel-wrapper collapse in">
                <div class="panel-body sm-data-box-1">
                    <div class="cus-sat-stat weight-500 txt-primary text-center mt-5 model_img img-responsive no-underline stage-job-list"
                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s50_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s50']['total'] ?? 0 }}"
                        >
                        <span class="counter-anim">{{ $returnResponse['data']['stage_count']['s50']['total'] ?? 0 }}</span>
                    </div>
                    <div class="social-info border-none">
                        <div class="row">
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s50_job_text') }}"
                                data-type="{{ __('dashboard.on_track_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s50']['ontrack'] ?? 0 }}">
                                <i class="ti-new-window font-30 data-right-rep-icon txt-navi-blue"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s50']['ontrack'] ?? 0 }}</span></span>
                                <span
                                    class="counts-text block btn-text txt-navi-blue">{{ __('dashboard.on_track_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s50_job_text') }}"
                                data-type="{{ __('dashboard.delay_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s50']['delay'] ?? 0 }}">
                                <i class="ti-new-window font-30 data-right-rep-icon text-danger"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s50']['delay'] ?? 0 }}</span></span>
                                <span
                                    class="counts-text block btn-text text-danger">{{ __('dashboard.delay_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s50_job_text') }}"
                                data-type="{{ __('dashboard.hold_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s50']['hold'] ?? 0 }}">
                                <i class="ti-new-window font-30 data-right-rep-icon text-warning"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s50']['hold'] ?? 0 }}</span></span>
                                <span
                                    class="counts-text block btn-text text-warning">{{ __('dashboard.hold_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s50_job_text') }}"
                                data-type="{{ __('dashboard.escalation_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s50']['escalation'] ?? 0 }}">
                                <i class="ti-new-window font-30 data-right-rep-icon txt-orange"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s50']['escalation'] ?? 0 }}</span></span>
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
                    <div class="cus-sat-stat weight-500 txt-primary text-center mt-5 model_img img-responsive no-underline stage-job-list"
                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s200_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s200']['total'] ?? 0 }}"
                        >
                        <span class="counter-anim">{{ $returnResponse['data']['stage_count']['s200']['total'] ?? 0 }}</span>
                    </div>
                    <div class="social-info border-none">
                        <div class="row">
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s200_job_text') }}"
                                data-type="{{ __('dashboard.on_track_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s200']['ontrack'] ?? 0 }}">
                                <i class="ti-new-window font-30 data-right-rep-icon txt-navi-blue"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s200']['ontrack'] ?? 0 }}</span></span>
                                <span
                                    class="counts-text block btn-text txt-navi-blue">{{ __('dashboard.on_track_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s200_job_text') }}"
                                data-type="{{ __('dashboard.delay_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s200']['delay'] ?? 0 }}">
                                <i class="ti-new-window font-30 data-right-rep-icon text-danger"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s200']['delay'] ?? 0 }}</span></span>
                                <span
                                    class="counts-text block btn-text text-danger">{{ __('dashboard.delay_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s200_job_text') }}"
                                data-type="{{ __('dashboard.hold_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s200']['hold'] ?? 0 }}">
                                <i class="ti-new-window font-30 data-right-rep-icon text-warning"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s200']['hold'] ?? 0 }}</span></span>
                                <span
                                    class="counts-text block btn-text text-warning">{{ __('dashboard.hold_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s200_job_text') }}"
                                data-type="{{ __('dashboard.escalation_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s200']['escalation'] ?? 0 }}">
                                <i class="ti-new-window font-30 data-right-rep-icon txt-orange"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s200']['escalation'] ?? 0 }}</span></span>
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
                    <div class="cus-sat-stat weight-500 txt-primary text-center mt-5 model_img img-responsive no-underline stage-job-list"
                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s300_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s300']['total'] ?? 0 }}"
                        >
                        <span class="counter-anim">{{ $returnResponse['data']['stage_count']['s300']['total'] ?? 0 }}</span>
                    </div>
                    <div class="social-info border-none">
                        <div class="row">
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s300_job_text') }}"
                                data-type="{{ __('dashboard.on_track_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s300']['ontrack'] ?? 0 }}">
                                <i class="ti-new-window font-30 data-right-rep-icon txt-navi-blue"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s300']['ontrack'] ?? 0 }}</span></span>
                                <span
                                    class="counts-text block btn-text txt-navi-blue">{{ __('dashboard.on_track_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s300_job_text') }}"
                                data-type="{{ __('dashboard.delay_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s300']['delay'] ?? 0 }}">
                                <i class="ti-new-window font-30 data-right-rep-icon text-danger"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s300']['delay'] ?? 0 }}</span></span>
                                <span
                                    class="counts-text block btn-text text-danger">{{ __('dashboard.delay_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s300_job_text') }}"
                                data-type="{{ __('dashboard.hold_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s300']['hold'] ?? 0 }}">
                                <i class="ti-new-window font-30 data-right-rep-icon text-warning"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s300']['hold'] ?? 0 }}</span></span>
                                <span
                                    class="counts-text block btn-text text-warning">{{ __('dashboard.hold_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s300_job_text') }}"
                                data-type="{{ __('dashboard.escalation_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s300']['escalation'] ?? 0 }}">
                                <i class="ti-new-window font-30 data-right-rep-icon txt-orange"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s300']['escalation'] ?? 0 }}</span></span>
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
                    <div class="cus-sat-stat weight-500 txt-primary text-center mt-5 model_img img-responsive no-underline stage-job-list"
                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s600_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s600']['total'] ?? '' }}"
                        >
                        <span class="counter-anim">{{ $returnResponse['data']['stage_count']['s600']['total'] ?? '' }}</span>
                    </div>
                    <div class="social-info border-none">
                        <div class="row">
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s600_job_text') }}"
                                data-type="{{ __('dashboard.on_track_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s600']['ontrack'] ?? '' }}">
                                <i class="ti-new-window font-30 data-right-rep-icon txt-navi-blue"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s600']['ontrack'] ?? 0 }}</span></span>
                                <span
                                    class="counts-text block btn-text txt-navi-blue">{{ __('dashboard.on_track_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s600_job_text') }}"
                                data-type="{{ __('dashboard.delay_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s600']['delay'] ?? '' }}">
                                <i class="ti-new-window font-30 data-right-rep-icon text-danger"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s600']['delay'] ?? 0 }}</span></span>
                                <span
                                    class="counts-text block btn-text text-danger">{{ __('dashboard.delay_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s600_job_text') }}"
                                data-type="{{ __('dashboard.hold_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s600']['hold'] ?? '' }}">
                                <i class="ti-new-window font-30 data-right-rep-icon text-warning"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s600']['hold'] ?? 0 }}</span></span>
                                <span
                                    class="counts-text block btn-text text-warning">{{ __('dashboard.hold_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s600_job_text') }}"
                                data-type="{{ __('dashboard.escalation_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s600']['escalation'] ?? '' }}">
                                <i class="ti-new-window font-30 data-right-rep-icon txt-orange"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s600']['escalation'] ?? 0 }}</span></span>
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
                    <div class="cus-sat-stat weight-500 txt-primary text-center mt-5 model_img img-responsive no-underline stage-job-list"
                        alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s650_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s650']['total'] ?? '' }}"
                        >
                        <span class="counter-anim">{{ $returnResponse['data']['stage_count']['s650']['total'] ?? '' }}</span>
                    </div>
                    <div class="social-info border-none">
                        <div class="row">
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s650_job_text') }}"
                                data-type="{{ __('dashboard.on_track_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s650']['ontrack'] ?? '' }}">
                                <i class="ti-new-window font-30 data-right-rep-icon txt-navi-blue"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s650']['ontrack'] ?? 0 }}</span></span>
                                <span
                                    class="counts-text block btn-text txt-navi-blue">{{ __('dashboard.on_track_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s650_job_text') }}"
                                data-type="{{ __('dashboard.delay_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s650']['delay'] ?? '' }}">
                                <i class="ti-new-window font-30 data-right-rep-icon text-danger"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s650']['delay'] ?? 0 }}</span></span>
                                <span
                                    class="counts-text block btn-text text-danger">{{ __('dashboard.delay_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s650_job_text') }}"
                                data-type="{{ __('dashboard.hold_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s650']['hold'] ?? '' }}">
                                <i class="ti-new-window font-30 data-right-rep-icon text-warning"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s650']['hold'] ?? 0 }}</span></span>
                                <span
                                    class="counts-text block btn-text text-warning">{{ __('dashboard.hold_job_label') }}</span>
                            </div>
                            <div class="col-xs-3 text-center model_img img-responsive no-underline stage-job-list btn btn-default btn-outline border-none btn-anim"
                                alt="default" data-toggle="modal" data-stage="{{ __('dashboard.s650_job_text') }}"
                                data-type="{{ __('dashboard.escalation_job_text') }}" data-count="{{ $returnResponse['data']['stage_count']['s650']['escalation'] ?? '' }}">
                                <i class="ti-new-window font-30 data-right-rep-icon txt-orange"></i>
                                <span class="counts block head-font btn-text"><span
                                        class="counter-anim">{{ $returnResponse['data']['stage_count']['s650']['escalation'] ?? 0 }}</span></span>
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
