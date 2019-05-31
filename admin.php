<?php
session_start();

if(isset($_SESSION["seller_email"])) {

  header("location: http://localhost/templatePages/adminPages/followDay.php");

} else {

  header("location: http://localhost/templatepages/adminpages/loginAdmin.php");

}
 ?>
