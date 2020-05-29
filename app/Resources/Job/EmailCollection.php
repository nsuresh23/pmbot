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
    protected $emailAnnotatorBaseUrl;

    public function __construct()
    {
        $this->fractal = new Manager();

        $this->emailSendApiUrl       = env('API_EMAIL_SEND_URL');
		$this->draftemailSendApiUrl  = env('API_DRAFT_EMAIL_SEND_URL');
        $this->emailGetApiUrl        = env('API_GET_EMAIL_URL');
		$this->emailidGetApiUrl      = env('API_GET_EMAILID_URL');
        $this->emailListApiUrl       = env('API_EMAIL_BOX_LIST_URL');
        $this->pmsEmailCountApiUrl   = env('API_PMS_EMAIL_COUNT_URL');
        $this->emailAnnotatorBaseUrl = env("EMAIL_ANNOTATOR_BASE_URL");
    }

    /**
     * Get the pms email count.
     *
     * @return array $returnData
     */
    public function pmsEmailCount()
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $url = $this->pmsEmailCountApiUrl;

            $responseData = $this->postRequest($url, []);

            if ($responseData["success"] == "true" && count($responseData["data"]) > 0 && $responseData["data"] != "") {

                $responseData = $this->pmsEmailCountFormatData($responseData["data"]);

                $responseData = $responseData["data"];

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

            $url = $this->emailListApiUrl;

            $responseData = $this->postRequest($url, $field);

            if ($responseData["success"] == "true") {

                $returnResponse["success"] = "true";


                if (is_array($responseData["data"]) && count($responseData["data"]) > 0 && $responseData["data"] != "") {

                    $responseData = $this->formatData($responseData["data"], $field);

                    if ($responseData) {

                        // $returnResponse["success"] = "true";

                        $returnResponse["data"] = $responseData;

                        if (is_array($responseData)) {

                            $returnResponse["result_count"] = count($responseData);

                            if(!isset($returnResponse["last_updated"]) || $returnResponse["last_updated"] == "") {

                                $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
                                $lastUpdated =  $date->format('y/m/d h:i:s A');

                                $returnResponse["last_updated"] = $lastUpdated;

                            }

                            // $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
                            // $returnResponse["last_updated"] =  $date->format('y/m/d h:i:s a');

                            // $returnResponse["last_updated"] = date('y/m/d h:i:s a');

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
                $field["cc"] = base64_encode($field['cc']);
            } else {
                $field["cc"] = '';
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

                            array_walk(
                                $emailAttachments,
                                function ($item, $key) use ($emailAttachmentPath, &$emailAttachmentHtml, &$emailAttachments) {

                                    try {

                                        if ($item) {

                                            $item_file = Config::get('constants.emailImageDownloadPath');

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

                                $returnResponse["data"]["email_attachment_count"] = count($emailAttachments);
                                $returnResponse["data"]["email_attachment"] = $emailAttachments;
                                $returnResponse["data"]["email_attachment_html"] = $emailAttachmentHtml;

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
                $field["email_to"] = base64_encode($field['email_to']);
            } else {
                $field["email_to"] = '';
            }
			if (isset($field['email_cc']) && $field['email_cc'] != "") {
                $field["email_cc"] = base64_encode($field['email_cc']);
            } else {
                $field["email_cc"] = '';
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
                    $emailGetUrl = route(__("job.email_get_url"));

                    $item["is_attachments"] = "";

                    if (isset($item["attachments"]) && $item["attachments"] != "") {

                        $item["is_attachments"] = '<i class="zmdi zmdi-attachment inline-block font-16"></i>';
                    }

					$emailDate = "";

					if(isset($item["status"]) && $item["status"] != "") {

						if( in_array($item["status"], ["0","1", "2", "3"])){

							if(isset($item["email_received_date"]) && $item["email_received_date"] != ""){

								$emailDate = $item["email_received_date"];
							}
						}

						if( in_array($item["status"], ["4", "5"])){

							if(isset($item["created_date"]) && $item["created_date"] != ""){

								$emailDate = $item["created_date"];
							}
						}

						if( in_array($item["status"], ["6"])){

							if(isset($item["email_sent_date"]) && $item["email_sent_date"] != ""){

								$emailDate = $item["email_sent_date"];
							}
						}

					}

					if ($emailDate){

						//	$returnResponse["data"]["create_date_formatted_text"] = date("dS M Y h:i:s a", strtotime($emailDate));

							$item["created_date"] = date("y/m/d H:i:s", strtotime($emailDate));
						}

                    /*  if (isset($item["created_date"]) && $item["created_date"] != "") {

                        $item["created_date_text"] = $item["created_date"];
                        // $item["created_date"] = date("d/m/y", strtotime($item["created_date"]));
                        //$item["created_date"] = date("d/m/y h:i:s a", strtotime($item["created_date"]));
						$item["created_date"] = date("y/m/d H:i:s", strtotime($item["created_date"]));
                    } */

                    if (isset($item["email_from"]) && $item["email_from"] != "") {

                        if (base64_decode($item["email_from"], true)) {

                            $item["email_from"] = base64_decode($item["email_from"]);

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

						//Bharathi changed as per Balaji's new format 10 May 2020
						/* if (isset($item["empcode"]) &&  $item["empcode"] != "") {

                        //    $emailViewUrl = $emailViewUrl . "&empcode=" . $item["empcode"];
                            $emailViewUrl = $emailViewUrl . "/empcode/" . $item["empcode"];
                        } */

                         $item['subject_link'] = '<a class="btn-link email-item ' . $emailTypeClass . '" href="' . $emailViewUrl . '" target="_blank" data-email-id="' . $item["id"] . '" data-email-geturl="' . $emailGetUrl . '">' . mb_strimwidth($item["subject"], 0, 75, "...") . '</a>';
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

                    if(isset($item["last_processed_time"]) && $item["last_processed_time"] != "") {

                        $item["last_processed_time"] = date("y/m/d H:i:s", strtotime($item["last_processed_time"]));

                    }

                    if (isset($item["last_annotated_time"]) && $item["last_annotated_time"] != "") {

                        $item["last_annotated_time"] = date("y/m/d H:i:s", strtotime($item["last_annotated_time"]));
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
}
