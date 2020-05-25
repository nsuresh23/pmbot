<?php

namespace App\Resources\Job;

use App\Models\Job\Stage;

use League\Fractal\Manager;

use League\Fractal\Resource\Collection;

use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Boolean;

class StageCollection
{

    protected $fractal;

    public function __construct()
    {

        $this->fractal = new Manager();

    }

    /**
     * Get the stages from the job_stage Table.
     *
     * @return array $stageData
     */
    public function getAllStage()
    {
        $stageData = "";

        try {

            $stageData = Stage::all();

            if ($stageData) {

                $stageData = $this->formatData($stageData->toArray());
            }

        } catch (Exception $e) {

            return $e->getMessage();
        }

        return $stageData;
    }

    /**
     * Add the stage to the job_stage Table.
     *
     * @return array $returnResponse
     */
    public function stageAdd($request)
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
                'name'       => 'required',
                'status'       => 'required'
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

                // store
                $stage = new Stage;
                $stage->name = $request->get('name');
                $stage->status = $request->get('status');
                
                if($stage->save()) {

                    $returnResponse["success"] = "true";
                    $returnResponse["message"] = "Save successfull";

                } else {

                    $returnResponse["error"] = "true";
                    $returnResponse["message"] = "Save unsuccessfull";

                }

            }

        } catch (Exception $e) {

            $returnResponse["error"] = "true";
            $returnResponse["message"] = $e->getMessage();
        }

        return $returnResponse;
    }

    /**
     * Edit the stage in job_stage table based on stage id.
     *
     * @return array $returnResponse
     */
    public function stageEdit($request)
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
                'name'       => 'required',
                'status'       => 'required'
            );
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Update failed";

            } else {

                // update
                $stage = Stage::find($request->get('id'));
                $stage->name = $request->get('name');
                $stage->status = $request->get('status');

                if ($stage->save()) {

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

        }

        return $returnResponse;
    }

    /**
     * Delete the stage in job_stage table based on stage id.
     *
     * @return array $returnResponse
     */
    public function stageDelete($request)
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
                $returnResponse["message"] = "Delete failed";
            } else {

                // delete
                $stage = Stage::find($request->get('id'));
                $stage->delete();

                $returnResponse["success"] = "true";
                $returnResponse["message"] = "Deleted successfully";
            }
        } catch (Exception $e) {

            $returnResponse["error"] = "true";
            $returnResponse["message"] = $e->getMessage();
            
        }

        return $returnResponse;
    }

    /**
     * Get the stage from the job_stage Table by stage field array.
     *
     * @param  array $field
     * @return array $stageData
     */
    public function getStage($field)
    {
        $stageData = "";

        try {

            // $field = [
            //     ['name', 'test'],
            //     ['id', '<>', '5']
            // ];

            $stageData = Stage::where($field)->get();

            if($stageData) {

                $stageData = $stageData->toArray();

            }
        } catch (Exception $e) {

            return $e->getMessage();
        }

        return $stageData;
    }

    /**
     * Get the stage from the job_stage Table by stage field array.
     *
     * @param  array $field
     * @param  string $fieldName
     * @return array $returnData
     */
    public function getStageField($field, $fieldName)
    {
        $returnData = "";

        try {

            // $field = [
            //     ['name', 'test'],
            //     ['id', '<>', '5']
            // ];

            $stageData = Stage::where($field)->get();

            
            if ($stageData) {
                
                $stageData = $stageData->toArray();

                if (isset($stageData[0]) && count($stageData[0]) > 0) {

                    $returnData = $stageData[0][$fieldName];

                }
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }

        return $returnData;
    }

    /**
     * Get the active stages from the job_stage Table.
     *
     * @return array $stageData
     */
    public function getActiveStages()
    {
        $stageData = "";

        try {

            $stage = Stage::all();

            $stageData = $stage->reject(

                function ($stage) {

                    return $stage->status === false;
                }

            )->pluck("name", "id");

            if ($stageData) {

                $stageData = $stageData->toArray();
            }

        } catch (Exception $e) {

            return $e->getMessage();
        }

        return $stageData;
        
    }

    public function formatData($items)
    {

        $resource = array_map(

            function ($item) {

                // if (isset($item['title']) && $item['title'] != "") {

                //     if (base64_decode($item["title"], true)) {

                //         $item['title'] = base64_decode($item["title"]);
                //     }

                // }

                // if (isset($item['description']) && $item['description'] != "") {

                //     if (base64_decode($item["description"], true)) {

                //         $item['description'] = base64_decode($item["description"]);
                //     }

                // }

                // if (isset($item['attachment_path']) && $item['attachment_path'] != "") {

                //     if (base64_decode($item["attachment_path"], true)) {

                //         $item['attachment_path'] = base64_decode($item["attachment_path"]);
                //     }

                // }

                return [

                    'id'      => (int) $item['id'],
                    'name'   => $item['name'],
                    'status'    => $item['status'],
                    'created_at' => date('d-M-y',strtotime($item['created_at'])),
                    'updated_at' => date('d-M-y',strtotime($item['updated_at'])),

                ];

            },
            $items
        );

        return $resource;

    }
    
}