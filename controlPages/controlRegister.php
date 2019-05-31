<?php

if($_POST) {
	session_start();
	require("connection.php");
	$userPuppet = 0;

  $regName=$_POST["regName"];
  $regSurname=$_POST["regSurname"];
	$regPassword=$_POST["regPassword"];

	$regDay=$_POST["regDay"];
	$regMonth=$_POST["regMonth"];
	$regYear=$_POST["regYear"];

	$regDate = $regYear."-".$regMonth."-".$regDay;

	$regGender=$_POST["regGender"];

	$regCity=$_POST["regCity"];
	$dbCityName = mysqli_query($connect_db, "SELECT uc_name FROM users_country WHERE uc_id = '".$regCity."' ");
	$dbCityArray = mysqli_fetch_row($dbCityName);
	$cityName = $dbCityArray[0];

	$regChildCity=$_POST["regChildCity"];
	$regAddress=$_POST["regAddress"];

	$regLocation = $regAddress." ".$regChildCity.", ".$cityName;

	$regNumber=$_POST["regNumber"];

	$regEmail=$_POST["regEmail"];


  $dbControl=mysqli_query($connect_db, "SELECT count(u_email) FROM users WHERE u_email = '".$regEmail."'");
  $dbValue = mysqli_fetch_row($dbControl);
  if((int)$dbValue[0] == 1) {
  		$userPuppet = 0;
      echo $userPuppet;
  } else {
  		$userPuppet = 1;
			$dbControl=mysqli_query($connect_db, "INSERT INTO users (g_id, uc_id, u_name, u_surname, u_email, u_password, u_address, u_date, u_number)
			VALUES ('".$regGender."', '".$regCity."', '".$regName."', '".$regSurname."', '".$regEmail."', '".$regPassword."', '".$regLocation."', '".$regDate."', '".$regNumber."')");

			$_SESSION['user_email'] = $regEmail;
			$_SESSION['user_name'] = $regName;

      echo $userPuppet."-"."http://localhost/";
  }
}

?>
