<?php
if($_POST){

  session_start();
  require(".././controlPages/connection.php");

  $p_id = $_POST["p_id"];

  $productData = mysqli_query($connect_db, "SELECT *
  FROM products
  LEFT JOIN products_category
  ON products.pc_id = products_category.pc_id
  LEFT JOIN products_media
  ON products.p_id = products_media.p_id
  LEFT JOIN products_gender
  ON products.pg_id = products_gender.pg_id
  WHERE products.p_id = '".$p_id."' ");

  while($settingsData=mysqli_fetch_assoc($productData)){
    echo '
      <div class="row" id="settingsWrapper">
      <div class="col-md-12">
        <div class="col-md-3"><div class="settings-img"><img height="300px" src="../'.$settingsData["p_media"].'"></div></div>
        <div class="col-md-9">
          <div class="col-md-12">
            <div class="col-md-3"><p class="settings_h5">Ürün Medyası:</p></div>
            <div class="col-md-9"><input class="form-control" type="text" value="'.$settingsData["p_media"].'"></div>
          </div>

          <div class="col-md-12">
            <div class="col-md-3"><p class="settings_h5">Ürün Adı:</p></div>
            <div class="col-md-9"><input class="form-control" type="text" value="'.$settingsData["p_name"].'"></div>
          </div>

          <div class="col-md-12">
            <div class="col-md-3"><p class="settings_h5">Ürün Kategorisi:</p></div>
            <div class="col-md-9"><input class="form-control" type="text" value="'.$settingsData["pc_name"].'"></div>
          </div>

          <div class="col-md-12">
            <div class="col-md-3"><p class="settings_h5">Ürün Cinsiyet:</p></div>
            <div class="col-md-9"><input class="form-control" type="text" value="'.$settingsData["pg_name"].'"></div>
          </div>

          <div class="col-md-12">
            <div class="col-md-3"><p class="settings_h5">Ürün Fiyat:</p></div>
            <div class="col-md-9"><input class="form-control" type="text" value="'.$settingsData["p_price"].'"></div>
          </div>

          <div class="col-md-12">
            <div class="col-md-3"><input class="btn settings-button" type="button" value="Ürünü Güncelle"></div>
            <div class="col-md-3"><input class="btn settings-button" type="button" value="Ürünü Sil"></div>
            <div class="col-md-3"><input class="btn settings-button" type="button" value="Görünürlüğü Aç"></div>
            <div class="col-md-3"><input class="btn settings-button" type="button" value="Görünürlüğü Kapat"></div>
          </div>

        </div>
        </div>
      </div>
    ';
  }
}
?>
