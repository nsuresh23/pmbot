<?php

namespace App\Http\Controllers\Job;

use Session;
use Exception;
use Illuminate\Http\Request;
use App\Traits\General\Helper;
use App\Http\Controllers\Controller;
use App\Traits\General\CustomLogger;
use Illuminate\Support\Facades\Config;
use App\Resources\Job\JobCollection as JobResource;
use App\Resources\Job\TaskCollection as TaskResource;
use App\Resources\Job\StageCollection as StageResource;
use App\Resources\User\UserCollection as UserResource;

class TaskController extends Controller
{

    use Helper;

    use CustomLogger;

    protected $jobResource = "";
    protected $taskResource = "";
    protected $userResource = "";
    protected $stageResource = "";

    public function __construct()
    {

        $this->jobResource = new JobResource();
        $this->userResource = new UserResource();
        $this->taskResource = new TaskResource();
        $this->stageResource = new StageResource();

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    { }

    /**
     * Show the task detail.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function taskList(Request $request)
    {

        try {

            $returnResponse = [];
            // $returnResponse = $this->taskResource->getAllTask();

            $field = [];

            $filterData = [];

            if (isset($request->filter) && is_array($request->filter) && count($request->filter) > 0) {

                $filterData = $request->filter;

                $formatData = [

                    "book_job_id" => "womat_job_id",

                ];

                $this->formatFilter($filterData, $formatData);

            }

            if (isset($filterData) && is_array($filterData) && count($filterData) > 0) {

                if(isset($filterData["pageIndex"]) && $filterData["pageIndex"] != '') {

                    if (isset($filterData["pageSize"]) && $filterData["pageSize"] != '') {

                        $filterData["offset"] = ($filterData["pageIndex"] - 1) * $filterData["pageSize"];

                        $filterData["limit"] = $filterData["pageSize"];

                        unset($filterData["pageIndex"]);

                        unset($filterData["pageSize"]);

                    }

                }

                $field["filter"] = $filterData;

            }

            if(!in_array(auth()->user()->role, Config::get('constants.nonStakeHolderUserRoles'))) {

                $field["assignedto_empcode"] = auth()->user()->empcode;

            }

            if ($request->job_id && $request->job_id != "") {

                $field["job_id"] = $request->job_id;
            }

            if ($request->user_id && $request->user_id != "") {

                $field["assignedto_empcode"] = auth()->user()->empcode;
            }

            if (count($field) > 0) {

                $returnResponse = $this->taskResource->getTaskList($field);

            }

        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        if ($request->ajax()) {

            return json_encode($returnResponse);

        }

        return view('pages.job.task.list', compact('returnResponse'));


    }

    /**
     * Show the job task detail.
     *
     *  @return json response
     */
    public function jobTaskList(Request $request)
    {

        try {

            $field = [];

            $returnResponse = [];

            $filterData = [];

            if (isset($request->filter) && is_array($request->filter) && count($request->filter) > 0) {

                $filterData = $request->filter;

                $formatData = [

                    "book_job_id" => "womat_job_id",

                ];

                $this->formatFilter($filterData, $formatData);

            }

            if (isset($filterData) && is_array($filterData) && count($filterData) > 0) {

                if(isset($filterData["pageIndex"]) && $filterData["pageIndex"] != '') {

                    if (isset($filterData["pageSize"]) && $filterData["pageSize"] != '') {

                        $filterData["offset"] = ($filterData["pageIndex"] - 1) * $filterData["pageSize"];

                        $filterData["limit"] = $filterData["pageSize"];

                        unset($filterData["pageIndex"]);

                        unset($filterData["pageSize"]);

                    }

                }

                $field["filter"] = $filterData;

            }

            if ($request->job_id && $request->job_id != "") {

                $field["job_id"] = $request->job_id;

            }

			if ($request->task_status_filter && $request->task_status_filter != "") {

                $field["task_status_filter"] = $request->task_status_filter;

            }

            $field["partialcomplete"] = "0";

            if (count($field) > 0) {

                $returnResponse = $this->taskResource->getTaskList($field);
            }
        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        if ($request->ajax()) {

            return json_encode($returnResponse);
        }

        return view("errors.error404");
    }

    /**
     * Show the my task detail.
     *
     *  @return json response
     */
    public function myTaskList(Request $request)
    {

        try {

            $field = [];

            $returnResponse = [];

            $taskTypeList = [];

            $filterData = [];

            if (isset($request->filter) && is_array($request->filter) && count($request->filter) > 0) {

                $filterData = $request->filter;

                $formatData = [

                    "book_job_id" => "womat_job_id",

                ];

                $this->formatFilter($filterData, $formatData);

            }

            if (isset($filterData) && is_array($filterData) && count($filterData) > 0) {

                if(isset($filterData["pageIndex"]) && $filterData["pageIndex"] != '') {

                    if (isset($filterData["pageSize"]) && $filterData["pageSize"] != '') {

                        $filterData["offset"] = ($filterData["pageIndex"] - 1) * $filterData["pageSize"];

                        $filterData["limit"] = $filterData["pageSize"];

                        unset($filterData["pageIndex"]);

                        unset($filterData["pageSize"]);

                    }

                }

                $field["filter"] = $filterData;

            }

            if($request->task_date){

                $field["task_date"] = $request->task_date;

            }

            $taskTypeList = Config::get('constants.taskType');

            if (isset($taskTypeList["task"]) && $taskTypeList["task"] != "") {

                $field["type"] = __("job.task_text");
            }

            $field["partialcomplete"] = "0";

            $field["assignedto_status"] = "pending";

            $field["assignedto_empcode"] = auth()->user()->empcode;

            $field["assignedto_emprole"] = auth()->user()->role;

            if (count($field) > 0) {

                $returnResponse = $this->taskResource->getMyTaskList($field);

            }
        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        if ($request->ajax()) {

            return json_encode($returnResponse);
        }

        return view("errors.error404");
    }

    /**
     * Show the my open task detail.
     *
     *  @return json response
     */
    public function openTaskList(Request $request)
    {

        try {

            $field = [];

            $returnResponse = [];

            $taskTypeList = [];

            $filterData = [];

            if (isset($request->filter) && is_array($request->filter) && count($request->filter) > 0) {

                $filterData = $request->filter;

                $formatData = [

                    "book_job_id" => "womat_job_id",

                ];

                $this->formatFilter($filterData, $formatData);

            }

            if (isset($filterData) && is_array($filterData) && count($filterData) > 0) {

                if(isset($filterData["pageIndex"]) && $filterData["pageIndex"] != '') {

                    if (isset($filterData["pageSize"]) && $filterData["pageSize"] != '') {

                        $filterData["offset"] = ($filterData["pageIndex"] - 1) * $filterData["pageSize"];

                        $filterData["limit"] = $filterData["pageSize"];

                        unset($filterData["pageIndex"]);

                        unset($filterData["pageSize"]);

                    }

                }

                $field["filter"] = $filterData;

            }

            $taskTypeList = Config::get('constants.taskType');

            if (isset($taskTypeList["task"]) && $taskTypeList["task"] != "") {

                $field["type"] = __("job.task_text");
            }

            $field["partialcomplete"] = "0";

            $field["createdby_empcode"] = auth()->user()->empcode;

            if (count($field) > 0) {

                $returnResponse = $this->taskResource->getTaskList($field);
            }
        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        if ($request->ajax()) {

            return json_encode($returnResponse);
        }

        return view("errors.error404");
    }

    /**
     * Show the draft task detail.
     *
     *  @return json response
     */
    public function draftTaskList(Request $request)
    {

        try {

            $field = [];

            $returnResponse = [];

            $taskTypeList = [];

            $filterData = [];

            if (isset($request->filter) && is_array($request->filter) && count($request->filter) > 0) {

                $filterData = $request->filter;

                $formatData = [

                    "book_job_id" => "womat_job_id",

                ];

                $this->formatFilter($filterData, $formatData);

            }

            if (isset($filterData) && is_array($filterData) && count($filterData) > 0) {

                if(isset($filterData["pageIndex"]) && $filterData["pageIndex"] != '') {

                    if (isset($filterData["pageSize"]) && $filterData["pageSize"] != '') {

                        $filterData["offset"] = ($filterData["pageIndex"] - 1) * $filterData["pageSize"];

                        $filterData["limit"] = $filterData["pageSize"];

                        unset($filterData["pageIndex"]);

                        unset($filterData["pageSize"]);

                    }

                }

                $field["filter"] = $filterData;

            }

            $taskTypeList = Config::get('constants.taskType');

            if (isset($taskTypeList["task"]) && $taskTypeList["task"] != "") {

                $field["type"] = __("job.task_text");
            }

            if ($request->job_id && $request->job_id != "") {

                $field["job_id"] = $request->job_id;

            }

            $field["partialcomplete"] = "1";

            $field["createdby_empcode"] = auth()->user()->empcode;

            if (count($field) > 0) {

                $returnResponse = $this->taskResource->getTaskList($field);
            }
        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        if ($request->ajax()) {

            return json_encode($returnResponse);
        }

        return view("errors.error404");
    }

    /**
     * Show the query detail.
     *
     *  @return json response
     */
    public function queryList(Request $request)
    {

        try {

            $field = [];

            $returnResponse = [];

            $taskTypeList = [];

            $filterData = [];

            if (isset($request->filter) && is_array($request->filter) && count($request->filter) > 0) {

                $filterData = $request->filter;

                $formatData = [

                    "book_job_id" => "womat_job_id",

                ];

                $this->formatFilter($filterData, $formatData);

            }

            if (isset($filterData) && is_array($filterData) && count($filterData) > 0) {

                if(isset($filterData["pageIndex"]) && $filterData["pageIndex"] != '') {

                    if (isset($filterData["pageSize"]) && $filterData["pageSize"] != '') {

                        $filterData["offset"] = ($filterData["pageIndex"] - 1) * $filterData["pageSize"];

                        $filterData["limit"] = $filterData["pageSize"];

                        unset($filterData["pageIndex"]);

                        unset($filterData["pageSize"]);

                    }

                }

                $field["filter"] = $filterData;

            }

            $taskTypeList = Config::get('constants.taskType');

            if (isset($taskTypeList["task"]) && $taskTypeList["task"] != "") {

                $field["type"] = __("job.task_inhouse_query_text");
            }

            // $field["partialcomplete"] = "0";

            $field["createdby_empcode"] = auth()->user()->empcode;

            if (count($field) > 0) {

                $returnResponse = $this->taskResource->getTaskList($field);
            }
        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        if ($request->ajax()) {

            return json_encode($returnResponse);
        }

        return view("errors.error404");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return json response
     */
    public function taskAdd(Request $request)
    {

        $returnData = [];

        if ($request->redirectTo) {

            $returnData["redirectTo"] = $request->redirectTo;

        }

        $jobList = [];


        if ($request->type) {

            $returnData["type"] = $request->type;

            if($request->type == __("job.task_querylist_text")) {

                $jobList = $this->jobResource->getAllJob();

            } else {

                $jobList = $this->jobResource->getActiveJobs();

            }

        }

        if ($request->job_id) {

            $returnData["job_id"] = $request->job_id;

            $jobResponse = $this->jobResource->getJobByParam(["job_id" => $returnData["job_id"]]);

            if (isset($jobResponse["stage"]) && $jobResponse["stage"] != "") {

                $returnData['stage'] =  $jobResponse["stage"];
            }

        }

        $userList = [];

        $userList = $this->userResource->getActiveUsers();

        // if (count($userList) > 0) {

        //     unset($userList[auth()->user()->empcode]);

        // }

        if (is_array($userList) && count($userList) > 0) {

            unset($userList[Config::get('constants.job_add_am_empcode')]);

        }

        $returnData["type_list"] = Config::get('constants.taskType');
        $returnData["status_list"] = Config::get('constants.taskStatus');
        $returnData["category_list"] = Config::get('constants.taskCategory');
        $returnData["category_followup_time"] = Config::get('constants.taskCategoryFollowupTime');
        // $returnData["parent_list"] = $this->taskResource->getActiveTasks();
        $returnData["stage_list"] = Config::get('constants.stageList');
        $returnData["user_list"] = $userList;

        $returnData["job_list"] = $jobList;

        return view('pages.job.task.task', compact("returnData"));

    }

    /**
     * Show task view page based on task id.
     *
     * @return array $returnData
     */
    public function taskView(Request $request)
    {

        $returnData = [];

        if ($request->redirectTo) {

            $returnData["redirectTo"] = $request->redirectTo;
        }

        if ($request->id != "") {

            $field = [];

            $field["task_id"] = $request->id;

            $returnData["status_list"] = Config::get('constants.taskStatus');
            $returnData["category_list"] = Config::get('constants.taskCategory');
            $returnData["job_list"] = $this->jobResource->getActiveJobs();
            $returnData["stage_list"] = Config::get('constants.stageList');
            $returnData["user_list"] = $this->userResource->getActiveUsers();
            $returnData["category_followup_time"] = Config::get('constants.taskCategoryFollowupTime');

            $returnData["data"] = $this->taskResource->getTask($field);

            $this->taskValidUserCheck($returnData);

            $returnData["data"]["notificationReadUrl"] = route(__("job.notification_read_url"), $request->id) . "?type=task";

            // $returnData["job_list"] = $this->jobResource->getActiveJobs();

        }

        return view('pages.job.task.view', compact("returnData"));

    }

    /**
     * Show task view page based on search task no.
     *
     * @return array $returnData
     */
    public function taskSearch(Request $request)
    {

        $returnData = [];

        if ($request->redirectTo) {

            $returnData["redirectTo"] = $request->redirectTo;
        }

        if ($request->id != "") {

            $field = [];

            $field["task_no"] = trim(ltrim($request->id, "#"));

            $returnData["status_list"] = Config::get('constants.taskStatus');
            $returnData["category_list"] = Config::get('constants.taskCategory');
            $returnData["job_list"] = $this->jobResource->getActiveJobs();
            $returnData["stage_list"] = Config::get('constants.stageList');
            $returnData["user_list"] = $this->userResource->getActiveUsers();
            $returnData["category_followup_time"] = Config::get('constants.taskCategoryFollowupTime');

            $returnData["data"] = $this->taskResource->getTask($field);

            if (!$returnData["data"]) {

                return view('errors.error404');

            }

            // $returnData["job_list"] = $this->jobResource->getActiveJobs();

            if(isset($returnData["data"]["task_id"]) && $returnData["data"]["task_id"] != "") {

                $returnData["data"]["notificationReadUrl"] = route(__("job.notification_read_url"),  $returnData["data"]["task_id"]) . "?type=task";

            }


        }

        return view('pages.job.task.view', compact("returnData"));
    }

    /**
     * Show task edit page based on task id.
     *
     * @return array $returnData
     */
    public function taskEdit(Request $request)
    {

        $returnData = [];

        if ($request->redirectTo) {

            $returnData["redirectTo"] = $request->redirectTo;
        }

        if ($request->id != "") {

            $field = [];

            $parentList = [];

            $field["task_id"] = $request->id;

            $returnData["status_list"] = Config::get('constants.taskStatus');
            $returnData["category_list"] = Config::get('constants.taskCategory');
            $returnData["job_list"] = $this->jobResource->getActiveJobs();
            $returnData["stage_list"] = Config::get('constants.stageList');
            $returnData["user_list"] = $this->userResource->getActiveUsers();

            if (is_array($returnData["user_list"]) && count($returnData["user_list"]) > 0) {

                unset($returnData["user_list"][Config::get('constants.job_add_am_empcode')]);
            }

            $returnData["category_followup_time"] = Config::get('constants.taskCategoryFollowupTime');

            // if (count($returnData["user_list"]) > 0) {

            //     unset($returnData["user_list"][auth()->user()->empcode]);

            // }

            // $taskListResponseData = $this->taskResource->getActiveTasks();

            // $parentList = $taskListResponseData;

            // unset($parentList[$request->id]);

            // $returnData["parent_list"] = $parentList;
            $returnData["data"] = $this->taskResource->getTask($field);
            // $returnData["user_list"] = $this->userResource->getActiveUsers();
            // $returnData["stage_list"] = $this->stageResource->getActiveStages();
            $returnData["data"]["notificationReadUrl"] = route(__("job.notification_read_url"), $request->id) . "?type=task";

        }

        return view('pages.job.task.taskEdit', compact("returnData"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return json response
     */
    public function taskStore(Request $request)
    {

        $returnResponse = [];

        $redirectRouteAction = "";

        $taskTypeList = [];

        $taskTypeList = Config::get('constants.taskType');

        if(isset($taskTypeList["task"]) && $taskTypeList["task"] != "") {

            $taskType = $taskTypeList["task"];

        }

        try {

            $request = $this->formatTaskAssignee($request, "assignee", "~");
            $request->merge(['createdby_empcode' => auth()->user()->empcode]);
            $request->merge(['createdby_empname' => auth()->user()->empname]);
            $request->merge(['createdby_role' => auth()->user()->role]);
            $request->merge(['createdby_status' => 'completed']);
            $request->merge(['assignedto_status' => 'pending']);
            // $request->merge(['partialcomplete' => '0']);
            $request->merge(['status' => 'progress']);

            if($request->partialcomplete == "1") {

                $request->merge(['createdby_status' => 'draft']);

                $request->merge(['status' => 'draft']);

            }

            if (!in_array(auth()->user()->role, Config::get('constants.nonStakeHolderUserRoles'))) {

                if (isset($taskTypeList["inhouse_query"]) && $taskTypeList["inhouse_query"] != "") {

                    $taskType = __("job.task_inhouse_query_text");

                }

                unset($request["task_type"]);

            }

            if($taskType != "") {

                $request->merge(['type' => $taskType]);

            }

            if (isset($request->users) && is_array($request->users) && count($request->users) > 1) {

                $userArray = array_map(function($ar) {

                    $returnAr = [];
                    // $returnAr = json_decode($ar, true);
                    $returnAr = $ar;
                    if(isset($returnAr["description"]) && $returnAr["description"] != "") {

                        $returnAr["description"] = base64_encode($returnAr["description"]);

                    }

                    return $returnAr;

                }, $request->users);

                // $request->merge(['users' => json_decode(json_encode($request->users), true)]);

                $request->merge(['users' => $userArray]);

                $request->merge(['assignedto_empcode' => auth()->user()->empcode]);

            }

            // if ($request->title &&  $request->title != "") {

            //     $title = "";
            //     $title = base64_encode($request->title);
            //     unset($request["title"]);
            //     $request->merge(['title' => $title]);

            // }

            // if ($request->description &&  $request->description != "") {

            //     $description = "";
            //     $description = base64_encode($request->description);
            //     unset($request["description"]);
            //     $request->merge(['description' => $description]);
            // }

            if ($request->redirectTo != __("job.job_detail_url")) {

                $redirectRouteAction = $this->roleBasedDashboardRouteAction($request);

            }

            if (auth()->check()) {

                $request->merge(['creator_empcode' => auth()->user()->empcode]);

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $request->merge(['creator_empcode' => session()->get("current_empcode")]);

                }

            }

            $returnResponse = $this->taskResource->taskAdd($request);

        } catch (Exeception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        if ($redirectRouteAction) {

            $redirectUrl = redirect()->action($redirectRouteAction);
        }

        if ($request->redirectTo == __("job.job_detail_url") && $request->current_job_id) {

            $redirectUrl = redirect()->route($request->redirectTo, $request->current_job_id);
        }

        return $redirectUrl->with(["success" => $returnResponse["success"], "error" => $returnResponse["error"], "message" => $returnResponse["message"]]);

    }

    /**
     * Update task in task table by task id.
     *
     * @return json returnResponse
     */
    public function taskUpdate(Request $request)
    {

        $returnResponse = $deletedSubTask = $subTaskHistory = $historyArray = [];

        $redirectRouteAction = "";

        try {

            // if ($request->redirectTo != "task-list") {

            //     $redirectRouteAction = $this->roleBasedDashboardRouteAction($request);
            // }

            $request = $this->formatTaskAssignee($request, "assignee", "~");
            $request = $this->formatHistoryData($request, "history", "~");

            if ($request->redirectTo != __("job.job_detail_url")) {

                $redirectRouteAction = $this->roleBasedDashboardRouteAction($request);
            }

            if (isset($request->history) && is_array($request->history) && count($request->history) > 0) {

                $historyArray = $request->history;

                // $historyArray = array_map(
                //     function ($ar) {

                //         return json_decode($ar, true);
                //     },
                //     json_decode(json_encode($request->history), true)
                // );

                unset($request["history"]);

            }

            if (isset($request->users) && is_array($request->users) && count($request->users) > 1) {

                if (count($historyArray) > 0) {

                    $arrayKey = array_search("assignedto_empcode", array_column($historyArray, "field_value"));

                    if ($arrayKey !== false) {

                        unset($historyArray[$arrayKey]);
                    }

                }

                $userArray = array_map(function ($ar) {

                        $returnAr = [];

                        // $returnAr = json_decode($ar, true);

                        $returnAr = $ar;

                        if (isset($returnAr["description"]) && $returnAr["description"] != "") {

                            $returnAr["description"] = base64_encode($returnAr["description"]);
                        }

                        return $returnAr;

                    },
                    $request->users
                );

                if (isset($request->subTaskUsers) && $request->subTaskUsers != "") {

                    $subTaskUsersArray = json_decode($request->subTaskUsers, true);

                    $subTasksInfo = $subTaskUsersArray;

                    foreach ($subTasksInfo as $key => $subTask) {

                        if (isset($subTask["task_id"])) {

                            $key = array_search($subTask["task_id"], array_column($userArray, 'task_id'));

                            $resultArray = $userArray[$key];

                            $subTask["description"] = base64_encode($subTask["description"]);

                            if ($subTask["description"] != $resultArray["description"]) {

                                $subTaskHistory[] = [

                                    'task_id' => $subTask["task_id"],
                                    'field_value' => 'description',
                                    'original_value' => $subTask["description"],
                                    'modified_value' => $resultArray["description"]

                                ];

                            }

                            if($key === false) {

                                $deletedSubTask[$subTask["task_id"]] = $subTask["task_id"];

                            }

                        }

                    }

                }

                $request->merge(['users' => $userArray]);

                $request->merge(['assignedto_empcode' => auth()->user()->empcode]);

            }

            if (count($subTaskHistory) > 0) {

                if (count($historyArray) > 0) {

                    foreach ($historyArray as $key => $value) {

                        array_push($subTaskHistory, $value);
                    }

                }

                $historyArray = $subTaskHistory;

            }

            if (count($deletedSubTask) > 0) {

                if (count($historyArray) > 0) {

                    foreach ($deletedSubTask as $deletedSubTaskKey => $deletedSubTaskValue) {

                        $deletedSubTaskKey = array_search($deletedSubTaskValue, array_column($historyArray, "task_id"));

                        if ($deletedSubTaskKey !== false) {

                            unset($historyArray[$deletedSubTaskKey]);

                        }

                    }

                }

                $request->merge(['deletedSubTask' => $deletedSubTask]);

            }

            if (count($historyArray) > 0) {

                $request->merge(['history' => $historyArray]);
            }

            if(isset($request->previous_assigned_user)) {

                if(isset($request->assignedto_empcode) && $request->previous_assigned_user != $request->assignedto_empcode) {

                    $request->merge(['assignedto_status' => "pending"]);
                    $request->merge(['createdby_status' => "completed"]);

                }

                if (isset($request->assignedto_empcode) && $request->previous_assigned_user == $request->assignedto_empcode) {

                    $request->merge(['assignedto_status' => "pending"]);
                    $request->merge(['createdby_status' => "completed"]);
                }

                unset($request["previous_assigned_user"]);

            }


            $request->merge(['empcode' => auth()->user()->empcode]);
            $request->merge(['ip_address' => $request->ip()]);

            // if(isset($request->description_previous_value)) {

            //     unset($request["description_previous_value"]);

            // }


            // if ($request->description_previous_value && $request->history && $request->history != "" && $request->description_previous_value != $request->description) {

            //     // array_push($request->history, [

            //     //     'field' => 'description',
            //     //     'originalValue' => $request->description_previous_value,
            //     //     'modifiedValue' => $request->description

            //     // ]);

            //     $history = $request->history;

            //     array_push($history, json_encode([

            //         'field_value' => 'description',
            //         'original_value' => $request->description_previous_value,
            //         'modified_value' => $request->description

            //     ]));

            //     $request->merge(['empcode' => auth()->user()->empcode]);
            //     $request->merge(['ip_address' => $request->ip()]);

            //     unset($request["description_previous_value"]);

            //     $request->merge(['history' => $history]);

            //     // $request->history->merge([

            //     //     'field' => 'description',
            //     //     'originalValue' => $request->description_previous_value,
            //     //     'modifiedValue' => $request->description

            //     // ]);

            // }

            if(isset($request->partialcomplete) && $request->partialcomplete == '1') {

                unset($request["history"]);

            }

            if (auth()->check()) {

                $request->merge(['creator_empcode' => auth()->user()->empcode]);

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $request->merge(['creator_empcode' => session()->get("current_empcode")]);

                }

            }

            $returnResponse = $this->taskResource->taskEdit($request);

        } catch (Exeception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();

        }

        if($redirectRouteAction) {

            $redirectUrl = redirect()->action($redirectRouteAction);

        }

        if ($request->redirectTo == __("job.job_detail_url") && $request->current_job_id) {

            $redirectUrl = redirect()->route($request->redirectTo, $request->current_job_id);

        }

        return $redirectUrl->with(["success" => $returnResponse["success"], "error" => $returnResponse["error"], "message" => $returnResponse["message"]]);

    }

    /**
     * Close task in task table by task id.
     *
     * @return json returnResponse
     */
    public function taskClose(Request $request)
    {

        $redirectUrl = "";

        $returnResponse = [];

        $redirectRouteAction = "";

        try {

            if ($request->task_id && $request->task_id != "") {

                $history[] = [

                    'task_id' => $request->task_id,
                    'field_value' => 'status',
                    'original_value' => $request->status,
                    'modified_value' => __("job.task_closed_status_text")

                ];

                $request->merge(['history' => $history]);
                $request->merge(['partialcomplete' => "0"]);
                $request->merge(['status' => __("job.task_closed_status_text")]);
                // $request->merge(['createdby_status' => __("job.task_closed_status_text")]);

                if (auth()->check()) {

                    $request->merge(['creator_empcode' => auth()->user()->empcode]);

                    if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                        $request->merge(['creator_empcode' => session()->get("current_empcode")]);

                    }

                }

                $returnResponse = $this->taskResource->taskClose($request);

                $redirectRouteAction = $this->roleBasedDashboardRouteAction($request);

            }
        } catch (Exeception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        $redirectUrl = redirect()->route('task-view', $request->task_id);

        if ($redirectRouteAction) {

            $redirectUrl = redirect()->action($redirectRouteAction);
        }

        return $redirectUrl->with(["success" => $returnResponse["success"], "error" => $returnResponse["error"], "message" => $returnResponse["message"]]);

    }

    /**
     * Update task in task table by task id.
     *
     * @return json returnResponse
     */
    public function taskFollowupUpdate(Request $request)
    {

        $returnResponse = [];

        try {

            $followupType = "snooze";

            if(in_array(auth()->user()->role, Config::get("constants.taskFollowupResetUserRoles"))) {

                $followupType = "followup";

            }

            $request->merge(['empcode' => auth()->user()->empcode]);
            $request->merge(['followup_type' => $followupType]);
            // $request->merge(['ip_address' => $request->ip()]);

            if (auth()->check()) {

                $request->merge(['creator_empcode' => auth()->user()->empcode]);

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $request->merge(['creator_empcode' => session()->get("current_empcode")]);

                }

            }

            $returnResponse = $this->taskResource->taskFollowupUpdate($request);

        } catch (Exeception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        $redirectUrl = redirect()->route(__("job.task_view_url"), $request->task_id);

        return $redirectUrl->with(["success" => $returnResponse["success"], "error" => $returnResponse["error"], "message" => $returnResponse["message"]]);
    }

    /**
     *gent task count based on calendar in task table by task id.
     *
     * @return json returnResponse
     */
    public function taskCalendar(Request $request)
    {

        $returnResponse = [];

        try {

            $request->merge(['empcode' => auth()->user()->empcode]);
            // $request->merge(['day' => date('d')]);
            // $request->merge(['month' => date('m')]);
            // $request->merge(['year' => date('Y')]);

            $returnResponse = $this->taskResource->taskCalendar($request);

        } catch (Exeception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        if ($request->ajax()) {

            return json_encode($returnResponse);
        }

        return view("errors.error404");

    }

    /**
     * Get the task history.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function taskHistory(Request $request)
    {
        $returnResponse = [];

        $field = [];

        try {

            if($request->id) {

                $field['task_id'] = $request->id;

            }


            if (count($field) > 0) {

                $returnResponse = $this->taskResource->taskHistory($field);
            }
        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return json_encode($returnResponse);
    }

    /**
     * Update task in task table by task id.
     *
     * @return json returnResponse
     */
    public function taskFieldUpdate(Request $request)
    {

        $returnResponse = [];

        try {

            $request->merge(['task_id' => $request->task_id]);
            $request->merge(['empcode' => auth()->user()->empcode]);
            $request->merge(['ip_address' => $request->ip()]);

            if (auth()->check()) {

                $request->merge(['creator_empcode' => auth()->user()->empcode]);

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $request->merge(['creator_empcode' => session()->get("current_empcode")]);

                }

            }

            $returnResponse = $this->taskResource->taskUpdate($request);

        } catch (Exeception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        $redirectUrl = redirect()->route(__("job.task_view_url"), $request->task_id);

        return $redirectUrl->with(["success" => $returnResponse["success"], "error" => $returnResponse["error"], "message" => $returnResponse["message"]]);
    }


    // /**
    //  * Delete task in task table by task id.
    //  *
    //  * @return json response
    //  */
    // public function taskDelete(Request $request)
    // {

    //     $returnResponse = [];

    //     try {

    //         $field = [];

    //         if ($request->task_id && $request->task_id != "") {

    //             if ($request->job_id && $request->job_id != "") {

    //                 $field["job_id"] = $request->job_id;

    //             }

    //             if ($request->assignedto_empcode && $request->assignedto_empcode != "") {

    //                 $field["assignedto_empcode"] = $request->assignedto_empcode;
    //             }

    //             $returnResponse = $this->taskResource->taskDelete($request);

    //         }

    //         if (isset($returnResponse["success"]) && $returnResponse["success"] == "true") {


    //             $returnData = $this->taskResource->getTaskList($field);

    //             if (isset($returnData["success"]) && $returnData["success"] == "true") {

    //                 $returnResponse["data"] = $returnData["data"];
    //             }

    //         }

    //     } catch (Exeception $e) {

    //         $returnResponse["success"] = "false";
    //         $returnResponse["error"] = "true";
    //         $returnResponse["data"] = [];
    //         $returnResponse["message"] = $e->getMessage();
    //     }

    //     return json_encode($returnResponse);
    // }

    /**
     * Delete task in task table by task id.
     *
     * @return json response
     */
    public function taskDelete(Request $request)
    {

        $redirectUrl = "";

        $returnResponse = [];

        $redirectRouteAction = "";

        try {

            $field = [];

            if ($request->task_id && $request->task_id != "") {

                if ($request->redirectTo != __("job.job_detail_url")) {

                    $redirectRouteAction = $this->roleBasedDashboardRouteAction($request);
                }

                if (auth()->check()) {

                    $request->merge(['creator_empcode' => auth()->user()->empcode]);

                    if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                        $request->merge(['creator_empcode' => session()->get("current_empcode")]);

                    }

                }

                $returnResponse = $this->taskResource->taskDelete($request);
            }

        } catch (Exeception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        if ($redirectRouteAction) {

            $redirectUrl = redirect()->action($redirectRouteAction);
        }

        if ($request->redirectTo == __("job.job_detail_url") && $request->current_job_id) {

            $redirectUrl = redirect()->route($request->redirectTo, $request->current_job_id);
        }

        return $redirectUrl->with(["success" => $returnResponse["success"], "error" => $returnResponse["error"], "message" => $returnResponse["message"]]);

    }

}
