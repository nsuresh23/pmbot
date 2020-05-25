<?php

namespace App\Resources\Notification;

use App\Traits\General\Helper;

use App\Traits\General\ApiClient;

use Illuminate\Support\Facades\Validator;

use App\Traits\General\CustomLogger;

class NotificationCollection
{

    use ApiClient;

    use Helper;

    use CustomLogger;

    protected $client;

    protected $notificationCountApiUrl;

    protected $notificationUpdateApiUrl;

    protected $notificationListByFieldApiUrl;

    protected $notificationReadApiUrl;

    protected $notificationReadAllApiUrl;


    public function __construct()
    {

        $this->notificationCountApiUrl = env('API_NOTIFICATION_COUNT_URL');
        $this->notificationUpdateApiUrl = env('API_NOTIFICATION_UPDATE_URL');
        $this->notificationListByFieldApiUrl = env('API_NOTIFICATION_LIST_BY_FIELD_URL');
        $this->notificationReadApiUrl = env('API_NOTIFICATION_READ_URL');
        $this->notificationReadAllApiUrl = env('API_NOTIFICATION_READ_ALL_URL');

    }

    /**
     * Get the notification count by field array.
     *
     * @param  array $field
     * @return array $returnData
     */
    public function notificationCount($field)
    {
        $returnResponse = [];

        try {

            $url = $this->notificationCountApiUrl;

            $responseData = $this->postRequest($url, $field);

            if (isset($responseData["success"]) && $responseData["success"] == "true") {

                $returnResponse = $responseData;
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
     * Get notification list by notification field array.
     *
     * @param  array $field
     * @return array $returnData
     */
    public function notificationListByField($field)
    {

        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $paramData = [];

            $url = $this->notificationListByFieldApiUrl;

            $paramData = $field;

            $responseData = $this->postRequest($url, $paramData);

            $tempData = [
                            [
                                "id"=>"1",
                                "title"=>"New job assigned",
                                "message"=>"A new job job title 1 is assigned for you.",
                                "type"=>"job",
                                "reference_id"=>"1",
                                "read"=>"0",
                            ],
                            [
                                "id"=>"2",
                                "title"=>"New task assigned",
                                "message"=>"A new task task title 1 is assigned for you.",
                                "type"=>"task",
                                "reference_id"=>"1",
                                "read"=>"0",
                            ],
                            [
                                "id"=>"2",
                                "title"=>"New check list added",
                                "message"=>"A new check list check list title 1 created.",
                                "type"=>"check_list",
                                "reference_id"=>"1",
                                "read"=>"0",
                            ]
                        ];

            // $responseData["data"] = json_decode($tempData, true);
            // $responseData["data"] = $tempData;

            // $responseData["success"] = "true";
            if ($responseData["success"] == "true" && count($responseData["data"]) > 0 && $responseData["data"] != "") {

                $returnData = $this->formatData($responseData["data"]);

                if (count($returnData) > 0) {

                    $responseData = implode("", array_column($returnData, "notification_view"));
                }

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
     * Read the notification based on notification id.
     *
     * @return array $returnResponse
     */
    public function notificationRead($request)
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
                'reference_id'       => 'required',
                // 'title'       => 'required'
                'empcode'       => 'required'
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Read failed";
            } else {

                $paramInfo = $request->all();

                $url = $this->notificationReadApiUrl;

                $returnData = $this->postRequest($url, $paramInfo);

                if (isset($returnData["success"]) && $returnData["success"] == "true") {

                    $returnResponse["success"] = "true";
                    $returnResponse["message"] = "Read successfull";
                } else {

                    $returnResponse["error"] = "true";
                    $returnResponse["message"] = "Read unsuccessfull";
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
     * Read all notification based on empcode.
     *
     * @return array $returnResponse
     */
    public function notificationReadAll($request)
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
                'empcode'       => 'required'
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Read all failed";
            } else {

                $paramInfo = $request->all();

                $url = $this->notificationReadAllApiUrl;

                $returnData = $this->postRequest($url, $paramInfo);

                if (isset($returnData["success"]) && $returnData["success"] == "true") {

                    $returnResponse["success"] = "true";
                    $returnResponse["message"] = "Read all successfull";
                } else {

                    $returnResponse["error"] = "true";
                    $returnResponse["message"] = "Read all unsuccessfull";
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
     * Edit the notification based on notification id.
     *
     * @return array $returnResponse
     */
    public function notificationEdit($request)
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
                'id'       => 'required',
                // 'job_id'       => 'required',
                'read'       => 'required'
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Update failed";
            } else {

                $paramInfo = $request->all();

                $url = $this->notificationUpdateApiUrl;

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

    public function notificationView($item)
    {

        $viewUrl = "";

        $notificationItemCount = "";

        if($item->type == "job") {

            $viewUrl = route(__("job.job_detail_url"), $item->reference_id);

        }

        if ($item->type == "task" || $item->type == "inhouse_query" || $item->type == "external_query") {

            $viewUrl = route(__("job.task_view_url"), $item->reference_id);

        }

        if ($item->type == "email") {

            $viewUrl = env('EMAIL_ANNOTATOR_BASE_URL');

           /*  if (isset($item->empcode) &&  $item->empcode != "") {

                $viewUrl = $viewUrl . "?empcode=" . $item->empcode;

            } */

            if (isset($item->reference_id) &&  $item->reference_id != "") {

                //$viewUrl = $viewUrl . "&email_id=" . $item->reference_id;
                $viewUrl = $viewUrl . "/id/" . $item->reference_id;

            }

        }

        if ($item->type == "global_check_list" || $item->type == "job_check_list") {

            $viewUrl = route(__("job.check_list_view_url"), $item->reference_id);

            if (isset($item->job_id) &&  $item->job_id != "") {

                $viewUrl = $viewUrl . "?job_id=" . $item->job_id;

            }

        }

        if (isset($item->count) &&  $item->count != "0") {

            $notificationItemCount .= '<span class="notification-item-count">';
                $notificationItemCount .= '<span class="notification-item-count-icon-badge">';
                    $notificationItemCount .= $item->count;
                $notificationItemCount .= '</span>';
            $notificationItemCount .= '</span>';

        }

        $viewLink = '<a href="' . $viewUrl . '">view</a>';

        // $readLink = route(__("job.notification_read_url"), $item->reference_id) . "?title=" . $item->title . "&message=" . $item->message;

        $readLink = route(__("job.notification_read_url"), $item->reference_id) . "?type=" . $item->type . "&category=" . $item->category;

        if ($item->type == "email") {

            $readLink = "";

        }

        $returnData = "";
        $returnData = '<div class="sl-item notification-item notification-unread-color" data-notification-read-link="' . $readLink . '">';
            // $returnData .= '<a href="javascript:void(0)">';
                $returnData .= '<div class="icon bg-blue">';
                    $returnData .= '<i class="zmdi zmdi-email"></i>';
                    $returnData .= $notificationItemCount;
                $returnData .= '</div>';
                $returnData .= '<div class="sl-content">';
                    $returnData .= '<span class="inline-block capitalize-font  pull-left truncate head-notifications">';
                        $returnData .= $item->title;
                        // $returnData .= '2 new messages';
                    $returnData .= '</span>';
                    $returnData .= '<span class="inline-block font-13  pull-right notifications-time">';
                        $returnData .= $viewLink;
                        // $returnData .= '4pm';
                    $returnData .= '</span>';
                    $returnData .= '<div class="clearfix"></div>';
                    $returnData .= '<p class="truncate">';
                        $returnData .= $item->message;
                        // $returnData .= 'The last payment for your G Suite Basic subscription failed.';
                    $returnData .= '</p>';
                $returnData .= '</div>';
            // $returnData .= '</a>';
            $returnData .= '</div>';
            $returnData .= '<hr class="light-grey-hr ma-0" />';

        return $returnData;
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

                // $item['count'] = '8';

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

                $item['notification_view'] = $this->notificationView((object)$item);

                return $item;
            },
            $items
        );

        return $resource;

    }

}
