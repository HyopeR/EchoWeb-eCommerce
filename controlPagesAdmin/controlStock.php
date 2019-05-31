<?php

  if($_POST) {

    session_start();
    require(".././controlPages/connection.php");

    $selectPro = $_POST["selectPro"];

    $detailStock = mysqli_query($connect_db, "SELECT b_name, p_stock FROM products
      LEFT JOIN products_body
      ON products.p_id = products_body.p_id
      LEFT JOIN body
      ON products_body.b_id = body.b_id
      WHERE products.p_id = '".$selectPro."' ");

    $mediaPro = mysqli_query($connect_db, "SELECT p_media FROM products
    LEFT JOIN products_media
    ON products.p_id = products_media.p_id
    WHERE products.p_id = '".$selectPro."' ");
    $mediaRow = mysqli_fetch_row($mediaPro);

      echo $mediaRow[0].",";
    while($stock = mysqli_fetch_assoc($detailStock)) {
      echo $stock["b_name"].",".$stock["p_stock"].",";
    }

  }
?>
