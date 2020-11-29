<?php

namespace App\Resources\Job;

use Exception;
use DateTime;
use DateTimeZone;
use League\Fractal\Manager;
use App\Traits\General\Helper;
use App\Traits\General\ApiClient;
use function GuzzleHttp\json_encode;
use App\Traits\General\CustomLogger;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class EmailCollection
{

    use Helper;

    use ApiClient;

    use CustomLogger;

    protected $client;
    protected $fractal;

    protected $emailListApiUrl;
    protected $emailSendApiUrl;
	protected $draftemailSendApiUrl;
    protected $pmsEmailCountApiUrl;
    protected $emailRulesApiUrl;
    protected $emailAddRulesApiUrl;
    protected $emailUpdateRulesApiUrl;
    protected $emailDeleteRulesApiUrl;
    protected $emailRuleLabelsApiUrl;
    protected $emailMoveToApiUrl;
    protected $emailAnnotatorBaseUrl;
    protected $emailStatusUpdateUrl;
    protected $jobEmailStatusUpdateUrl;
	protected $signatureupdateApiUrl;
	protected $getsignatureApiUrl;
    protected $emailSentCountApiUrl;
    protected $emailCategoryCountApiUrl;
    protected $classificationEmailListApiUrl;

    public function __construct()
    {
        $this->fractal = new Manager();

        $this->emailSendApiUrl          = env('API_EMAIL_SEND_URL');
		$this->draftemailSendApiUrl     = env('API_DRAFT_EMAIL_SEND_URL');
        $this->emailGetApiUrl           = env('API_GET_EMAIL_URL');
		$this->emailidGetApiUrl         = env('API_GET_EMAILID_URL');
        $this->emailListApiUrl          = env('API_EMAIL_BOX_LIST_URL');
        $this->pmsEmailCountApiUrl      = env('API_PMS_EMAIL_COUNT_URL');
        $this->emailRulesApiUrl         = env('API_EMAIL_RULES_URL');
        $this->emailAddRulesApiUrl      = env('API_EMAIL_ADD_RULES_URL');
        $this->emailUpdateRulesApiUrl   = env('API_EMAIL_UPDATE_RULES_URL');
        $this->emailDeleteRulesApiUrl   = env('API_EMAIL_DELETE_RULES_URL');
        $this->emailRuleLabelsApiUrl    = env('API_EMAIL_FOLDERS_URL');
        $this->emailMoveToApiUrl        = env('API_EMAIL_MOVE_TO_URL');
        $this->emailAnnotatorBaseUrl    = env("EMAIL_ANNOTATOR_BASE_URL");
        $this->emailStatusUpdateUrl     = env("API_EMAIL_STATUS_UPDATE_URL");
        $this->jobEmailStatusUpdateUrl  = env("API_JOB_EMAIL_STATUS_UPDATE_URL");
		$this->signatureupdateApiUrl    = env('API_SIGNATURE_UPDATE_URL');
        $this->getsignatureApiUrl       = env('API_GET_SIGNATURE_URL');
        $this->emailSentCountApiUrl     = env('API_EMAIL_SENT_COUNT_URL');
        $this->emailCategoryCountApiUrl     = env('API_EMAIL_CATEGORY_COUNT_URL');
        $this->classificationEmailListApiUrl    = env('API_EMAIL_CLASSIFICATION_LIST_URL');
    }

    /**
     * Get the email rules labels.
     *
     * @return array $returnData
     */
    public function emailRuleLabels()
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            // $userData = User::all();

            $url = $this->emailRuleLabelsApiUrl;

            $params = ["empcode" => Config::get('constants.job_add_am_empcode')];

            $returnData = $this->postRequest($url, $params);

            if ($returnData["success"] == "true"&& is_array($returnData["data"]) && count($returnData["data"]) > 0 && $returnData["data"] != "") {

                $responseData = $this->emailLabelsFormatData($returnData["data"]);

                if ($responseData) {

                    // array_push($responseData, [
                    //     "id" => "inbox",
                    //     "text" => "inbox"
                    // ]);

                    // $returnResponse["success"] = "true";
                    // $returnResponse["data"] = $responseData;

                    // array_push($emailLabelListArray, $responseData);

                    $returnResponse["success"] = "true";
                    $returnResponse["data"] = $responseData;

                }

            }

        } catch (Exception $e) {

            // return $e->getMessage();

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
     * Get the email rules labels.
     *
     * @return array $returnData
     */
    public function emailMoveToRuleLabels()
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            // $userData = User::all();

            $url = $this->emailRuleLabelsApiUrl;

            $params = ["empcode" => Config::get('constants.job_add_am_empcode')];

            $returnData = $this->postRequest($url, $params);

            if ($returnData["success"] == "true"&& is_array($returnData["data"]) && count($returnData["data"]) > 0 && $returnData["data"] != "") {

                $responseData = $this->emailLabelsFormatData($returnData["data"]);

                if ($responseData) {

                    array_unshift($responseData, [
                        "id" => "0",
                        "text" => "Inbox"
                    ]);

                    $returnResponse["success"] = "true";
                    $returnResponse["data"] = $responseData;
                }
            }
        } catch (Exception $e) {

            // return $e->getMessage();

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
     * Get the email rules.
     *
     * @return array $returnData
     */
    public function emailRules($params)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $url = $this->emailRulesApiUrl;

            $responseData = $this->postRequest($url, $params);

            if ($responseData["success"] == "true" && is_array($responseData["data"]) && count($responseData["data"]) && $responseData["data"] != "") {

                $responseFormatData = $this->emailRulesFormatData($responseData["data"]);

                if ($responseFormatData) {

                    $returnResponse["success"] = "true";
                    $returnResponse["data"] = $responseFormatData;

                    if (isset($responseData["result_count"]) && $responseData["result_count"] != "") {

                        $returnResponse["result_count"] = $responseData["result_count"];

                    } else if (is_array($responseFormatData)) {

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
     * Add the email rules.
     *
     * @return array $returnData
     */
    public function emailAddRule($params)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $url = $this->emailAddRulesApiUrl;

            $responseData = $this->postRequest($url, $params);

            if (isset($responseData["success"]) && $responseData["success"] == "true") {

                $returnResponse["success"] = "true";
                $returnResponse["message"] = "Save successfull";

            } else {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Save unsuccessfull";
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
     * Update the email rules.
     *
     * @return array $returnData
     */
    public function emailUpdateRule($params)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $url = $this->emailUpdateRulesApiUrl;

            $responseData = $this->postRequest($url, $params);

            if (isset($responseData["success"]) && $responseData["success"] == "true") {

                $returnResponse["success"] = "true";
                $returnResponse["message"] = "Update successfull";

            } else {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Update unsuccessfull";

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
     * Delete the email rules.
     *
     * @return array $returnData
     */
    public function emailDeleteRule($params)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $url = $this->emailDeleteRulesApiUrl;

            $responseData = $this->postRequest($url, $params);

            if (isset($responseData["success"]) && $responseData["success"] == "true") {

                $returnResponse["success"] = "true";
                $returnResponse["message"] = "Delete successfull";

            } else {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Delete unsuccessfull";

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
     * Update the email label based on email field array.
     *
     * @return array $returnResponse
     */
    public function emailLabelUpdate($request)
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
                'id'        => 'required',
                'label_name'    => 'required',
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Update failed";
            } else {

                $paramInfo = $request->all();

                $url = $this->emailMoveToApiUrl;

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
     * Get the pms email count.
     *
     * @return array $returnData
     */
    public function pmsEmailCount($request)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $paramInfo = [];

            $paramInfo = $request->all();

            $url = $this->pmsEmailCountApiUrl;

            $responseData = $this->postRequest($url, $paramInfo);

            if ($responseData["success"] == "true"&& is_array($responseData["data"]) && count($responseData["data"]) > 0 && $responseData["data"] != "") {

                $responseFormatData = $this->pmsEmailCountFormatData($responseData["data"]);

                if ($responseFormatData) {

                    $returnResponse["success"] = "true";
                    $returnResponse["data"] = $responseFormatData;

                    if (isset($responseData["result_count"]) && $responseData["result_count"] != "") {

                        $returnResponse["result_count"] = $responseData["result_count"];

                    } else if(is_array($responseFormatData)) {

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
     * Get the email rules labels.
     *
     * @return array $returnData
     */
    public function emailSentCount($request)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            // $userData = User::all();

            $url = $this->emailSentCountApiUrl;

            $params = ["empcode" => auth()->user()->empcode, "ipaddress" => $request->ip()];

            $returnData = $this->postRequest($url, $params);

            if (is_array($returnData) && count($returnData) > 0 && isset($returnData["success"]) && $returnData["success"]== "true") {

                $returnResponse["success"] = "true";

                if (isset($returnData["data"]) && is_array($returnData["data"]) && count($returnData["data"]) > 0 && $returnData["data"] != "") {

                    // $responseData = $this->emailLabelsFormatData($returnData["data"]);

                    $returnResponse["data"] = $returnData["data"];

                }

            }

        } catch (Exception $e) {

            // return $e->getMessage();

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
     * Get the email category count.
     *
     * @return array $returnData
     */
    public function emailCategoryCount($request)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            // $userData = User::all();

            $url = $this->emailCategoryCountApiUrl;

            $params = ["empcode" => auth()->user()->empcode, "ipaddress" => $request->ip()];

            $returnData = $this->postRequest($url, $params);

            if (is_array($returnData) && count($returnData) > 0 && isset($returnData["success"]) && $returnData["success"] == "true") {

                $returnResponse["success"] = "true";

                if (isset($returnData["data"]) && is_array($returnData["data"]) && count($returnData["data"]) > 0 && $returnData["data"] != "") {

                    $returnResponse["data"] = $returnData["data"];

                }

            }
        } catch (Exception $e) {

            // return $e->getMessage();

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
     * Get the email list by email field array.
     *
     * @param  array $field
     * @return array $returnData
     */
    public function emailList($field)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $responseData = [];

            $url = $this->emailListApiUrl;

            if(isset($field["category"])) {

                $url = $this->classificationEmailListApiUrl;

            }

            $returnResponseData = $this->postRequest($url, $field);

            if ($returnResponseData["success"] == "true") {

                $returnResponse["success"] = "true";

                if (is_array($returnResponseData["data"]) && count($returnResponseData["data"]) > 0 && $returnResponseData["data"] != "") {

                    $responseData = $this->formatData($returnResponseData["data"], $field);

                    if ($responseData) {

                        // $returnResponse["success"] = "true";

                        $returnResponse["data"] = $responseData;

                        if (is_array($responseData)) {

                            $returnResponse["last_updated_delay"] = "false";

                            $returnResponse["result_count"] = count($responseData);

                            if (!isset($returnResponseData["last_updated"]) || $returnResponseData["last_updated"] == "") {

                                $date = new DateTime('now', new DateTimeZone(env('APP_TIME_ZONE')));
                                $lastUpdated =  $date->format('Y/m/d h:i:s A');

                                $returnResponse["last_updated"] = $lastUpdated;

                            }

                            if (isset($returnResponseData["result_count"]) && $returnResponseData["result_count"] != "") {

                                $returnResponse["result_count"] = $returnResponseData["result_count"];

                            } elseif (is_array($returnResponseData)) {

                                $returnResponse["result_count"] = count($returnResponseData);

                            }

                            if (isset($returnResponseData["last_updated"]) && $returnResponseData["last_updated"] != "") {

                                $lastUpdated = new DateTime($returnResponseData["last_updated"], new DateTimeZone(env('APP_TIME_ZONE')));
                                $currentTime = new DateTime('now', new DateTimeZone(env('APP_TIME_ZONE')));
                                $diff = $lastUpdated->diff($currentTime);

                                $minutes = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;

                                if($minutes > 5) {

                                    $returnResponse["last_updated_delay"] = "true";

                                }

                                $returnResponse["last_updated"] = $returnResponseData["last_updated"];

                            }

                            if (isset($returnResponseData["unread_count"]) && $returnResponseData["unread_count"] != "") {

                                $returnResponse["unread_count"] = $returnResponseData["unread_count"];

                            }

                            // $date = new DateTime('now', new DateTimeZone(env('APP_TIME_ZONE')));
                            // $returnResponse["last_updated"] =  $date->format('Y/m/d h:i:s a');

                            // $returnResponse["last_updated"] = date('Y/m/d h:i:s a');

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
     * Update the email status based on email field array.
     *
     * @return array $returnResponse
     */
    public function emailStatusUpdate($request)
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
                'id'        => 'required',
                'status'    => 'required',
                'type'      => 'required'
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Update failed";
            } else {

                $paramInfo = $request->all();

                $url = $this->emailStatusUpdateUrl;

                if(isset($paramInfo["job_id"]) && $paramInfo["job_id"] != "") {

                    $url = $this->jobEmailStatusUpdateUrl;

                }

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
     * Send email based on email field array.
     *
     * @param  array $field
     * @return array $returnData
     */
    public function emailsend($field)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $url = $this->emailSendApiUrl;
			if (isset($field['to']) && $field['to'] != "") {
				$field["to"] = rtrim($field["to"],";");
                $field["to"] = base64_encode($field['to']);
            } else {
                $field["to"] = '';
            }
			if (isset($field['from']) && $field['from'] != "") {
                $field["from"] = base64_encode($field['from']);
            } else {
                $field["from"] = '';
            }
			if (isset($field['cc']) && $field['cc'] != "") {
				$field["cc"] = rtrim($field["cc"],";");
                $field["cc"] = base64_encode($field['cc']);
            } else {
                $field["cc"] = '';
            }
			if (isset($field['bcc']) && $field['bcc'] != "") {
				$field["bcc"] = rtrim($field["bcc"],";");
                $field["bcc"] = base64_encode($field['bcc']);
            } else {
                $field["bcc"] = '';
            }
			if (isset($field['subject']) && $field['subject'] != "") {
                $field["subject"] = base64_encode($field['subject']);
            } else {
                $field["subject"] = '';
            }
			if (isset($field['body_html']) && $field['body_html'] != "") {
                $field["body_html"] = base64_encode($field['body_html']);
            } else {
                $field["body_html"] = '';
            }
			if (isset($field['message_start']) && $field['message_start'] != "") {
                $field["message_start"] = base64_encode($field['message_start']);
            } else {
                $field["message_start"] = '';
            }

			$responseData = $this->postRequest($url, $field);

			if (isset($responseData["success"]) && $responseData["success"] == "true") {

				$returnResponse["success"] = "true";
				$returnResponse["message"] = "Send successfull";

			} else {

				$returnResponse["error"] = "true";
				$returnResponse["message"] = "Send unsuccessfull";

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
    public function emailGet($field)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];
        try {

            $url = $this->emailGetApiUrl;
            $responseData = $this->postRequest($url, $field);
            if (isset($responseData["success"]) && $responseData["success"] == "true") {
                $returnResponse["data"] = $responseData["data"];
                if(isset($returnResponse["data"]) && is_array($returnResponse["data"]) && count($returnResponse["data"]) > 0) {

                    $emailViewUrl = $this->emailAnnotatorBaseUrl;

                    if (isset($returnResponse["data"]["id"]) &&  $returnResponse["data"]["id"] != "") {

                        $emailViewUrl = $emailViewUrl . "/id/" . $returnResponse["data"]["id"];
                    }


                  /*   if (isset($returnResponse["data"]["empcode"]) &&  $returnResponse["data"]["empcode"] != "") {

                        $emailViewUrl = $emailViewUrl . "/empcode/" . $returnResponse["data"]["empcode"];

                    } */

                    if (isset($returnResponse["data"]["job_id"]) &&  $returnResponse["data"]["job_id"] && isset($returnResponse["data"]["status"]) &&  $returnResponse["data"]["status"] == "2") {

                        $returnResponse["data"]["email_annotator_link"] = $emailViewUrl;

                    }

					$emailDate = "";

					if(isset($returnResponse["data"]["status"]) && $returnResponse["data"]["status"] != "") {

						if( in_array($returnResponse["data"]["status"], ["0","1", "2", "3"])){

							if(isset($returnResponse["data"]["email_received_date"]) && $returnResponse["data"]["email_received_date"] != ""){

								$emailDate = $returnResponse["data"]["email_received_date"];
							}
						}

						if( in_array($returnResponse["data"]["status"], ["4", "5"])){

							if(isset($returnResponse["data"]["created_date"]) && $returnResponse["data"]["created_date"] != ""){

								$emailDate = $returnResponse["data"]["created_date"];
							}
						}

						if( in_array($returnResponse["data"]["status"], ["6"])){

							if(isset($returnResponse["data"]["email_sent_date"]) && $returnResponse["data"]["email_sent_date"] != ""){

								$emailDate = $returnResponse["data"]["email_sent_date"];
							}
						}

					}




                   // if(isset($returnResponse["data"]["email_received_date"]) && $returnResponse["data"]["email_received_date"] != "") {

                        // $returnResponse["data"]["create_date_formatted_text"] = date("dd [.stndrh\t ]+ m ([ .\t-])* y h:i:s a", strtotime($returnResponse["data"]["email_received_date"]));
                        //$returnResponse["data"]["create_date_formatted_text"] = date("d/m/Y h:i:s a", strtotime($returnResponse["data"]["email_received_date"]));


						if ($emailDate){

							$returnResponse["data"]["create_date_formatted_text"] = date("dS M Y h:i:s a", strtotime($emailDate));
						}

                   // }

                    if (isset($returnResponse["data"]["email_from"]) && $returnResponse["data"]["email_from"] != "") {

                        if (base64_decode($returnResponse["data"]["email_from"], true)) {

                            $returnResponse["data"]["email_from"] = base64_decode($returnResponse["data"]["email_from"]);

                        }

                        $returnResponse["data"]["email_from"] = htmlspecialchars($returnResponse["data"]["email_from"]);
                    }

                    if (isset($returnResponse["data"]["email_to"]) && $returnResponse["data"]["email_to"] != "") {

                        if (base64_decode($returnResponse["data"]["email_to"], true)) {

                            $returnResponse["data"]["email_to"] = base64_decode($returnResponse["data"]["email_to"]);

                        }

                        $returnResponse["data"]["email_to"] = htmlspecialchars($returnResponse["data"]["email_to"]);
                    }

                    if (isset($returnResponse["data"]["email_cc"]) && $returnResponse["data"]["email_cc"] != "") {

                        if (base64_decode($returnResponse["data"]["email_cc"], true)) {

                            $returnResponse["data"]["email_cc"] = base64_decode($returnResponse["data"]["email_cc"]);

                        }

                        $returnResponse["data"]["email_cc"] = htmlspecialchars($returnResponse["data"]["email_cc"]);
                    }

                    if (isset($returnResponse["data"]["email_bcc"]) && $returnResponse["data"]["email_bcc"] != "") {

                        if (base64_decode($returnResponse["data"]["email_bcc"], true)) {

                            $returnResponse["data"]["email_bcc"] = base64_decode($returnResponse["data"]["email_bcc"]);

                        }

                        $returnResponse["data"]["email_bcc"] = htmlspecialchars($returnResponse["data"]["email_bcc"]);
                    }
                    /*if (isset($returnResponse["data"]["body_html"]) && $returnResponse["data"]["body_html"] != "") {

                        $returnResponse["data"]["body_html"] = base64_decode($returnResponse["data"]["body_html"]);
                    }*/

                    if (isset($returnResponse["data"]["subject"]) && $returnResponse["data"]["subject"] != "") {

                       // $returnResponse["data"]["subject"] = base64_decode($returnResponse["data"]["subject"]);

                        if (base64_decode($returnResponse["data"]["subject"], true)) {

                            // $returnResponse["data"]["subject"] = htmlspecialchars(base64_decode($returnResponse["data"]["subject"]));
                            $returnResponse["data"]["subject"] = base64_decode($returnResponse["data"]["subject"]);
                        }
                    }


                    if (isset($returnResponse["data"]["body_html"]) && $returnResponse["data"]["body_html"] != "") {

                        // $returnResponse["data"]["body_html"] = base64_decode($returnResponse["data"]["body_html"]);

                        if (base64_decode($returnResponse["data"]["body_html"], true)) {

                            $returnResponse["data"]["body_html"] = base64_decode($returnResponse["data"]["body_html"]);
                        }
                    }
					if (isset($returnResponse["data"]["email_reply_all"]) && $returnResponse["data"]["email_reply_all"] != "") {

                        if (base64_decode($returnResponse["data"]["email_reply_all"], true)) {

                            $returnResponse["data"]["email_reply_all"] = base64_decode($returnResponse["data"]["email_reply_all"]);

                        }

                        $returnResponse["data"]["email_reply_all"] = htmlspecialchars($returnResponse["data"]["email_reply_all"]);
                    }
					if (isset($returnResponse["data"]["email_reply_cc"]) && $returnResponse["data"]["email_reply_cc"] != "") {

                        if (base64_decode($returnResponse["data"]["email_reply_cc"], true)) {

                            $returnResponse["data"]["email_reply_cc"] = base64_decode($returnResponse["data"]["email_reply_cc"]);

                        }

                        $returnResponse["data"]["email_reply_cc"] = htmlspecialchars($returnResponse["data"]["email_reply_cc"]);
                    }
					if (isset($returnResponse["data"]["new_signature"]) && $returnResponse["data"]["new_signature"] != "") {
                        if (base64_decode($returnResponse["data"]["new_signature"], true)) {
                            $returnResponse["data"]["new_signature"] = base64_decode($returnResponse["data"]["new_signature"]);
                        }
                   }
				   if (isset($returnResponse["data"]["replyforward_signature"]) && $returnResponse["data"]["replyforward_signature"] != "") {
                        if (base64_decode($returnResponse["data"]["replyforward_signature"], true)) {
                            $returnResponse["data"]["replyforward_signature"] = base64_decode($returnResponse["data"]["replyforward_signature"]);
                        }
                   }

                    if (isset($returnResponse["data"]["email_path_primary"]) && $returnResponse["data"]["email_path_primary"] != "") {

                        $email_filename = "email.eml";

                        $file_name_split = pathinfo($email_filename);

                        if (is_array($file_name_split) && count($file_name_split) > 0) {

                            if (isset($file_name_split["extension"]) && $file_name_split["extension"] != "") {

                                $email_file_base_name = $file_name_split["filename"];

                                if (isset($returnResponse["data"]["subject"]) && $returnResponse["data"]["subject"] != "") {

                                    $email_file_base_name = $returnResponse["data"]["subject"];
                                    $email_file_base_name = preg_replace('/[^A-Za-z0-9. _]/', '', $email_file_base_name);
                                    $email_file_base_name = preg_replace('/\\s+/', '_', $email_file_base_name);
                                    $email_file_base_name = strtolower(mb_strimwidth($email_file_base_name, 0, 50));

                                }

                                $email_file_path = route('file') . Config::get('constants.emailImageDownloadPathParams');

                                $email_file_path .= $returnResponse["data"]["email_path_primary"] . $email_filename;

                                $alais_filename = $email_file_base_name . "." . $file_name_split["extension"];

                                $email_file_path .= "&alais_name=" . $alais_filename;

                                $returnResponse["data"]["email_download_path"] = $email_file_path;

                            }

                        }

                    }

                    if (isset($returnResponse["data"]["attachments"]) && $returnResponse["data"]["attachments"] && isset($returnResponse["data"]["email_path"]) && $returnResponse["data"]["email_path"]) {

                        $emailAttachments = [];

                        $emailAttachmentPath = $returnResponse["data"]["email_path"];

                        if (base64_decode($returnResponse["data"]["attachments"], true)) {

                            $returnResponse["data"]["attachments"] = base64_decode($returnResponse["data"]["attachments"]);

                        }

                        $emailAttachments = explode("|", $returnResponse["data"]["attachments"]);



                        if(is_array($emailAttachments) && count($emailAttachments) > 0) {

                            // $returnResponse["data"]["attachment_count"] = count($emailAttachments);

                            $emailAttachmentHtml= "";
                            $emailForwardAttachmentList= "";

                            array_walk(
                                $emailAttachments,
                                function ($item, $key) use ($emailAttachmentPath, &$emailAttachmentHtml, &$emailAttachments , &$emailForwardAttachmentList) {

                                    try {

                                        if ($item) {

                                            $item_file = route('file') . Config::get('constants.emailImageDownloadPathParams');

                                            // if (base64_decode($item, true)) {

                                            //     $item = base64_decode($item);

                                            // }

                                            $item_file .= $emailAttachmentPath . $item;
                                            $item_name = $item;

                                            $emailAttachmentHtml .= '<li class="mb-0">';
                                                $emailAttachmentHtml .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 email-attachment-item-block">';
                                                    $emailAttachmentHtml .= '<a href="';
                                                    $emailAttachmentHtml .= $item_file;
                                                    $emailAttachmentHtml .= '" title="';
                                                    $emailAttachmentHtml .= $item;
                                                    $emailAttachmentHtml .= '" class="atch-thumb">';
                                                        $emailAttachmentHtml .= '<span>';
                                                            $emailAttachmentHtml .= '<i class="font-30 mr-5 fa fa-file-';
                                                            $emailAttachmentHtml .= $this->getFileType($item_name);
                                                            $emailAttachmentHtml .= '-o"></i>';
                                                        $emailAttachmentHtml .= '</span>';
                                                    $emailAttachmentHtml .= '<span class="email-attachment-item-name ">';
                                                        $emailAttachmentHtml .= mb_strimwidth($item, 0, 25, "...");
                                                    $emailAttachmentHtml .= '</span>';
                                                    $emailAttachmentHtml .= '</a>';
                                                $emailAttachmentHtml .= '</div>';
                                            $emailAttachmentHtml .= '</li>';


                                            /********** FORWARD EMAIL ATTACHEMENT LIST START ***********/
                                            $emailForwardAttachmentList .= '<li class="mb-0 attachements_'.$key.'" id="attachements_'.$key.'" >';
                                                $emailForwardAttachmentList .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 email-attachment-item-block">';
                                                    $emailForwardAttachmentList .= '<a href="';
                                                    $emailForwardAttachmentList .= $item_file;
                                                    $emailForwardAttachmentList .= '" title="';
                                                    $emailForwardAttachmentList .= $item;
                                                    $emailForwardAttachmentList .= '" class="atch-thumb" style="text-decoration:none;">';
                                                        $emailForwardAttachmentList .= '<span>';
                                                            $emailForwardAttachmentList .= '<i class="font-30 mr-5 fa fa-file-';
                                                            $emailForwardAttachmentList .= $this->getFileType($item_name);
                                                            $emailForwardAttachmentList .= '-o"></i>';
                                                        $emailForwardAttachmentList .= '</span>';
                                                    $emailForwardAttachmentList .= '<span class="email-attachment-item-name ">';
                                                        $emailForwardAttachmentList .= mb_strimwidth($item, 0, 25, "...");
                                                        $emailForwardAttachmentList .= '<i class="fa fa-times text-danger ml-5 fw-attachements" data-user-empcode="pmbot_spi-global_com_desc" data-attachement-id = "attachements_'.$key.'"></i>';
                                                    $emailForwardAttachmentList .= '</span>';
                                                    $emailForwardAttachmentList .= '</a>';
                                                $emailForwardAttachmentList .= '</div>';
                                            $emailForwardAttachmentList .= '<input type="hidden" id="fw_attachements" name="fw_attachements[]" value="'.$item_name.'"></li>';
                                            /********** FORWARD EMAIL ATTACHEMENT LIST END ***********/

                                            $emailAttachments[$key] = ["attachment_name" => $item_name, "attachment_file" => $item_file];

                                        } else {

                                            unset($emailAttachments[$key]);
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
                                }

                            );


                            if (is_array($emailAttachments) && count($emailAttachments) > 0) {

                                $returnResponse["data"]["email_attachment_count"]        = count($emailAttachments);
                                $returnResponse["data"]["email_attachment"]              = $emailAttachments;
                                $returnResponse["data"]["email_attachment_html"]         = $emailAttachmentHtml;
                                $returnResponse["data"]["email_forward_attachment_html"] = $emailForwardAttachmentList;

                            }

                        }

                    }

                }
                $returnResponse["success"] = "true";
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
	public function emailidGet($field)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];
        try {

            $url = $this->emailidGetApiUrl;
			$responseData = $this->postRequest($url, $field);

			 if (isset($responseData["success"]) && $responseData["success"] == "true") {
				  $returnResponse["data"] = $responseData["data"];
				  $returnResponse["success"] = "true";
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
	public function draftemailSend($field)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $url = $this->draftemailSendApiUrl;
			if (isset($field['email_to']) && $field['email_to'] != "") {
				$field["email_to"] = rtrim($field["email_to"],";");
                $field["email_to"] = base64_encode($field['email_to']);
            } else {
                $field["email_to"] = '';
            }
			if (isset($field['email_cc']) && $field['email_cc'] != "") {
				$field["email_cc"] = rtrim($field["email_cc"],";");
                $field["email_cc"] = base64_encode($field['email_cc']);
            } else {
                $field["email_cc"] = '';
            }
			if (isset($field['email_bcc']) && $field['email_bcc'] != "") {
				$field["email_bcc"] = rtrim($field["email_bcc"],";");
                $field["email_bcc"] = base64_encode($field['email_bcc']);
            } else {
                $field["email_bcc"] = '';
            }
			if (isset($field['subject']) && $field['subject'] != "") {
                $field["subject"] = base64_encode($field['subject']);
            } else {
                $field["subject"] = '';
            }
			if (isset($field['body_html']) && $field['body_html'] != "") {
                $field["body_html"] = base64_encode($field['body_html']);
            } else {
                $field["body_html"] = '';
            }
			$responseData = $this->postRequest($url, $field);

			if (isset($responseData["success"]) && $responseData["success"] == "true") {

				$returnResponse["success"] = "true";
				$returnResponse["message"] = "Send successfull";

			} else {

				$returnResponse["error"] = "true";
				$returnResponse["message"] = "Send unsuccessfull";

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
    public function formatData($items, $field)
    {
        $resource = array_map(

            function ($item) use ($field) {

                try {

                    $emailTypeClass = "";
                    $emailSubject = "no subject";
                    $emailGetUrl = route(__("job.email_get_url"));

                    $item["is_priority"] = "";

                    if (isset($item["priority"]) && $item["priority"] == "1") {

                        $item["is_priority"] = '<i class="fa fa-exclamation inline-block txt-danger font-16"></i>';

                    }

                    $item["is_attachments"] = "";

                    if (isset($item["attachments"]) && $item["attachments"] != "") {

                        $item["is_attachments"] = '<i class="zmdi zmdi-attachment inline-block font-16"></i>';
                    }

					$emailDate = "";

					if(isset($item["status"]) && $item["status"] != "") {

						if( in_array($item["status"], ["0","1", "2", "3", "7"])){

							if(isset($item["email_received_date"]) && $item["email_received_date"] != ""){

								$emailDate = $item["email_received_date"];
							}
						}

						if( in_array($item["status"], ["4", "5", "55"])){

                            if (isset($item["created_date"]) && $item["created_date"] != "") {

                                $emailDate = $item["created_date"];

                            }

							if(isset($item["modified_date"]) && $item["modified_date"] != ""){

                                $emailDate = $item["modified_date"];

                            }

						}

						if( in_array($item["status"], ["6", "99"])){

							if(isset($item["email_sent_date"]) && $item["email_sent_date"] != ""){

								$emailDate = $item["email_sent_date"];
							}
						}

					}

					if ($emailDate){

						//	$returnResponse["data"]["create_date_formatted_text"] = date("dS M Y h:i:s a", strtotime($emailDate));

							$item["created_date"] = date("Y/m/d H:i:s", strtotime($emailDate));
						}

                    /*  if (isset($item["created_date"]) && $item["created_date"] != "") {

                        $item["created_date_text"] = $item["created_date"];
                        // $item["created_date"] = date("d/m/y", strtotime($item["created_date"]));
                        //$item["created_date"] = date("d/m/y h:i:s a", strtotime($item["created_date"]));
						$item["created_date"] = date("Y/m/d H:i:s", strtotime($item["created_date"]));
                    } */

                    if (isset($item["email_from"]) && $item["email_from"] != "") {

                        if (base64_decode($item["email_from"], true)) {

                            $item["email_from"] = base64_decode($item["email_from"]);

                        }

                    }

                    if (isset($item["email_to"]) && $item["email_to"] != "") {

                        if (base64_decode($item["email_to"], true)) {

                            $item["email_to"] = base64_decode($item["email_to"]);

                        }

                    }

                    if (isset($item["email_cc"]) && $item["email_cc"] != "") {

                        if (base64_decode($item["email_cc"], true)) {

                            $item["email_cc"] = base64_decode($item["email_cc"]);

                        }

                    }

                    if (isset($item["email_bcc"]) && $item["email_bcc"] != "") {

                        if (base64_decode($item["email_bcc"], true)) {

                            $item["email_bcc"] = base64_decode($item["email_bcc"]);

                        }

                    }

                    if (isset($item["message_start"]) && $item["message_start"] != "") {

                        if (base64_decode($item["message_start"], true)) {

                            $item["message_start_text"] = $item["message_start"];

                            $item["message_start"] = base64_decode($item["message_start"]);

                        }

                    }

                    if (isset($item["body_html"]) && $item["body_html"] != "") {

                        if (base64_decode($item["body_html"], true)) {

                            $item["body_html"] = base64_decode($item["body_html"]);
                        }

                        // $item["message"] = mb_strimwidth( $item["body_html"], 0, 100, "...");
                        // $item["message"] = mb_strimwidth(htmlentities($item["body_html"]), 0, 100, "...");
                        $item["message"] = mb_strimwidth(trim(strip_tags($item["body_html"])), 0, 100, "...");
                    }

                    if (isset($item["subject"]) && $item["subject"] != "") {

                        if (base64_decode($item["subject"], true)) {

                            $item["subject"] = base64_decode($item["subject"]);

							$emailSubject = $item["subject"];

                        }
                    }

                    // if(isset($item["status"]) && $item["status"] != "2") {
                    if (isset($item["status"]) && $item["status"] != "") {

                        $emailStatusList = Config::get('constants.emailStatus');

                        $item['status_text'] = $item["status"];

                        if (is_array($emailStatusList) && count($emailStatusList) > 0) {

                            $item['status_text'] = $emailStatusList[$item["status"]];
                        }

                        $item['status_text'] = '<span class="label bg-' . $item['status_text'] . '"> ' . $item["status_text"] . '</span>';

                        $emailViewUrl = $this->emailAnnotatorBaseUrl;

                        if (isset($item["id"]) &&  $item["id"] != "") {

                      //      $emailViewUrl = $emailViewUrl . "?id=" . $item["id"];
                      //      $emailViewUrl = $emailViewUrl . "/" . $item["id"];
					  //Bharathi changed as per Balaji's new format 10 May 2020
                            $emailViewUrl = $emailViewUrl . "/id/" . $item["id"];
                        }

						if($item["status"] != "0") {

                            $emailTypeClass = "pmbot-email-item";

                        }

                        if (strtolower($item["empcode"]) != strtolower(auth()->user()->empcode)) {

                            $emailTypeClass = "pmbot-email-item";
                        }

						//Bharathi changed as per Balaji's new format 10 May 2020
						/* if (isset($item["empcode"]) &&  $item["empcode"] != "") {

                        //    $emailViewUrl = $emailViewUrl . "&empcode=" . $item["empcode"];
                            $emailViewUrl = $emailViewUrl . "/empcode/" . $item["empcode"];
                        } */

                         $item['subject_link'] = '<a class="btn-link email-item ' . $emailTypeClass . '" href="' . $emailViewUrl . '" data-email-id="' . $item["id"] . '" data-email-geturl="' . $emailGetUrl . '">' . mb_strimwidth($emailSubject, 0, 75, "...") . '</a>';
                    }

                    return $item;
                } catch (Exception $e) {

                    $this->error(
                        "app_error_log_" . date('Y-m-d'),
                        " => FILE => " . __FILE__ . " => " .
                            " => LINE => " . __LINE__ . " => " .
                            " => MESSAGE => " . $e->getMessage() . " "
                    );
                }
            },
            $items
        );

        return $resource;
    }

    public function pmsEmailCountFormatData($items)
    {
        $resource = array_map(

            function ($item) {

                try {

                    $item["negative_count_link"] = "0";

                    if(isset($item["last_processed_time"]) && $item["last_processed_time"] != "") {

                        $item["last_processed_time"] = date("Y/m/d H:i:s", strtotime($item["last_processed_time"]));

                    }

                    if (isset($item["last_annotated_time"]) && $item["last_annotated_time"] != "") {

                        $item["last_annotated_time"] = date("Y/m/d H:i:s", strtotime($item["last_annotated_time"]));
                    }

                    if (isset($item["negative_count"]) && $item["negative_count"] != ""&& $item["negative_count"] != "0") {

                        $item["negative_count_link"] = '<a class="dashboard-email-sent-count-btn" href="#sentEmailModal" data-toggle="modal" data-grid-selector="emailSentCountGrid" data-grid-title="alarming email" data-count="' . $item["negative_count"]. '" data-email-filter="negative" data-empcode="' . $item["empcode"] . '"><span class="txt-danger underlined">' . $item["negative_count"] . '</span></a>';

                    }

                    return $item;

                } catch (Exception $e) {

                    $this->error(
                        "app_error_log_" . date('Y-m-d'),
                        " => FILE => " . __FILE__ . " => " .
                            " => LINE => " . __LINE__ . " => " .
                            " => MESSAGE => " . $e->getMessage() . " "
                    );
                }
            },
            $items
        );

        return $resource;
    }

    public function emailRulesFormatData($items)
    {
        $resource = array_map(

            function ($item) {

                try {

                    if (isset($item["status"])) {

                        $status = false;

                        if ($item["status"] == "1") {

                            $status = true;
                        }

                        $item["status"] = $status;

                    }

                    return $item;

                } catch (Exception $e) {

                    $this->error(
                        "app_error_log_" . date('Y-m-d'),
                        " => FILE => " . __FILE__ . " => " .
                        " => LINE => " . __LINE__ . " => " .
                        " => MESSAGE => " . $e->getMessage() . " "
                    );
                }
            },
            $items
        );

        return $resource;
    }

    public function emailLabelsFormatData($items)
    {
        $resource = array_map(

            function ($item) {

                try {

                    return [
                        "id" => $item["id"],
                        "text" => $item["label_name"]
                    ];
                } catch (Exception $e) {

                    $this->error(
                        "app_error_log_" . date('Y-m-d'),
                        " => FILE => " . __FILE__ . " => " .
                        " => LINE => " . __LINE__ . " => " .
                        " => MESSAGE => " . $e->getMessage() . " "
                    );
                }
            },
            $items
        );

        return $resource;
    }

	 public function signatureUpdate($field)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $url = $this->signatureupdateApiUrl;

			if (isset($field['new_signature']) && $field['new_signature'] != "") {
                $field["new_signature"] = base64_encode($field['new_signature']);
				$field["new_signature"] = $field['new_signature'];
            } else {
                $field["new_signature"] = '';
            }
			if (isset($field['replyforward_signature']) && $field['replyforward_signature'] != "") {
                $field["replyforward_signature"] = base64_encode($field['replyforward_signature']);
				//$field["replyforward_signature"] = $field['replyforward_signature'];
            } else {
                $field["replyforward_signature"] = '';
            }
			$responseData = $this->postRequest($url, $field);

			if (isset($responseData["success"]) && $responseData["success"] == "true") {

				$returnResponse["success"] = "true";
				$returnResponse["message"] = "Send successfull";

			} else {

				$returnResponse["error"] = "true";
				$returnResponse["message"] = "Send unsuccessfull";

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

	public function getSignature($field)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];
        try {

            $url = $this->getsignatureApiUrl;
			$responseData = $this->postRequest($url, $field);

			 if (isset($responseData["success"]) && $responseData["success"] == "true") {

				  if (isset($responseData["data"]["new_signature"]) && $responseData["data"]["new_signature"] != "") {
                        if (base64_decode($responseData["data"]["new_signature"], true)) {
                            $responseData["data"]["new_signature"] = base64_decode($responseData["data"]["new_signature"]);
                        }
                  }
				  if (isset($responseData["data"]["replyforward_signature"]) && $responseData["data"]["replyforward_signature"] != "") {
                        if (base64_decode($responseData["data"]["replyforward_signature"], true)) {
                            $responseData["data"]["replyforward_signature"] = base64_decode($responseData["data"]["replyforward_signature"]);
                        }
                  }
				  $returnResponse["data"] = $responseData["data"];
				  $returnResponse["success"] = "true";
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
}
