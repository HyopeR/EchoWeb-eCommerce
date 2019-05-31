<?php

  if($_POST) {

    session_start();
    require(".././controlPages/connection.php");

    $gender = $_POST["selectGender"];
    $category = $_POST["selectCat"];

    $detailPro = mysqli_query($connect_db, "SELECT products.p_id, products.p_name
    FROM products
    LEFT JOIN seller
    ON products.s_id = seller.s_id
    LEFT JOIN products_gender
    ON products.pg_id = products_gender.pg_id
    LEFT JOIN products_category
    ON products.pc_id = products_category.pc_id
    WHERE products_gender.pg_id = '".$gender."'
    AND products_category.pc_id = '".$category."'
    AND seller.s_email = '".$_SESSION["seller_email"]."' ");

    echo '<option value="" disabled="disabled" selected="selected">Ürün Seçiniz</option>';
    while($pro = mysqli_fetch_assoc($detailPro)) {
      echo '
        <option value="'.$pro["p_id"].'">'.$pro["p_name"].'</option>
      ';
    }

  }
 ?>
