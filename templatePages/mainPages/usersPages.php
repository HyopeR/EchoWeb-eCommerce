<?php session_start(); ?>
<?php require("mainDesignTop.php"); ?>
<?php include("../.././controlPages/breadCrumpTree.php"); ?>
<?php include("usersPageTop.php") ?>

<?php
if(isset($_SESSION["user_email"])) {

  require("../.././controlPages/connection.php");
  $dbControl = mysqli_query($connect_db, "SELECT * FROM users WHERE u_email = '".$_SESSION["user_email"]."' ");
  $dbValue = mysqli_fetch_row($dbControl);

  $userGender = $dbValue[1];
  $userName = $dbValue[3];
  $userSurname = $dbValue[4];
  $userEmail = $dbValue[5];
  $userPassword = $dbValue[6];
  $userAddress = $dbValue[7];
  $userDate = $dbValue[8];
  $userNumber = $dbValue[9];

  $userDateExp = explode("-", $userDate);
}
 ?>

<h4 class="userspage-title">Kullanıcı ► Profilim / Ayarlar<h4>
  <hr class="userspage-hr">

  <div class="update-profile-detail">
    <p><?php if(isset($_SESSION["update_profile_detail"])) { echo $_SESSION["update_profile_detail"];} unset($_SESSION['update_profile_detail']);?></p>
  </div>

  <form id="userMainUpdate" method="POST" action="http://localhost/controlPages/controlUpdateUser.php">
    <div class="settings_row">
      <div class="row">
        <div class="col-md-4">
          <h5 class="settings_h5">Adınız:</h5>
        </div>
        <div class="col-md-8">
          <input class="form-control" id="updateName" name="updateName" placeholder="Adınız" type="text" value="<?php echo $userName; ?>">
        </div>
      </div>
    </div>

    <div class="settings_row">
      <div class="row">
        <div class="col-md-4">
          <h5 class="settings_h5">Soyadınız:</h5>
        </div>
        <div class="col-md-8">
          <input class="form-control" id="updateSurname" name="updateSurname" placeholder="Soyadınız" type="text" value="<?php echo $userSurname; ?>">
        </div>
      </div>
    </div>

    <div class="settings_row">
      <div class="row">
        <div class="col-md-4">
          <h5 class="settings_h5">Şifreniz:</h5>
        </div>
        <div class="col-md-8">
          <input class="form-control" id="updatePassword" name="updatePassword" placeholder="Şifreniz" type="password" value="<?php echo $userPassword; ?>">
        </div>
      </div>
    </div>

    <div class="settings_row">
      <div class="row">
        <div class="col-md-4">
          <h5 class="settings_h5">Doğum Tarihiniz:</h5>
        </div>

        <div class="col-md-2">
          <select id="updateDay" name="updateDay" class="form-control">
            <option value="<?php echo $userDateExp[2]; ?>" selected="selected"><?php echo $userDateExp[2]; ?></option>
            <?php
              $day = 1;

              while ($day <= 31) {
                echo '<option value="'.$day.'">'.$day.'</option>';
                $day ++;
              }
             ?>
          </select>
        </div>

        <div class="col-md-2">
          <select id="updateMonth" name="updateMonth" class="form-control" tabindex="2">
            <option value="<?php echo $userDateExp[1]; ?>" selected="selected"><?php echo $userDateExp[1]; ?></option>
            <option value="01">Ocak</option>
            <option value="02">Şubat</option>
            <option value="03">Mart</option>
            <option value="04">Nisan</option>
            <option value="05">Mayıs</option>
            <option value="06">Haziran</option>
            <option value="07">Temmuz</option>
            <option value="08">Ağustos</option>
            <option value="09">Eylül</option>
            <option value="10">Ekim</option>
            <option value="11">Kasım</option>
            <option value="12">Aralık</option>
          </select>
        </div>

        <div class="col-md-4">

          <select id="updateYear" name="updateYear" class="form-control">
            <option value="<?php echo $userDateExp[0]; ?>" selected="selected"><?php echo $userDateExp[0]; ?></option>
              <?php
                $year = 2005;
                while ($year >= 1940) {
                  echo '<option value="'.$year.'">'.$year.'</option>';
                  $year --;
                }
               ?>
          </select>
        </div>
      </div>
    </div>

      <div class="settings_row">
        <div class="row">
          <div class="col-md-4">
            <h5 class="settings_h5">Cinsiyetiniz:</h5>
          </div>
          <div class="col-md-8">
            <select class="form-control" id="updateGender" name="updateGender">
              <option value="" disabled="disabled">Cinsiyet</option>
              <?php
                for($i=0; $i < 2; $i++) {
                  if($userGender == 1) {
                    echo '
                    <option value="1" selected="selected">Kadın</option>
                    <option value="2">Erkek</option>
                    ';
                  } else {
                    echo '
                    <option value="1">Kadın</option>
                    <option value="2" selected="selected">Erkek</option>
                    ';
                  }
                }
               ?>
              <option value="1">Kadın</option>
              <option value="2">Erkek</option>
            </select>
          </div>
        </div>
      </div>

      <div class="settings_row">
        <div class="row">
          <div class="col-md-4">
            <h5 class="settings_h5">Adresiniz:</h5>
          </div>
          <div class="col-md-8">
            <textarea class="form-control" id="updateAddress" name="updateAddress" placeholder="Ev Adresi"><?php echo $userAddress; ?></textarea>
          </div>
        </div>
      </div>

      <div class="settings_row">
        <div class="row">
          <div class="col-md-4">
            <h5 class="settings_h5">Cep Telefonunuz:</h5>
          </div>
          <div class="col-md-8">
            <input class="form-control" id="updateNumber" name="updateNumber" placeholder="Cep Telefonunuz" type="text" value="<?php echo $userNumber; ?>">
          </div>
        </div>
      </div>

      <div class="settings_row">
        <div class="row">
          <div class="col-md-4">
            <h5 class="settings_h5">E-Posta Adresiniz:</h5>
          </div>
          <div class="col-md-8">
            <input class="form-control" id="updateEmail" name="updateEmail" placeholder="E-Posta Adresiniz" type="email" value="<?php echo $userEmail; ?>">
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

<?php include("usersPageBottom.php") ?>
<?php require("mainDesignBottom.php"); ?>
