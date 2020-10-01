<?php
namespace App\Resources\Job;

use DB;
use Exception;
use App\Traits\General\Helper;
use App\Traits\General\ApiClient;
use function GuzzleHttp\json_encode;
use App\Traits\General\CustomLogger;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Null_;
use App\Resources\Job\TaskCollection as TaskResource;

class JobCollection
{

    use Helper;

    use ApiClient;

    use CustomLogger;

    protected $client;

    protected $jobCountApiUrl;

    protected $userJobCountApiUrl;

    protected $jobByFieldApiUrl;

    protected $jobAddApiUrl;

    protected $jobUpdateApiUrl;

    protected $jobInfoUpdateApiUrl;

    protected $jobListApiUrl;

    protected $jobSelectApiUrl;

    protected $jobTaskListApiUrl;

    protected $taskResource = "";

    protected $annotatorJobAddApiUrl;

    protected $workflowListSelectApiUrl = "";

    protected $currentUserCodeField = "pm_empcode";

    public function __construct()
    {

        $this->taskResource = new TaskResource();
        $this->jobAddApiUrl = env('API_JOB_ADD_URL');
        $this->jobListApiUrl = env('API_JOB_LIST_URL');
        $this->jobCountApiUrl = env('API_JOB_COUNT_URL');
        $this->jobSelectApiUrl = env('API_JOB_SELECT_URL');
        // $this->jobHistoryApiUrl = env('API_JOB_HISTORY_URL');
        $this->jobUpdateApiUrl = env('API_JOB_UPDATE_URL');
        $this->jobInfoUpdateApiUrl = env('API_JOB_INFO_UPDATE_URL');
        $this->jobHistoryApiUrl = env('API_MY_HISTORY_URL');
        $this->jobByFieldApiUrl = env('API_JOB_BY_FIELD_URL');
        $this->jobTaskListApiUrl = env('API_JOB_TASK_LIST_URL');
        $this->userJobCountApiUrl = env('API_USER_JOB_COUNT_URL');
        $this->currentUserCodeField = env('CURRENT_USER_CODE_FIELD');
        $this->annotatorJobAddApiUrl = env('API_ANNOTATOR_JOB_ADD_URL');
        $this->workflowListSelectApiUrl = env('API_WORKFLOW_SELECT_URL');

    }

    /**
     * Store job based on job field array.
     *
     * @param  array $field
     * @return array $returnData
     */
    public function jobAdd($request)
    {

        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            // validate
            // read more on validation at http://laravel.com/docs/validation
            $rules = array(
                'womat_job_id'       => 'required',
                'pm_empcode'       => 'required',
                // 'date_due'       => 'required',
            );

            $url = $this->jobAddApiUrl;

            $validator = Validator::make($request->all(), $rules);

            // process the login
            if ($validator->fails()) {

                $messages = $validator->messages();
                $returnResponse["error"] = "true";
                // $returnResponse["message"] = "Save failed";
                $returnResponse["message"] = $messages->first();

                if ($messages->has('womat_job_id')) {

                    $returnResponse["message"] = __("job.job_isbn_error_msg");
                }

            } else {

                $paramInfo = $request->all();

                unset($paramInfo["redirectTo"]);

                $returnData = $this->postRequest($url, $paramInfo);

                if (isset($returnData["success"]) && $returnData["success"] == "true") {

                    $returnResponse["success"] = "true";
                    $returnResponse["message"] = "Save successfull";

                } else {

                    $returnResponse["error"] = "true";
                    $returnResponse["message"] = "Save unsuccessfull";

                }
            }
        } catch (Exception $e) {

            $returnResponse["error"] = "true";
            $returnResponse["message"] = $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return $returnResponse;
    }

    /**
     * Update job based on job field array.
     *
     * @param  array $field
     * @return array $returnData
     */
    public function jobUpdate($field)
    {

        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            // validate
            // read more on validation at http://laravel.com/docs/validation
            $rules = array(
                'job_id'       => 'required',
                'empcode'       => 'required',
                // 'date_due'       => 'required',
            );

            $url = $this->jobInfoUpdateApiUrl;

            if(!isset($field["isbn"])) {

                $url = $this->jobUpdateApiUrl;

            }

            $validator = Validator::make($field, $rules);

            // process the login
            if ($validator->fails()) {

                $messages = $validator->messages();
                $returnResponse["error"] = "true";
                // $returnResponse["message"] = "Save failed";
                $returnResponse["message"] = $messages->first();

            } else {

                $paramInfo = $field;

                unset($paramInfo["redirectTo"]);

                $returnData = $this->postRequest($url, $paramInfo);

                if (isset($returnData["success"]) && $returnData["success"] == "true") {

                    $returnResponse["success"] = "true";
                    $returnResponse["message"] = "Save successfull";
                } else {

                    $returnResponse["error"] = "true";
                    $returnResponse["message"] = "Save unsuccessfull";
                }
            }
        } catch (Exception $e) {

            $returnResponse["error"] = "true";
            $returnResponse["message"] = $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return $returnResponse;
    }

