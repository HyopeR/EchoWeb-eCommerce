<?php
if($_POST) {

  session_start();
  $menuTab = $_POST["menuTab"];
  $_SESSION["menuTab"] = $menuTab;

}
 ?>
