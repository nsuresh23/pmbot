<?php

ini_set('memory_limit', '-1');
error_reporting(E_ALL);
ini_set("display_errors", 1);

date_default_timezone_set('Asia/Kolkata');

try {

	$config 			= parse_ini_file(realpath(dirname(__FILE__) . '/email_update_config.ini'), true);

	$mode 				= $config['Server_Mode']['Mode'];

	$dbhost				= $config[$mode]['Db_Host'];
	$dbuser				= $config[$mode]['Db_User'];
	$dbpass				= $config[$mode]['Db_Pass'];
	$dbname				= "";
	// $dbname			= $config[$mode]['Db_Name'];
	$dbConnection 		= new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbConnection->setAttribute(PDO:: MYSQL_ATTR_FOUND_ROWS, TRUE);

} catch (PDOException $e) {

	$logMsg = '';
	$logMsg = 'DB connection error:';
	$logMsg .= "\n\n";
	$logMsg .=  $e->getMessage();

	update_log($logMsg, 'Update_Email');

}

$databases = [
	"pmbot_pdy_oup_books",
	"pmbot_pdy_oup_books2",
	"pmbot_pdy_oup_books_he",
	"pmbot_us_oup_he",
	"pmbot_ph_oup_journals",
	"pmbot_mb_english",
	"pmbot_elsevier_books",
	"pmbot_apress",
	"pmbot_spilabs",
];

/*$databases = [
	"pmbot_pdy_oup_books",
];*/

