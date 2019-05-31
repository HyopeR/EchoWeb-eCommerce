<?php
  session_start();
  require("connection.php");

  if(isset($_SESSION["pg_name"])) {
    $pg_name = $_SESSION["pg_name"];
  }

  if(isset($_POST["valueSelect"])) {
    $pc_id = $_POST["valueSelect"];
  }
  else {
    $pc_id=1;
  }

  $dbTsort=mysqli_query($connect_db, "SELECT p_name, p_price, pc_name, p_media, p_page, s_name, products.p_id as p_id, pg_name
                                          FROM products
                                          LEFT JOIN products_category
                                          ON products.pc_id = products_category.pc_id
                                          LEFT JOIN products_media
                                          ON products.p_id = products_media.p_id
                                          LEFT JOIN seller
                                          ON products.s_id = seller.s_id
                                          LEFT JOIN products_gender
                                          ON products.pg_id = products_gender.pg_id
                                          WHERE products.pc_id = '".$pc_id."' and pg_name ='".$pg_name."' ");

    $loopValue = 0;
    while($row=mysqli_fetch_assoc($dbTsort)) {
      $loopValue ++;
      if($loopValue == 1) {
        echo '<div><h4 class="genderCatTitle">'.$row["pg_name"].' ► '.$row["pc_name"].'</h4></div>';
      }
      $p_page = "http://localhost/seller/".$row["s_name"]."/productpages/".$row["p_page"].".php";
      echo '
      <div class="col-md-4 col-xs-6">
        <div class="product">
          <div class="product-img">
            <img src="../../'.$row["p_media"].'" alt="">
          </div>
          <div class="product-body">
            <p class="product-category">'.$row["pc_name"].'</p>
            <h3 class="product-name"><a href="'.$p_page.'">'.$row["p_name"].'</a></h3>
            <h4 class="product-price">'.$row["p_price"].' ₺</h4>
            <div class="product-btns">
              <div class="product-rating">';

            $dbControl = mysqli_query($connect_db, "SELECT avg(like_state)
                                                    FROM products_like
                                                    WHERE products_like.p_id = '".$row["p_id"]."' ");
            $dbValue = mysqli_fetch_row($dbControl);
            $roundLikeState = round($dbValue[0]);

            for($loop = 0; 5 > $loop; $loop++) {
              if(
                $roundLikeState != 0) {echo '<i class="fa fa-star"></i>';
                $roundLikeState --;
                }
              else {echo '<i class="fa fa-star-o"></i>';}

            }
        echo'
            </div>
          </div>
        </div>
        <div class="add-to-cart">
          <a href="'.$p_page.'"><button class="add-to-cart-btn">Ürünü İncele</button></a>
        </div>
      </div>
    </div>
    ';
  }

?>
