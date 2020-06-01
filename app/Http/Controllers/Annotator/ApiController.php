<?php

namespace App\Http\Controllers\Annotator;

use Session;
use Exception;
use Illuminate\Http\Request;
use App\Traits\General\Helper;
use App\Http\Controllers\Controller;
use App\Traits\General\CustomLogger;
use App\Models\Annotation;
use Illuminate\Support\Facades\Config;
//use App\Resources\Annotator\AnnotatorCollection as AnnotatorResource;

use Laravel\Lumen\Routing\Controller as BaseController;
use Auth;
use Activity;
use DB;
use App\Paginations\pagination;


class ApiController extends Controller
{

    use Helper;

    use CustomLogger;

    protected $jobResource = "";

    protected $AnnotatorResource = "";

    public function __construct()
    {

        //$this->annotatorResource = new AnnotatorResource();

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
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getannotatoremail(Request $request)
    {
        $returnData = [];
        $emailData = DB::select(DB::raw("SELECT id, email_id, subject,email_from,email_to, body_html,email_received_date,attachments,email_path from email_box where id = '" . $request->id . "' and email_id = '" . auth()->user()->empcode . "'  limit 0,1"));
        $returnData['emailData']     = $emailData;
        $returnData['id']             = $request->id;
        $returnData['empcode']         = auth()->user()->empcode;
        return view("pages.annotator.emailDetail", compact("returnData"));
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getresult(Request $request)
    {

        $id            = $request->id;
        $empcode    = auth()->user()->empcode;
        $sql = "SELECT id,email_id,job_id,subject,email_from,email_to,email_cc,email_bcc,body_html,email_received_date,attachments,email_path,status from email_box where id = '" . $id . "' and email_id = '" . auth()->user()->empcode . "' ";
        $filedownloadlink    =    env('ANNOTATIONEMAILFILEDOWNLOADED');


        $query         =  $sql . " limit 0 , 1";
        $list         = DB::connection('mysql')->select(DB::raw($query));
        $emailcount = DB::connection('mysql')->select(DB::raw($sql));
        if (!empty($list)) {

            if ($list[0]->job_id != '') {
                $womatidsql    = "SELECT * from jobs where job_id = '" . $list[0]->job_id . "'";
                $womatidsqllists    = DB::connection('mysql')->select(DB::raw($womatidsql));
            }

            $Annotationsql    = "SELECT * from annotations where page_id = '" . $id . "'";
            $Annotationlists    = DB::connection('mysql')->select(DB::raw($Annotationsql));

            $output = '';
            $mailattachdnt = '';
            $loop_attach = '';
            $output .= '<div class="col-md-9">';

            foreach ($list as $k => $v) {
                if ($list[$k]->attachments != '') {
                    $attachment    = explode('|', base64_decode($list[$k]->attachments));
                    foreach ($attachment as $attach) {
                        if (!empty($attach)) {
                            $ext = pathinfo($attach, PATHINFO_EXTENSION);
                            if ($ext == 'docx' || $ext == 'doc') {
                                $loop_attach .= '<li><a class="mailbox-attachment-name" href="' . $filedownloadlink . '?fileserver=1&img_path=' . $list[$k]->email_path . '/' . $attach . '" target="_blank"><span class="mailbox-attachment-icon"><i class="fa fa-file-word-o"></i></span></a><div class="mailbox-attachment-info"> <a class="mailbox-attachment-name" href="' . $filedownloadlink . '?fileserver=1&img_path=' . $list[$k]->email_path . '/' . $attach . '" target="_blank"><i class="fa fa-paperclip"></i>&nbsp;' . $attach . '</a> <span class="mailbox-attachment-size">&nbsp;&nbsp;<a class="btn btn-default btn-xs pull-right" href="' . $filedownloadlink . '?fileserver=1&img_path=' . $list[$k]->email_path . '/' . $attach . '" target="_blank"><i class="fa fa-cloud-download"></i></a> </span></div></li>';
                            } else if ($ext == 'pdf') {
                                $loop_attach .= '<li><a class="mailbox-attachment-name" href="' . $filedownloadlink . '?fileserver=1&img_path=' . $list[$k]->email_path . '/' . $attach . '" target="_blank"><span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span></a><div class="mailbox-attachment-info"> <a class="mailbox-attachment-name" href="' . $filedownloadlink . '?fileserver=1&img_path=' . $list[$k]->email_path . '/' . $attach . '" target="_blank"><i class="fa fa-paperclip"></i>&nbsp;' . $attach . '</a> <span class="mailbox-attachment-size">&nbsp;&nbsp;<a class="btn btn-default btn-xs pull-right" href="' . $filedownloadlink . '?fileserver=1&img_path=' . $list[$k]->email_path . '/' . $attach . '" target="_blank"><i class="fa fa-cloud-download"></i></a> </span></div></li>';
                            } else {
                                $loop_attach .= '<li><a class="mailbox-attachment-name" href="' . $filedownloadlink . '?fileserver=1&img_path=' . $list[$k]->email_path . '/' . $attach . '" target="_blank"><span class="mailbox-attachment-icon"><i class="fa fa-file-picture-o"></i></span></a><div class="mailbox-attachment-info"> <a class="mailbox-attachment-name" href="' . $filedownloadlink . '?fileserver=1&img_path=' . $list[$k]->email_path . '/' . $attach . '" target="_blank"><i class="fa fa-paperclip"></i>&nbsp;' . $attach . '</a> <span class="mailbox-attachment-size">&nbsp;&nbsp;<a class="btn btn-default btn-xs pull-right" href="' . $filedownloadlink . '?fileserver=1&img_path=' . $list[$k]->email_path . '/' . $attach . '" target="_blank"><i class="fa fa-cloud-download"></i></a> </span></div></li>';
                            }
                        }
                    }
                }



                $mailattachdnt = '<div class="box-footer"><ul class="mailbox-attachments clearfix">' . $loop_attach . '</ul></div>';
                $output .= '<script>document.getElementById("emailid").value=' . $list[$k]->id . ';</script>';
                $output .= '<div class="emailid"><input type="hidden" id="emailid" name="emailid" value="' . $list[$k]->id . '" /></div>';
                $output .= '<div class="question"><input type="hidden" id="rowcount" name="rowcount" value="1" /></div>';
                if (@$Annotationlists[0]->page_id != '') {
                    $output .= '<div class="annotationID"><input type="hidden" id="annotationID" name="annotationID" value="' . $Annotationlists[0]->jobid . '" /></div>';
                } else {
                    $output .= '<div class="annotationID"><input type="hidden" id="annotationID" name="annotationID" value="" /></div>';
                }

                if ($list[0]->job_id != '') {
                    $output .= '<div class="womatRefID"><input type="hidden" id="womatRefID" name="womatRefID" value="' . $womatidsqllists[0]->womat_job_id . '" /></div>';
                } else {
                    $output .= '<div class="womatRefID"><input type="hidden" id="womatRefID" name="womatRefID" value="" /></div>';
                }

                if ($list[0]->job_id != '') {
                    $output .= '<div class="womatRefID"><input type="hidden" id="associatejobid" name="associatejobid" value="' . $list[0]->job_id . '" /></div>';
                } else {
                    $output .= '<div class="womatRefID"><input type="hidden" id="associatejobid" name="associatejobid" value="" /></div>';
                }



                $regformat = '/[0-9]{6}\_[0-9]{1}\_En/m';
                preg_match_all($regformat, base64_decode($list[$k]->subject), $matches, PREG_SET_ORDER, 0);
                //$matches[0][0] = '471607_1_En';
                if (@$matches[0][0] != '') {
                    $output .= '<div class="emailid"><input type="hidden" id="mailsubject" name="mailsubject" value="' . $matches[0][0] . '" /></div>';
                } else {
                    $output .= '<div class="emailid"><input type="hidden" id="mailsubject" name="mailsubject" value="" /></div>';
                }

                if ($list[$k]->email_from != '') {

                    if (base64_decode($list[$k]->email_from, true)) {

                        $list[$k]->email_from = base64_decode($list[$k]->email_from);
                    }
                }

                if ($list[$k]->email_to != '') {

                    if (base64_decode($list[$k]->email_to, true)) {

                        $list[$k]->email_to = base64_decode($list[$k]->email_to);
                    }
                }

                if ($list[$k]->email_cc != '') {

                    if (base64_decode($list[$k]->email_cc, true)) {

                        $list[$k]->email_cc = base64_decode($list[$k]->email_cc);
                    }
                }

                if ($list[$k]->email_bcc != '') {

                    if (base64_decode($list[$k]->email_bcc, true)) {

                        $list[$k]->email_bcc = base64_decode($list[$k]->email_bcc);
                    }
                }

                if ($list[$k]->email_cc != '') {

                    $cc = '<h5>CC: ' . htmlspecialchars($list[$k]->email_cc) . '</span></h5>';
                } else {
                    $cc = '';
                }

                if ($list[$k]->email_bcc != '') {
                    $bcc = '<h5>Bcc: ' . htmlspecialchars($list[$k]->email_bcc) . '</span></h5>';
                } else {
                    $bcc = '';
                }

                if ($list[$k]->status != '0') {
                    $hide = 'no-copy';
                } else {
                    $hide = '';
                }

                if ($list[$k]->email_received_date != '') {
                    $email_recdate    = date('j<\s\up>S</\s\up> M. Y h:i A', strtotime($list[$k]->email_received_date));
                } else {
                    $email_recdate    = '';
                }

                if (base64_decode($list[$k]->body_html, true)) {
                    $bodyhtml = base64_decode($list[$k]->body_html);
                } else {
                    // not valid
                    $bodyhtml = $list[$k]->body_html;
                }


                $output .= '<div class="box box-warning ' . $hide . '"><div class="box-body no-padding"><div id="mailbodycontent" class="no-copy"><div class="mailbox-read-info"><h3>' . base64_decode($list[$k]->subject) . '</h3><h5>From: ' . htmlspecialchars($list[$k]->email_from) . ' <span class="mailbox-read-time pull-right">' . $email_recdate . '</span></h5><h5>To: ' . htmlspecialchars($list[$k]->email_to) . '</span>' . $cc . '' . $bcc . '</h5></div><div class="mailbox-read-message"> ' . $bodyhtml . '  </div></div></div>' . $mailattachdnt . '</div>';
            }

            $output .= '</div>';

            return response()->json(['msg' => $output,  'status' => $list[$k]->status]);
        } else {
            return response()->json(['msg' => '',  'status' => '-1']);
        }




        //$update = 'update ee_mail_body set annotate_status = "pending" where email_id = "'.$list[0]->email_id.'"';
        //$emailcount = DB::connection('mysql')->select(DB::raw($update));
        //return $output;

    }

    public function search(Request $request)
    {
        $annotations = Annotation::where('page_id', $request->get('page'))->get();
        //echo '<script>document.getElementById("ajaxannotationdata").value='.count($annotations).';<\/script>';
        return response()->json(['total' => count($annotations), 'rows' => $annotations]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if(isset($data["jobid"]) && $data["jobid"] != "") {

            $jobId = $data["jobid"];

            // if($jobId != "pmbot_generic") {

                $Annotationstage    = "SELECT stage from jobs where job_id = '" . $data['jobid'] . "'";
                $stagelists    = DB::connection('mysql')->select(DB::raw($Annotationstage));

            // }

        }

        if (array_key_exists('text', $data)) {
            $text = $data['text'];
        } else {
            $text = '';
        }

        $taskdescription = $data['taskdesc'];
        $tasktitle          = $data['tasktitle'];
        $tasknotes          = $data['tasknotes'];
        $emailnotation     = $data['emailnotation'];
        $stage              = "";

        // if ($jobId != "pmbot_generic") {

            $stage              = $stagelists[0]->stage;

        // }

        if (is_null($data['attachment'])) {
            $attachment = '';
        } else {
            $attachment = implode(',', $data['attachment']);
        }

        if (is_null($data['newattachment'])) {
            $newattachment = '';
        } else {
            $newattachment = implode(',', $data['newattachment']);
        }

        if (is_null($data['emailnotation'])) {
            $emailnotation = '';
        } else {
            $emailnotation = $data['emailnotation'];
        }

        if (is_null($data['category']) || empty($data['category'])) {
            $category = '0';
        } else {
            $category = $data['category'];
        }

        $annotation = [
            'ranges'              => isset($data['ranges']) ? $data['ranges'] : "",
            'quote'               => isset($data['quote']) ? $data['quote'] : "",
            'jobid'               => $jobId,
            'stage'               => $stage,
            'createdempcode'       => isset($data['createdempcode']) ? $data['createdempcode'] : "",
            'userid'               => isset($data['section'])? implode(',', $data['section']) : "" ,
            'attachment'           => $attachment,
            'additionalattach'    => $newattachment,
            'emailnotation'        => $emailnotation,
            'text'                => isset($data['section_title']) ? $data['section_title'] : "",
            'category'            => $category,
            'annotationid'         => isset($data['annotationid']) ? $data['annotationid'] : "",
            'taskdescription'      => $taskdescription,
            'tasknotes'          => $tasknotes,
            'tasktitle'          => $tasktitle,
            'page_id'             => isset($data['page']) ? $data['page'] : "",
        ];
        try {
            $annotation = Annotation::create($annotation);

            return response()->json(['status' => 'success', 'id' => $annotation->id]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function completetaskdetail(Request $request)
    {
        $empcode    =    auth()->user()->empcode;             //API Url
        $id         =    $_POST['id'];
        $jobid      =    $_POST['jobid'];
        $start_time =    $_POST['start_time'];

        $isGeneric = "false";

        if(isset($_POST["is_generic"]) && $_POST["is_generic"] == "true") {

            $isGeneric = "true";

        }

        $Annotationsql    = "SELECT * from annotations where page_id = '" . $id . "' and createdempcode ='" . $empcode . "' ";
        $Annotationlists    = DB::connection('mysql')->select(DB::raw($Annotationsql));
        if (!empty($Annotationlists)) {
            foreach ($Annotationlists as $completedlist) {
                if ($completedlist->category != '0') {
                    $jsonDataTaskNotes = array(                        //The JSON data.
                        "task_id" => $completedlist->category,
                        "job_id"  => $completedlist->jobid,
                        "email_id"  => $completedlist->page_id,
                        "title"   => base64_encode($completedlist->tasktitle),
                        "status_previous" => "progress",
                        "createdby_status" => "pending",
                        "assignedto_status" => "completed",
                        "id" => '',
                        "additional_note" => base64_encode($completedlist->tasknotes),
                        "attachment_path" => base64_encode($completedlist->attachment),
                        "empcode" => $completedlist->userid,
                        "empname" => $completedlist->userid,
                        "emprole" => "project_manager"
                    );

                    if($start_time != "") {

                        $jsonDataTaskNotes["start_time"] = $start_time;
                        $jsonDataTaskNotes["ip_address"] = request()->ip();

                    }
                    $jsonDataNotesEncoded = json_encode($jsonDataTaskNotes);
                    // once taks created create task notes
                    //API Request to save data to PMBOT DATABASE TASKNOTES
                    $insertnewtasknotes_url    =    env('INSERTNEWTASKNOTES');
                    $ch = curl_init($insertnewtasknotes_url);            //Initiate cURL.
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLINFO_HEADER_OUT, true);

                    //Tell cURL that we want to send a POST request.
                    curl_setopt($ch, CURLOPT_POST, true);
                    //Attach our encoded JSON string to the POST fields.
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataNotesEncoded);
                    //Set the content type to application/json
                    // Set HTTP Header for POST request
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($jsonDataNotesEncoded)));

                    // Submit the POST request
                    $resultnotes = curl_exec($ch);
                    // Close cURL session handle
                    curl_close($ch);
                } else {
                    $searchForValue = ',';
                    if (strpos($completedlist->userid,  $searchForValue) !== false) {
                        $userlist = explode(',', $completedlist->userid);
                        $taskassignuser = array();
                        foreach ($userlist as $kk => $assignuser) {
                            $taskassignuser[$kk]['empcode']             = $assignuser;
                            $taskassignuser[$kk]['additional_note']        = base64_encode($completedlist->tasknotes);
                            $taskassignuser[$kk]['description']         = base64_encode($completedlist->taskdescription);
                            $taskassignuser[$kk]['attachment_path']     = base64_encode($completedlist->attachment);
                        }
                        //$taskassignuser = json_encode($taskassignuser);
                        $jsonData = array(
                            "attachment_path" => base64_encode($completedlist->attachment),
                            "partialcomplete" => "0",
                            "previousPartialcomplete" => '',
                            "stage" => $completedlist->stage,
                            "job_id" => $completedlist->jobid,
                            "email_id"  => $completedlist->page_id,
                            "category" => "medium",
                            "assignedto_empcode" => $completedlist->createdempcode,
                            "users" => $taskassignuser,
                            "title" => base64_encode($completedlist->tasktitle),
                            "description" => base64_encode($completedlist->taskdescription),
                            "createdby_empcode" => $completedlist->createdempcode,
                            "createdby_empname" => $completedlist->createdempcode,
                            "createdby_role" => "project_manager",
                            "createdby_status" => "completed",
                            "assignedto_status" => "pending",
                            "status" => "progress",
                            "type" => "task",
                        );
                    } else {
                        $jsonData = array(                        //The JSON data.	/// single user
                            "attachment_path" => base64_encode($completedlist->attachment),
                            "additional_note" => base64_encode($completedlist->tasknotes),
                            "partialcomplete" => "0",
                            "previousPartialcomplete" => '',
                            "stage" => $completedlist->stage,
                            "job_id" => $completedlist->jobid,
                            "email_id"  => $completedlist->page_id,
                            "category" => "medium",
                            "assignedto_empcode" => $completedlist->userid,
                            "title" => base64_encode($completedlist->tasktitle),
                            "description" => base64_encode($completedlist->taskdescription),
                            "createdby_empcode" => $completedlist->createdempcode,
                            "createdby_empname" => $completedlist->createdempcode,
                            "createdby_role" => "project_manager",
                            "createdby_status" => "completed",
                            "assignedto_status" => "pending",
                            "status" => "progress",
                            "type" => "task"
                        );
                    }

                    if ($start_time != "") {

                        $jsonData["start_time"] = $start_time;
                        $jsonData["ip_address"] = request()->ip();

                    }

                    // if ($isGeneric == "true") {

                    //     $jsonData["pmbot_type"] = "generic";

                    // }

                    $jsonDataEncoded = json_encode($jsonData);

                    //API Request to save data to PMBOT DATABASE
                    $insertnewtask_url    =    env('INSERTNEWTASK');
                    // Prepare new cURL resource
                    $ch = curl_init($insertnewtask_url);            //Initiate cURL.

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLINFO_HEADER_OUT, true);

                    //Tell cURL that we want to send a POST request.
                    curl_setopt($ch, CURLOPT_POST, true);
                    //Attach our encoded JSON string to the POST fields.
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
                    //Set the content type to application/json
                    // Set HTTP Header for POST request
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($jsonDataEncoded)));

                    // Submit the POST request
                    $result = curl_exec($ch);
                    // Close cURL session handle
                    curl_close($ch);
                }
            }
        } else {
            $jsonData = array(                        //The JSON data.
                'id' => $id,
                'job_id' => $jobid,
                'status' => '2',
            );

            // if($isGeneric == "true" ) {

            //     // $jsonData["status"] = '1';
            //     // $jsonData["type"] = 'generic';

            // }

            if ($start_time != "") {

                $jsonData["start_time"] = $start_time;
                $jsonData["ip_address"] = request()->ip();

            }

            $jsonDataEncoded = json_encode($jsonData);
            //API Request to save data to PMBOT DATABASE
            $completedtask_url    =    env('NONANNOTATECOMPLETEDJOB');
            // Prepare new cURL resource
            $ch = curl_init($completedtask_url);            //Initiate cURL.

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);

