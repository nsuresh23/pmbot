<?php

namespace App\Http\Controllers\Job;

use Session;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use App\Traits\General\Helper;
use App\Http\Controllers\Controller;
use App\Models\Annotation;
use Illuminate\Support\Facades\Config;
use App\Traits\General\CustomLogger;
use Illuminate\Support\Facades;
use App\Resources\Job\JobCollection as JobResource;
use App\Resources\Job\EmailCollection as EmailResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class EmailController extends Controller
{

    use Helper;

    use CustomLogger;

    protected $jobResource = "";

    protected $emailResource = "";

    public function __construct()
    {

        $this->jobResource = new JobResource();
        $this->emailResource = new EmailResource();

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
    }

    /**
     * Display a email rules.
     *
     * @return Response
     */
    public function fetchEmailRules(Request $request)
    {

        $returnResponse = [];

        try {

            $method = $_SERVER['REQUEST_METHOD'];

            $paramInfo = $returnData = [];

            $request->merge(['empcode' => auth()->user()->empcode]);

            if (in_array(auth()->user()->role, Config::get('constants.pmUserRoles')) && auth()->user()->lead_pm) {

                $request->merge(['lead_pm' => auth()->user()->lead_pm]);

            }

            if (auth()->check()) {

                $request->merge(['creator_empcode' => auth()->user()->empcode]);

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $request->merge(['creator_empcode' => session()->get("current_empcode")]);
                }

            }

            $paramInfo = $request->all();

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


                if(array_key_exists("status", $filterData)) {

                    if ($filterData["status"] == "false") {

                        $filterData["status"] = "0";

                    }

                    if($filterData["status"] == "true") {

                        $filterData["status"] = "1";

                    }

                }

            }

            if(is_array($paramInfo) && isset($paramInfo["s_no"])) {

                unset($paramInfo["s_no"]);

            }

            if ($method == "GET") {

                if (is_array($paramInfo) && isset($paramInfo["creator_empcode"])) {

                    unset($paramInfo["creator_empcode"]);

                }

                if (isset($filterData) && is_array($filterData) && count($filterData) > 0) {

                    $paramInfo["filter"] = $filterData;

                }

                $returnResponse = $this->emailResource->emailRules($paramInfo);

            }

            if ($method == "POST") {

                $status = "0";

                if ($paramInfo["status"] == "true") {

                    $status = "1";
                }

                $paramInfo["status"] = $status;

                $returnData = $this->emailResource->emailAddRule($paramInfo);

                if (is_array($returnData) && isset($returnData["success"]) && $returnData["success"] == "true") {

                    $params = [];

                    $params["empcode"] = auth()->user()->empcode;

                    if (isset($filterData) && is_array($filterData) && count($filterData) > 0) {

                        $params["filter"] = $filterData;

                    }

                    $returnResponse = $this->emailResource->emailRules($params);

                    if (is_array($returnResponse) && isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

                        $returnResponse["message"] = $returnData["message"];

                    }

                }

            }

            if ($method == "PUT") {

                $status = "0";

                if ($paramInfo["status"] == "true") {

                    $status = "1";
                }

                $paramInfo["status"] = $status;

                $returnData = $this->emailResource->emailUpdateRule($paramInfo);

                if (is_array($returnData) && isset($returnData["success"]) && $returnData["success"] == "true") {

                    $params = [];

                    $params["empcode"] = auth()->user()->empcode;

                    if (isset($filterData) && is_array($filterData) && count($filterData) > 0) {

                        $params["filter"] = $filterData;

                    }

                    $returnResponse = $this->emailResource->emailRules($params);

                    if (is_array($returnResponse) && isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

                        $returnResponse["message"] = $returnData["message"];

                    }

                }

            }

            if ($method == "DELETE") {

                $paramInfo["status"] = "0";

                $returnData = $this->emailResource->emailDeleteRule($paramInfo);

                if (is_array($returnData) && isset($returnData["success"]) && $returnData["success"] == "true") {

                    $params = [];

                    $params["empcode"] = auth()->user()->empcode;

                    if (isset($filterData) && is_array($filterData) && count($filterData) > 0) {

                        $params["filter"] = $filterData;

                    }

                    $returnResponse = $this->emailResource->emailRules($params);

                    if (is_array($returnResponse) && isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

                        $returnResponse["message"] = $returnData["message"];

                    }

                }

            }

        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        //if ($request->ajax()) {

        return json_encode($returnResponse);
        //}

        return view("errors.error404");



        // $returnData["redirectTo"] = "";

        // if ($request->redirectTo) {

        //     $returnData["redirectTo"] = $request->redirectTo;
        // }

    }

    /**
     * Display a email templates.
     *
     * @return Response
     */
    public function fetchEmailTemplates(Request $request)
    {

        $returnResponse = [];

        try {

            $method = $_SERVER['REQUEST_METHOD'];

            $paramInfo = $returnData = [];

            $request->merge(['empcode' => auth()->user()->empcode]);

            if (auth()->check()) {

                $request->merge(['creator_empcode' => auth()->user()->empcode]);

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $request->merge(['creator_empcode' => session()->get("current_empcode")]);
                }
            }

            $paramInfo = $request->all();

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


                if (array_key_exists("status", $filterData)) {

                    if ($filterData["status"] == "false") {

                        $filterData["status"] = "0";
                    }

                    if ($filterData["status"] == "true") {

                        $filterData["status"] = "1";
                    }
                }

            }

            if (is_array($paramInfo) && isset($paramInfo["s_no"])) {

                unset($paramInfo["s_no"]);
            }

            if ($method == "GET") {

                if (is_array($paramInfo) && isset($paramInfo["creator_empcode"])) {

                    unset($paramInfo["creator_empcode"]);
                }

                if (isset($filterData) && is_array($filterData) && count($filterData) > 0) {

                    $paramInfo["filter"] = $filterData;
                }

                $returnResponse = $this->emailResource->emailTemplates($paramInfo);
            }

            if ($method == "POST") {

                $returnData = $this->emailResource->emailTemplates($paramInfo);

                if (is_array($returnData) && isset($returnData["success"]) && $returnData["success"] == "true") {

                    $returnResponse = $returnData;

                    if (isset($returnResponse["data"]) && is_array($returnResponse["data"]) && count($returnResponse["data"]) > 0) {

                        if (isset($paramInfo["template"]) && $paramInfo["template"] != '') {

                            if(isset($returnResponse["data"][$paramInfo["template"]])) {

                                $returnResponse["data"]["body_html"] = $returnResponse["data"][$paramInfo["template"]];

                            }

                            if (is_array(Config::get('constants.email_template_variables')) && count(Config::get('constants.email_template_variables')) > 0) {

                                $returnResponse["data"]["email_template_variables"] = Config::get('constants.email_template_variables');

                            }

                            $emailTemplateVariables = [];

                            $emailTemplateVariables["pm_name"] = auth()->user()->empname;
                            $emailTemplateVariables["pm_signature"] = auth()->user()->empname;

                            if(isset($paramInfo["job_id"]) && $paramInfo["job_id"]) {

                                $returnJobResponse = [];

                                $returnJobResponse = $this->jobResource->getJobByParam(["job_id" => $paramInfo["job_id"]]);

                                if(is_array($returnJobResponse) && count($returnJobResponse) > 0) {

                                    if(isset($returnJobResponse["author"]) && $returnJobResponse["author"] != null && $returnJobResponse["author"] != "") {

                                        $emailTemplateVariables["author_name"] = $returnJobResponse["author"];

                                    }

                                    if(isset($returnJobResponse["author_email"]) && $returnJobResponse["author_email"] != null && $returnJobResponse["author_email"] != "") {

                                        $emailTemplateVariables["author_email"] = $returnJobResponse["author_email"];

                                    }

                                    if(isset($returnJobResponse["pe_name"]) && $returnJobResponse["pe_name"] != null && $returnJobResponse["pe_name"] != "") {

                                        $emailTemplateVariables["pe_name"] = $returnJobResponse["pe_name"];

                                    }

                                    if(isset($returnJobResponse["created_date"]) && $returnJobResponse["created_date"] != null && $returnJobResponse["created_date"] != "") {

                                        $date = new DateTime($returnJobResponse["created_date"]);

                                        $projectStartDate =  $date->format('Y/m/d');

                                        $emailTemplateVariables["project_start_date"] = $projectStartDate;

                                    }

                                }

                            }

                            if(is_array($emailTemplateVariables) && count($emailTemplateVariables) > 0) {

                                $returnResponse["data"]["template_variables"] = $emailTemplateVariables;

                            }

                        }

                    }

                }

            }

        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        return json_encode($returnResponse);

    }

    /**
     * Display a email ratings.
     *
     * @return Response
     */
    public function fetchEmailRatings(Request $request)
    {

        $returnResponse = [];

        try {

            $method = $_SERVER['REQUEST_METHOD'];

            $paramInfo = $returnData = [];

            $request->merge(['empcode' => auth()->user()->empcode]);

            if (auth()->check()) {

                // $request->merge(['creator_empcode' => auth()->user()->empcode]);

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $request->merge(['creator_empcode' => session()->get("current_empcode")]);
                }
            }

            $paramInfo = $request->all();

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

            }

            if ($method == "GET") {

                if (is_array($paramInfo) && isset($paramInfo["creator_empcode"])) {

                    unset($paramInfo["creator_empcode"]);
                }

                if (isset($filterData) && is_array($filterData) && count($filterData) > 0) {

                    $paramInfo["filter"] = $filterData;
                }

                $returnResponse = $this->emailResource->emailRules($paramInfo);
            }

            if ($method == "POST") {

                $returnResponse = $this->emailResource->emailUpdateRating($paramInfo);

            }

            if ($method == "PUT") {

                $returnResponse = $this->emailResource->emailUpdateRating($paramInfo);

            }

            if ($method == "DELETE") {

                // $returnResponse = $this->emailResource->emailDeleteRating($paramInfo);

            }
        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        //if ($request->ajax()) {

        return json_encode($returnResponse);
        //}

        return view("errors.error404");



        // $returnData["redirectTo"] = "";

        // if ($request->redirectTo) {

        //     $returnData["redirectTo"] = $request->redirectTo;
        // }

    }


    /**
     * Update email label in email table by email id.
     *
     * @return json returnResponse
     */
    public function emailLabelUpdate(Request $request)
    {

        $returnResponse = [];

        try {

            $request->merge(['empcode' => auth()->user()->empcode]);
            $request->merge(['start_time' => date('Y-m-d H:i:s')]);
            $request->merge(['ip_address' => $request->ip()]);

            if (auth()->check()) {

                $request->merge(['creator_empcode' => auth()->user()->empcode]);

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $request->merge(['creator_empcode' => session()->get("current_empcode")]);

                }

            }

            $returnResponse = $this->emailResource->emailLabelUpdate($request);

        } catch (Exeception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        // if ($redirectRouteAction) {

        //     // $redirectUrl = redirect()->action($redirectRouteAction);
        //     $returnResponse["redirectTo"] = route('home');
        // }

        return json_encode($returnResponse);

    }

    /**
     * Update email label in email table by email id.
     *
     * @return json returnResponse
     */
    public function dashboardEmailLabelUpdate(Request $request)
    {

        $returnResponse = [];

        try {

            $request->merge(['empcode' => auth()->user()->empcode]);
            $request->merge(['start_time' => date('Y-m-d H:i:s')]);
            $request->merge(['ip_address' => $request->ip()]);

            if (auth()->check()) {

                $request->merge(['creator_empcode' => auth()->user()->empcode]);

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $request->merge(['creator_empcode' => session()->get("current_empcode")]);
                }
            }

            if (isset($request->id) && $request->id != "") {

                $request->merge(['id' => json_decode($request->id, true)]);
            }

            if (isset($request->label_name) && $request->label_name != "") {

                $label_name_split = explode("_", $request->label_name);

                if (is_array($label_name_split) && count($label_name_split) > 0) {

                    if (count($label_name_split) > 1 && $label_name_split[0] == "job") {

                        $request->merge(['job_id' => $label_name_split[1]]);
                        $request->merge(['status' => "2"]);
                        $request->merge(['type' => "pmbot"]);

                        // unset($request["label_name"]);

                    } else {

                        $request->merge(['type' => "non_pmbot"]);
                        $request->merge(['status' => "3"]);

                    }

                }
            }

            $returnResponse = $this->emailResource->emailLabelUpdate($request);
        } catch (Exeception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        // if ($redirectRouteAction) {

        //     // $redirectUrl = redirect()->action($redirectRouteAction);
        //     $returnResponse["redirectTo"] = route('home');
        // }

        return json_encode($returnResponse);
    }

    /**
     * Display a email compose form.
     *
     * @return Response
     */
    public function emailCompose(Request $request)
    {

        $returnData = [];

        $returnData["redirectTo"] = "";

        if ($request->redirectTo) {

            $returnData["redirectTo"] = $request->redirectTo;
        }

        return view('pages.annotator.emailComposeModal', compact("returnData"));

    }

    /**
     * Display a email draft form.
     *
     * @return Response
     */
    public function emailDraft(Request $request)
    {

        $returnData = [];

        $returnData["redirectTo"] = "";

        if ($request->redirectTo) {

            $returnData["redirectTo"] = $request->redirectTo;
        }

        return view('pages.annotator.emailDraftModal', compact("returnData"));
    }

    /**
     * Display a email reply form.
     *
     * @return Response
     */
    public function emailReply(Request $request)
    {

        $returnData = [];

        if ($request->redirectTo) {

            $request->merge(['emailid' => $request->redirectTo]);

            $returnData = $this->emailGet($request);

            //$this->emailValidUserCheck($returnData);

            $returnData["email_template_list"] = [];

            if (is_array(Config::get('constants.email_template_list')) && count(Config::get('constants.email_template_list')) > 0) {

                $returnData["email_template_list"] = Config::get('constants.email_template_list');

            }

            $returnData["redirectTo"] = route(__("job.email_view_url"), $request->redirectTo);

        }

        return view('pages.annotator.emailReplyModal', compact("returnData"));
    }

    /**
     * Display a email reply all form.
     *
     * @return Response
     */
    public function emailReplyAll(Request $request)
    {

        $returnData = [];

        if ($request->redirectTo) {

            $request->merge(['emailid' => $request->redirectTo]);

            $returnData = $this->emailGet($request);

            //$this->emailValidUserCheck($returnData);
			if (is_array($returnData) && isset($returnData["success"]) && $returnData["success"] == "true") {

                if (isset($returnData["data"]) && is_array($returnData["data"]) && count($returnData["data"]) > 0) {

                    if (isset($returnData["data"]["email_to"]) && $returnData["data"]["email_to"] != "") {

                        $toEmails = [];

                        $toEmails = explode(';', $returnData["data"]["email_to"]);

                        if (is_array($toEmails) && count($toEmails) > 0) {

                            array_walk($toEmails, function ($value, $key) use ($returnData, &$toEmails) {

                                if (stripos($value, auth()->user()->empcode) !== false) {

                                    unset($toEmails[$key]);
                                }

                                if (stripos($value, $returnData["data"]["email_from"]) !== false) {

                                    unset($toEmails[$key]);
                                }
                            });
                        }
                        $replyAllToEmails = implode(";", $toEmails);

                        $returnData["data"]["email_replay_all_to"] = $returnData["data"]["email_from"] . ";" . $replyAllToEmails;

                        // $returnData["data"]["email_replay_all_to"] = $returnData["data"]["email_from"] . ";" . str_replace($returnData["data"]["email_from"] . ";", "", $returnData["data"]["email_to"]);

                    }
                }
            }

            $returnData["email_template_list"] = [];

            if (is_array(Config::get('constants.email_template_list')) && count(Config::get('constants.email_template_list')) > 0) {

                $returnData["email_template_list"] = Config::get('constants.email_template_list');

            }

            $returnData["redirectTo"] = route(__("job.email_view_url"), $request->redirectTo);

        }

        return view('pages.annotator.emailReplyAllModal', compact("returnData"));
    }

    /**
     * Display a email forward form.
     *
     * @return Response
     */
    public function emailForward(Request $request)
    {

        $returnData = [];

        if ($request->redirectTo) {

            $request->merge(['emailid' => $request->redirectTo]);

            $returnData = $this->emailGet($request);

            //$this->emailValidUserCheck($returnData);

            $returnData["email_template_list"] = [];

            if (is_array(Config::get('constants.email_template_list')) && count(Config::get('constants.email_template_list')) > 0) {

                $returnData["email_template_list"] = Config::get('constants.email_template_list');

            }

            $returnData["redirectTo"] = route(__("job.email_view_url"), $request->redirectTo);

        }

        return view('pages.annotator.emailForwardModal', compact("returnData"));
    }

    /**
     * sent email count.
     *
     *  @return json response
     */
    public function emailSentCount(Request $request)
    {

        $returnResponse = [];

        try {

            $returnResponse = $this->emailResource->emailSentCount($request);

        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        //if ($request->ajax()) {

        return json_encode($returnResponse);

        //}

    }

    /**
     * pms email count.
     *
     *  @return json response
     */
    public function pmsEmailCount(Request $request)
    {

        try {

            $returnResponse = [];

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

                $request->merge(['filter' => $filterData]);

            }

            $returnResponse = $this->emailResource->pmsEmailCount($request);

        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        //if ($request->ajax()) {

        return json_encode($returnResponse);
        //}

        return view("errors.error404");
    }

    /**
     * Show the email detail.
     *
     *  @return json response
     */
    public function emailList(Request $request)
    {

        try {

            $field = [];

            $returnResponse = [];

            $filterData = [];

            if (isset($request->filter) && is_array($request->filter) && count($request->filter) > 0) {

                $filterData = $request->filter;

                $formatData = [

                    "subject_link" => "subject",
                    "is_attachments" => "attachments",
                    "is_priority" => "priority",

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

                if (isset($request->status) && $request->status != "") {

                    $emailStatus = implode(",", $request->status);

                    if (in_array($emailStatus, ["0", "1", "2", "3", "7"])) {

                        if (array_key_exists("created_date", $filterData)) {

                            $filterData["email_received_date"] = $filterData["created_date"];

                            unset($filterData["created_date"]);
                        }
                    }

                    if (in_array($emailStatus, ["4", "5", "55"])) {

                        if (array_key_exists("created_date", $filterData)) {

                            $filterData["modified_date"] = $filterData["created_date"];
                        }
                    }

                    if (in_array($emailStatus, ["6", "8", "99"])) {

                        if (array_key_exists("created_date", $filterData)) {

                            $filterData["email_sent_date"] = $filterData["created_date"];

                            unset($filterData["created_date"]);
                        }
                    }
                }

                $field["filter"] = $filterData;

            }

            if (isset($request->job_id) && $request->job_id != "") {
                $field["job_id"] = $request->job_id;
            }

            if (isset($request->status) && $request->status != "") {

                $field["status"] = implode(",", $request->status);
            }

            if (isset($request->email_filter) && $request->email_filter != "") {

                $field["email_filter"] = $request->email_filter;
            }

            if (isset($request->label_name) && $request->label_name != "") {

                $field["label_name"] = $request->label_name;

            }

            if (isset($request->email_type) && $request->email_type != "") {

                $field["email_type"] = $request->email_type;

            }

            if (isset($request->type) && $request->type != "") {

                $field["type"] = $request->type;

                if (isset($field["status"]) && $field["status"] == "8") {

                    $field["type"] = "pmbot";

                }

            }

            if (isset($request->category) && $request->category != "") {

                $field["category"] = $request->category;

            }

            if (isset($request->empcode) && $request->empcode != "") {

                $field["current_empcode"] = $request->empcode;

            }

            if (isset($request->pe_email) && $request->pe_email != "") {

                $field["pe_email"] = $request->pe_email;

            }

            if (isset($request->author_email) && $request->author_email != "") {

                $field["author_email"] = $request->author_email;

            }

            if (isset($request->sort_type) && $request->sort_type != "") {

                $field["sort_type"] = $request->sort_type;

            }

            if (isset($request->sort_limit) && $request->sort_limit != "") {

                $field["sort_limit"] = $request->sort_limit;

            }

            if (isset($request->range) && $request->range != "") {

                $rangeValue = explode(' to ', $request->range);

                if (is_array($rangeValue)) {

                    if (count($rangeValue) > 0) {

                        $field["fromdate"] = $rangeValue[0];

                        if (count($rangeValue) > 1) {

                            $field["todate"] = $rangeValue[1];
                        }
                    }
                }

                // $filterData["range"] = $filterOption["range"];

            }


            $field["empcode"] = auth()->user()->empcode;

            if (isset($request->email_type) && $request->email_type == "email-review-latest") {

                if (isset($request->email_id) && $request->email_id != "") {

                    $field["email_id"] = $request->email_id;

                }

                if (isset($request->fromdate) && $request->fromdate != "") {

                    $field["fromdate"] = $request->fromdate;

                }

                if (isset($request->subject) && $request->subject != "") {

                    $field["subject"] = $request->subject;

                }

            }

            if (count($field) > 0) {

                $returnResponse = $this->emailResource->emailList($field);
            }
        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        //if ($request->ajax()) {

        return $returnResponse;
        // return json_encode($returnResponse);
        //}

        return view("errors.error404");
    }

    /**
     * Update email status in email table by email id.
     *
     * @return json returnResponse
     */
    public function emailStatusUpdate(Request $request)
    {

        $returnResponse = [];

        $redirectRouteAction = $redirectTo = "";

        $emailId = $jobId = "";

        try {

            $redirectRouteAction = $this->roleBasedDashboardRouteAction($request);

            $paramInfo = $request->all();

            if (isset($paramInfo["id"]) && $paramInfo["id"] != "") {

                $emailId = $paramInfo["id"];

            }

            if (isset($paramInfo["job_id"]) && $paramInfo["job_id"] != "") {

                $jobId = $paramInfo["job_id"];

            }

            if (auth()->check()) {

                $request->merge(['creator_empcode' => auth()->user()->empcode]);

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $request->merge(['creator_empcode' => session()->get("current_empcode")]);

                }

            }

            $returnResponse = $this->emailResource->emailStatusUpdate($request);

            if (is_array($returnResponse) && isset($returnResponse["success"]) && $returnResponse["success"] == "true" && $emailId != "") {


                if ($jobId != "") {

                    Annotation::where("jobid", $jobId)->delete();

                }

                if ($emailId != "") {

                    $returnResponse["redirectTo"] = env("EMAIL_ANNOTATOR_BASE_URL") . "/id/" . $emailId;

                    $redirectRouteAction = "";

                }

            }

        } catch (Exeception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        // if ($redirectRouteAction) {

        //     // $redirectUrl = redirect()->action($redirectRouteAction);
        //     $returnResponse["redirectTo"] = route('home');
        // }

        return json_encode($returnResponse);

    }

    /**
     * Update email view in email table by email id.
     *
     * @return json returnResponse
     */
    public function emailViewUpdate(Request $request)
    {

        $returnResponse = [];

        try {

            $emailViewParamInfo = [];
            $emailViewParamInfo["id"] = $request->id;
            $emailViewParamInfo["empcode"] = auth()->user()->empcode;
            $emailViewParamInfo["view"] = $request->view;
            $emailViewParamInfo["start_time"] = date('Y-m-d H:i:s');
            $emailViewParamInfo["ip_address"] = $request->ip();

            if (auth()->check()) {

                // $emailViewParamInfo["creator_empcode"] = auth()->user()->empcode;

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $emailViewParamInfo["creator_empcode"] = session()->get("current_empcode");

                }

            }

            if(is_array($emailViewParamInfo) && count($emailViewParamInfo)>0) {

                $returnResponse = $this->emailResource->emailViewUpdate($emailViewParamInfo);

            }

        } catch (Exeception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        // if ($redirectRouteAction) {

        //     // $redirectUrl = redirect()->action($redirectRouteAction);
        //     $returnResponse["redirectTo"] = route('home');
        // }

        return json_encode($returnResponse);
    }

    /**
     * Update email review in email table by email id.
     *
     * @return json returnResponse
     */
    public function emailReviewUpdate(Request $request)
    {

        $returnResponse = [];

        try {

            $paramInfo = [];
            $paramInfo["id"] = $request->id;
            $paramInfo["empcode"] = auth()->user()->empcode;
            $paramInfo["unreview"] = $request->unreview;
            $paramInfo["start_time"] = date('Y-m-d H:i:s');
            $paramInfo["ip_address"] = $request->ip();

            if (auth()->check()) {

                // $paramInfo["creator_empcode"] = auth()->user()->empcode;

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $paramInfo["creator_empcode"] = session()->get("current_empcode");

                }

            }

            if(is_array($paramInfo) && count($paramInfo)>0) {

                $returnResponse = $this->emailResource->emailReviewUpdate($paramInfo);

            }

        } catch (Exeception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        // if ($redirectRouteAction) {

        //     // $redirectUrl = redirect()->action($redirectRouteAction);
        //     $returnResponse["redirectTo"] = route('home');
        // }

        return json_encode($returnResponse);
    }

    /**
     * Send email.
     *
     *  @return json response
     */
    public function emailSend(Request $request)
    {

        try {

            $field = [];

            $returnResponse = [];
            $field["from"] = '';

            if (isset($request->start_time) && $request->start_time != "") {
                $field["start_time"] = $request->start_time;
                $field["end_time"] = date('Y-m-d H:i:s');
            }

            if (isset($request->to) && $request->to != "") {
                $field["to"] = $request->to;
            }

            if (isset($request->cc) && $request->cc != "") {
                $field["cc"] = $request->cc;
            } else {
                $field["cc"] = '';
            }
			if (isset($request->bcc) && $request->bcc != "") {
                $field["bcc"] = $request->bcc;
            } else {
                $field["bcc"] = '';
            }
            if (isset($request->subject) && $request->subject != "") {
                $field["subject"] = $request->subject;
            } else {
                $field["subject"] = '';
            }
            if (isset($request->type) && $request->type != "") {
                $field["type"] = $request->type;
            } else {
                $field["type"] = '';
            }
			if (isset($request->email_id) && $request->email_id != "") {
                $field["email_id"] = $request->email_id;
            } else {
                $field["email_id"] = '';
            }
            if (isset($request->body_html) && $request->body_html != "") {

                // $field["body_html"] = $request->body_html;
                $emailEditorStyle = Config::get('constants.email_editor_style');
                $field["body_html"] = $emailEditorStyle . "<div>" . $request->body_html ."</div>";
            } else {
                $field["body_html"] = '';
            }
            if (isset($request->status) && $request->status != "") {
                $field["status"] = $request->status;
            } else {
                $field["status"] = '';
            }
            if (isset($request->email_type) && $request->email_type != "") {
                $field["email_type"] = $request->email_type;
            } else {
                $field["email_type"] = '';
            }
            if (isset($request->job_id) && $request->job_id != "") {
                $field["job_id"] = $request->job_id;
            } else {
				 $field["job_id"] = '';
			}
			if (isset($request->body_html) && $request->body_html != "") {
				$text = substr(strip_tags($request->body_html),0,100);
                $field["message_start"] = $text;
            } else {
                $field["message_start"] = '';
            }

			if (isset($request->priority) && $request->priority != "") {
                $field["priority"] = '1';
            } else {
				$field["priority"] = '3';
            }

            if (isset($request->external_email) && $request->external_email != "") {
                $field["email_domain_name"] = $request->external_email;
            } else {
                $field["email_domain_name"] = 'internal';
            }

            $field["empcode"]       = auth()->user()->empcode;
            $field["source"]        = 'inbox';
            $field['email_guid']    = '';

            $attached_files = [];
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
            $rand = substr(str_shuffle($permitted_chars), 0, 8);
            $guid = date('Y-m-d-hms') . '-' . $rand;
            $currentTime = date('Y') . '\\' . date('m') . '\\' . date('j') . '\\' . $guid;
            $uploadPath = strtoupper(auth()->user()->empcode) . '\\' . $currentTime . '\\';
            $filePathFolder =  env('UPLOAD_FILE_ROUTE_PATH', storage_path('app')) . '\\' . $uploadPath;

			if($request->file())
			{

                $files = $request->file();

				// $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
				// $rand = substr(str_shuffle($permitted_chars), 0, 8);
                // $guid = date('Y-m-d-hms').'-'.$rand;
                // $currentTime = date('Y') . '\\' . date('m') . '\\' . date('j') . '\\' . $guid;
                // $uploadPath = strtoupper(auth()->user()->empcode) . '\\' . $currentTime . '\\';

				foreach($files as $file){

					$filename  = $file->getClientOriginalName();
					$extension = $file->getClientOriginalExtension();
					$hasFilename = $filename;

					//$filePath1 = 'OUPBOOKS\\RADDEVELOPERS@SPI-GLOBAL.COM\\2020\\6\\9\\09a13be6-d963-432f-8fef-020e53074b22\\' . $filename;

					$filePath =  $filePathFolder. $hasFilename;

                    Storage::disk('s3')->put($filePath, file_get_contents($file));

                    $fileIndexRand = substr(str_shuffle($permitted_chars), 0, 8);
                    $fileIndex = date('Ymdhmsv') . '_' . $fileIndexRand;
					$attached_files[$fileIndex] = $hasFilename;

                }

            }

            $requestParams = $request->all();

            array_walk($requestParams, function ($value, $key)  use ($permitted_chars, $filePathFolder, &$attached_files) {

                if (strpos($key, "attached_email_file_") !== false) {

                    $parsedUrlQueryString = parse_url($value, PHP_URL_QUERY);

                    if($parsedUrlQueryString){

                        parse_str($parsedUrlQueryString, $parseUrlQueryParams);

                        if(is_array($parseUrlQueryParams) && count($parseUrlQueryParams)) {

                            Storage::disk('s3')->copy($parseUrlQueryParams["img_path"], $filePathFolder . $parseUrlQueryParams["alais_name"]);

                                $fileIndexRand = substr(str_shuffle($permitted_chars), 0, 8);
                                $fileIndex = date('Ymdhmsv') . '_' . $fileIndexRand;
                                $attached_files[$fileIndex] = $parseUrlQueryParams["alais_name"];

                        }

                    }

                }

            });

            if (is_array($attached_files) && count($attached_files) > 0) {

                $field["attachments"] = implode("|", $attached_files);
                $field['email_path'] = env('UPLOAD_FILE_ROUTE_PATH', storage_path('app')) . '\\' . $uploadPath;
                $field['email_guid'] = $guid;

            }

			/*$field['from'] = '';
			$field['to'] = 'test';
			$field['cc'] = 'test';
			$field['subject'] = 'FW: Ourania Gouseti et al. (Eds): Interdisciplinary Approaches to Food Digestion, 978-3-030-03900-4, 371152_1_En, (1)';
			$field['type'] = 'non_pmbot';
			$field['email_id'] = '147';
			$field['body_html'] = 'test';
			$field['status'] = '0';
			$field['email_type'] = 'forward';
			$field['job_id'] = '';
			$field['empcode'] = 'K.Rajarethinam@spi-global.com';
			$field['source'] = 'inbox';
			$field['email_guid'] = '';
			*/
			if($field['email_type'] == 'forward') {
				$gfield['emailid'] = $field['email_id'];
				$gfield["empcode"] = auth()->user()->empcode;
				$returnResponse = $this->emailResource->emailGet($gfield);

				if(!empty($request->fw_attachements)) {
					$fw_attachementslist = implode("|", $request->fw_attachements);
					$returnResponse['data']['attachments'] = $fw_attachementslist;
				} else {
					$returnResponse['data']['attachments'] = '';
				}

				if(!empty($returnResponse['data']['attachments'])) {
					//$returnResponse['data']['attachments'] = base64_decode($returnResponse['data']['attachments']);
					$returnResponse['data']['attachments'] = $returnResponse['data']['attachments'];
				}



				if(empty($uploadPath)) {
					$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
					$rand = substr(str_shuffle($permitted_chars), 0, 8);
					$guid = date('Y-m-d-hms').'-'.$rand;

					$currentTime = date('Y') . '\\' . date('n') . '\\' . date('j') . '\\' . $guid;
					$uploadPath = strtoupper(auth()->user()->empcode) . '\\' . $currentTime . '\\';
					$field['email_path'] = env('UPLOAD_FILE_ROUTE_PATH', storage_path('app')) . '\\' .$uploadPath;
					$field["attachments"] = $returnResponse['data']['attachments'];

					$upath = env('UPLOAD_FILE_ROUTE_PATH', storage_path('app')) . '\\'.$uploadPath;

					//$upath = str_replace("\\","/",$upath);
					//mkdir($upath, 0777,true);

				} else {
					$uploadPath = $uploadPath;
                    $field['email_path'] = env('UPLOAD_FILE_ROUTE_PATH', storage_path('app')) . '\\' .$uploadPath;

                    if(isset($field["attachments"]) && !empty($field["attachments"])) {

                        $field["attachments"] = $field["attachments"].'|'.$returnResponse['data']['attachments'];

                    } else {

                        $field["attachments"] = $returnResponse['data']['attachments'];

                    }

					$upath = env('UPLOAD_FILE_ROUTE_PATH', storage_path('app')).'\\'.$uploadPath;
                }

				if(!empty($returnResponse['data'])) {
					$spath = $returnResponse['data']['email_path'];
					$file = explode("|",$returnResponse['data']['attachments']);

					for ($i = 0; $i < count($file); $i++) {
						if(!empty($file[$i])) {
							$filename = $spath.$file[$i];
							$upath = env('UPLOAD_FILE_ROUTE_PATH', storage_path('app')) . '\\'.$uploadPath;
							Storage::disk('s3')->copy($filename, $upath.$file[$i]);
							//if (file_exists($filename)) {
								//$upath = $_ENV['UPLOAD_FILE_PATH'].''.$uploadPath;
								//Storage::disk('s3')->copy($filePath, $upath.$file[$i]);
								//copy($filename, $upath.$file[$i]);
							//}
						}
					}

				}
			}
			if(!empty($field["attachments"])) {
				$field["attachments"] = base64_encode($field["attachments"]);
            }

            if(auth()->check()) {

               $field['creator_empcode'] = auth()->user()->empcode;

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $field['creator_empcode'] = session()->get("current_empcode");

                }

            }

            if(isset($request->autosave) && $request->autosave == 'true') {

                $field['autosave'] = 'true';

                $field['view'] = '1';

            }

            if (count($field) > 0) {
                $returnResponse = $this->emailResource->emailSend($field);
            }
        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        if ($request->page_type && $request->page_type == "page") {

            $returnResponse["redirectUrl"] = route(__("job.email_view_url"), $request->email_id);

        }

        // if ($request->ajax()) {

            return json_encode($returnResponse);

        // }



        // return view("errors.error404");
    }
	public function draftemailSend(Request $request)
    {

        try {

            $field = [];

            $returnResponse = [];

            if (isset($request->start_time) && $request->start_time != "") {
                $field["start_time"] = $request->start_time;
                $field["end_time"] = date('Y-m-d H:i:s');
            }

            if (isset($request->to) && $request->to != "") {
                $field["email_to"] = $request->to;
            } else {
				$field["email_to"] = $request->to;
			}

            if (isset($request->cc) && $request->cc != "") {
                $field["email_cc"] = $request->cc;
            } else {
                $field["email_cc"] = '';
            }
			if (isset($request->bcc) && $request->bcc != "") {
                $field["email_bcc"] = $request->bcc;
            } else {
                $field["email_bcc"] = '';
            }
            if (isset($request->subject) && $request->subject != "") {
                $field["subject"] = $request->subject;
            } else {
                $field["subject"] = '';
            }

			if (isset($request->email_id) && $request->email_id != "") {
                $field["id"] = $request->email_id;
            } else {
                $field["id"] = '';
            }
            if (isset($request->body_html) && $request->body_html != "") {
                $field["body_html"] = $request->body_html;
            } else {
                $field["body_html"] = '';
            }
            if (isset($request->status) && $request->status != "") {
                $field["status"] = $request->status;
            } else {
                $field["status"] = '';
            }

            if (isset($request->external_email) && $request->external_email != "") {
                $field["email_domain_name"] = $request->external_email;
            } else {
                $field["email_domain_name"] = '';
            }

			if($request->file())
			{
				$gfield['emailid'] = $field['id'];
				$gfield["empcode"] = auth()->user()->empcode;
                $returnResponse = $this->emailResource->emailGet($gfield);

                // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($returnResponse);echo '<PRE/>';exit;
				// if(!empty($returnResponse['data']['attachments'])) {
				// 	$returnResponse['data']['attachments'] = base64_decode($returnResponse['data']['attachments']);
				// }


				$attached_files = [];
				$files = $request->file();

				if(!empty($returnResponse['data']['email_path'])) {
					//$uploadPath = str_replace(env('UPLOAD_FILE_ROUTE_PATH', storage_path('app')).'\\',"",$returnResponse['data']['email_path']);
					//$uploadPath = str_replace($_ENV['UPLOAD_FILE_ROUTE_PATH1'].'\\',"",$uploadPath);
					$uploadPath = str_replace(env('UPLOAD_FILE_ROUTE_PATH', storage_path('app')).'\\',"",$returnResponse['data']['email_path']);
				} else {
					/*$guid = date('Y-m-d-hms');
					$currentTime = date('Y') . '\\' . date('m') . '\\' . date('d') . '\\' . $guid;
					$uploadPath = auth()->user()->empcode . '\\' . $currentTime . '\\';
					$field['email_path'] = env('UPLOAD_FILE_ROUTE_PATH', storage_path('app')) . '\\' .$uploadPath;
					$field['email_guid'] = $guid;*/

					$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
					$rand = substr(str_shuffle($permitted_chars), 0, 8);
					$guid = date('Y-m-d-hms').'-'.$rand;
					$currentTime = date('Y') . '\\' . date('n') . '\\' . date('d') . '\\' . $guid;
					$uploadPath = strtoupper(auth()->user()->empcode) . '\\' . $currentTime . '\\';
					$field['email_path'] = env('UPLOAD_FILE_ROUTE_PATH', storage_path('app')) . '\\' .$uploadPath;
					$field['email_guid'] = $guid;
				}

				foreach($files as $file){
					$filename  = $file->getClientOriginalName();
					$extension = $file->getClientOriginalExtension();
					$hasFilename = $filename;
					$filePath =  env('UPLOAD_FILE_ROUTE_PATH', storage_path('app')) . '\\' .$uploadPath. $hasFilename;
					Storage::disk('s3')->put($filePath, file_get_contents($file));
                    //$filename = $file->store(strtotime("now") . '/' . auth()->user()->empcode);
                    $fileIndexRand = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 8);
                    $fileIndex = date('Ymdhmsv') . '_' . $fileIndexRand;
                    $attached_files[$fileIndex] = $hasFilename;
				}


				if(count($attached_files) > 0){
					$field["attachments"] = implode("|", $attached_files);

					if(!empty($request->fw_attachements)) {
						$fw_attachementslist = implode("|", $request->fw_attachements);
						$field["attachments"] = $fw_attachementslist.'|'.$field["attachments"];
					}
					/*if(!empty($returnResponse['data']['attachments'])) {
						$attachments = rtrim($returnResponse['data']['attachments'],"|");
						$field["attachments"] = $attachments.'|'.$field["attachments"];
					}*/
				}
            } else {
				if(!empty($request->fw_attachements)) {
					$fw_attachementslist = implode("|", $request->fw_attachements);
					$field["attachments"] = $fw_attachementslist;
				}
			}

			if(!empty($field["attachments"])) {
				$field["attachments"] = base64_encode($field["attachments"]);
            }

            if (auth()->check()) {

                $field['creator_empcode'] = auth()->user()->empcode;

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $field['creator_empcode'] = session()->get("current_empcode");
                }
            }

            if(isset($request->autosave) && $request->autosave == 'true') {

                $field['autosave'] = 'true';

            }

            if (count($field) > 0) {
                $returnResponse = $this->emailResource->draftemailSend($field);
            }
        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        // if ($request->ajax()) {

        return json_encode($returnResponse);
        // }

        // return view("errors.error404");
    }
    public function emailGet(Request $request)
    {
        try {

            $field = [];

            $returnResponse = [];
            if (isset($request->emailid) && $request->emailid != "") {
                $field["emailid"] = $request->emailid;
            }
            if (isset($request->type) && $request->type != "") {
                $field["type"] = $request->type;
            }
            if (isset($request->email_group_ids) && $request->email_group_ids != "") {
                $field["email_group_ids"] = $request->email_group_ids;
            }
            if (isset($request->view) && $request->view != "") {
                $field["view"] = $request->view;
            }
            $field["empcode"]       = auth()->user()->empcode;

            if (count($field) > 0) {

                $returnResponse = $this->emailResource->emailGet($field);

				$returnData = [];

				$returnData = $returnResponse;

				if (is_array($returnData) && isset($returnData["success"]) && $returnData["success"] == "true") {

					if (isset($returnData["data"]) && is_array($returnData["data"]) && count($returnData["data"]) > 0) {

						if (isset($returnData["data"]["email_to"]) && $returnData["data"]["email_to"] != "") {

							$toEmails = [];

							if($returnData["data"]["status"] != '6') {
								$toEmails = $returnData["data"]["email_from"].';'.$returnData["data"]["email_to"];
							} else {
								$toEmails = $returnData["data"]["email_to"];
							}
							$toEmails = explode(';', html_entity_decode($toEmails));

							if (is_array($toEmails) && count($toEmails) > 0) {

								array_walk($toEmails, function ($value, $key) use ($returnData, &$toEmails) {

									if (stripos($value, auth()->user()->empcode) !== false) {

										unset($toEmails[$key]);
									}

									if (stripos($value, $returnData["data"]["email_from"]) !== false) {

										unset($toEmails[$key]);
									}
								});
							}
							$replyAllToEmails = implode(";", $toEmails);
							$returnData["data"]["reply_all_to"] = $replyAllToEmails;
							$returnResponse["data"]["reply_all_to"] = $returnData["data"]["reply_all_to"];

						}
					}
				}

                if (is_array($returnResponse) && isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

					$returnData = [];

                    $returnData = $this->emailResource->emailMoveToRuleLabels();

                    if (is_array($returnData) && isset($returnData["success"]) && $returnData["success"] == "true") {

                        $returnResponse["label_list"] = $returnData["data"];
                    }
                }

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

        return $returnResponse;

        // return view("errors.error404");
    }
	public function emailidGet(Request $request)
    {
        try {

            $field = [];

            $returnResponse = [];

            if (isset($request->search) && $request->search != "") {
                $field["search"] = $request->search;
            }
			$field["empcode"]       = auth()->user()->empcode;
            if (count($field) > 0) {
                $returnResponse = $this->emailResource->emailidGet($field);
            }
        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        //if ($request->ajax()) {
        return json_encode($returnResponse);
        // }

        // return view("errors.error404");
    }
	public function signatureUpdate(Request $request)
    {

        try {

            $field = [];

            $returnResponse = [];

            if (isset($request->new_signature) && $request->new_signature != "") {
                $field["new_signature"] = $request->new_signature;
            } else {
                $field["new_signature"] = '';
            }
			if (isset($request->replyforward_signature) && $request->replyforward_signature != "") {
                $field["replyforward_signature"] = $request->replyforward_signature;
            } else {
                $field["replyforward_signature"] = '';
            }
            $field["empcode"]       = auth()->user()->empcode;

            if(auth()->check()) {

               $field['creator_empcode'] = auth()->user()->empcode;

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $field['creator_empcode'] = session()->get("current_empcode");

                }

            }

            if (count($field) > 0) {
                $returnResponse = $this->emailResource->signatureUpdate($field);
            }
        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        // if ($request->ajax()) {

        return json_encode($returnResponse);
        // }

        // return view("errors.error404");
    }
	public function getSignature(Request $request)
    {
        try {

            $field = [];

            $returnResponse = [];

            $field["empcode"]       = auth()->user()->empcode;

            if (count($field) > 0) {
                $returnResponse = $this->emailResource->getSignature($field);
            }
        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        //if ($request->ajax()) {
        return json_encode($returnResponse);
        // }

        // return view("errors.error404");
    }
}
