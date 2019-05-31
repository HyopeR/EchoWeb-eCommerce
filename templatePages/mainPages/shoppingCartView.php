<?php
  session_start();
  require("../.././controlPages/connection.php");
?>
<?php require("mainDesignTop.php"); ?>
<?php include("../.././controlPages/breadCrumpTree.php"); ?>
<style>
#cart-drop {
  display: none;
}
</style>
<div class="container">
  <div class="row">
    <div class="col-md-7">
      <div id="cart-all-view">Sepetinizde ki ürünler:
        <?php
          if(isset($_SESSION['cart_id'])) {

            $cart_id = $_SESSION['cart_id'];
            $dbControl=mysqli_query($connect_db, "SELECT p_name, p_media, pc_name, sc_piece, sc_total, products.p_id as p_id, products_shop_cart.b_id as b_id, b_name
                                                  FROM shop_cart
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
                                                  WHERE products_shop_cart.sc_id = '".$cart_id."' ");

            $totalPrice = 0;
            $valueLoop = 0;

            while($row=mysqli_fetch_assoc($dbControl)) {
              $valueLoop++;
              $totalPrice = $totalPrice + $row["sc_total"];

              echo'
              <div id="cart-view-'.$valueLoop.'" class="cart-view">

                <div class="row">

                  <div class="cart_form_div">
                    <form id="cart-form-'.$valueLoop.'" name="cart_form" class="cart_form" method="POST">
                      <input class="hiddenInput" name="cart_id" id="cart2_id_'.$valueLoop.'" value="'.$cart_id.'" readonly>
                      <input class="hiddenInput" name="product_id" id="product2_id_'.$valueLoop.'" value="'.$row["p_id"].'" readonly>
                      <input class="hiddenInput" name="body_id" id="body2_id_'.$valueLoop.'" value="'.$row["b_id"].'" readonly>
                      <span class="delete" type="button" value="'.$valueLoop.'" onclick = "cartItemDelete(this);"><i class="fa fa-close"></i></span>
                    </form>
                  </div>

                  <div class="col-md-4">
                    <div class="cart-view-img"><img src="'.SCRIPT_ROOT.''.$row["p_media"].'" alt=""></div>
                  </div>

                  <div class="col-md-8">
                    <div>
                      <h3 class="cart-product-name"><a href="#">'.$row["p_name"].'</a></h3>
                    </div>

                    <div id="cart-product-detail" class="cart-product-detail">
                      <h4>Detaylar</h4>

                        <div>
                          <h4 id="cart-product-quantity" class="cart-product-quantity">
                            <p>Adet: <span id="qty-value">'.$row["sc_piece"].'</span></p>
                          </h4>
                        </div>

                        <div><h4 id="cart-product-price" class="cart-product-price">
                          <p>Tutar: <span id="cart-item-price-'.$valueLoop.'">'.$row["sc_total"].'</span></p>
                          </h4>
                        </div>

                        <div><h4 id="cart-product-size" class="cart-product-size">
                          <span id="item-size-">Beden: '.$row["b_name"].'</span>
                          </h4>
                        </div>
                    </div>

                  </div>
                </div>

              </div>
              ';
            }
          } else {
            echo'
            <div class="row">
              <div class="col-md-12"><br>Sepetiniz boş.</div>
            </div>
            ';
          }
        ?>

      </div>
    </div>
    <div class="col-sm-5">
      <div id="cart-all-order">
        <div id="cart-order-view">
          <div class="row">
            <div class="col-sm-12">
              <h4>Sepet Toplamı</h4>
              <hr>
              <?php
              if(isset($_SESSION['cart_id'])) {
                echo '
                  <p>Ürün sayısı: <span id="cartview-value">'.$valueLoop.'</span></p>
                  <p>Toplam Tutar: <span id="cartview-total">'.$totalPrice.'</span></p>
                ';
              } else {
                echo '
                  <p>Ürün sayısı: <span id="cartview-value">0</span></p>
                  <p>Toplam Tutar: <span id="cartview-total">0</span></p>
                ';
              }
              ?>

            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <?php
                if(isset($_SESSION['user_email'])) {
                  $user_email = $_SESSION['user_email'];
                  $dbUsers = mysqli_query($connect_db, "SELECT u_address, u_id FROM users WHERE u_email = '".$user_email."' ");
                  $dbUsersRow = mysqli_fetch_row($dbUsers);

                  $user_address = $dbUsersRow[0];
                  $user_id = $dbUsersRow[1];

                  echo '
                  <p id="detail-order">Mevcut Adres:</p>
                  <form id="orderMainForm" name="orderMainForm" method="POST">
                    <input id="hiddenUserId" class="hiddenInput" name="hiddenUserId" type="text" value="'.$user_id.'">
                    ';
                    if(isset($_SESSION['cart_id'])){
                      echo '<input id="hiddenCartId" class="hiddenInput" name="hiddenCartId" type="text" value="'.$cart_id.'">';
                    } else {
                      echo '<input id="hiddenCartId" class="hiddenInput" name="hiddenCartId" type="text" value="null">';
                    }
                    echo'
                      <textarea id="order-address" class="form-control" readonly>'.$user_address.'</textarea>
                      <input type="button" id="addOrder" class="btn btn-outline-success my-2 my-sm-0" value="Sipariş Ver">
                    </form>
                    ';
                } else {
                  echo '
                    <p id="detail-order">Sipariş vermek için üye girişi yapmalısınız.</p>
                    <input type="button" id="router" class="btn btn-outline-success my-2 my-sm-0"  value="Üye Girişi">
                  ';
                }
               ?>

            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php require("mainDesignBottom.php"); ?>