    /**
     * Store oup job based on job field array.
     *
     * @param  array $field
     * @return array $returnData
     */
    public function annotatorJobAdd($request)
    {

        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            // validate
            // read more on validation at http://laravel.com/docs/validation
            $rules = array(
                'womat_job_id'       => 'required',
                'pm_empcode'       => 'required',
                // 'date_due'       => 'required',
            );

            $url = $this->annotatorJobAddApiUrl;

            $validator = Validator::make($request->all(), $rules);

            // process the login
            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Save failed";
            } else {

                $paramInfo = $request->all();

                unset($paramInfo["redirectTo"]);

                $returnData = $this->postRequest($url, $paramInfo);

                if (isset($returnData["success"]) && $returnData["success"] == "true") {

                    $returnResponse["data"] = $returnData["data"];
                    $returnResponse["success"] = "true";
                    $returnResponse["message"] = "Save successfull";
                } else {

                    $returnResponse["error"] = "true";
                    $returnResponse["message"] = "Save unsuccessfull";
                }
            }
        } catch (Exception $e) {

            $returnResponse["error"] = "true";
            $returnResponse["message"] = $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                " => LINE => " . __LINE__ . " => " .
                " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return $returnResponse;
    }

    /**
     * Get the job count based on field.
     *
     * @param array $field
     * @return array $returnResponse
     */
    public function jobCountByField($field)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            if (count($field) > 0) {

                $url = $this->jobCountApiUrl;

                $responseData = $this->postRequest($url, $field);

                if ($responseData["success"] == "true" && count($responseData["data"]) > 0 && $responseData["data"] != "") {

                    // $responseData = $this->formatData($responseData["data"]);

                    if ($responseData) {

                        $returnResponse["success"] = "true";
                        $returnResponse["data"] = $responseData["data"];
                    }
                }

            }

        } catch (Exception $e) {

            $returnResponse["error"] = "true";
            $returnResponse["message"] = $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return $returnResponse;
    }

    /**
     * Get the user job count based on field.
     *
     * @param array $field
     * @return array $returnResponse
     */
    public function userJobCount($field)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            if (count($field) > 0) {

                $url = $this->userJobCountApiUrl;

                $responseData = $this->postRequest($url, $field);

                if ($responseData["success"] == "true" && count($responseData["data"]) > 0 && $responseData["data"] != "") {

                    // $responseData = $this->formatData($responseData["data"]);

                    if ($responseData) {

                        $returnResponse["success"] = "true";
                        $returnResponse["data"] = $responseData["data"];
                    }
                }
            }
        } catch (Exception $e) {

            $returnResponse["error"] = "true";
            $returnResponse["message"] = $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                " => LINE => " . __LINE__ . " => " .
                " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return $returnResponse;
    }

    /**
     * Get the job count stage wise based on field.
     *
     * @param array $field
     * @return array $returnResponse
     */
    public function jobStageCountByField($field)
    {
        $returnResponse = [];

        try {

            $stageList = Config::get('constants.stageList');

            if (count($stageList) > 0) {

                $url = $this->jobCountApiUrl;

                array_walk($stageList, function($item, $key) use(&$returnResponse, $field) {

                    $field["stage"] = $item;

                    // sleep(10);

                    $stageResponse = $this->jobCountByField($field);

                    if ($stageResponse["success"] == "true" && count($stageResponse["data"]) > 0 && $stageResponse["data"] != "") {

                        $returnResponse[$item] = $stageResponse["data"];
                    }

                });
            }
        } catch (Exception $e) {

            $returnResponse["error"] = "true";
            $returnResponse["message"] = $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return $returnResponse;
    }


    /**
     * Get the job list by job list field array.
     *
     * @param  array $field
     * @return array $returnData
     */
    public function getJobByField($field)
    {

        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $url = $this->jobListApiUrl;

            $responseData = $this->postRequest($url, $field);

            if ($responseData["success"] == "true") {

                $returnResponse["success"] = "true";

                if (isset($responseData["data"]) &&  $responseData["data"] == "") {

                    $responseData["data"] = [];
                }

                if (isset($responseData["data"]) && is_array($responseData["data"]) && count($responseData["data"]) > 0) {

                    $responseFormattedData = [];

                    $responseFormattedData = $this->formatData($responseData["data"]);

                    if ($responseFormattedData) {

                        $returnResponse["data"] = $responseFormattedData;

                        if (isset($responseData["result_count"]) && $responseData["result_count"] != "") {

                            $returnResponse["result_count"] = $responseData["result_count"];

                        } else if (is_array($responseFormattedData)) {

                            $returnResponse["result_count"] = count($responseFormattedData);

                        }

                    }

                }

            }

        } catch (Exception $e) {

            $returnResponse["error"] = "true";
            $returnResponse["message"] = $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return $returnResponse;
    }

    /**
     * Get the job by job field array.
     *
     * @param  array $field
     * @return array $returnData
     */
    public function getJob($field)
    {
        $returnResponse = [];

        try {

            // $field = [
            //     ['name', 'test'],
            //     ['id', '<>', '5']
            // ];

            $url = $this->jobByFieldApiUrl;

            $responseData = $this->postRequest($url, $field);

            if (isset($responseData["success"]) && $responseData["success"] == "true") {

                $returnResponse = $responseData;

                if(isset($returnResponse["data"]["job_id"]) && $returnResponse["data"]["job_id"] !="") {

                    $returnRes = $this->taskResource->getTaskList(["job_id" => $returnResponse["data"]["job_id"]]);

                    if (isset($returnRes["success"]) && $returnRes["success"] == "true" && $returnRes["data"] != "") {

                        $returnResponse["data"]["task"] = $returnRes["data"];

                    }
                    // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($returnResponse);echo '<PRE/>';exit;

                    cache()->forget($returnResponse["data"]["job_id"]);
                    cache([$returnResponse["data"]["job_id"] => $returnResponse], Config::get("session.lifetime"));

                }

            }

        } catch (Exception $e) {

            // return $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return $returnResponse;
    }

    /**
     * Get the job by job field array.
     *
     * @param  array $field
     * @return array $returnData
     */
    public function getJobByParam($param)
    {

        $returnResponse = [];

        try {

            $url = $this->jobByFieldApiUrl;

            $responseData = cache($param["job_id"]);

            if(!$responseData) {

                $responseData = $this->postRequest($url, $param);

            }

            if (isset($responseData["success"]) && $responseData["success"] == "true") {

                $returnResponse = $responseData["data"];

            }

        } catch (Exception $e) {

            // return $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return $returnResponse;
    }

    /**
     * Get the job timeline by job field array.
     *
     * @param  array $field
     * @return array $returnResponse
     */
    public function jobTimeline($field)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $url = $this->jobTaskListApiUrl;

            $responseData = $this->postRequest($url, $field);

            if ($responseData["success"] == "true" && count($responseData["data"]) > 0 && $responseData["data"] != "") {

                $responseData = $this->formatJobTimelineData($responseData["data"]);

                if ($responseData) {

                    $returnResponse["success"] = "true";
                    $returnResponse["data"] = $responseData;
                }
            }
        } catch (Exception $e) {

            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return $returnResponse;
    }

    /**
     * Get the job history by job field array.
     *
     * @param  array $field
     * @return array $returnResponse
     */
    public function jobHistory($field)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $url = $this->jobHistoryApiUrl;

            $responseData = $this->postRequest($url, $field);

            if ($responseData["success"] == "true" && count($responseData["data"]) > 0 && $responseData["data"] != "") {

                $responseData = $this->formatJobHistory($responseData["data"]);

                if ($responseData) {

                    $returnResponse["success"] = "true";
                    $returnResponse["data"] = $responseData;
                }
            }

        } catch (Exception $e) {

            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return $returnResponse;
    }

    /**
     * Get jobs select.
     *
     * @return array $returnData
     */
    public function getAllJob()
    {
        $returnData = "";

        try {


            $url = $this->jobSelectApiUrl;

            // if(auth()->user()->role == "account_manager") {

            //     $field["am_empcode"] =  auth()->user()->empcode;

            // }

            $field = [];

            // $field[env('PROJECT_MANAGER_CODE_FIELD')] =  auth()->user()->empcode;

            // if (auth()->user()->role == env('ACCOUNT_MANAGER_ROLE_NAME')) {

            //     $field[env('ACCOUNT_MANAGER_CODE_FIELD')] =  auth()->user()->empcode;
            // }

            // if (auth()->user()->role == env('PROJECT_MANAGER_ROLE_NAME')) {

            //     $field[env('PROJECT_MANAGER_CODE_FIELD')] =  auth()->user()->empcode;
            // }

            $returnData = $this->postRequest($url, $field);

            if ($returnData["success"] == "true" && count($returnData["data"]) > 0 && $returnData["data"] != "") {

                // $returnResponse = [];

                // array_walk($returnData["data"], function ($item, $key) use (&$returnResponse) {

                //     if (base64_decode($item, true)) {

                //         $item = base64_decode($item);
                //     }

                //     $returnResponse[$key] = $item;

                // });

                $returnData = $returnData["data"];
            }
        } catch (Exception $e) {

            // return $e->getMessage();

            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return $returnData;
    }

    /**
     * Get workflow select.
     *
     * @return array $returnData
     */
    public function getWorkflowList($request)
    {
        $returnData = "";
        // $returnData = [
        //     "1" => "1",
        //     "2" => "2",
        // ];

        try {

            $request = json_decode(json_encode($request), true);

            $url = $this->workflowListSelectApiUrl;

            $paramInfo = [];

            $returnData = $this->postRequest($url, $paramInfo);

            if ($returnData["success"] == "true" && count($returnData["data"]) > 0 && $returnData["data"] != "") {

                $returnData = $returnData["data"];
            }
        } catch (Exception $e) {

            // return $e->getMessage();

            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return $returnData;
    }

    /**
     * Get jobs select.
     *
     * @return array $returnData
     */
    public function getActiveJobs()
    {
        $returnData = "";

        try {


            $url = $this->jobSelectApiUrl;

            // if(auth()->user()->role == "account_manager") {

            //     $field["am_empcode"] =  auth()->user()->empcode;

            // }

            $field = [];

            // $field[env('PROJECT_MANAGER_CODE_FIELD')] =  auth()->user()->empcode;

            if (auth()->user()->role == env('ACCOUNT_MANAGER_ROLE_NAME')) {

                $field[env('ACCOUNT_MANAGER_CODE_FIELD')] =  auth()->user()->empcode;
            }

            if (auth()->user()->role == env('PROJECT_MANAGER_ROLE_NAME')) {

                $field[env('PROJECT_MANAGER_CODE_FIELD')] =  auth()->user()->empcode;
            }

            $returnData = $this->postRequest($url, $field);

            if ($returnData["success"] == "true" && count($returnData["data"]) > 0 && $returnData["data"] != "") {

                // $returnResponse = [];

                // array_walk($returnData["data"], function ($item, $key) use (&$returnResponse) {

                //     if (base64_decode($item, true)) {

                //         $item = base64_decode($item);
                //     }

                //     $returnResponse[$key] = $item;

                // });

                $returnData = $returnData["data"];
            }
        } catch (Exception $e) {

            // return $e->getMessage();

            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return $returnData;
    }

    /**
     * format timeline view.
     *
     * @return array $item
     */

    public function taskTimelineView($item)
    {

        $userClass = $userRoleClass = "";

        if (isset($item["createdby_empcode"]) && $item["createdby_empcode"] == auth()->user()->empcode) {

            $userClass = "timeline-inverted";
        }

        if (isset($item["createdby_role"]) && $item["createdby_role"]) {

            $userRoleClass = "bg-" . $item["createdby_role"];
        }

        $returnData = '<li class="' . $userClass . '">';

        $returnData .= '<div class="timeline-badge ' . $userRoleClass . '">';
        $returnData .= '<i class="icon-layers"></i>';
        $returnData .= '</div>';

        $returnData .= '<div class="timeline-panel pa-10">';

        $returnData .= '<div class="timeline-heading">';

        $returnData .= '<h6 class="">';
        $returnData .= '<i class="fa fa-calendar grey"></i>';

        $returnData .= '<span class="pl-5">';
        $returnData .= date('d F Y', strtotime($item['created_date']));
        // $returnData .= date('g:ia \o\n l jS F Y',strtotime($item['created_date']));
        $returnData .= '</span>';

        $returnData .= '</h6>';

        $returnData .= '</div>';

        $returnData .= '<div class="timeline-body">';

        $returnData .= '<h4 class="capitalize-font txt-primary">';
        $returnData .= '<i class="fa fa-user grey"></i>';

        $returnData .= '<span class="pl-5">';
        $returnData .= isset($item["createdby_empname"]) ? $item["createdby_empname"] : '-';
        $returnData .= '</span>';

        $returnData .= '</h4>';

        $returnData .= '<p class="pull-right">';

        $returnData .= '<span class="capitalize-font">';
        $returnData .= __('job.task_status_label') . ': ';

        $returnData .= '<span class="weight-600">';
        // $returnData .= isset($item["createdby_status"]) ? $item["createdby_status"] : ' - ';
        $returnData .= isset($item["status"]) ? $item["status"] : ' - ';
        $returnData .= '</span>';

        $returnData .= '</span>';

        $returnData .= '</p>';

        $returnData .= '<p>';

        $returnData .= '<span class="">';
        $returnData .= __('job.task_role_label') . ': ';

        $returnData .= '<span class="label label-default ml-10 ' . $userRoleClass . '">';
        $returnData .= isset($item["createdby_role"]) ? $item["createdby_role"] : ' - ';
        $returnData .= '</span>';

        // $returnData .= '<span class="text-uppercase">';
        // $returnData .= isset($item["createdby_role"]) ? $item["createdby_role"] : ' - ';
        // $returnData .= '</span>';

        $returnData .= '</span>';

        // $returnData .= '<span class="label label-default ml-10 ' . $userRoleClass . '">';
        // $returnData .= isset($item["createdby_role"]) ? $item["createdby_role"] : ' - ';
        // $returnData .= '</span>';

        $returnData .= '</p>';

        $returnData .= '<p class="lead head-font txt-dark">';
        $returnData .= $item['title'];
        $returnData .= '</p>';

        $returnData .= '<p>';
        $returnData .= $this->createExcerptAndLink($item['description'], 250, route(__('job.task_view_url'), $item['task_id']), 'Read more.');
        $returnData .= '</p>';

        $returnData .= '</div>';

        $returnData .= '</div>';

        $returnData .= '</li>';

        return $returnData;
    }

    /**
     * format job timeline result.
     *
     * @return array $resource
     */
    public function formatJobTimelineData($items)
    {

        $returnData = [];

        if (count($items) > 0) {

            array_walk(

                $items,

                function ($item, $key) use (&$returnData) {

                    $value["timeline_view"] = $this->taskTimelineView($item);

                    array_push($returnData, $value);
                }

            );
        }

        // if (count($returnData) > 0) {

        //     usort($returnData, function ($a, $b) {

        //         if (isset($a['created_date']) && isset($b['created_date'])) {

        //             $t1 = strtotime($a['created_date']);
        //             $t2 = strtotime($b['created_date']);

        //             // return $t1 - $t2;
        //             return $t2 - $t1;
        //         }
        //     });
        // }

        if (count($returnData) > 0) {

            $returnData = implode("", array_column($returnData, "timeline_view"));
        }

        return $returnData;
    }

    /**
     * format job history result.
     *
     * @return array $resource
     */
    public function formatJobHistory($items)
    {

        $returnData = array_map(

            function ($item) {

                $item['diary_view'] = $this->jobDiaryView($item);

                return $item;
            },
            $items
        );

        if (count($returnData) > 0) {

            $returnData = implode("", array_column($returnData, "diary_view"));
        }

        return $returnData;
    }

    /**
     * format job history result.
     *
     * @return array $resource
     */
    public function formatJobHistoryData($items)
    {

        $returnData = [];

        if (count($items) > 0) {

            array_walk(

                $items,

                function ($item, $key) use(&$returnData) {

                    if (count($item) > 0) {

                        array_walk($item, function ($value, $key) use(&$returnData) {

                            $value["diary_view"] = $this->diaryView($value);

                            array_push($returnData, $value);

                        });

                    }

                }

            );

        }

        if (count($returnData) > 0) {

            usort($returnData, function ($a, $b) {

                if(isset($a['created_date']) && isset($b['created_date'])) {

                    $t1 = strtotime($a['created_date']);
                    $t2 = strtotime($b['created_date']);

                    // return $t1 - $t2;
                    return $t2 - $t1;

                }

            });

        }

        if (count($returnData) > 0) {

            $returnData = implode("", array_column($returnData, "diary_view"));

        }

        return $returnData;
    }

    /**
     * format result.
     *
     * @return array $resource
     */
    public function formatData($items)
    {

        $resource = array_map(

            function ($item) {

                $item['job_id_value'] = '<a href="' . route('job-detail', (int) $item['job_id']) . '">' . $item['womat_job_id'] . '</a>';

                if (isset($item["book"]) && count($item["book"]) > 0 && $item["book"]) {

                    $item['book_id_value'] = $item["book"]["book_id"];

                    $item['title_id'] = $item["book"]["title_id"];

                    $item['title'] = $item["book"]["title"];

                    $item['sub_title'] = $item["book"]["sub_title"];

                    $item['series_title'] = $item["book"]["series_title"];

                    $item['category'] = $item["book"]["category"];

                    $item['copy_editing_level'] = $item["book"]["copy_editing_level"];

                    $item['author'] = $item["book"]["author"];

                    $item['publisher'] = $item["book"]["publisher"];

                    $item['doi'] = $item["book"]["doi"];

                    $item['isbn'] = $item["book"]["isbn"];

                    $item['e_isbn'] = $item["book"]["e_isbn"];
                }

                return $item;

                // return [
                //     // 'id'      => '<a href="' . route('job-detail', (int) $item['id']) . '">',
                //     // 'jobId'   => $item['jobId'],
                //     'id'   => $item['id'],
                //     'job_id'   => $item['job_id'],
                //     'job_id_value'      => '<a href="' . route('job-detail', (int) $item['id']) . '">' . $item['job_id'] . '</a>',
                //     'book_id_value'   => $item['book_id_value'],
                //     'title'   => $item['title'],
                //     'sub_title'   => $item['sub_title'],
                //     'series_title'   => $item['series_title'],
                //     'category'   => $item['category'],
                //     'copy_editing_level'   => $item['copy_editing_level'],
                //     'doi'   => $item['doi'],
                //     'isbn'   => $item['isbn'],
                //     'e_isbn'   => $item['e_isbn'],
                //     'author'   => $item['author'],
                //     'publisher'   => $item['publisher'],
                //     'status'   => $item['status'],
                //     'stage'   => $item['stage'],
                //     'start_date'   => date('d-M-y', strtotime($item['start_date'])),
                //     'due_date'   => date('d-M-y', strtotime($item['due_date'])),
                //     'created_at' => date('d-M-y', strtotime($item['created_at'])),
                //     'updated_at' => date('d-M-y', strtotime($item['updated_at'])),
                // ];
            },
            $items
        );

        return $resource;
    }

    /**
     * format media result.
     *
     * @return array $resource
     */
    public function attachmentMediaList($items)
    {

        $resource = [];

        try {

            $resource = $this->dropzoneMediaList($items);

            // for ($i=0; $i < count($items); $i++) {

            //     try {

            //         $filePath = storage_path(env('UPLOAD_FOLDER')) . '\\' . $items[$i];

            //         $resource[$i] =  [
            //             'name'   => $items[$i],
            //             'size'   => filesize($filePath),
            //             'path'   => $filePath,
            //         ];


            //     } catch(Exception $e) {

            //         return null;

            //     }
            // }

        } catch (Exception $e) {

            return $e->getMessage();
        }

        return $resource;
    }

    // public function formatData($items)
    // {

    //     $resource = new Collection($items, function (array $item) {
    //         return [
    //             'id'      => (int) $item['id'],
    //             'title'   => $item['title'],
    //             'year'    => (int) $item['yr'],
    //             'author'  => [
    //                 'name'  => $item['author_name'],
    //                 'email' => $item['author_email'],
    //             ],
    //             'links'   => [
    //                 [
    //                     'rel' => 'self',
    //                     'uri' => '/data/' . $item['id'],
    //                 ]
    //             ]
    //         ];
    //     });

    //     // Turn that into a structured array (handy for XML views or auto-YAML converting)
    //     return  $this->fractal->createData($resource)->toArray();

    // }



    // /**
    //  * Transform the resource collection into an array.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return array
    //  */
    // public function toArray($request)
    // {
    //     return [
    //         'data' => $this->collection,
    //         'links' => [
    //             'self' => 'link-value',
    //         ],
    //     ];
    // }
}

// // Model path
// use App\Job;
// // Resource path
// use App\Http\Resources\CheckListCollection;
// // Calling procedure
// Route::get('/jobs', function () {
//        return new CheckListCollection(Job::all());
// });