if(is_array($databases) && count($databases) > 0) {

	foreach ($databases as $key => $dbname) {

		try {

			$LogFileName = "Update_Email_" .$dbname;

			//EMAIL SENT AND RECEIVED DETAILS

			$emailListQuery = "SELECT id, email_id, empcode, email_to, email_cc, email_bcc, email_domain, email_domain_name FROM ".$dbname. ".email_box WHERE sent_received IN('sent', 'received') AND (email_sent_date >= NOW() - INTERVAL 10 MINUTE OR email_received_date >= NOW() - INTERVAL 10 MINUTE) ORDER BY empcode ASC";
			// $emailListQuery = "SELECT id, email_id, empcode, email_to, email_cc, email_bcc, email_domain, email_domain_name FROM " . $dbname . ".email_box WHERE sent_received IN('sent', 'received') ORDER BY empcode ASC";

			$logMsg = '';
			$logMsg = 'Select Query:';
			$logMsg .= "\n\n";
			$logMsg .=  $emailListQuery;

			update_log($logMsg, $LogFileName);

			$emailList 	= get_SQL_rows($emailListQuery);

			$logMsg = '';
			$logMsg = 'Result Count:';
			$logMsg .= "\n\n";
			$logMsg .=  count($emailList);

			update_log($logMsg, $LogFileName);
			
			$txt = '';
			$createdtime = date('Y-m-d H:i:s');
			$txt.= 'Created Date & Time: ';
			$txt.= $createdtime;
			$txt.= "\n";

			print "\n---------------------------\n". $txt . $emailListQuery . "\n---------------------------\n";
			print "Total Record Count : ".count($emailList)."\n---------------------------------------";

			if (is_array($emailList) && COUNT($emailList) > 0) {

				for ($j = 0; $j < count($emailList); $j++) {

					try {

						$dbConnection->beginTransaction();

						$emailID 			= '';
						$emailTo 			= '';
						$emailCC 			= '';
						$emailBCC 			= '';
						$empcode			= '';
						$email_type 		= 'internal';
						$empcodeIsStraive 	= false;

						$emailID 			= $emailList[$j]->id;
						$emailTo 			= $emailList[$j]->email_to;
						$emailCC 			= $emailList[$j]->email_cc;
						$emailBCC 			= $emailList[$j]->email_bcc;

						$empcode 			= $emailList[$j]->empcode;

						if($emailID) {

							if($emailTo && $email_type == 'internal') {

								$email_type = check_email($emailTo);

							}

							if($emailCC && $email_type == 'internal') {

								$email_type = check_email($emailCC);

							}

							if($emailBCC && $email_type == 'internal') {

								$email_type = check_email($emailBCC);

							}

							if(trim($empcode)) {

								if(strpos(strtolower(trim($empcode)), 'straive.com') != false) {

									$empcodeIsStraive = true;

									$empcode = str_replace('straive.com' , 'spi-global.com', strtolower(trim($empcode)));

								}

							}

							//if($email_type == 'external') {

								// TO DO: update email as external based on email id;

								// $emailDomainNameUpdateQuery = "UPDATE " .$dbname.".email_box SET email_domain_name = 'external' WHERE id = " . $emailID;
								$emailDomainNameUpdateQuery = "UPDATE " .$dbname.".email_box SET email_domain_name = '" . $email_type . "' WHERE id = " . $emailID;

								$logMsg = '';
								$logMsg = 'Email Domain Name Update Query:';
								$logMsg .= "\n\n";
								$logMsg .=  $emailDomainNameUpdateQuery;

								update_log($logMsg, $LogFileName);

								$affectedRowCounts = 0;

								$affectedRowCounts = update_SQL_rows($emailDomainNameUpdateQuery);

								$logMsg = '';
								$logMsg = 'Email Domain Name Update Query Affected Row Counts:';
								$logMsg .= "\n\n";
								$logMsg .=  $affectedRowCounts;

								update_log($logMsg, $LogFileName);

							//}

							if($empcodeIsStraive) {

								// TO DO: update email_id, empcode in email_box, email_history, notification, diary and all related table based on email id

								$emailBoxEmpcodeUpdateQuery = "UPDATE " . $dbname . ".email_box SET email_id = '" . $empcode . "', empcode = '" . $empcode . "' WHERE id = " . $emailID;

								$logMsg = '';
								$logMsg = 'Email Box Table Domain Name Update Query:';
								$logMsg .= "\n\n";
								$logMsg .=  $emailBoxEmpcodeUpdateQuery;

								update_log($logMsg, $LogFileName);

								$affectedRowCounts = 0;

								$affectedRowCounts = update_SQL_rows($emailBoxEmpcodeUpdateQuery);

								$logMsg = '';
								$logMsg = 'Email Box Table Empcode Update Query Affected Row Counts:';
								$logMsg .= "\n\n";
								$logMsg .=  $affectedRowCounts;

								update_log($logMsg, $LogFileName);

								$emailHistoryEmpcodeUpdateQuery = "UPDATE " . $dbname . ".email_history SET empcode = '" . $empcode . "' WHERE email_id = " . $emailID;

								$logMsg = '';
								$logMsg = 'Email History Table Empcode Update Query:';
								$logMsg .= "\n\n";
								$logMsg .=  $emailHistoryEmpcodeUpdateQuery;

								update_log($logMsg, $LogFileName);

								$affectedRowCounts = 0;

								$affectedRowCounts = update_SQL_rows($emailHistoryEmpcodeUpdateQuery);

								$logMsg = '';
								$logMsg = 'Email History Table Empcode Update Query Affected Row Counts:';
								$logMsg .= "\n\n";
								$logMsg .=  $affectedRowCounts;

								update_log($logMsg, $LogFileName);

								$notificationEmpcodeUpdateQuery = "UPDATE " . $dbname . ".notification SET empcode = '" . $empcode . "' WHERE type = 'email' AND reference_id = " . $emailID;

								$logMsg = '';
								$logMsg = 'Notification Table Empcode Update Query:';
								$logMsg .= "\n\n";
								$logMsg .=  $notificationEmpcodeUpdateQuery;

								update_log($logMsg, $LogFileName);

								$affectedRowCounts = 0;

								$affectedRowCounts = update_SQL_rows($notificationEmpcodeUpdateQuery);

								$logMsg = '';
								$logMsg = 'Notification Table Empcode Update Query Affected Row Counts:';
								$logMsg .= "\n\n";
								$logMsg .=  $affectedRowCounts;

								update_log($logMsg, $LogFileName);

								$diaryEmpcodeUpdateQuery = "UPDATE " . $dbname . ".diary SET empcode = '" . $empcode . "' WHERE email_id = " . $emailID;

								$logMsg = '';
								$logMsg = 'Diary Table Empcode Update Query:';
								$logMsg .= "\n\n";
								$logMsg .=  $diaryEmpcodeUpdateQuery;

								update_log($logMsg, $LogFileName);

								$affectedRowCounts = 0;

								$affectedRowCounts = update_SQL_rows($diaryEmpcodeUpdateQuery);

								$logMsg = '';
								$logMsg = 'Diary Table Empcode Update Query Affected Row Counts:';
								$logMsg .= "\n\n";
								$logMsg .=  $affectedRowCounts;

								update_log($logMsg, $LogFileName);

							}

							$dbConnection->commit();

						}

					} catch(Exception $e) {

						$logMsg = '';
						$logMsg = 'Email Check error:';
						$logMsg .= "\n\n";
						$logMsg .=  $e->getMessage();

						update_log($logMsg, $LogFileName);

						$dbConnection->rollBack();

					}

				}

			}

		} catch (Exception $e) {

			$logMsg = '';
			$logMsg = 'Database error:';
			$logMsg .= "\n\n";
			$logMsg .=  $e->getMessage();

			update_log($logMsg, $LogFileName);

		}

	}

}

