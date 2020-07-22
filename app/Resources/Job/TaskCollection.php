<?php

namespace App\Resources\Job;

use Exception;
use League\Fractal\Manager;
use App\Traits\General\Helper;
use App\Traits\General\ApiClient;
use function GuzzleHttp\json_encode;
use App\Traits\General\CustomLogger;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use App\Resources\Job\JobCollection as JobResource;

class TaskCollection
{

    use Helper;

    use ApiClient;

    use CustomLogger;

    protected $jobResource = "";

    protected $client;
    protected $fractal;

    protected $taskListApiUrl;
    protected $myTaskListApiUrl;
    protected $taskAddApiUrl;
    protected $taskUpdateApiUrl;
    protected $taskByFieldApiUrl;
    protected $taskDeleteApiUrl;
    protected $taskSelectApiUrl;
    protected $taskHistoryApiUrl;
    protected $checkListTaskSelectApiUrl;
    protected $taskFollowupDateUpdateApiUrl;
    protected $workflowTaskSelectApiUrl;
    protected $shMyTaskListApiUrl;
    protected $shTaskListApiUrl;
    protected $jobTaskListApiUrl;
    protected $emailAnnotatorBaseUrl;
    protected $taskCalendarCountApiUrl;


    public function __construct()
    {
        // $this->client = new ApiClient();
        $this->fractal = new Manager();

        $this->taskListApiUrl = env('API_TASK_LIST_URL');
        $this->myTaskListApiUrl = env('API_MY_TASK_LIST_URL');
        $this->shTaskListApiUrl = env('API_SH_TASK_LIST_URL');
        $this->shMyTaskListApiUrl = env('API_SH_MY_TASK_LIST_URL');
        $this->jobTaskListApiUrl = env('API_JOB_TASK_LIST_URL');
        $this->taskAddApiUrl = env('API_TASK_ADD_URL');
        $this->taskUpdateApiUrl = env('API_TASK_UPDATE_URL');
        $this->taskFollowupDateUpdateApiUrl = env('API_TASK_FOLLOWUP_DATE_UPDATE_URL');
        $this->taskHistoryApiUrl = env('API_TASK_HISTORY_URL');
        $this->taskByFieldApiUrl = env('API_TASK_BY_FIELD_URL');
        $this->taskDeleteApiUrl = env('API_TASK_DELETE_URL');
        $this->taskSelectApiUrl = env('API_TASK_SELECT_URL');
        $this->workflowTaskSelectApiUrl = env('API_WORKFLOW_TASK_SELECT_URL');
        $this->checkListTaskSelectApiUrl = env('API_CHECKLIST_TASK_SELECT_URL');
        $this->emailAnnotatorBaseUrl = env("EMAIL_ANNOTATOR_BASE_URL");
        $this->taskCalendarCountApiUrl = env("API_TASK_CALENDAR_COUNT_URL");
    }

    /**
     * Get the task list by task field array.
     *
     * @param  array $field
     * @return array $returnData
     */
    public function getTaskList($field)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $url = $this->taskListApiUrl;

            if (in_array(auth()->user()->role, Config::get("constants.shUserRoles"))) {

                $url = $this->shTaskListApiUrl;
            }

            if (isset($field["job_id"]) && $field["job_id"] != "") {

                $url = $this->jobTaskListApiUrl;
            }

            $responseData = $this->postRequest($url, $field);

