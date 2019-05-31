<?php
if($_POST) {
  session_start();
  include("connection.php");

  $product_id = $_POST["hidden_product_id"];
  $quantity = $_POST["quantity_products"];
  $body_name = $_POST["body_select"];
  $quantity = (int)$quantity;

  $dbControl=mysqli_query($connect_db, "SELECT b_id FROM body WHERE b_name = '".$body_name."'");
  $queryBodyId = mysqli_fetch_row($dbControl);
  $body_id = $queryBodyId[0];

  $dbControl=mysqli_query($connect_db, "SELECT p_price FROM products WHERE p_id = '".$product_id."'");
  $dbValue = mysqli_fetch_row($dbControl);
  $product_price = $dbValue[0];
  $sc_total = $product_price * $quantity;

  if(isset($_SESSION['cart_id'])) {

    $current_cart_id = $_SESSION['cart_id'];

    $dbControl=mysqli_query($connect_db, "SELECT count(p_id)
                                          FROM products_shop_cart
                                          WHERE p_id = '".$product_id."' AND sc_id = '".$current_cart_id."' AND b_id = '".$body_id."'");
    $dbValue = mysqli_fetch_row($dbControl);
    $product_control = $dbValue[0];

    if ($product_control == 0) {

      $dbControl=mysqli_query($connect_db, "INSERT INTO products_shop_cart (p_id, sc_id, sc_piece, sc_total, b_id)
                                            VALUES('".$product_id."', '".$current_cart_id."', '".$quantity."', '".$sc_total."', '".$body_id."')");

    } else {

      $dbControl=mysqli_query($connect_db, "SELECT sc_piece, sc_total
                                            FROM products_shop_cart
                                            WHERE p_id = '".$product_id."' AND sc_id = '".$current_cart_id."' AND b_id = '".$body_id."'");
      $dbValue = mysqli_fetch_row($dbControl);
      $last_piece = $dbValue[0];
      $last_total = $dbValue[1];

      $quantity = $quantity + $last_piece;
      $sc_total = $sc_total + $last_total;

      $dbControl=mysqli_query($connect_db, "UPDATE products_shop_cart SET sc_piece = '".$quantity."', sc_total = '".$sc_total."'
                                            WHERE p_id = '".$product_id."' AND sc_id = '".$current_cart_id."' AND b_id = '".$body_id."'");

    }

  } else {

    $dbControl=mysqli_query($connect_db, "INSERT INTO shop_cart () VALUES()");
    $last_cart_id = mysqli_insert_id($connect_db);

    $dbControl=mysqli_query($connect_db, "INSERT INTO products_shop_cart (p_id, sc_id, sc_piece, sc_total, b_id)
                                          VALUES('".$product_id."', '".$last_cart_id."', '".$quantity."', '".$sc_total."', '".$body_id."')");

    $_SESSION['cart_id'] = $last_cart_id;

  }
}

 ?>
