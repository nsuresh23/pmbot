<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\WorkRequest;
use App\Models\Jobs;
use App\Models\TicketInfo;
use Auth;
use Activity;
use DB;

use App\Traits\General\Helper;

class HomeController extends Controller
{
	use Helper;
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
	}

	public function storeMedia(Request $request)
	{

		$returnResponse = [];

		try {

			$returnResponse =  $this->dropzoneMediaUpload($request);

		} catch (Exeception $e) {

			$returnResponse["success"] = "false";
			$returnResponse["error"] = "true";
			$returnResponse["data"] = [];
			$returnResponse["message"] = $e->getMessage();
		}

		return $returnResponse;

	}

	public function UpdatePageAnalysis(Request $request){
		$starttime     = $request->starttime;
		$endtime       = date('Y-m-d H:i:s');
		$modified_date = date('Y-m-d H:i:s');
		$ip_address    = $_SERVER['REMOTE_ADDR'];
		$pagurl        = $request->pageurl;
		
		
		$list = DB::select( DB::raw('INSERT INTO `page_analysis` (page_name,start_time,end_time,ip,modified_date) VALUES ("'.$pagurl.'", "'.$starttime.'", "'.$endtime.'", "'.$ip_address.'", "'.$modified_date.'")'));
	}
}
?>