<?php

namespace App\Http\Controllers\File;

use Session;
use Exception;
use SimpleXMLElement;
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
                    readfile($imageFolderPath);

                }

                if ($request->fileserver == "2") {

                    $imageFolderPath     = str_replace("\\", "/", $request->img_path);

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

}
