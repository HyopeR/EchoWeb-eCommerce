<?php
if($_POST) {
  session_start();
	require(".././controlPages/connection.php");

  $seller_email = $_SESSION["seller_email"];
  $seller_key = $_SESSION["seller_key"];

  $p_name=$_POST["pro_name"];
	$p_content=$_POST["pro_content"];
  $p_page=$_POST["pro_page"];
  $pc_id=$_POST["pro_category"];
  $pg_name=$_POST["pro_gender"];
  $p_price=$_POST["pro_price"];
  $p_stock=$_POST["pro_stock"];
  $exp_stock = explode(",", $p_stock);
  if(isset($_FILES["pro_media"])) {
    if ($_FILES["pro_media"]["size"] != 0) {
      require("createProductMedia.php");
      $p_media = $target_file;
    }
  }

  $dbControl=mysqli_query($connect_db, "SELECT pg_id FROM products_gender WHERE pg_name = '".$pg_name."'");
  $dbValue = mysqli_fetch_row($dbControl);
  $pg_id = $dbValue[0];

  $dbControl=mysqli_query($connect_db, "SELECT count(s_email) FROM seller WHERE s_email = '".$seller_email."'");
  $dbValue = mysqli_fetch_row($dbControl);

  if ($dbValue[0] == 1) {

    $dbControl=mysqli_query($connect_db, "SELECT s_id FROM seller WHERE s_email = '".$seller_email."'");
    $dbValue = mysqli_fetch_row($dbControl);
    $seller_id = $dbValue[0];

    if (!file_exists(".././seller/".$seller_key."/productpages")) {
        mkdir(".././seller/".$seller_key."/productpages", 0777, true);
    }

    $newFileName = "../seller/".$seller_key."/productpages/".$p_page.".php";
    $newFileContent = '<?php require("../../.././templatePages/mainPages/productsViewPages.php"); ?>';


    if (file_put_contents($newFileName, $newFileContent) !== false) {
    } else {
    }

    $addProducts=mysqli_query($connect_db,
    "INSERT INTO products (s_id, p_name, p_content, p_page, pc_id, pg_id, p_price)
    VALUES('".$seller_id."', '".$p_name."', '".$p_content."', '".$p_page."', '".$pc_id."', '".$pg_id."', '".$p_price."')");

    $last_product_id = mysqli_insert_id($connect_db);
      $addProducts=mysqli_query($connect_db,"INSERT INTO products_media (p_id, p_media)
                                            VALUES('".$last_product_id."','".$p_media."')");


      $b_type_1 = 1;
      $b_type_2 = array(2,3,4,5,6);
      $b_type_3 = array(7,8,9,10,11,12,13,14,15,16);
      for($i = 0; $i < count($exp_stock); $i++){
        if(count($exp_stock) == 1){
          $addStocks=mysqli_query($connect_db,"INSERT INTO products_body (p_id, b_id, p_stock)
                                                VALUES('".$last_product_id."', '".$b_type_1."', '".$exp_stock[$i]."')");
        }else if(count($exp_stock) == 5){
          $addStocks=mysqli_query($connect_db,"INSERT INTO products_body (p_id, b_id, p_stock)
                                                VALUES('".$last_product_id."', '".$b_type_2[$i]."', '".$exp_stock[$i]."')");

        }else if(count($exp_stock) == 10){
          $addStocks=mysqli_query($connect_db,"INSERT INTO products_body (p_id, b_id, p_stock)
                                                VALUES('".$last_product_id."', '".$b_type_3[$i]."', '".$exp_stock[$i]."')");
        }
      }

      $_SESSION["add_detail"] = 'Ürününüz eklenmiştir. Ürüne göz atmak için <a href="http://localhost/seller/'.$seller_key.'/productpages/'.$p_page.'.php">tıklayınız.</a>';

  } else {
    echo "Böyle bir mağaza sahibi yoktur!";
  }
}


 ?>
