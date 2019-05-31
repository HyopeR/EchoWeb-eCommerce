<?php

  if($_POST) {

    session_start();
    require(".././controlPages/connection.php");

    $selectDay = $_POST["selectDay"];
    $selectMonth = $_POST["selectMonth"];
    $selectYear = $_POST["selectYear"];

    $allSales = mysqli_query($connect_db,
    "SELECT products_category.pc_name, SUM(products_shop_cart.sc_piece) as total_sales
    FROM orders
    LEFT JOIN users
    ON orders.u_id = users.u_id
    LEFT JOIN shop_cart
    ON orders.sc_id = shop_cart.sc_id
    LEFT JOIN products_shop_cart
    ON shop_cart.sc_id = products_shop_cart.sc_id
    LEFT JOIN products
    ON products_shop_cart.p_id = products.p_id
    LEFT JOIN products_category
    ON products.pc_id = products_category.pc_id
    LEFT JOIN seller
    ON products.s_id = seller.s_id
    WHERE DAY(o_time) = '".$selectDay."'
    AND MONTH(o_time) = '".$selectMonth."'
    AND YEAR(o_time) = '".$selectYear."'
    AND seller.s_email = '".$_SESSION["seller_email"]."'
    GROUP BY products_category.pc_id");

    while($daySales=mysqli_fetch_assoc($allSales)) {
      echo $daySales["pc_name"].",".$daySales["total_sales"].",";
    }

    }
?>
