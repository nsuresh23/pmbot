<?php

namespace App\Traits\General;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\MessageFormatter;
use App\Traits\General\CustomLogger;

trait ApiClient
{
    // protected $baseUrl;

    // public function __construct()
    // {
    // 	$this->baseUrl = env('API_BASE_URL');
    // }

    // public function getData($url, $param)
    // {
    //     $client = new Client();
    // 	$response = $client->request('GET', $url);
    // 	$statusCode = $response->getStatusCode();
    // 	$body = $response->getBody()->getContents();

    //     return $body;

    //     // $client = new Client();
    //     // $res = $client->get($url);
    //     // //echo $res->getBody();
    //     // $persons = json_decode($res->getBody()->getContents());


    //     // return view('persons.index', compact('persons'));
    // }

    protected $apiClient;

	// public function __construct(Client $client)
	public function __construct()
	{

		// $this->apiClient = new Client([
        //     // Base URI is used with relative requests
        //     'base_uri' =>  env('API_BASE_URL'),
        //     // You can set any number of default request options.
        //     // 'timeout'  => 2.0,
        // ]);

	}

	// public function all()
	// {
	// 	return $this->endpointRequest('/dummy/posts');
	// }

	// public function findById($id)
	// {
	// 	return $this->endpointRequest('/dummy/post/'.$id);
	// }

