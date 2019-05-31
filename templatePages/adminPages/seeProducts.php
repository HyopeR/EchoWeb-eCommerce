<?php require("adminSettingsTop.php"); ?>
<?php require("adminDesignTop.php"); ?>
<?php require("../.././controlPages/connection.php"); ?>
<h3>Ürünler ► Ürünlerimi Gör</h3>
  <hr class="userspage-hr">

<input class="hiddenInput" id="hiddenTabId" type="text" value="1">
<div class="row">
    <?php
      $allProducts = mysqli_query($connect_db, "SELECT *
      FROM products
      LEFT JOIN seller
      ON products.s_id = seller.s_id
      LEFT JOIN products_media
      ON products.p_id = products_media.p_id
      WHERE seller.s_email = '".$_SESSION["seller_email"]."'");

      $tabId = 1;
      $line = 1;
      $valueLoop = 0;
      $controlLoop = 0;
      $styleConfig = 'style="display: block"';
      while ($row = mysqli_fetch_assoc($allProducts)) {
        $likeQuery = mysqli_query($connect_db, "SELECT round(avg(products_like.like_state),1) as avg_like
        FROM products
        LEFT JOIN products_like
        ON products.p_id = products_like.p_id
        WHERE products.p_id = '".$row["p_id"]."'
        GROUP BY products.p_id");
        $likeRow = mysqli_fetch_row($likeQuery);
        $roundLikeState = round($likeRow[0]);
        $face = "vote-".$roundLikeState.".png";

        $commentQuery = mysqli_query($connect_db, "SELECT COUNT(products_comment.p_id) as sum_comment
        FROM products
        LEFT JOIN products_comment
        ON products.p_id = products_comment.p_id
        WHERE products_comment.p_id = '".$row["p_id"]."'
        GROUP BY products.p_id");
        $commentRow = mysqli_fetch_row($commentQuery);

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
        <div class="col-md-6">
        <div id="cart-view-'.$valueLoop.'" class="admin-cart-view">

          <div class="row">
            <div class="cart_form_div">
              <form id="cart-form-'.$valueLoop.'" name="cart_form" class="cart_form" method="POST">
                <input class="hiddenInput" name="product_id" id="product-'.$row["p_id"].'" value="'.$row["p_id"].'" readonly>
                <span class="delete" type="button" value="'.$row["p_id"].'" onclick = "settingsProducts(this);"><i class="fa fa-cog"></i></span>
              </form>
            </div>

            <div class="col-md-2">
              <div class="admin-cart-view-img"><img height="100px" src="'.SCRIPT_ROOT.''.$row["p_media"].'" alt=""></div>
            </div>

            <div class="col-md-10">
              <div>
                <h3 class="cart-product-name"><a href="#">'.$row["p_name"].'</a></h3>
              </div>

              <div><img class="likeFace" width="30px" height="30px" src="'.SCRIPT_ROOT.'settingsPages/img/'.$face.'"><span class="badge">'.$commentRow[0].'</span></div>
            </div>
          </div>

          </div>
        </div>
        ';

        if($controlLoop == 9){
          echo '
          </div>
          ';
        }
        $valueLoop ++;
        $controlLoop++;
      }

      if($controlLoop < 9){
        echo '</div>';
      }

      echo '
        <div class="col-md-12" id="selectPage">
      ';
      $loopNumber = 1;
      while($line > 0) {
        echo '
          <span type="button"class="selectPageItem" onclick="newSeePage(this);" value = "'.$loopNumber.'">'.$loopNumber.'</span>
          ';
        $line --;
        $loopNumber++;
      }
      echo '
        </div>
      ';
     ?>
  </div>
</div>

<div id="myModal" class="modal">

  <div class="modal-content">
    <div class="modal-body">
      <span class="close">&times;</span>
      <div class="model-detail">Some text in the Modal Body</p>
    </div>
  </div>

</div>

<?php require("adminSettingsBottom.php"); ?>
<?php require("adminDesignBottom.php"); ?>

<script>
let modal = document.getElementById("myModal");
let span = document.getElementsByClassName("close")[0];

function settingsProducts(elem){
  let valueSelect = $(elem).attr('value');
  let selectSettings = "product-"+valueSelect;
  let btn = document.getElementById(selectSettings);
  let modalContent = document.getElementsByClassName("model-detail")[0];

  $.ajax({
    type: "POST",
    url: "http://localhost/controlPagesAdmin/productsSettings.php",
    data: {p_id: valueSelect},
  }).done(function( productDetail ) {
    modalContent.innerHTML = productDetail;
  })
  modal.style.display = "block";
}

span.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

function newSeePage(elem){
	let valueSelect = $(elem).attr('value');

  let hiddenTabInput = document.getElementById("hiddenTabId");
  let tabDeselect = "view-tab-"+hiddenTabInput.value;
  let oldTab = document.getElementById(tabDeselect);
  oldTab.setAttribute("style", "display:none");

  let tabSelect = "view-tab-"+valueSelect;
  let newTab = document.getElementById(tabSelect);
  newTab.setAttribute("style", "display:block");
  hiddenTabInput.value = valueSelect;
}
</script>
