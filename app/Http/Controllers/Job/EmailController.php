<?php

namespace App\Http\Controllers\Job;

use Session;
use Exception;
use Illuminate\Http\Request;
use App\Traits\General\Helper;
use App\Http\Controllers\Controller;
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

        $redirectRouteAction = "";

        try {

            $redirectRouteAction = $this->roleBasedDashboardRouteAction($request);

            if (auth()->check()) {

                $request->merge(['creator_empcode' => auth()->user()->empcode]);

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $request->merge(['creator_empcode' => session()->get("current_empcode")]);

                }

            }

            $returnResponse = $this->emailResource->emailStatusUpdate($request);

        } catch (Exeception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        if ($redirectRouteAction) {

            // $redirectUrl = redirect()->action($redirectRouteAction);
            $returnResponse["redirectTo"] = route('home');
        }

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

            $field["empcode"]       = auth()->user()->empcode;
            $field["source"]        = 'inbox';
			$field['email_guid']    = '';

			if($request->file())
			{
				$attached_files = [];
				$files = $request->file();

                $guid = date('Y-m-d-hms');
                $currentTime = date('Y') . '\\' . date('m') . '\\' . date('d') . '\\' . $guid;
                //$uploadPath = $currentTime . '\\' . auth()->user()->empcode . '\\';
                $uploadPath = auth()->user()->empcode . '\\' . $currentTime . '\\';

                //$field['email_path'] = env('UPLOAD_FILE_PATH', storage_path('app')) . '\\' .$uploadPath;
				$field['email_path'] = env('UPLOAD_FILE_ROUTE_PATH', storage_path('app')) . '\\' .$uploadPath;
                $field['email_guid'] = $guid;

				foreach($files as $file){
					$filename = $file->getClientOriginalName();

					$extension = $file->getClientOriginalExtension();

					//$hasFilename = $currentTime . '_' .$filename;
					$hasFilename = $filename;

					//$filename = $file->store($uploadPath);


					//Storage::put($uploadPath, $file);
					Storage::putFileAs($uploadPath . '/',$file, $hasFilename);
					//$filename = $file->store(strtotime("now") . '/' . auth()->user()->empcode);
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
				$returnResponse = $this->emailResource->emailGet($gfield);
				
				if(!empty($returnResponse['data']['attachments'])) {
					//$returnResponse['data']['attachments'] = base64_decode($returnResponse['data']['attachments']);
					$returnResponse['data']['attachments'] = $returnResponse['data']['attachments'];
				}
				


				if(empty($uploadPath)) {
					$guid = date('Y-m-d-hms');
					$currentTime = date('Y') . '\\' . date('m') . '\\' . date('d') . '\\' . $guid;
					$uploadPath = auth()->user()->empcode . '\\' . $currentTime . '\\';
					$field['email_path'] = env('UPLOAD_FILE_ROUTE_PATH', storage_path('app')) . '\\' .$uploadPath;
					$field["attachments"] = $returnResponse['data']['attachments'];
					$upath = $_ENV['UPLOAD_FILE_PATH'].''.$uploadPath;
					$upath = str_replace("\\","/",$upath);

					mkdir($upath, 0777,true);
				} else {
					$uploadPath = $uploadPath;
					$field['email_path'] = env('UPLOAD_FILE_ROUTE_PATH', storage_path('app')) . '\\' .$uploadPath;
					$field["attachments"] = $field["attachments"].'|'.$returnResponse['data']['attachments'];
					$upath = $_ENV['UPLOAD_FILE_PATH'].'\\'.$uploadPath;
				}

				if(!empty($returnResponse['data'])) {
					$spath = $returnResponse['data']['email_path'];

					/******* SERVER PATH ******/
					$spath = str_replace($_ENV['UPLOAD_FILE_ROUTE_PATH'],$_ENV['UPLOAD_FILE_PATH'],$spath);
					$spath = str_replace($_ENV['UPLOAD_FILE_ROUTE_PATH1'],$_ENV['UPLOAD_FILE_PATH'],$spath);

					//$spath = str_replace('\\172.24.134.24\AnI\ChemInfoBot',$_ENV['PRODUCTION_SERVERPATH'],$spath);

					$spath = str_replace("\\","/",$spath);
					$spath = str_replace("//","/",$spath);
					$spath = str_replace("//","/",$spath);



					/******* LOCAL PATH ******/
					//$spath = str_replace($_ENV['UPLOAD_FILE_ROUTE_PATH'],$_ENV['UPLOAD_FILE_PATH'],$spath);

					$file = explode("|",$returnResponse['data']['attachments']);

					for ($i = 0; $i < count($file); $i++) {
						if(!empty($file[$i])) {
							$filename = $spath.$file[$i];
							if (file_exists($filename)) {
								$uploadPath = str_replace("\\","/",$uploadPath);
								$upath = $_ENV['UPLOAD_FILE_PATH'].''.$uploadPath;
								copy($filename, $upath.$file[$i]);

							}
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
				$returnResponse = $this->emailResource->emailGet($gfield);
				if(!empty($returnResponse['data']['attachments'])) {
					$returnResponse['data']['attachments'] = base64_decode($returnResponse['data']['attachments']);
				}

				$attached_files = [];
				$files = $request->file();
				if(!empty($returnResponse['data']['email_path'])) {
					$uploadPath = str_replace($_ENV['UPLOAD_FILE_ROUTE_PATH'].'\\',"",$returnResponse['data']['email_path']);
					$uploadPath = str_replace($_ENV['UPLOAD_FILE_ROUTE_PATH1'].'\\',"",$uploadPath);
				} else {
					$guid = date('Y-m-d-hms');
					$currentTime = date('Y') . '\\' . date('m') . '\\' . date('d') . '\\' . $guid;
					$uploadPath = auth()->user()->empcode . '\\' . $currentTime . '\\';
					$field['email_path'] = env('UPLOAD_FILE_ROUTE_PATH', storage_path('app')) . '\\' .$uploadPath;
					$field['email_guid'] = $guid;
				}

				foreach($files as $file){
					$filename = $file->getClientOriginalName();

					$extension = $file->getClientOriginalExtension();

					//$hasFilename = $currentTime . '_' .$filename;
					$hasFilename = $filename;

					//$filename = $file->store($uploadPath);

					//Storage::put($uploadPath, $file);
					Storage::putFileAs($uploadPath . '/',$file, $hasFilename);
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
            if (count($field) > 0) {
                $returnResponse = $this->emailResource->emailGet($field);
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
	public function emailidGet(Request $request)
    {
        try {

            $field = [];

            $returnResponse = [];

            if (isset($request->search) && $request->search != "") {
                $field["search"] = $request->search;
            }
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
}