	public function getRequest($url)
	{

        // $url = "";

        $returnResponse = [];

		try {

            $response = "";

            // if($requestUrl) {

            //     $url = $this->baseUrl . $requestUrl;

            // }

            $logger = new Logger('api_log');

            $logger->pushHandler(new StreamHandler(storage_path("/logs/api_log-" . date('Y-m-d') . ".log"), Logger::INFO));

            $stack = HandlerStack::create();

            $stack->push(Middleware::log(
                $logger,
                // new MessageFormatter('{req_body} - {res_body}')
                new MessageFormatter(
                    // nl2br(
                    '<================================= REQUEST ===============================> ' . "\n" .

                        'URL => {uri},' . "\n" .
                        'Method => {method},' . "\n" .
                        'Host => {host},' . "\n" .
                        'Host Name => {hostname},' . "\n" .
                        'Request Headers => {req_headers},' . "\n" .
                        'Response Data => {req_body},' . "\n" .

                    '<================================= RESPONSE ===============================>' . "\n" .

                        'Response Headers => {res_headers},' . "\n" .
                        // 'Response Data => {res_body},' . "\n" .
                        'Code => {code},' . "\n" .
                        'Error => {error},' . "\n"

                    // )
                )
            ));

            $apiClient = new Client([
                // Base URI is used with relative requests
                'base_uri' =>  env('API_BASE_URL'),
                'handler' => $stack,
                // You can set any number of default request options.
                // 'timeout'  => 2.0,
            ]);

            $response = $apiClient->request('GET', $url);

            if ($response) {

                $returnResponse =  $this->response_handler($response->getBody()->getContents());
            }

		} catch (Exception $e) {

            // return $e->getMessage();

            $this->error(
                "api_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );

		}

		return $returnResponse;
    }

    public function postRequest($url, $paramData)
    {

        $returnResponse = [];

        $params = [];

        try {

            $response = "";

            // if ($requestUrl) {

            //     $url = $this->baseUrl . $requestUrl;
            // }

            if(isset($paramData["title"]) && $paramData["title"] != "") {

                // $paramData["title"] = gzencode($paramData["title"]);
                $paramData["title"] = base64_encode($paramData["title"]);

            }

            if (isset($paramData["description"]) && $paramData["description"] != "") {

                // $paramData["description"] = gzencode($paramData["description"]);
                $paramData["description"] = base64_encode($paramData["description"]);

            }

            if (isset($paramData["additional_note"]) && $paramData["additional_note"] != "") {

                $paramData["additional_note"] = base64_encode($paramData["additional_note"]);
            }

            if (isset($paramData["attachment_path"]) && $paramData["attachment_path"] != "") {

                $paramData["attachment_path"] = base64_encode($paramData["attachment_path"]);
            }

            if (count($paramData) > 0) {

                $params['json'] = $paramData;
            }

            $logger = new Logger('api_log');

            $logger->pushHandler(new StreamHandler(storage_path("/logs/api_log-" . date('Y-m-d') . ".log"), Logger::INFO));

            $stack = HandlerStack::create();

            $stack->push(Middleware::log(
                $logger,
                // new MessageFormatter('{req_body} - {res_body}')
                // new MessageFormatter('{req_body} - {res_body}')
                new MessageFormatter(
                    // nl2br(
                    '<================================= REQUEST ===============================> ' . "\n" .

                        'URL => {uri},' . "\n" .
                        'Method => {method},' . "\n" .
                        'Host => {host},' . "\n" .
                        'Host Name => {hostname},' . "\n" .
                        'Request Headers => {req_headers},' . "\n" .
                        'Request Data => {req_body},' . "\n" .

                    '<================================= RESPONSE ===============================>' . "\n" .

                        'Response => {res_headers},' . "\n" .
                        // '{res_body},' . "\n" .
                        // 'Response Data => {res_body},' . "\n" .
                        'Code => {code},' . "\n" .
                        'Error => {error}'

                    // )
                )
            ));

            $apiClient = new Client([
                // Base URI is used with relative requests
                'base_uri' =>  env('API_BASE_URL'),
                'handler' => $stack,
                // You can set any number of default request options.
                // 'timeout'  => 2.0,
            ]);

            // if ($url == "tasklist") {

            //     echo '<PRE/>';
            //     echo 'LINE => ' . __LINE__;
            //     echo '<PRE/>';
            //     echo 'CAPTION => CaptionName';
            //     echo '<PRE/>';
            //     print_r($response);
            //     echo '<PRE/>';
            //     exit;
            // }


            $response = $apiClient->request('POST', $url, $params);

            if($response) {

                $returnResponse =  $this->response_handler($response->getBody()->getContents());

            }

        } catch (Exception $e) {

            // return $e->getMessage();
            $this->error(
                "api_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                " => LINE => " . __LINE__ . " => " .
                " => MESSAGE => " . $e->getMessage() . " "
            );

        }

        return $returnResponse;
    }

	public function response_handler($response)
	{
        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "message" => "",
            "data" => ""
        ];

        $response = json_decode($response, true);

        $this->info(
            "api_log-" . date('Y-m-d'),
            " => RESPONSE => " . json_encode($response)
        );

        if ($response && is_array($response) && count($response) > 0 && isset($response["result"])) {

            if (is_array($response) && count($response["result"]) > 0 && isset($response["result"]["status"]) && $response["result"]["status"] == "1") {

                $returnResponse["success"] = "true";

                // if (isset($response["result"]["data"]["title"]) && $response["result"]["data"]["title"] != "") {

                //     // $response["result"]["data"]["title"] = gzdecode($response["result"]["data"]["title"]);

                //     if (base64_decode($response["result"]["data"]["title"], true)) {

                //         $response["result"]["data"]["title"] = base64_decode($response["result"]["data"]["title"]);

                //     }

                // }

                // if (isset($response["result"]["data"]["description"]) && $response["result"]["data"]["description"] != "") {

                //     if (base64_decode($response["result"]["data"]["description"], true)) {

                //         $response["result"]["data"]["description"] = base64_decode($response["result"]["data"]["description"]);
                //     }

                // }

                // if (isset($response["result"]["data"]["additional_note"]) && $response["result"]["data"]["additional_note"] != "") {

                //     if (base64_decode($response["result"]["data"]["additional_note"], true)) {

                //         $response["result"]["data"]["additional_note"] = base64_decode($response["result"]["data"]["additional_note"]);
                //     }

                // }

                // if (isset($response["result"]["data"]["attachment_path"]) && $response["result"]["data"]["attachment_path"] != "") {

                //     if (base64_decode($response["result"]["data"]["attachment_path"], true)) {

                //         $response["result"]["data"]["attachment_path"] = base64_decode($response["result"]["data"]["attachment_path"]);
                //     }

                // }

                // if (isset($response["result"]["data"]["parent_description"]) && $response["result"]["data"]["parent_description"] != "") {

                //     if (base64_decode($response["result"]["data"]["parent_description"], true)) {

                //         $response["result"]["data"]["parent_description"] = base64_decode($response["result"]["data"]["parent_description"]);

                //     }
                // }

                $returnResponse["data"] = $response["result"]["data"];

            } else {

                // $returnResponse["error"] = "true";
                $returnResponse["message"] = $response["result"]["error_msg"];

            }

        }

		// return json_decode($returnResponse);
		return $returnResponse;
	}
}
