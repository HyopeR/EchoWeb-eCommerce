<?php session_start(); ?>
<?php require("mainDesignTop.php"); ?>
<?php include("../.././controlPages/breadCrumpTree.php"); ?>

<div class="container">
	<div class="row">
		<div class="col-md-12">

			<div id="cart-all-view">
			<h4 class="userspage-title">Yeni Mağaza Formu<h4>
				<hr class="userspage-hr">

							<form id="userSellerRegister" method="POST">

								<div class="settings_row">
									<div class="row">
										<div class="col-md-4">
											<h5 class="settings_h5">Mağaza Adı:</h5>
										</div>
										<div class="col-md-8">
											<input class="form-control" name="reg_s_name" id="reg_s_name" placeholder="Store Name" type="text" required>
										</div>
									</div>
								</div>

								<div class="settings_row">
									<div class="row">
										<div class="col-md-4">
											<h5 class="settings_h5">Mağaza Anahtarı:</h5>
										</div>
										<div class="col-md-8">
											<input class="form-control" name="reg_s_key" id="reg_s_key" placeholder="Store Key" type="text" required>
										</div>
									</div>
								</div>

								<div class="settings_row">
									<div class="row">
										<div class="col-md-4">
											<h5 class="settings_h5">Mağaza Email:</h5>
										</div>
										<div class="col-md-8">
											<input class="form-control" name="reg_s_email" id="reg_s_email" placeholder="Store Email" type="email" required>
										</div>
									</div>
								</div>

								<div class="settings_row">
									<div class="row">
										<div class="col-md-4">
											<h5 class="settings_h5">Mağaza Şifresi:</h5>
										</div>
										<div class="col-md-8">
											<input class="form-control" name="reg_s_password" id="reg_s_password" placeholder="Store Password" type="password" required>
										</div>
									</div>
								</div>

              <button type="button" id="regSeller" class="btn btn-outline-success my-2 my-sm-0">Mağazanı Oluştur</button>

            </form>
          </div>

			</div>
		</div>
	</div>

<?php require("mainDesignBottom.php"); ?>
