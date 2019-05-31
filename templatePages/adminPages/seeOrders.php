<?php require("adminSettingsTop.php"); ?>
<?php require("adminDesignTop.php"); ?>
<?php require("../.././controlPages/connection.php"); ?>
<h3>Sipariş Takibi ► Siparişleri Gör</h3>
  <hr class="userspage-hr">

<input id="hiddenTabId" class="hiddenInput" type="text" value="1">
<div class="row">
  <div class="col-md-12">
    <div class="col-md-12">
      <div id="pageHeader">
        <div id="leftButton"><span id="prevPage" value="Prev" onclick="orderPage(this);" class="fa fa-arrow-left"></div>
        <div id="inCenter"><div id="centerText"><p id="pageNumber">Siparişler (<span id="centerValue">1</span>)</p></div></div>
        <div id="rightButton"><span id="nextPage" value="Next" onclick="orderPage(this);" class="fa fa-arrow-right"></div>
      </div>
    </div>

    <div class="col-md-12" id="noPad12">
      <input id="saveClick" class="hiddenInput" type="text" value="null">
      <?php
        $allOrders = mysqli_query($connect_db, "SELECT o_id, o_total_price, o_time
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
        LEFT JOIN seller
        ON products.s_id = seller.s_id
        WHERE seller.s_email = '".$_SESSION["seller_email"]."'
        GROUP BY orders.o_id
        ORDER BY orders.o_time desc");

          $line = 1;
          $loop = 0;
          $controlLoop = 0;
          $styleConfig = 'style="display: block"';
          while($row=mysqli_fetch_assoc($allOrders)) {
            if($controlLoop == 10){
              $controlLoop = 0;
              $line++;
              $styleConfig = 'style="display: none"';
            }
            if($controlLoop == 0){
              echo '
              <div class="col-md-12" id="view-tab-'.$line.'" '.$styleConfig.'>
              ';
            }
            echo '
            <div id="order-tab-'.$loop.'">
            <form id="orderListForm-'.$row["o_id"].'" method="POST">
              <div class="orderListButton">
                <span onclick = "viewOrder(this);" id="listButton" class="btn btn-outline-success my-2 my-sm-0" type="button" value="'.$row["o_id"].'">
                  Sipariş No: '.$row["o_id"].' ▼
                </span>
              </div>
            </form>
              <div id="orderContent-'.$row["o_id"].'" class="orderContent"></div>
              </div>
            ';

            if($controlLoop == 9){
              echo '
              </div>
              ';
            }

            $loop++;
            $controlLoop++;
          }
      ?>
    </div>
  </div>
</div>
<?php require("adminSettingsBottom.php"); ?>
<?php require("adminDesignBottom.php"); ?>
