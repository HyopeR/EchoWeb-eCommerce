<?php
require("connection.php");
session_start();

if($_POST) {
  $comment_name = $_POST["comment_name"];
  $comment_email = $_POST["comment_email"];
  $comment_content = $_POST["comment_content"];
  $comment_product_id = $_POST["comment_product_id"];
  if($_POST["rating"]){
    $comment_rating = $_POST["rating"];
  }

  $dbControl = mysqli_query($connect_db, "SELECT p_page, s_name
                                          FROM products
                                          LEFT JOIN seller
                                          ON products.s_id = seller.s_id
                                          WHERE products.p_id = '".$comment_product_id."'");

  $dbValue = mysqli_fetch_row($dbControl);
  $product_page = $dbValue[0];
  $seller_name = $dbValue[1];

  $dbControl = mysqli_query($connect_db, "SELECT count(users.u_id)
                                          FROM users
                                          WHERE users.u_email = '".$comment_email."'");
  $dbValue = mysqli_fetch_row($dbControl);
  if ($dbValue[0] == 1) {

    $dbControl = mysqli_query($connect_db, "SELECT users.u_id
                                            FROM users
                                            WHERE users.u_email = '".$comment_email."'");
    $dbValue = mysqli_fetch_row($dbControl);
    $user_id = $dbValue[0];

    $dbControl = mysqli_query($connect_db, "SELECT count(products_like.u_id)
                                            FROM products_like
                                            WHERE products_like.p_id = '".$comment_product_id."'
                                            AND products_like.u_id = '".$user_id."'");
    $dbValue = mysqli_fetch_row($dbControl);
      if($dbValue[0] == 0) {

        $dbControl = mysqli_query($connect_db, "INSERT INTO products_like (u_id, p_id, like_state)
                                                VALUES('".$user_id."', '".$comment_product_id."', '".$comment_rating."')");

        $dbControl = mysqli_query($connect_db, "INSERT INTO products_comment (u_id, p_id, c_content)
                                                VALUES('".$user_id."', '".$comment_product_id."', '".$comment_content."')");

        $dbControl = mysqli_query($connect_db, "SELECT avg(products_like.like_state)
                                                FROM products_like
                                                WHERE products_like.p_id = '".$comment_product_id."' ");
        $dbValue = mysqli_fetch_row($dbControl);
        $roundLikeState = round($dbValue[0]);

        echo $roundLikeState;
      }

      else {

        $dbControl = mysqli_query($connect_db, "INSERT INTO products_comment (u_id, p_id, c_content)
                                                VALUES('".$user_id."', '".$comment_product_id."', '".$comment_content."')");

        $dbControl = mysqli_query($connect_db, "SELECT avg(products_like.like_state)
                                                FROM products_like
                                                WHERE products_like.p_id = '".$comment_product_id."' ");
        $dbValue = mysqli_fetch_row($dbControl);
        $roundLikeState = round($dbValue[0]);

        echo $roundLikeState;

      }

  } else {

    echo "Değerlendirme yapmak ve görüşlerinizi belirtmek için lütfen üye olun yada giriş yapın.";

  }
}
$goPath = "/seller/".$seller_name."/productpages/".$product_page.".php";
header("location: ../../.$goPath");
 ?>
