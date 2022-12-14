<?php

namespace App\Http\Controllers\QC;

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
            // $returnResponse = $this->jobResource->jobCountByField($field);


            // $field["stage"] = "s5";

            // $stageResponse = $this->jobResource->jobCountByField($field);

            // if ($stageResponse["success"] == "true" && count($stageResponse["data"]) > 0 && $stageResponse["data"] != "") {

            //     $returnResponse['data']['stage_count']['s5'] = $stageResponse["data"];

            // }

            // $stageResponse = $this->jobResource->jobStageCountByField($field);

            // if (count($stageResponse)) {

            //     if (isset($returnResponse['data']) && $returnResponse['data'] != "") {

            //         $returnResponse['data']['stage_count'] = $stageResponse;
            //     }
            // }

            $returnResponse['redirectToDashboard'] = 'false';

            if (array_key_exists("redirectToDashboard", $params)) {

                $returnResponse['redirectToDashboard'] = 'true';

            }

            $returnResponse['label_list'] = [];

            // $returnData = $this->emailResource->emailRuleLabels();

            // if (is_array($returnData) && isset($returnData["success"]) && $returnData["success"] == "true") {

            //     $returnResponse["label_list"] = $returnData["data"];

            // }

            $returnResponse['email_move_to_list'] = $emailMoveToReturnData = $genericJobsList = [];

            // $returnResponse["email_move_to_list"][""] = "Please select";

            // $genericJobsList = $this->jobResource->getGenericJobs();

            // if (is_array($genericJobsList) && count($genericJobsList)) {

            //     $genericJobsListData = [];

            //     array_walk($genericJobsList, function ($item, $key) use (&$genericJobsListData) {

            //         $genericJobsListData["job_". $key] = $item;

            //     });

            //     $returnResponse["email_move_to_list"]["Generic Jobs"] = $genericJobsListData;

            // }

            // $emailMoveToReturnData = $this->emailResource->emailMoveToLabels();

            // if (is_array($emailMoveToReturnData) && isset($emailMoveToReturnData["success"]) && $emailMoveToReturnData["success"] == "true") {

            //     $returnResponse["email_move_to_list"]["Non Business"] = $emailMoveToReturnData["data"];

            // }

        //    $emailSentCountData = $this->emailResource->emailSentCount($request);

        //     if (is_array($emailSentCountData) && isset($emailSentCountData["success"]) && $emailSentCountData["success"] == "true") {

        //         $returnResponse["email_sent_count"] = $emailSentCountData["data"];

        //     }

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

        return view('pages.dashboard.qc.dashboard', compact('returnResponse'));

    }
}