            //Tell cURL that we want to send a POST request.
            curl_setopt($ch, CURLOPT_POST, true);
            //Attach our encoded JSON string to the POST fields.
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
            //Set the content type to application/json
            // Set HTTP Header for POST request
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($jsonDataEncoded)));

            // Submit the POST request
            $result = curl_exec($ch);
            // Close cURL session handle
            curl_close($ch);
        }

        $update = 'update annotations set status = "completed" where page_id = "' . $id . '" and createdempcode ="' . $empcode . '"';
        $emailcount = DB::connection('mysql')->select(DB::raw($update));
        return response()->json(['message' => 'Email annotator task completed success!!', 'status' => '1']);
    }

    public function newattachment(Request $request)
    {
        $Task_Additional_Attachment    =    env('Task_Additional_Attachment');
        if (isset($_FILES['keysfile'])) {
            // Count total files
            $countfiles = count($_FILES['keysfile']['name']);
            // Looping all files
            $additional_attach = array();
            for ($i = 0; $i < $countfiles; $i++) {
                $filename = $_FILES['keysfile']['name'][$i];
                $additional_attach[] = $_FILES['keysfile']['name'][$i];
                // Upload file
                //move_uploaded_file($_FILES['keysfile']['tmp_name'][$i], $Task_Additional_Attachment.'/'.date('ymdHis').'/'.$filename);
                move_uploaded_file($_FILES['keysfile']['tmp_name'][$i], $Task_Additional_Attachment . '/' . $filename);
            }
            return response()->json(['message' => $additional_attach]);
        }
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getpmbotjoblist(Request $request)
    {
        if ($_POST['empcode'] != '') {
            $empcode        =    $_POST['empcode'];             //API Url
            $subject        =    $_POST['subject'];
            $annotationID    =    $_POST['annotationID'];
            $associatejobid    =    $_POST['associatejobid'];


            $getjobid_url    =    env('GETPMJOBID');



            $getjoblist_url    =    env('GETPMJOBLIST');
            // Prepare new cURL resource
            $ch = curl_init($getjobid_url);            //Initiate cURL.
            $jsonData = array(                        //The JSON data.
                'order_id' => $subject,
                'pm_empcode' => $empcode
            );

            $jsonDataEncoded = json_encode($jsonData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            //Encode the array into JSON.
            $jsonDataEncoded = json_encode($jsonData);
            //Tell cURL that we want to send a POST request.
            curl_setopt($ch, CURLOPT_POST, true);
            //Attach our encoded JSON string to the POST fields.
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
            //Set the content type to application/json
            // Set HTTP Header for POST request
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($jsonDataEncoded)));

            // Submit the POST request
            $result = curl_exec($ch);
            // Close cURL session handle
            curl_close($ch);
            $json_data_decoded = json_decode($result, true);

            if ($json_data_decoded['result']['status'] == '0') {
                // Prepare new cURL resource
                $ch = curl_init($getjoblist_url);            //Initiate cURL.

                $jsonData = array(                        //The JSON data.
                    'pm_empcode' => $empcode,
                    'stage' => '',
                    'status' => 'progress'
                );

                $jsonDataEncoded = json_encode($jsonData);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                //Encode the array into JSON.
                $jsonDataEncoded = json_encode($jsonData);
                //Tell cURL that we want to send a POST request.
                curl_setopt($ch, CURLOPT_POST, true);
                //Attach our encoded JSON string to the POST fields.
                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
                //Set the content type to application/json
                // Set HTTP Header for POST request
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($jsonDataEncoded)));

                // Submit the POST request
                $result = curl_exec($ch);
                // Close cURL session handle
                curl_close($ch);
                $json_data_decoded = json_decode($result, true);

                if ($annotationID == '') {
                    $output = '<select id="pmjobid"  onchange="getjobID()">'; //multiple="multiple"
                } else {
                    $output = '<select id="pmjobid">'; //multiple="multiple"
                }
                $output .= '<option disabled selected>--select--</option>';
                foreach ($json_data_decoded['result']['data'] as $key => $val) {
                    if ($annotationID != '') {
                        if ($val['job_id'] == $annotationID) {
                            $output .= '<option value="' . $val['job_id'] . '" selected>' . $val['womat_job_id'] . '</option>';
                        }
                    } else if ($val['job_id'] == $associatejobid) {
                        $output .= '<option value="' . $val['job_id'] . '" selected>' . $val['womat_job_id'] . '</option>';
                    } else {
                        $output .= '<option value="' . $val['job_id'] . '">' . $val['womat_job_id'] . '</option>';
                    }
                }
                $output .= '</select>';
                return response()->json(['status' => 'success', 'message' => $output]);
            } else {

                if ($annotationID == '') {
                    $output = '<select id="pmjobid"  onchange="getjobID()">'; //multiple="multiple"
                } else {
                    $output = '<select id="pmjobid">'; //multiple="multiple"
                }
                $output .= '<option disabled selected>--select--</option>';
                foreach ($json_data_decoded['result']['data'] as $key => $val) {
                    if ($annotationID != '') {
                        if ($val['job_id'] == $annotationID) {
                            $output .= '<option value="' . $val['job_id'] . '" selected>' . $val['title'] . '</option>';
                        }
                    } else if ($val['job_id'] == $associatejobid) {
                        $output .= '<option value="' . $val['job_id'] . '" selected>' . $val['title'] . '</option>';
                    } else {
                        $output .= '<option value="' . $val['job_id'] . '">' . $val['title'] . '</option>';
                    }
                }
                $output .= '</select>';

                return response()->json(['status' => 'success', 'message' => $output]);
            }
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update($id, Request $request)
    {
        $annotation = Annotation::find($id);
        if ($annotation) {
            $data = json_decode($request->getContent(), true);
            $annotation->ranges     = $data['ranges'];
            $annotation->quote         = $data['quote'];
            $annotation->text         = $data['category'];
            $annotation->category     = $data['category'];
            $annotation->notes         = $data['text'];
            $annotation->page_id     = $data['page'];
            try {
                $annotation->save();
                return response()->json(['status' => 'success']);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'Could not find the annotation.'], 400);
    }

    public function statusupdate($id, Request $request)
    {
        $update = 'update ee_mail_body set annotate_status = "progress" where email_id = "' . $id . '"';
        $emailcount = DB::connection('mysql')->select(DB::raw($update));
        return response()->json(['status' => 'success']);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete($id)
    {
        try {
            if (Annotation::destroy($id)) {
                return response('', 204);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        return response()->json(['status' => 'error', 'message' => 'Could not find the annotation.'], 400);
    }

    public function updategroupingdata(Request $request)
    {
        $data    = json_decode($request->getContent(), true);
        $sql    = "SELECT * from annotations where group_ID IS NOT NULL and page_id = '" . $_POST['referenceid'] . "' group by group_ID";
        $lists    = DB::connection('mysql')->select(DB::raw($sql));

        $actiongroup     = '"' . str_replace(',', '","', $_POST['actionid']) . '"';
        $update     = 'update annotations set group_ID = "group-' . (count($lists) + 1) . '", groupinfo ="' . $_POST['content'] . '" where annotationid IN (' . $actiongroup . ')';
        $emailcount = DB::connection('mysql')->select(DB::raw($update));
        return $_POST['referenceid'];
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getjobtasklist(Request $request)
    {
        $empcode            =    $_POST['empcode'];             //API Url
        $jobid                =    $_POST['jobid'];
        $gettasklist_url    =    env('GETPMTASKLIST');

        // Prepare new cURL resource
        $ch = curl_init($gettasklist_url);            //Initiate cURL.
        $jsonData = array(                        //The JSON data.
            'job_id'                 => $jobid,
            'assignedto_empcode'    => env('ASSIGN_EMPCODE'),  //
            'partialcomplete'         => '0'
        );
        $jsonDataEncoded = json_encode($jsonData);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        //Encode the array into JSON.
        $jsonDataEncoded = json_encode($jsonData);
        //Tell cURL that we want to send a POST request.
        curl_setopt($ch, CURLOPT_POST, true);
        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        //Set the content type to application/json
        // Set HTTP Header for POST request
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($jsonDataEncoded)));

        // Submit the POST request
        $result = curl_exec($ch);
        // Close cURL session handle
        curl_close($ch);
        $json_data_decoded = json_decode($result, true);
        //$output =	array();
        $output = '<select id="jobtaskid"  class="form-control" required onchange="gettaskval(this.value)"><option value="" selected>Choose your option</option>';



        if ($json_data_decoded['result']['status'] != '0') {
            foreach ($json_data_decoded['result']['data'] as $val) {
                $output .= '<option value="' . $val['task_id'] . '">' . $val['title'] . '</option>';
            }
        }
        $output .= '</select>';

        return response()->json(['status' => 'success', 'message' => $output, 'taskstatus' => $json_data_decoded['result']['status']]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function gettasklist(Request $request)
    {
        $empcode            =    $_POST['empcode'];             //API Url
        $jobid                =    $_POST['jobid'];
        $gettasklist_url    =    env('GETPMTASKLIST');

        // Prepare new cURL resource
        $ch = curl_init($gettasklist_url);            //Initiate cURL.
        $jsonData = array(                        //The JSON data.
            'job_id'                 => $jobid,
            'assignedto_empcode'    => env('ASSIGN_EMPCODE'),  //
            'partialcomplete'         => '0'
        );
        $jsonDataEncoded = json_encode($jsonData);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        //Encode the array into JSON.
        $jsonDataEncoded = json_encode($jsonData);
        //Tell cURL that we want to send a POST request.
        curl_setopt($ch, CURLOPT_POST, true);
        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        //Set the content type to application/json
        // Set HTTP Header for POST request
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($jsonDataEncoded)));

        // Submit the POST request
        $result = curl_exec($ch);
        // Close cURL session handle
        curl_close($ch);
        $json_data_decoded = json_decode($result, true);
        $output =    array();



        if ($json_data_decoded['result']['status'] != '0') {
            foreach ($json_data_decoded['result']['data'] as $val) {
                $output[$val['title'] . '||' . $val['task_id']] = ':"annotator-hl-' . $val['title'] . '"';
            }
        }

        return ($output);
    }

    public function getselectedjob(Request $request)
    {
        $getselectedjob_url    =    env('GETSELECTEDJOB');

        $jobid    =    $_POST['jobid'];

        // Prepare new cURL resource
        $ch = curl_init($getselectedjob_url);            //Initiate cURL.
        $jsonData = array(                        //The JSON data.
            'job_id'                 => $jobid
        );

        $jsonDataEncoded = json_encode($jsonData);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        //Encode the array into JSON.
        $jsonDataEncoded = json_encode($jsonData);
        //Tell cURL that we want to send a POST request.
        curl_setopt($ch, CURLOPT_POST, false);
        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        //Set the content type to application/json
        // Set HTTP Header for POST request
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($jsonDataEncoded)));

        // Submit the POST request
        $result = curl_exec($ch);
        // Close cURL session handle
        curl_close($ch);

        $json_data_decoded = json_decode($result, true);

        /*if(@$_POST['singlejob'] == 1){
					$output = '<select id="select-jobid" class="form-control" required onchange="getjob_tasklist(this.value)">';
				} else {
					$output = '<select id="select-jobid" class="form-control" required onchange="getjob_tasklist(this.value)"><option value="" disabled selected>Choose your option</option>';
				}*/

        $output = '<select id="select-jobid" class="form-control" required onchange="getjob_tasklist(this.value)">';
        foreach ($json_data_decoded['result']['data'] as $key => $val) {
            $output .= '<option value="' . $val['job_id'] . '">' . $val['womat_job_id'] . '</option>';
        }
        $output .= '</select>';


        return response()->json(['status' => 'success', 'message' => $output]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getpmuserlist(Request $request)
    {
        $gettasklist_url    =    env('GETPMUSERLIST');
        // Prepare new cURL resource
        $ch = curl_init($gettasklist_url);            //Initiate cURL.
        $jsonData = array(                        //The JSON data.
            'empcode'                 => auth()->user()->empcode
        );
        $jsonDataEncoded = json_encode($jsonData);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        //Encode the array into JSON.
        $jsonDataEncoded = json_encode($jsonData);
        //Tell cURL that we want to send a POST request.
        curl_setopt($ch, CURLOPT_POST, false);
        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        //Set the content type to application/json
        // Set HTTP Header for POST request
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($jsonDataEncoded)));

        // Submit the POST request
        $result = curl_exec($ch);
        // Close cURL session handle
        curl_close($ch);
        $json_data_decoded = json_decode($result, true);
        $output = '<select id="multi-select-user" multiple="multiple"  required>';
        foreach ($json_data_decoded['result']['data'] as $key => $val) {
            $output .= '<option value="' . $key . '">' . $val . '</option>';
        }
        $output .= '</select>';

        $newtaskoutput = '<select id="multi-select-user-newtask" multiple="multiple"  required>';
        foreach ($json_data_decoded['result']['data'] as $key => $val) {
            $newtaskoutput .= '<option value="' . $key . '">' . $val . '</option>';
        }
        $newtaskoutput .= '</select>';
        return response()->json(['status' => 'success', 'message' => $output, 'newtaskmessage' => $newtaskoutput]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function gettaskdetail(Request $request)
    {
        $taskid                =    $_POST['taskid'];
        $gettasklist_url    =    env('GETPMTASKLIST');

        // Prepare new cURL resource
        $ch = curl_init($gettasklist_url);            //Initiate cURL.
        $jsonData = array(                        //The JSON data.
            'task_id'                 => $taskid
        );
        $jsonDataEncoded = json_encode($jsonData);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        //Encode the array into JSON.
        $jsonDataEncoded = json_encode($jsonData);
        //Tell cURL that we want to send a POST request.
        curl_setopt($ch, CURLOPT_POST, true);
        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        //Set the content type to application/json
        // Set HTTP Header for POST request
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($jsonDataEncoded)));

        // Submit the POST request
        $result = curl_exec($ch);
        // Close cURL session handle
        curl_close($ch);
        $json_data_decoded = json_decode($result, true);
        $output =    array();



        $output['title']         = @$json_data_decoded['result']['data'][0]['title'];
        $output['description']     = @$json_data_decoded['result']['data'][0]['description'];

        if ($output['title'] == '' && $output['description'] == '') {
            $output['title'] = '';
            $output['description'] = '';
        }
        //$output = json_encode($output);
        return response()->json([$output]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createisbn(Request $request)
    {
        $duedate = "";
        $emailid            =    $_POST['emailid'];
        $empcode            =    $_POST['empcode'];
        $isbn                =    $_POST['isbn'];
        $start_time         = $_POST['start_time'];

        if(!isset($_POST['generic'])) {

            date_default_timezone_set("Asia/Kolkata");
            $duedate = date("Y-m-d", strtotime("tomorrow")) . ' ' . date('H:i:s');

        }

        $create_isbn_url    =    env('CREATEISBNJOB');
        // Prepare new cURL resource
        $ch = curl_init($create_isbn_url);            //Initiate cURL.
        $jsonData = array(                        //The JSON data.
            'womat_job_id'         => $isbn,
            'pm_empcode'         => $empcode,
            'date_due'             => $duedate,
            'title'             => base64_encode($isbn),
            'am_empcode'         => Config::get('constants.job_add_am_empcode'),
            'am_empname'         => Config::get('constants.job_add_am_empname'),
            'status'            => Config::get('constants.job_add_status'),
            'isbn'                => $isbn,
            'e_isbn'            => $isbn
        );

        if ($start_time != "") {

            $jsonData["start_time"] = $start_time;
            $jsonData["ip_address"] = request()->ip();

        }

        if (isset($_POST['generic']) && $_POST['generic'] == "generic") {

            $jsonData["pmbot_type"] = $_POST['generic'];
        }

        $jsonDataEncoded = json_encode($jsonData);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        //Encode the array into JSON.
        $jsonDataEncoded = json_encode($jsonData);
        //Tell cURL that we want to send a POST request.
        curl_setopt($ch, CURLOPT_POST, true);
        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        //Set the content type to application/json
        // Set HTTP Header for POST request
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($jsonDataEncoded)));

        // Submit the POST request
        $result = curl_exec($ch);
        // Close cURL session handle
        curl_close($ch);
        $json_data_decoded = json_decode($result, true);

        $output = '<select id="pmjobid">';
        $output .= '<option value="' . $json_data_decoded['result']['data']['job_id'] . '" selected>' . $json_data_decoded['result']['data']['womat_job_id'] . '</option>';
        $output .= '</select>';
        return response()->json(['status' => 'success', 'message' => $output]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function nonbusiness(Request $request)
    {
        $id                    =    $_POST['id'];
        $type                =    'non_pmbot';
        $nonbusiness_url    =    env('NONBUSINESS');
        $status                =    '3';
        $start_time         = $_POST['start_time'];

        // Prepare new cURL resource
        $ch = curl_init($nonbusiness_url);            //Initiate cURL.
        $jsonData = array(                        //The JSON data.
            'id'                 => $id,
            'type'                 => $type,
            'status'             => $status,
            'job_id'             => Null
        );

        if ($start_time != "") {

            $jsonData["start_time"] = $start_time;
            $jsonData["ip_address"] = request()->ip();
        }

        $jsonDataEncoded = json_encode($jsonData);


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        //Encode the array into JSON.
        $jsonDataEncoded = json_encode($jsonData);
        //Tell cURL that we want to send a POST request.
        curl_setopt($ch, CURLOPT_POST, true);
        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        //Set the content type to application/json
        // Set HTTP Header for POST request
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($jsonDataEncoded)));

        // Submit the POST request
        $result = curl_exec($ch);
        // Close cURL session handle
        curl_close($ch);
        $json_data_decoded = json_decode($result, true);

        //$update 	= 'update annotations set status = "completed" and emailtype = "1" where page_id = "'.$id.'")';
        //$emailcount = DB::connection('mysql')->select(DB::raw($update));

        //$output = json_encode($output);
        return response()->json([$json_data_decoded]);
    }

}
