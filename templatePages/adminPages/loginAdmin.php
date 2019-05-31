<?php require("adminSettingsTop.php"); ?>
  <div id="loginBackground">
    <div id="container-relative" class="container">
      <div class="row">
      <div id="loginForm">
        <div id="loginFormTitle">Mağaza Admin Girişi</div>

        <div id="loginFormContent">
        <div class="row">



          <form>
            <div class="col-md-4">
              <h5>Mağaza Eposta:</h5>
            </div>
            <div class="col-md-8">
              <input type="email" id="adminEmail" class="form-control" placeholder="Email">
            </div>

            <div class="col-md-4">
              <h5>Mağaza Şifre:</h5>
            </div>
            <div class="col-md-8">
              <input type="password" id="adminPass" class="form-control" placeholder="Password">
            </div>

            <div class="col-md-12">
              <input type"submit" value="Giriş Yap" id="adminLogin" class="btn btn-outline-success">
            </div>


          <form>
        </div>
      </div>

        </div>
      </div>
    </div>
  </div>
<?php require("adminSettingsBottom.php"); ?>
