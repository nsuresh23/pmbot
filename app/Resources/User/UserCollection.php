<?php

namespace App\Resources\User;

use Exception;

use App\Models\User;

use League\Fractal\Manager;

use App\Traits\General\Helper;

use App\Traits\General\ApiClient;

use App\Traits\General\CustomLogger;

use League\Fractal\Resource\Collection;

use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Boolean;

use App\Resources\User\GroupCollection as GroupResource;
use App\Resources\User\RoleCollection as RoleResource;

class UserCollection
{

    use Helper;

    use ApiClient;

    use CustomLogger;

    protected $fractal;
    protected $groupResource = "";
    protected $userResource = "";
    protected $userLoginApiUrl;
    protected $userListApiUrl;
    protected $myHistoryApiUrl;
    protected $userByFieldApiUrl;
    protected $userAddApiUrl;
    protected $userUpdateApiUrl;
    protected $userPasswordUpdateApiUrl;
    protected $userDeleteApiUrl;
    protected $userSelectApiUrl;
    protected $memberSelectApiUrl;
    protected $userListSelectApiUrl;
    protected $memberListApiUrl;
    protected $pmUserSelectApiUrl;
    protected $loginHistoryApiUrl;
    protected $userLoginHistoryReportApiUrl;
    protected $userMacIdUpdateApiUrl;
    protected $userMFAApiUrl;

    public function __construct()
    {

        $this->fractal = new Manager();
        $this->groupResource = new GroupResource();
        $this->roleResource = new RoleResource();
        $this->userLoginApiUrl = env('API_USER_LOGIN_URL');
        $this->userListApiUrl = env('API_USER_LIST_URL');
        $this->myHistoryApiUrl = env('API_MY_HISTORY_URL');
        $this->userByFieldApiUrl = env('API_USER_BY_FIELD_URL');
        $this->userAddApiUrl = env('API_USER_ADD_URL');
        $this->userUpdateApiUrl = env('API_USER_EDIT_URL');
        $this->userPasswordUpdateApiUrl = env('API_USER_PASSWORD_UPDATE_URL');
        $this->userDeleteApiUrl = env('API_USER_DELETE_URL');
        $this->userSelectApiUrl = env('API_USER_SELECT_URL');
        $this->memberSelectApiUrl = env('API_MEMBER_SELECT_URL');
        $this->userListSelectApiUrl = env('API_USER_LIST_SELECT_URL');
        $this->pmUserSelectApiUrl = env('API_PM_USER_SELECT_URL');
        $this->memberListApiUrl = env('API_MEMBER_LIST_URL');
        $this->loginHistoryApiUrl = env('API_USER_HISTORY_URL');
        $this->userLoginHistoryReportApiUrl = env('API_USER_LOGIN_HISTORY_URL');
        $this->userMacIdUpdateApiUrl = env('API_USER_MAC_ID_UPDATE_URL');
        $this->userMFAApiUrl = env('API_USER_MFA_URL');

    }

    /**
     * Get the users from the users Table.
     *
     * @return array $userData
     */
    public function getAllUser($field)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            // $userData = User::all();

            $url = $this->userListApiUrl;

            $responseData = $this->postRequest($url, $field);

            if ($responseData["success"] == "true" && count($responseData["data"]) > 0 && $responseData["data"] != "") {

                $responseFormatData = $this->formatData($responseData["data"]);

                if ($responseFormatData) {

                    $returnResponse["success"] = "true";
                    $returnResponse["message"] = "Retrieved successfully";
                    $returnResponse["data"] = $responseFormatData;

                }

                if (isset($responseData["result_count"]) && $responseData["result_count"] != "") {

                    $returnResponse["result_count"] = $responseData["result_count"];

                } else if (is_array($responseFormatData)) {

                    $returnResponse["result_count"] = count($responseFormatData);

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

            $returnResponse["error"] = "true";
            $returnResponse["message"] = $e->getMessage();

        }

        return $returnResponse;
    }

    /**
     * Get the my history by user field array.
     *
     * @param  array $field
     * @return array $returnResponse
     */
    public function myHistory($field)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $url = $this->myHistoryApiUrl;

