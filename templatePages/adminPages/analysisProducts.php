<?php require("adminSettingsTop.php"); ?>
<?php require("adminDesignTop.php"); ?>
<?php require("../.././controlPages/connection.php"); ?>
<h3>Analizler ► Ürün Analizleri</h3>
  <hr class="userspage-hr">
<div class="row">
  <div class="col-md-12">
    <div class="big-chart" id="chart_bar_cat"></div>
  </div>
  <div class="col-md-12">
    <div class="big-chart" id="chart_bar_cat_price"></div>
  </div>
  <div class="col-md-12">
    <div class="big-chart" id="chart_bar_like"></div>
  </div>
  <div class="col-md-12">
    <div class="big-chart" id="chart_bar_comment"></div>
  </div>
  <div class="col-md-12">
    <div class="big-chart" id="chart_bar_view"></div>
  </div>
</div>

<?php require("adminSettingsBottom.php"); ?>
<?php require("adminDesignBottom.php"); ?>
<?php include("dataProducts.php"); ?>
