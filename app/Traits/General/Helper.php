<?php

namespace App\Traits\General;

use Exception;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;

trait Helper
{

    public function dropzoneMediaUpload($request)
    {

        $path = public_path(env('UPLOAD_FOLDER'));


        if (!file_exists($path)) {

            mkdir($path, 0777, true);

            // $old = umask(0);
            // mkdir($path, 0777);
            // umask($old);
        }

        // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($path);echo '<PRE/>';exit;
        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());


        $file->move($path, $name);

        return response()->json(
            [

                'name'          => $name,

                'original_name' => $file->getClientOriginalName(),

            ]
        );
    }

    public function dropzoneMediaList($items)
    {


        $resource = [];

        try {

            for ($i = 0; $i < count($items); $i++) {

                try {

                    // $filePath = public_path(env('UPLOAD_FOLDER')) . '\\' . $items[$i];
                    // $fileUrlPath = asset('public/' . env('UPLOAD_FOLDER') . '/' . $items[$i]);

                    $filePath = public_path('img/uploads/') . '\\' . $items[$i];
                    $fileUrlPath = asset('public/img/uploads/' . $items[$i]);

                    if(file_exists($filePath)) {

                        $resource[$i] =  [
                            'name'   => $items[$i],
                            'size'   => filesize($filePath),
                            'path'   => $filePath,
                            'url'    => $fileUrlPath,
                        ];
                    }

                } catch (Exception $e) {

                    return null;
                }
            }
        } catch (Exception $e) {

            return null;
        }

        return $resource;
    }

    public function avatarImage()
    {

        $fileUrlPath = "#";

        try {

            $fileUrlPath = asset('public/img/avatar.jpg');

        } catch (Exception $e) {

            return null;
        }

        return $fileUrlPath;
    }

    public function roleBasedDashboardRouteAction($request)
    {
        // $redirectRouteAction = "/";

        $redirectRouteAction = 'StakeHolders\DashboardController@index';

        if ($request->user()->role == "project_manager") {

            $redirectRouteAction = 'PM\DashboardController@index';
        }

        if ($request->user()->role == "account_manager") {

            $redirectRouteAction = 'AM\DashboardController@index';
        }

        if ($request->user()->role == "admin") {

            $redirectRouteAction = 'Admin\DashboardController@index';
        }

        return $redirectRouteAction;
    }

    function createExcerptAndLink($text, $limit, $url, $readMoreText = 'Read More')
    {

        $end = "...<br><br><a class=\"btn btn-default\" href=\"$url\">$readMoreText</a>";

        // $end = '...<button onclick="myFunction()" id="myBtn">Read more</button>';

        return Str::limit($text, $limit, $end);
    }

    public function formatSelectData($items)
    {

        $returnData = [];

        if(count($items) > 0) {

            $returnData = array_column($items, 'empname', 'empcode');

        }

        return $returnData;

    }

    /**
     * format diary view.
     *
     * @return array $item
     */

    public function diaryView($item)
    {

        $returnData = '<div class="sl-item">';
        $returnData .= '<a href="javascript:void(0)">';
        $returnData .= '<div class="sl-avatar avatar avatar-sm avatar-circle">';
        $returnData .= '<img class="img-responsive img-circle" src="';
        $returnData .= asset('public/img/user1.png');
        $returnData .= '" alt="avatar" />';
        $returnData .= '</div>';
        $returnData .= '<div class="sl-content">';
        $returnData .= '<p class="inline-block">';
        $returnData .= '<span class="capitalize-font txt-primary mr-5 weight-500">';
        $returnData .= $item["empname"];
        $returnData .= '</span>';
        $returnData .= '<span class="txt-dark">';

        if (in_array($item["tablename"], Config::get("constants.jobHistory.receivedTables"))) {

            $returnData .= ' received a new ' . str_replace("_", " ", $item["tablename"]);
        }

        if (in_array($item["tablename"], Config::get("constants.jobHistory.createdTables"))) {

            $returnData .= ' created a new ' . str_replace("_", " ", $item["tablename"]);
        }

        if (in_array($item["tablename"], Config::get("constants.jobHistory.changedTables"))) {

            // $returnData .= ' changed the ' . $item["field_value"] . ' from ' . htmlspecialchars($item["original_value"]) . ' to ' . htmlspecialchars($item["modified_value"]);
            $returnData .= ' changed the ' . $item["field_value"] . ' from ' . strip_tags($item["original_value"]) . ' to ' . strip_tags($item["modified_value"]);
        }

        $returnData .= '</span>';

        if (isset($item["title"]) && $item["title"] != "") {

            $returnData .= '<span>';

            // if (base64_decode($item["title"], true)) {

            //     $title = base64_decode($item["title"]);

            // } else {

            //     $title = $item["title"];

            // }

            // $title = htmlspecialchars($item["title"]);
            $title = strip_tags($item["title"]);

            $returnData .= ' ' . $title;

            $returnData .= '</span>';

        } else {

            if (isset($item["additional_note"]) && $item["additional_note"] != "") {

                $returnData .= '<span>';

                // $additionalNote = htmlspecialchars($item["additional_note"]);
                $additionalNote = strip_tags($item["additional_note"]);
                $additionalNote = $item["additional_note"];

                $returnData .= ' ' . $additionalNote;

                $returnData .= '</span>';

            }

            if (isset($item["attachment_path"]) && $item["attachment_path"] != "") {

                $returnData .= '<p>';

                // $attachmentPath = htmlspecialchars($item["attachment_path"]);
                $attachmentPath = strip_tags($item["attachment_path"]);
                $attachmentPath = $item["attachment_path"];

                $returnData .= ' ' . $attachmentPath;

                $returnData .= '</p>';

            }

        }

        $returnData .= '</p>';
        $returnData .= '<span class="block txt-grey font-12 capitalize-font">';
        $returnData .= '<i class="fa fa-calendar grey"></i>';
        $returnData .= '<span class="pl-5">';
        $returnData .= date('g:ia \o\n l jS F Y', strtotime($item['created_date']));
        $returnData .= '</span>';
        $returnData .= '</span>';
        $returnData .= '</div>';
        $returnData .= '</a>';
        $returnData .= '</div>';

        return $returnData;

    }

    /**
     * format job diary view.
     *
     * @return array $item
     */

    public function jobDiaryView($item)
    {

        $eventMessage = $actionTypePrefixText = "";
        $actionItemUrl = $jobUrl = "#";

        if (isset($item["action_item"]) && $item["action_item"] != "") {

            if ($item["action_item"] == "task" && (!isset($item["job_id"]) || $item["job_id"] == "" || $item["job_id"] == null)) {

                $actionTypePrefixText = "Generic";
            }

            if ($item["action_item"] == "email" && (!isset($item["job_id"]) || $item["job_id"] == "" || $item["job_id"] == null)) {

                if (isset($item["action_type"]) && in_array($item["action_type"], ["reply", "forward", "sent"])) {

                    $actionTypePrefixText = "Non-business";
                }
            }

            // if ($item["action_item"] == "email" && !isset($item["job_id"]) || $item["job_id"] == "" || $item["job_id"] == null) {

            //     $actionTypePrefixText = "Generic";

            // }

            $eventMessage .= $actionTypePrefixText;

            $eventMessage .= '<span class="capitalize-font pl-5">';
            $eventMessage .= ucwords($item["action_item"]);
            $eventMessage .= '</span>';

            if (isset($item[$item["action_item"] . "_title"]) && $item[$item["action_item"] . "_title"] != "") {

                if ($item["action_item"] == "job") {

                    $actionItemUrl = route(__("job.job_detail_url"), $item[$item["action_item"] . "_id"]);
                }

                if ($item["action_item"] == "task") {

                    $actionItemUrl = route(__("job.task_view_url"), $item[$item["action_item"] . "_id"]);
                }

                if ($item["action_item"] == "checklist") {

                    $actionItemUrl = route(__("job.check_list_view_url"), $item[$item["action_item"] . "_id"]);
                }

                if ($item["action_item"] == "email") {

                    $actionItemUrl = route(__("job.email_view_url"), $item[$item["action_item"] . "_id"]);
                }

                $eventMessage .= " with title ";

                $eventMessage .=  '<a class="btn-link" href="' . $actionItemUrl . '" target="_blank" title="' . $item[$item["action_item"] . "_title"] . '">' . mb_strimwidth($item[$item["action_item"] . "_title"], 0, 75, "...") . '</a>';
                // $eventMessage .= '<span class="text-success">';
                // $eventMessage .= $item[$item["action_item"] . "_title"];
                // $eventMessage .= '</span>';

            }
        }

        if (isset($item["action_type"]) && $item["action_type"] != "") {

            if ($item["action_type"] == "add") {

                $actionTypeAddText = " was created";

                if (isset($item["action_item"]) && $item["action_item"] == "email") {

                    $actionTypeAddText = " was received";
                }

                $eventMessage .= $actionTypeAddText;
            }

            if ($item["action_type"] == "edit" || $item["action_type"] == "update") {

                $eventMessage .= " was modified";
            }

            if ($item["action_type"] == "delete") {

                $eventMessage .= " was deleted";
            }

            if ($item["action_type"] == "closed") {

                $eventMessage .= " was closed";
            }

            if ($item["action_type"] == "hold") {

                $eventMessage .= " on hold";
            }

            if ($item["action_type"] == "job_tagging") {

                $eventMessage .= " was associated";
            }

            if ($item["action_type"] == "job_untagging") {

                $eventMessage .= " was un-associated";
            }

            if ($item["action_type"] == "nb_tagging") {

                $eventMessage .= " tagged as Non-Business";
            }

            if ($item["action_type"] == "reply") {

                $eventMessage .= " was replied";
            }

            if ($item["action_type"] == "forward") {

                $eventMessage .= " was forwarded";
            }

            if ($item["action_type"] == "sent") {

                $eventMessage .= " was sent";
            }

            // if (isset($item["action_item"]) && $item["action_item"] != "job" && isset($item["job_title"]) && $item["job_title"] != "") {

            //     $eventMessage .= " for Job ";

            //     $jobUrl = route(__("job.job_detail_url"), $item["job_id"]);

            //     $eventMessage .=  '<a class="btn-link" href="' . $jobUrl . '" target="_blank" title="' . $item["job_title"] . '">' . mb_strimwidth($item["job_title"], 0, 75, "...") . '</a>';

            //     // $eventMessage .= '<span class="text-warning">';
            //     // $eventMessage .= $item["job_title"];
            //     // $eventMessage .= '</span>';

            // }

        }

        if (isset($item["empcode"]) && $item["empcode"] != "") {

            $eventMessage .= " by ";

            $eventMessage .=  $item["empcode"];

            // $eventMessage .= '<span class="text-warning">';
            // $eventMessage .= $item["job_title"];
            // $eventMessage .= '</span>';

        }

        $returnData = '<div class="sl-item">';

        $returnData .= '<p>';

        $returnData .= '<span class="block txt-dark font-14 pl-5">';
        $returnData .= '<i class="fa fa-calendar grey"></i>';
        $returnData .= '<span class="pl-5">';
        $returnData .= date('jS F Y h:i A', strtotime($item['date_time']));
        $returnData .= '</span>';

        if ($eventMessage) {

            $returnData .= '<span class="pl-5">';
            $returnData .= $eventMessage . ".";
            $returnData .= '</span>';
        }

        $returnData .= '</span>';

        $returnData .= '</p>';

        $returnData .= '</div>';

        return $returnData;
    }

    /**
     * format user action diary view.
     *
     * @return array $item
     */

    public function userActiondiaryView($item)
    {

        $eventMessage = $actionTypePrefixText = "" ;
        $actionItemUrl = $jobUrl = "#";

        if (isset($item["action_item"]) && $item["action_item"] != "") {

            if ($item["action_item"] == "task" && (!isset($item["job_id"]) || $item["job_id"] == "" || $item["job_id"] == null)) {

                $actionTypePrefixText = "Generic";

            }

            if ($item["action_item"] == "email" && (!isset($item["job_id"]) || $item["job_id"] == "" || $item["job_id"] == null)) {

                if (isset($item["action_type"]) && in_array($item["action_type"], ["reply", "forward", "sent"])) {

                    $actionTypePrefixText = "Non-business";

                }

            }

            // if ($item["action_item"] == "email" && !isset($item["job_id"]) || $item["job_id"] == "" || $item["job_id"] == null) {

            //     $actionTypePrefixText = "Generic";

            // }

            $eventMessage .= $actionTypePrefixText;

            $eventMessage .= '<span class="capitalize-font pl-5">';
            $eventMessage .= ucwords($item["action_item"]);
            $eventMessage .= '</span>';

            if (isset($item[$item["action_item"]. "_title" ]) && $item[$item["action_item"] . "_title"] != "") {

                if($item["action_item"] == "job") {

                    if(isset($item[$item["action_item"] . "_id"]) && $item[$item["action_item"] . "_id"] != "") {

                        $actionItemUrl = route(__("job.job_detail_url"), $item[$item["action_item"] . "_id"]);

                    }

                }

                if ($item["action_item"] == "task") {

                    if (isset($item[$item["action_item"] . "_id"]) && $item[$item["action_item"] . "_id"] != "") {

                        $actionItemUrl = route(__("job.task_view_url"), $item[$item["action_item"] . "_id"]);

                    }

                }

                if ($item["action_item"] == "checklist") {

                    if (isset($item[$item["action_item"] . "_id"]) && $item[$item["action_item"] . "_id"] != "") {

                        $actionItemUrl = route(__("job.check_list_view_url"), $item[$item["action_item"] . "_id"]);

                    }

                }

                if ($item["action_item"] == "email") {

                    if (isset($item[$item["action_item"] . "_id"]) && $item[$item["action_item"] . "_id"] != "") {

                        $actionItemUrl = route(__("job.email_view_url"), $item[$item["action_item"] . "_id"]);

                    }

                }

                $eventMessage .= " with title ";

                $eventMessage .=  '<a class="btn-link" href="' . $actionItemUrl . '" target="_blank" title="' . $item[$item["action_item"] . "_title"] . '">' . mb_strimwidth($item[$item["action_item"] . "_title"], 0, 75, "...") . '</a>';
                // $eventMessage .= '<span class="text-success">';
                // $eventMessage .= $item[$item["action_item"] . "_title"];
                // $eventMessage .= '</span>';

            }

        }

        if (isset($item["action_type"]) && $item["action_type"] != "") {

            if($item["action_type"] == "add") {

                $actionTypeAddText = " was created";

                if (isset($item["action_item"]) && $item["action_item"] == "email") {

                    $actionTypeAddText = " was received";

                }

                $eventMessage .= $actionTypeAddText;

            }

            if ($item["action_type"] == "edit" || $item["action_type"] == "update") {

                $eventMessage .= " was modified";

            }

            if ($item["action_type"] == "delete") {

                $eventMessage .= " was deleted";

            }

            if ($item["action_type"] == "closed") {

                $eventMessage .= " was closed";

            }

            if ($item["action_type"] == "hold") {

                $eventMessage .= " on hold";

            }

            if ($item["action_type"] == "job_untagging") {

                $eventMessage .= " was un-associated";

            }

            if ($item["action_type"] == "job_tagging") {

                $eventMessage .= " was associated";

            }

            if ($item["action_type"] == "nb_tagging") {

                $eventMessage .= " tagged as Non-Business";

            }

            if ($item["action_type"] == "reply") {

                $eventMessage .= " was replied";

            }

            if ($item["action_type"] == "forward") {

                $eventMessage .= " was forwarded";

            }

            if ($item["action_type"] == "sent") {

                $eventMessage .= " was sent";

            }

            if (isset($item["action_item"]) && $item["action_item"] != "job" && isset($item["job_title"]) && $item["job_title"] != "" ) {

                $eventMessage .= " for Job ";

                $jobUrl = route(__("job.job_detail_url"), $item["job_id"]);

                $eventMessage .=  '<a class="btn-link" href="' . $jobUrl . '" target="_blank" title="' . $item["job_title"] . '">' . mb_strimwidth($item["job_title"], 0, 75, "...") . '</a>';

                // $eventMessage .= '<span class="text-warning">';
                // $eventMessage .= $item["job_title"];
                // $eventMessage .= '</span>';

            }

            if (isset($item["creator_empcode"]) && $item["creator_empcode"] != "" && $item["creator_empcode"] != null && $item["creator_empcode"] != auth()->user()->empcode) {

                $eventMessage .= " by ";

                $eventMessage .= $item["creator_empcode"];

            }

        }

        $returnData = '<div class="sl-item">';

            $returnData .= '<p>';

                $returnData .= '<span class="block txt-dark font-14 pl-5">';
                    $returnData .= '<i class="fa fa-calendar grey"></i>';
                    $returnData .= '<span class="pl-5">';
                        $returnData .= date('jS F Y h:i A', strtotime($item['date_time']));
                    $returnData .= '</span>';

                    if($eventMessage) {

                        $returnData .= '<span class="pl-5">';
                            $returnData .= $eventMessage . ".";
                        $returnData .= '</span>';

                    }

                $returnData .= '</span>';

            $returnData .= '</p>';

        $returnData .= '</div>';

        return $returnData;
    }

    /**
     * format task assignee.
     *
     * @return array $request
     */

    public function formatTaskAssignee($request, $startsWithString, $splitString)
    {

        $returnData = $request->all();

        $requestKeys = array_keys($returnData);

        $assigneeArray = [];

        array_walk($requestKeys, function($item, $key) use(&$assigneeArray, $request, $startsWithString, $splitString) {

            if (is_string($item)) {

                if(strpos($item, $startsWithString) === 0) {

                    $splitArray = [];

                    $splitArray = explode($splitString, $item);

                    if(count($splitArray) == 3) {

                        $assigneeArray[$splitArray[1]][$splitArray[2]] = $request[$item];

                        unset($request[$item]);

                    }

                }

            }

        });

        if (count($assigneeArray) > 0) {

            $request->merge(["users" => array_values($assigneeArray)]);

        }

        return $request;

    }

    /**
     * format task assignee.
     *
     * @return array $request
     */

    public function formatHistoryData($request, $startsWithString, $splitString)
    {

        $returnData = $request->all();

        $requestKeys = array_keys($returnData);

        $historyArray = [];

        array_walk($requestKeys, function ($item, $key) use (&$historyArray, $request, $startsWithString, $splitString) {

            if (is_string($item)) {

                if (strpos($item, $startsWithString) === 0) {

                    $splitArray = [];

                    $splitArray = explode($splitString, $item);

                    if (count($splitArray) == 3) {

                        $historyArray[$splitArray[1]][$splitArray[2]] = $request[$item];

                        unset($request[$item]);
                    }
                }
            }
        });

        if(count($historyArray) > 0) {

            $request->merge(["history" => array_values($historyArray)]);

        }

        return $request;
    }

    /**
     * format diary view.
     *
     * @return array $item
     */

    public function taskCheckListItemView($item)
    {

        $returnData = $checkListUrl = $status = $disabled = "";

        // $item["id"] = "004";

        // $item["title"] = "Prepare For The Next";

        // $item["check_list_id"] = "30";

        if (!in_array(auth()->user()->role, Config::get('constants.nonStakeHolderUserRoles'))) {

            $disabled = "disabled";

        }

        if(isset($item["check_list_id"]) && $item["check_list_id"] != '') {

            if (isset($item["status"]) && $item["status"] == '1') {

                $status = "checked";

            }

            if (isset($item["title"]) && $item["title"] != '') {

                $checkListUrl = route(__('job.check_list_view_url'), $item['check_list_id']);

                // $title_link = '<a  href="'. $checkListUrl . '">' . $item["title"] . '</a>';
                $title_link = $item["title"];
                $view_link = '<a  href="' . $checkListUrl . '">view</a>';

            }

        }

        if($title_link != "") {

            $returnData = '<li class="todo-item">';

            if($disabled != "disabled") {

                $returnData .= '<div class="checkbox checkbox-success" style="display:inline;">';

                $returnData .= '<input type="checkbox" id="checkbox_';
                $returnData .= $item["id"];
                $returnData .= '" data-checklist-id="';
                $returnData .= $item["id"];
                $returnData .= '" ';
                $returnData .= $status;
                $returnData .= ' ';
                $returnData .= $disabled;
                $returnData .= ' />';

            } else {

                $returnData .= '<div class="checkbox-success" style="display:inline;">';

            }

            $returnData .= '<label for="checkbox_';
            $returnData .= $item["id"];
            $returnData .= '">';
            $returnData .= $title_link;
            $returnData .= '</label>';
            $returnData .= '</div>';
            $returnData .= '<span class="pl-10 pull-right">';
            $returnData .= $view_link;
            $returnData .= '</span>';
            $returnData .= '</li>';
            $returnData .= '<li>';
            $returnData .= '<hr class="light-grey-hr" />';
            $returnData .= '</li>';

            // $returnData = '<li class="col-lg-12 col-md-12 col-sm-12 col-xs-12 todo-item">';

            //     $returnData .= '<div class="row">';

            //         $returnData .= '<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 checkbox checkbox-success">';

            //             $returnData .= '<input type="checkbox" id="checkbox_';
            //             $returnData .= $item["id"];
            //             $returnData .= '" data-checklist-id=';
            //             $returnData .= $item["id"];
            //             $returnData .= '" checked />';

            //          $returnData .= '</div>';

            //         $returnData .= '<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">';

            //             $returnData .= '<label for="checkbox_';
            //             $returnData .= $item["id"];
            //             $returnData .= '">';
            //             $returnData .= $title_link;
            //             $returnData .= '</label>';

            //         $returnData .= '</div>';

            //     $returnData .= '</div">';

            // $returnData .= '</li">';

            // $returnData .= '<li>';
            // $returnData .= '<hr class="light-grey-hr" />';
            // $returnData .= '</li>';

        }


        return $returnData;

    }

    /**
     * format diary view.
     *
     * @return array $item
     */

    public function checkListTaskItemView($item)
    {

        $returnData = "";

        if (isset($item["task_title"]) && $item["task_title"]) {

            $returnData .= '<span class="tag tag-item">';
            $returnData .= $item["task_title"];
            // $returnData .= '<span data-role="remove"></span>';
            $returnData .= '</span>';


        }

        return $returnData;

    }

    public function taskValidUserCheck($returnData)
    {

        try {


            if (!$returnData["data"]) {

                // return view('errors.error404');

                redirect()->route("error404");
            }

            if (auth()->user() === null || auth()->user() == "") {

                // return view('auth.login');
                redirect()->route("login");
            }

            if (!in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) {

                if (isset($returnData["data"]["assignedto_empcode"]) && $returnData["data"]["assignedto_empcode"] != auth()->user()->empcode) {

                    // return view('errors.error401');
                    redirect()->route("error401");
                }

                if (isset($returnData["data"]["createdby_empcode"]) && $returnData["data"]["createdby_empcode"] != auth()->user()->empcode) {

                    // return view('errors.error401');
                    redirect()->route("error401");
                }

                if (isset($returnData["data"]["status"]) && $returnData["data"]["status"] == __("job.task_closed_status_text")) {

                    // return view('errors.error401');
                    redirect()->route("error401");
                }
            }

        } catch(Exception $e) {

            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );

        }

    }

    public function emailValidUserCheck($returnData)
    {

        try {

            if (auth()->user() === null || auth()->user() == "") {

                redirect()->route("login");
            }

            if (!is_array($returnData["data"])) {

                redirect()->route("error404");
            }


            if (!isset($returnData["data"])) {

                redirect()->route("error404");
            }

            if (is_array($returnData) && isset($returnData["success"]) && $returnData["success"] == "true") {

                if (isset($returnData["data"]) && is_array($returnData["data"]) && count($returnData["data"]) > 0) {

                    if (isset($returnData["data"]["empcode"]) && $returnData["data"]["empcode"] != auth()->user()->empcode) {

                        redirect()->route("error401");
                    }
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

    public function getFileType($url)
    {
        $type = "file";

        try {

            $filename = explode('.', $url);
            $extension = strtolower(end($filename));

            switch ($extension) {
                case 'pdf':
                    $type = $extension;
                    break;
				case 'PDF':
                    $type = 'file-pdf';
                    break;
                case 'txt':
                    $type = 'file-text';
                    break;
                case 'docx':
                case 'doc':
                    $type = 'file-word';
                    break;
                case 'xls':
				case 'csv':
                case 'xlsx':
                    $type = 'file-excel';
                    break;
                case 'mp3':
                case 'ogg':
                case 'wav':
                    $type = 'file-audio';
                    break;
                case 'mp4':
                case 'mov':
                    $type = 'file-video';
                    break;
                case 'zip':
                case '7z':
                case 'rar':
                    $type = 'file-archive';
                    break;
                case 'jpg':
                case 'jpeg':
                case 'png':
                    $type = 'file-image';
                    break;
				case 'html':
					$type = 'file-code';
                    break;
                case 'eml':
                    $type = 'envelope';
                    break;
                default:
                    $type = 'file-picture';
            }
        } catch (Exception $e) {

            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return $type;
    }

    public function formatFilter(&$filterData, $formatData)
    {

        try {

            if(is_array($filterData) && count($filterData) > 0 && is_array($formatData) && count($formatData) > 0) {

                foreach ($formatData as $key => $value) {

                    if(isset($filterData['sortField']) && $filterData['sortField'] == $key) {

                        $filterData['sortField'] = $value;

                    }

                    if (array_key_exists($key, $filterData)) {

                        $filterData[$value] = $filterData[$key];

                        unset($filterData[$key]);

                    }
                }

                if (array_key_exists("followup_date", $filterData)) {

                    $filterData["followup_date"] = str_replace("/", "-", $filterData["followup_date"]);

                }

                if (array_key_exists("created_date", $filterData)) {

                    $filterData["created_date"] = str_replace("/", "-", $filterData["created_date"]);

                    // $date = new DateTime($filterData["created_date"]);
                    // $created_date =  $date->format('Y-m-d h:i:s');

                    // $filterData["created_date"] = $created_date;

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

    public function formatDataTableFilter(&$filterData, $fieldData, $orderData, $formatData)
    {

        try {

            if (is_array($orderData) && count($orderData) > 0 ) {

                $orderDataColumns = array_shift($orderData);

                if (is_array($orderDataColumns) && count($orderDataColumns) > 0 ) {

                    $value = $sortOrder = '';

                    if (isset($orderDataColumns["column"]) && $orderDataColumns["column"] != '') {

                        $value = $orderDataColumns["column"];

                    }

                    if (isset($orderDataColumns["dir"]) && $orderDataColumns["dir"] != '') {

                        $sortOrder = $orderDataColumns["dir"];

                    }

                    if (is_array($fieldData) && count($fieldData) > 0) {

                        if (isset($fieldData[$value]) && is_array($fieldData[$value]) && isset($fieldData[$value]["data"]) != '') {

                            if (array_key_exists($fieldData[$value]["data"], $formatData)) {

                                $fieldData[$value]["data"] = $formatData[$fieldData[$value]["data"]];
                            }

                            $filterData['sortField'] = $fieldData[$value]["data"];
                            $filterData['sortOrder'] = $sortOrder;

                        }
                    }

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

    public function dateTimeDifferenceInHours($sartDateTime, $endDateTime)
    {

        $returnHours = "";

        try {

            $fromDateTime = new DateTime($sartDateTime, new DateTimeZone(env('APP_TIME_ZONE')));
            $toDateTime = new DateTime($endDateTime, new DateTimeZone(env('APP_TIME_ZONE')));
            $diff = $fromDateTime->diff($toDateTime);

            // $returnHours = $diff->format("%H:%I:%S");

            $returnHours = ($diff->days * 24) + $diff->h;

            // $returnHours = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;

        } catch (Exception $e) {

            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return $returnHours;

    }

    public function dateTimeDifferenceInMinutes($sartDateTime, $endDateTime)
    {

        $returnMinutes = "";

        try {

            $fromDateTime = new DateTime($sartDateTime, new DateTimeZone(env('APP_TIME_ZONE')));
            $toDateTime = new DateTime($endDateTime, new DateTimeZone(env('APP_TIME_ZONE')));
            $diff = $fromDateTime->diff($toDateTime);

            $returnMinutes = $diff->format("%H:%I:%S");

            // $returnMinutes = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;

        } catch (Exception $e) {

            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return $returnMinutes;

    }

    public function secondsToMinutes($seconds)
    {

        $returnMinutes = "";

        try {

            $hours = floor($seconds / 3600);
            $minutes = floor(((int)$seconds / 60) % 60);
            $seconds = $seconds % 60;

            // $returnMinutes = $hours . ":" . $minutes .":" . $seconds;

            $returnMinutes = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);

            // $returnMinutes = gmdate("H:i:s", $seconds);

        } catch (Exception $e) {

            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return $returnMinutes;


    }

    public function getClientIPaddress($request) {

        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP)){
            $clientIp = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP)){
            $clientIp = $forward;
        }
        else{
            $clientIp = $remote;
        }

        return $clientIp;

    }

}
