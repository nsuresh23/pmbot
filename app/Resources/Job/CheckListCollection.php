<?php

namespace App\Resources\Job;

use Exception;
use League\Fractal\Manager;
use App\Models\Job\CheckList;
use App\Traits\General\Helper;
use App\Traits\General\ApiClient;
use function GuzzleHttp\json_encode;
use App\Traits\General\CustomLogger;
use Illuminate\Support\Facades\Validator;
use App\Resources\Job\TaskCollection as TaskResource;

// class CheckListCollection extends ResourceCollection


class CheckListCollection
{

    use Helper;

    use ApiClient;

    use CustomLogger;

    protected $client;
    protected $fractal;

    protected $checkListApiUrl;
    protected $checkListAddApiUrl;
    protected $checkListUpdateApiUrl;

    protected $checkListByFieldApiUrl;
    protected $checkListDeleteApiUrl;

    public function __construct()
    {
        // $this->client = new ApiClient();
        $this->fractal = new Manager();

        $this->checkListApiUrl = env('API_CHECK_LIST_URL');
        $this->checkListAddApiUrl = env('API_CHECK_LIST_ADD_URL');
        $this->checkListUpdateApiUrl = env('API_CHECK_LIST_UPDATE_URL');
        $this->checkListDeleteApiUrl = env('API_CHECK_LIST_DELETE_URL');
        $this->checkListByFieldApiUrl = env('API_CHECK_LIST_BY_FIELD_URL');

    }

    /**
     * Get the check list from the check_list Table.
     *
     * @param string $id
     * @return array $returnResponse
     */
    public function getAllCheckList($field)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $paramData = [];

            $url = $this->checkListApiUrl;

            if(is_array($field) && count($field) > 0) {

                $paramData = $field;

            }

            $responseData = $this->postRequest($url, $paramData);

