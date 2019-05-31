<?php session_start(); ?>
<?php require("mainDesignTop.php"); ?>
<?php include("../.././controlPages/breadCrumpTree.php"); ?>
<?php include("sellerPageTop.php") ?>

<?php
if(isset($_SESSION["seller_email"])) {

  require("../.././controlPages/connection.php");
  $dbControl = mysqli_query($connect_db, "SELECT * FROM seller WHERE s_email = '".$_SESSION["seller_email"]."' ");
  $dbValue = mysqli_fetch_row($dbControl);

  $sellerKey = $dbValue[1];
  $sellerName = $dbValue[2];
  $sellerPassword = $dbValue[3];
  $sellerEmail = $dbValue[4];

}
 ?>

<h4 class="userspage-title">Mağaza ► Hesap İşlemleri<h4>
  <hr class="userspage-hr">

  <div class="update-profile-detail">
    <p><?php if(isset($_SESSION["update_profile_detail"])) { echo $_SESSION["update_profile_detail"];} unset($_SESSION['update_profile_detail']);?></p>
  </div>

  <form id="userMainUpdate" method="POST" action="">
    <div class="settings_row">
      <div class="row">
        <div class="col-md-4">
          <h5 class="settings_h5">Mağaza Adı:</h5>
        </div>
        <div class="col-md-8">
          <input class="form-control" id="updateName" name="updateName" placeholder="Adınız" type="text" value="<?php echo $sellerName; ?>" readonly>
        </div>
      </div>
    </div>

    <div class="settings_row">
      <div class="row">
        <div class="col-md-4">
          <h5 class="settings_h5">Mağaza Anahtarı:</h5>
        </div>
        <div class="col-md-8">
          <input class="form-control" id="updateSurname" name="updateSurname" placeholder="Soyadınız" type="text" value="<?php echo $sellerKey; ?>" readonly>
        </div>
      </div>
    </div>

    <div class="settings_row">
      <div class="row">
        <div class="col-md-4">
          <h5 class="settings_h5">Mağaza Email:</h5>
        </div>
        <div class="col-md-8">
          <input class="form-control" id="updatePassword" name="updatePassword" placeholder="Şifreniz" type="email" value="<?php echo $sellerEmail; ?>">
        </div>
      </div>
    </div>

    <div class="settings_row">
      <div class="row">
        <div class="col-md-4">
          <h5 class="settings_h5">Mağaza Password:</h5>
        </div>
        <div class="col-md-8">
          <input class="form-control" id="updatePassword" name="updatePassword" placeholder="Şifreniz" type="password" value="<?php echo $sellerPassword; ?>">
        </div>
      </div>
    </div>

    <br>
  <div class="settings_submit">
    <div class="row">
      <input type="submit" id="updateProfile" class="btn btn-outline-success my-2 my-sm-0" value="Bilgilerimi Güncelle">
    </div>
  </div>
  </form>

<?php include("sellerPageBottom.php") ?>
<?php require("mainDesignBottom.php"); ?>
