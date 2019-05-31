<?php

if($_POST) {
	session_start();
	require("connection.php");

  if(isset($_SESSION["user_email"])) {
    $current_email = $_SESSION["user_email"];
  }

  $updateName=$_POST["updateName"];
  $updateSurname=$_POST["updateSurname"];

	$updatePassword=$_POST["updatePassword"];

	$updateDay=$_POST["updateDay"];
	$updateMonth=$_POST["updateMonth"];
	$updateYear=$_POST["updateYear"];

	$updateDate = $updateYear."-".$updateMonth."-".$updateDay;

	$updateGender=$_POST["updateGender"];

	$updateAddress=$_POST["updateAddress"];

	$updateNumber=$_POST["updateNumber"];

	$updateEmail=$_POST["updateEmail"];

  $dbControl=mysqli_query($connect_db, "SELECT count(u_email) FROM users WHERE u_email = '".$current_email."'");
  $dbValue = mysqli_fetch_row($dbControl);
  if((int)$dbValue[0] == 1) {
    $dbControl=mysqli_query($connect_db, "UPDATE users
                                          SET
                                            g_id = '".$updateGender."',
                                            u_name = '".$updateName."',
                                            u_surname = '".$updateSurname."',
                                            u_email = '".$updateEmail."',
                                            u_password = '".$updatePassword."',
                                            u_address = '".$updateAddress."',
                                            u_date = '".$updateDate."',
                                            u_number = '".$updateNumber."'
                                            WHERE u_email = '".$current_email."' ");

    $_SESSION['user_email'] = $updateEmail;
    $_SESSION['user_name'] = $updateName;

    $_SESSION['update_profile_detail'] = "Bilgileriniz başarılı şekilde güncellendi.";

  }

    header("location: http://localhost/templatePages/mainPages/userspages.php");
  }

?>
