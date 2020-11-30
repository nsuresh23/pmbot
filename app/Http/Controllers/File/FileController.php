<?php

namespace App\Http\Controllers\File;

use Session;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\General\Helper;
use App\Http\Controllers\Controller;
use App\Traits\General\CustomLogger;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

    use Helper;

    use CustomLogger;

    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
    }

    /**
     * Get file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getFile(Request $request)
    {

        $imageFolderPath = "";

        try {

            if (isset($request->fileserver) && $request->fileserver != "" && isset($request->img_path) && $request->img_path != "") {

                if ($request->fileserver == "1") {

                    $imageFolderPath     = str_replace("\\", "/", $request->img_path);
                    $imageFolderPath    = str_replace("//ppdys-fs03/TSG/Technology/RAD/TechUtilities/PMBot/emails/", "", $imageFolderPath);
                    $imageFolderPath    = str_replace("//172.24.134.26/TSG/Technology/RAD/TechUtilities/PMBot/emails/", "", $imageFolderPath);
                    $imageFolderPath     = "/mnt/ppdysfs03_pmbot_emails/" . $imageFolderPath;

                    header('Content-Type: image/png');

                    if (isset($request->alais_name) && $request->alais_name != "") {

                        $filename = "filename=" . $request->alais_name;

                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; ' . $filename);
                        header('Content-Transfer-Encoding: binary');

                    }

                    readfile($imageFolderPath);

                }

                if ($request->fileserver == "2") {

                    $imageFolderPath     = str_replace("\\", "/", $request->img_path);

                    // Storage::disk('s3')->put($imageFolderPath, file_get_contents($imageFolderPath));

                    if(isset($request->alais_name) && $request->alais_name != "") {

                        return Storage::disk('s3')->download($imageFolderPath, $request->alais_name);

                    }

                    return Storage::disk('s3')->download($imageFolderPath);

                }

            }

        } catch (Exception $e) {

            $this->error(
                "app_error_log_" . date('Y-m-d'),
                " => FILE => " . __FILE__ . " => " .
                    " => LINE => " . __LINE__ . " => " .
                    " => MESSAGE => " . $e->getMessage() . " "
            );
        }

    }

    /**
     * Upload file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fileUpload(Request $request)
    {

        $imageFolderPath = "";

        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            if ($_FILES['file']['name']) {

                if (!$_FILES['file']['error']) {

                    $filename = $_FILES['file']['name'];
                    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                    $rand = substr(str_shuffle($permitted_chars), 0, 8);
                    $guid = date('Y-m-d-hms') . '-' . $rand;
                    $currentTime = date('Y') . '\\' . date('n') . '\\' . date('j') . '\\' . $guid;
                    $uploadPath = strtoupper(auth()->user()->empcode) . '\\' . $currentTime . '\\';
                    $imageFolderPath = env('UPLOAD_FILE_ROUTE_PATH', storage_path('app')) . '\\' . $uploadPath;

                    $imageFolderPath .= $filename;

                    $location = $_FILES["file"]["tmp_name"];

                    Storage::disk('s3')->put($imageFolderPath, file_get_contents($location));

                    $url = env('APP_URL');

                    $url .= '/file';

                    $url .= Config::get('constants.emailImageDownloadPathParams');

                    $url .= $imageFolderPath;

                    $returnResponse["success"] = "true";

                    $returnResponse["data"] = ["url" => $url, "filename" => $filename]; //change this URL

                } else {

                    $returnResponse["error"] = "true";
                    $returnResponse["message"] = $_FILES['file']['error'];

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

}
