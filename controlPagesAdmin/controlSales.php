<?php

  if($_POST) {

    session_start();
    require(".././controlPages/connection.php");

    $selectMonth = $_POST["selectMonth"];
    $selectYear = $_POST["selectYear"];

    $allSales = mysqli_query($connect_db,
    "SELECT DAY(o_time) as day_id, DAYNAME(o_time) as day_name, COUNT(o_id) as sum
    FROM orders
    WHERE o_id in (SELECT o_id
    FROM orders
    LEFT JOIN users
    ON orders.u_id = users.u_id
    LEFT JOIN shop_cart
    ON orders.sc_id = shop_cart.sc_id
    LEFT JOIN products_shop_cart
    ON shop_cart.sc_id = products_shop_cart.sc_id
    LEFT JOIN products
    ON products_shop_cart.p_id = products.p_id
    LEFT JOIN seller
    ON products.s_id = seller.s_id
    WHERE seller.s_email = '".$_SESSION["seller_email"]."'
    AND MONTH(o_time) = '".$selectMonth."'
    AND YEAR(o_time) = '".$selectYear."'
    GROUP BY shop_cart.sc_id)
    GROUP BY day_id
    ");

    // $resultArray = array();
    // $dataCalender = date('d.m.Y',strtotime('last day of this month'));
    // $dataDay = explode(".",$dataCalender);
    // $dataDay[0];
    while($daySales=mysqli_fetch_assoc($allSales)) {
      echo '<option value="'.$daySales["day_id"].'">'.$daySales['day_name'].' ('.$daySales["day_id"].')</option>'.','.$daySales["day_name"].",".$daySales["sum"].",";
    }

    }
?>
