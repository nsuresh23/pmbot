<?php

namespace App\Http\Controllers\Job;

use Session;
use Exception;
use Illuminate\Http\Request;
use App\Traits\General\Helper;
use App\Http\Controllers\Controller;
use App\Models\Annotation;
use App\Traits\General\CustomLogger;
use Illuminate\Support\Facades;
use App\Resources\Job\EmailCollection as EmailResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class EmailController extends Controller
{

    use Helper;

    use CustomLogger;

    protected $emailResource = "";

    public function __construct()
    {

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

            if (auth()->check()) {

                $request->merge(['creator_empcode' => auth()->user()->empcode]);

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $request->merge(['creator_empcode' => session()->get("current_empcode")]);
                }

            }

            $paramInfo = $request->all();

            if(is_array($paramInfo) && isset($paramInfo["s_no"])) {

                unset($paramInfo["s_no"]);

            }

            if ($method == "GET") {

                if (is_array($paramInfo) && isset($paramInfo["creator_empcode"])) {

                    unset($paramInfo["creator_empcode"]);

                }

                $returnResponse = $this->emailResource->emailRules($paramInfo);

            }

            if ($method == "POST") {

                $returnData = $this->emailResource->emailAddRule($paramInfo);

                if (is_array($returnData) && isset($returnData["success"]) && $returnData["success"] == "true") {

                    $returnResponse = $this->emailResource->emailRules(["empcode" => auth()->user()->empcode]);

                    if (is_array($returnResponse) && isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

                        $returnResponse["message"] = $returnData["message"];

                    }

                }

            }

            if ($method == "PUT") {

                $returnData = $this->emailResource->emailUpdateRule($paramInfo);

                if (is_array($returnData) && isset($returnData["success"]) && $returnData["success"] == "true") {

                    $returnResponse = $this->emailResource->emailRules(["empcode" => auth()->user()->empcode]);

                    if (is_array($returnResponse) && isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

                        $returnResponse["message"] = $returnData["message"];

                    }

                }

            }

            if ($method == "DELETE") {

                $returnData = $this->emailResource->emailDeleteRule($paramInfo);

                if (is_array($returnData) && isset($returnData["success"]) && $returnData["success"] == "true") {

                    $returnResponse = $this->emailResource->emailRules(["empcode" => auth()->user()->empcode]);

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
     * Update email label in email table by email id.
     *
     * @return json returnResponse
     */
    public function emailLabelUpdate(Request $request)
    {

        $returnResponse = [];

        try {

            $request->merge(['empcode' => auth()->user()->empcode]);

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

            $returnData["redirectTo"] = route(__("job.email_view_url"), $request->redirectTo);

        }

        return view('pages.annotator.emailForwardModal', compact("returnData"));
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

            $returnResponse = $this->emailResource->pmsEmailCount();

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
            }
            $field["empcode"] = auth()->user()->empcode;

            if (count($field) > 0) {

                $returnResponse = $this->emailResource->emailList($field);
            }
        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($returnResponse);
        // echo '<PRE/>';
        // echo '<PRE/>';
        // echo 'LINE => ' . __LINE__;
        // echo '<PRE/>';
        // echo 'CAPTION => CaptionName';
        // echo '<PRE/>';
        // print_r(json_encode($returnResponse));echo '<PRE/>';exit;

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
                $field["body_html"] = $request->body_html;
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
			
            $field["empcode"]       = auth()->user()->empcode;
            $field["source"]        = 'inbox';
			$field['email_guid']    = '';


			if($request->file())
			{
				$attached_files = [];
				$files = $request->file();
				$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';

				$rand = substr(str_shuffle($permitted_chars), 0, 8);

                $guid = date('Y-m-d-hms').'-'.$rand;

                $currentTime = date('Y') . '\\' . date('m') . '\\' . date('j') . '\\' . $guid;
                $uploadPath = strtoupper(auth()->user()->empcode) . '\\' . $currentTime . '\\';
				$field['email_path'] = env('UPLOAD_FILE_ROUTE_PATH', storage_path('app')) . '\\' .$uploadPath;
                $field['email_guid'] = $guid;

				foreach($files as $file){
					$filename  = $file->getClientOriginalName();
					$extension = $file->getClientOriginalExtension();
					$hasFilename = $filename;

					//$filePath1 = 'OUPBOOKS\\RADDEVELOPERS@SPI-GLOBAL.COM\\2020\\6\\9\\09a13be6-d963-432f-8fef-020e53074b22\\' . $filename;

					$filePath =  env('UPLOAD_FILE_ROUTE_PATH', storage_path('app')) . '\\' .$uploadPath. $hasFilename;

					Storage::disk('s3')->put($filePath, file_get_contents($file));
					$attached_files[$filename] = $hasFilename;

				}

				if(count($attached_files) > 0){
					$field["attachments"] = implode("|", $attached_files);
				}
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
					$field["attachments"] = $field["attachments"].'|'.$returnResponse['data']['attachments'];
					$upath = $_ENV['UPLOAD_FILE_ROUTE_PATH'].'\\'.$uploadPath;
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

			if($request->file())
			{
				$gfield['emailid'] = $field['id'];
				$gfield["empcode"] = auth()->user()->empcode;
				$returnResponse = $this->emailResource->emailGet($gfield);
				if(!empty($returnResponse['data']['attachments'])) {
					$returnResponse['data']['attachments'] = base64_decode($returnResponse['data']['attachments']);
				}

				$attached_files = [];
				$files = $request->file();

				if(!empty($returnResponse['data']['email_path'])) {
					//$uploadPath = str_replace($_ENV['UPLOAD_FILE_ROUTE_PATH'].'\\',"",$returnResponse['data']['email_path']);
					//$uploadPath = str_replace($_ENV['UPLOAD_FILE_ROUTE_PATH1'].'\\',"",$uploadPath);
					$uploadPath = str_replace($_ENV['UPLOAD_FILE_ROUTE_PATH'].'\\',"",$returnResponse['data']['email_path']);
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
					$attached_files[$filename] = $hasFilename;
				}


				if(count($attached_files) > 0){
					$field["attachments"] = implode("|", $attached_files);
					if(!empty($returnResponse['data']['attachments'])) {
						$attachments = rtrim($returnResponse['data']['attachments'],"|");
						$field["attachments"] = $attachments.'|'.$field["attachments"];
					}
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

                    $returnData = $this->emailResource->emailRuleLabels();

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
