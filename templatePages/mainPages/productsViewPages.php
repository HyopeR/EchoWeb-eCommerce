<?php
session_start();

// URL PARÇALAMA VE KONUM YAZMA İŞELVİNİ OTOMATİĞE BAĞLA VE SAYFALARA İNCLUDE ET.
$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]$_SERVER[QUERY_STRING]";
$pagenameExp = explode("/", $url);
$pageExp = explode(".", $pagenameExp[6]);
$pageName = $pageExp[0];
$starState = "";

require("../../.././controlPages/connection.php");

$dbControl=mysqli_query($connect_db, "SELECT p_name, p_price, pc_id, pg_id, products.p_id AS p_id, p_content, products_body.p_stock AS p_stock
                                      FROM products
                                      LEFT JOIN products_body
                                      ON products.p_id = products_body.p_id
                                      LEFT JOIN body
                                      ON products_body.b_id = body.b_id
                                      WHERE p_page = '".$pageName."' AND body.b_name in ('XS','36','Standart') ");
$queryOneValue = mysqli_fetch_row($dbControl);
$p_name = $queryOneValue[0];
$p_price = $queryOneValue[1];
$p_id = $queryOneValue[4];
$p_content = $queryOneValue[5];
$p_stock = $queryOneValue[6];


$dbControl=mysqli_query($connect_db, "SELECT pc_name FROM products_category WHERE pc_id = '".$queryOneValue[2]."'");
$queryTwoValue = mysqli_fetch_row($dbControl);
$pc_name = $queryTwoValue[0];

$dbControl=mysqli_query($connect_db, "SELECT pg_name FROM products_gender WHERE pg_id = '".$queryOneValue[3]."'");
$queryThreeValue = mysqli_fetch_row($dbControl);
$pg_name = $queryThreeValue[0];

$dbControl=mysqli_query($connect_db, "SELECT p_media FROM products_media WHERE p_id = '".$p_id."'");
$queryFourValue = mysqli_fetch_row($dbControl);
$p_media = "../../".$queryFourValue[0];

if(isset($_SESSION['user_email'])) {
  $user_email = $_SESSION["user_email"];

  $userDb = mysqli_query($connect_db, "SELECT u_id FROM users WHERE u_email = '".$user_email."' ");

  if(mysqli_num_rows ($userDb) > 0) {
    $userId = mysqli_fetch_row($userDb);
    $likeDb = mysqli_query($connect_db, "SELECT like_state FROM products_like WHERE u_id = '".$userId[0]."' AND p_id = '".$p_id."' ");
    $likeState = mysqli_fetch_row($likeDb);
    $starState = $likeState[0];

    $dbInsert = mysqli_query($connect_db, "INSERT INTO products_view (u_id, p_id) VALUES ('".$userId[0]."', '".$p_id."') ");

    $dbCountView = mysqli_query($connect_db, "SELECT count(p_id) FROM products_view WHERE p_id = '".$p_id."'");
    $countView = mysqli_fetch_row($dbCountView);
  }
} else {

  $dbInsert = mysqli_query($connect_db, "INSERT INTO products_view (p_id) VALUES ('".$p_id."')");

  $dbCountView = mysqli_query($connect_db, "SELECT count(p_id) FROM products_view WHERE p_id = '".$p_id."'");
  $countView = mysqli_fetch_row($dbCountView);

}

$allCommentDb = mysqli_query($connect_db, "SELECT count(c_id) FROM products_comment WHERE p_id = '".$p_id."' ");
$allCommentArray = mysqli_fetch_row($allCommentDb);

$dbControl = mysqli_query($connect_db, "SELECT avg(like_state)
                                        FROM products_like
                                        WHERE products_like.p_id = '".$p_id."' ");
$dbValue = mysqli_fetch_row($dbControl);
$roundLikeState = round($dbValue[0]);

$dbControl = mysqli_query($connect_db, "SELECT count(u_id)
                                        FROM products_like
                                        WHERE products_like.p_id = '".$p_id."' ");
$dbValue = mysqli_fetch_row($dbControl);
$starPersonValue = round($dbValue[0]);

$bedenArray = array("Tişört", "Gömlek", "Hırka/Mont", "Kazak/Sweetshirt", "Pantolon", "Şort", "Elbise", "Etek");
?>

<?php require("mainDesignTop.php"); ?>
<?php include("../../.././controlPages/breadCrumpTree.php"); ?>

<div class="section">
  <div class="container">
    <div class="row">
      <div class="col-md-5">
        <div id="product-main-img">
          <div class="product-preview">
            <?php echo '<img src="'.$p_media.'" alt="">'; ?>
          </div>
        </div>
        <br>
      </div>

      <div class="col-md-7">
        <div class="product-details">
          <?php echo '<h2 class="product-name">'.$p_name.'</h2>'; ?>
          <div>
            <?php echo '<h3 class="product-price">'.$p_price.' ₺</h3>' ?>
            <?php
              if($p_stock > 0) {
                echo '
                <span id="stock_span" class="product-available">
                <input id="stock_product" class="hiddenInput" value="1">
                <span id="stock_a">Stokta Var</a>
                </span>';}
              else {
                echo '
                <span id="stock_span" class="product-not-available">
                <input id="stock_product" class="hiddenInput" value="0">
                <span id="stock_a">Stokta Yok</a>
                </span>';}
             ?>
          </div>
          <?php
          if($p_content == "") {
            echo '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
              Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>';
          } else {
            echo '<p>'.$p_content.'</p>';
          }
          ?>

          <?php
          echo '<form id="cart_add_form" name="cart_add_button" method="POST">';
          if (in_array ($pc_name , $bedenArray)) {
            echo '
            <div class="product-options">
              <label>
                Beden Seçimi:
                <select name="body_select" id="body_select" class="input-select">
                  <option value="XS">XS</option>
                  <option value="S">S</option>
                  <option value="M">M</option>
                  <option value="L">L</option>
                  <option value="XL">XL</option>
                  <input name="selectHiddenId" id="selectHiddenId" class="hiddenInput" type="text" value="'.$p_id.'">
                </select>
              </label>
            </div>
            ';
          } else if ($pc_name == "Ayakkabı") {
            echo '
            <div class="product-options">
              <label>
                Numara Seçimi:
                <select name="body_select" id="body_select" class="input-select">
                  <option value="36">36</option>
                  <option value="37">37</option>
                  <option value="38">38</option>
                  <option value="39">39</option>
                  <option value="40">40</option>
                  <option value="41">41</option>
                  <option value="42">42</option>
                  <option value="43">43</option>
                  <option value="44">44</option>
                  <option value="45">45</option>
                  <input name="selectHiddenId" id="selectHiddenId" class="hiddenInput" type="text" value="'.$p_id.'">
                </select>
              </label>
            </div>
            ';
          } else {
            echo '
            <input name="body_select" id="body_select" type="text" value="Standart" class="hiddenInput">
            ';
          }
          ?>

          <div class="add-to-cart">
            <div class="qty-label">
              Adet Seçimi:
              <div class="input-number">
                <input name="quantity_products" id="quantity_products" value="1" type="number">
                <span id="qty-up" class="qty-up">+</span>
                <span id="qty-down" class="qty-down">-</span>
              </div>
            </div>
          </div>

          <div class="add-to-cart">
              <?php echo '<input name="hidden_product_id" id="hidden_product_id" type="text" value="'.$p_id.'" readonly>' ?>
              <button type="button" id="cart_add_button" class="add-to-cart-btn">Sepete Ekle</button>
            </form>
          </div>

          <ul class="product-links">
            <li>Kategori:</li>
            <?php
            echo'
            <li><a href="#">'.$pc_name.'</a></li>
            <li><a href="#">'.$pg_name.'</a></li>
            ';
            ?>
          </ul>

          <ul class="product-links">
            <li>Görüntülenme:</li>
            <?php
            echo'
            <li><a>'.$countView[0].'</a></li>
            ';
            ?>
          </ul>

          <ul class="product-links">
            <li>Ortalama Puan:</li>
            <div class="product-rating">
              <?php
              for($loop = 0; 5 > $loop; $loop++) {
                if(
                  $roundLikeState != 0) {echo '<i class="fa fa-star"></i>';
                  $roundLikeState --;
                  }
                else {echo '<i class="fa fa-star-o"></i>';}

              }
                 ?>
            </div>
            <li><p><?php echo "(".$starPersonValue.") kişi oyladı." ?></p></li>
          </ul>

        </div>
      </div>

      <div class="col-md-12">
        <div id="product-tab">
          <ul class="tab-nav">
            <li class="active"><a data-toggle="tab" href="#tab1">Açıklama</a></li>
            <li><a data-toggle="tab" href="#tab2">Detaylar</a></li>
            <li><a data-toggle="tab" href="#tab3">Yorumlar (<?php echo $allCommentArray[0] ?>)</a></li>
          </ul>

          <div class="tab-content">
            <div id="tab1" class="tab-pane fade in active">
              <div class="row">
                <div class="col-md-12">
                  <?php
                  if($p_content == "") {
                    echo '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                      Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>';
                  } else {
                    echo '<p>'.$p_content.'</p>';
                  }
                  ?>
                </div>
              </div>
            </div>

            <div id="tab2" class="tab-pane fade in">
              <div class="row">
                <div class="col-md-12">
                  <?php
                  if($p_content == "") {
                    echo '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                      Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>';
                  } else {
                    echo '<p>'.$p_content.'</p>';
                  }
                  ?>
                </div>
              </div>
            </div>

            <div id="tab3" class="tab-pane fade in">
              <div class="row">
                <div class="col-md-8">
                  <div id="reviews">
                    <ul class="reviews">
                      <?php
                      $dbCommentsPost=mysqli_query($connect_db, "SELECT u_name, c_time, like_state, c_content
                      FROM products
                      LEFT JOIN products_comment
                      ON products.p_id = products_comment.p_id
                      LEFT JOIN users
                      ON products_comment.u_id = users.u_id
                      LEFT JOIN products_like
                      ON users.u_id = products_like.u_id AND products_like.p_id = products.p_id
                      WHERE products.p_id = $p_id
                      ORDER BY c_time DESC
                      ");

                      if($allCommentArray[0] > 0) {
                        while($row=mysqli_fetch_assoc($dbCommentsPost)) {
                          echo'
                          <li>
                            <div class="review-heading">
                              <h5 class="name">'.$row["u_name"].'</h5>
                              <p class="date">'.$row["c_time"].'</p>
                              <div class="review-rating">
                              ';
                              for($loop = 0; 5 > $loop; $loop++) {
                                if(
                                  $row["like_state"] != 0) {echo '<i class="fa fa-star"></i>';
                                  $row["like_state"] --;
                                }
                                else {echo '<i class="fa fa-star-o"></i>';}
                              }
                          echo'
                              </div>
                            </div>
                            <div class="review-body">
                              <p>'.$row["c_content"].'</p>
                            </div>
                          </li>
                          ';
                        }
                      } else {
                        echo'
                            <h5>Henüz hiç yorum yapılmamış...</h5>
                        ';
                      }
                       ?>
                    </ul>
                  </div>
                </div>

                <div class="col-md-4">
                  <div id="review-form">
                    <?php

    								$sessionControlUser = isset($_SESSION['user_email']);
    								if (((int)$sessionControlUser) == 0) {
                      echo'
                      <div id="please-register">
                      <p>
                          Yorum ve Değerlendirme için;
                          <br>
                          <span onclick="logFunction()">Giriş Yap</span>
                          /
                          <span onclick="regFunction()">Üye Ol</span>
                      </p>
                      </div>
                      <form class="review-form" method = "POST" action = "'.SCRIPT_ROOT.'controlPages/controlLike.php">
                        <input name="comment_name" class="input" type="text" placeholder="Your Name">
                        <input name="comment_email" class="input" type="email" placeholder="Your Email">
                        <input name="comment_product_id" id="comment_product_id" type="text" value="'.$p_id.'" readonly>
                      ';
                    } else {
                      $user_email = $_SESSION['user_email'];
                      $user_name = $_SESSION['user_name'];

                      echo'
                      <form class="review-form" method = "POST" action = "'.SCRIPT_ROOT.'controlPages/controlLike.php">
                      <input name="comment_name" type="text" class="input" value="'.$user_name.'" readonly>
                      <input name="comment_email" type="text" class="input" value="'.$user_email.'" readonly>
                      <input name="comment_product_id" id="comment_product_id" type="text" value="'.$p_id.'" readonly>
                      ';
                    }
                    ?>

                      <textarea name="comment_content" class="input" placeholder="Your Review"></textarea>
                      <?php
                      if($starState == "") {
                        echo '
                        <div class="input-rating">
                          <span>Ürünü Puanla: </span>
                          <div class="stars">
                            <input id="star5" name="rating" value="5" type="radio"><label for="star5"></label>
                            <input id="star4" name="rating" value="4" type="radio"><label for="star4"></label>
                            <input id="star3" name="rating" value="3" type="radio"><label for="star3"></label>
                            <input id="star2" name="rating" value="2" type="radio"><label for="star2"></label>
                            <input id="star1" name="rating" value="1" type="radio"><label for="star1"></label>
                          </div>
                        </div>
                        ';
                      } else if ($starState != "") {
                        echo '<div class="input-rating">
                                <span>Önceki Puanın: </span>
                                <div class="stars">';
                        for($loop = 0; $starState > $loop; $loop++) {
                          echo '<input id="star1" name="rating" value="0" type="radio" readonly><label for="star1" readonly></label>';
                        }
                        echo '</div></div>';
                      }
                      ?>
                      <button class="primary-btn">Yorum Ekle</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require("mainDesignBottom.php"); ?>
<script>
$('#cart_add_button').click(function() {
  let stock = document.getElementById("stock_product");
  if (stock.value == 1) {
    $.ajax({
      type: "POST",
      url: "http://localhost/controlPages/controlShopCart.php",
      data: { hidden_product_id: hidden_product_id.value, quantity_products: quantity_products.value, body_select: body_select.value},
    }).done(function( thisResult ) {
      location.reload();
    });
  } else {
    alert("Ürünün bu bedeni stoklarda mevcut değildir.")
  }
  });

$("#body_select").change(function(){
  $.ajax({
    type: "POST",
    url: "http://localhost/controlPages/controlStock.php",
    data: { body_select: body_select.value, selectHiddenId: selectHiddenId.value},
  }).done(function( stockResult ) {
    if(stockResult == 1) {
      let stockSpan = document.getElementById("stock_span");
      stockSpan.className = "product-available";
      let stockA = document.getElementById("stock_a");
      stockA.innerText = "Stokta Var";
      let stock = document.getElementById("stock_product");
      stock.value = 1;
    } else {
      let stockSpan = document.getElementById("stock_span");
      stockSpan.className = "product-not-available";
      let stockA = document.getElementById("stock_a");
      stockA.innerText = "Stokta Yok";
      let stock = document.getElementById("stock_product");
      stock.value = 0;
    }
  });
});

function logFunction() {
  $("html, body").animate({ scrollTop: 0 }, "slow");
  return false;
}

function regFunction() {
  $("html, body").animate({ scrollTop: 0 }, "slow");
  return false;
}
</script>
