<?php

if($_POST) {
  header('Content-Type:application/json');
  session_start();
  require(".././controlPages/connection.php");

  $selectYear = $_POST["priceYear"];

  $loopSales = mysqli_query($connect_db,
  "SELECT MONTH(o_time) AS month_id, MONTHNAME(o_time) AS month_name, COUNT(o_id) as order_count
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
      AND YEAR(o_time) = '".$selectYear."'
    GROUP BY month_id
    ORDER BY month_id");

    $listMonth = array();
    $array = array(['Gün']);
    $gun = 1;
    $listDay = array([$gun]);
    $columnAdd = 1;

    while($subsetLoop = mysqli_fetch_assoc($loopSales)) {
      $array[0][$columnAdd] = $subsetLoop["month_name"]." Gelir";
      $listMonth[] = $subsetLoop["month_id"];
      $listDay[0][$columnAdd] = null;
      $columnAdd++;
    }

    for($i = 0; $i < count($listMonth); $i++){
      $seletIndex = $i + 1;

      $yearSales = mysqli_query($connect_db,
      "SELECT DAY(o_time) AS day_id, MONTH(o_time) AS month_id, SUM(o_total_price) AS total_price
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
          AND YEAR(o_time) = '".$selectYear."'
          AND MONTH(o_time) = '".$listMonth[$i]."'
        GROUP BY DAY(o_time), MONTH(o_time)
        ORDER BY month_id, day_id");

        while($row = mysqli_fetch_assoc($yearSales)){
          for($a = 0; $a < count($listDay); $a++){
            $listDay[0][$seletIndex] = (float)$row["total_price"];
            $array[] = $listDay[$a];
          }
          $gun++;
          $listDay[0][$seletIndex] = null;
          $listDay[0][0] = $gun;
        }
    }

    echo json_encode($array, JSON_UNESCAPED_UNICODE);
}

 ?>