            if ($responseData["success"] == "true") {

                $returnResponse["success"] = "true";

                if (isset($responseData["data"]) &&  $responseData["data"] == "") {

                    $responseData["data"] = [];
                }

                if (isset($responseData["data"]) && is_array($responseData["data"]) && count($responseData["data"]) > 0) {

                    $responseData = $this->formatData($responseData["data"], $field);

                    if ($responseData) {

                        $returnResponse["data"] = $responseData;

                        if (is_array($responseData)) {

                            $returnResponse["result_count"] = count($responseData);
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
     * Get the my task list by task field array.
     *
     * @param  array $field
     * @return array $returnData
     */
    public function getMyTaskList($field)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $url = $this->myTaskListApiUrl;

            if (in_array(auth()->user()->role, Config::get("constants.shUserRoles"))) {

                $url = $this->shMyTaskListApiUrl;
            }

            $responseData = $this->postRequest($url, $field);

            if (is_array($responseData) && $responseData["success"] == "true" && $responseData["data"] != "") {

                $responseData = $this->formatData($responseData["data"], $field);

                if ($responseData) {

                    $returnResponse["success"] = "true";
                    $returnResponse["data"] = $responseData;

                    if (is_array($responseData)) {

                        $returnResponse["result_count"] = count($responseData);
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
     * Add the task.
     *
     * @return array $returnResponse
     */
    public function taskAdd($request)
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
                // 'users'                 => 'required',
                'createdby_status'      => 'required',
                'category'              => 'required',
                // 'assignedto_empcode'    => 'required',
                'title'                 => 'required',
                // 'stage'                 => 'required',
                'createdby_empcode'     => 'required',
            );

            if ($request->job_id && $request->job_id != "") {

                $rules["job_id"] = 'required';
            }

            if ($request->type && $request->type == __("job.task_inhouse_query_label")) {

                unset($rules["assignedto_empcode"]);
                unset($rules["stage"]);
            }
            $validator = Validator::make($request->all(), $rules);

            // process the login
            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Save failed";
            } else {

                $paramInfo = $request->all();

                unset($paramInfo["files"]);
                unset($paramInfo["_token"]);
                unset($paramInfo["task_id"]);
                unset($paramInfo["redirectTo"]);
                unset($paramInfo["current_job_id"]);
                unset($paramInfo["_wysihtml5_mode"]);

                $url = $this->taskAddApiUrl;

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
     * Get the task by task field array.
     *
     * @param  array $field
     * @return array $returnData
     */
    public function getTask($field)
    {
        $returnResponse = [];

        try {

            $url = $this->taskByFieldApiUrl;

            $responseData = $this->postRequest($url, $field);




            if (isset($responseData["success"]) && $responseData["success"] == "true" && isset($responseData["data"]) && count($responseData["data"]) > 0) {

                // $responseData["data"]["email_id"] = '1';
                // $responseData["data"]["email_title"] = 'FW: Ourania Gouseti et al. (Eds): Interdisciplinary Approaches to Food Dgfdhgfhgfjhfjfhjfh...';

                if (isset($responseData["data"]["email_id"]) && $responseData["data"]["email_id"] != "") {

		            $emailViewUrl = $this->emailAnnotatorBaseUrl;

					$emailViewUrl = $emailViewUrl . "/id/" . $responseData["data"]["email_id"];


                    if (isset($responseData["data"]["email_title"]) && $responseData["data"]["email_title"] != "") {

                        $responseData["data"]['task_email_title_link'] = '<a class="btn-link" target="_blank" href="' . $emailViewUrl . '">' . mb_strimwidth($responseData["data"]["email_title"], 0, 65, "...") . '</a>';
                    }
                }


                if (isset($responseData["data"]["assingees"]) && is_array($responseData["data"]["assingees"]) && count($responseData["data"]["assingees"]) > 0) {

                    $assigness = $responseData["data"]["assingees"];

                    array_unshift($assigness, [
                        "empcode" => "common",
                        "empname" => "Common",
                        "description" => $responseData["data"]["description"]
                    ]);

                    $assignessDescriptionView = $this->assigneesDescriptionView($assigness);

                    if ($assignessDescriptionView != "") {

                        $responseData["data"]['assignessDescriptionView'] = $assignessDescriptionView;
                    }
                }

                // $responseData["data"]["checklist"] = [
                //     [
                //         "id" => "1",
                //         "check_list_id" => "1",
                //         "title" => "title1",
                //     ],
                //     [
                //         "id" => "2",
                //         "check_list_id" => "2",
                //         "title" => "title2",
                //     ],
                //     [
                //         "id" => "3",
                //         "check_list_id" => "3",
                //         "title" => "title3",
                //     ],
                //     [
                //         "id" => "4",
                //         "check_list_id" => "4",
                //         "title" => "title4",
                //     ]
                // ];

                if (isset($responseData["data"]["checklist"]) && is_array($responseData["data"]["checklist"]) && count($responseData["data"]["checklist"]) > 0) {

                    $taskCheckLists = $responseData["data"]["checklist"];

                    $taskCheckListView = $this->taskCheckListView($taskCheckLists);

                    if ($taskCheckListView != "") {

                        $responseData["data"]['taskCheckListView'] = $taskCheckListView;
                    }
                }

                $returnResponse = $responseData["data"];




                cache()->forget($returnResponse["task_id"]);
                cache([$returnResponse["task_id"] => $returnResponse], Config::get("session.lifetime"));
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
     * Edit the task based on task id.
     *
     * @return array $returnResponse
     */
    public function taskEdit($request)
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
                'task_id'       => 'required',
                // 'job_id'       => 'required',
                // 'stage'       => 'required',
                'title'       => 'required',
                'category'       => 'required',
                // 'status'       => 'required',
                'assignedto_empcode'       => 'required',
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Update failed";
            } else {

                $paramInfo = $request->all();

                // $paramInfo["task_no"] = $paramInfo["task_id"];

                unset($paramInfo["id"]);
                unset($paramInfo["_token"]);
                unset($paramInfo["files"]);
                // unset($paramInfo["task_id"]);
                unset($paramInfo["redirectTo"]);
                unset($paramInfo["current_job_id"]);
                unset($paramInfo["_wysihtml5_mode"]);

                $url = $this->taskUpdateApiUrl;

                $returnData = $this->postRequest($url, $paramInfo);

                if (isset($returnData["success"]) && $returnData["success"] == "true") {

                    $returnResponse["success"] = "true";
                    $returnResponse["message"] = "Update successfull";
                    cache()->forget($paramInfo["task_id"]);
                } else {

                    $returnResponse["error"] = "true";
                    $returnResponse["message"] = "Update unsuccessfull";
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
     * Update the task based on task id.
     *
     * @return array $returnResponse
     */
    public function taskUpdate($request)
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
                'task_id'       => 'required'
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Update failed";
            } else {

                $paramInfo = $request->all();

                $url = $this->taskUpdateApiUrl;

                $returnData = $this->postRequest($url, $paramInfo);

                if (isset($returnData["success"]) && $returnData["success"] == "true") {

                    $returnResponse["success"] = "true";
                    $returnResponse["message"] = "Update successfull";
                    cache()->forget($paramInfo["task_id"]);
                } else {

                    $returnResponse["error"] = "true";
                    $returnResponse["message"] = "Update unsuccessfull";
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
     * Update the task based on task id.
     *
     * @return array $returnResponse
     */
    public function taskFollowupUpdate($request)
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
                'task_id'       => 'required',
                'followup_type'       => 'required',
                'followup_date'       => 'required'
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Update failed";
            } else {

                $paramInfo = $request->all();

                $url = $this->taskFollowupDateUpdateApiUrl;

                $returnData = $this->postRequest($url, $paramInfo);

                if (isset($returnData["success"]) && $returnData["success"] == "true") {

                    $returnResponse["success"] = "true";
                    $returnResponse["message"] = "Update successfull";
                    cache()->forget($paramInfo["task_id"]);
                } else {

                    $returnResponse["error"] = "true";
                    $returnResponse["message"] = "Update unsuccessfull";
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
     * Close the task based on task id.
     *
     * @return array $returnResponse
     */
    public function taskClose($request)
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
                'task_id'       => 'required',
                'status'       => 'required',
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Task close failed";
            } else {

                $paramInfo = $request->all();

                $url = $this->taskUpdateApiUrl;

                $returnData = $this->postRequest($url, $paramInfo);

                if (isset($returnData["success"]) && $returnData["success"] == "true") {

                    $returnResponse["success"] = "true";
                    $returnResponse["message"] = "Task close successfull";
                    cache()->forget($paramInfo["task_id"]);
                } else {

                    $returnResponse["error"] = "true";
                    $returnResponse["message"] = "Task close unsuccessfull";
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
     * Delete the task based on task id.
     *
     * @return array $returnResponse
     */
    public function taskDelete($request)
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
                'task_id'       => 'required'
            );
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Delete failed";
            } else {

                // delete
                $url = $this->taskDeleteApiUrl;

                $returnData = $this->postRequest($url, ['task_id' => $request->get('task_id')]);

                if (isset($returnData["success"]) && $returnData["success"] == "true") {

                    $returnResponse["success"] = "true";
                    $returnResponse["message"] = "Delete successfull";
                    cache()->forget($request->get('task_id'));
                } else {

                    $returnResponse["error"] = "true";
                    $returnResponse["message"] = "Delete failed";
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
     * Get task select.
     *
     * @return array $returnData
     */
    public function getActiveTasks()
    {
        $returnData = "";

        try {

            $url = $this->taskSelectApiUrl;

            $returnData = $this->getRequest($url);

            if ($returnData["success"] == "true" && count($returnData["data"]) > 0 && $returnData["data"] != "") {

                $returnResponse = [];

                // array_walk($returnData["data"], function($item, $key) use(&$returnResponse) {

                //     if(base64_decode($item, true)) {

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
     * Get task select.
     *
     * @return array $returnData
     */
    public function getWorkflowTasks($request)
    {
        $returnData = "";

        try {

            // $request = json_decode(json_encode($request), true);

            $url = $this->workflowTaskSelectApiUrl;

            $paramInfo = [];

            if (isset($request["workflow_id"]) && $request["workflow_id"] != "") {

                $paramInfo["workflow_version"] = $request["workflow_id"];
            }

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
     * Get task select.
     *
     * @return array $returnData
     */
    public function getCheckListTasks($request)
    {
        $returnData = "";

        try {

            $request = json_decode(json_encode($request), true);

            $url = $this->checkListTaskSelectApiUrl;

            $paramInfo = [];

            if (is_array($request) && isset($request["job_id"]) && $request["job_id"] != "") {

                $paramInfo["job_id"] = $request["job_id"];
            }

            if (is_array($request) && isset($request["category"]) && $request["category"] != "") {

                $paramInfo["type"] = $request["category"];
            }

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
     * format task checklist view.
     *
     * @return array $item
     */

    public function taskCheckListView($items)
    {

        $returnData = '<div class="todo-box-wrap">';
        $returnData .= '<ul class="todo-list task-check-list todo-box-nicescroll-bar mb-0">';

        foreach ($items as $key => $item) {

            $taskCheckListView = "";

            $taskCheckListView .= $this->taskCheckListItemView($item);

            if ($taskCheckListView != "") {

                $returnData .= $taskCheckListView;
            }
        }

        // $returnData .= '<div class="new-todo">';
        // $returnData .= '<div class="input-group">';
        // $returnData .= '<input type="text" id="add_todo" name="example-input2-group2" class="form-control" placeholder="Add new task">';
        // $returnData .= '<span class="input-group-btn">';
        // $returnData .= '<button type="button" class="btn btn-primary">';
        // $returnData .= '<i class="zmdi zmdi-plus txt-success"></i>';
        // $returnData .= '</button>';
        // $returnData .= '</span>';
        // $returnData .= '</div>';
        // $returnData .= '</div>';

        $returnData .= '</ul>';
        $returnData .= '</div>';


        return $returnData;
    }


    /**
     * format assigness description view.
     *
     * @return array $item
     */

    public function assigneesDescriptionView($items)
    {

        $itemsTabView = "";
        $itemsContentView = "";

        $returnData = '<div class="pills-struct">';
        $returnData .= '<ul role="tablist" class="nav nav-pills nav-pills-outline" id="">';

        foreach ($items as $key => $item) {

            $itemsTabView .= $this->assigneesDescriptionTabView($item, $key);
            $itemsContentView .= $this->assigneesDescriptionContentView($item, $key);
        }

        if ($itemsTabView != "") {

            $returnData .= $itemsTabView;
        }
        $returnData .= '</ul>';
        $returnData .= '<div class="tab-content" id="">';

        if ($itemsContentView != "") {

            $returnData .= $itemsContentView;
        }

        $returnData .= '</div>';
        $returnData .= '</div>';

        return $returnData;
    }

    /**
     * format assigness description tab view.
     *
     * @return array $item
     */

    public function assigneesDescriptionTabView($item, $index)
    {

        // $taskNotificationItemCount = "";

        // if (isset($item["createdby_empcode"]) && isset($item["createdby_status"])) {

        //     if (isset($item["createdby_empcode"]) == auth()->user()->empcode && isset($item["createdby_status"]) == __("job.task_pending_status_text")) {

        //         if (isset($item["notification_count"]) &&  $item["notification_count"] != "0") {

        //             $taskNotificationItemCount .= '<span class="task-notification-item-count">';
        //             $taskNotificationItemCount .= '<span class="task-notification-item-count-icon-badge">';
        //             $taskNotificationItemCount .= $item["notification_count"];
        //             $taskNotificationItemCount .= '</span>';
        //             $taskNotificationItemCount .= '</span>';

        //         }

        //     }

        // }

        $statusIcon = $statusBadge = "";

        $returnData = '<li class="';

        if ((string) $index == "0") {

            $returnData .= ' active';
        }
        $returnData .= '" role="presentation">';
        $returnData .= '<a ';

        if ((string) $index == "0") {

            $returnData .= 'aria-expanded="true"';
        }

        $returnData .= ' data-toggle="tab" role="tab" id="';
        $returnData .= $item['empcode'] . '_tab"';
        $returnData .= ' class="';

        if (isset($item['task_status']) && $item['task_status'] != "") {

            // $returnData .= 'bg-' . $item['task_status'];

            if ($item['task_status'] == __("job.task_pending_status_text")) {

                $statusIcon = "icon-layers txt-purple";
            }

            if ($item['task_status'] == __("job.task_progress_status_text")) {

                $statusIcon = "icon-graph txt-navi-blue";
            }

            if ($item['task_status'] == __("job.task_delay_status_text")) {

                $statusIcon = "fa fa-exclamation-triangle txt-danger";
            }

            if ($item['task_status'] == __("job.task_hold_status_text")) {

                $statusIcon = "fa fa-lock txt-warning";
            }

            if ($item['task_status'] == __("job.task_escalation_status_text")) {

                $statusIcon = "glyphicon glyphicon-fire txt-orange";
            }

            if ($item['task_status'] == __("job.task_closed_status_text")) {

                $statusIcon = "fa fa-graduation-cap txt-success";
            }

            $statusBadge = '<i class="' . $statusIcon . ' data-right-rep-icon ml-5"></i>';
        }

        // if ($taskNotificationItemCount != "") {

        //     $returnData .= 'notification-item';

        // }

        $returnData .= ' assignedUserDescTab"';
        $returnData .= ' data-assignee-id="';
        $returnData .= $item['empcode'];

        if (isset($item['task_id']) && $item['task_id'] != "") {

            $returnData .= '" data-assignee-task-id="';
            $returnData .= $item['task_id'];

            $returnData .= '" data-assignee-note-list-url="';
            $returnData .= route(__('job.task_note_list_url'), $item['task_id']);
        }

        // if($taskNotificationItemCount !="") {

        //     $readLink = route(__("job.notification_read_url"), $item['task_id']) . "?type=task";
        //     $returnData .= '" data-notification-read-link="';
        //     $returnData .= $readLink;

        // }
        $returnData .= '" href="#';
        $returnData .= $item['empcode'];
        $returnData .= '">';
        $returnData .= $item['empname'];

        if ($statusBadge != "") {

            $returnData .= $statusBadge;
        }

        $returnData .= '</a>';
        // $returnData .= $taskNotificationItemCount;
        $returnData .= '</li>';

        return $returnData;
    }

    /**
     * format assigness description content view.
     *
     * @return array $item
     */

    public function assigneesDescriptionContentView($item, $index)
    {
        $returnData = '<div id="';
        $returnData .= $item['empcode'];
        $returnData .= '" class="tab-pane fade ';

        if ((string) $index == "0") {

            $returnData .= 'active in';
        }

        $returnData .= '" role="tabpanel">';
        $returnData .= '<p>';

        // if(base64_decode($item['description'], true)) {

        //     $item['description'] = base64_decode($item['description']);

        // }
        $returnData .= $item['description'];
        $returnData .= '</p>';
        $returnData .= '</div>';

        return $returnData;
    }

    /**
     * Get the task history by task field array.
     *
     * @param  array $field
     * @return array $returnResponse
     */
    public function taskHistory($field)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $url = $this->taskHistoryApiUrl;

            $responseData = $this->postRequest($url, $field);

            if ($responseData["success"] == "true" && count($responseData["data"]) > 0 && $responseData["data"] != "") {

                $responseData = $this->formatTaskHistoryData($responseData["data"]);

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
     * format task history result.
     *
     * @return array $resource
     */
    public function formatTaskHistoryData($items)
    {

        $returnData = [];

        if (count($items) > 0) {

            array_walk(

                $items,

                function ($item, $key) use (&$returnData) {

                    if (count($item) > 0) {

                        array_walk($item, function ($value, $key) use (&$returnData) {

                            $value["diary_view"] = $this->diaryView($value);

                            array_push($returnData, $value);
                        });
                    }
                }

            );
        }

        if (count($returnData) > 0) {

            usort($returnData, function ($a, $b) {

                if (isset($a['created_date']) && isset($b['created_date'])) {

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
     * Get the calendar task count by task field array.
     *
     * @param  array $field
     * @return array $returnData
     */
    public function taskCalendar($request)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $url = $this->taskCalendarCountApiUrl;

            // $responseData = $this->postRequest($url, $request);

            $responseData["success"] = "true";

            $responseData["data"] = [
                ["count" => "20", "due_date" => "2020-05-20"],
                ["count" => "20", "due_date" => "2020-06-20"],
                ["count" => "10", "due_date" => "2020-07-02"],
                ["count" => "30", "due_date" => "2020-08-15"]
            ];

            if (is_array($responseData) && $responseData["success"] == "true" && $responseData["data"] != "") {

                $responseData = $this->formattaskCalendarData($responseData["data"]);

                if ($responseData) {

                    $returnResponse["success"] = "true";
                    $returnResponse["data"] = $responseData;

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
     * format result.
     *
     * @return array $resource
     */
    public function formatTaskCalendarData($items)
    {

        $jobResource = new JobResource();

        $resource = array_map(

            function ($item) {

                $returnItem = [];

                $returnItem["title"] = Config::get('constants.calendaf_task_count_label', 'Tasks') . ": " . $item["count"];
                $returnItem["start"] = $item["due_date"];
                // $returnItem["end"] = $item["due_date"];

                return $returnItem;

            },

            $items

        );

        return $resource;

    }

    /**
     * format result.
     *
     * @return array $resource
     */
    public function formatData($items, $field)
    {

        $jobResource = new JobResource();

        $resource = array_map(

            function ($item) use ($field) {

                $partialcomplete = "false";

                $typeSuffix = $isUpdatedFlag = "";

				//$jobViewUrl = route(__("job.job_detail_url"), $item["job_id"]);


                // $jobResponse = $jobResource->getJobByParam(["job_id" => $item["job_id"]]);

                // if(isset($jobResponse["title"]) && $jobResponse["title"] != "") {

                //     $item['job_title'] =  $jobResponse["title"];

                // }

				if (isset($item["womat_job_id"]) && $item["womat_job_id"] != "") {

                    //$item['womat_job_id'] =  $jobResponse["womat_job_id"];
					$item["book_job_id"] = '<a target="_blank" href="' . route(__("job.job_detail_url"), $item["job_id"]) . '">'. $item["womat_job_id"] .'</a>' ;

                }

                // if (isset($jobResponse["order_id"]) && $jobResponse["order_id"] != "") {

                //     $item['order_id'] =  $jobResponse["order_id"];

                // }

                // if (isset($item['title']) && $item['title'] != "") {

                //     if (base64_decode($item["title"], true)) {

                //         $item['title'] = base64_decode($item["title"]);
                //     }

                // }

                // if (isset($item['description']) && $item['description'] != "") {

                //     if (base64_decode($item["description"], true)) {

                //         $item['description'] = base64_decode($item["description"]);
                //     }

                // }

                // if (isset($item['attachment_path']) && $item['attachment_path'] != "") {

                //     if (base64_decode($item["attachment_path"], true)) {

                //         $item['attachment_path'] = base64_decode($item["attachment_path"]);
                //     }

                // }

                $item['title'] = mb_strimwidth($item["title"], 0, 50, "...");

                // if($item['partialcomplete'] != "1") {

                $taskViewUrl = route(__("job.task_view_url"), (int) $item['task_id']);

                if (isset($item["partialcomplete"]) && $item["partialcomplete"] == "1") {

                    // $partialcomplete = "true";
                    $taskViewUrl = route(__("job.task_edit_url"), (int) $item['task_id']);

                    $typeSuffix = "(draft)";

                }

                // $taskViewUrl = $taskViewUrl . "?partialcomplete=" . $partialcomplete;

                if (isset($field["job_id"]) && $field["job_id"] != "") {

                    $taskViewUrl = $taskViewUrl . "&redirectTo=" . __("job.job_detail_url");
                }

                if (isset($item["email_id"]) && $item["email_id"] != "") {

                    $typeSuffix = "(email)";

                }

                if (isset($item["pmbot_type"]) && $item["pmbot_type"] == "generic") {

                    $typeSuffix = "(generic)";

                }

                if (isset($item["type"]) && $item["type"] != "") {

                    $item["type_text"] = $item["type"];
                    $item["type"] = $item["type_text"] . $typeSuffix;

                }

                if (isset($item["is_updated"]) && $item["is_updated"] == "1") {

                    $isUpdatedFlag = '<i class="fa fa-info-circle updated-flag"></i>';

                }

                $item["over_due_hours"] = $overdueClass = "";

                if (isset($item["followup_count"]) && $item["followup_count"] != "" && $item["followup_count"] != null && $item["followup_count"] > 0 && isset($item["category"]) && $item["category"] != "" && $item["category"] != null) {

                    $taskCategoryFollowupTime = [];

                    $taskCategoryFollowupTime = Config::get('constants.taskCategoryFollowupTime');

                    if (is_array($taskCategoryFollowupTime) && isset($taskCategoryFollowupTime[$item["category"]]) && $taskCategoryFollowupTime[$item["category"]] != "") {

                        $item["over_due_hours"] = (int) $item["followup_count"] * (int) $taskCategoryFollowupTime[$item["category"]];

                        $overdueClass = "text-danger";

                    }
                }

                $item['title'] = '<a class="btn-link ' . $overdueClass . '" href="' . $taskViewUrl . '">' . mb_strimwidth($item["title"], 0, 50, "...") . $isUpdatedFlag .'</a>';

                if (isset($item["followup_date"]) && $item["followup_date"] != "") {

                    $item["followup_date"] = date("y/m/d H:i:s", strtotime($item["followup_date"]));

                }

                // }

                // $item['diary_view'] = $this->diaryView($item);
                // $item['timeline_view'] = $this->taskTimelineView($item);

                return $item;
            },
            $items
        );

        return $resource;
    }
}
