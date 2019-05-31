<?php

if($_POST) {

  session_start();
  require(".././controlPages/connection.php");
  $countrySelect = $_POST["countrySelect"];

  $dbControl = mysqli_query($connect_db, "SELECT users_country.uc_name, count(u_id)
  FROM users
  RIGHT JOIN users_country
  ON users.uc_id = users_country.uc_id
  WHERE users_country.uc_id = '".$countrySelect."' ");

  $dbValue = mysqli_fetch_row($dbControl);

  $dbControl2 = mysqli_query($connect_db, "SELECT COUNT(o_id)
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
  WHERE users.uc_id = '".$countrySelect."' AND seller.s_email = '".$_SESSION["seller_email"]."'
  GROUP BY shop_cart.sc_id) ");

  $dbValue2 = mysqli_fetch_row($dbControl2);

  echo "<b>".$dbValue[0]."</b> şehri için ► Detaylar<br>";
  echo "<b>Bölgedeki Kullanıcı Sayısı:</b> ".$dbValue[1]."<br>";
  echo "<b>Bölgeden Alınan Sipariş:</b> ".$dbValue2[0]."<br>";


}

 ?>
