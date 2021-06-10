<?php
	include(realpath(dirname(__FILE__).'/functions_db.php'));


	if(!empty($_REQUEST['dbname'])){
		$dbname = $_REQUEST['dbname'];
	}else{
		print "dbname is not empty, please provide vali data!!";
		exit;
	}

	print "<pre>";
//EXTERNAL SENT EMAIL DETAILS
	$SQL_Sent_EmailsList = "SELECT
								id, empcode, email_to, email_cc, email_bcc, reviewed, email_sent_through, parent_email_received_date, email_type, email_sent_date, email_domain, email_domain_name
							FROM ".$dbname.".email_box
							WHERE
								sent_received = 'sent'
							ORDER BY empcode ASC
							";
							//AND email_domain_name = 'internal' //AND lower(empcode) = 'j.saranya@spi-global.com'
							//(email_sent_date >= '".$fdate."' AND email_sent_date  <= '".$tdate."') AND LOWER(empcode) = '".$user_empcode."'
							//id IN (142250, 142251, 142056, 142055)
	$Rows_Sent_List 	= get_SQL_rows($SQL_Sent_EmailsList);
	print "<br>---------------------------<br>".$SQL_Sent_EmailsList."<br>---------------------------<br>";
	print "Total Record Count : ".count($Rows_Sent_List)."<br>*********************************<br>";
//	exit;
//	print_r($Rows_Sent_List);
	$cnt 		= 0;
	if (COUNT($Rows_Sent_List) > 0) {

		$str_Internal_Email = array();
		$str_updateid		= '';
		for ($j = 0; $j < count($Rows_Sent_List); $j++) {

			$emailTo 			= '';
			$emailCC 			= '';
			$emailBCC 			= '';
			$email_type 		= 'internal';
			$matched_address	= '';

			$emailTo 			= $Rows_Sent_List[$j]->email_to;
			$emailCC 			= $Rows_Sent_List[$j]->email_cc;
			$emailBCC 			= $Rows_Sent_List[$j]->email_bcc;

			//print "BEFORE :: ".$Rows_Sent_List[$j]->id." ------ ".$Rows_Sent_List[$j]->email_domain_name."-------".$email_type."<br>";

			if($emailTo && $email_type == 'internal') {
				$email_type 			= check_email($emailTo);
				if($email_type == 'external'){
					$matched_address 	= "To";
				}
			}

			if($emailCC && $email_type == 'internal') {
				$email_type 			= check_email($emailCC);
				if($email_type == 'external'){
					$matched_address 	= "CC";
				}
			}

			if($emailBCC && $email_type == 'internal') {
				$email_type 			= check_email($emailBCC);
				if($email_type == 'external'){
					$matched_address 	= "BCC";
				}
			}

			//print "AFTER :: ".$Rows_Sent_List[$j]->id." ------ ".$Rows_Sent_List[$j]->email_domain_name."-------".$email_type."<br>";
			//print "<br>-------------------------------------------------------------------<br>";

			if($Rows_Sent_List[$j]->email_domain_name == 'external' && $email_type == 'internal'){
				$str_Internal_Email[$cnt]['Id'] 				= $Rows_Sent_List[$j]->id;
				$str_Internal_Email[$cnt]['empcode'] 			= $Rows_Sent_List[$j]->empcode;
				$str_Internal_Email[$cnt]['email_domain'] 		= $Rows_Sent_List[$j]->email_domain;
				$str_Internal_Email[$cnt]['email_domain_name'] 	= $Rows_Sent_List[$j]->email_domain_name;
				$str_Internal_Email[$cnt]['email_sent_through'] = $Rows_Sent_List[$j]->email_sent_through;
				$str_Internal_Email[$cnt]['email_type'] 		= $Rows_Sent_List[$j]->email_type;
				$str_Internal_Email[$cnt]['reviewed'] 			= $Rows_Sent_List[$j]->reviewed;
				$str_Internal_Email[$cnt]['externalEmail'] 		= 'internal';
				$str_Internal_Email[$cnt]['matched_address'] 	= $matched_address;
				$str_updateid = $str_updateid.",".$Rows_Sent_List[$j]->id;
				$cnt = $cnt + 1;
			}

		}
		print "<b>Total Record Count (Convert External as Internal) : ".	COUNT($str_Internal_Email) ."</b><br>";
		print "<b>Total Record (Convert External as Internal) : ".	$str_updateid ."</b><br>";

		//print "<pre>";
		//print_r($str_Internal_Email);
		//exit;
	}


	function internalEmailCheck($email){
		$returnData = "false";
		$externalEmailReg = "/^[\w\.\_]+@(spi\-global\.com)?$/";
		//$externalEmailReg = "/^[\w\.\_]+@(straive\.com)?$/";
		$returnData = preg_match($externalEmailReg, strtolower(trim($email)));
		//print $email." --------- ".$returnData."<br>";
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

?>


<!DOCTYPE html>
<html>
<head>
<title>PMBOT :: External Email Checking </title>
</head>
<body>
	<table cellspacing="0" cellpadding="10" border="1" style="border-top:1px solid #ccc;border-right:1px solid #ccc;border-left:1px solid #ccc;border-bottom:1px solid #ccc;">
		<tr>
			<td align="left">id</td>
			<td align="left">empcode</td>
			<td align="left">email_domain</td>
			<td align="left">email_domain_name</td>
			<td align="left">email_sent_through</td>
			<td align="left">email_type</td>
			<td align="left">reviewed</td>
			<td align="left">externalEmail</td>
			<td align="left">matched_address</td>
		</tr>
		<?PHP
		if (COUNT($str_Internal_Email) > 0) {
			for ($cnt = 0; $cnt < count($str_Internal_Email); $cnt++) {
		?>
		<tr>
			<td align="left"><?PHP print $str_Internal_Email[$cnt]['Id']; ?> </td>
			<td align="left"><?PHP print $str_Internal_Email[$cnt]['empcode']; ?> </td>
			<td align="left"><?PHP print $str_Internal_Email[$cnt]['email_domain']; ?> </td>
			<td align="left"><?PHP print $str_Internal_Email[$cnt]['email_domain_name']; ?> </td>
			<td align="left"><?PHP print $str_Internal_Email[$cnt]['email_sent_through']; ?> </td>
			<td align="left"><?PHP print $str_Internal_Email[$cnt]['email_type']; ?> </td>
			<td align="left"><?PHP print $str_Internal_Email[$cnt]['reviewed']; ?> </td>
			<td align="left"><?PHP print $str_Internal_Email[$cnt]['externalEmail']; ?> </td>
			<td align="left"><?PHP print $str_Internal_Email[$cnt]['matched_address']; ?> </td>
		</tr>
		<?PHP
			}
		}
		?>

	</table>
</body>
</html>
