<?php
if($_POST) {
  session_start();
  require(".././controlPages/connection.php");

  $priceYear = $_POST["priceYear"];
  $priceMonth = $_POST["priceMonth"];

  $monthPrice = mysqli_query($connect_db, "SELECT DAY(o_time) AS day_id, MONTH(o_time) AS month_id, SUM(o_total_price) AS total_price
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
    AND MONTH(o_time) = '".$priceMonth."'
    AND YEAR(o_time) = '".$priceYear."'
  GROUP BY DAY(o_time), MONTH(o_time)
  ORDER BY month_id, day_id");

  while($month=mysqli_fetch_assoc($monthPrice)) {
    echo $month["day_id"].",".$month["total_price"].",";
  }

}

 ?>
