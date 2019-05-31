<?php
if($_POST) {
  header('Content-Type:application/json');
  session_start();
  require(".././controlPages/connection.php");

  $compOne = $_POST["compOne"];
  $compOneExp = explode("-", $compOne);
  $compTwo = $_POST["compTwo"];
  $compTwoExp = explode("-", $compTwo);

  $monthQuery = mysqli_query($connect_db, "SELECT DAY(o_time) AS day_id, MONTH(o_time) AS month_id, YEAR(o_time) as year, SUM(o_total_price) AS total_price
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
  GROUP BY orders.sc_id)
  	AND YEAR(o_time) in ($compOneExp[0], $compTwoExp[0])
    AND MONTH(o_time) in ($compOneExp[1], $compTwoExp[1])
  GROUP BY DAY(o_time), MONTH(o_time)
  ORDER BY month_id, day_id");

  $result = array();
  $loop = 0;
  while($loop <= 31) {
    $result[$loop] = [$loop, null, null];
    $loop++;
  }

  while($compResult = mysqli_fetch_assoc($monthQuery)){
    if($compResult["month_id"] == $compOneExp[1] && $compResult["year"] == $compOneExp[0]) {
      $result[$compResult["day_id"]][1] = (float)$compResult["total_price"];
    } else if($compResult["month_id"] == $compTwoExp[1] && $compResult["year"] == $compTwoExp[0]) {
      $result[$compResult["day_id"]][2] = (float)$compResult["total_price"];
    }
  }

  echo json_encode($result);
}
 ?>
