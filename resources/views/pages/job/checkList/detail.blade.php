<!-- Main Content -->
<!-- Row -->
<div class="row" id="checkListView" data-url="{{ $viewUrl }}">
    <div class="col-md-12">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark capitalize-font">
                        <i class="zmdi zmdi-collection-text mr-10"></i>{{ __('job.check_list_detail_label') . ": #" }}{{$returnData['data']['c_no'] ?? ''}}
                    </h6>
                </div>
                <div class="pull-right">

                    <?php if (in_array(auth()->user()->role, $checkListUserRoles)) { ?>

                        <div class="pull-left inline-block mr-15 footable-filtering">
                            <a class="btn btn-warning btn-outline btn-icon right-icon" type="button" href="{{$checkListAddUrl ?? '#'}}">
                                {{__('job.check_list_add_button_label')}}
                                <i class="fa fa-plus font-15"></i>
                            </a>
                        </div>

                        <div class="pull-left inline-block mr-15 footable-filtering">
                            <a class="btn btn-warning btn-outline btn-icon right-icon check-list-edit" type="button">
                                {{__('job.check_list_edit_button_label')}}
                                <i class="fa fa-pencil font-15"></i>
                            </a>
                        </div>

                        <?php if ($checkListStatus != __("job.check_list_completed_status_text")) { ?>

                            <div class="pull-left inline-block mr-15 footable-filtering">
                                <a class="btn btn-danger btn-outline btn-icon right-icon check-list-delete" type="button" href="{{$checkListDeleteUrl ?? '#'}}">
                                    {{__('job.check_list_delete_button_label')}}
                                    <i class="fa fa-trash font-15"></i>
                                </a>
                            </div>

                        <?php } ?>

                    <?php

                    }

                    ?>
                    <div class="pull-left inline-block mr-15 footable-filtering">

                        <form id="checkListViewSearchForm" class="form-inline">
                            <div class="form-group">
                                <label class="sr-only">{{ __('job.check_list_search_label') }}</label>
                                <div class="input-group">
                                    <input type="text" id="checkListViewSearchInput" class="form-control" placeholder="Search" data-job-id="{{$jobId ?? ''}}">
                                    <div id="checkListViewSearch" data-check-list-view-base-url="{{ route(__('job.check_list_search_url'), '') }}" class="input-group-btn">
                                        <span type="button" class="btn btn-primary">
                                            <span class="fooicon fooicon-search"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <a href="#" class="pull-left inline-block full-screen mr-15">
                        <i class="zmdi zmdi-fullscreen job-status-i"></i>
                    </a>
                    <a class="pull-left inline-block" href="{{$redirectTo ?? '#'}}" data-effect="fadeOut">
                        <i class="zmdi zmdi-close job-status-i"></i>
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <div id="check_list_detail" class="row panel-wrapper collapse in readonly-block">
                <div class="panel-body pt-0 pb-0">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <?php if($checklistTask == "true") { ?>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 pt-10 checklist-detail-block">
                            <?php } else { ?>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pt-10 checklist-detail-block">
                            <?php } ?>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <label for="title" class="pt-0">
                                                {{$returnData['data']['title'] ?? '-'}}
                                            </label>
                                        </div>

                                        <?php if ($createdDate) { ?>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <p class="mb-10 font-italic">
                                                    Added by

                                                    <?php if(isset($returnData['data']['creator_empcode'])) { ?>
                                                    
                                                        <span class="weight-500 capitalize-font txt-primary">
                                                        
                                                            <span class="pl-5">{{$returnData['data']['creator_empcode'] ?? '-'}}</span>
                                                        
                                                        </span>
                                                        
                                                        for
                                                    
                                                    <?php } ?>

                                                    <span class="weight-500 capitalize-font txt-primary">
                                                        <span class="pl-5">{{$returnData['data']['empname'] ?? '-'}}</span>
                                                    </span>
                                                    at
                                                    <span>
                                                        {{date('g:ia \o\n l jS F Y',strtotime($createdDate))}}
                                                    </span>
                                                </p>
                                            </div>
                                        <?php } ?>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="row">

                                                <?php if ($jobId) { ?>

                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <label class="control-label text-left">{{ __('job.task_job_title_label') }}:</label>
                                                        <span class="ml-20">
                                                            <a id="job" name="job" class="form-control-static" href="{{$checkListJobUrl ?? '#'}}" readonly>
                                                                {{$jobTitle ?? '-'}} </a>
                                                        </span>
                                                    </div>

                                                <?php } ?>

                                                <?php if ($taskTitleLink) { ?>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <label class="control-label text-left">{{ __('job.check_list_task_title_label') }}:</label>
                                                        <span class="ml-20">
                                                            <?php echo $taskTitleLink; ?>
                                                        </span>
                                                    </div>
                                                <?php } ?>

                                                <?php if ($location) { ?>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <label class="control-label text-left">{{ __('job.check_list_location_label') }}:</label>
                                                        <span class="ml-20">
                                                            {{$location ?? '-'}}
                                                        </span>
                                                    </div>
                                                <?php } ?>

                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <hr class="light-grey-top-border">
                                            <label class="control-label">{{ __('job.check_list_description_label') }}:</label>
                                            <p id="check-list-description-view" class="form-control-static"
                                                data-value="{{$returnData['data']['description'] ?? ''}}">
                                            </p>
                                        </div>

                                        <?php if ($attachmentPath) { ?>

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <label for="attachment" class="control-label">{{ __('job.check_list_attachment_label') }}</label>
                                                <p class="form-control-static">
                                                    {{$returnData['data']['attachment_path']}}
                                                </p>
                                            </div>

                                        <?php } ?>
                                        <?php if (in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) { ?>

                                            <div class="collapse hiddenBlock" id="checkListEdit">

                                                <hr class="light-grey-top-border">

                                                {{-- <div class="panel panel-default card-view"> --}}

                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-block">

                                                    @include('pages.job.checkList.checkListEditForm')

                                                </div>

                                                {{-- </div> --}}

                                            </div>

                                        <?php } ?>
                                    </div>
                                </div>
                                <?php if($checklistTask == "true") { ?>
                                    <div class="col-lg-4 col-md-4 col-sm-8 col-xs-12">
                                        <div class="panel panel-default card-view">
                                            <div class="panel-heading">
                                                <div class="pull-left">
                                                    <h6 class="panel-title txt-dark">{{$sideBlockTitle}}</h6>
                                                </div>
                                                <div class="pull-right">
                                                    <a href="#" class="pull-left inline-block full-screen">
                                                        <i class="zmdi zmdi-fullscreen job-status-i"></i>
                                                    </a>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="row panel-wrapper collapse in">
                                                <div class="checklist-tasks panel-body pa-0">
                                                    <?php echo $checkListTaskView; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Row -->
<!-- /Main Content -->
