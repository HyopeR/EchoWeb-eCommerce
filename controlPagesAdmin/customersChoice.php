<?php
if($_POST) {
  header('Content-Type:application/json');
  session_start();
  require(".././controlPages/connection.php");

  if(isset($_POST["selectGender"])){
    $selectGender = $_POST["selectGender"];
    if ($selectGender == "" || $selectGender == 0) {$selectGender = null;}
  } else {
    $selectGender = null;
  }

  if(isset($_POST["selectAge"])){
    $selectAge = $_POST["selectAge"];
    if ($selectAge == "") {$selectAge = null;}
    else {$selectAge = (int)$selectAge;}
  } else {
    $selectAge = null;
  }

  if($selectGender != null && $selectAge != null){
    $query = mysqli_query($connect_db, "SELECT products_category.pc_name, sum(products_shop_cart.sc_piece) as big_low
    FROM products
    LEFT JOIN products_category
    ON products.pc_id = products_category.pc_id
    LEFT JOIN products_shop_cart
    ON products.p_id = products_shop_cart.p_id
    LEFT JOIN shop_cart
    ON products_shop_cart.sc_id = shop_cart.sc_id
    LEFT JOIN orders
    ON shop_cart.sc_id = orders.sc_id
    LEFT JOIN users
    ON orders.u_id = users.u_id
    LEFT JOIN users_gender
    ON users.g_id = users_gender.g_id
    LEFT JOIN users_country
    ON users.uc_id = users_country.uc_id
    WHERE users_gender.g_id = $selectGender
    AND YEAR(CURDATE()) - YEAR(u_date) = $selectAge
    GROUP BY products_category.pc_id
    ORDER BY big_low DESC
    LIMIT 20");
  } else if($selectGender != null && $selectAge == null){
    $query = mysqli_query($connect_db, "SELECT products_category.pc_name, sum(products_shop_cart.sc_piece) as big_low
    FROM products
    LEFT JOIN products_category
    ON products.pc_id = products_category.pc_id
    LEFT JOIN products_shop_cart
    ON products.p_id = products_shop_cart.p_id
    LEFT JOIN shop_cart
    ON products_shop_cart.sc_id = shop_cart.sc_id
    LEFT JOIN orders
    ON shop_cart.sc_id = orders.sc_id
    LEFT JOIN users
    ON orders.u_id = users.u_id
    LEFT JOIN users_gender
    ON users.g_id = users_gender.g_id
    LEFT JOIN users_country
    ON users.uc_id = users_country.uc_id
    WHERE users_gender.g_id = $selectGender
    GROUP BY products_category.pc_id
    ORDER BY big_low DESC
    LIMIT 20");
  } else if($selectGender == null && $selectAge != null){
    $query = mysqli_query($connect_db, "SELECT products_category.pc_name, sum(products_shop_cart.sc_piece) as big_low
    FROM products
    LEFT JOIN products_category
    ON products.pc_id = products_category.pc_id
    LEFT JOIN products_shop_cart
    ON products.p_id = products_shop_cart.p_id
    LEFT JOIN shop_cart
    ON products_shop_cart.sc_id = shop_cart.sc_id
    LEFT JOIN orders
    ON shop_cart.sc_id = orders.sc_id
    LEFT JOIN users
    ON orders.u_id = users.u_id
    LEFT JOIN users_gender
    ON users.g_id = users_gender.g_id
    LEFT JOIN users_country
    ON users.uc_id = users_country.uc_id
    WHERE YEAR(CURDATE()) - YEAR(u_date) = $selectAge
    GROUP BY products_category.pc_id
    ORDER BY big_low DESC
    LIMIT 20");
  }

  $array = array();
  $array[] = ['Kategoriler', 'Sipariş Sayısı'];

  while($row = mysqli_fetch_assoc($query)){
    $array[] = [$row["pc_name"], (int)$row["big_low"]];
  }

  echo json_encode($array);
}


?>
