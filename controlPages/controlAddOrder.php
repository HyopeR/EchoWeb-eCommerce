<?php
if($_POST) {
  session_start();
  require("connection.php");

  $cart_id = $_POST["hiddenCartId"];
  $user_id = $_POST["hiddenUserId"];
  $total_price = 0;

  $dbControl = mysqli_query($connect_db, "SELECT sc_total, p_id, b_id, sc_piece FROM products_shop_cart WHERE sc_id = '".$cart_id."' ");
  while($row=mysqli_fetch_assoc($dbControl)) {
    $total_price = $total_price + $row["sc_total"];

    $dbStockCurrent = mysqli_query($connect_db, "SELECT p_stock FROM products_body  WHERE p_id = '".$row["p_id"]."' AND b_id = '".$row["b_id"]."' ");
    $dbStockValue = mysqli_fetch_row($dbStockCurrent);
    $newStock = $dbStockValue[0] - $row["sc_piece"];

    $dbStockModify = mysqli_query($connect_db, "UPDATE products_body SET p_stock = '".$newStock."' WHERE p_id = '".$row["p_id"]."' AND b_id = '".$row["b_id"]."' ");
  }

  $dbInsertOrder = mysqli_query($connect_db, "INSERT INTO orders (u_id, sc_id, o_total_price) VALUES('".$user_id."', '".$cart_id."', '".$total_price."') ");

  unset($_SESSION['cart_id']);
  $last_order_id = mysqli_insert_id($connect_db);
  $_SESSION["send_order_detail"] = "Siparişiniz alınmıştır. Sipariş No: <b>$last_order_id</b><br>Aşağıdaki butondan sipariş detaylarına erişebilirsiniz.";

}

 ?>
