@include('pages.email.composeModal')
@include('pages.email.replyModal')
@include('pages.email.draftModal')

<aside class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pr-0 job-email-nav">
    <div class="mt-20 mb-20 ml-15 mr-15 pmbottype" data-pmbottype="pmbot">

		<a href="javascript:void(0)" data-toggle="modal" title="Compose" class="btn btn-success btn-block email-compose-btn">
            {{ __("job.email_compose_label") }}
        </a>

    </div>
    <ul class="inbox-nav mb-30">
        <li class="active">
            <a class="job-inbox-email" data-grid-selector="jobEmailGrid" href="javascript:void(0);">
                <i class="fa fa-envelope"></i>
                {{ __("job.email_inbox_label") }}
                <span class="email-inbox-count email-item-count label label-danger ml-10"></span>
            </a>
        </li>
        <li class="">
            <a class="job-error-email" data-grid-selector="jobEmailGrid" href="javascript:void(0);">
                <i class="fa fa-exclamation-triangle"></i>
                {{ __("job.email_error_mail_label") }}
                <span class="email-error-count email-item-count label label-danger ml-10"></span>
            </a>
        </li>
        <li class="">
            <a class="job-outbox-email" data-grid-selector="jobEmailGrid" href="javascript:void(0);">
                <i class="fa fa-envelope-square"></i>
                {{ __("job.email_outbox_mail_label") }}
                <span class="email-outbox-count email-item-count label label-danger ml-10"></span>
            </a>
        </li>
        <li class="">
            <a class="job-sent-email" data-grid-selector="jobEmailGrid" href="javascript:void(0);">
                <i class="fa fa-send"></i>
                {{ __("job.email_sent_mail_label") }}
                <span class="email-sent-count email-item-count label label-danger ml-10"></span>
            </a>
        </li>
        <li class="">
            <a class="job-draft-email" data-grid-selector="jobEmailGrid" href="javascript:void(0);">
                <i class="zmdi zmdi-folder-outline"></i>
                {{ __("job.email_draft_label") }}
                <span class="email-draft-count email-item-count label label-danger ml-10"></span>
            </a>
        </li>
    </ul>
</aside>
