<?php

  if($_POST) {
    session_start();
    require(".././controlPages/connection.php");

    $gender = $_POST["selectGender"];

    $catPro = mysqli_query($connect_db, "SELECT products_category.pc_name, products_category.pc_id
    FROM products
    LEFT JOIN seller
    ON products.s_id = seller.s_id
    LEFT JOIN products_gender
    ON products.pg_id = products_gender.pg_id
    LEFT JOIN products_category
    ON products.pc_id = products_category.pc_id
    WHERE products_gender.pg_id = '".$gender."'
    AND seller.s_email = '".$_SESSION["seller_email"]."'
    GROUP BY products_category.pc_id");

    echo '<option value="" disabled="disabled" selected="selected">Kategori Seçiniz</option>';
    while($cat = mysqli_fetch_assoc($catPro)) {
      echo '
        <option value="'.$cat["pc_id"].'">'.$cat["pc_name"].'</option>
      ';
    }

  }
 ?>
