<?php

namespace App\Resources\Job;

use Exception;
use League\Fractal\Manager;
use App\Traits\General\Helper;
use App\Traits\General\ApiClient;
use function GuzzleHttp\json_encode;
use App\Traits\General\CustomLogger;
use Illuminate\Support\Facades\Validator;

class NoteCollection
{

    use Helper;

    use ApiClient;

    use CustomLogger;

    protected $client;
    protected $fractal;

    protected $taskNoteListApiUrl;
    protected $taskNoteAddApiUrl;
    protected $taskNoteUpdateApiUrl;
    protected $taskNoteByFieldApiUrl;
    protected $taskNoteDeleteApiUrl;



    public function __construct()
    {
        // $this->client = new ApiClient();
        $this->fractal = new Manager();

        $this->taskNoteListApiUrl = env('API_TASK_NOTE_LIST_URL');
        $this->taskNoteAddApiUrl = env('API_TASK_NOTE_ADD_URL');
        $this->taskNoteUpdateApiUrl = env('API_TASK_NOTE_UPDATE_URL');
        $this->taskNoteByFieldApiUrl = env('API_TASK_NOTE_BY_FIELD_URL');
        $this->taskNoteDeleteApiUrl = env('API_TASK_NOTE_DELETE_URL');
    }

    /**
     * Get the task note list by task note field array.
     *
     * @param  array $field
     * @return array $returnData
     */
    public function taskNoteList($field)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $url = $this->taskNoteListApiUrl;

            $responseData = $this->postRequest($url, $field);

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
     * Add the task note.
     *
     * @return array $returnResponse
     */
    public function taskNoteAdd($request)
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
                'task_id'              => 'required',
                'status_previous'      => 'required',
                'empcode'              => 'required',
                'empname'              => 'required',
                'emprole'              => 'required',
            );

            $validator = Validator::make($request->all(), $rules);

            // process the login
            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Save failed";
            } else {

                $paramInfo = $request->all();

                
                unset($paramInfo["_token"]);
                unset($paramInfo["files"]);
                unset($paramInfo["redirectTo"]);
                unset($paramInfo["_wysihtml5_mode"]);
                
                $url = $this->taskNoteAddApiUrl;

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
     * Get the task note by task field array.
     *
     * @param  array $field
     * @return array $returnData
     */
    public function taskNoteListByField($field)
    {

        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $paramData = [];

            $url = $this->taskNoteByFieldApiUrl;

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
     * Get the task note by task field array.
     *
     * @param  array $field
     * @return array $returnData
     */
    public function getTaskNote($field)
    {
        $returnResponse = [];

        try {

            $url = $this->taskNoteByFieldApiUrl;
            
            $responseData = $this->postRequest($url, $field);

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
     * Edit the task note based on task note id.
     *
     * @return array $returnResponse
     */
    public function taskNoteEdit($request)
    {

        // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($request->all());echo '<PRE/>';exit;

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
                'id'       => 'required',
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Update failed";
            } else {

                $paramInfo = $request->all();

                unset($paramInfo["_token"]);
                // unset($paramInfo["task_id"]);
                unset($paramInfo["files"]);
                unset($paramInfo["redirectTo"]);
                unset($paramInfo["status_previous"]);
                unset($paramInfo["_wysihtml5_mode"]);
                unset($paramInfo["assignedto_status"]);

                $url = $this->taskNoteUpdateApiUrl;

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
     * Delete the task note based on task note id.
     *
     * @return array $returnResponse
     */
    public function taskNoteDelete($request)
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
                'id'       => 'required'
            );
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Delete failed";
            } else {

                // delete
                $url = $this->taskNoteDeleteApiUrl;
                
                $returnData = $this->postRequest($url, ['id' => $request->get('id')]);

                if (isset($returnData["success"]) && $returnData["success"] == "true") {

                    $returnResponse["success"] = "true";
                    $returnResponse["message"] = "Delete successfull";
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
     * format result.
     *
     * @return array $resource
     */
    public function formatData($items)
    {

        $resource = array_map(

            function ($item) {

                $item['user_image'] = asset('public/img/user1.png');

                $item['empinitial'] = implode('', array_map(function ($v) { return strtoupper($v[0]); }, explode(' ', trim($item["empname"]))));

                if (strlen($item['empinitial']) > 2) {

                    $item['empinitial'] = substr($item['empinitial'], 0, 2);

                }

                $item['formated_created_date'] = date('g:ia \o\n l jS F Y', strtotime($item['created_date']));

                if (isset($item['additional_note']) && $item['additional_note'] != "") {

                    $item['additional_note'] = htmlentities($item['additional_note']);

                }

                // if(isset($item['additional_note']) && $item['additional_note'] != "") {

                //     if (base64_decode($item["additional_note"], true)) {

                //         $item['additional_note'] = base64_decode($item["additional_note"]);
                //     }

                // }

                // if (isset($item['attachment_path']) && $item['attachment_path'] != "") {

                //     if (base64_decode($item["attachment_path"], true)) {

                //         $item['attachment_path'] = base64_decode($item["attachment_path"]);
                //     }

                // }
                
                // $item['title'] = '<a class="btn-link" href="' . route('task-view', (int) $item['task_id']) . '">' . $item['title'] . '</a>';
                // $item['diary_view'] = $this->taskDiaryView($item);
                // $item['timeline_view'] = $this->taskTimelineView($item);

                return $item;
            },
            $items
        );

        return $resource;
    }

}

