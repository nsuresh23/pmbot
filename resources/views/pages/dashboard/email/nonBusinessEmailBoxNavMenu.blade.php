<aside class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pr-0">
    <div class="mt-20 mb-20 ml-15 mr-15">
		<a href="#emailSendModal" data-toggle="modal" title="Compose" class="btn btn-success btn-block email-compose-btn">
            {{ __("job.email_compose_label") }}
        </a>
    </div>
    <div class="email-inbox-nav">
        <ul class="inbox-nav mb-30">
            <li class="active">
                <a class="dashboard-inbox-email" data-grid-selector="nonBusinessEmailGrid" href="javascript:void(0);">
                    <i class="fa fa-envelope"></i>
                    {{ __("job.email_inbox_label") }}
                    <span class="email-inbox-count email-item-count label label-danger ml-10"></span>
                </a>
            </li>
            <li class="">
                <a class="dashboard-unread-email" data-grid-selector="nonBusinessEmailGrid" href="javascript:void(0);">
                    <i class="fa fa-envelope-square"></i>
                    {{ __("job.email_unread_mail_label") }}
                    <span class="email-unread-count email-item-count label label-danger ml-10"></span>
                </a>
            </li>
            <li class="">
                <a class="dashboard-error-email" data-grid-selector="nonBusinessEmailGrid" href="javascript:void(0);">
                    <i class="fa fa-exclamation-triangle"></i>
                    {{ __("job.email_error_mail_label") }}
                    <span class="email-error-count email-item-count label label-danger ml-10"></span>
                </a>
            </li>
            <li class="">
                <a class="dashboard-outbox-email" data-grid-selector="nonBusinessEmailGrid" href="javascript:void(0);">
                    <i class="zmdi zmdi-email-open"></i>
                    {{ __("job.email_outbox_mail_label") }}
                    <span class="email-outbox-count email-item-count label label-danger ml-10"></span>
                </a>
            </li>
            <li class="">
                <a class="dashboard-sent-email" data-grid-selector="nonBusinessEmailGrid" href="javascript:void(0);">
                    <i class="fa fa-send"></i>
                    {{ __("job.email_sent_mail_label") }}
                    <span class="email-sent-count email-item-count label label-danger ml-10"></span>
                </a>
            </li>
            <li class="">
                <a class="dashboard-draft-email" data-grid-selector="nonBusinessEmailGrid" href="javascript:void(0);">
                    <i class="zmdi zmdi-folder-outline"></i>
                    {{ __("job.email_draft_label") }}
                    <span class="email-draft-count email-item-count label label-danger ml-10"></span>
                </a>
            </li>
            <li class="">
                <a class="dashboard-archived-email" data-grid-selector="nonBusinessEmailGrid" href="javascript:void(0);">
                    <i class="zmdi zmdi-archive"></i>
                    {{ __("job.email_archived_label") }}
                    <span class="email-archived-count email-item-count label label-danger ml-10"></span>
                </a>
            </li>

            <?php

            if(isset($nonBusinessEmailLabels) && is_array($nonBusinessEmailLabels) && count($nonBusinessEmailLabels) > 0) {

                foreach ($nonBusinessEmailLabels as $key => $value) {

            ?>
                    <li class="">
                    <a class="dashboard-nb-email-label" data-grid-selector="nonBusinessEmailGrid" href="javascript:void(0);" data-label="{{ $value["id"] }}">
                            <i class="zmdi zmdi-folder-outline"></i>
                            {{ $value["text"] }}
                            <span class="email-{{ str_replace(",", "", $value["id"]) }}-count email-item-count label label-danger ml-10"></span>
                        </a>
                    </li>

            <?php

                }
            }

            ?>
        </ul>
    </div>
</aside>
