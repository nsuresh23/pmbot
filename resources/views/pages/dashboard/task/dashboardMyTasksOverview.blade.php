<!-- Row -->
<div class="row">
    <?php if(in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

        <div class="panel-group accordion-struct pl-5" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading bg-light-green activestate" role="tab">
                    <a role="tab" data-toggle="collapse" href="#myTaskList" aria-expanded="true">
                        <i class="zmdi zmdi-collection-text mr-10"></i>
                        {{ __("dashboard.tasks_label") }}
                        <span class="result-count"></span>
                        {{-- <div class="noti">
                            <i class="fas fa-heart"></i>2
                            <div class="shadow"></div>
                            <div class="point"></div>
                        </div>
                        <div class="shadow-oval"></div> --}}
                    </a>
                </div>
                <div id="myTaskList" class="panel-collapse collapse in" role="tabpanel">

                    @include('pages.dashboard.task.dashboardMyTasks')

                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading bg-light-yellow activestate" role="tab">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <a class="collapsed" role="tab" data-toggle="collapse" href="#myEmails" aria-expanded="true">
                                <i class="zmdi zmdi-collection-text mr-10"></i>
                                {{ __("dashboard.emails_label") }}
                                {{-- <span class="result-count"></span> --}}
                                <span class="email-result-count"></span>
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="pull-right inline-block">
                                <div class="pull-left inline-block mt-5 mb-5">
                                    <form class="form-inline dashboard-email-move-to-form" action="{{ route(__('job.dashboard_email_move_to_url')) }}">
                                        <input type="hidden" class="dashboard-email-move-to-email-id" name="id" value="" />
                                        <div class="form-group">
                                            <div class="input-group dashboard-email-move-to-input-group pr-5">
                                                <div class="input-group-btn wd-20">
                                                    <span type="button" class="btn bg-warning txt-light pt-10 pb-10 pr-10">
                                                        {{-- <span class="fa fa-arrow-circle-right"></span> --}}
                                                        {{ __('job.email_move_to_label') }}
                                                    </span>
                                                </div>
                                                {!! Form::select('label_name', $myEmailsMoveToList, null, ['class' => 'form-control select2 dashboard-email-move-to-input',
                                                'data-error' => "{{ __('job.email_move_to_placeholder_text') }}", 'style' => 'width: max-content;', 'required']) !!}
                                                {{-- <select class="form-control select2 dashboard-email-move-to-input" name="label_name" style="width: max-content;"
                                                    placeholder="{{__('job.email_move_to_placeholder_text') }}" required></select> --}}
                                                <div class="input-group-btn dashboard-email-move-to-btn wd-10">
                                                    <span type="button" class="btn bg-success txt-light pa-10">
                                                        <span class="fa fa-arrow-circle-right"></span>
                                                        {{-- {{ __('job.email_move_to_label') }} --}}
                                                    </span>
                                                </div>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="pull-left inline-block mr-15 mt-15">
                                    <span class="mr-5">{{ __("dashboard.emails_last_updated_label") }}:</span>
                                    <span class="email-last-updated"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="myEmails" class="panel-collapse collapse in" role="tabpanel">

                    @include('pages.dashboard.email.dashboardMyEmails')

                </div>
            </div>
        </div>

    <?php } else { ?>

        @include('pages.dashboard.task.dashboardMyTasks')

    <?php } ?>
</div>
<!-- /Row -->
