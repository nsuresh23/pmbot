<aside class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pr-0">
    <div class="mt-20 mb-20 ml-15 mr-15">
        
		<a href="#emailSendModal" data-toggle="modal" title="Compose" class="btn btn-success btn-block email-compose-btn">
            {{ __("job.email_compose_label") }}
        </a>
		@include('pages.email.composeModal')
		@include('pages.email.replyModal')
		@include('pages.email.draftModal')
    </div>
    <ul class="inbox-nav mb-30">
        <li class="active">
            <a class="job-inbox-email" href="javascript:void(0);">
                <i class="zmdi zmdi-inbox"></i>
                {{ __("job.email_inbox_label") }}
                {{-- <span class="email-inbox-count label label-danger ml-10">2</span> --}}
            </a>
        </li>
        <li class="">
            <a class="job-outbox-email" href="javascript:void(0);">
                <i class="zmdi zmdi-email-open"></i>
                {{ __("job.email_outbox_mail_label") }}
            </a>
        </li>
        <li class="">
            <a class="job-sent-email" href="javascript:void(0);">
                <i class="zmdi zmdi-email-open"></i>
                {{ __("job.email_sent_mail_label") }}
            </a>
        </li>
        <li class="">
            <a class="job-draft-email" href="javascript:void(0);">
                <i class="zmdi zmdi-folder-outline"></i>
                {{ __("job.email_draft_label") }}
                {{-- <span class="email-draft-count label bg-partial ml-10">30</span> --}}
            </a>
        </li>
    </ul>
</aside>