            if ($responseData["success"] == "true" && count($responseData["data"]) > 0 && $responseData["data"] != "") {

                $responseFormatData = $this->formatData($responseData["data"]);

                if ($responseFormatData) {

                    $returnResponse["success"] = "true";
                    $returnResponse["data"] = $responseFormatData;

                    if (isset($responseData["result_count"]) && $responseData["result_count"] != "") {

                        $returnResponse["result_count"] = $responseData["result_count"];

                    } else if (is_array($responseData)) {

                        $returnResponse["result_count"] = count($responseFormatData);

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
     * Add the check list to the check_list Table.
     *
     * @return array $returnResponse
     */
    public function checkListAdd($request)
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
                'location'       => 'required',
                // 'tasklist'       => 'required',
                'title'       => 'required',
                'empcode'       => 'required',
                'empname'       => 'required',
            );


            if ($request->job_id && $request->job_id != "") {

                unset($rules['location']);
                unset($rules['tasklist']);
                $rules['job_id'] = 'required';

            }

            $url = $this->checkListAddApiUrl;

            $validator = Validator::make($request->all(), $rules);

            // process the login
            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Save failed";

            } else {

                $paramInfo = $request->all();

                unset($paramInfo["c_id"]);
                unset($paramInfo["files"]);
                unset($paramInfo["_token"]);
                unset($paramInfo["redirectTo"]);
                unset($paramInfo["_wysihtml5_mode"]);

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
     * Get the check list from the check_list Table by check list field array.
     *
     * @param  array $field
     * @return array $returnData
     */
    public function getCheckListByField($field)
    {

        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $paramData = [];

            $url = $this->checkListByFieldApiUrl;

            $paramData = $field;

            $responseData = $this->postRequest($url, $paramData);

            if ($responseData["success"] == "true" && count($responseData["data"]) > 0 && $responseData["data"] != "") {

                $responseData = $this->formatData($responseData["data"]);

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
     * Get the check list from the check list Table by check list field array.
     *
     * @param  array $field
     * @return array $returnData
     */
    public function getCheckList($field)
    {
        $returnResponse = [];

        try {

            // $field = [
            //     ['name', 'test'],
            //     ['id', '<>', '5']
            // ];

            $paramData = [];

            $url = $this->checkListByFieldApiUrl;

            $paramData = $field;

            unset($paramData["job_id"]);

            $responseData = $this->postRequest($url, $paramData);

            if (isset($responseData["success"]) && $responseData["success"] == "true") {

                // $responseData["data"]['task_title_link'] = '-';
                // $responseData["data"]['task_title'] = '-';

                // if (isset($responseData["data"]['t_id']) && $responseData["data"]['t_id'] != "") {

                //     $taskResource = new TaskResource();

                //     $taskResponse = $taskResource->getTask(["task_id" => $responseData["data"]['t_id']]);

                //     if (isset($taskResponse["title"]) && $taskResponse["title"] != "") {

                //         $responseData["data"]['task_title'] =  mb_strimwidth($taskResponse['title'], 0, 50, "...");

                //         $responseData["data"]['task_title_link'] =  '<a class="btn-link" href="' . route(__('job.task_view_url'), (int) $taskResponse['task_id']) . '">' . mb_strimwidth($taskResponse['title'], 0, 50, "...") . '</a>';

                //     }

                // }

                if (isset($responseData["data"]["tasklist"]) && is_array($responseData["data"]["tasklist"]) && count($responseData["data"]["tasklist"]) > 0) {

                    $checkListTasks = $responseData["data"]["tasklist"];

                    $checkListTasksIds = array_column($responseData["data"]["tasklist"], "task_id");

                    if(is_array($checkListTasksIds) && count($checkListTasksIds) > 0) {


                        $responseData["data"]['task_list'] = $checkListTasksIds;

                    }

                    $checkListTaskView = $this->checkListTaskView($checkListTasks);

                    if ($checkListTaskView != "") {

                        $responseData["data"]['checkListTaskView'] = $checkListTaskView;
                    }
                }

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
     * Edit the check list in check list table based on check list id.
     *
     * @return array $returnResponse
     */
    public function checkListEdit($request)
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
                "c_id"       => "required",
                "location"      => "required",
                "title"      => "required",
            );

            $url = $this->checkListUpdateApiUrl;

            if ($request->job_id && $request->job_id != "") {

                unset($rules["location"]);

                $rules["job_id"] = "required";
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Update failed";

            } else {

                $paramInfo = $request->all();

                unset($paramInfo["id"]);
                unset($paramInfo["files"]);
                unset($paramInfo["_token"]);
                unset($paramInfo["redirectTo"]);
                unset($paramInfo["_wysihtml5_mode"]);

                $returnData = $this->postRequest($url, $paramInfo);

                if (isset($returnData["success"]) && $returnData["success"] == "true") {

                    $returnResponse["success"] = "true";
                    $returnResponse["message"] = "Update successfull";

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
     * Delete the check list in check list table based on check list id.
     *
     * @return array $returnResponse
     */
    public function checkListDelete($request)
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
                'c_id'       => 'required'
            );
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Delete failed";

            } else {

                // delete

                $url = $this->checkListDeleteApiUrl;

                $returnData = $this->postRequest($url, ['c_id' => $request->get('c_id')]);

                if (isset($returnData["success"]) && $returnData["success"] == "true") {

                    $returnResponse["success"] = "true";
                    $returnResponse["message"] = "Delete successfull";

                } else {

                    $returnResponse["error"] = "true";
                    $returnResponse["message"] = "Delete unsuccessfull";

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
     * format task checklist view.
     *
     * @return array $item
     */

    public function checkListTaskView($items)
    {

        $checklistReturnData = $returnData = "";

        foreach ($items as $key => $item) {

            $checkListTaskView = "";

            $checkListTaskView .= $this->checkListTaskItemView($item);

            if ($checkListTaskView != "") {

                $checklistReturnData .= $checkListTaskView;

            }
        }

        if($checklistReturnData != "") {

            $returnData = "";

            $returnData .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
                $returnData .= '<div class="row">';
                    $returnData .= '<div class="bootstrap-tagsinput">';
                    $returnData .= $checklistReturnData;
                    $returnData .= '</div>';
                $returnData .= '</div>';
            $returnData .= '</div>';

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

        $taskResource = new TaskResource();

        $resource = array_map(

            function ($item) use ($taskResource) {

                $status = false;

                $jobQueryParam = "";

                if(isset($item['status']) && $item['status'] == 1) {

                    $status = true;

                }

                // $item['t_id']   = isset($item['t_id']) ? $item['t_id'] : '';

                $item['task_title'] = $item['task_title_original'] =  '-';

                if (isset($item['t_id']) && $item['t_id'] != "") {

                    $taskResponse = $taskResource->getTask(["task_id" => $item["t_id"]]);

                    if (isset($taskResponse["title"]) && $taskResponse["title"] != "") {

                        // if (base64_decode($taskResponse["title"], true)) {

                        //     $taskResponse["title"] = base64_decode($taskResponse["title"]);
                        // }

                        $item['task_title_original'] =  $taskResponse["title"];

                        $item['task_title'] =  '<a class="btn-link" href="' . route(__('job.task_view_url'), (int) $taskResponse['task_id']) . '">' . mb_strimwidth($taskResponse['title'], 0, 50, "...") . '</a>';

                    }

                }

                if (isset($item['job_id']) && $item['job_id'] != "") {


                    $jobQueryParam = "?job_id=". $item['job_id'];

                    if (isset($item['status']) && $item['status'] != "") {

                        $status = $item['status'];
                    }

                }

                $item['status'] = $status;

                $item['job_id']   = isset($item['job_id'])? $item['job_id']:'';
                $item['remarks']   = isset($item['remarks']) ? $item['remarks'] : '';
                $item['location']   = isset($item['location']) ? $item['location'] : '';

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

                $item['title_original']   = isset($item['title']) ? $item['title'] : '';
                $item['title']   = '<a class="btn-link" href="' . route(__('job.check_list_view_url'), (int) $item['c_id']) . $jobQueryParam . '">' . mb_strimwidth($item['title'], 0, 50, "...") . '</a>';

                return $item;

            },

            $items
        );

        return $resource;

    }

}
