<?php
if($_POST) {
	session_start();
	require("connection.php");

	$user_email=$_POST["user_email"];
	$user_password=$_POST["user_password"];
	$userPuppet = 0;

$dbControl=mysqli_query($connect_db, "SELECT count(u_email) FROM users WHERE u_email = '".$user_email."'");
$dbValue = mysqli_fetch_row($dbControl);
if ($dbValue[0] == 1) {
		$userPuppet = 1;

		$dbControl=mysqli_query($connect_db, "SELECT u_name FROM users WHERE u_email = '".$user_email."'");
		$dbValue = mysqli_fetch_row($dbControl);
		$user_name = $dbValue[0];

		$dbControl=mysqli_query($connect_db, "SELECT u_email, u_password FROM users WHERE u_email = '".$user_email."' AND u_password = '".$user_password."'");
		if(mysqli_num_rows ($dbControl) > 0) {
			$_SESSION['user_email'] = $user_email;
			$_SESSION['user_name'] = $user_name;
			// $logStatus=mysqli_query($connect_db, "UPDATE users SET user_status = 1 WHERE user_email = '".$user_email."'");
			echo $userPuppet."-"."http://localhost/";
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
