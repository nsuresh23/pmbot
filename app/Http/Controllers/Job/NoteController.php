<?php

namespace App\Http\Controllers\Job;

use Session;
use Exception;
use Illuminate\Http\Request;
use App\Traits\General\Helper;
use App\Http\Controllers\Controller;
use App\Traits\General\CustomLogger;
use Illuminate\Support\Facades\Config;
use App\Resources\Job\TaskCollection as TaskResource;
use App\Resources\Job\NoteCollection as NoteResource;
use App\Resources\User\UserCollection as UserResource;

class NoteController extends Controller
{

    use Helper;

    use CustomLogger;
    
    protected $taskResource = "";
    protected $noteResource = "";
    protected $userResource = "";

    public function __construct()
    {

        $this->taskResource = new TaskResource();
        $this->noteResource = new NoteResource();
        $this->userResource = new UserResource();

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    { }

    /**
     * Show the task note detail.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function taskNoteList(Request $request)
    {
        $returnResponse = [];

        if ($request->ajax()) {

            try {

                $field = $empcode = [];

                if(isset($request->id) && $request->id != "") {

                    $field['task_id'] = $request->id;

                }

                if (isset($request->assignedEmpcode) && $request->assignedEmpcode != "" && $request->assignedEmpcode != __("job.task_common_empcode")) {

                    array_push($empcode, $request->assignedEmpcode);

                    if (isset($request->createdEmpcode) && $request->createdEmpcode != "") {

                        array_push($empcode, $request->createdEmpcode);
                    }
                    
                }               

                if(count($empcode) > 0) {

                    $field['empcode'] = $empcode;

                }

                $returnResponse = $this->noteResource->taskNoteList($field);

            } catch (Exception $e) {

                $returnResponse["success"] = "false";
                $returnResponse["error"] = "true";
                $returnResponse["data"] = [];
                $returnResponse["message"] = $e->getMessage();
            }

        }

        return json_encode($returnResponse);

        // return view('pages.job.task.list', compact('taskData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return json response
     */
    public function noteAdd(Request $request)
    {

        $returnData = "";

        if ($request->redirectTo) {

            $returnData["redirectTo"] = $request->redirectTo;
            
        }

        return view('pages.job.task.taskNote', compact("returnData"));
    }

    /**
     * Show note edit page based on note id.
     *
     * @return array $returnData
     */
    public function noteEdit(Request $request)
    {

        $returnData = "";

        if ($request->redirectTo) {

            $returnData["redirectTo"] = $request->redirectTo;
        }

        if ($request->id != "") {

            $parentList = [];

            $field = [

                ['id', $request->id]

            ];

            $field = [

                ['task_id', $request->task_id]

            ];

            $returnData = $this->noteResource->getTaskNote($field);
            

            if (isset($returnData["success"]) && $returnData["success"] == "true") {

                $returnResponse["data"]['note'] = $returnData["data"];
            }
        }

        return view('pages.job.task.view', compact("returnData"));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return json response
     */
    public function noteStore(Request $request)
    {
        $returnResponse = [];

        $redirectRouteAction = "Job\NoteController@noteList";

        try {

            $request->merge(['empcode' => auth()->user()->empcode]);
            $request->merge(['empname' => auth()->user()->empname]);
            $request->merge(['emprole' => auth()->user()->role]);

            if(auth()->user()->empcode == $request->createdby_empcode && $request->createdby_status == "pending") {

                $request->merge(['createdby_status' => 'completed']);
                $request->merge(['assignedto_status' => 'pending']);
                $request->merge(['notification_empcode' => $request->assignedto_empcode]);

            }

            if (auth()->user()->empcode == $request->assignedto_empcode && $request->assignedto_status == "pending") {

                $request->merge(['notification_empcode' => $request->createdby_empcode]);
                $request->merge(['createdby_status' => 'pending']);
                $request->merge(['assignedto_status' => 'completed']);

            }

            if (isset($request->createdby_empcode)) {

                unset($request["createdby_empcode"]);
            }

            if (isset($request->assignedto_empcode)) {

                unset($request["assignedto_empcode"]);
            }

            if (isset($request->redirectTo)) {

                $redirectRouteAction = $this->roleBasedDashboardRouteAction($request);

                unset($request["redirectTo"]);
            }

            if (auth()->check()) {

                $request->merge(['creator_empcode' => auth()->user()->empcode]);

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $request->merge(['creator_empcode' => session()->get("current_empcode")]);

                }

            }

            $returnResponse = $this->noteResource->taskNoteAdd($request);

        } catch (Exeception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        $redirectUrl = redirect()->action($redirectRouteAction);
        
        // $redirectUrl = redirect()->route('task-view', $request->task_id);

        return $redirectUrl->with(["success" => $returnResponse["success"], "error" => $returnResponse["error"], "message" => $returnResponse["message"]]);

    }

    /**
     * Update note in note table by note id.
     *
     * @return json returnResponse
     */
    public function noteUpdate(Request $request)
    {

        $returnResponse = [];

        try {

            $request = $this->formatHistoryData($request, "history", "~");

            $request->merge(['notification_empcode' => $request->assignedto_empcode]);

            if(isset($request->createdby_empcode)) {

                unset($request["createdby_empcode"]);

            }

            if (isset($request->assignedto_empcode)) {

                unset($request["assignedto_empcode"]);
            }

            if (isset($request->createdby_status)) {

                unset($request["createdby_status"]);
            }

            if (isset($request->assignedTo_status)) {

                unset($request["assignedTo_status"]);
            }

            $request->merge(['ip_address' => $request->ip()]);

            if (auth()->check()) {

                $request->merge(['creator_empcode' => auth()->user()->empcode]);

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $request->merge(['creator_empcode' => session()->get("current_empcode")]);

                }

            }

            $returnResponse = $this->noteResource->taskNoteEdit($request);

            if (isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

                $field = ['task_id' => $request->task_id];

                $returnData = $this->noteResource->getTaskNote($field);

                if (isset($returnData["success"]) && $returnData["success"] == "true") {

                    $returnResponse["data"] = $returnData["data"];
                }
            }
        } catch (Exeception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        // return json_encode($returnResponse);

        $redirectTaskId = $request->task_id;

        if(isset($request->parent_task_id) && $request->parent_task_id != "") {
            
            $redirectTaskId = $request->parent_task_id;

        }

        $redirectUrl = redirect()->route('task-view', $redirectTaskId);

        return $redirectUrl->with(["success" => $returnResponse["success"], "error" => $returnResponse["error"], "message" => $returnResponse["message"]]);

    }

    /**
     * Delete note in task_note table by note id.
     *
     * @return json response
     */
    public function noteDelete(Request $request)
    {

        $returnResponse = [];

        try {

            if (auth()->check()) {

                $request->merge(['creator_empcode' => auth()->user()->empcode]);

                if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                    $request->merge(['creator_empcode' => session()->get("current_empcode")]);
                    
                }

            }

            $returnResponse = $this->noteResource->taskNoteDelete($request);

            if (isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

                $field = ['task_id' => $request->task_id];
                
                $returnData = $this->noteResource->taskNoteList($field);

                if (isset($returnData["success"]) && $returnData["success"] == "true") {

                    $returnResponse["data"] = $returnData["data"];
                }
            }
        } catch (Exeception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        return json_encode($returnResponse);
    }

    

    // /**
    //  * Delete task in task table by task id.
    //  *
    //  * @return json response
    //  */
    // public function taskDelete(Request $request)
    // {

    //     $returnResponse = [];

    //     try {

    //         $returnResponse = $this->noteResource->taskDelete($request);

    //         if (isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

    //             $returnData = $this->noteResource->getAllTask();

    //             if (isset($returnData["success"]) && $returnData["success"] == "true") {

    //                 $returnResponse["data"] = $returnData["data"];
    //             }
    //         }

    //     } catch (Exeception $e) {

    //         $returnResponse["success"] = "false";
    //         $returnResponse["error"] = "true";
    //         $returnResponse["data"] = [];
    //         $returnResponse["message"] = $e->getMessage();
    //     }

    //     return json_encode($returnResponse);
    // }

}