            $responseData = $this->postRequest($url, $field);

            if ($responseData["success"] == "true" && isset($responseData["data"]) && is_array($responseData["data"]) && count($responseData["data"]) > 0 && $responseData["data"] != "") {

                $responseData = $this->formatUserActivityData($responseData["data"]);

                if ($responseData) {

                    $returnResponse["success"] = "true";
                    $returnResponse["data"] = $responseData;
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

        return $returnResponse;
    }

    /**
     * format result.
     *
     * @return array $resource
     */
    public function formatUserActivityData($items)
    {

        $returnData = array_map(

            function ($item) {

                $item['diary_view'] = $this->userActiondiaryView($item);

                return $item;

            },
            $items
        );

        if (count($returnData) > 0) {

            $returnData = implode("", array_column($returnData, "diary_view"));
        }

        return $returnData;

    }

    /**
     * format my history result.
     *
     * @return array $resource
     */
    public function formatMyHistoryData($items)
    {

        $returnData = [];

        if (count($items) > 0) {

            array_walk(

                $items,

                function ($item, $key) use (&$returnData) {

                    if (count($item) > 0) {

                        array_walk($item, function ($value, $key) use (&$returnData) {

                            $value["diary_view"] = $this->diaryView($value);

                            array_push($returnData, $value);

                        });
                    }
                }

            );
        }

        if (count($returnData) > 0) {

            usort($returnData, function ($a, $b) {

                if (isset($a['created_date']) && isset($b['created_date'])) {

                    $t1 = strtotime($a['created_date']);
                    $t2 = strtotime($b['created_date']);

                    // return $t1 - $t2;
                    return $t2 - $t1;
                }
            });
        }

        if (count($returnData) > 0) {

            $returnData = implode("", array_column($returnData, "diary_view"));
        }

        return $returnData;

    }

    /**
     * Get the list of user login history report.
     *
     * @return array $returnData
     */
    public function userLoginHistory($params)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $paramInfo = [];

            $paramInfo = $params;

            $url = $this->userLoginHistoryReportApiUrl;

            $responseData = $this->postRequest($url, $paramInfo);

            if ($responseData["success"] == "true" && is_array($responseData["data"]) && count($responseData["data"]) > 0 && $responseData["data"] != "") {

                $responseFormatData = $this->userLoginHistoryReportFormatData($responseData["data"]);

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
     * format user login history result.
     *
     * @return array $resource
     */
    public function userLoginHistoryReportFormatData($items)
    {

        $s_no = 0;

        $resource = array_map(

            function ($item) use (&$s_no) {

                if (is_array($item) && count($item)) {

                    $s_no = $s_no + 1;

                    $item["s_no"] = $s_no;
                }

                return $item;

            },
            $items

        );

        return $resource;
    }

    /**
     * Add the user to the users Table.
     *
     * @return array $returnResponse
     */
    public function userAdd($request)
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
                'empname'       => 'required',
                'empcode'       => 'required',
                'email'       => 'required',
                // 'password'       => 'required',
                'role'       => 'required',
                'location'       => 'required',
                'status'       => 'required',
                'spi_status'       => 'required',
                'daily_status_report'       => 'required'
            );
            $validator = Validator::make($request->all(), $rules);

            // process the login
            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Save failed";

                // return Redirect::to('nerds/create')
                //     ->withErrors($validator)
                //     ->withInput(Input::except('password'));

            } else {

                // // store
                // $user = new User;
                // $user->empname = $request->get('empname');
                // $user->empcode = $request->get('empcode');
                // $user->email = $request->get('email');
                // // $user->password = bcrypt($request->get('password'));
                // $user->password = md5($request->get('password'));
                // $user->role = $request->get('role');
                // $user->location = $request->get('location');

                // if ($request->get('cisco')) {

                //     $user->cisco = $request->get('cisco');
                // }

                // if ($request->get('mobile')) {

                //     $user->mobile = $request->get('mobile');
                // }

                // $user->status = $request->get('status');

                // $userInfo = $user;

                // $userInfo = $userInfo->toArray();

                $userInfo = [];

                $userInfo = $request->all();

                if(isset($userInfo["_token"]) && $userInfo["_token"] != "") {

                    unset($userInfo["_token"]);

                }

                if (isset($userInfo["empcode"]) && $userInfo["empcode"] != "") {

                    $userInfo["empcode"] = strtolower(trim($userInfo["empcode"]));

                    $userInfo["spi_empcode"] = $userInfo["empcode"];

                }

                if (isset($userInfo["email"]) && $userInfo["email"] != "") {

                    $userInfo["email"] = strtolower(trim($userInfo["email"]));

                }

                // $userInfo["password"] = md5($userInfo["password"]);

                $url = $this->userAddApiUrl;

                $returnData = $this->postRequest($url, $userInfo);

                if (isset($returnData["success"]) && $returnData["success"] == "true") {

                    // if ($user->save()) {

                        $returnResponse["success"] = "true";
                        $returnResponse["message"] = "Save successfull";
                    // } else {

                    //     $returnResponse["error"] = "true";
                    //     $returnResponse["message"] = "Save unsuccessfull";
                    // }

                } else {

                    $returnResponse["error"] = "true";
                    $returnResponse["message"] = "Save unsuccessfull";
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
     * Edit the user in users table based on user id.
     *
     * @return array $returnResponse
     */
    public function userEdit($request)
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
                // 'id'       => 'required',
                'empname'       => 'required',
                //'empcode'       => 'required',
                //'email'       => 'required',
                'role'       => 'required',
                'location'       => 'required',
                'status'       => 'required',
                'spi_status'       => 'required',
                'daily_status_report'       => 'required'
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Update failed";

            } else {


                // $conditions = [

                //     ['empcode', $request->get('empcode')],
                // ];

                // $fields = ['id'];

                // $user = $this->getUserField($conditions, $fields);

                // // update
                // // $user = new User;
                // // $user = User::find($request->get('id'));
                // $user->empname = $request->get('empname');
                // $user->empcode = $request->get('empcode');
                // $user->email = $request->get('email');
                // $user->role = $request->get('role');
                // $user->location = $request->get('location');

                // if($request->get('cisco')) {

                //     $user->cisco = $request->get('cisco');
                // }

                // if ($request->get('mobile')) {

                //     $user->mobile = $request->get('mobile');
                // }

                // // if (isset($request->updated_at)) {

                // //     unset($request['updated_at']);

                // // }

                // $user->status = $request->get('status');

                // $userInfo = $user;

                // $userInfo = $userInfo->toArray();

                // unset($userInfo["id"]);

                $userInfo = [];

                $userInfo = $request->all();

                if (isset($userInfo["_token"]) && $userInfo["_token"] != "") {

                    unset($userInfo["_token"]);
                }

                $url = $this->userUpdateApiUrl;

                $returnData = $this->postRequest($url, $userInfo);

                if (isset($returnData["success"]) && $returnData["success"] == "true") {

                    // if ($user->save()) {

                        $returnResponse["success"] = "true";
                        $returnResponse["message"] = "Update successfull";

                    // } else {

                    //     $returnResponse["error"] = "true";
                    //     $returnResponse["message"] = "Update unsuccessfull";
                    // }

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
     * Update the user calendar link in users table based on user id.
     *
     * @return array $returnResponse
     */
    public function eventCalendarUpdate($request)
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
                'empcode'       => 'required',
                'calendar_link'       => 'required'
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Update failed";
            } else {

                $userInfo = [];

                $userInfo = $request->all();

                if (isset($userInfo["_token"]) && $userInfo["_token"] != "") {

                    unset($userInfo["_token"]);
                }

                $url = $this->userUpdateApiUrl;

                $returnData = $this->postRequest($url, $userInfo);

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
     * Delete the user in users table based on user id.
     *
     * @return array $returnResponse
     */
    public function userDelete($request)
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
                'id'       => 'required'
            );
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Inactive failed";
            } else {

                // delete
                $conditions = [
                    ['empcode', $request->get('id')],
                ];

                $url = $this->userDeleteApiUrl;

                $returnData = $this->postRequest($url, ['empcode' => $request->get('id')]);

                if (isset($returnData["success"]) && $returnData["success"] == "true") {

                    // delete

                    // $fields = ['id'];

                    // $user = $this->getUserField($conditions, $fields);

                    // $user->status = "0";

                    // if ($user->save()) {

                        $returnResponse["success"] = "true";
                        $returnResponse["message"] = "Inactive successfull";

                    // } else {

                    //     $returnResponse["error"] = "true";
                    //     $returnResponse["message"] = "Delete unsuccessfull";
                    // }

                } else {

                    $returnResponse["error"] = "true";
                    $returnResponse["message"] = "Delete unsuccessfull";
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
     * Get the user from the users Table by user field array.
     *
     * @param  array $field
     * @return array $userData
     */
    public function getUser($field)
    {
        $userData = "";

        try {

            $url = $this->userByFieldApiUrl;

            $returnData = $this->postRequest($url, $field);

            if (isset($returnData["success"]) && $returnData["success"] == "true") {

                $userData = $returnData["data"];

                // if(isset($userData['members']) && is_array($userData['members']) && count($userData['members']) > 0) {

                //     $memberList = explode(",", $userData['members'][0]);
                //     array_walk($memberList, function ($arr) {
                //         return trim($arr, "'");
                //     });
                //     $userData['members'] = $memberList;

                // }

                // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($userData);echo '<PRE/>';exit;

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

        return $userData;
    }

    /**
     * Get the user from the users Table by user field array.
     *
     * @param  array $field
     * @return array $userData
     */
    public function getUserField($conditions, $fields)
    {
        $userData = "";

        try {

            // $conditions = [
            //     ['name', 'test'],
            //     ['id', '<>', '5']
            // ];

            // $fields = [
            //     ['id', 'name'],
            // ];

            // $userData = User::where($conditions)->get($fields);
            $userData = User::where($conditions)->first($fields);



        } catch (Exception $e) {

            // return $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return $userData;
    }

    /**
     * Get the active users from the users Table.
     *
     * @return array $userData
     */
    public function getActiveUsers()
    {
        $returnData = [];

        try {

            // $userData = User::all();

            $url = $this->userSelectApiUrl;

			$params = ["empcode" => auth()->user()->empcode];

            $userData = $this->postRequest($url,$params);

            if ($userData["success"] == "true" && count($userData["data"]) > 0 && $userData["data"] != "") {

                $returnData = $userData["data"];

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

        return $returnData;
    }

    /**
     * Get the list of active users from the users Table.
     *
     * @return array $userData
     */
    public function getActiveUserList()
    {
        $returnData = [];

        try {

            // $userData = User::all();

            $url = $this->userListSelectApiUrl;

            $params = ["empcode" => auth()->user()->empcode, "role" => auth()->user()->role];

            $userData = $this->postRequest($url, $params);

            if ($userData["success"] == "true" && count($userData["data"]) > 0 && $userData["data"] != "") {

                $returnData = $userData["data"];

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

        return $returnData;
    }

    /**
     * Get the active users from the users Table.
     *
     * @return array $userData
     */
    public function getPMUsers()
    {
        $returnData = [];

        try {

            // $userData = User::all();

            $url = $this->pmUserSelectApiUrl;

            $userData = $this->getRequest($url);

            if ($userData["success"] == "true" && count($userData["data"]) > 0 && $userData["data"] != "") {

                $returnData = $userData["data"];
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

        return $returnData;
    }

    /**
     * Get the active members from the users Table by field array.
     *
     * @return array $userData
     */
    public function userMembersSelect()
    {
        $returnData = [];

        try {


            $url = $this->memberSelectApiUrl;

            $params = ["empcode" => auth()->user()->empcode, "role" => auth()->user()->role];

            $userData = $this->postRequest($url,$params);

            if ($userData["success"] == "true" && count($userData["data"]) > 0 && $userData["data"] != "") {

                $returnData = $userData["data"];

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

        return $returnData;
    }

    /**
     * Get the members of the user.
     *
     * @return array $userData
     */
    public function memberList($request)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $url = $this->memberListApiUrl;

            $responseData = $this->postRequest($url, $request);

            if ($responseData["success"] == "true") {

                $returnResponse["success"] = "true";

                if (isset($responseData["data"]) &&  $responseData["data"] == "") {

                    $responseData["data"] = [];
                }

                if (isset($responseData["data"]) && is_array($responseData["data"]) && count($responseData["data"]) > 0) {

                    $responseFormatData = $this->formatMembersData($responseData["data"], $request);

                    if ($responseFormatData) {

                        $returnResponse["data"] = $responseFormatData;

                        if (isset($responseData["result_count"]) && $responseData["result_count"] != "") {

                            $returnResponse["result_count"] = $responseData["result_count"];

                        } else if (is_array($responseFormatData)) {

                            $returnResponse["result_count"] = count($responseFormatData);

                        }

                        // if (is_array($responseData)) {

                        //     $returnResponse["result_count"] = count($responseData);
                        // }
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

    public function formatData($items)
    {

        // $resource = new Collection($items, function (array $item) {

        //     return [

        //         'id'      => (int) $item['id'],
        //         'name'   => $item['name'],
        //         'email'   => $item['email'],
        //         'role_id'   => (int) $item['role_id'],
        //         'group_id'   => (int) $item['group_id'],
        //         // 'role_name'   => $item['role']['name'],
        //         // 'group_name'   => $item['group']['name'],
        //         'role'   => $item['role']['name'],
        //         'group'   => $item['group']['name'],
        //         'status'    => (boolean) $item['status'],
        //         'created_at' => date('d-M-y',strtotime($item['created_at'])),
        //         'updated_at' => date('d-M-y',strtotime($item['updated_at'])),

        //     ];

        // });

        // // return $resource->getData();


        // // Turn that into a structured array (handy for XML views or auto-YAML converting)
        // return  $this->fractal->createData($resource)->toArray();

        $resource = array_map(

            function ($item) {

                if (isset($item["status"])) {

                    $status = false;

                    if ($item["status"] == "1") {

                        $status = true;

                    }

                    $item["status"] = $status;

                }

                return [

                    'id'      => $item['empcode'],
                    'empname'   => $item['empname'],
                    'empcode'   => $item['empcode'],
                    'spi_empcode'   => $item['spi_empcode'],
                    'email'   => $item['email'],
                    'role'   => $item['role'],
                    'location'   => $item['location'],
                    'cisco'   => $item['cisco'],
                    'mobile'   => $item['mobile'],
                    // 'role_id'   => (int) $item['role_id'],
                    // 'group_id'   => (int) $item['group_id'],
                    // // 'role_name'   => $item['role']['name'],
                    // // 'group_name'   => $item['group']['name'],
                    // 'role'   => $item['role']['name'],
                    // 'group'   => $item['group']['name'],
                    'status'    => $item['status'],
                    'created_at' => date('d-M-y',strtotime($item['created_date'])),
                    'updated_at' => date('d-M-y',strtotime($item['modified_date'])),

                ];
            },
            $items
        );

        return $resource;

    }

    public function formatMembersData($items)
    {

        $resource = array_map(

            function ($item) {

                $memberDashboardUrl = "javascript:void(0);";

                if(isset($item["email"]) && $item["email"] != "") {

                    // $item["email"] = '<a class="btn-link member-job-count-item " href="javascript:void(0);" data-member-empcode="' . $item["empcode"] . '" >' . mb_strimwidth($item["email"], 0, 75, "...") . '</a>';
                    // $item["email"] = '<a class="btn-link member-job-count-item " href="javascript:void(0);" data-member-empcode="' . $item["empcode"] . '" >' . $item["email"] . '</a>';

                    $memberDashboardUrl = route(__("dashboard.member_dashboard_url"), ["empcode" => urlencode(base64_encode($item["id"])),"currentempcode" => urlencode(base64_encode(auth()->user()->id))]);
                    // $item["email"] = '<a class="btn-link" href="' . $memberDashboardUrl . '" data-member-empcode="' . $item["empcode"] . '" target="_blank">' . $item["email"] . '</a>';
                    $item["email"] = '<a class="btn-link" href="' . $memberDashboardUrl . '" data-member-empcode="' . $item["empcode"] . '">' . $item["email"] . '</a>';

                }

                return $item;

            },
            $items
        );

        return $resource;
    }


    /**
     * Get the user from the users Table by user field array.
     *
     * @param  array $field
     * @return array $userData
     */
    public function login($field)
    {
        $returnData = "";

        try {

            $url = $this->userLoginApiUrl;

            $returnData = $this->postRequest($url, $field);

            if ($returnData["success"] == "true") {

                if (is_array($returnData["data"]) && count($returnData["data"]) > 0 && $returnData["data"] != "") {

                    if (isset($returnData["data"]["qr_code"]) && $returnData["data"]["qr_code"] != "") {

                        if (base64_decode($returnData["data"]["qr_code"], true)) {

                            $returnData["data"]["qr_code"] = base64_decode($returnData["data"]["qr_code"]);

                        }

                    }

                }

            }

            // $returnData= [
            //     "success" => "true",
            //     "message" => "",
            //     "data" => [
            //         "empcode" => "admin",
            //         "code" => "5",
            //         "qr_code" => "https://www.a2zwebhelp.com/images/google_auth_3.png"
            //     ]
            // ];

        } catch (Exception $e) {

            // return $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return $returnData;

    }

    /**
     * Post user MFA code.
     *
     * @param  array $field
     * @return array $userData
     */
    public function mfa($field)
    {
        $returnData = "";

        try {

            $url = $this->userMFAApiUrl;

            $returnData = $this->postRequest($url, $field);

            // $returnData = [
            //     "success" => "true",
            //     "message" => "",
            //     "data" => [
            //         "empcode" => "admin",
            //         "code" => "1",
            //     ]
            // ];

        } catch (Exception $e) {

            // return $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return $returnData;

    }

    /**
     * Update user mac id by user empcode.
     *
     * @return array $returnResponse
     */
    public function updateMacId($request)
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

                'empcode'       => 'required',
                'mac_address'       => 'required',

            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Update failed";

            } else {

                $paramInfo = $request->all();

                if(isset($paramInfo["_token"])) {

                    unset($paramInfo["_token"]);

                }

                $url = $this->userMacIdUpdateApiUrl;

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
     * Update user password by user empcode.
     *
     * @return array $returnResponse
     */
    public function changePassword($request)
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

                'empcode'       => 'required',
                'password'       => 'required',

            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Update failed";
            } else {


                $conditions = [

                    ['empcode', $request->get('empcode')],

                ];

                $fields = ['empcode'];

                $user = $this->getUserField($conditions, $fields);


                $user->empcode =  $request->get('empcode');
                $user->password =  md5($request->get('password'));

                $userInfo = $user;
                $userInfo = $userInfo->toArray();
                $userInfo["password"] = md5($request->get('password'));

                // unset($userInfo["id"]);

                $url = $this->userPasswordUpdateApiUrl;

                $returnData = $this->postRequest($url, $userInfo);

                if (isset($returnData["success"]) && $returnData["success"] == "true") {

                    if ($user->save()) {

                        $returnResponse["success"] = "true";
                        $returnResponse["message"] = "Password Changed successfully";
                    } else {

                        $returnResponse["error"] = "true";
                        $returnResponse["message"] = "Password Change unsuccessfull";
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
     * user login history.
     *
     * @return array $userData
     */
    public function loginHistory($request)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $url = $this->loginHistoryApiUrl;

            $responseData = $this->postRequest($url, $request);

            if ($responseData["success"] == "true") {

                $returnResponse["success"] = "true";
                $returnResponse["message"] = "logged successfully";

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

// // Model path
// use App\Job;
// // Resource path
// use App\Http\Resources\JobCollection;
// // Calling procedure
// Route::get('/jobs', function () {
//        return new JobCollection(Job::all());
// });
