<?php

namespace App\Http\Controllers\PM;

use Url;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Resources\Job\JobCollection as JobResource;
use App\Resources\Job\EmailCollection as EmailResource;

class DashboardController extends Controller
{
    protected $jobResource = "";

    protected $emailResource = "";

    protected $currentUserCodeField = "pm_empcode";

    public function __construct()
    {

        $this->jobResource = new JobResource();

        $this->emailResource = new EmailResource();

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

            $field = [];

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

            // if ($request->empcode) {

            //     $field["empcode"] = $request->empcode;

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

                if (isset($returnResponse['data']) && $returnResponse['data'] != "") {

                    $returnResponse['data']['stage_count'] = $stageResponse;
                }
            }

            $returnResponse['redirectToDashboard'] = 'false';

            if (array_key_exists("redirectToDashboard", $params)) {

                $returnResponse['redirectToDashboard'] = 'true';

            }

            $returnResponse['label_list'] = [];

            $returnData = $this->emailResource->emailRuleLabels();

            if (is_array($returnData) && isset($returnData["success"]) && $returnData["success"] == "true") {

                $returnResponse["label_list"] = $returnData["data"];

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

        return view('pages.dashboard.dashboard', compact('returnResponse'));

    }
}
