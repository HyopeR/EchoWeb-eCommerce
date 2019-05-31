<?php
if(isset($_SESSION["menuTab"]) == 0){
  $_SESSION["menuTab"] = "One";
}
 ?>

<div id="topMenu">
  <ul class="topMenu-items">
    <a><li><i class="fa fa-user"></i><?php echo $_SESSION["seller_name"]; ?></li></a>
  </ul>
  <div id="topMenuRight">
    <ul class="topMenuRight-items">
      <a href="http://localhost/admin"><li><i class="fa fa-home"></i></li></a>
      <a href="http://localhost/controlPages/controlLogout.php"><li><i class="fa fa fa-sign-out"></i></li></a>
      <a href="http://localhost/"><li><i class="fa fa-chevron-right"></i></li></a>
    </ul>
  </div>

</div>

<input type="text" class="hiddenInput" value="One">
<div class="container" id="container-full">
    <div class="row">
        <div class="col-sm-2 col-md-2">
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading" id="panel-heading">
                        <h4 class="panel-title" value="One" onclick="selectMenu(this)">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="fa fa-folder">
                            </span>Güncel Takip</a>
                        </h4>
                    </div>
                    <div id="collapseOne" <?php if($_SESSION["menuTab"] == "One") { echo 'class="panel-collapse collapse in"';} else {echo 'class="panel-collapse collapse"';} ?> >
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="fa fa-arrow-right"></span><a href="http://localhost/templatePages/adminPages/followDay.php">Günlük Takip</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" id="panel-heading">
                        <h4 class="panel-title" value="Two" onclick="selectMenu(this)">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class="fa fa-th">
                            </span>Ürünler</a>
                        </h4>
                    </div>
                    <div id="collapseTwo" <?php if($_SESSION["menuTab"] == "Two") { echo 'class="panel-collapse collapse in"';} else {echo 'class="panel-collapse collapse"';} ?>>
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="fa fa-eye"></span><a href="http://localhost/templatePages/adminPages/seeProducts.php">Ürünlerimi Gör</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="fa fa-plus"></span><a href="http://localhost/templatePages/adminPages/addProduct.php">Ürün Ekleme </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="fa fa-archive"></span><a href="http://localhost/templatePages/adminPages/productsStock.php">Ürün Stokları</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" id="panel-heading">
                        <h4 class="panel-title" value="Three" onclick="selectMenu(this)">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><span class="fa fa-shopping-basket">
                            </span>Sipariş Takibi</a>
                        </h4>
                    </div>
                    <div id="collapseThree" <?php if($_SESSION["menuTab"] == "Three") { echo 'class="panel-collapse collapse in"';} else {echo 'class="panel-collapse collapse"';} ?>>
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="fa fa-sort"></span><a href="http://localhost/templatePages/adminPages/seeOrders.php">Siparişleri Gör</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" id="panel-heading">
                        <h4 class="panel-title" value="Four" onclick="selectMenu(this)">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><span class="fa fa-file">
                            </span>Analizler</a>
                        </h4>
                    </div>
                    <div id="collapseFour" <?php if($_SESSION["menuTab"] == "Four") { echo 'class="panel-collapse collapse in"';} else {echo 'class="panel-collapse collapse"';} ?>>
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="fa fa-shopping-cart"></span><a href="http://localhost/templatePages/adminPages/analysisOrders.php">Sipariş Analizleri</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="fa fa-user"></span><a href="http://localhost/templatePages/adminPages/analysisCustomers.php">Müşteri Analizleri</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="fa fa-tasks"></span><a href="http://localhost/templatePages/adminPages/analysisProducts.php">Ürün Analizleri</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="fa fa-usd"></span><a href="http://localhost/templatePages/adminPages/analysisSales.php">Satış Analizleri</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-10 col-md-10">
            <div class="well" id="well-admin">
