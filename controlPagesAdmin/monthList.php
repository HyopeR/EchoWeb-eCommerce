<?php
if($_POST) {
  session_start();
  require(".././controlPages/connection.php");

  $priceYear = $_POST["priceYear"];

  $monthQuery = mysqli_query($connect_db, "SELECT MONTH(o_time) AS month_id, MONTHNAME(o_time) AS month_name
  FROM orders
  WHERE o_id IN (SELECT o_id
  FROM orders
  LEFT JOIN shop_cart
  ON orders.sc_id = shop_cart.sc_id
  LEFT JOIN products_shop_cart
  ON shop_cart.sc_id = products_shop_cart.sc_id
  LEFT JOIN products
  ON products_shop_cart.p_id = products.p_id
  LEFT JOIN seller
  ON products.s_id = seller.s_id
  WHERE seller.s_email = '".$_SESSION["seller_email"]."'
  GROUP BY orders.sc_id)
    AND YEAR(o_time) = '".$priceYear."'
  GROUP BY MONTH(o_time)
  ORDER BY month_id");

  echo '<option value="" disabled="disabled" selected="selected">Ay Seçiniz</option>';
  while($monthOption=mysqli_fetch_assoc($monthQuery)) {
    echo '<option value="'.$monthOption["month_id"].'">'.$monthOption["month_name"].'</option>';
  }
}

 ?>
