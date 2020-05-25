<!-- Main Content -->
<!-- Row -->
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark capitalize-font"><i
							class="zmdi zmdi-collection-text mr-10"></i>{{ $activitiesTableCaption }}</h6>
				</div>
				<div class="pull-right">
					<!-- <div class="pull-left inline-block mr-15 footable-filtering">
						<div class="form-group">
							{{-- <a href="#"class="btn btn-success btn-outline btn-anim task-note-modal"> --}}
							<a href="#"class="btn btn-success btn-anim task-note-modal">
								<i class="fa fa-check font-18"></i>
								<span class="btn-text font-18">
									{{ __('job.task_note_add_label') }}
								</span>
							</a>
						</div>
					</div> -->
					<a class="pull-left inline-block mr-15" data-toggle="collapse" href="#task_activities_collapse"
						aria-expanded="true">
						<i class="zmdi zmdi-chevron-down job-status-i"></i>
						<i class="zmdi zmdi-chevron-up job-status-i"></i>
					</a>
					<a href="#" class="pull-left inline-block full-screen mr-15">
						<i class="zmdi zmdi-fullscreen job-status-i"></i>
					</a>
					{{-- <a id="job-status-close" class="pull-left inline-block" href="{{ route(__("job.check_list_url")) }}"
					data-effect="fadeOut">
					<i class="zmdi zmdi-close job-status-i"></i>
					</a> --}}
				</div>
				<div class="clearfix"></div>
			</div>
			<div id="task_activities_collapse" class="panel-wrapper collapse in">
				<div class="panel-body">
					<div class="table-wrap">
						<div class="taskActivities" data-list-url="{{ $activitiesListUrl }}" data-add-url="{{ $activitiesAddUrl }}"
							data-edit-url="{{ $activitiesEditUrl }}" data-delete-url="{{ $activitiesDeleteUrl }}"
							data-current-route="{{ Route::currentRouteName() }}">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /Row -->
<!-- /Main Content -->