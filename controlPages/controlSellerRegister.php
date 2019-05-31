<?php

if($_POST) {

	session_start();
	require("connection.php");

	$s_name=$_POST["reg_s_name"];
	$s_key=$_POST["reg_s_key"];
	$s_email=$_POST["reg_s_email"];
	$s_password=$_POST["reg_s_password"];

	$userPuppet = 0;

	$s_key = strtolower($s_key);

	$dbControl=mysqli_query($connect_db, "SELECT count(s_email) FROM seller WHERE s_email = '".$s_email."'");
	$dbValue = mysqli_fetch_row($dbControl);
	//Eposta kaydı var.
	if((int)$dbValue[0] == 1) {
			$userPuppet = 0;
			echo $userPuppet;
	//Eposta kaydı yok. Üye yap.
	} else {
			$userPuppet = 1;
			if($s_name&$s_email&$s_password&$s_key){

				require("controlCreateSeller.php");

				// $logStatus=mysqli_query($connect_db, "UPDATE users SET user_status = 1 WHERE user_email = '".$rg_email."'");
				$_SESSION['seller_key'] = $s_key;
				$_SESSION['seller_email'] = $s_email;
				$_SESSION['seller_name'] = $s_name;


			echo $userPuppet."-"."http://localhost/templatePages/mainPages/sellerpages.php";
		}
	}

}

?>
