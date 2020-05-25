<?php

namespace App\Traits\General;

use Exception;
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

            $returnData .= ' changed the ' . $item["field_value"] . ' from ' . $item["original_value"] . ' to ' . $item["modified_value"];
        }

        $returnData .= '</span>';

        if (isset($item["title"]) && $item["title"] != "") {

            $returnData .= '<span>';

            // if (base64_decode($item["title"], true)) {

            //     $title = base64_decode($item["title"]);

            // } else {

            //     $title = $item["title"];

            // }

            $title = $item["title"];

            $returnData .= ' ' . $title;

            $returnData .= '</span>';

        } else {

            if (isset($item["additional_note"]) && $item["additional_note"] != "") {

                $returnData .= '<span>';

                $additionalNote = $item["additional_note"];

                $returnData .= ' ' . $additionalNote;

                $returnData .= '</span>';

            }

            if (isset($item["attachment_path"]) && $item["attachment_path"] != "") {

                $returnData .= '<p>';

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

                // return view('layout.login');
                redirect()->route("login");
            }

            if (!in_array(auth()->user()->role, config('constants.nonStakeHolderUserRoles'))) {

                if (isset($returnData["data"]["assignedto_empcode"]) && $returnData["data"]["assignedto_empcode"] != auth()->user()->empcode) {

                    // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($returnData);echo '<PRE/>';exit;

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
                case 'docx':
                case 'doc':
                    $type = 'word';
                    break;
                case 'xls':
                case 'xlsx':
                    $type = 'excel';
                    break;
                case 'mp3':
                case 'ogg':
                case 'wav':
                    $type = 'audio';
                    break;
                case 'mp4':
                case 'mov':
                    $type = 'video';
                    break;
                case 'zip':
                case '7z':
                case 'rar':
                    $type = 'archive';
                    break;
                case 'jpg':
                case 'jpeg':
                case 'png':
                    $type = 'image';
                    break;
                default:
                    $type = 'alt';
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


    // public function logData($message, $type)
    // {

    //     // create a log channel
    //     $logger = new Logger('app_log');
    //     // $logger->pushHandler(new StreamHandler('/path/to/app-log-' .date('Y-m-d'). '.log', Logger::WARNING));
    //     $logger->pushHandler(new StreamHandler('/path/to/app-log-' .date('Y-m-d'). '.log', $type));

    // }

}