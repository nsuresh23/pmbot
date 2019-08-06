<?php

namespace PMBot\Http\Controllers;

// namespace PMBot\Traits;

use PMBot\Model\Jobs\Job;
use PMBot\Traits\JobTrait;
use Illuminate\Http\Request;

class JobController extends Controller
{
    use JobTrait;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = $this->allJobs();

        return view('pages.job.jobList', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \PMBot\Model\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \PMBot\Model\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \PMBot\Model\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \PMBot\Model\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        //
    }

    /**
     * Get the jobs from the Jobs Table by stage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getJobsByStage(Request $request)
    {
        $jobs = $this->jobsByStage($request->stage);

        return view('pages.job.jobList', compact('jobs'));
    }

    /**
     * Get the jobs from the Jobs Table by status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getJobsByStatus(Request $request)
    {
        $jobs = $this->jobsByStatus($request->status);

        return view('pages.job.jobList', compact('jobs'));
    }

    /**
     * Get the jobs from the Jobs Table by stage and status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getJobsByStageAndStatus(Request $request)
    {
        // $jobs = $this->jobsByStageAndStatus($request->stage, $request->status);

        $jobData = [
            [
                "jobTitle" => "#12212",
                "projectManager" => "Suresh",
                "author" => "Suresh",
                "editor" => "Kumar",
                "publisher" => "Springer",
                "startDate" => "Oct 27",
                "dueDate" => "Oct 30"
            ],
            [
                "jobTitle" => "#12212",
                "projectManager" => "Suresh",
                "author" => "Suresh",
                "editor" => "Kumar",
                "publisher" => "Springer",
                "startDate" => "Oct 27",
                "dueDate" => "Oct 30"
            ],
            [
                "jobTitle" => "#12212",
                "projectManager" => "Suresh",
                "author" => "Suresh",
                "editor" => "Kumar",
                "publisher" => "Springer",
                "startDate" => "Oct 27",
                "dueDate" => "Oct 30"
            ],
            [
                "jobTitle" => "#12212",
                "projectManager" => "Suresh",
                "author" => "Suresh",
                "editor" => "Kumar",
                "publisher" => "Springer",
                "startDate" => "Oct 27",
                "dueDate" => "Oct 30"
            ],
            [
                "jobTitle" => "#12212",
                "projectManager" => "Suresh",
                "author" => "Suresh",
                "editor" => "Kumar",
                "publisher" => "Springer",
                "startDate" => "Oct 27",
                "dueDate" => "Oct 30"
            ],
            [
                "jobTitle" => "#12212",
                "projectManager" => "Kumar",
                "author" => "Suresh",
                "editor" => "Kumar",
                "publisher" => "Springer",
                "startDate" => "Oct 27",
                "dueDate" => "Oct 30"
            ],
            [
                "jobTitle" => "#12212",
                "projectManager" => "Suresh",
                "author" => "Suresh",
                "editor" => "Kumar",
                "publisher" => "Springer",
                "startDate" => "Oct 27",
                "dueDate" => "Oct 30"
            ],
            [
                "jobTitle" => "#12212",
                "projectManager" => "Suresh",
                "author" => "Suresh",
                "editor" => "Kumar",
                "publisher" => "Springer",
                "startDate" => "Oct 27",
                "dueDate" => "Oct 30"
            ],
            [
                "jobTitle" => "#12212",
                "projectManager" => "Suresh",
                "author" => "Suresh",
                "editor" => "Kumar",
                "publisher" => "Springer",
                "startDate" => "Oct 27",
                "dueDate" => "Oct 30"
            ]
        ];

        $fields = [
            "jobTitle",
            "projectManager",
            "author",
            "editor",
            "publisher",
            "startDate",
            "dueDate"
        ];

        $jobs["data"] = $jobData;
        $jobs["itemsCount"] = count($jobData);
        $jobs["fields"] = $fields;

        // return response()->json($jobs);
        return response()->json($jobData);

        // return view('pages.job.jobList', compact('jobs'))->render();
        // return redirect()->route('jsgrid');
    }

    /**
     * Get the job stage card.
     *
     */
    public function jobStageCard(Request $request)
    {
        $data = $request->all();
        $jobData = $data;
        // print_r($data);exit;
        // $jobData = [
        //     'title' => $data['title'],
        //     'stageTitle' => $data['stageTitle'],
        //     'stage' => $data['stage'],
        //     'total' => $data['total'],
        //     'allTitle' => $data['allTitle'],
        //     'pendingTitle' => $data['pendingTitle'],
        //     'pending ' => $data['pending'],
        //     'wipTitle' => $data['wipTitle'],
        //     'wip' => $data['wip'],
        //     'completedTitle' => $data['completedTitle'],
        //     'completed ' => $data['completed']
        // ];

        return view('pages.job.jobStageCard', compact('jobData'));
    }

}
