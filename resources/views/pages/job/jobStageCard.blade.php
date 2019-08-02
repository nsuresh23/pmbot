<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
    <div class="panel panel-default card-view">
        <div class="panel-heading">
            <div class="pull-left">
                <h2 class="txt-dark">{{ $jobData['stageTitle'] }}</h2>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="panel-wrapper collapse in">
            <div class="panel-body sm-data-box-1">
                {{-- <span class="uppercase-font weight-500 font-14 block text-center txt-dark">customer satisfaction</span> --}}
                <div class="cus-sat-stat weight-500 txt-primary text-center mt-5 model_img img-responsive no-underline job-list"
                    alt="default" data-toggle="modal" data-url="{{ route('job-list') }}" data-stage="{{ $jobData['stage'] }}"
                    data-status="{{ $jobData['allTitle'] }}">
                    <span class="counter-anim">{{ $jobData['total'] }}</span>
                    {{-- <span>%</span> --}}
                </div>
                <div class="progress-anim mt-20">
                    <div class="progress">
                        <div class="progress-bar progress-bar-primary wow animated progress-animated" role="progressbar"
                            aria-valuenow="{{ $jobData['total'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <ul class="flex-stat mt-5">
                    <li class="model_img img-responsive no-underline job-list" alt="default" data-toggle="modal"
                        data-url="{{ route('job-list') }}" data-stage="{{ $jobData['stage'] }}" data-status="{{ $jobData['pendingTitle'] }}">
                        <span class="block capitalize">{{ $jobData['pendingTitle'] }}</span>
                        {{-- <span class="block weight-500 txt-dark font-15">30</span> --}}
                        <span class="block weight-500 txt-dark font-15">{{ $jobData['pending'] }}</span>
                    </li>
                    <li class="model_img img-responsive no-underline job-list" alt="default" data-toggle="modal"
                        data-url="{{ route('job-list') }}" data-stage="{{ $jobData['stage'] }}" data-status="{{ $jobData['wipTitle'] }}">
                        <span class="block capitalize">{{ $jobData['wipTitle'] }}</span>
                        {{-- <span class="block weight-500 txt-dark font-15">5</span> --}}
                        <span class="block weight-500 txt-dark font-15">{{ $jobData['wip'] }}</span>
                    </li>
                    <li class="model_img img-responsive no-underline job-list" alt="default" data-toggle="modal"
                        data-url="{{ route('job-list') }}" data-stage="{{ $jobData['stage'] }}" data-status="{{ $jobData['completedTitle'] }}">
                        <span class="block capitalize">{{ $jobData['completedTitle'] }}</span>
                        {{-- <span class="block weight-500 txt-dark font-15">15</span> --}}
                        <span class="block weight-500 txt-dark font-15">{{ $jobData['completed'] }}</span>
                        {{-- <span class="block">
                                    <i class="zmdi zmdi-trending-up txt-dark font-20"></i>
                                </span> --}}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
