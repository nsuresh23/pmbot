<?php

namespace App\Http\Controllers\AM;

use Url;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Resources\Job\JobCollection as JobResource;
use App\Resources\User\UserCollection as UserResource;

class DashboardController extends Controller
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

            // if($request->empcode){

            //     $field["empcode"] = $request->empcode;

            //     $returnResponse = $this->jobResource->jobCountByField($field);

            // }

            $field["empcode"] = auth()->user()->empcode;

            $returnResponse = $this->jobResource->jobCountByField($field);


            // $field["stage"] = "s5";

            // $stageResponse = $this->jobResource->jobCountByField($field);

            // if ($stageResponse["success"] == "true" && count($stageResponse["data"]) > 0 && $stageResponse["data"] != "") {

            //     $returnResponse['data']['stage_count']['s5'] = $stageResponse["data"];

            // }

            $stageResponse = $this->jobResource->jobStageCountByField($field);

            if (count($stageResponse)) {

                if(isset($returnResponse['data']) && $returnResponse['data'] != "") {
                    $returnResponse['data']['stage_count'] = $stageResponse;

                }

            }

            $returnResponse['redirectToDashboard'] = 'false';

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

            if(is_array($customUrl) && isset($customUrl["job_add_url"])) {

                // $returnResponse['job_add_url'] = route($customUrl["job_add_url"]);
                $returnResponse['job_add_url'] = $customUrl["job_add_url"];

            }

            $returnResponse["user_list"] = $this->userResource->getPMUsers();

            $returnResponse["workflow_list"] = $this->jobResource->getWorkflowList($request);

            $returnResponse["location_list"] = Config::get('constants.locationList');


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

        return view('pages.dashboard.am.dashboard', compact('returnResponse'));
    }

}
