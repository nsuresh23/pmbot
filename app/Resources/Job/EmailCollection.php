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
    protected $emailRuleLabelCategoryApiUrl;
    protected $emailMoveToApiUrl;
    protected $emailClassificationMoveToApiUrl;
    protected $emailAnnotatorBaseUrl;
    protected $emailStatusUpdateUrl;
    protected $jobEmailStatusUpdateUrl;
	protected $signatureupdateApiUrl;
	protected $getsignatureApiUrl;
    protected $emailSentCountApiUrl;
    protected $emailCategoryCountApiUrl;
    protected $classificationEmailListApiUrl;
    protected $qcEmailListApiUrl;
    protected $emailInfoUpdateApiUrl;
    protected $emailAutosaveSendApiUrl;
    protected $emailReviewListApiUrl;
    protected $emailUpdateRatingApiUrl;
    protected $latestEmailListApiUrl;
    protected $reviewEmailGetApiUrl;

    public function __construct()
    {
        $this->fractal = new Manager();

        $this->emailSendApiUrl                  = env('API_EMAIL_SEND_URL');
		$this->draftemailSendApiUrl             = env('API_DRAFT_EMAIL_SEND_URL');
        $this->emailGetApiUrl                   = env('API_GET_EMAIL_URL');
		$this->emailidGetApiUrl                 = env('API_GET_EMAILID_URL');
        $this->emailListApiUrl                  = env('API_EMAIL_BOX_LIST_URL');
        $this->pmsEmailCountApiUrl              = env('API_PMS_EMAIL_COUNT_URL');
        $this->emailRulesApiUrl                 = env('API_EMAIL_RULES_URL');
        $this->emailAddRulesApiUrl              = env('API_EMAIL_ADD_RULES_URL');
        $this->emailUpdateRulesApiUrl           = env('API_EMAIL_UPDATE_RULES_URL');
        $this->emailDeleteRulesApiUrl           = env('API_EMAIL_DELETE_RULES_URL');
        $this->emailRuleLabelsApiUrl            = env('API_EMAIL_FOLDERS_URL');
        $this->emailRuleLabelCategoryApiUrl     = env('API_EMAIL_FOLDERS_CATEGORY_URL');
        $this->emailMoveToApiUrl                = env('API_EMAIL_MOVE_TO_URL');
        $this->emailClassificationMoveToApiUrl  = env('API_EMAIL_CLASSIFICATION_MOVE_TO_URL');
        $this->emailAnnotatorBaseUrl            = env("EMAIL_ANNOTATOR_BASE_URL");
        $this->emailStatusUpdateUrl             = env("API_EMAIL_STATUS_UPDATE_URL");
        $this->jobEmailStatusUpdateUrl          = env("API_JOB_EMAIL_STATUS_UPDATE_URL");
		$this->signatureupdateApiUrl            = env('API_SIGNATURE_UPDATE_URL');
        $this->getsignatureApiUrl               = env('API_GET_SIGNATURE_URL');
        $this->emailSentCountApiUrl             = env('API_EMAIL_SENT_COUNT_URL');
        $this->emailCategoryCountApiUrl         = env('API_EMAIL_CATEGORY_COUNT_URL');
        $this->classificationEmailListApiUrl    = env('API_EMAIL_CLASSIFICATION_LIST_URL');
        $this->qcEmailListApiUrl                = env('API_EMAIL_QC_LIST_URL');
        $this->emailInfoUpdateApiUrl            = env('API_EMAIL_INFO_UPDATE_URL');
        $this->emailAutoSaveSendApiUrl          = env('API_EMAIL_AUTOSAVE_SEND_URL');
        $this->emailReviewListApiUrl            = env('API_EMAIL_REVIEW_LIST_URL');
        $this->emailUpdateRatingApiUrl          = env('API_EMAIL_RATING_SEND_URL');
        $this->latestEmailListApiUrl            = env('API_LATEST_EMAIL_LIST_URL');
        $this->reviewEmailGetApiUrl             = env('API_REVIEW_EMAIL_GET_URL');
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

            // $params = ["empcode" => env('JOB_ADD_AM_EMPCODE')];
            $params = ["empcode" => auth()->user()->empcode];

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

            // $params = ["empcode" => env('JOB_ADD_AM_EMPCODE'), "status" => "1"];
            $params = ["empcode" => auth()->user()->empcode, "status" => "1"];

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
     * Get the email rules labels.
     *
     * @return array $returnData
     */
    public function emailMoveToLabels()
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            // $userData = User::all();

            $url = $this->emailRuleLabelCategoryApiUrl;

            $params = ["empcode" => env('JOB_ADD_AM_EMPCODE'), "current_empcode" => auth()->user()->empcode, "status" => "1"];

            $returnData = $this->postRequest($url, $params);

            if ($returnData["success"] == "true" && is_array($returnData["data"]) && count($returnData["data"]) > 0 && $returnData["data"] != "") {

                $emailMoveToList = [];

                // $emailMoveToList[""] = "Please select";

                if (isset($returnData["data"]["am"]) && is_array($returnData["data"]["am"]) && count($returnData["data"]["am"])) {

                    $amEmailMoveToList = $this->emailMoveToLabelsFormatData($returnData["data"]["am"]);

                    $emailMoveToList = $emailMoveToList + ["0" => "Inbox"] + $amEmailMoveToList;

                }

                if (isset($returnData["data"]["user"]) && is_array($returnData["data"]["user"]) && count($returnData["data"]["user"])) {

                    $emailMoveToList = $emailMoveToList + $this->emailMoveToLabelsFormatData($returnData["data"]["user"]);
                }

                // $emailMoveToList = $this->emailMoveToLabelsFormatData($returnData["data"]);

                // $emailMoveToList = ["0" => "Inbox"] + $emailMoveToList;

                $responseData = $emailMoveToList;

                if ($responseData) {

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

                if(isset($responseData["data"]) && $responseData["data"] != "") {

                    $returnResponse["message"] = $responseData["data"];

                }

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

                if(isset($responseData["data"]) && $responseData["data"] != "") {

                    $returnResponse["message"] = $responseData["data"];

                }

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
     * Get the email templates.
     *
     * @return array $returnData
     */
    public function emailTemplates($params)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            // $url = $this->emailTemplatesApiUrl;

            // $responseData = $this->postRequest($url, $params);

            // <p>
            //     Regards, <br>
            //     <span id="pm_signature" class="pm_signature">{{pm_signature}}</span>
            // </p>

            $responseData["data"] = [
                "template_1" => '<div dir="ltr">
                        <p>
                            Dear <span id="author_name" class="author_name">{{author_name}}</span>,
                        </p>
                        <p style="padding:10px 0px 10px 0px;">I hope this finds you well.</p>
                        <p style="padding:10px 0px 10px 0px;">It\'s been <span id="txt2" style="background:#00ffe7;">[ADD length of time]</span> since my last correspondence with you, and I wanted to check in and see how your manuscript is progressing. I note from our last correspondence that:</p>
                        <ul style="width:88%;">
                            <li id="txt3" style="background:#00ffe7;">
                            Summarise any key points here as this will be project specific - this include a reminder to provide sample content, a query about content for a companion website, a request for updated ToC etc.
                            </li>
                        </ul>
                        <p>
                        <b>Permissions</b><br>
                        May I also take this opportunity to remind you <span id="txt10" style="background:#00ffe7;">(or your contributors)</span> that you are responsible for clearing all third-party permissions. Our permissions digest can be found here: <span id="txt10"><___></span>
                        </p>
                        <p style="padding:10px 0px 10px 0px;"><b>Text design <span id="txt10" style="background:#00ffe7;">[edited as required]</span></b></p>
                        <p>
                        <span id="txt6" style="background:#00ffe7;">For books following the global standard design:</span>
                        <br>
                        May I take this opportunity to share with you <span id="txt7" style="background:#00ffe7;">(again)</span> the attached text design that will be applied to your book
                        </p>
                        <p style="padding:10px 0px 10px 0px;">
                        <span id="txt8" style="background:#00ffe7;">For books in a series:</span><br>
                        Your book is in a series and therefore will follow the series design.
                        </p>
                        <p style="padding:10px 0px 10px 0px;">
                        <span id="txt9" style="background:#00ffe7;">For model books:</span><br>
                        May I also draw your attention to the text design that will be applied to your book? Please see the attached for samples.
                        </p>
                        <p style="padding:10px 0px 10px 0px;">
                        <b>Schedule</b><br>
                        Your current agreed submission date is <span id="txt10" style="background:#00ffe7;">[Add last agreed date here]</span>. Can you confirm that you are still on track to meet this date?
                        </p>
                        I look forward to hearing from you soon,
                    </div>',
                "template_2" => '<div dir="ltr">
                        <p>
                            Dear <span id="author_name" class="author_name">{{author_name}}</span>,
                        </p>

                        <p style="padding:10px 0px 10px 0px;">
                            I hope that this email finds you well. I just wanted to check in to see how things are coming along with the manuscript preparation. Please can you update me on where you are with the project at present?
                        </p>

                        <p style="padding:10px 0px 10px 0px;">
                            I look forward to hearing the latest on the project and please do get in touch if you have any questions that I can help with.
                        </p>
                    </div>',
                "template_3" => '<div dir="ltr">
                        <p>
                            Dear <span id="author_name" class="author_name">{{author_name}}</span>,
                        </p>
                        <p style="padding:10px 0px 10px 0px;">
                            I am <span id="pm_name" class="pm_name">{{pm_name}}</span> working with John Wiley & Sons as Project Editor. I have taken over the below project from <span id="project-start-date" class="project_start_date">{{project_start_date}}</span>.
                        </p>
                        <p style="padding:10px 0px 10px 0px;">
                            Good day! It would be great if you could provide a tentative date as to when we would be receiving the final manuscript. You may also share the manuscript until whatever stage it is ready now so that I can start working on it simultaneously.
                        </p>
                    </div>',
                "template_4" => '<div dir="ltr">
                        <p>
                            Dear <span id="author_name" class="author_name">{{author_name}}</span>,
                        </p>
                        <p style="padding:10px 0px 10px 0px;">
                            I would like to introduce myself as <span id="pm_name" class="pm_name">{{pm_name}}</span>, your new Project Editor. <span id="pe_name" class="pe_name">{{pe_name}}</span> has briefed me on your project and I will be your primary contact going forward, providing guidance and support as you progress towards handover to production.
                        </p>
                        <p style="padding:10px 0px 10px 0px;">
                            I wanted to take this opportunity to check in with you and see how you are progressing with the manuscript.
                        </p>
                        <p style="padding:10px 0px 10px 0px;">
                            As you work on the manuscript, please do not hesitate to get in touch should you have any concerns. I am here to offer all the support you need.
                        </p>
                    </div>',
                "template_5" => '<div dir="ltr">
                        <p>
                            Dear <span id="author_name" class="author_name">{{author_name}}</span>,
                        </p>
                        <p style="padding:10px 0px 10px 0px;">
                            I\'d like to introduce myself as <span id="pm_name" class="pm_name">{{pm_name}}</span>, your new Project Editor.
                        </p>
                        <p style="padding:10px 0px 10px 0px;">
                            <span id="pe_name" class="pe_name">{{pe_name}}</span> has briefed me on your project and I will be your primary contact going forward, providing guidance and support as you progress towards handover to production.
                        </p>
                        <p style="padding:10px 0px 10px 0px;">
                            I am writing today to touch base and check how you are progressing with the manuscript.
                        </p>
                        <p style="padding:10px 0px 10px 0px;">
                            Please don\'t hesitate to contact me if you have any queries. I am very much looking forward to working with you and bringing this project to fruition together.
                        </p>
                    </div>',
                "template_6" => '<div dir="ltr">
                        <p>
                            Dear <span id="author_name" class="author_name">{{author_name}}</span>,
                        </p>
                        <p style="padding:10px 0px 10px 0px;">
                            Hope you are doing well!
                        </p>
                        <p style="padding:10px 0px 10px 0px;">
                            I am hoping the manuscript finalisation is in progress. As we have passed the scheduled submission date, could you please let me know a revised date you are working towards?
                        </p>
                        <p style="padding:10px 0px 10px 0px;">
                            Please let me know if you have any questions and I will be happy to address them.
                        </p>
                    </div>',
                "template_7" => '<div dir="ltr">
                        <p>
                            Dear <span id="author_name" class="author_name">{{author_name}}</span>,
                        </p>
                        <p style="padding:10px 0px 10px 0px;">
                            Hope you\'re doing well.
                        </p>
                        <p style="padding:10px 0px 10px 0px;">
                            I thought to check with you on the status of the feedback from your co-authors.
                        </p>
                        <p style="padding:10px 0px 10px 0px;">
                            Please let me know if I can be of any help.
                        </p>
                    </div>'
            ];



            $responseData["success"] = "true";

            if ($responseData["success"] == "true" && is_array($responseData["data"]) && count($responseData["data"]) && $responseData["data"] != "") {

                $responseFormatData = $this->emailTemplatesFormatData($responseData["data"]);

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
     * Update the email rating.
     *
     * @return array $returnData
     */
    public function emailUpdateRating($params)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $url = $this->emailUpdateRatingApiUrl;

            $responseData = $this->postRequest($url, $params);

            if (isset($responseData["success"]) && $responseData["success"] == "true") {

                $returnResponse["success"] = "true";
                $returnResponse["message"] = "Update successfull";

                if (isset($responseData["data"]) && $responseData["data"] != "") {

                    $returnResponse["message"] = $responseData["data"];
                }
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
            $rules = [];
            $paramInfo = $request->all();
            $url = $this->emailMoveToApiUrl;

            $rules["id"] = "required";

            if (isset($paramInfo["email_classification_category"]) && $paramInfo["email_classification_category"]) {

                $url = $this->emailClassificationMoveToApiUrl;

                $rules["email_classification_category"] = "required";

            } else {

                $rules["label_name"] = "required";

            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Update failed";
            } else {

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
     * Update the email view based on email field array.
     *
     * @return array $returnResponse
     */
    public function emailViewUpdate($paramInfo)
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
            $rules = [];
            $url = $this->emailInfoUpdateApiUrl;

            $rules["id"] = "required";

            $paramInfo["type"] = "view";

            $validator = Validator::make($paramInfo, $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Update failed";
            } else {

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
     * Update the email review based on email field array.
     *
     * @return array $returnResponse
     */
    public function emailReviewUpdate($paramInfo)
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
            $rules = [];
            $url = $this->emailInfoUpdateApiUrl;

            $rules["id"] = "required";

            $validator = Validator::make($paramInfo, $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Update failed";
            } else {

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

            if (isset($field["email_type"]) && $field["email_type"] == "email-review") {

                $url = $this->emailReviewListApiUrl;

            }

            if (isset($field["email_type"]) && $field["email_type"] == "email-review-latest") {

                $url = $this->latestEmailListApiUrl;

            }

            if (isset($field["email_type"]) && $field["email_type"] == "qcEmail" && isset($field["email_filter"]) && $field["email_filter"] != "") {

                // $field["email_type"] = "myEmail";
                // $field["empcode"] = "raddevelopers@spi-global.com";

                $fieldData = [];

                if (isset($field["filter"]) && $field["filter"] != "") {

                    $fieldData["filter"] = $field["filter"];

                }

                $fieldData["email_classification_category"] = "negative";

                // if(isset($field["empcode"]) && $field["empcode"] != "") {

                //     $fieldData["empcode"] = $field["empcode"];

                // }

                if (isset($field["current_empcode"]) && $field["current_empcode"] != "") {

                    $fieldData["empcode"] = $field["current_empcode"];

                }

                if (in_array(auth()->user()->role, config('constants.amUserRoles'))) {


                    if($field["email_filter"] == "potentially_alarming") {

                        $fieldData["am_approved"] = "0";
                        $fieldData["qc_approved"] = "0";

                    }

                    if ($field["email_filter"] == "alarming") {

                        $fieldData["am_approved"] = "0";
                        $fieldData["qc_approved"] = "1";

                    }

                    if ($field["email_filter"] == "escalation") {

                        $fieldData["am_approved"] = "1";

                    }

                }

                if (in_array(auth()->user()->role, config('constants.qcUserRoles'))) {

                    $fieldData["qc_approved"] = "0";
                    $fieldData["am_approved"] = "0";

                }

                if(is_array($fieldData) && count($fieldData)) {

                    $field = $fieldData;

                }

                $url = $this->qcEmailListApiUrl;

            }

            $returnResponseData = $this->postRequest($url, $field);

            /* $returnResponseData = [
                'success' => 'true',
                'error' => 'false',
                'message' => '',
                'data' => [
                    0 => [
                        'latest_modified_date' => '2021-03-16 13:54:00',
                        'id' => '2259',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'Rajarethinam K',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => 'b8bb8948-8cb9-4229-a0f2-6f095e31fefa',
                        'email_messageid' => NULL,
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'ay5yYWphcmV0aGluYW1Ac3BpLWdsb2JhbC5jb20=',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => '2021-03-16 13:54:00',
                        'email_sent_date' => '2021-03-16 13:54:00',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => '\\\\172.24.134.26\\TSG\\Technology\\RAD\\TechUtilities\\PMBot\\emails\\dev\\RADDEVELOPERS@SPI-GLOBAL.COM\\2021\\3\\16\\b8bb8948-8cb9-4229-a0f2-6f095e31fefa\\',
                        'attachments' => NULL,
                        'created_date' => '2021-03-16 13:57:16',
                        'modified_date' => '2021-03-16 13:57:30',
                        'email_type' => 'reply',
                        'source' => NULL,
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UkU6IFNZU1RFTSBBTk5PVU5DRU1FTlQgOjogUm91dGUgUmVkaXN0cmlidXRpb24gSW4gUEggQW5kIElOIFJvdXRlcnMgRm9yIFRoZSBOZXcgR2xvYmUgTVBMUyB0dW5uZWwgOjogQ09NUExFVEVE',
                        'message_start' => 'SGksDQombmJzcDsNClBsZWFzZSBjaGVjayB0aGUgZW1haWwgc2lnbmF0dXJlIGZvcm1hdC4NCiZuYnNwOw0KJm5ic3A7DQoNClRoYW5rcywNClJhamENCiZuYnNwOw0KUmFqYQ==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                        'reviewed'=> '1',
                    ],
                    1 => [
                        'latest_modified_date' => '2021-03-12 13:53:21',
                        'id' => '2228',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'Rajarethinam K',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '',
                        'email_messageid' => '',
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'bi5zdXJlc2hrdW1hckBzcGktZ2xvYmFsLmNvbQ==',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2021-03-12 13:53:21',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => NULL,
                        'attachments' => NULL,
                        'created_date' => '2021-03-12 13:56:35',
                        'modified_date' => '2021-03-12 13:56:44',
                        'email_type' => 'new',
                        'source' => 'inbox',
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UmVnOltlbWFpbCBzaWduYXR1cmUgdGVzdF0=',
                        'message_start' => 'SGkgU3VyZXNoLA0KJm5ic3A7DQpUaGlzIGlzIGVtYWlsIHNpZ25hdHVyZSB0ZXN0IGVtYWlsDQpjaGVjayB0aGlzDQombmJzcDsNCg0KVGhhbmtzLA0KUmFqYQ0KJm5ic3A7DQ==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                        'reviewed' => '1',
                    ],
                    2 => [
                        'latest_modified_date' => '2021-02-09 10:15:14',
                        'id' => '2079',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '',
                        'email_messageid' => '',
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'bi5zdXJlc2hrdW1hckBzcGktZ2xvYmFsLmNvbQ==',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2021-02-09 10:15:14',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => NULL,
                        'attachments' => NULL,
                        'created_date' => '2021-02-08 18:38:52',
                        'modified_date' => '2021-02-09 10:17:42',
                        'email_type' => 'new',
                        'source' => 'inbox',
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UmVnOlsgc3R5bGUgdGFnIHRlc3Rd',
                        'message_start' => 'SGksJm5ic3A7DQombmJzcDsNClRoaXMgaXMgdGVzdCBlbWFpbCB3aXRoIHN0eWxlIHRhZw0KJm5ic3A7DQpUaGFua3MsDQombmJzcDs=',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                    ],
                    3 => [
                        'latest_modified_date' => '2021-02-08 19:51:02',
                        'id' => '2085',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '',
                        'email_messageid' => NULL,
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'bi5zdXJlc2hrdW1hckBzcGktZ2xvYmFsLmNvbQ==',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2021-02-08 19:51:02',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => NULL,
                        'attachments' => NULL,
                        'created_date' => '2021-02-08 19:53:17',
                        'modified_date' => '2021-02-08 19:53:29',
                        'email_type' => 'reply',
                        'source' => 'inbox',
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UkU6IFJlZzpbRWRpdG9yIFt0ZXN0XQ==',
                        'message_start' => 'SGksDQombmJzcDsNClRlc3QgdGhlIGJlbG93IGlzc3Vlcw0KJm5ic3A7DQoNCmlzc3VlIG9uZSZuYnNwOw0KaXNzdWUgdHdvJm5ic3A7DQppc3N1ZSB0aHJlZSZuYnNwOw0KDQ==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                    ],
                    4 => [
                        'latest_modified_date' => '2021-02-08 19:35:52',
                        'id' => '2084',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '',
                        'email_messageid' => NULL,
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'bi5zdXJlc2hrdW1hckBzcGktZ2xvYmFsLmNvbQ==',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2021-02-08 19:35:52',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => NULL,
                        'attachments' => NULL,
                        'created_date' => '2021-02-08 19:38:04',
                        'modified_date' => '2021-02-08 19:38:19',
                        'email_type' => 'reply',
                        'source' => 'inbox',
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UkU6IFJlZzpbRWRpdG9yIFt0ZXN0XQ==',
                        'message_start' => 'SGksDQombmJzcDsNClRlc3QgdGhlIGJlbG93IGlzc3Vlcw0KJm5ic3A7DQoNCmlzc3VlIG9uZSZuYnNwOw0KaXNzdWUgdHdvJm5ic3A7DQppc3N1ZSB0aHJlZSZuYnNwOw0KDQ==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                    ],
                    5 => [
                        'latest_modified_date' => '2021-02-08 19:25:15',
                        'id' => '2083',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '',
                        'email_messageid' => NULL,
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'bi5zdXJlc2hrdW1hckBzcGktZ2xvYmFsLmNvbQ==',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2021-02-08 19:25:15',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => NULL,
                        'attachments' => NULL,
                        'created_date' => '2021-02-08 19:27:33',
                        'modified_date' => '2021-02-08 19:27:42',
                        'email_type' => 'reply',
                        'source' => 'inbox',
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UkU6IFJlZzpbRWRpdG9yIFt0ZXN0XQ==',
                        'message_start' => 'SGksDQombmJzcDsNClRlc3QgdGhlIGJlbG93IGlzc3Vlcw0KJm5ic3A7DQoNCmlzc3VlIG9uZSZuYnNwOw0KaXNzdWUgdHdvJm5ic3A7DQppc3N1ZSB0aHJlZSZuYnNwOw0KDQ==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                    ],
                    6 => [
                        'latest_modified_date' => '2021-02-08 19:15:47',
                        'id' => '2082',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '',
                        'email_messageid' => '',
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'bi5zdXJlc2hrdW1hckBzcGktZ2xvYmFsLmNvbQ==',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2021-02-08 19:15:47',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => NULL,
                        'attachments' => NULL,
                        'created_date' => '2021-02-08 19:18:04',
                        'modified_date' => '2021-02-08 19:27:34',
                        'email_type' => 'new',
                        'source' => 'inbox',
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UmVnOltFZGl0b3IgW3Rlc3Rd',
                        'message_start' => 'SGksDQombmJzcDsNClRlc3QgdGhlIGJlbG93IGlzc3Vlcw0KJm5ic3A7DQoNCmlzc3VlIG9uZSZuYnNwOw0KaXNzdWUgdHdvJm5ic3A7DQppc3N1ZSB0aHJlZSZuYnNwOw0KDQ==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                    ],
                    7 => [
                        'latest_modified_date' => '2021-02-08 19:08:07',
                        'id' => '2081',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '',
                        'email_messageid' => '',
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'bi5zdXJlc2hrdW1hckBzcGktZ2xvYmFsLmNvbQ==',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2021-02-08 19:08:07',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => NULL,
                        'attachments' => NULL,
                        'created_date' => '2021-02-08 19:10:25',
                        'modified_date' => '2021-02-08 19:10:34',
                        'email_type' => 'new',
                        'source' => 'inbox',
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UmVnOltjdXJseSBxdW90ZXMgcGFyYSB0ZXN0XQ==',
                        'message_start' => 'SGkmbmJzcDsNCiZuYnNwOw0KU3RyYWlnaHQgcXVvdGVzIGFyZSB0aGUgdHdvIGdlbmVyaWMgdmVydGljYWwgcXVvdGF0aW9uIG1hcmtzIGxvY2F0ZWQgbmVhciB0aGUgcmV0dQ==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                    ],
                    8 => [
                        'latest_modified_date' => '2021-02-08 19:05:53',
                        'id' => '2080',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '',
                        'email_messageid' => '',
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'bi5zdXJlc2hrdW1hckBzcGktZ2xvYmFsLmNvbQ==',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2021-02-08 19:05:53',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => NULL,
                        'attachments' => NULL,
                        'created_date' => '2021-02-08 19:08:12',
                        'modified_date' => '2021-02-08 19:08:20',
                        'email_type' => 'new',
                        'source' => 'inbox',
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UmVnOltlZGl0b3Igc3R5bGUgdGVzdF0=',
                        'message_start' => 'SGksDQombmJzcDsNCnRoaXMgaXMgZWRpdG9yIHN0eWxlIHRlc3QgZm9yIGxpc3QgYW5kIHN1YiBsaXN0DQombmJzcDsNCg0Kb25lDQp0d28NCnRocmVlDQpmb3VyDQoNCmNoZQ==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                    ],
                    9 => [
                        'latest_modified_date' => '2021-02-08 16:56:01',
                        'id' => '2078',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '',
                        'email_messageid' => '',
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'bi5zdXJlc2hrdW1hckBzcGktZ2xvYmFsLmNvbQ==',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2021-02-08 16:56:01',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => NULL,
                        'attachments' => NULL,
                        'created_date' => '2021-02-08 16:58:20',
                        'modified_date' => '2021-02-08 16:58:28',
                        'email_type' => 'new',
                        'source' => 'inbox',
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UmVnOltjdXJseSBxdW90ZSB0ZXN0XQ==',
                        'message_start' => 'U3RyYWlnaHQgcXVvdGVzIGFyZSB0aGUgdHdvIGdlbmVyaWMgdmVydGljYWwgcXVvdGF0aW9uIG1hcmtzIGxvY2F0ZWQgbmVhciB0aGUgcmV0dXJuIGtleTogdGhlIHN0cmFpZw==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                    ],
                    10 => [
                        'latest_modified_date' => '2021-02-08 16:46:19',
                        'id' => '2077',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '',
                        'email_messageid' => NULL,
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'bi5zdXJlc2hrdW1hckBzcGktZ2xvYmFsLmNvbQ==',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2021-02-08 16:46:19',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => NULL,
                        'attachments' => NULL,
                        'created_date' => '2021-02-08 16:48:31',
                        'modified_date' => '2021-02-08 16:48:46',
                        'email_type' => 'reply',
                        'source' => 'inbox',
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UkU6IFJlZzpbdGVzdCBzY3JlZW5zaG90IGltYWdlc10=',
                        'message_start' => 'DQoNCiZuYnNwOw0KUmVnYXJkcw0KUmVwbHkgZW1haWwNCg0KRnJvbTogcmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbVNlbnQ6IDIwMjEtMDItMDggMTY6NDQ6MTBUbzogcg==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                    ],
                    11 => [
                        'latest_modified_date' => '2021-02-08 16:42:00',
                        'id' => '2075',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '',
                        'email_messageid' => NULL,
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2021-02-08 16:42:00',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => NULL,
                        'attachments' => NULL,
                        'created_date' => '2021-02-08 16:44:10',
                        'modified_date' => '2021-02-08 16:44:27',
                        'email_type' => 'reply',
                        'source' => 'inbox',
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UkU6IFJlZzpbdGVzdCBzY3JlZW5zaG90IGltYWdlc10=',
                        'message_start' => 'DQoNCiZuYnNwOw0KUmVnYXJkcw0KUmVwbHkgZW1haWwNCg0KRnJvbTogcmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbVNlbnQ6IDIwMjEtMDItMDggMTY6NDI6MjFUbzogbg==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                    ],
                    12 => [
                        'latest_modified_date' => '2021-02-08 16:40:07',
                        'id' => '2074',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '',
                        'email_messageid' => '',
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'bi5zdXJlc2hrdW1hckBzcGktZ2xvYmFsLmNvbQ==',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2021-02-08 16:40:07',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => NULL,
                        'attachments' => NULL,
                        'created_date' => '2021-02-08 16:42:21',
                        'modified_date' => '2021-02-08 16:44:11',
                        'email_type' => 'new',
                        'source' => 'inbox',
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UmVnOlt0ZXN0IHNjcmVlbnNob3QgaW1hZ2VzXQ==',
                        'message_start' => '',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                    ],
                    13 => [
                        'latest_modified_date' => '2021-01-12 17:05:03',
                        'id' => '2056',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '',
                        'email_messageid' => '',
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'YS5hbmFudGhhcmFqYUBzcGktZ2xvYmFsLmNvbQ==',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2021-01-12 17:05:03',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => NULL,
                        'attachments' => NULL,
                        'created_date' => '2021-01-12 17:06:32',
                        'modified_date' => '2021-01-12 17:06:41',
                        'email_type' => 'new',
                        'source' => 'inbox',
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UmVnOltTdGFydCBhbmQgZW5kIHRpbWUgY2hlY2td',
                        'message_start' => 'SGkgQW5hbmQsDQombmJzcDsNClRoaXMgaXMgc3RhcnQgYW5kIGVuZCB0aW1lIGNoZWNrDQombmJzcDsNClRoYW5rcw==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                    ],
                    14 => [
                        'latest_modified_date' => '2020-12-24 18:17:58',
                        'id' => '2027',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '7418bdf2-a800-4a12-9d95-be76c117b2b0',
                        'email_messageid' => NULL,
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'U3VyZXNoa3VtYXIsIE5hbWFjaGl2YXlhbSA8Ti5TdXJlc2hrdW1hckBzcGktZ2xvYmFsLmNvbT4=',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2020-12-24 18:17:58',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => '\\\\172.24.134.26\\TSG\\Technology\\RAD\\TechUtilities\\PMBot\\emails\\dev\\RADDEVELOPERS@SPI-GLOBAL.COM\\2020\\12\\24\\7418bdf2-a800-4a12-9d95-be76c117b2b0\\',
                        'attachments' => NULL,
                        'created_date' => '2020-12-24 18:18:50',
                        'modified_date' => '2020-12-24 18:19:01',
                        'email_type' => 'reply',
                        'source' => NULL,
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UkU6IFJFRzpbTGlzdCBUZXN0XQ==',
                        'message_start' => 'SGkgc3VyZXNoLA0KUGxlYXNlIGNoZWNrIHRoaXMNCg0KJm5ic3A7DQpSZWdhcmRzDQpSZXBseSBlbWFpbA0KDQpGcm9tOiAiU3VyZXNoa3VtYXIsIE5hbWFjaGl2YXlhbSIgJg==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                    ],
                    15 => [
                        'latest_modified_date' => '2020-12-24 18:16:33',
                        'id' => '2026',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '7418bdf2-a800-4a12-9d95-be76c117b2b0',
                        'email_messageid' => NULL,
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'U3VyZXNoa3VtYXIsIE5hbWFjaGl2YXlhbSA8Ti5TdXJlc2hrdW1hckBzcGktZ2xvYmFsLmNvbT4=',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2020-12-24 18:16:33',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => '\\\\172.24.134.26\\TSG\\Technology\\RAD\\TechUtilities\\PMBot\\emails\\dev\\RADDEVELOPERS@SPI-GLOBAL.COM\\2020\\12\\24\\7418bdf2-a800-4a12-9d95-be76c117b2b0\\',
                        'attachments' => NULL,
                        'created_date' => '2020-12-24 18:17:22',
                        'modified_date' => '2020-12-24 18:17:37',
                        'email_type' => 'reply',
                        'source' => NULL,
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UkU6IFJFRzpbTGlzdCBUZXN0XQ==',
                        'message_start' => 'Jm5ic3A7DQpIaSBTdXJlc2gsDQombmJzcDsNCkNoZWNrIHRoaXMNCiZuYnNwOw0KDQpSZWdhcmRzDQpSZXBseSBlbWFpbA0KDQpGcm9tOiAiU3VyZXNoa3VtYXIsIE5hbWFjaA==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                    ],
                    16 => [
                        'latest_modified_date' => '2020-12-21 12:13:49',
                        'id' => '2006',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '',
                        'email_messageid' => '',
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'bi5zdXJlc2hrdW1hckBzcGktZ2xvYmFsLmNvbQ==',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2020-12-21 12:13:49',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => NULL,
                        'attachments' => NULL,
                        'created_date' => '2020-12-21 11:36:09',
                        'modified_date' => '2020-12-21 12:14:47',
                        'email_type' => 'new',
                        'source' => 'inbox',
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UmVnOlt0ZXN0IGxpbmtd',
                        'message_start' => 'SGkgU3VyZXNoLA0KJm5ic3A7DQpQbGVhc2UgZmluZCB0aGUgYmVsb3cgbGluaw0KJm5ic3A7DQpcXDE3Mi4yNC4xMzYuNDFcSGVfT1VQXDAxX0xPR0lTVElDU1xSZWNlaXB0cw==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                    ],
                    17 => [
                        'latest_modified_date' => '2020-12-14 17:55:35',
                        'id' => '1998',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '',
                        'email_messageid' => NULL,
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'bi5zdXJlc2hrdW1hckBzcGktZ2xvYmFsLmNvbQ==',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2020-12-14 17:55:35',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => 'DEVELOP52\\RADDEVELOPERS@SPI-GLOBAL.COM\\2020\\12\\14\\2020-12-14-051257-38gx45jf\\',
                        'email_path_primary' => NULL,
                        'attachments' => NULL,
                        'created_date' => '2020-12-14 17:55:57',
                        'modified_date' => '2020-12-14 17:56:21',
                        'email_type' => 'forward',
                        'source' => 'inbox',
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'Rlc6IFJlZzpbdGVzdF0=',
                        'message_start' => 'Jm5ic3A7DQoNCiZuYnNwOw0KUmVnYXJkcw0KUmVwbHkgZW1haWwNCg0KRnJvbTogcmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbVNlbnQ6IDIwMjAtMTItMTQgMTc6NDg6Mw==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                        'reviewed' => '1',
                    ],
                    18 => [
                        'latest_modified_date' => '2020-12-14 17:50:46',
                        'id' => '1997',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '',
                        'email_messageid' => NULL,
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'bi5zdXJlc2hrdW1hckBzcGktZ2xvYmFsLmNvbQ==',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2020-12-14 17:50:46',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => 'DEVELOP52\\RADDEVELOPERS@SPI-GLOBAL.COM\\2020\\12\\14\\2020-12-14-051219-esz6ltfp\\',
                        'email_path_primary' => NULL,
                        'attachments' => NULL,
                        'created_date' => '2020-12-14 17:51:19',
                        'modified_date' => '2020-12-14 17:51:31',
                        'email_type' => 'forward',
                        'source' => 'inbox',
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'Rlc6IFJlZzpbdGVzdF0=',
                        'message_start' => 'Jm5ic3A7DQoNCiZuYnNwOw0KUmVnYXJkcw0KUmVwbHkgZW1haWwNCg0KRnJvbTogcmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbVNlbnQ6IDIwMjAtMTItMTQgMTc6NDg6Mw==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                    ],
                    19 => [
                        'latest_modified_date' => '2020-12-14 17:48:02',
                        'id' => '1996',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '',
                        'email_messageid' => '',
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'ay5yYWphcmV0aGluYW1Ac3BpLWdsb2JhbC5jb20=',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2020-12-14 17:48:02',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => NULL,
                        'attachments' => NULL,
                        'created_date' => '2020-12-14 17:48:36',
                        'modified_date' => '2020-12-14 17:51:19',
                        'email_type' => 'new',
                        'source' => 'inbox',
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UmVnOlt0ZXN0XQ==',
                        'message_start' => 'SGkgUmFqYSwNCiZuYnNwOw0KUGxlYXNlIGZpbmQgdGhlIGJlbG93DQoNCm9uZQ0KdHdvDQoNCg0KDQoNCm9uZQ0KdHdvDQoNCg0KDQombmJzcDsNClRoYW5rcywNClJBRGRpdg==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                    ],
                    20 => [
                        'latest_modified_date' => '2020-12-14 17:43:06',
                        'id' => '1995',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '',
                        'email_messageid' => '',
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'bi5zdXJlc2hrdW1hckBzcGktZ2xvYmFsLmNvbQ==',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2020-12-14 17:43:06',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => NULL,
                        'attachments' => NULL,
                        'created_date' => '2020-12-14 17:43:43',
                        'modified_date' => '2020-12-14 17:43:51',
                        'email_type' => 'new',
                        'source' => 'inbox',
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UmVnOlt0ZXN0XQ==',
                        'message_start' => 'SGkgU3VyZXNoLA0KDQoNCg0KRm9udA0KQm9yZGVyDQoNCg0KDQombmJzcDsNClRoYW5rcywNClJBRGRpdiB7IGZvbnQtc2l6ZTogMTEuMHB0OyBmb250LWZhbWlseTogQ2FsaQ==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                    ],
                    21 => [
                        'latest_modified_date' => '2020-12-14 17:35:45',
                        'id' => '1994',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '',
                        'email_messageid' => '',
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'bi5zdXJlc2hrdW1hckBzcGktZ2xvYmFsLmNvbQ==',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2020-12-14 17:35:45',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => NULL,
                        'attachments' => NULL,
                        'created_date' => '2020-12-14 17:36:23',
                        'modified_date' => '2020-12-14 17:36:30',
                        'email_type' => 'new',
                        'source' => 'inbox',
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UmVnOlt0ZXN0XQ==',
                        'message_start' => 'SGkgU3VyZXNoLA0KDQoNCg0Kb25lDQp0d28NCg0KDQoNCiZuYnNwOw0KVGhhbmtzLA0KUkFEZGl2IHsgZm9udC1zaXplOiAxMS4wcHQ7IGZvbnQtZmFtaWx5OiBDYWxpYnJpOw==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                    ],
                    22 => [
                        'latest_modified_date' => '2020-12-14 17:19:00',
                        'id' => '1993',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '',
                        'email_messageid' => '',
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'bi5zdXJlc2hrdW1hckBzcGktZ2xvYmFsLmNvbQ==',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2020-12-14 17:19:00',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => NULL,
                        'attachments' => NULL,
                        'created_date' => '2020-12-14 17:19:36',
                        'modified_date' => '2020-12-14 17:19:46',
                        'email_type' => 'new',
                        'source' => 'inbox',
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UmVnOlt0ZXN0XQ==',
                        'message_start' => 'ZGl2IHsgZm9udC1zaXplOiAxMS4wcHQ7IGZvbnQtZmFtaWx5OiBDYWxpYnJpOyBjb2xvcjogIzFmNDk3ZDsgfSBwIHsgZm9udC1zaXplOiAxMS4wcHQ7IGZvbnQtZmFtaWx5Og==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                    ],
                    23 => [
                        'latest_modified_date' => '2020-12-14 17:10:34',
                        'id' => '1992',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '',
                        'email_messageid' => '',
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'bi5zdXJlc2hrdW1hckBzcGktZ2xvYmFsLmNvbQ==',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2020-12-14 17:10:34',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => NULL,
                        'attachments' => NULL,
                        'created_date' => '2020-12-14 17:11:10',
                        'modified_date' => '2020-12-14 17:11:20',
                        'email_type' => 'new',
                        'source' => 'inbox',
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UmVnOlt0ZXN0XQ==',
                        'message_start' => 'Ym9keSB7IGZvbnQtc2l6ZTogMTEuMHB0OyBmb250LWZhbWlseTogQ2FsaWJyaTsgY29sb3I6ICMxZjQ5N2Q7IH0gcCB7IG1hcmdpbjogMGluOyBtYXJnaW4tYm90dG9tOiAuMA==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                    ],
                    24 => [
                        'latest_modified_date' => '2020-12-14 17:03:20',
                        'id' => '1991',
                        'email_id' => 'raddevelopers@spi-global.com',
                        'empname' => 'raddevelopers@spi-global.com',
                        'empcode' => 'raddevelopers@spi-global.com',
                        'job_id' => NULL,
                        'email_guid' => '',
                        'email_messageid' => '',
                        'status' => '6',
                        'email_from' => 'cmFkZGV2ZWxvcGVyc0BzcGktZ2xvYmFsLmNvbQ==',
                        'email_to' => 'bi5zdXJlc2hrdW1hckBzcGktZ2xvYmFsLmNvbQ==',
                        'email_cc' => '',
                        'email_bcc' => '',
                        'email_received_date' => NULL,
                        'email_sent_date' => '2020-12-14 17:03:20',
                        'priority' => '3',
                        'score' => NULL,
                        'email_path' => NULL,
                        'email_path_primary' => NULL,
                        'attachments' => NULL,
                        'created_date' => '2020-12-14 17:03:56',
                        'modified_date' => '2020-12-14 17:04:05',
                        'email_type' => 'new',
                        'source' => 'inbox',
                        'type' => 'non_pmbot',
                        'associate' => '0',
                        'subject' => 'UmVnOlt0ZXN0XQ==',
                        'message_start' => 'aHRtbCB7IGJvZHkgeyBmb250LXNpemU6IDExLjBwdDsgZm9udC1mYW1pbHk6IENhbGlicmk7IGNvbG9yOiAjMWY0OTdkOyB9IHAgeyBtYXJnaW46IDBpbjsgbWFyZ2luLWJvdA==',
                        'view' => '1',
                        'body_text' => '',
                        'body_html' => '',
                        'email_classification_category' => NULL,
                        'creator_empname' => '',
                    ],
                ],
                'last_updated' => '2020-12-11 17:27:14',
                'result_count' => '175',
                'unread_count' => '40',
            ]; */

            if ($returnResponseData["success"] == "true") {

                $returnResponse["success"] = "true";

                if (is_array($returnResponseData["data"]) && count($returnResponseData["data"]) > 0 && $returnResponseData["data"] != "") {

                    $responseGroupedData = $returnResponseData["data"];

                    if (isset($field["email_type"]) && $field["email_type"] == "email-review") {

                        $responseGroupedData = $this->formatSubjectGroupedData($returnResponseData["data"], $field);

                    }

                    $responseData = $this->formatData($responseGroupedData, $field);

                    if ($responseData) {

                        // $returnResponse["success"] = "true";

                        if (is_array($responseData) && count($responseData) > 0 && isset($responseData["reviewed_count"]) && $responseData["reviewed_count"] != "") {

                            $returnResponse["reviewed_count"] = $responseData["reviewed_count"];

                            unset($responseData["reviewed_count"]);

                        }

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

                            if (isset($field["email_type"]) && $field["email_type"] == "email-review") {

                                $returnResponse["result_count"] = count($responseData);

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

            if (isset($field['autosave']) && $field['autosave'] == "true") {

                $url = $this->emailAutoSaveSendApiUrl;

            }

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

                if (isset($field['autosave']) && $field['autosave'] == "true") {

                    $responseData["data"] = [];
                    $responseData["data"]["email_id"] = "200";

                    if (isset($responseData["data"]) && $responseData["data"] != '') {

                        $returnResponse["data"] = $responseData["data"];

                    }

                }


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

            if(isset($field["type"]) && $field["type"] != "") {

                if($field["type"] == "email-review") {

                    $url = $this->reviewEmailGetApiUrl;

                    if (isset($field["view"]) ) {

                        unset($field["view"]);

                    }

                }

                unset($field["type"]);

            }

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

                    if (isset($returnResponse["data"]["parent_email_received_date"]) && $returnResponse["data"]["parent_email_received_date"] != "" &&isset($returnResponse["data"]["email_sent_date"]) && $returnResponse["data"]["email_sent_date"] != "") {

                        $emailReplySpeedInHours = '';

                        $emailReplySpeedRating = '';

                        $emailReplySpeedInHours = $this->dateTimeDifferenceInHours($returnResponse["data"]["parent_email_received_date"], $returnResponse["data"]["email_sent_date"]);

                        if ($emailReplySpeedInHours != "") {

                            if($emailReplySpeedInHours < 24) {

                                $emailReplySpeedRating = '3';

                            }

                            if ($emailReplySpeedInHours <= 24 && $emailReplySpeedInHours <= 48 ) {

                                $emailReplySpeedRating = '2';

                            }

                            if ($emailReplySpeedInHours > 48 ) {

                                $emailReplySpeedRating = '1';

                            }

                            if($emailReplySpeedInHours != '') {

                                if(isset($returnResponse["data"]["ratings"]) && is_array($returnResponse["data"]["ratings"]) && count($returnResponse["data"]["ratings"]) > 0) {

                                    if(isset($returnResponse["data"]["ratings"]['speed']) && $returnResponse["data"]["ratings"]['speed'] != '') {

                                        $returnResponse["data"]["ratings"]['speed'] = $emailReplySpeedRating;

                                    } else {

                                        $returnResponse["data"]["ratings"]['speed'] = $emailReplySpeedRating;

                                    }

                                } else {

                                    $returnResponse["data"]["ratings"] = [];
                                    $returnResponse["data"]["ratings"]['speed'] = $emailReplySpeedRating;

                                }

                            }

                        }

                    }


                   // if(isset($returnResponse["data"]["email_received_date"]) && $returnResponse["data"]["email_received_date"] != "") {

                        // $returnResponse["data"]["create_date_formatted_text"] = date("dd [.stndrh\t ]+ m ([ .\t-])* y h:i:s a", strtotime($returnResponse["data"]["email_received_date"]));
                        //$returnResponse["data"]["create_date_formatted_text"] = date("d/m/Y h:i:s a", strtotime($returnResponse["data"]["email_received_date"]));


						if ($emailDate){

							$returnResponse["data"]["create_date_text"] = $emailDate;
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

                    if (isset($returnResponse["data"]["email_classification_category"]) && $returnResponse["data"]["email_classification_category"] != "") {

                        if ($returnResponse["data"]["email_classification_category"] == null || $returnResponse["data"]["email_classification_category"] == '' || $returnResponse["data"]["email_classification_category"] == 'not_set' || $returnResponse["data"]["email_classification_category"] == 'neutral') {

                            $returnResponse["data"]["email_classification_category"] = "neutral";

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

                                $email_file_path .= $returnResponse["data"]["email_path_primary"] . urlencode($email_filename);

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

                                            $item_file .= $emailAttachmentPath . urlencode($item);
                                            $item_name = $item;

                                            $emailAttachmentHtml .= '<li class="mb-0">';
                                                $emailAttachmentHtml .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 email-attachment-item-block">';
                                                    $emailAttachmentHtml .= '<a href="';
                                                    $emailAttachmentHtml .= $item_file;
                                                    $emailAttachmentHtml .= '" title="';
                                                    $emailAttachmentHtml .= $item;
                                                    $emailAttachmentHtml .= '" class="atch-thumb">';
                                                        $emailAttachmentHtml .= '<span>';
                                                            $emailAttachmentHtml .= '<i class="font-30 mr-5 fa fa-';
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
                                                            $emailForwardAttachmentList .= '<i class="font-30 mr-5 fa fa-';
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

                    // if(is_array(Config::get('constants.emailClassificationMoveToList')) && count(Config::get('constants.emailClassificationMoveToList'))) {

                    //     $returnResponse["data"]["classification_list"] = Config::get('constants.emailClassificationMoveToList');

                    // }

                    if (is_array(Config::get('constants.emailClassificationList')) && count(Config::get('constants.emailClassificationList'))) {

                        $returnResponse["data"]["classification_list"] = Config::get('constants.emailClassificationList');

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

            if (isset($field['autosave']) && $field['autosave'] == "true") {

                $url = $this->emailAutoSaveSendApiUrl;

            }

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

                if (isset($field['autosave']) && $field['autosave'] == "true") {

                    if (isset($responseData["data"]) && $responseData["data"] != '') {

                        $returnResponse["data"] = $responseData["data"];

                    }

                }

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

    public function formatSubjectGroupedData($items, $field)
    {
        $resource = $groupedResource = [];

        array_walk($items, function ($item) use (&$groupedResource) {

                try {


                    if(isset($item["subject"]) && $item["subject"] != "") {

                        $groupedResource[$item["subject"]][] = $item;

                    }

                } catch (Exception $e) {

                    $this->error(
                        "app_error_log_" . date('Y-m-d'),
                        " => FILE => " . __FILE__ . " => " .
                            " => LINE => " . __LINE__ . " => " .
                            " => MESSAGE => " . $e->getMessage() . " "
                    );
                }

            }

        );

        array_walk($groupedResource, function ($item, $key) use (&$resource) {

                try {

                    if(is_array($item)) {

                        if (count($item) == 1) {

                            array_push($resource, $item[0]);

                        }

                        if (count($item) > 1) {

                            usort($item, function ($a, $b) {

                                if (isset($a['email_sent_date']) && isset($b['email_sent_date'])) {

                                    $t1 = strtotime($a['email_sent_date']);
                                    $t2 = strtotime($b['email_sent_date']);

                                    // return $t1 - $t2;
                                    return $t2 - $t1;
                                }

                            });

                            // $groupedResource[$key] = $item[0];

                            array_push($resource, $item[0]);

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

            }

        );

        if(is_array($resource) && count($resource) > 0) {

            usort($resource, function ($a, $b) use($field) {

                if (isset($a['email_sent_date']) && isset($b['email_sent_date'])) {

                    $t1 = strtotime($a['email_sent_date']);
                    $t2 = strtotime($b['email_sent_date']);

                    if(isset($field["sort_type"]) && $field["sort_type"] == "oldest"){

                        return $t1 - $t2;

                    } else {

                        return $t2 - $t1;

                    }

                }

            });

            if (isset($field["sort_type"]) && $field["sort_type"] == "random") {

                shuffle($resource);

            }

            if(isset($field["sort_limit"]) && $field["sort_limit"] != '' && count($resource) > (int)$field["sort_limit"]) {

                $resource = array_slice($resource, 0, (int)$field["sort_limit"]);

            }

        }

        return $resource;

    }

    public function formatData($items, $field)
    {
        $reviewed_count = 0;

        $resource = array_map(

            function ($item) use ($field, &$reviewed_count) {

                try {

                    $emailTypeClass = $email_category = "";
                    $emailSubject = "no subject";
                    $emailGetUrl = route(__("job.email_get_url"));

                    if (isset($field["email_type"]) && $field["email_type"] != "") {

                        $email_category = $field["email_type"];

                    }

                    $item["is_priority"] = "";

                    if (isset($item["priority"]) && $item["priority"] == "1") {

                        $item["is_priority"] = '<i class="fa fa-exclamation inline-block txt-danger font-16"></i>';

                    }

                    $item["is_attachments"] = "";

                    if (isset($item["attachments"]) && $item["attachments"] != "") {

                        $item["is_attachments"] = '<i class="zmdi zmdi-attachment inline-block font-16"></i>';
                    }

                    if (isset($item["reviewed"]) && $item["reviewed"] == "1") {

                        $reviewed_count = $reviewed_count + 1;

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

                        // if (in_array(auth()->user()->role, config('constants.qcUserRoles'))) {

                        //     $emailTypeClass = "";

                        // }

						//Bharathi changed as per Balaji's new format 10 May 2020
						/* if (isset($item["empcode"]) &&  $item["empcode"] != "") {

                        //    $emailViewUrl = $emailViewUrl . "&empcode=" . $item["empcode"];
                            $emailViewUrl = $emailViewUrl . "/empcode/" . $item["empcode"];
                        } */

                         $item['subject_link'] = '<a class="email-item ' . $emailTypeClass . '" href="' . $emailViewUrl . '" data-email-id="' . $item["id"] . '" data-email-category="' . $email_category . '" data-email-geturl="' . $emailGetUrl . '">' . mb_strimwidth($emailSubject, 0, 75, "...") . '</a>';
                         $item["subject_min_width"] = mb_strimwidth($emailSubject, 0, 75, "...");
                    }

                    if (isset($item["email_path_primary"]) && $item["email_path_primary"] != "") {

                        $email_filename = "email.eml";

                        $file_name_split = pathinfo($email_filename);

                        if (is_array($file_name_split) && count($file_name_split) > 0) {

                            if (isset($file_name_split["extension"]) && $file_name_split["extension"] != "") {

                                $email_file_base_name = $file_name_split["filename"];

                                if (isset($item["subject"]) && $item["subject"] != "") {

                                    $email_file_base_name = $item["subject"];
                                    $email_file_base_name = preg_replace('/[^A-Za-z0-9. _]/', '', $email_file_base_name);
                                    $email_file_base_name = preg_replace('/\\s+/', '_', $email_file_base_name);
                                    $email_file_base_name = strtolower(mb_strimwidth($email_file_base_name, 0, 50));
                                }

                                $email_file_path = route('file') . Config::get('constants.emailImageDownloadPathParams');

                                $email_file_path .= $item["email_path_primary"] . urlencode($email_filename);

                                $alais_filename = $email_file_base_name . "." . $file_name_split["extension"];

                                $email_file_path .= "&alais_name=" . $alais_filename;

                                $item["email_download_path"] = $email_file_path;

                            }
                        }
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

        if($reviewed_count > 0) {

            $resource["reviewed_count"] = $reviewed_count;

        }

        return $resource;

    }

    public function pmsEmailCountFormatData($items)
    {
        $resource = array_map(

            function ($item) {

                try {

                    $item["negative_count_link"] = "0";
                    $item["alarming_count_link"] = "0";
                    $item["escalation_count_link"] = "0";

                    if(isset($item["last_processed_time"]) && $item["last_processed_time"] != "") {

                        $item["last_processed_time"] = date("Y/m/d H:i:s", strtotime($item["last_processed_time"]));

                    }

                    if (isset($item["last_annotated_time"]) && $item["last_annotated_time"] != "") {

                        $item["last_annotated_time"] = date("Y/m/d H:i:s", strtotime($item["last_annotated_time"]));
                    }

                    if (isset($item["negative_count"]) && $item["negative_count"] != ""&& $item["negative_count"] != "0") {

                        $item["negative_count_link"] = '<a class="dashboard-email-sent-count-btn" href="#QCEmailModal" data-toggle="modal" data-grid-selector="emailQCCountGrid" data-grid-title="Potentially alarming email" data-count="' . $item["negative_count"]. '" data-email-filter="potentially_alarming" data-empcode="' . $item["empcode"] . '"><span class="txt-danger underlined">' . $item["negative_count"] . '</span></a>';
                        // $item["negative_count_link"] = $item["negative_count"];

                    }

                    if (isset($item["alarming_email_count"]) && $item["alarming_email_count"] != "" && $item["alarming_email_count"] != "0") {

                        $item["alarming_count_link"] = '<a class="dashboard-email-sent-count-btn" href="#QCEmailModal" data-toggle="modal" data-grid-selector="emailQCCountGrid" data-grid-title="Alarming email" data-count="' . $item["alarming_email_count"] . '" data-email-filter="alarming" data-empcode="' . $item["empcode"] . '"><span class="txt-danger underlined">' . $item["alarming_email_count"] . '</span></a>';

                    }

                    if (isset($item["escalation_count"]) && $item["escalation_count"] != "" && $item["escalation_count"] != "0") {

                        // $item["escalation_count_link"] = $item["escalation_count"];
                        $item["escalation_count_link"] = '<a class="dashboard-email-sent-count-btn" href="#QCEmailModal" data-toggle="modal" data-grid-selector="emailQCCountGrid" data-grid-title="Escalation email" data-count="' . $item["escalation_count"] . '" data-email-filter="escalation" data-empcode="' . $item["empcode"] . '"><span class="txt-danger underlined">' . $item["escalation_count"] . '</span></a>';

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

    public function emailTemplatesFormatData($items)
    {
        $resource = array_map(

            function ($item) {

                try {

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

    public function emailMoveToLabelsFormatData($items)
    {
        $resource= [];
        array_walk($items,

            function ($item) use(&$resource) {

                try {

                    $resource[$item["id"]] = $item["label_name"];

                } catch (Exception $e) {

                    $this->error(
                        "app_error_log_" . date('Y-m-d'),
                        " => FILE => " . __FILE__ . " => " .
                        " => LINE => " . __LINE__ . " => " .
                        " => MESSAGE => " . $e->getMessage() . " "
                    );
                }
            }
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
