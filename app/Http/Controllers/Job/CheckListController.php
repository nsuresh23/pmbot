<?php

namespace App\Http\Controllers\Job;

use Session;
use Exception;
use Illuminate\Http\Request;
use App\Traits\General\Helper;
use App\Http\Controllers\Controller;
use App\Traits\General\CustomLogger;
use Illuminate\Support\Facades\Config;
use App\Resources\Job\StageCollection as StageResource;
use App\Resources\User\LocationCollection as LocationResource;
use App\Resources\Job\CheckListCollection as CheckListResource;
use App\Resources\Job\TaskCollection as TaskResource;
use App\Resources\Job\JobCollection as JobResource;

class CheckListController extends Controller
{

    use Helper;

    use CustomLogger;

    protected $jobResource = "";
    protected $taskResource = "";
    protected $stageResource = "";
    protected $locationResource = "";
    protected $checkListResource = "";

    public function __construct()
    {

        $this->jobResource = new JobResource();
        $this->taskResource = new TaskResource();
        $this->stageResource = new StageResource();
        $this->locationResource = new LocationResource();
        $this->checkListResource = new CheckListResource();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    { }

    /**
     * Show the checkList detail.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function checkList(Request $request)
    {
        $returnResponse = [];

        try {

            $field = [];

            if ($request->type && $request->type != "") {

                $field["type"] = $request->type;
            }

            if ($request->job_id && $request->job_id != "") {

                $field["job_id"] = $request->job_id;
            }

            $filterData = [];

            if (isset($request->filter) && is_array($request->filter) && count($request->filter) > 0) {

                $filterData = $request->filter;

                $formatData = [

                    // "subject_link" => "subject"

                ];

                $this->formatFilter($filterData, $formatData);
            }

            if (isset($filterData) && is_array($filterData) && count($filterData) > 0) {

                if (isset($filterData["pageIndex"]) && $filterData["pageIndex"] != '') {

                    if (isset($filterData["pageSize"]) && $filterData["pageSize"] != '') {

                        $filterData["offset"] = ($filterData["pageIndex"] - 1) * $filterData["pageSize"];

                        $filterData["limit"] = $filterData["pageSize"];

                        unset($filterData["pageIndex"]);

                        unset($filterData["pageSize"]);
                    }
                }

                $field["filter"] = $filterData;

            }

            $returnResponse = $this->checkListResource->getAllCheckList($field);

            // if (count($field) > 0) {

            //     $returnResponse = $this->checkListResource->getCheckListByField($field);
            // }

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

        if ($request->ajax()) {

            return json_encode($returnResponse);
        }

        // return view('pages.job.checkList.list', compact('returnResponse'));

        return view('errors.error404');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return json response
     */
    public function checkListAdd(Request $request)
    {

        $returnData = [];

        try {

            if ($request->redirectTo) {

                $returnData["redirectTo"] = $request->redirectTo;
            }

            if ($request->type) {

                $returnData["type"] = $request->type;
            }

            if ($request->category) {

                $returnData["category"] = $request->category;
            }

            if ($request->task_id) {

                $returnData["task_id"] = $request->task_id;
            }

            if ($request->job_id) {

                $returnData["job_id"] = $request->job_id;

                if (cache($returnData["job_id"])) {

                    $jobInfo = cache($returnData["job_id"]);

                    $returnData["job_stage"] =  isset($jobInfo["data"]["stage"])? $jobInfo["data"]["stage"] : "";

                }

            }

            $returnData["state_list"] = Config::get('constants.stateList');
            $returnData["stage_list"] = Config::get('constants.stageList');
            // $returnData["task_list"] = $this->taskResource->getActiveTasks();
            // $returnData["task_list"] = $this->taskResource->getCheckListTasks($request);
            $returnData["task_list"] = [];
            if(isset($returnData["type"]) && $returnData["type"] == "global") {
                $returnData["workflow_list"] = $this->jobResource->getWorkflowList($request);
            }
            $returnData["location_list"] = Config::get('constants.locationList');
            $returnData["status_list"] = Config::get('constants.jobCheckListStatus');

        } catch(Exception $e) {

            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );

        }

        // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($returnData);echo '<PRE/>';exit;

        return view('pages.job.checkList.checkList', compact("returnData"));
    }

    /**
     * check list task list select based on workflow id.
     *
     * @return array $returnData
     */

    public function checkListTasksSelect(Request $request)
    {

        $returnData = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => ""
        ];

        $returnResponse = $this->taskResource->getWorkflowTasks($request);

        if($returnResponse) {

            $returnData["success"] = "true";
            $returnData["data"] = $returnResponse;
            $returnData["message"] = "retrieval successful";

        } else {

            $returnData["error"] = "true";
            $returnData["message"] = "retrieval unsuccessful";

        }

