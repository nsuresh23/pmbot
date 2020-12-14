<?php

function previousJobRoute(&$breadcrumbs)
{

    $previousUrlSplit = explode("/", url()->previous());

    if (count($previousUrlSplit) > 2) {

        if ($previousUrlSplit[count($previousUrlSplit) - 2] == "job") {

            $breadcrumbs->push('Job', url()->previous());
        }
    }

    return $breadcrumbs;

}

// Home
Breadcrumbs::register('home', function ($breadcrumbs) {

    // $breadcrumbs->push('Home', route('home'));

});

Breadcrumbs::register('admin-dashboard', function ($breadcrumbs) {

    // $breadcrumbs->push('Home', route('pm-dashboard'));

});

Breadcrumbs::register('pm-dashboard', function ($breadcrumbs) {

    // $breadcrumbs->push('Home', route('pm-dashboard'));

});

Breadcrumbs::register('am-dashboard', function ($breadcrumbs) {

    // $breadcrumbs->push('Home', route('am-dashboard'));

});

Breadcrumbs::register('qc-dashboard', function ($breadcrumbs) {

    // $breadcrumbs->push('Home', route('am-dashboard'));

});

Breadcrumbs::register('member-dashboard', function ($breadcrumbs) {

    // $breadcrumbs->push('Home', route('am-dashboard'));

});

Breadcrumbs::register('stakeholders-dashboard', function ($breadcrumbs) {

    // $breadcrumbs->push('Home', route('stakeholders-dashboard'));

});

Breadcrumbs::register('users', function ($breadcrumbs) {

    // $breadcrumbs->push('home', route(__('job.job_detail_home_url')));

});

Breadcrumbs::register('user-list', function ($breadcrumbs) {

    // $breadcrumbs->push('home', route(__('job.job_detail_home_url')));

});

Breadcrumbs::register('email-compose', function ($breadcrumbs) {

    // $breadcrumbs->push('home', route(__('job.job_detail_home_url')));

});

Breadcrumbs::register('email-draft', function ($breadcrumbs) {

    // $breadcrumbs->push('home', route(__('job.job_detail_home_url')));

});

Breadcrumbs::register('email-rules', function ($breadcrumbs) {

    // $breadcrumbs->push('home', route(__('job.job_detail_home_url')));

});

Breadcrumbs::register('email-reply', function ($breadcrumbs) {

    // $breadcrumbs->push('home', route(__('job.job_detail_home_url')));

});

Breadcrumbs::register('email-reply-all', function ($breadcrumbs) {

    // $breadcrumbs->push('home', route(__('job.job_detail_home_url')));

});

Breadcrumbs::register('email-forward', function ($breadcrumbs) {

    // $breadcrumbs->push('home', route(__('job.job_detail_home_url')));

});

Breadcrumbs::register('user-add', function ($breadcrumbs) {

    $breadcrumbs->push('home', route(__('job.job_detail_home_url')));

    $breadcrumbs->push('User', url()->current());
});

Breadcrumbs::register('user-edit', function ($breadcrumbs) {

    $breadcrumbs->push('home', route(__('job.job_detail_home_url')));

    $breadcrumbs->push('User', url()->current());
});

Breadcrumbs::register('user-password-update', function ($breadcrumbs) {

    // $breadcrumbs->push('home', route(__('job.job_detail_home_url')));

    // $breadcrumbs->push('User', url()->current());
});

Breadcrumbs::register(__("job.job_detail_url"), function ($breadcrumbs) {

    $breadcrumbs->push('home', route(__('job.job_detail_home_url')));

    $breadcrumbs->push('Job', url()->current());

});

Breadcrumbs::register('task-add', function ($breadcrumbs) {

    $breadcrumbs->push('home', route(__('job.job_detail_home_url')));

    previousJobRoute($breadcrumbs);

    $breadcrumbs->push("Task", url()->current());

});

Breadcrumbs::register('task-edit', function ($breadcrumbs) {

    $breadcrumbs->push('home', route(__('job.job_detail_home_url')));

    previousJobRoute($breadcrumbs);

    $breadcrumbs->push("Task", url()->current());

});

Breadcrumbs::register('task-view', function ($breadcrumbs, $id) {

    $breadcrumbs->push('home', route(__('job.job_detail_home_url')));

    previousJobRoute($breadcrumbs);

    $breadcrumbs->push("Task", url()->current());

});

Breadcrumbs::register('task-search', function ($breadcrumbs, $id) {

    $breadcrumbs->push('home', route(__('job.job_detail_home_url')));

    previousJobRoute($breadcrumbs);

    $breadcrumbs->push("Task", url()->current());
});

Breadcrumbs::register('check-list', function ($breadcrumbs) {

    $breadcrumbs->push('home', route(__('job.job_detail_home_url')));

    previousJobRoute($breadcrumbs);

    $breadcrumbs->push("Checklist", url()->current());
});

Breadcrumbs::register('check-list-add', function ($breadcrumbs) {

    $breadcrumbs->push('home', route(__('job.job_detail_home_url')));

    previousJobRoute($breadcrumbs);

    $breadcrumbs->push("Checklist", url()->current());

});

Breadcrumbs::register('check-list-edit', function ($breadcrumbs) {

    $breadcrumbs->push('home', route(__('job.job_detail_home_url')));

    previousJobRoute($breadcrumbs);

    $breadcrumbs->push("Checklist", url()->current());

});

Breadcrumbs::register('check-list-view', function ($breadcrumbs) {

    $breadcrumbs->push('home', route(__('job.job_detail_home_url')));

    previousJobRoute($breadcrumbs);

    $breadcrumbs->push("Checklist", url()->current());

});

Breadcrumbs::register('check-list-search', function ($breadcrumbs) {

    $breadcrumbs->push('home', route(__('job.job_detail_home_url')));

    previousJobRoute($breadcrumbs);

    $breadcrumbs->push("Checklist", url()->current());
});

Breadcrumbs::register(__("annotation"), function ($breadcrumbs) {

    $breadcrumbs->push('home', route(__('job.job_detail_home_url')));

    $breadcrumbs->push('Annotator', url()->current());

});


?>
