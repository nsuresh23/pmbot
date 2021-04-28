<?php

namespace App\Resources\Report;

use DateTime;

use Exception;

use DateTimeZone;

use League\Fractal\Manager;

use App\Traits\General\Helper;

use App\Traits\General\ApiClient;

use App\Traits\General\CustomLogger;

use Illuminate\Support\Facades\Config;

use League\Fractal\Resource\Collection;

use Illuminate\Support\Facades\Validator;

use phpDocumentor\Reflection\Types\Boolean;

class ReportCollection
{

    use Helper;

    use ApiClient;

    use CustomLogger;

    protected $fractal;
    protected $summaryReportApiUrl;
    protected $receivedEmailReportApiUrl;
    protected $sentEmailReportApiUrl;
    protected $classifiedEmailReportApiUrl;
    protected $externalEmailReportApiUrl;
    protected $reviewedEmailReportApiUrl;

    public function __construct()
    {

        $this->fractal = new Manager();
        $this->summaryReportApiUrl = env('API_SUMMARY_REPORT_LIST_URL');
        $this->receivedEmailReportApiUrl = env('API_RECEIVED_EMAIL_REPORT_LIST_URL');
        $this->sentEmailReportApiUrl = env('API_SENT_EMAIL_REPORT_LIST_URL');
        $this->classifiedEmailReportApiUrl = env('API_CLASSIFIED_EMAIL_REPORT_LIST_URL');
        $this->externalEmailReportApiUrl = env('API_EXTERNAL_EMAIL_REPORT_LIST_URL');
        $this->reviewedEmailReportApiUrl = env('API_REVIEWED_EMAIL_REPORT_LIST_URL');

    }

