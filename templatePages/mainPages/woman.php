<?php
session_start();
require("../.././controlPages/connection.php");
$_SESSION["pg_name"] = "Kadın";
?>

<?php require("mainDesignTop.php"); ?>
<?php include("../.././controlPages/breadCrumpTree.php"); ?>

<div class="section">
  <div class="container">
    <div class="row">
      <div id="aside" class="col-md-3">
        <div class="aside">
          <h3 class="aside-title">Kategoriler</h3>
          <div class="checkbox-filter" id="checkbox-category">
						<?php include("../.././controlPages/controlGenderCategory.php"); ?>
          </div>
					<div class="checkbox-filter" id="dropdown-category">
						<div class="dropdown">
						  <button class="btn btn-secondary dropdown-toggle" type="button" id="genderCatButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    Kategori Seç
						  </button>
						  <div class="dropdown-menu" id="genderCatMenu" aria-labelledby="dropdownMenuButton">
									<?php include("../.././controlPages/controlGenderCategory.php"); ?>
						  </div>
						</div>
					</div>
        </div>
				<form id="hiddenCurrent" method="POST">
					<input class="hiddenInput" name="selector" id="selector" type="text" value="1">
				</form>
        <form id="hiddenCurrentGender" method="POST">
					<input class="hiddenInput" name="selectorGender" id="selectorGender" type="text" value="<?php echo $_SESSION["pg_name"]; ?>">
				</form>
      </div>

      <div id="store" class="col-md-9">
        <div class="row">
					<div id="store_main_view"></div>
      </div>
    </div>
  </div>
</div>
</div>

<?php
require("mainDesignBottom.php");
echo ' <script src="'.SCRIPT_ROOT.'settingsPages/js/storeAction.js"></script> ';
?>
