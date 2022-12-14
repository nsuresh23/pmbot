<aside class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pr-0">
    <div class="mt-20 mb-20 ml-15 mr-15">
		<a href="javascript:void(0)" data-toggle="modal" title="Compose" class="btn btn-success btn-block email-compose-btn">
            {{ __("job.email_compose_label") }}
        </a>
        {{-- @include('pages.email.composeModal')
		@include('pages.email.replyModal')
		@include('pages.email.draftModal') --}}
    </div>
    <ul class="inbox-nav mb-30">
        <li class="active">
            <a class="dashboard-inbox-email" data-grid-selector= "businessEmailGrid" href="javascript:void(0);">
                <i class="fa fa-envelope"></i>
                {{ __("job.email_inbox_label") }}
            </a>
        </li>
        <li class="">
            <!--<a class="dashboard-unread-email" data-grid-selector="nonBusinessEmailGrid" href="javascript:void(0);">-->
			<a class="dashboard-unread-email" data-grid-selector="businessEmailGrid" href="javascript:void(0);">
                <i class="fa fa-envelope-square"></i>
                {{ __("job.email_unread_mail_label") }}
                <span class="email-inbox-unread-count label label-danger ml-10"></span>
            </a>
        </li>
        <li class="">
            <a class="dashboard-error-email" data-grid-selector="businessEmailGrid" href="javascript:void(0);">
                <i class="fa fa-exclamation-triangle"></i>
                {{ __("job.email_error_mail_label") }}
            </a>
        </li>
        <li class="">
            <a class="dashboard-outbox-email" data-grid-selector= "businessEmailGrid" href="javascript:void(0);">
                <i class="zmdi zmdi-email-open"></i>
                {{ __("job.email_outbox_mail_label") }}
            </a>
        </li>
        <li class="">
            <a class="dashboard-sent-email" data-grid-selector= "businessEmailGrid" href="javascript:void(0);">
                <i class="fa fa-send"></i>
                {{ __("job.email_sent_mail_label") }}
            </a>
        </li>
        <li class="">
            <a class="dashboard-draft-email" data-grid-selector= "businessEmailGrid" href="javascript:void(0);">
                <i class="zmdi zmdi-folder-outline"></i>
                {{ __("job.email_draft_label") }}
                {{-- <span class="email-draft-count label bg-partial ml-10">30</span> --}}
            </a>
        </li>

    </ul>
</aside>
