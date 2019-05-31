<?php
if($_POST) {
  require("connection.php");

  $cart_id = $_POST["cart_id"];
  $product_id = $_POST["product_id"];
  $body_id = $_POST["body_id"];

  $dbControl=mysqli_query($connect_db, "SELECT count(p_id) FROM products_shop_cart WHERE sc_id = '".$cart_id."' AND p_id = '".$product_id."' AND b_id = '".$body_id."'");
  $dbValue = mysqli_fetch_row($dbControl);
  if ($dbValue[0] == 1) {

    $dbControl=mysqli_query($connect_db, "DELETE FROM products_shop_cart WHERE sc_id = '".$cart_id."' AND p_id = '".$product_id."' AND b_id = '".$body_id."' ");

  } else {
    //Not else.
  }
  
}

?>