function internalEmailCheck($email){

	$returnData = "false";
	$externalEmailReg = "/^[\w\.\_]+@((spi\-global|straive)\.com)?$/";
	$returnData = preg_match($externalEmailReg, strtolower(trim($email)));

	if($returnData == 1){

		return 'internal';

	}else{

		return 'external';

	}

}

function check_email($email_address){

	$emailArray = [];
	$emailArray = explode(";", strtolower(base64_decode($email_address)));

	if(is_array($emailArray) && count($emailArray) > 0) {

		foreach($emailArray as $item) {

			if(strlen(trim($item))) {

				if(internalEmailCheck(trim($item)) == 'external') {

					return 'external';

					break;

				}

			}

		}

		return 'internal';	//If not matched this will as default "Internal"

	}

}

//********** CREATE A LOG FILE BASED ON THE DATE IN LOG FOLDER **********//
function update_log($log_msg,$logname) {
	global $config,$mode;

	$logname 		= $logname.'_'.date('H', time());
	$config[$mode]['Create_Log'] = '1';
	if($config[$mode]['Create_Log'] == '1'){
		$directory = date('Y-m-d');
		$createdtime = date('Y-m-d H:i:s');
		$txt= "\n\n";
		$txt.= 'Created Date & Time: ';
		$txt.= $createdtime;
		$log_msg = $log_msg.$txt;

		if(!is_dir('log/'.$directory)){
			mkdir('log/'.$directory, 0777, true);
		}
		$log_filename = "log/".$directory;
		if (!file_exists($log_filename)) {
			mkdir($log_filename, 0777, true);
		}
		$log_file_data = $log_filename.'/' .$logname. '.log';
		file_put_contents($log_file_data, $log_msg . "\n\n-----------------------------------------------------------\n\n", FILE_APPEND);
	}
}

function get_SQL_rows($SQL)
{

	$Count_result 	= $GLOBALS['dbConnection']->prepare($SQL);
	$Count_result->execute();
	$Count_row 		= $Count_result->fetchAll(PDO::FETCH_OBJ);
	return $Count_row;

}

function update_SQL_rows($SQL)
{

	$Count_result 	= $GLOBALS['dbConnection']->prepare($SQL);
	$Count_result->execute();
	$affectedRows = $Count_result->rowCount();
	//$Count_result = 1;
	return $affectedRows;

}