    /**
     * Get the list of summary report.
     *
     * @return array $returnData
     */
    public function summaryReport($params)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "message" => "",
        ];

        try {

            $paramInfo = [];

            $paramInfo = $params;

            $url = $this->summaryReportApiUrl;

            if(isset($paramInfo["category"]) && $paramInfo["category"] == "received_email"){

                $url = $this->receivedEmailReportApiUrl;

            }

            if (isset($paramInfo["category"]) && $paramInfo["category"] == "sent_email") {

                $url = $this->sentEmailReportApiUrl;

            }

            if (isset($paramInfo["category"]) && $paramInfo["category"] == "classified_email") {

                $url = $this->classifiedEmailReportApiUrl;

            }

            if (isset($paramInfo["category"]) && $paramInfo["category"] == "external_email") {

                $url = $this->externalEmailReportApiUrl;

            }

            if (isset($paramInfo["category"]) && $paramInfo["category"] == "reviewed_email") {

                $url = $this->reviewedEmailReportApiUrl;

            }

            $responseData = [];

            $responseData = $this->postRequest($url, $paramInfo);

            /* $responseData = [
                "success" => "true",
                "error_msg" => "",
                "data" => [
                    [
                    "empcode" => "d.gopinath2@spi-global.com",
                    "pmname" => "Gopinath, Durai",
                    "spi_empcode" => "304207",
                    "reviewed_count" => "5",
                    "issue_sum" => "9",
                    "responded_sum" => "7",
                    "language_sum" => "10",
                    "satisfaction_sum" => "11",
                    "emails_responded_count" => 56,
                    "average_response_time" => "16056:05:50"
                    ]
                ],
                "last_updated" => "",
                "result_count" => ""
                ]; */

            if ($responseData["success"] == "true" && is_array($responseData["data"]) && count($responseData["data"]) > 0 && $responseData["data"] != "") {

                $responseFormatData = [];

                if (isset($paramInfo["category"]) && $paramInfo["category"] != "") {

                    if ($paramInfo["category"] == "external_email") {

                        $responseFormattedData = $this->externalEmailReportFormatData($responseData["data"]["list"]);

                        if(is_array($responseFormattedData) && count($responseFormattedData) > 0) {

                            $responseFormatData["list"] = $responseFormattedData;

                            $responseFormatData["result_count"] = count($responseFormattedData);

                        }

                        if(isset($responseData["data"]["totallist"]) && is_array($responseData["data"]["totallist"]) && count($responseData["data"]["totallist"]) > 0) {

                            $responseFormatData["totallist"] = $responseData["data"]["totallist"];

                        }

                    }

                    if ($paramInfo["category"] == "reviewed_email") {

                        $responseFormatData = $this->reviewedEmailReportFormatData($responseData["data"], $paramInfo);

                        /* if(is_array($responseFormattedData) && count($responseFormattedData) > 0) {

                            $responseFormatData["list"] = $responseFormattedData;

                            $responseFormatData["result_count"] = count($responseFormattedData);

                        } */

                        // if(isset($responseData["data"]["totallist"]) && is_array($responseData["data"]["totallist"]) && count($responseData["data"]["totallist"]) > 0) {

                        //     $responseFormatData["totallist"] = $responseData["data"]["totallist"];

                        // }

                    }

                    if ($paramInfo["category"] != "external_email" && $paramInfo["category"] != "reviewed_email") {

                        $responseFormatData = $this->summaryReportFormatData($responseData["data"]);

                    }

                }

                if ($responseFormatData) {

                    if (isset($responseFormatData["result_count"]) && $responseFormatData["result_count"] != "") {

                        $returnResponse["recordsTotal"] = $responseFormatData["result_count"];

                        $returnResponse["recordsFiltered"] = $responseFormatData["result_count"];

                        unset($responseFormatData["result_count"]);

                    } else if (is_array($responseFormatData)) {

                        $returnResponse["recordsTotal"] = count($responseFormatData);

                        $returnResponse["recordsFiltered"] = count($responseFormatData);

                    }

                    $returnResponse["success"] = "true";

                    $returnResponse["data"] = $responseFormatData;
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

    public function summaryReportFormatData($items)
    {

        $s_no = 0;

        $resource = array_map(

            function ($item) use(&$s_no) {

                if(is_array($item) && count($item)) {

                    $s_no = $s_no + 1;

                    $item["s_no"] = $s_no;

                    $item["formatted_date"] = "-";

                    $item["formatted_first_login"] = "-";

                    $item["formatted_last_logout"] = "-";

                    $item["overall_time"] = "-";

                    $item["email_received_time_in_minutes"] = "-";

                    $item["email_received_title_time_in_minutes"] = "-";

                    $item["email_received_nonbusiness_time_in_minutes"] = "-";

                    $item["email_received_generic_time_in_minutes"] = "-";


                    $item["email_sent_time_in_minutes"] = "-";

                    $item["email_sent_title_time_in_minutes"] = "-";

                    $item["email_sent_nonbusiness_time_in_minutes"] = "-";

                    $item["email_sent_generic_time_in_minutes"] = "-";


                    $item["email_received_average_time_in_minutes"] = "-";

                    $item["email_received_title_average_time_in_minutes"] = "-";

                    $item["email_received_nonbusiness_average_time_in_minutes"] = "-";

                    $item["email_received_generic_average_time_in_minutes"] = "-";


                    $item["email_sent_average_time_in_minutes"] = "-";

                    $item["email_sent_title_average_time_in_minutes"] = "-";

                    $item["email_sent_nonbusiness_average_time_in_minutes"] = "-";

                    $item["email_sent_generic_average_time_in_minutes"] = "-";

                    if (isset($item["pmname"]) && $item["pmname"] != "") {

                        $item["pmname_link"] = '<a class="user-login-history-btn" href="#userLoginHistorModal" data-toggle="modal" data-grid-selector="user-login-history-grid" data-grid-title="Login history" data-date="' . $item["date"] . '" data-empcode="' . $item["empcode"] . '"><span class="txt-a-blue underlined">' . $item["pmname"] . '</span></a>';
                        // $item["pmname_link"] = '<a class="user-login-history-btn" href="#sentEmailModal" data-toggle="modal" data-grid-selector="emailSentCountGrid" data-grid-title="alarming email" data-count="10" data-email-filter="negative" data-empcode="' . $item["pmname"] . '"><span class="txt-danger underlined">10</span></a>';

                    }

                    if (isset($item["date"]) && $item["date"] != "") {

                        $item["formatted_date"] = date("Y/m/d", strtotime($item["date"]));

                    }

                    if (isset($item["first_login"]) && $item["first_login"] != "") {

                        $item["formatted_first_login"] = date("Y/m/d H:i:s", strtotime($item["first_login"]));

                    }

                    if (isset($item["last_logout"]) && $item["last_logout"] != "") {

                        $item["formatted_last_logout"] = date("Y/m/d H:i:s", strtotime($item["last_logout"]));;

                    }

                    if(isset($item["last_logout"]) && $item["last_logout"] != "" && isset($item["first_login"]) && $item["first_login"] != "") {

                        $minutes = $this->dateTimeDifferenceInMinutes($item["first_login"], $item["last_logout"]);

                        if($minutes != "") {

                            $item["overall_time"] = $minutes;

                        }

                    }

                    if(isset($item["email_received_time"]) && $item["email_received_time"] != "" && $item["email_received_time"] != "0") {

                        $emailReceivedTimeInMinutes = $this->secondsToMinutes($item["email_received_time"]);

                        if($emailReceivedTimeInMinutes != "") {

                            $item["email_received_time_in_minutes"] = $emailReceivedTimeInMinutes;

                        }

                    }

                    if(isset($item["email_sent_time"]) && $item["email_sent_time"] != "" && $item["email_sent_time"] != "0") {

                        $emailSentTimeInMinutes = $this->secondsToMinutes($item["email_sent_time"]);

                        if($emailSentTimeInMinutes != "") {

                            $item["email_sent_time_in_minutes"] = $emailSentTimeInMinutes;

                        }

                    }

                    if(isset($item["receive_title_time"]) && $item["receive_title_time"] !="" && $item["receive_title_time"] != "0") {

                        $emailReceivedTitleTimeInMinutes = $this->secondsToMinutes($item["receive_title_time"]);

                        if($emailReceivedTitleTimeInMinutes != "") {

                            $item["email_received_title_time_in_minutes"] = $emailReceivedTitleTimeInMinutes;

                        }

                    }

                    if(isset($item["receive_nonbusiness_time"]) && $item["receive_nonbusiness_time"] != "" && $item["receive_nonbusiness_time"] != "0") {

                        $emailReceivedNonbusinessTimeInMinutes = $this->secondsToMinutes($item["receive_nonbusiness_time"]);

                        if($emailReceivedNonbusinessTimeInMinutes != "") {

                            $item["email_received_nonbusiness_time_in_minutes"] = $emailReceivedNonbusinessTimeInMinutes;

                        }

                    }

                    if(isset($item["receive_generic_time"]) && $item["receive_generic_time"] != "" && $item["receive_generic_time"] != "0") {

                        $emailReceivedGenericTimeInMinutes = $this->secondsToMinutes($item["receive_generic_time"]);

                        if($emailReceivedGenericTimeInMinutes != "") {

                            $item["email_received_generic_time_in_minutes"] = $emailReceivedGenericTimeInMinutes;

                        }

                    }

                    if (isset($item["sent_title_time"]) && $item["sent_title_time"] != "" && $item["sent_title_time"] != "0") {

                        $emailSentTitleTimeInMinutes = $this->secondsToMinutes($item["sent_title_time"]);

                        if ($emailSentTitleTimeInMinutes != "") {

                            $item["email_sent_title_time_in_minutes"] = $emailSentTitleTimeInMinutes;
                        }
                    }

                    if (isset($item["sent_nonbusiness_time"]) && $item["sent_nonbusiness_time"] != "" && $item["sent_nonbusiness_time"] != "0") {

                        $emailSentNonbusinessTimeInMinutes = $this->secondsToMinutes($item["sent_nonbusiness_time"]);

                        if ($emailSentNonbusinessTimeInMinutes != "") {

                            $item["email_sent_nonbusiness_time_in_minutes"] = $emailSentNonbusinessTimeInMinutes;
                        }
                    }

                    if (isset($item["sent_generic_time"]) && $item["sent_generic_time"] != "" && $item["sent_generic_time"] != "0") {

                        $emailSentGenericTimeInMinutes = $this->secondsToMinutes($item["sent_generic_time"]);

                        if ($emailSentGenericTimeInMinutes != "") {

                            $item["email_sent_generic_time_in_minutes"] = $emailSentGenericTimeInMinutes;
                        }
                    }

                    if (isset($item["email_received_time"]) && $item["email_received_time"] != "" && $item["email_received_time"] != "0" && isset($item["email_received_count"]) && $item["email_received_count"] != "" && $item["email_received_count"] != "0") {

                        $emailReceivedAverageTime = (int)$item["email_received_time"] / (int)$item["email_received_count"];

                        $emailReceivedAverageTimeInMinutes = $this->secondsToMinutes($emailReceivedAverageTime);

                        if ($emailReceivedAverageTimeInMinutes != "") {

                            $item["email_received_average_time_in_minutes"] = $emailReceivedAverageTimeInMinutes;

                        }

                    }

                    if (isset($item["email_sent_time"]) && $item["email_sent_time"] !="" && $item["email_sent_time"] != "0" && isset($item["email_sent_count"]) && $item["email_sent_count"] != "" && $item["email_sent_count"] != "0") {

                        $emailSentAverageTime = (int)$item["email_sent_time"]/(int)$item["email_sent_count"];

                        $emailSentAverageTimeInMinutes = $this->secondsToMinutes($emailSentAverageTime);

                        if ($emailSentAverageTimeInMinutes != "") {

                            $item["email_sent_average_time_in_minutes"] = $emailSentAverageTimeInMinutes;

                        }

                    }

                    if (isset($item["receive_title_time"]) && $item["receive_title_time"] != "" && $item["receive_title_time"] != "0" && isset($item["receive_title_count"]) && $item["receive_title_count"] != "" && $item["receive_title_count"] != "0") {

                        $emailReceivedTitleAverageTime = (int)$item["receive_title_time"] / (int)$item["receive_title_count"];

                        $emailReceivedTitleAverageTimeInMinutes = $this->secondsToMinutes($emailReceivedTitleAverageTime);

                        if ($emailReceivedTitleAverageTimeInMinutes != "") {

                            $item["email_received_title_average_time_in_minutes"] = $emailReceivedTitleAverageTimeInMinutes;

                        }

                    }

                    if (isset($item["receive_nonbusiness_time"]) && $item["receive_nonbusiness_time"] != "" && $item["receive_nonbusiness_time"] != "0" && isset($item["receive_nonbusiness_count"]) && $item["receive_nonbusiness_count"] != "" && $item["receive_nonbusiness_count"] != "0") {

                        $emailReceivedNonbusinessAverageTime = (int)$item["receive_nonbusiness_time"] / (int)$item["receive_nonbusiness_count"];

                        $emailReceivedNonbusinessAverageTimeInMinutes = $this->secondsToMinutes($emailReceivedNonbusinessAverageTime);

                        if ($emailReceivedNonbusinessAverageTimeInMinutes != "") {

                            $item["email_received_nonbusiness_average_time_in_minutes"] = $emailReceivedNonbusinessAverageTimeInMinutes;

                        }

                    }

                    if (isset($item["receive_generic_time"]) && $item["receive_generic_time"] != "" && $item["receive_generic_time"] != "0" && isset($item["receive_generic_count"]) && $item["receive_generic_count"] != "" && $item["receive_generic_count"] != "0") {

                        $emailReceivedGenericAverageTime = (int)$item["receive_generic_time"] / (int)$item["receive_generic_count"];

                        $emailReceivedGenericAverageTimeInMinutes = $this->secondsToMinutes($emailReceivedGenericAverageTime);

                        if ($emailReceivedGenericAverageTimeInMinutes != "") {

                            $item["email_received_generic_average_time_in_minutes"] = $emailReceivedGenericAverageTimeInMinutes;

                        }

                    }

                    if (isset($item["sent_title_time"]) && $item["sent_title_time"] != "" && $item["sent_title_time"] != "0" && isset($item["sent_title_count"]) && $item["sent_title_count"] != "" && $item["sent_title_count"] != "0") {

                        $emailSentTitleAverageTime = (int)$item["sent_title_time"] / (int)$item["sent_title_count"];

                        $emailSentTitleAverageTimeInMinutes = $this->secondsToMinutes($emailSentTitleAverageTime);

                        if ($emailSentTitleAverageTimeInMinutes != "") {

                            $item["email_sent_title_average_time_in_minutes"] = $emailSentTitleAverageTimeInMinutes;
                        }
                    }

                    if (isset($item["sent_nonbusiness_time"]) && $item["sent_nonbusiness_time"] != "" && $item["sent_nonbusiness_time"] != "0" && isset($item["sent_nonbusiness_count"]) && $item["sent_nonbusiness_count"] != "" && $item["sent_nonbusiness_count"] != "0") {

                        $emailSentNonbusinessAverageTime = (int)$item["sent_nonbusiness_time"] / (int)$item["sent_nonbusiness_count"];

                        $emailSentNonbusinessAverageTimeInMinutes = $this->secondsToMinutes($emailSentNonbusinessAverageTime);

                        if ($emailSentNonbusinessAverageTimeInMinutes != "") {

                            $item["email_sent_nonbusiness_average_time_in_minutes"] = $emailSentNonbusinessAverageTimeInMinutes;
                        }
                    }

                    if (isset($item["sent_generic_time"]) && $item["sent_generic_time"] != "" && $item["sent_generic_time"] != "0" && isset($item["sent_generic_count"]) && $item["sent_generic_count"] != "" && $item["sent_generic_count"] != "0") {

                        $emailSentGenericAverageTime = (int)$item["sent_generic_time"] / (int)$item["sent_generic_count"];

                        $emailSentGenericAverageTimeInMinutes = $this->secondsToMinutes($emailSentGenericAverageTime);

                        if ($emailSentGenericAverageTimeInMinutes != "") {

                            $item["email_sent_generic_average_time_in_minutes"] = $emailSentGenericAverageTimeInMinutes;
                        }
                    }

                }

                return $item;

            },

            $items

        );

        return $resource;

    }

    public function externalEmailReportFormatData($items)
    {

        $s_no = 0;

        $resource = array_map(

            function ($item) use (&$s_no) {

                if (is_array($item) && count($item)) {

                    $s_no = $s_no + 1;

                    $item["s_no"] = $s_no;

					$item["formatted_date"] = "-";

                    $item["formatted_total_count"] = "";

                    $item["formatted_internal_count"] = "";

                    $item["formatted_external_count"] = "";

                    $item["formatted_not_set_count"] = "";

                    $item["formatted_positive_count"] = "";

                    $item["formatted_neutral_count"] = "";

                    $item["formatted_negative_count"] = "";

                    $item["formatted_emails_responded_count"] = "";

                    $item["formatted_average_response_time"] = "";

                    if (isset($item["pmname"]) && $item["pmname"] != "") {

                        $item["pmname_link"] = $item["pmname"];
                        // $item["pmname_link"] = '<a class="user-login-history-btn" href="#userLoginHistorModal" data-toggle="modal" data-grid-selector="user-login-history-grid" data-grid-title="Login history" data-date="' . $item["date"] . '" data-empcode="' . $item["empcode"] . '"><span class="txt-a-blue underlined">' . $item["pmname"] . '</span></a>';

                    }

					if (isset($item["date"]) && $item["date"] != "") {

                        $item["formatted_date"] = date("Y/m/d", strtotime($item["date"]));

                    }

                    if (isset($item["total_count"]) && $item["total_count"] != "") {

                        $item["formatted_total_count"] = $item["total_count"];

                    }

                    if (isset($item["internal_count"]) && $item["internal_count"] != "") {

                        $item["formatted_internal_count"] = $item["internal_count"];

                    }

                    if (isset($item["external_count"]) && $item["external_count"] != "") {

                        $item["formatted_external_count"] = $item["external_count"];

                    }

                    if (isset($item["not_set_count"]) && $item["not_set_count"] != "") {

                        $item["formatted_not_set_count"] = $item["not_set_count"];

                    }

                    if (isset($item["positive_count"]) && $item["positive_count"] != "") {

                        $item["formatted_positive_count"] = $item["positive_count"];

                    }

                    if (isset($item["neutral_count"]) && $item["neutral_count"] != "") {

                        $item["formatted_neutral_count"] = $item["neutral_count"];

                    }

                    if (isset($item["negative_count"]) && $item["negative_count"] != "") {

                        $item["formatted_negative_count"] = $item["negative_count"];

                    }

                    if (isset($item["emails_responded_count"]) && $item["emails_responded_count"] != "") {

                        $item["formatted_emails_responded_count"] = $item["emails_responded_count"];

                    }

                    if (isset($item["average_response_time"]) && $item["average_response_time"] != "") {

                        $item["formatted_average_response_time"] = $item["average_response_time"];

                    }

                }

                return $item;
            },

            $items

        );

        return $resource;
    }

    public function reviewedEmailReportFormatData($items, $paramInfo)
    {

        $s_no = 0;

        $resource = array_map(

            function ($item) use (&$s_no, $paramInfo) {

                if (is_array($item) && count($item)) {

                    $overall_average_sum = 0;

                    $s_no = $s_no + 1;

                    $item["s_no"] = $s_no;

					$item["formatted_date"] = "-";

                    $item["formatted_reviewed_count"] = "";

                    $item["formatted_issue_average"] = "";

                    $item["formatted_responded_average"] = "";

                    $item["formatted_language_average"] = "";

                    $item["formatted_satisfaction_average"] = "";

                    $item["formatted_overall_average"] = "";

                    $item["formatted_emails_responded_count"] = "";

                    $item["formatted_average_response_time"] = "";

                    if (isset($item["pmname"]) && $item["pmname"] != "") {

                        $item["pmname_link"] = $item["pmname"];

                    }

					if (isset($item["date"]) && $item["date"] != "") {

                        $item["formatted_date"] = date("Y/m/d", strtotime($item["date"]));

                    }

                    if (isset($item["reviewed_count"]) && $item["reviewed_count"] != "" && $item["reviewed_count"] != "0") {

                        $review_count_tag = '<a class="reviewed-report-mail-list" href="#reviewedEmailModal" data-toggle="modal" data-grid-selector="reviewed-email-grid" data-grid-title="Reviewed Email"';

                        if (isset($item["empcode"]) && $item["empcode"] != "") {

                            $review_count_tag .= ' data-empcode="' . $item["empcode"] . '"';

                        }

                        if (isset($paramInfo["filter"]) && is_array($paramInfo["filter"]) && count($paramInfo["filter"]) > 0) {

                            $dateRange = "";

                            if (isset($paramInfo["filter"]["fromdate"]) && $paramInfo["filter"]["fromdate"] != "") {

                                $fromDateSplitArray = explode(" ", $paramInfo["filter"]["fromdate"]);

                                if(is_array($fromDateSplitArray) && count($fromDateSplitArray) > 0) {

                                    $dateRange .= $fromDateSplitArray[0];

                                }

                                // $review_count_tag .= ' data-fromdate="' . $paramInfo["filter"]["fromdate"] . '"';

                            }

                            if (isset($paramInfo["filter"]["todate"]) && $paramInfo["filter"]["todate"] != "") {

                                $toDateSplitArray = explode(" ", $paramInfo["filter"]["todate"]);

                                if(is_array($toDateSplitArray) && count($toDateSplitArray) > 0) {

                                    $dateRange .= " to " . $toDateSplitArray[0];

                                }

                                // $review_count_tag .= ' data-todate="' . $paramInfo["filter"]["todate"] . '"';

                            }

                            if($dateRange != "") {

                                $review_count_tag .= ' data-range="' . $dateRange . '"';

                            }

                        }

                        $review_count_tag .= '>';
                        $review_count_tag .= '<span class="txt-a-blue underlined">';
                        $review_count_tag .= $item["reviewed_count"];
                        $review_count_tag .= '</span>';

                        $review_count_tag .= '</a>';


                        $item["formatted_reviewed_count"] = $review_count_tag;

                    }

                    if (isset($item["reviewed_count"]) && $item["reviewed_count"] != "" && $item["reviewed_count"] != "0") {

                        if (isset($item["issue_sum"]) && $item["issue_sum"] != "") {

                            // $item["formatted_issue_average"] = (string) round((int)$item["issue_sum"] / (int)$item["reviewed_count"], 2);

                            $item["formatted_issue_average"] = $this->getStarByValue(round((int)$item["issue_sum"] / (int)$item["reviewed_count"], 2), "star");

                            if (is_array(Config::get('constants.reviewed_email_field_%')) && count(Config::get('constants.reviewed_email_field_%')) > 0) {

                                $reviewedEmailFieldPercentage = Config::get('constants.reviewed_email_field_%');

                                if(isset($reviewedEmailFieldPercentage["issue"]) && $reviewedEmailFieldPercentage["issue"] != "") {

                                    $overall_average_sum += (int) $item["issue_sum"] * (float) $reviewedEmailFieldPercentage["issue"];

                                }

                            }

                        }

                        if (isset($item["responded_sum"]) && $item["responded_sum"] != "") {

                            // $item["formatted_responded_average"] = (string) round((int)$item["responded_sum"] / (int)$item["reviewed_count"], 2);

                            $item["formatted_responded_average"] = $this->getStarByValue(round((int)$item["responded_sum"] / (int)$item["reviewed_count"], 2), "star");

                            if (is_array(Config::get('constants.reviewed_email_field_%')) && count(Config::get('constants.reviewed_email_field_%')) > 0) {

                                $reviewedEmailFieldPercentage = Config::get('constants.reviewed_email_field_%');

                                if(isset($reviewedEmailFieldPercentage["responded"]) && $reviewedEmailFieldPercentage["responded"] != "") {

                                    $overall_average_sum += (int) $item["responded_sum"] * (float) $reviewedEmailFieldPercentage["responded"];

                                }

                            }

                        }

                        if (isset($item["language_sum"]) && $item["language_sum"] != "") {

                            // $item["formatted_language_average"] = (string) round((int)$item["language_sum"] / (int)$item["reviewed_count"], 2);

                            $item["formatted_language_average"] = $this->getStarByValue(round((int)$item["language_sum"] / (int)$item["reviewed_count"], 2), "star");

                            if (is_array(Config::get('constants.reviewed_email_field_%')) && count(Config::get('constants.reviewed_email_field_%')) > 0) {

                                $reviewedEmailFieldPercentage = Config::get('constants.reviewed_email_field_%');

                                if(isset($reviewedEmailFieldPercentage["language"]) && $reviewedEmailFieldPercentage["language"] != "") {

                                    $overall_average_sum += (int) $item["language_sum"] * (float) $reviewedEmailFieldPercentage["language"];

                                }

                            }

                        }

                        if (isset($item["satisfaction_sum"]) && $item["satisfaction_sum"] != "") {

                            // $item["formatted_satisfaction_average"] = (string) round((int)$item["satisfaction_sum"] / (int)$item["reviewed_count"], 2);

                            $item["formatted_satisfaction_average"] = $this->getStarByValue(round((int)$item["satisfaction_sum"] / (int)$item["reviewed_count"], 2), "star");

                            if (is_array(Config::get('constants.reviewed_email_field_%')) && count(Config::get('constants.reviewed_email_field_%')) > 0) {

                                $reviewedEmailFieldPercentage = Config::get('constants.reviewed_email_field_%');

                                if(isset($reviewedEmailFieldPercentage["satisfaction"]) && $reviewedEmailFieldPercentage["satisfaction"] != "") {

                                    $overall_average_sum += (int) $item["satisfaction_sum"] * (float) $reviewedEmailFieldPercentage["satisfaction"];

                                }

                            }

                        }

                        if (isset($item["overall_average"]) && $item["overall_average"] != "") {

                            $item["formatted_overall_average"] = $this->getStarByValue((float)$item["overall_average"], "star");

                        } else {

                            if($overall_average_sum > 0) {

                                $overall_average = $overall_average_sum;

                                $overall_average = $overall_average_sum / (int) $item["reviewed_count"] ;

                                // $item["formatted_overall_average"] = (string) round($overall_average, 2);

                                $item["formatted_overall_average"] = $this->getStarByValue(round($overall_average, 2), "star");

                            }

                        }

                    }

                    if (isset($item["emails_responded_count"]) && $item["emails_responded_count"] != "") {

                        $item["formatted_emails_responded_count"] = $item["emails_responded_count"];

                    }

                    if (isset($item["average_response_time"]) && $item["average_response_time"] != "") {

                        // $item["formatted_average_response_time"] = $item["average_response_time"];
                        $item["formatted_average_response_time"] = $this->getStarByValue($item["average_response_time"], "time");

                    }

                }

                return $item;
            },

            $items

        );

        return $resource;
    }

}
