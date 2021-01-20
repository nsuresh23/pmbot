<?php

namespace App\Http\Controllers\AM\Report;

use Url;
use Session;
use Exception;
use Illuminate\Http\Request;
use App\Traits\General\Helper;
use App\Http\Controllers\Controller;
use App\Traits\General\CustomLogger;
use Illuminate\Support\Facades\Config;
use App\Resources\Report\ReportCollection as ReportResource;

class ReportController extends Controller
{
    use Helper;

    use CustomLogger;

    protected $reportResource = "";

    protected $currentUserCodeField = "am_empcode";

    public function __construct()
    {

        $this->reportResource = new ReportResource();

        $this->currentUserCodeField = env('CURRENT_USER_CODE_FIELD');
    }

    /**
     * Show the email summary report detail.
     *
     *  @return json response
     */
    public function summaryReport(Request $request)
    {

        try {

            $field = [];

            $returnResponse = [];

            $fieldData = $filterData = [];

            if (isset($request->draw) && $request->draw != '') {

                $filterData["page"] = $request->draw;

            }

            if (isset($request->start) && $request->start != '') {

                if (isset($request->length) && $request->length != '') {

                    $filterData["offset"] = $request->start;

                    $filterData["limit"] = $request->length;
                }
            }

            if (isset($request->search) && is_array($request->search) && isset($request->search["value"]) && $request->search["value"] != '') {

                $filterData["search"] = $request->search["value"];

            }

            if (isset($request->filter_option) && is_array($request->filter_option) && count($request->filter_option)) {

                $filterOption = $request->filter_option;

                if(isset($filterOption["range"]) && $filterOption["range"] != "") {

                    $rangeValue = explode(' to ', $filterOption["range"]);

                    if(is_array($rangeValue)) {

                        if (count($rangeValue) > 0) {

                            $filterData["fromdate"] = $rangeValue[0];

                            if (count($rangeValue) > 1) {

                                $filterData["todate"] = $rangeValue[1];

                            }

                        }

                    }

                    // $filterData["range"] = $filterOption["range"];

                }

                if (isset($filterOption["report_type"]) && $filterOption["report_type"] != "") {

                    $filterData["email_domain"] = $filterOption["report_type"];

                }

                if (isset($filterOption["user_empcode"]) && $filterOption["user_empcode"] != "") {

                    $filterData["user_empcode"] = $filterOption["user_empcode"];

                }

            }

            if (isset($request->order) && is_array($request->order) && count($request->order) > 0) {

                $orderData = $request->order;

                $formatData = [

                    "subject_link" => "subject",
                    "is_attachments" => "attachments",
                    "is_priority" => "priority",

                ];

                if (isset($request->columns) && is_array($request->columns) && count($request->columns) > 0) {

                    $fieldData = $request->columns;

                }

                $this->formatDataTableFilter($filterData, $fieldData, $orderData, $formatData);

            }

            if (isset($filterData) && is_array($filterData) && count($filterData) > 0) {

                $field["filter"] = $filterData;

            }

            if (isset($request->category) && $request->category != "") {

                $field["category"] = $request->category;

            }

            $field["empcode"] = auth()->user()->empcode;

            $field["role"] = auth()->user()->role;

            if (count($field) > 0) {

                $returnResponse = $this->reportResource->summaryReport($field);

            }

        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        //if ($request->ajax()) {

        return $returnResponse;
        // return json_encode($returnResponse);
        //}

        return view("errors.error404");
    }

    /**
     * Show the email received email report detail.
     *
     *  @return json response
     */
    public function receivedEmailReport(Request $request)
    {

        try {

            $field = [];

            $returnResponse = [];

            $fieldData = $filterData = [];

            if (isset($request->draw) && $request->draw != '') {

                $filterData["page"] = $request->draw;

            }

            if (isset($request->start) && $request->start != '') {

                if (isset($request->length) && $request->length != '') {

                    $filterData["offset"] = $request->start;

                    $filterData["limit"] = $request->length;
                }
            }

            if (isset($request->search) && is_array($request->search) && isset($request->search["value"]) && $request->search["value"] != '') {

                $filterData["search"] = $request->search["value"];

            }

            if (isset($request->filter_option) && is_array($request->filter_option) && count($request->filter_option)) {

                $filterOption = $request->filter_option;

                if(isset($filterOption["range"]) && $filterOption["range"] != "") {

                    $rangeValue = explode(' to ', $filterOption["range"]);

                    if(is_array($rangeValue)) {

                        if (count($rangeValue) > 0) {

                            $filterData["fromdate"] = $rangeValue[0];

                            if (count($rangeValue) > 1) {

                                $filterData["todate"] = $rangeValue[1];

                            }

                        }

                    }

                    // $filterData["range"] = $filterOption["range"];

                }

                if (isset($filterOption["report_type"]) && $filterOption["report_type"] != "") {

                    $filterData["email_domain"] = $filterOption["report_type"];

                }

                if (isset($filterOption["user_empcode"]) && $filterOption["user_empcode"] != "") {

                    $filterData["user_empcode"] = $filterOption["user_empcode"];

                }

            }

            if (isset($request->order) && is_array($request->order) && count($request->order) > 0) {

                $orderData = $request->order;

                $formatData = [

                    "subject_link" => "subject",
                    "is_attachments" => "attachments",
                    "is_priority" => "priority",

                ];

                if (isset($request->columns) && is_array($request->columns) && count($request->columns) > 0) {

                    $fieldData = $request->columns;

                }

                $this->formatDataTableFilter($filterData, $fieldData, $orderData, $formatData);

            }

            if (isset($filterData) && is_array($filterData) && count($filterData) > 0) {

                $field["filter"] = $filterData;

            }

            if (isset($request->category) && $request->category != "") {

                $field["category"] = $request->category;

            }

            $field["empcode"] = auth()->user()->empcode;

            $field["role"] = auth()->user()->role;

            if (count($field) > 0) {

                $returnResponse = $this->reportResource->summaryReport($field);

            }

        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        //if ($request->ajax()) {

        return $returnResponse;
        // return json_encode($returnResponse);
        //}

        return view("errors.error404");

    }

    /**
     * Show the email sent email report detail.
     *
     *  @return json response
     */
    public function sentEmailReport(Request $request)
    {

        try {

            $field = [];

            $returnResponse = [];

            $fieldData = $filterData = [];

            if (isset($request->draw) && $request->draw != '') {

                $filterData["page"] = $request->draw;

            }

            if (isset($request->start) && $request->start != '') {

                if (isset($request->length) && $request->length != '') {

                    $filterData["offset"] = $request->start;

                    $filterData["limit"] = $request->length;
                }
            }

            if (isset($request->search) && is_array($request->search) && isset($request->search["value"]) && $request->search["value"] != '') {

                $filterData["search"] = $request->search["value"];

            }

            if (isset($request->filter_option) && is_array($request->filter_option) && count($request->filter_option)) {

                $filterOption = $request->filter_option;

                if(isset($filterOption["range"]) && $filterOption["range"] != "") {

                    $rangeValue = explode(' to ', $filterOption["range"]);

                    if(is_array($rangeValue)) {

                        if (count($rangeValue) > 0) {

                            $filterData["fromdate"] = $rangeValue[0];

                            if (count($rangeValue) > 1) {

                                $filterData["todate"] = $rangeValue[1];

                            }

                        }

                    }

                    // $filterData["range"] = $filterOption["range"];

                }

                if (isset($filterOption["report_type"]) && $filterOption["report_type"] != "") {

                    $filterData["email_domain"] = $filterOption["report_type"];

                }

                if (isset($filterOption["user_empcode"]) && $filterOption["user_empcode"] != "") {

                    $filterData["user_empcode"] = $filterOption["user_empcode"];

                }

            }

            if (isset($request->order) && is_array($request->order) && count($request->order) > 0) {

                $orderData = $request->order;

                $formatData = [

                    "subject_link" => "subject",
                    "is_attachments" => "attachments",
                    "is_priority" => "priority",

                ];

                if (isset($request->columns) && is_array($request->columns) && count($request->columns) > 0) {

                    $fieldData = $request->columns;

                }

                $this->formatDataTableFilter($filterData, $fieldData, $orderData, $formatData);

            }

            if (isset($filterData) && is_array($filterData) && count($filterData) > 0) {

                $field["filter"] = $filterData;

            }

            if (isset($request->category) && $request->category != "") {

                $field["category"] = $request->category;

            }

            $field["empcode"] = auth()->user()->empcode;

            $field["role"] = auth()->user()->role;

            if (count($field) > 0) {

                $returnResponse = $this->reportResource->summaryReport($field);

            }

        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        //if ($request->ajax()) {

        return $returnResponse;
        // return json_encode($returnResponse);
        //}

        return view("errors.error404");

    }

    /**
     * Show the email classified email report detail.
     *
     *  @return json response
     */
    public function classifiedEmailReport(Request $request)
    {

        try {

            $field = [];

            $returnResponse = [];

            $fieldData = $filterData = [];

            if (isset($request->draw) && $request->draw != '') {

                $filterData["page"] = $request->draw;

            }

            if (isset($request->start) && $request->start != '') {

                if (isset($request->length) && $request->length != '') {

                    $filterData["offset"] = $request->start;

                    $filterData["limit"] = $request->length;
                }
            }

            if (isset($request->search) && is_array($request->search) && isset($request->search["value"]) && $request->search["value"] != '') {

                $filterData["search"] = $request->search["value"];

            }

            if (isset($request->filter_option) && is_array($request->filter_option) && count($request->filter_option)) {

                $filterOption = $request->filter_option;

                if(isset($filterOption["range"]) && $filterOption["range"] != "") {

                    $rangeValue = explode(' to ', $filterOption["range"]);

                    if(is_array($rangeValue)) {

                        if (count($rangeValue) > 0) {

                            $filterData["fromdate"] = $rangeValue[0];

                            if (count($rangeValue) > 1) {

                                $filterData["todate"] = $rangeValue[1];

                            }

                        }

                    }

                    // $filterData["range"] = $filterOption["range"];

                }

                if (isset($filterOption["report_type"]) && $filterOption["report_type"] != "") {

                    $filterData["email_domain"] = $filterOption["report_type"];

                }

                if (isset($filterOption["user_empcode"]) && $filterOption["user_empcode"] != "") {

                    $filterData["user_empcode"] = $filterOption["user_empcode"];

                }

            }

            if (isset($request->order) && is_array($request->order) && count($request->order) > 0) {

                $orderData = $request->order;

                $formatData = [

                    "subject_link" => "subject",
                    "is_attachments" => "attachments",
                    "is_priority" => "priority",

                ];

                if (isset($request->columns) && is_array($request->columns) && count($request->columns) > 0) {

                    $fieldData = $request->columns;

                }

                $this->formatDataTableFilter($filterData, $fieldData, $orderData, $formatData);

            }

            if (isset($filterData) && is_array($filterData) && count($filterData) > 0) {

                $field["filter"] = $filterData;

            }

            if (isset($request->category) && $request->category != "") {

                $field["category"] = $request->category;

            }

            $field["empcode"] = auth()->user()->empcode;

            $field["role"] = auth()->user()->role;

            if (count($field) > 0) {

                $returnResponse = $this->reportResource->summaryReport($field);

            }

        } catch (Exception $e) {

            $returnResponse["success"] = "false";
            $returnResponse["error"] = "true";
            $returnResponse["data"] = [];
            $returnResponse["message"] = $e->getMessage();
        }

        //if ($request->ajax()) {

        return $returnResponse;
        // return json_encode($returnResponse);
        //}

        return view("errors.error404");

    }

}
