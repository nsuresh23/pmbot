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
	"pmbot_spilabs",
];

/*$databases = [
	"pmbot_pdy_oup_books",
];*/

if(is_array($databases) && count($databases) > 0) {

	foreach ($databases as $key => $dbname) {

		try {

			$LogFileName = "Update_Empcode_" .$dbname;

			//EMAIL SENT AND RECEIVED DETAILS

			$emailListQuery = "SELECT id, email_id, empcode FROM ".$dbname. ".email_box ORDER BY empcode ASC";
			// $emailListQuery = "SELECT id, email_id, empcode, email_to, email_cc, email_bcc, email_domain, email_domain_name FROM " . $dbname . ".email_box WHERE sent_received IN('sent', 'received') ORDER BY empcode ASC";

			$logMsg = '';
			$logMsg = 'Email Select Query:';
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

						$emailBoxID 			= '';

                        $emailBoxEmpcode        = '';

						$emailBoxID 			= $emailList[$j]->id;

                        $emailBoxEmpcode        = $emailList[$j]->empcode;

						if($emailBoxID) {

                            //USER DETAILS

                            $userQuery = "SELECT empcode, spi_empcode FROM " . $dbname . ".users WHERE email IN ('" . $emailBoxEmpcode . "')  ORDER BY empcode ASC";

                            $logMsg = '';
                            $logMsg = 'User Select Query:';
                            $logMsg .= "\n\n";
                            $logMsg .=  $userQuery;

                            update_log($logMsg, $LogFileName);

                            $userList     = get_SQL_rows($userQuery);

                            $logMsg = '';
                            $logMsg = 'Result Count:';
                            $logMsg .= "\n\n";
                            $logMsg .=  count($userList);

                            update_log($logMsg, $LogFileName);

                            if (is_array($userList) && COUNT($userList) > 0) {

                                for ($j = 0; $j < count($userList); $j++) {

                                    $userSpiEmpcode        = '';

                                    $userSpiEmpcode        = $emailList[$j]->spi_empcode;


                                    // TO DO: update email_box empcode based on email_box id;

                                    $emailBoxUpdateQuery = "UPDATE " . $dbname . ".email_box SET empcode = '" . $userSpiEmpcode . "' WHERE id = " . $emailBoxID;

                                    $logMsg = '';
                                    $logMsg = 'EmailBox empcode Update Query:';
                                    $logMsg .= "\n\n";
                                    $logMsg .=  $emailBoxUpdateQuery;

                                    update_log($logMsg, $LogFileName);

                                    $affectedRowCounts = 0;

                                    $affectedRowCounts = update_SQL_rows($emailBoxUpdateQuery);

                                    $logMsg = '';
                                    $logMsg = 'EmailBox Empcode Update Query Affected Row Counts:';
                                    $logMsg .= "\n\n";
                                    $logMsg .=  $affectedRowCounts;

                                    update_log($logMsg, $LogFileName);


                                }

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
