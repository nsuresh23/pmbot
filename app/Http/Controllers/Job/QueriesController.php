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

class QueriesController extends Controller
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
     * Show the my queries detail.
     *
     *  @return json response
     */
    public function myQueriesList(Request $request)
    {

        try {

            $field = [];

            
            $returnResponse = [];
            
            $taskTypeList = [];

            $taskTypeList = Config::get('constants.taskType');

            if (isset($taskTypeList["inhouse_query"]) && $taskTypeList["inhouse_query"] != "") {

                $field["type"] = __("job.task_inhouse_query_text");
            }

            $field["partialcomplete"] = "0";
            
            $field["assignedto_status"] = "pending";
            
            $field["assignedto_empcode"] = auth()->user()->empcode;

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
     * Show the my open queries detail.
     *
     *  @return json response
     */
    public function openQueriesList(Request $request)
    {

        try {

            $field = [];

            $returnResponse = [];

            $taskTypeList = [];

            $taskTypeList = Config::get('constants.taskType');

            if (isset($taskTypeList["inhouse_query"]) && $taskTypeList["inhouse_query"] != "") {

                $field["type"] = __("job.task_inhouse_query_text");
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
     * Show the draft queries detail.
     *
     *  @return json response
     */
    public function draftQueriesList(Request $request)
    {

        try {

            $field = [];

            $returnResponse = [];

            $taskTypeList = [];

            $taskTypeList = Config::get('constants.taskType');

            if (isset($taskTypeList["inhouse_query"]) && $taskTypeList["inhouse_query"] != "") {

                $field["type"] = __("job.task_inhouse_query_text");
                
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
     * Store a newly created resource in storage.
     *
     * @return json response
     */
    public function queryAdd(Request $request)
    {

        $returnData = [];

        if ($request->redirectTo) {

            $returnData["redirectTo"] = $request->redirectTo;
        }

        if ($request->type) {

            $returnData["type"] = $request->type;
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

        if (count($userList) > 0) {

            unset($userList[auth()->user()->empcode]);
        }

        $returnData["status_list"] = Config::get('constants.taskStatus');
        $returnData["category_list"] = Config::get('constants.taskCategory');
        // $returnData["parent_list"] = $this->taskResource->getActiveTasks();
        $returnData["stage_list"] = Config::get('constants.stageList');
        $returnData["user_list"] = $userList;
        $returnData["job_list"] = $this->jobResource->getActiveJobs();

        echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($returnData);echo '<PRE/>';exit;

        return view('pages.job.task.task', compact("returnData"));
    }

    /**
     * Show query view page based on task id.
     *
     * @return array $returnData
     */
    public function queryView(Request $request)
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

            $returnData["data"] = $this->taskResource->getTask($field);

            if (!$returnData["data"]) {

                return view('errors.error404');
            }

            if (auth()->user() === null || auth()->user() == "") {

                return view('layout.login');
            }

            if (!in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) {

                if (isset($returnData["data"]["assignedto_empcode"]) && $returnData["data"]["assignedto_empcode"] != auth()->user()->empcode) {

                    return view('errors.error401');
                }

                if (isset($returnData["data"]["status"]) && $returnData["data"]["status"] == __("job.task_closed_status_text")) {

                    return view('errors.error401');
                }
            }

            $returnData["data"]["notificationReadUrl"] = route(__("job.notification_read_url"), $request->id) . "?type=task";

            // $returnData["job_list"] = $this->jobResource->getActiveJobs();

        }

        return view('pages.job.task.view', compact("returnData"));
    }

    /**
     * Show query view page based on search query no.
     *
     * @return array $returnData
     */
    public function querySearch(Request $request)
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

            $returnData["data"] = $this->taskResource->getTask($field);

            if (!$returnData["data"]) {

                return view('errors.error404');
            }

            // $returnData["job_list"] = $this->jobResource->getActiveJobs();

            if (isset($returnData["data"]["task_id"]) && $returnData["data"]["task_id"] != "") {

                $returnData["data"]["notificationReadUrl"] = route(__("job.notification_read_url"),  $returnData["data"]["task_id"]) . "?type=task";
            }
        }

        return view('pages.job.task.view', compact("returnData"));
    }

    /**
     * Show query edit page based on task id.
     *
     * @return array $returnData
     */
    public function queryEdit(Request $request)
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
    public function queryStore(Request $request)
    {

        $returnResponse = [];

        $redirectRouteAction = "";

        $taskTypeList = [];

        $taskTypeList = Config::get('constants.taskType');

        if (isset($taskTypeList["task"]) && $taskTypeList["task"] != "") {

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

            if (!in_array(auth()->user()->role, Config::get('constants.nonStakeHolderUserRoles'))) {

                if (isset($taskTypeList["inhouse_query"]) && $taskTypeList["inhouse_query"] != "") {

                    $taskType = $taskTypeList["inhouse_query"];
                }
            }

            if ($taskType != "") {

                $request->merge(['type' => $taskType]);
            }

            if (isset($request->users) && is_array($request->users) && count($request->users) > 1) {

                $userArray = array_map(function ($ar) {

                    $returnAr = [];
                    // $returnAr = json_decode($ar, true);
                    $returnAr = $ar;
                    if (isset($returnAr["description"]) && $returnAr["description"] != "") {

                        $returnAr["description"] = base64_encode($returnAr["description"]);
                    }

                    return $returnAr;
                }, $request->users);

                $request->merge(['users' => $userArray]);

                $request->merge(['assignedto_empcode' => auth()->user()->empcode]);
            }

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
     * Update query in task table by task id.
     *
     * @return json returnResponse
     */
    public function queryUpdate(Request $request)
    {

        $returnResponse = $deletedSubTask = $subTaskHistory = $historyArray = [];

        $redirectRouteAction = "";

        try {

            $request = $this->formatTaskAssignee($request, "assignee", "~");
            $request = $this->formatHistoryData($request, "history", "~");

            if ($request->redirectTo != __("job.job_detail_url")) {

                $redirectRouteAction = $this->roleBasedDashboardRouteAction($request);
            }

            if (isset($request->history) && is_array($request->history) && count($request->history) > 0) {

                $historyArray = $request->history;

                unset($request["history"]);
            }

            if (isset($request->users) && is_array($request->users) && count($request->users) > 1) {

                if (count($historyArray) > 0) {

                    $arrayKey = array_search("assignedto_empcode", array_column($historyArray, "field_value"));

                    if ($arrayKey !== false) {

                        unset($historyArray[$arrayKey]);
                    }
                }

                $userArray = array_map(
                    function ($ar) {

                        $returnAr = [];

                        $returnAr = $ar;

                        if (isset($returnAr["description"]) && $returnAr["description"] != "") {

                            $returnAr["description"] = base64_encode($returnAr["description"]);
                        }

                        return $returnAr;
                    },
                    $request->users
                );

                if (isset($request->subTaskUsers) && $request->subTaskUsers !="") {

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

                            if ($key === false) {

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

            if (isset($request->previous_assigned_user)) {

                if (isset($request->assignedto_empcode) && $request->previous_assigned_user != $request->assignedto_empcode) {

                    $request->merge(['assignedto_status' => "pending"]);
                    $request->merge(['createdby_status' => "completed"]);
                }

                unset($request["previous_assigned_user"]);
            }

            $request->merge(['empcode' => auth()->user()->empcode]);
            $request->merge(['ip_address' => $request->ip()]);

            if (isset($request->partialcomplete) && $request->partialcomplete == '1') {

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

        if ($redirectRouteAction) {

            $redirectUrl = redirect()->action($redirectRouteAction);
        }

        if ($request->redirectTo == __("job.job_detail_url") && $request->current_job_id) {

            $redirectUrl = redirect()->route($request->redirectTo, $request->current_job_id);
        }

        return $redirectUrl->with(["success" => $returnResponse["success"], "error" => $returnResponse["error"], "message" => $returnResponse["message"]]);
    }

    /**
     * Close query in task table by task id.
     *
     * @return json returnResponse
     */
    public function queryClose(Request $request)
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

}
