<?php

  session_start();
  require("connection.php");

  $user_email = $_SESSION["user_email"];
  $order_id = $_POST["hiddenOrderId"];

  $dbControl = mysqli_query($connect_db, "SELECT p_name, p_media, pc_name, sc_piece, sc_total, products.p_id as p_id, products_shop_cart.b_id as b_id, b_name, o_time, o_id, o_total_price
  FROM users
  LEFT JOIN orders
  ON users.u_id = orders.u_id
  LEFT JOIN shop_cart
  ON orders.sc_id = shop_cart.sc_id
  LEFT JOIN products_shop_cart
  ON shop_cart.sc_id = products_shop_cart.sc_id
  LEFT JOIN products
  ON products_shop_cart.p_id = products.p_id
  LEFT JOIN products_media
  ON products.p_id = products_media.p_id
  LEFT JOIN products_category
  ON products.pc_id = products_category.pc_id
  LEFT JOIN products_body
  ON products.p_id = products_body.p_id
  AND products_shop_cart.b_id = products_body.b_id
  LEFT JOIN body
  ON products_body.b_id = body.b_id
  WHERE users.u_email = '".$user_email."' AND orders.o_id = '".$order_id."' ");

  echo '
  <div class="row" id="list-order-row">
    <div class="col-md-12" id="list-order-item">
      <div class="col-md-2"><p class="list-order-title">Ürün Resmi</p></div>
      <div class="col-md-5"><p class="list-order-title">Ürün İsmi</p></div>
      <div class="col-md-2"><p class="list-order-title">Kategori</p></div>
      <div class="col-md-1"><p class="list-order-title">Adet</p></div>
      <div class="col-md-2"><p class="list-order-title">Beden</p></div>
    </div>';
  while($orderContent=mysqli_fetch_assoc($dbControl)) {

    $order_time = $orderContent["o_time"];
    $order_total = $orderContent["o_total_price"];

    echo '
      <div class="col-md-12" id="list-order-item">
          <div class="col-md-2"><img width="50" height="75" src="../'.$orderContent["p_media"].'"></div>
          <div class="col-md-5"><p class="list-order-text">'.$orderContent["p_name"].'</p></div>
          <div class="col-md-2"><p class="list-order-text">'.$orderContent["pc_name"].'</p></div>
          <div class="col-md-1"><p class="list-order-text">'.$orderContent["sc_piece"].'</p></div>
          <div class="col-md-2"><p class="list-order-text">'.$orderContent["b_name"].'</p></div>
      </div>
    ';
  }
  echo '
  <div class="col-md-12" id="list-order-item">
    <div class="col-md-6"><p class="list-order-title">Sipariş Zamanı: <span class="list-order-detail">'.$order_time.'</span></p></div>
    <div class="col-md-6"><p class="list-order-title">Toplam Tutar: <span class="list-order-detail">'.$order_total.' ₺</span></p></div>
  </div>
    </div>
  </div>'



 ?>
