<?php

namespace PMBot\Traits;


use PMBot\Model\Jobs\Job;
use Illuminate\Http\Request;

trait JobTrait
{
    /**
     * Get all the jobs from the Jobs Table.
     *
    */
    public function allJobs()
    {
        $jobs = Job::all();
        return $jobs;
    }

    /**
     * Get the jobs from the Jobs Table by stage.
     *
    */
    public function jobsByStage($stage)
    {
        $jobs = Job::where('stage', $stage)
            // ->orderBy('name', 'desc')
            // ->take(10)
            ->get();
        return $jobs;
    }

    /**
     * Get the jobs from the Jobs Table by status.
     *
     */
    public function jobsByStatus($status)
    {
        $jobs = Job::where('status', $status)
            ->get();
        return $jobs;
    }

    /**
     * Get the jobs from the Jobs Table by status.
     *
     */
    public function jobsByStageAndStatus($stage, $status)
    {
        $jobs = Job::where('stage', $stage)
            ->where('status', $status)
            ->get();
        return $jobs;
    }
}
