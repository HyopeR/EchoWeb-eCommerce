<?php

  if($_POST) {

    session_start();
    require(".././controlPages/connection.php");

    $selectYear = $_POST["selectYear"];

    $monthList = mysqli_query($connect_db,
    "SELECT YEAR(o_time) as year, MONTHNAME(o_time) as month_name, MONTH(o_time) as month_id, COUNT(o_id) as sum
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
    GROUP BY shop_cart.sc_id)
    GROUP BY month_name
    HAVING sum > 0 AND year = '".$selectYear."'
    ORDER BY MONTH(o_time)");

    echo '<option value="" disabled="disabled" selected="selected">Ay Seçiniz</option>';
    while($month = mysqli_fetch_assoc($monthList)) {
      echo '
        <option value="'.$month["month_id"].'">'.$month["month_name"].'</option>
      ';
    }

    }
?>
