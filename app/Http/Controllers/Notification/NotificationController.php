<?php

namespace App\Http\Controllers\Notification;

use Illuminate\Http\Request;
use App\Traits\General\Helper;
use App\Http\Controllers\Controller;
use App\Resources\Notification\NotificationCollection as NotificationResource;

class NotificationController extends Controller
{

    use Helper;

    protected $notificationResource = "";

    public function __construct()
    {

        $this->notificationResource = new NotificationResource();

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    { }

    /**
     * Show the notification count detail.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function notificationCount(Request $request)
    {

        $returnResponse = [];

        if ($request->ajax()) {

            try {

                $field = [];

                $field = [
                    'empcode' => auth()->user()->empcode
                ];

                if (count($field) > 0) {

                    $returnResponse = $this->notificationResource->notificationCount($field);

                }

            } catch (Exception $e) {

                $returnResponse["success"] = "false";
                $returnResponse["error"] = "true";
                $returnResponse["data"] = [];
                $returnResponse["message"] = $e->getMessage();
            }

        }

        return json_encode($returnResponse);

    }

    /**
     * Show the notification list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function notificationList(Request $request)
    {

        $returnResponse = [];

        if ($request->ajax()) {

            try {

                $field = [];

                $field = [
                    'empcode' => auth()->user()->empcode
                ];

                if (count($field) > 0) {

                    $returnResponse = $this->notificationResource->notificationListByField($field);

                }
            } catch (Exception $e) {

                $returnResponse["success"] = "false";
                $returnResponse["error"] = "true";
                $returnResponse["data"] = [];
                $returnResponse["message"] = $e->getMessage();
            }
        }


        return json_encode($returnResponse);
    }

    /**
     * Update notification by notification id.
     *
     * @return json returnResponse
     */
    public function notificationEdit(Request $request)
    {

        $returnResponse = [];

        if ($request->ajax()) {

            try {

                $request->merge(["read" => "1"]);

                if (auth()->check()) {

                    $request->merge(['creator_empcode' => auth()->user()->empcode]);

                    if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                        $request->merge(['creator_empcode' => session()->get("current_empcode")]);

                    }

                }

                $returnResponse = $this->notificationResource->notificationEdit($request);

            } catch (Exception $e) {

                $returnResponse["success"] = "false";
                $returnResponse["error"] = "true";
                $returnResponse["data"] = [];
                $returnResponse["message"] = $e->getMessage();
            }
        }

        return json_encode($returnResponse);

    }

    /**
     * Read notification by notification id.
     *
     * @return json returnResponse
     */
    public function notificationRead(Request $request)
    {

        $returnResponse = [];

        if ($request->ajax()) {

            try {

                // if(isset($request->id) && $request->id && isset($request->title) && $request->title && isset($request->message) && $request->message) {
                if (isset($request->id) && $request->id) {

                    $request->merge(["reference_id" => $request->id]);

                    if (isset($request->category) && $request->category) {

                        $request->merge(["category" => $request->category]);

                    }

                    if (isset($request->type) && $request->type) {

                        $request->merge(["type" => $request->type]);

                    }

                    if (auth()->check()) {

                        $request->merge(['creator_empcode' => auth()->user()->empcode]);

                        if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                            $request->merge(['creator_empcode' => session()->get("current_empcode")]);

                        }

                    }

                    $request->merge(["empcode" => auth()->user()->empcode]);

                    $returnResponse = $this->notificationResource->notificationRead($request);

                }

                if (isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

                    $notificationCount = 0;

                    $field = [];

                    $field = [
                        'empcode' => auth()->user()->empcode
                    ];

                    $returnCountData = $this->notificationResource->notificationCount($field);

                    if (isset($returnCountData["success"]) && $returnCountData["success"] == "true") {

                        $notificationCount = $returnCountData["data"];

                        if ((int) $notificationCount > 0) {

                            $returnData = $this->notificationResource->notificationListByField($field);

                            if (isset($returnData["success"]) && $returnData["success"] == "true") {

                                $returnResponse["data"]["items"] = $returnData["data"];

                            }

                        }

                    }

                    if(isset($returnResponse["data"]) && $returnResponse["data"] != "") {

                        $returnResponse["data"]["count"] = $notificationCount;

                    }

                }

            } catch (Exception $e) {

                $returnResponse["success"] = "false";
                $returnResponse["error"] = "true";
                $returnResponse["data"] = [];
                $returnResponse["message"] = $e->getMessage();
            }
        }

        return json_encode($returnResponse);
    }

    /**
     * Read all notification by empcode.
     *
     * @return json returnResponse
     */
    public function notificationReadAll(Request $request)
    {

        $returnResponse = [];

        if ($request->ajax()) {

            try {

                // $request->merge(["read" => "1"]);
                $request->merge(["empcode" => auth()->user()->empcode]);

                if (auth()->check()) {

                    $request->merge(['creator_empcode' => auth()->user()->empcode]);

                    if (session()->has("current_empcode") && session()->get("current_empcode") != "") {

                        $request->merge(['creator_empcode' => session()->get("current_empcode")]);

                    }
                    
                }

                $returnResponse = $this->notificationResource->notificationReadAll($request);

                if (isset($returnResponse["success"]) && $returnResponse["success"] == "true") {

                    $notificationCount = 0;

                    $returnResponse["data"] = [];

                    $returnCountData = $this->notificationCount($request);

                    if (isset($returnCountData["success"]) && $returnCountData["success"] == "true") {

                        $notificationCount = $returnCountData["data"];

                        if ((int) $notificationCount > 0) {

                            $returnData = $this->notificationList($request);

                            if (isset($returnData["success"]) && $returnData["success"] == "true") {

                                $returnResponse["data"]["items"] = $returnData["data"];
                            }
                        }
                    }

                    $returnResponse["data"]["count"] = $notificationCount;
                }

            } catch (Exception $e) {

                $returnResponse["success"] = "false";
                $returnResponse["error"] = "true";
                $returnResponse["data"] = [];
                $returnResponse["message"] = $e->getMessage();
            }
        }


        return json_encode($returnResponse);
    }

}
