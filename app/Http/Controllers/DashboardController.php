<?php

namespace PMBot\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $jobsData = [
            'title' => 's5',
            'stageTitle' => 's5',
            'stage' => 's5',
            'total' => '50',
            'allTitle' => 'all',
            'pendingTitle' => 'pending',
            'pending' => '15',
            'wipTitle' => 'work in progress',
            'wip' => '20',
            'completedTitle' => 'completed',
            'completed' => '15'
        ];
        return view('pages.job.dashboard', compact('jobsData'));
    }
}