        return $returnData;

    }

    /**
     * Show check list view page based on check list id.
     *
     * @return array $returnData
     */
    public function checkListView(Request $request)
    {

        $returnData = [];

        try {

            if ($request->redirectTo) {

                $returnData["redirectTo"] = $request->redirectTo;
            }


            if ($request->id != "") {

                $field = [];

                $field["c_id"] = $request->id;

                $type = __("job.global_check_list_text");

                if ($request->job_id != "") {

                    $type = __("job.job_check_list_text");

                    $field["job_id"] = $request->job_id;

                }

                $returnData["data"] = $this->checkListResource->getCheckList($field);

                $checklistTaskField = [];

                if(isset($returnData["data"]["type"]) && $returnData["data"]["type"]) {

                    $checklistTaskField["category"] = $returnData["data"]["type"];

                }

                if (isset($returnData["data"]["job_id"]) && $returnData["data"]["job_id"]) {

                    $checklistTaskField["job_id"] = $returnData["data"]["job_id"];
                    $returnData["task_list"] = $this->taskResource->getCheckListTasks($checklistTaskField);
                }

                $returnData["data"]["workflow_version"] = "1";

                $returnData["job_list"] = $this->jobResource->getActiveJobs();
                $returnData["state_list"] = Config::get('constants.stateList');
                $returnData["stage_list"] = Config::get('constants.stageList');
                if ($request->job_id == "") {

                    if (isset($returnData["data"]["workflow_version"]) && $returnData["data"]["workflow_version"]) {

                        $returnData["task_list"] = $this->taskResource->getWorkflowTasks(["workflow_id" => $returnData["data"]["workflow_version"]]);

                    }

                }
                $returnData["location_list"] = Config::get('constants.locationList');
                $returnData["status_list"] = Config::get('constants.jobCheckListStatus');
                // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($returnData);echo '<PRE/>';exit;
                $returnData["data"]["notificationReadUrl"] = route(__("job.notification_read_url"), $request->id) . "?type=".$type;

            }

        } catch (Exception $e) {

            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return view('pages.job.checkList.view', compact("returnData"));
    }

    /**
     * Show check list view page based on check list no.
     *
     * @return array $returnData
     */
    public function checkListSearch(Request $request)
    {

        $returnData = [];

        try {

            if ($request->redirectTo) {

                $returnData["redirectTo"] = $request->redirectTo;

            }

            if ($request->c_no != "") {

                $field = [];

                $field["c_no"] = trim(ltrim($request->c_no, "#"));

                $type = __("job.global_check_list_text");

                if ($request->job_id != "") {

                    $type = __("job.job_check_list_text");

                    $field["job_id"] = $request->job_id;
                }

                $returnData["data"] = $this->checkListResource->getCheckList($field);


                $checklistTaskField = [];

                if (isset($returnData["data"]["type"]) && $returnData["data"]["type"]) {

                    $checklistTaskField["category"] = $returnData["data"]["type"];
                }

                if (isset($returnData["data"]["job_id"]) && $returnData["data"]["job_id"]) {

                    $checklistTaskField["job_id"] = $returnData["data"]["job_id"];
                    $returnData["task_list"] = $this->taskResource->getCheckListTasks($checklistTaskField);
                }

                $returnData["job_list"] = $this->jobResource->getActiveJobs();
                $returnData["state_list"] = Config::get('constants.stateList');
                $returnData["stage_list"] = Config::get('constants.stageList');
                if ($request->job_id == "") {

                    if (isset($returnData["data"]["workflow_version"]) && $returnData["data"]["workflow_version"]) {

                        $returnData["task_list"] = $this->taskResource->getWorkflowTasks(["workflow_id" => $returnData["data"]["workflow_version"]]);
                    }
                }
                $returnData["location_list"] = Config::get('constants.locationList');
                $returnData["status_list"] = Config::get('constants.jobCheckListStatus');
                $returnData["data"]["notificationReadUrl"] = route(__("job.notification_read_url"), $request->id) . "?type=" . $type;
            }
        } catch (Exception $e) {

            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return view('pages.job.checkList.view', compact("returnData"));
    }

    /**
     * Show check list edit page based on check list id.
     *
     * @return array $returnData
     */
    public function checkListEdit(Request $request)
    {

        $returnData = [];

        try {

            if ($request->redirectTo) {

                $returnData["redirectTo"] = $request->redirectTo;
            }

            if ($request->type) {

                $returnData["type"] = $request->type;
            }

            if ($request->id && $request->id != "") {

                $type = "global_check_list";

                $field = [
                    'c_id' => $request->id
                ];

                if ($request->job_id && $request->job_id != "") {

                    $type = "job_check_list";

                    $field['job_id'] = $request->job_id;

                }

                $returnData["data"] = $this->checkListResource->getCheckList($field);
                $returnData["task_list"] = $this->taskResource->getActiveTasks();
                $returnData["state_list"] = Config::get('constants.stateList');
                $returnData["stage_list"] = Config::get('constants.stageList');
                $returnData["location_list"] = Config::get('constants.locationList');
                $returnData["status_list"] = Config::get('constants.jobCheckListStatus');

                $returnData["data"]["notificationReadUrl"] = route(__("job.notification_read_url"), $request->id) . "?type=" . $type;

            }

        } catch (Exception $e) {

            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );

        }

        return view('pages.job.checkList.checkList', compact("returnData"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return json response
     */
    public function checkListStore(Request $request)
    {
        $returnResponse = [];

        $redirectRouteAction = "Job\CheckListController@checkList";

        try {

            $request->merge(['empcode' => $request->user()->empcode]);
            $request->merge(['empname' => $request->user()->empname]);
            $request->merge(['workflow_type' => __("job.hap_text")]);


            if ($request->redirectTo != __("job.job_detail_url")) {

                $redirectRouteAction = $this->roleBasedDashboardRouteAction($request);

            }

            // if ($request->redirectTo) {

            //     $redirectRouteAction = $request->redirectTo;

            // }

            if (auth()->check()) {

                $request->merge(['creator_empcode' => auth()->user()->empcode]);

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $request->merge(['creator_empcode' => session()->get("current_empcode")]);

                }

            }

            $returnResponse = $this->checkListResource->checkListAdd($request);

        } catch (Exeception $e) {

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

        // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($request->all());echo '<PRE/>';exit;

        $redirectUrl = redirect()->action($redirectRouteAction);

        if ($request->redirectTo == __("job.job_detail_url") && $request->job_id) {

            $redirectUrl = redirect()->route($request->redirectTo, $request->job_id);
        }

        // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($redirectRouteAction);echo '<PRE/>';
        // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($request->all());echo '<PRE/>';exit;

        return $redirectUrl->with(["success" => $returnResponse["success"], "error" => $returnResponse["error"], "message" => $returnResponse["message"]]);

    }

    /**
     * Update check list in check list table by check list id.
     *
     * @return json response
     */
    public function checkListUpdate(Request $request)
    {

        $returnResponse = [];

        $redirectRouteAction = "Job\CheckListController@checkList";

        try {

            // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($request->all());echo '<PRE/>';exit;

            // $status = "0";

            // if ($request->get('status')) {

            //     if ($request->get('status') == "on") {

            //         $status = "1";

            //     }

            //     if ($request->get('job_id')) {

            //         $status = $request->get('status');
            //     }

            // }

            // $request->merge(['status' => $status]);

            $request = $this->formatHistoryData($request, "history", "~");

            if ($request->redirectTo != __("job.job_detail_url")) {

                $redirectRouteAction = $this->roleBasedDashboardRouteAction($request);

            }

            $request->merge(['empcode' => auth()->user()->empcode]);
            $request->merge(['ip_address' => $request->ip()]);

            if (auth()->check()) {

                $request->merge(['creator_empcode' => auth()->user()->empcode]);

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $request->merge(['creator_empcode' => session()->get("current_empcode")]);

                }

            }

            $returnResponse = $this->checkListResource->checkListEdit($request);

        } catch (Exeception $e) {

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

        $redirectUrl = redirect()->action($redirectRouteAction);

        if ($request->redirectTo == __("job.job_detail_url") && $request->job_id) {

            $redirectUrl = redirect()->route($request->redirectTo, $request->job_id);

        }

        // if ($request->c_id) {

        //     $redirectUrl = redirect()->route(__("job.check_list_view_url"), $request->c_id);

        // }

        return $redirectUrl->with(["success" => $returnResponse["success"], "error" => $returnResponse["error"], "message" => $returnResponse["message"]]);

    }

    /**
     * Delete check list in check list table by check list id.
     *
     * @return json response
     */
    public function checkListDelete(Request $request)
    {

        $redirectUrl = "";

        $returnResponse = [];

        $redirectRouteAction = "";

        try {

            if ($request->c_id && $request->c_id != "") {

                if ($request->redirectTo != __("job.job_detail_url")) {

                    $redirectRouteAction = $this->roleBasedDashboardRouteAction($request);

                }

                if (auth()->check()) {

                    $request->merge(['creator_empcode' => auth()->user()->empcode]);

                    if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                        $request->merge(['creator_empcode' => session()->get("current_empcode")]);

                    }

                }

                $returnResponse = $this->checkListResource->checkListDelete($request);

            }

        } catch (Exeception $e) {

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

        if ($redirectRouteAction) {

            $redirectUrl = redirect()->action($redirectRouteAction);
        }

        if ($request->redirectTo == __("job.job_detail_url") && $request->job_id) {

            $redirectUrl = redirect()->route($request->redirectTo, $request->job_id);
        }

        return $redirectUrl->with(["success" => $returnResponse["success"], "error" => $returnResponse["error"], "message" => $returnResponse["message"]]);

    }

    public function storeMedia(Request $request)
    {

        $returnResponse = [];

        try {

            $returnResponse =  $this->dropzoneMediaUpload($request);

        } catch (Exeception $e) {

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

        return $returnResponse;

        // $path = storage_path(env('UPLOAD_FOLDER'));

        // if (!file_exists($path)) {

        //     mkdir($path, 0777, true);

        // }

        // $file = $request->file('file');

        // $name = uniqid() . '_' . trim($file->getClientOriginalName());

        // $file->move($path, $name);

        // return response()->json(
        //     [

        //     'name'          => $name,

        //     'original_name' => $file->getClientOriginalName(),

        //     ]
        // );

    }

}
