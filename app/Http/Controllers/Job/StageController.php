<?php

namespace App\Http\Controllers\Job;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Resources\Job\StageCollection as StageResource;

class StageController extends Controller
{
    protected $stageResource = "";

    public function __construct()
    {

        $this->stageResource = new StageResource();

    }

    /**
     * Show the stage detail.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function stageList(Request $request)
    {

        $responseData = $this->stageResource->getAllStage();

        $returnData = [

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

        return view('pages.user.list', compact('returnData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return json response
     */
    public function stageAdd(Request $request)
    {

        $returnResponse = $this->stageResource->stageAdd($request);

        if (isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

            $returnResponse["data"] = $this->stageResource->getAllStage();
        }

        return json_encode($returnResponse);
    }

    /**
     * Edit stage in job_stage table by stage id.
     *
     * @return json response
     */
    public function stageEdit(Request $request)
    {

        $returnResponse = $this->stageResource->stageEdit($request);

        if (isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

            $returnResponse["data"] = $this->stageResource->getAllStage();
        }

        return json_encode($returnResponse);
    }

    /**
     * Delete stage in job_stage table by stage id.
     *
     * @return json response
     */
    public function stageDelete(Request $request)
    {

        $returnResponse = $this->stageResource->stageDelete($request);

        if (isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

            $returnResponse["data"] = $this->stageResource->getAllStage();
        }

        return json_encode($returnResponse);
    }

    /**
     * get active stages.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getActiveStages(Request $request)
    {

        $responseData = $this->roleResource->getActiveStages();

        $returnData = [

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

        return view('pages.user.list', compact('returnData'));
    }

}
