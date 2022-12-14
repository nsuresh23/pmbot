<?php

namespace App\Http\Controllers\User;

use Exception;
use Illuminate\Http\Request;
use App\Traits\General\Helper;
use Illuminate\Support\Facades\Auth;
use App\Traits\General\CustomLogger;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Resources\User\UserCollection as UserResource;
use App\Resources\User\GroupCollection as GroupResource;
use App\Resources\User\RoleCollection as RoleResource;
use App\Resources\User\LocationCollection as LocationResource;

class UserController extends Controller
{

    use Helper;

    use CustomLogger;

    protected $userResource = "";
    protected $groupResource = "";
    protected $roleResource = "";
    protected $locationResource = "";

    protected $roleList = [
        "art" => "art",
        "admin" => "admin",
        "logistics" => "logistics",
        "production" => "production",
        "copy_editing" => "copy_editing",
        "account_manager" => "account_manager",
        "project_manager" => "project_manager",
    ];



    protected $locationList = [
        "pondy" => "pondy",
        "chennai" => "chennai"
    ];

    public function __construct()
    {

        $this->userResource = new UserResource();
        $this->groupResource = new GroupResource();
        $this->roleResource = new RoleResource();
        $this->locationResource = new LocationResource();

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
     * Show the user detail.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function users(Request $request)
    {

        $userData = [];

        try {

        } catch (Exception $e) {

            // return $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return view('pages.user.list', compact('userData'));
    }

    /**
     * Show the user detail.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function userList(Request $request)
    {

        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $field = [];

            $filterData = [];

            if (isset($request->filter) && is_array($request->filter) && count($request->filter) > 0) {

                $filterData = $request->filter;

                $formatData = [

                    // "subject_link" => "subject",

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

                if (array_key_exists("status", $filterData)) {

                    if ($filterData["status"] == "false") {

                        $filterData["status"] = "0";
                    }

                    if ($filterData["status"] == "true") {

                        $filterData["status"] = "1";
                    }

                }

                $field["filter"] = $filterData;

            }

            $field["empcode"] = auth()->user()->empcode;
            $field["role"] = auth()->user()->role;

            $returnResponse = $this->userResource->getAlluser($field);

            // if(is_array($responseData) && count($responseData) > 0) {

            //     $returnResponse["success"] = "true";
            //     $returnResponse["data"] = $responseData["data"];
            //     $returnResponse["message"] = "retrieved successfully";

            // }

        } catch (Exception $e) {

            // return $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                " => LINE => " . __LINE__ . " => " .
                " => MESSAGE => " . $e->getMessage() . " "
            );

            $returnResponse["error"] = "true";
            $returnResponse["message"] = $e->getMessage();

        }

        return $returnResponse;

    }


    /**
     * Get member list.
     *
     *  @return json response
     */
    public function memberList(Request $request)
    {

        try {

            $field = [];

            $returnResponse = [];

            $filterData = [];

            if (isset($request->filter) && is_array($request->filter) && count($request->filter) > 0) {

                $filterData = $request->filter;

                $formatData = [

                    // "subject_link" => "subject",

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

                $field["filter"] = $filterData;

            }

            $field["empcode"] = auth()->user()->empcode;
            $field["role"] = auth()->user()->role;

            if (count($field) > 0) {

                $returnResponse = $this->userResource->memberList($field);

            }

        } catch (Exception $e) {

            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        //if ($request->ajax()) {

        return $returnResponse;
        // return json_encode($returnResponse);
        //}

    }

    /**
     * Get the my history.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function myHistory(Request $request)
    {
        $returnResponse = [];

        $field = [];

        try {

            $field['empcode'] = auth()->user()->empcode;

            if (count($field) > 0) {

                $returnResponse = $this->userResource->myHistory($field);
            }
        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return json_encode($returnResponse);
    }

    /**
     * Show the user login history detail.
     *
     *  @return json response
     */
    public function userLoginHistory(Request $request)
    {

        try {

            $field = [];

            $returnResponse = [];

            $filterData = [];

            if (isset($request->filter) && is_array($request->filter) && count($request->filter) > 0) {

                $filterData = $request->filter;

                $formatData = [

                    // "subject_link" => "subject",

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

                $field["filter"] = $filterData;
            }

            if (isset($request->date) && $request->date != "") {

                $field["date"] = $request->date;

            }

            if (isset($request->empcode) && $request->empcode != "") {

                $field["empcode"] = $request->empcode;

            }

            $field["current_empcode"] = auth()->user()->empcode;

            $field["role"] = auth()->user()->role;

            if (count($field) > 0) {

                $returnResponse = $this->userResource->userLoginHistory($field);
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
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request Request
     * @return json response
     */
    public function userAdd(Request $request)
    {

        $userData = [];

        try {

            $roleField = [

                ["status", true]

            ];

            $groupField = [

                ["status", true]

            ];

            $locationField = [

                ["status", true]

            ];

            $userData["role_list"] = Config::get('constants.roleList');
            $userData["user_list"] = $this->userResource->getActiveUserList();

            // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($userData);echo '<PRE/>';exit;
            // $userData["role_list"] = $this->roleResource->getActiveRoles();
            // $userData["group_list"] = $this->groupResource->getActiveGroups();
            // $userData["location_list"] = $this->locationResource->getActiveLocations();
            $userData["location_list"] = Config::get('constants.locationList');

        } catch (Exception $e) {

            // return $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($userData);echo '<PRE/>';exit;
        return view('pages.user.user', compact("userData"));
    }

    /**
     * Show user edit page based on user id.
     *
     * @param \Illuminate\Http\Request Request
     * @return array $userData
     */
    public function userEdit(Request $request)
    {

        $userData = [];

        try {

            if($request->id != "") {

                $field = [

                    // ['empcode', $request->id]
                    'empcode' => $request->id

                ];

                $userData["data"] = $this->userResource->getUser($field);
                $userData["role_list"] = Config::get('constants.roleList');
                $userData["location_list"] = Config::get('constants.locationList');
                $userData["user_list"] = $this->userResource->getActiveUserList();

                if (isset($userData["user_list"]) && is_array($userData["user_list"]) && isset($userData["user_list"][$request->id])) {

                    unset($userData["user_list"][$request->id]);
                }


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

        return view('pages.user.user', compact("userData"));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request Request
     * @return json response
     */
    public function userStore(Request $request)
    {

        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "message" => ""
        ];

        $status = $lead_pm = $spi_status = $daily_status_report = "0";

        try {

            if ($request->get('status') == "on") {

                $status = "1";

            }

            $request->merge(['status' => $status]);

            if ($request->get('lead_pm') == "on") {

                $lead_pm = "1";
            }

            $request->merge(['lead_pm' => $lead_pm]);

            if ($request->get('spi_status') == "on") {

                $spi_status = "1";
            }

            $request->merge(['spi_status' => $spi_status]);

            if ($request->get('daily_status_report') == "on") {

                $daily_status_report = "1";
            }

            $request->merge(['daily_status_report' => $daily_status_report]);

            // if ($request->email) {

            //     $request->merge(['empcode' => strtolower($request->email)]);
            // }

            if (auth()->check()) {

                $request->merge(['creator_empcode' => auth()->user()->empcode]);

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $request->merge(['creator_empcode' => session()->get("current_empcode")]);

                }

            }

            // $responseData = $this->userResource->userAdd($request);
            $returnData = $this->userResource->userAdd($request);

            if(is_array($returnData) && count($returnData)) {

                $returnResponse = $returnData;

            }

        } catch (Exception $e) {

            // return $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );

            $returnResponse["error"] = "true";
            $returnResponse["message"] = $e->getMessage();

        }

        $redirecturl = redirect()->action('User\UserController@users');

        return $redirecturl->with(["success" => $returnResponse["success"], "error" => $returnResponse["error"], "message" => $returnResponse["message"]]);

        // return json_encode($returnResponse);
    }

    /**
     * Update user in users table by user id.
     *
     * @param \Illuminate\Http\Request Request
     * @return json response
     */
    public function userUpdate(Request $request)
    {

        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "message" => ""
        ];

        try {

            $status = $lead_pm = $spi_status = $daily_status_report = "0";

            if ($request->get('status') == "on") {

                $status = "1";

            }

            $request->merge(['status' => $status]);

            if ($request->get('lead_pm') == "on") {

                $lead_pm = "1";
            }

            $request->merge(['lead_pm' => $lead_pm]);

            if ($request->get('spi_status') == "on") {

                $spi_status = "1";
            }

            $request->merge(['spi_status' => $spi_status]);

            if ($request->get('daily_status_report') == "on") {

                $daily_status_report = "1";
            }

            $request->merge(['daily_status_report' => $daily_status_report]);

            if (auth()->check()) {

                $request->merge(['creator_empcode' => auth()->user()->empcode]);

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $request->merge(['creator_empcode' => session()->get("current_empcode")]);

                }

            }

            $request = $this->formatHistoryData($request, "history", "~");

            $returnData = $this->userResource->userEdit($request);

            if(is_array($returnData) && count($returnData)) {

                $returnResponse = $returnData;

            }

        } catch (Exception $e) {

            // return $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );

            $returnResponse["error"] = "true";
            $returnResponse["message"] = $e->getMessage();
        }

        $redirecturl = redirect()->action('User\UserController@users');

        return $redirecturl->with(["success" => $returnResponse["success"], "error" => $returnResponse["error"], "message"=> $returnResponse["message"]]);

        // return json_encode($returnResponse);
    }

    /**
     * User login.
     *
     * @param \Illuminate\Http\Request Request
     * @return json response
     */
    public function login(Request $request)
    {

        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => [],
            "message" => "",
        ];

        try {

            if (isset($request->email_or_username) && $request->email_or_username != "" && isset($request->ldap_password) && $request->ldap_password != "") {

                $param = [
                    "empcode" => strtolower(trim($request->email_or_username)),
                    "password" => base64_encode($request->ldap_password),
                    "ipaddress" => $_SERVER["REMOTE_ADDR"],
                ];

                // $this->info("app_data_" . date('Y-m-d'), json_encode($request->all()));

                $responseData = $this->userResource->login($param);

                if(isset($responseData["success"]) && $responseData["success"] == "true") {

                    $returnResponse["success"] = "true";

                    if(isset($responseData["data"]) && $responseData["data"] != "") {

                        $returnResponse["data"] = $responseData["data"];

                        if (isset($responseData["data"]["code"]) && $responseData["data"]["code"] != "") {

                            $loginStatusCodes = Config::get("constants.login_error_codes");

                            if(in_array($responseData["data"]["code"], array_keys($loginStatusCodes))) {

                                if ($responseData["data"]["code"] == "1" && isset($responseData["data"]["empcode"]) && $responseData["data"]["empcode"] != "") {

                                    $conditions = [
                                        ['empcode', $responseData["data"]["empcode"]],
                                    ];

                                    $fields = ['id'];

                                    $userData = [];

                                    $userData = $this->userResource->getUserField($conditions, $fields);

                                    if (isset($userData->id) && $userData->id != "") {

                                        $rememberMe = true;

                                        Auth::loginUsingId($userData->id, $rememberMe);

                                    }

                                } else {

                                    $returnResponse["message"] = $loginStatusCodes[$responseData["data"]["code"]];

                                }

                            }

                        }

                    }

                }

                if(isset($responseData["message"]) && $responseData["message"] != "") {

                    $returnResponse["message"] = $responseData["message"];

                }

            }

        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();

            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );

        }

        return json_encode($returnResponse);

    }

    /**
     * User multi factor authentication.
     *
     * @param \Illuminate\Http\Request Request
     * @return json response
     */
    public function mfa(Request $request)
    {

        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => [],
            "message" => "",
        ];

        try {

            if (isset($request->email_or_username) && $request->email_or_username != "" && isset($request->ldap_password) && $request->ldap_password != "") {

                $param = [
                    "empcode" => strtolower(trim($request->email_or_username)),
                    "mfa_code" => $request->mfa_code,
                    "ipaddress" => $request->ip(),
                ];

                $responseData = $this->userResource->mfa($param);

                if(isset($responseData["success"]) && $responseData["success"] == "true") {

                    $returnResponse["success"] = "true";

                    if(isset($responseData["data"]) && $responseData["data"] != "") {

                        $returnResponse["data"] = $responseData["data"];

                        if (isset($responseData["data"]["code"]) && $responseData["data"]["code"] != "") {

                            $loginStatusCodes = Config::get("constants.login_error_codes");

                            if(in_array($responseData["data"]["code"], array_keys($loginStatusCodes))) {

                                if ($responseData["data"]["code"] == "1" && isset($responseData["data"]["empcode"]) && $responseData["data"]["empcode"] != "") {

                                    $conditions = [
                                        ['empcode', $responseData["data"]["empcode"]],
                                    ];

                                    $fields = ['id'];

                                    $userData = [];

                                    $userData = $this->userResource->getUserField($conditions, $fields);

                                    if (isset($userData->id) && $userData->id != "") {

                                        $rememberMe = true;

                                        Auth::loginUsingId($userData->id, $rememberMe);

                                    }

                                } else {

                                    $returnResponse["message"] = $loginStatusCodes[$responseData["data"]["code"]];

                                }

                            }

                        }

                    }

                }

                if(isset($responseData["message"]) && $responseData["message"] != "") {

                    $returnResponse["message"] = $responseData["message"];

                }

            }

        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();

            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );

        }

        return json_encode($returnResponse);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getEventCalendar(Request $request)
    {

        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => [],
            "message" => "",
        ];

        try {

            $returnData = [];

            $returnResponse["data"]["calendar_link"] = "";

            $returnData = $this->userResource->getUser(["empcode" => auth()->user()->empcode]);

            $returnResponse["success"] = "true";

            if (is_array($returnData) && isset($returnData["calendar_link"]) ) {

                if($returnData["calendar_link"] != null && $returnData["calendar_link"] != "") {

                    $returnResponse["data"]["calendar_link"] = $returnData["calendar_link"];

                }

            }
        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                " => LINE => " . __LINE__ . " => " .
                " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return json_encode($returnResponse);

    }

    /**
     * Update user event calendar in users table by user empcode.
     *
     * @param \Illuminate\Http\Request Request
     * @return json response
     */
    public function userEventCalendarUpdate(Request $request)
    {

        try {

            $request->merge(['empcode' => auth()->user()->empcode]);

            if (auth()->check()) {

                $request->merge(['creator_empcode' => auth()->user()->empcode]);

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $request->merge(['creator_empcode' => session()->get("current_empcode")]);
                }
            }

            $returnResponse = $this->userResource->eventCalendarUpdate($request);

        } catch (Exception $e) {

            // return $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                " => LINE => " . __LINE__ . " => " .
                " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return json_encode($returnResponse);

    }

    /**
     * Delete user in users table by user id.
     *
     * @param \Illuminate\Http\Request Request
     * @return json response
     */
    public function userDelete(Request $request)
    {

        try {

            if (auth()->check()) {

                $request->merge(['creator_empcode' => auth()->user()->empcode]);

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $request->merge(['creator_empcode' => session()->get("current_empcode")]);

                }

            }

            $returnResponse = $this->userResource->userDelete($request);

            if (isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

                $returnResponse["data"] = $this->userResource->getAllUser();
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

        return json_encode($returnResponse);
    }

    /**
     * Show user edit page based on user id.
     *
     * @param \Illuminate\Http\Request Request
     * @return array $userData
     */
    public function userPasswordUpdate(Request $request)
    {

        $userData = [];
        try {

            $userData["data"]["id"] = "";

            if ($request->id != "") {

                $userData["data"]["id"] = $request->id;

                if(!in_array(auth()->user()->role, Config::get('constants.amUserRoles')) && !in_array(auth()->user()->role, Config::get('constants.adminUserRoles')) && auth()->user()->empcode != $request->id) {

                    return view("errors.error401");

                }

                if ($request->isMethod('post')) {

                    if (auth()->check()) {

                        $request->merge(['creator_empcode' => auth()->user()->empcode]);

                        if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                            $request->merge(['creator_empcode' => session()->get("current_empcode")]);

                        }

                    }

                    $returnResponse = $this->userResource->changePassword($request);

                    if(in_array(auth()->user()->role, Config::get("constants.amUserRoles"))) {

                        $redirecturl = redirect()->action('User\UserController@users');

                    } else {

                        Auth::logout();

                        return redirect('login')->with(["success" => $returnResponse["success"], "error" => $returnResponse["error"], "message" => $returnResponse["message"]]);

                    }

                    return $redirecturl->with(["success" => $returnResponse["success"], "error" => $returnResponse["error"], "message" => $returnResponse["message"]]);

                }
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

        return view('pages.user.userChangePassword', compact("userData"));
    }

    /**
     * Show user outlook mac id edit page based on user id.
     *
     * @param \Illuminate\Http\Request Request
     * @return array $userData
     */
    public function userMacId(Request $request)
    {

        $userData = [];

        try {

            if ($request->id != "") {

                $field = [

                    'empcode' => $request->id

                ];

                $userData["data"] = $this->userResource->getUser($field);

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

        return view('pages.user.userMacId', compact("userData"));
    }

    /**
     * Update user outlook mac id based on user id.
     *
     * @param \Illuminate\Http\Request Request
     * @return array $userData
     */
    public function userMacIdUpdate(Request $request)
    {

        $userData = [];

        try {

            if ($request->isMethod('post')) {

                if (auth()->check()) {

                    // $request->merge(['creator_empcode' => auth()->user()->empcode]);

                    if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                        $request->merge(['creator_empcode' => session()->get("current_empcode")]);
                    }
                }

                $returnResponse = $this->userResource->updateMacId($request);

                /* session()->flash("success", $returnResponse["success"]);
                session()->flash("error", $returnResponse["error"]);
                session()->flash("message", $returnResponse["message"]); */

                // $redirecturl = redirect()->action('PM\DashboardController@index');
                // $redirecturl = redirect()->action('User\UserController@userMacId');

                $redirecturl = redirect()->route(__("user.user_mac_id_url"), $request->empcode);

                return $redirecturl->with(["success" => $returnResponse["success"], "error" => $returnResponse["error"], "message" => $returnResponse["message"]]);

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

        return view('pages.user.userMacId', compact("userData"));

    }

    /**
     * Change user password.
     *
     * @param \Illuminate\Http\Request Request
     * @return json response
     */

    public function changePassword(Request $request)
    {
        $validator = array();
        $succ_msg  = '';
        $old_pass  = '';
        if ($request->isMethod('post')) {
            $valid_arr = array(
                'password'     => 'required|min:6',
                'password_confirmation' => 'required|same:password'
            );
            $custmsg['password_confirmation.same'] = 'The password and confirmation password do not match';
            $validator = Validator::make($request->all(), $valid_arr, $custmsg);

            $data = $request->all();
            $old_pass  = $data['password'];
            $user = User::find(Auth::user()->id);
            if (!$validator->fails()) {
                if (!Hash::check($data['old_password'], $user->password)) {
                    $fails = $validator->fails(); // true
                    $failedMessages = $validator->failed(); // h
                    $validator->errors()->add('old_password', 'The specified password does not match the database password');
                } else {
                    // code to update password
                    $user->password = bcrypt($data["password"]);
                    $user->save();
                    $succ_msg = 'Password changed successfully';
                }
            }
        }
        return view('user.changepassword', array("successmsg" => $succ_msg, 'old_pass' => $old_pass, 'page_title' => 'Change Password'))->withErrors($validator);
        exit;
    }

    /**
     * Show the user group detail.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function groupList(Request $request)
    {

        $responseData = $this->groupResource->getAllGroup();

        $groupData = [

            "data" => $responseData

        ];

        if ($request->ajax()) {

            $returnResponse = [
                "success" => "false",
                "error" => "false",
                "data" => "",
                "message" => "",
            ];

            if ($responseData) {

                $returnResponse["success"] = "true";
                $returnResponse["data"] = $responseData;
                $returnResponse["message"] = "retrieved successfully";
            }

            return json_encode($returnResponse);
        }

        return view('pages.user.list', compact('groupData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return json response
     */
    public function groupAdd(Request $request)
    {

        // $responseData = $this->groupResource->groupAdd($request);
        $returnResponse = $this->groupResource->groupAdd($request);

        if (isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

            $returnResponse["data"] = $this->groupResource->getAllGroup();

        }

        return json_encode($returnResponse);

    }

    /**
     * Edit group in user_group table by group id.
     *
     * @return json response
     */
    public function groupEdit(Request $request)
    {

        $returnResponse = $this->groupResource->groupEdit($request);

        if (isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

            $returnResponse["data"] = $this->groupResource->getAllGroup();

        }

        return json_encode($returnResponse);
    }

    /**
     * Delete group in user_group table by group id.
     *
     * @return json response
     */
    public function groupDelete(Request $request)
    {

        $returnResponse = $this->groupResource->groupDelete($request);

        if (isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

            $returnResponse["data"] = $this->groupResource->getAllGroup();

        }

        return json_encode($returnResponse);
    }

    /**
     * get active user groups.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getActiveGroups(Request $request)
    {

        $responseData = $this->roleResource->getActiveGroups();

        $groupData = [

            "data" => $responseData

        ];

        if ($request->ajax()) {

            $returnResponse = [
                "success" => "false",
                "error" => "false",
                "data" => "",
                "message" => "",
            ];

            if ($responseData) {

                $returnResponse["success"] = "true";
                $returnResponse["data"] = $responseData;
                $returnResponse["message"] = "retrieved successfully";
            }

            return json_encode($returnResponse);
        }

        return view('pages.user.list', compact('groupData'));
    }

    /**
     * Show the user role detail.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function roleList(Request $request)
    {

        $responseData = $this->roleResource->getAllRole();

        $roleData = [

            "data" => $responseData

        ];

        if ($request->ajax()) {

            $returnResponse = [
                "success" => "false",
                "error" => "false",
                "data" => "",
                "message" => "",
            ];

            if ($responseData) {

                $returnResponse["success"] = "true";
                $returnResponse["data"] = $responseData;
                $returnResponse["message"] = "retrieved successfully";
            }

            return json_encode($returnResponse);
        }

        return view('pages.user.list', compact('roleData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return json response
     */
    public function roleAdd(Request $request)
    {

        // $responseData = $this->roleResource->roleAdd($request);
        $returnResponse = $this->roleResource->roleAdd($request);

        if (isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

            $returnResponse["data"] = $this->roleResource->getAllRole();

        }

        return json_encode($returnResponse);
    }

    /**
     * Edit role in user_role table by role id.
     *
     * @return json response
     */
    public function roleEdit(Request $request)
    {

        $returnResponse = $this->roleResource->roleEdit($request);

        if (isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

            $returnResponse["data"] = $this->roleResource->getAllRole();

        }

        return json_encode($returnResponse);
    }

    /**
     * Delete role in user_role table by role id.
     *
     * @return json response
     */
    public function roleDelete(Request $request)
    {

        $returnResponse = $this->roleResource->roleDelete($request);

        if (isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

            $returnResponse["data"] = $this->roleResource->getAllRole();

        }

        return json_encode($returnResponse);
    }

    /**
     * get active user roles.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getActiveRoles(Request $request)
    {

        $responseData = $this->roleResource->getActiveRoles();

        $roleData = [

            "data" => $responseData

        ];

        if ($request->ajax()) {

            $returnResponse = [
                "success" => "false",
                "error" => "false",
                "data" => "",
                "message" => "",
            ];

            if ($responseData) {

                $returnResponse["success"] = "true";
                $returnResponse["data"] = $responseData;
                $returnResponse["message"] = "retrieved successfully";
            }

            return json_encode($returnResponse);
        }

        return view('pages.user.list', compact('roleData'));
    }

    /**
     * Show the user location detail.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function locationList(Request $request)
    {

        $responseData = $this->locationResource->getAllLocation();

        $locationData = [

            "data" => $responseData

        ];

        if ($request->ajax()) {

            $returnResponse = [
                "success" => "false",
                "error" => "false",
                "data" => "",
                "message" => "",
            ];

            if ($responseData) {

                $returnResponse["success"] = "true";
                $returnResponse["data"] = $responseData;
                $returnResponse["message"] = "retrieved successfully";
            }

            return json_encode($returnResponse);
        }

        return view('pages.user.list', compact('locationData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return json response
     */
    public function locationAdd(Request $request)
    {

        $returnResponse = $this->locationResource->locationAdd($request);

        if (isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

            $returnResponse["data"] = $this->locationResource->getAllLocation();

        }

        return json_encode($returnResponse);
    }

    /**
     * Edit location in user_location table by location id.
     *
     * @return json response
     */
    public function locationEdit(Request $request)
    {

        $returnResponse = $this->locationResource->locationEdit($request);

        if (isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

            $returnResponse["data"] = $this->locationResource->getAllLocation();
        }

        return json_encode($returnResponse);
    }

    /**
     * Delete location in user_location table by location id.
     *
     * @return json response
     */
    public function locationDelete(Request $request)
    {

        $returnResponse = $this->locationResource->locationDelete($request);

        if (isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

            $returnResponse["data"] = $this->locationResource->getAllLocation();
        }

        return json_encode($returnResponse);
    }

    /**
     * get active user locations.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getActiveLocations(Request $request)
    {

        $responseData = $this->LocationResource->getActiveLocations();

        $groupData = [

            "data" => $responseData

        ];

        if ($request->ajax()) {

            $returnResponse = [
                "success" => "false",
                "error" => "false",
                "data" => "",
                "message" => "",
            ];

            if ($responseData) {

                $returnResponse["success"] = "true";
                $returnResponse["data"] = $responseData;
                $returnResponse["message"] = "retrieved successfully";
            }

            return json_encode($returnResponse);
        }

        return view('pages.user.list', compact('locationData'));
    }

}
