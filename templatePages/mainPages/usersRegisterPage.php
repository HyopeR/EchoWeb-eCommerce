<?php session_start(); ?>
<?php require("mainDesignTop.php"); ?>
<?php include("../.././controlPages/breadCrumpTree.php"); ?>

  <div class="container">
    <div class="row">
      <div class="col-md-12">

        <div id="cart-all-view">
        <h4 class="userspage-title">Yeni Üye Formu<h4>
          <hr class="userspage-hr">

        <form id="userMainRegister" method="POST">
          <div class="settings_row">
            <div class="row">
              <div class="col-md-4">
                <h5 class="settings_h5">Adınız:</h5>
              </div>
              <div class="col-md-8">
                <input class="form-control" id="regName" name="regName" placeholder="Adınız" type="text" required>
              </div>
            </div>
          </div>

          <div class="settings_row">
            <div class="row">
              <div class="col-md-4">
                <h5 class="settings_h5">Soyadınız:</h5>
              </div>
              <div class="col-md-8">
                <input class="form-control" id="regSurname" name="regSurname" placeholder="Soyadınız" type="text" required>
              </div>
            </div>
          </div>

          <div class="settings_row">
            <div class="row">
              <div class="col-md-4">
                <h5 class="settings_h5">Şifreniz:</h5>
              </div>
              <div class="col-md-8">
                <input class="form-control" id="regPassword" name="regPassword" placeholder="Şifreniz" type="password" required>
              </div>
            </div>
          </div>

          <div class="settings_row">
            <div class="row">
              <div class="col-md-4">
                <h5 class="settings_h5">Doğum Tarihiniz:</h5>
              </div>

              <div class="col-md-2">
                <select id="regDay" name="regDay" class="form-control" required>
                  <option value="" disabled="disabled" selected="selected">Gün</option>
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
                <select id="regMonth" name="regMonth" class="form-control" required>
                  <option value="" disabled="disabled" selected="selected">Ay</option>
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

                <select id="regYear" name="regYear" class="form-control" required>
                  <option value="" disabled="disabled" selected="selected">Yıl</option>
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
                  <select class="form-control" id="regGender" name="regGender" required>
                    <option value="" disabled="disabled" selected="selected">Cinsiyet</option>
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
                <div class="col-md-2">
                  <select class="form-control" id="regCity" name="regCity" required>
                    <option value="" disabled="disabled" selected="selected">İl</option>
                    <?php
                      $countryList = mysqli_query($connect_db, "SELECT uc_id, uc_name FROM users_country");

                      while($row = mysqli_fetch_assoc($countryList)) {
                        echo '
                          <option value="'.$row["uc_id"].'">'.$row["uc_name"].'</option>
                        ';
                      }
                     ?>
                  </select>
                </div>
                <div class="col-md-2">
                  <input class="form-control" id="regChildCity" name="regChildCity" placeholder="İlçe" type="text" required>
                </div>
                <div class="col-md-4">
                  <textarea class="form-control" id="regAddress" name="regAddress" placeholder="Ev Adresi" required></textarea>
                </div>
              </div>
            </div>

            <div class="settings_row">
              <div class="row">
                <div class="col-md-4">
                  <h5 class="settings_h5">Cep Telefonunuz:</h5>
                </div>
                <div class="col-md-8">
                  <input class="form-control" id="regNumber" name="regNumber" placeholder="Cep Telefonunuz" type="text" required>
                </div>
              </div>
            </div>

            <div class="settings_row">
              <div class="row">
                <div class="col-md-4">
                  <h5 class="settings_h5">E-Posta Adresiniz:</h5>
                </div>
                <div class="col-md-8">
                  <input class="form-control" id="regEmail" name="regEmail" placeholder="E-Posta Adresiniz" type="email" required>
                </div>
              </div>
            </div>

            <br>
          <div class="settings_submit">
            <div class="row">
              <input type="button" id="userRegister" name="userRegister" class="btn btn-outline-success my-2 my-sm-0" value="Üye Ol">
            </div>
          </div>
          </form>
        </div>

        </div>
      </div>
    </div>

  <?php require("mainDesignBottom.php"); ?>
