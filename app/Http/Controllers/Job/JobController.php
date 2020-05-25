<?php

namespace App\Http\Controllers\Job;

use Session;
use Exception;
use Illuminate\Http\Request;
use App\Traits\General\Helper;
use App\Http\Controllers\Controller;
use App\Traits\General\CustomLogger;
use Illuminate\Support\Facades\Config;
use App\Resources\Job\JobCollection as JobResource;
use App\Resources\Job\TaskCollection as TaskResource;

class JobController extends Controller
{

    use Helper;

    use CustomLogger;

    protected $jobResource = "";

    protected $taskResource = "";

    protected $currentUserCodeField = "pm_empcode";

    public function __construct()
    {

        $this->jobResource = new JobResource();

        $this->taskResource = new TaskResource();

        $this->currentUserCodeField = env('CURRENT_USER_CODE_FIELD');

        // $this->userId = auth()->user()->id;

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    { }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function jobList(Request $request)
    {
        $returnResponse = $returnData = [];

        try {

            $field = [];

            // $field[$this->currentUserCodeField] =  auth()->user()->empcode;

            // if(auth()->user()->role == "account_manager") {

            //     $field["am_empcode"] =  auth()->user()->empcode;

            // }

            // $field[env('PROJECT_MANAGER_CODE_FIELD')] =  auth()->user()->empcode;

            if(auth()->user()->role == env('ACCOUNT_MANAGER_ROLE_NAME')) {

                $field[env('ACCOUNT_MANAGER_CODE_FIELD')] =  auth()->user()->empcode;

            }

            if (auth()->user()->role == env('PROJECT_MANAGER_ROLE_NAME')) {

                $field[env('PROJECT_MANAGER_CODE_FIELD')] =  auth()->user()->empcode;
            }

            if ($request->stage && $request->stage != "") {

                $field["stage"] = $request->stage;
            }

            if ($request->status && $request->status != "") {

                $field["status"] = $request->status;

            }

            // if ($request->type && $request->type != "") {

            //     $fieldValue = ["type", $request->type];

            //     if ($request->type == __('dashboard.in_hand_job_text')) {

            //         $fieldValue = ["type", "<>", __('dashboard.completed_job_text')];
            //     }

            //     if ($request->type == __('dashboard.completed_job_text')) {

            //         $fieldValue = ["type", __('dashboard.completed_job_text')];
            //     }

            //     $field[] = $fieldValue;
            // }

            if (count($field) > 0) {

                $returnResponse = $this->jobResource->getJobByField($field);

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

        if ($request->ajax()) {

            return json_encode($returnResponse);
        }

        if(isset($returnResponse['data'])) {

            $returnData = $returnResponse['data'];

        }

        return view("pages.job.jobDetail", compact("returnData"));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return json response
     */
    public function jobStore(Request $request)
    {

        $returnResponse = [];

        $redirectRouteAction = "";


        try {

            $request->merge(['am_empcode' => Config::get('constants.job_add_am_empcode')]);
            $request->merge(['am_empname' => Config::get('constants.job_add_am_empname')]);
            // $request->merge(['stage' => 's5']);
            $request->merge(['status' => Config::get('constants.job_add_status')]);

            if ($request->womat_job_id) {

                $request->merge(['isbn' => $request->womat_job_id]);
                $request->merge(['e_isbn' => $request->womat_job_id]);
            }

            $returnResponse = $this->jobResource->jobAdd($request);

            if ($request->redirectTo != __("job.job_detail_url")) {

                $redirectRouteAction = $this->roleBasedDashboardRouteAction($request);
            }

        } catch (Exeception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        if ($redirectRouteAction) {

            $redirectUrl = redirect()->action($redirectRouteAction);
        }

        if ($request->redirectTo == __("job.job_detail_url") && $request->current_job_id) {

            $redirectUrl = redirect()->route($request->redirectTo, $request->current_job_id);
        }

        // if($redirectUrl && isset($returnResponse)) {

        //     $returnResponse["redirectTo"] = $redirectUrl;

        // }

        // return json_encode($returnResponse);

        return $redirectUrl->with(["success" => $returnResponse["success"], "error" => $returnResponse["error"], "message" => $returnResponse["message"]]);




        // $returnResponse = [];

        // try {

        //     $request->merge(['am_empcode' => Config::get('constants.job_add_am_empcode')]);
        //     $request->merge(['am_empname' => Config::get('constants.job_add_am_empname')]);
        //     $request->merge(['status' => Config::get('constants.job_add_status')]);

        //     if($request->womat_job_id) {

        //         $request->merge(['isbn' => $request->womat_job_id]);
        //         $request->merge(['e_isbn' => $request->womat_job_id]);

        //     }

        //     $returnResponse = $this->jobResource->jobAdd($request);

        // } catch (Exeception $e) {

        //     $returnResponse["success"] = "false";
        //     $returnResponse["error"] = "true";
        //     $returnResponse["data"] = [];
        //     $returnResponse["message"] = $e->getMessage();
        //     $this->error(
        //         "app_error_log_" . date('Y-m-d'),
        //         " => FILE => " . __FILE__ . " => " .
        //             " => LINE => " . __LINE__ . " => " .
        //             " => MESSAGE => " . $e->getMessage() . " "
        //     );
        // }

        // return json_encode($returnResponse);

    }

    /**
     * Show the job detail.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getJobDetails(Request $request)
    {
        $returnResponse = $responseData = [];

        $field = [];

        try {


            if ($request->id && $request->id != "") {

                $field["job_id"] = $request->id;
            }

            if (count($field) > 0) {

                $returnResponse = $this->jobResource->getJob($field);

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

        if ($request->ajax()) {

            return json_encode($returnResponse);
        }


        if (isset($returnResponse['data'])) {

            $responseData = $returnResponse;
			
			if($responseData['data']['pm_empcode'] != auth()->user()->empcode && $responseData['data']['am_empcode'] != auth()->user()->empcode){
			
				return view('errors.error401');
			
			}
			
            // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($returnResponse);echo '<PRE/>';exit;
            // $responseData['data']["task"] = $this->taskResource->getTaskList($field);


        }

        // echo '<PRE/>'; echo 'LINE => '.__LINE__;echo '<PRE/>';echo 'CAPTION => CaptionName';echo '<PRE/>';print_r($responseData);echo '<PRE/>';exit;

        return view("pages.job.jobDetail", compact("responseData"));

    }

    /**
     * Get the job history.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function jobHistory(Request $request)
    {
        $returnResponse = [];

        $field = [];

        try {

            if ($request->id && $request->id != "") {

                $field["job_id"] = $request->id;
            }

            if (count($field) > 0) {

                $returnResponse = $this->jobResource->jobHistory($field);
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
     * Get the job timeline.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function jobTimeline(Request $request)
    {
        $returnResponse = [];

        $field = [];

        try {

            if ($request->id && $request->id != "") {

                $field["job_id"] = $request->id;
            }

            if (count($field) > 0) {

                $returnResponse = $this->jobResource->jobTimeline($field);
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

}