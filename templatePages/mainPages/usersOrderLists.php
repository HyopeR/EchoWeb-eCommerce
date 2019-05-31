<?php session_start(); ?>
<?php require("mainDesignTop.php"); ?>
<?php include("../.././controlPages/breadCrumpTree.php"); ?>
<?php include("usersPageTop.php") ?>

<?php
if(isset($_SESSION["user_email"])) {

  require("../.././controlPages/connection.php");

  $dbOrderList = mysqli_query($connect_db,
  "SELECT o_id, o_time
  FROM orders
  LEFT JOIN users
  ON orders.u_id = users.u_id
  WHERE users.u_email = '".$_SESSION["user_email"]."'
  ORDER BY o_time DESC
  ");
}
 ?>

<h4 class="userspage-title">Kullanıcı ► Siparişlerim<h4>
  <hr class="userspage-hr">

<div class="update-profile-detail">
  <p><?php if(isset($_SESSION["send_order_detail"])) { echo $_SESSION["send_order_detail"];} unset($_SESSION['send_order_detail']);?></p>
</div>

<input id="saveClick" class="hiddenInput" type="text" value="null">
<?php
  while($row=mysqli_fetch_assoc($dbOrderList)) {
    echo '
    <form id="orderListForm-'.$row["o_id"].'" method="POST">
      <div class="orderListButton">
        <span onclick = "viewOrder(this);" id="listButton" class="btn btn-outline-success my-2 my-sm-0" type="button" value="'.$row["o_id"].'">
          Sipariş No: '.$row["o_id"].' ▼
        </span>
      </div>
    </form>
      <div id="orderContent-'.$row["o_id"].'" class="orderContent"></div>
    ';
  }
 ?>

<?php include("usersPageBottom.php") ?>
<?php require("mainDesignBottom.php"); ?>
