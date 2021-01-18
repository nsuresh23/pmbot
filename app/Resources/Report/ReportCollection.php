<?php

namespace App\Resources\Report;

use League\Fractal\Manager;

use App\Traits\General\Helper;

use App\Traits\General\ApiClient;

use App\Traits\General\CustomLogger;

use League\Fractal\Resource\Collection;

use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Boolean;

class ReportCollection
{

    use Helper;

    use ApiClient;

    use CustomLogger;

    protected $fractal;
    protected $summaryReportApiUrl;
    protected $receivedEmailReportApiUrl;
    protected $sentEmailReportApiUrl;
    protected $classifiedEmailReportApiUrl;

    public function __construct()
    {

        $this->fractal = new Manager();
        $this->summaryReportApiUrl = env('API_SUMMARY_REPORT_LIST_URL');
        $this->receivedEmailReportApiUrl = env('API_RECEIVED_EMAIL_REPORT_LIST_URL');
        $this->sentEmailReportApiUrl = env('API_SENT_EMAIL_REPORT_LIST_URL');
        $this->classifiedEmailReportApiUrl = env('API_CLASSIFIED_EMAIL_REPORT_LIST_URL');

    }

    /**
     * Get the list of summary report.
     *
     * @return array $returnData
     */
    public function summaryReport($params)
    {
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            $paramInfo = [];

            $paramInfo = $params;

            $url = $this->summaryReportApiUrl;

            // $responseData = $this->postRequest($url, $paramInfo);

            $responseData["success"] = true;

            $responseData["data"] = [

                [
                    "url" => "url1",
                    "title" => "title1",
                    "date" => "2020/10/29 16:33:24",
                    "url" => "url1",
                    "title" => "title1",
                    "date" => "2020/10/29 16:33:24",
                    "url" => "url1",
                    "title" => "title1",
                    "date" => "2020/10/29 16:33:24",
                    "url" => "url1",
                    "title" => "title1",
                    "date" => "2020/10/29 16:33:24",
                ],
                [
                    "url" => "url2",
                    "title" => "title2",
                    "date" => "2020/02/29 16:33:24",
                    "url" => "url2",
                    "title" => "title2",
                    "date" => "2020/02/29 16:33:24",
                    "url" => "url2",
                    "title" => "title2",
                    "date" => "2020/02/29 16:33:24",
                    "url" => "url2",
                    "title" => "title2",
                    "date" => "2020/02/29 16:33:24",
                ],
                [
                    "url" => "url3",
                    "title" => "title3",
                    "date" => "2020/03/29 16:33:24",
                    "url" => "url3",
                    "title" => "title3",
                    "date" => "2020/03/29 16:33:24",
                    "url" => "url3",
                    "title" => "title3",
                    "date" => "2020/03/29 16:33:24",
                    "url" => "url3",
                    "title" => "title3",
                    "date" => "2020/03/29 16:33:24",
                ],
                [
                    "url" => "url4",
                    "title" => "title4",
                    "date" => "2020/04/29 16:33:24",
                    "url" => "url4",
                    "title" => "title4",
                    "date" => "2020/04/29 16:33:24",
                ],
                [
                    "url" => "url5",
                    "title" => "title5",
                    "date" => "2020/05/29 16:33:24",
                    "url" => "url5",
                    "title" => "title5",
                    "date" => "2020/05/29 16:33:24",
                    "url" => "url5",
                    "title" => "title5",
                    "date" => "2020/05/29 16:33:24",
                    "url" => "url5",
                    "title" => "title5",
                    "date" => "2020/05/29 16:33:24",
                ],
                [
                    "url" => "url6",
                    "title" => "title6",
                    "date" => "2020/06/29 16:33:24",
                    "url" => "url6",
                    "title" => "title6",
                    "date" => "2020/06/29 16:33:24",
                ],

            ];

            $responseData["data"] = array_merge($responseData["data"], $responseData["data"]);
            $responseData["data"] = array_merge($responseData["data"], $responseData["data"]);

            if ($responseData["success"] == "true" && is_array($responseData["data"]) && count($responseData["data"]) > 0 && $responseData["data"] != "") {

                $responseFormatData = $this->summaryReportFormatData($responseData["data"]);

                if ($responseFormatData) {

                    $returnResponse["success"] = "true";

                    $returnResponse["data"] = $responseFormatData;

                    if (isset($responseData["result_count"]) && $responseData["result_count"] != "") {

                        $returnResponse["recordsTotal"] = $responseData["result_count"];

                    } else if (is_array($responseFormatData)) {

                        $returnResponse["recordsTotal"] = count($responseFormatData);

                    }

                    if (is_array($responseFormatData)) {

                        $returnResponse["recordsFiltered"] = count($responseFormatData);

                    }

                }
            }
        } catch (Exception $e) {

            $returnResponse["error"] = "true";
            $returnResponse["message"] = $e->getMessage();
            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

        return $returnResponse;
    }

    public function summaryReportFormatData($items)
    {

        $s_no = 0;

        $resource = array_map(

            function ($item) use(&$s_no) {

                if(is_array($item) && count($item)) {

                    $s_no = $s_no + 1;

                    $item["s_no"] = $s_no;

                }

                return $item;

            },

            $items

        );

        return $resource;

    }

}
