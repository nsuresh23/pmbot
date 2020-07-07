<?php

namespace App\Http\Controllers\Members;

use Url;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Resources\Job\JobCollection as JobResource;
use App\Resources\User\UserCollection as UserResource;

class MembersController extends Controller
{
    protected $jobResource = "";

    protected $userResource = "";

    protected $currentUserCodeField = "am_empcode";

    public function __construct()
    {

        $this->jobResource = new JobResource();

        $this->userResource = new UserResource();

        $this->currentUserCodeField = env('CURRENT_USER_CODE_FIELD');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        try {

            $field = $returnResponse = [];

            $returnResponse['redirectToDashboard'] = 'false';

            $params = $request->all();

            // $field[$this->currentUserCodeField] =  auth()->user()->empcode;

            // $field["pm_empcode"] =  auth()->user()->empcode;

            // if (auth()->user()->role == "account_manager") {

            //     $field["am_empcode"] =  auth()->user()->empcode;
            // }

            // if (auth()->user()->role == env('ACCOUNT_MANAGER_ROLE_NAME')) {

            //     $field[env('ACCOUNT_MANAGER_CODE_FIELD')] =  auth()->user()->empcode;
            // }

            // if (auth()->user()->role == env('PROJECT_MANAGER_ROLE_NAME')) {

            //     $field[env('PROJECT_MANAGER_CODE_FIELD')] =  auth()->user()->empcode;
            // }

            if($request->empcode && $request->currentempcode){

                $request->empcode = base64_decode(urldecode($request->empcode));

                $request->currentempcode = base64_decode(urldecode($request->currentempcode));

                $memberListResponse = $this->userResource->memberList(["empcode" => auth()->user()->empcode]);

                if ($memberListResponse["success"] == "true") {

                    if (isset($memberListResponse["data"]) &&  is_array($memberListResponse["data"]) && count($memberListResponse["data"]) > 0) {

                        if (!in_array($request->empcode, array_column($memberListResponse["data"], "id"))) {

                            return view("errors.error401");
                        }

                        // array_search($request->empcode, array_column($memberListResponse["data"], "empcode"));

                        $memberInfo = [];

                        array_walk($memberListResponse["data"], function ($arr) use($request, &$memberInfo) {
                            if ($arr["id"] == $request->empcode) {
                                $memberInfo = $arr;
                            }
                        });

                        $currentUserEmpid = auth()->user()->id;
                        $currentUserEmpcode = auth()->user()->empcode;
                        $currentUserName = auth()->user()->empname;
                        $currentUserEmail = auth()->user()->email;
                        $currentUserrole = auth()->user()->role;

                        Auth::loginUsingId($memberInfo["id"], false);

                        session()->put("current_empid", $currentUserEmpid);
                        session()->put("current_empcode", $currentUserEmpcode);
                        session()->put("current_empname", $currentUserName);
                        session()->put("current_email", $currentUserEmail);
                        session()->put("current_role", $currentUserrole);

                        // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r(session()->all());echo '<PRE/>';exit;

                        return redirect()->route("home");

                        $field["empcode"] = $memberInfo["empcode"];

                        // session()->put("current_empcode", $request->currentempcode);
                        // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r(session()->get("current_empcode"));echo '<PRE/>';exit;
                        // session()->put("current_empcode", auth()->user()->empcode);
                        // session()->put("current_role", auth()->user()->empname);
                        // session()->put("current_email", auth()->user()->email);
                        // session()->put("curr>ent_role", auth()->user()->role);

                        // auth()->user()->empcode = $memberInfo["empcode"];
                        // auth()->user()->empname = $memberInfo["empname"];
                        // auth()->user()->email = $memberInfo["email"];
                        // auth()->user()->role = $memberInfo["role"];

                        $returnResponse = $this->jobResource->jobCountByField($field);

                        // $field["stage"] = "s5";

                        // $stageResponse = $this->jobResource->jobCountByField($field);

                        // if ($stageResponse["success"] == "true" && count($stageResponse["data"]) > 0 && $stageResponse["data"] != "") {

                        //     $returnResponse['data']['stage_count']['s5'] = $stageResponse["data"];

                        // }

                        $stageResponse = $this->jobResource->jobStageCountByField($field);

                        if (count($stageResponse)) {

                            if (isset($returnResponse['data']) && $returnResponse['data'] != "") {
                                $returnResponse['data']['stage_count'] = $stageResponse;
                            }
                        }

                        if (array_key_exists("redirectToDashboard", $params)) {

                            $returnResponse['redirectToDashboard'] = 'true';
                        }

                        $jobDefaultDueDateTime = Config::get('constants.jobDefaultDueDateTime');

                        if (isset($jobDefaultDueDateTime) && is_array($jobDefaultDueDateTime) && count($jobDefaultDueDateTime) > 0) {

                            if (isset($jobDefaultDueDateTime["oup"]) && $jobDefaultDueDateTime["oup"] != "") {

                                $returnResponse['default_due_date'] = date("Y-m-d H:i:s", strtotime("+" . $jobDefaultDueDateTime["oup"] . " hour", strtotime(date("Y-m-d H:i:s"))));
                            }
                        }

                        $customUrl = Config::get('constants.custom_urls');

                        if (is_array($customUrl) && isset($customUrl["job_add_url"])) {

                            // $returnResponse['job_add_url'] = route($customUrl["job_add_url"]);
                            $returnResponse['job_add_url'] = $customUrl["job_add_url"];
                        }

                        $returnResponse["user_list"] = $this->userResource->getPMUsers();

                        $returnResponse["workflow_list"] = $this->jobResource->getWorkflowList($request);

                        $returnResponse["location_list"] = Config::get('constants.locationList');

                    }

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

        return view('pages.dashboard.members.dashboard', compact('returnResponse'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function currentUserLogin(Request $request)
    {

        try {

            if(session()->has("current_empid")) {

                Auth::loginUsingId(session()->get("current_empid"), false);

                session()->forget("current_empid");
                session()->forget("current_empcode");
                session()->forget("current_empname");
                session()->forget("current_email");
                session()->forget("current_role");

                return redirect()->route("home");

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

}
