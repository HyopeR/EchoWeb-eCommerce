<?php

if($_POST) {
  require("connection.php");

  $body_name = $_POST["body_select"];
  $p_id = $_POST["selectHiddenId"];

  $dbControl=mysqli_query($connect_db, "SELECT b_id FROM body WHERE b_name = '".$body_name."'");
  $queryBodyId = mysqli_fetch_row($dbControl);
  $body_id = $queryBodyId[0];

  $dbControl=mysqli_query($connect_db, "SELECT p_stock FROM products_body WHERE b_id = '".$body_id."' AND p_id = '".$p_id."' ");
  $queryStock = mysqli_fetch_row($dbControl);

  if ($queryStock[0] > 0) {

    echo 1;

  } else {

    echo 0;

  }
}

 ?>
