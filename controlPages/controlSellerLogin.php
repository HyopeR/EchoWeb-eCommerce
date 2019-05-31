<?php
if($_POST) {
	session_start();
	require("connection.php");

	$seller_email=$_POST["seller_email"];
	$seller_password=$_POST["seller_password"];
	$userPuppet = 0;

$dbControl=mysqli_query($connect_db, "SELECT count(s_email) FROM seller WHERE s_email = '".$seller_email."'");
$dbValue = mysqli_fetch_row($dbControl);
if ($dbValue[0] == 1) {
		$userPuppet = 1;

		$dbControl=mysqli_query($connect_db, "SELECT s_key, s_name FROM seller WHERE s_email = '".$seller_email."'");
		$dbValue = mysqli_fetch_row($dbControl);
		$seller_key = $dbValue[0];
		$seller_name = $dbValue[1];

		$dbControl=mysqli_query($connect_db, "SELECT s_email, s_password FROM seller WHERE s_email = '".$seller_email."' AND s_password = '".$seller_password."'");
		if(mysqli_num_rows ($dbControl) > 0) {
			$_SESSION['seller_email'] = $seller_email;
			$_SESSION['seller_name'] = $seller_name;
			$_SESSION['seller_key'] = $seller_key;
			// $logStatus=mysqli_query($connect_db, "UPDATE users SET user_status = 1 WHERE user_email = '".$user_email."'");
			echo $userPuppet."-"."http://localhost/templatePages/mainPages/sellerpages.php";
		}else {
			$userPuppet = 0;
			echo $userPuppet;
		}
} else {
		$userPuppet = 0;
		echo $userPuppet;
}
}

?>
