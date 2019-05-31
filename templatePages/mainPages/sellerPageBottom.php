</div>
</div>

<div class="col-sm-4">
<div id="cart-all-order">

  <div id="cart-order-view">
    <div id="cart-order-view-header"><h4>Hesap İşlemleri</h4></div>
    <hr>

    <div class="row">
      <div class="col-sm-12">
        <h5>
          <ul id="profile-menu">
            <a href="<?php echo "http://localhost/seller/".$_SESSION["seller_key"]; ?>"><li>Mağazam</li></a>
            <a href="http://localhost/templatePages/mainPages/sellerpages.php"><li>Hesap İşlemleri</li></a>
            <a href="http://localhost/admin"><li>Yönetici Paneli</li></a>
          </ul>
        </h5>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <form id="logout" method="POST" action="http://localhost/controlpages/controlLogout.php">
          <input id="addOrder" class="btn btn-outline-success my-2 my-sm-0" type="submit" value="Çıkış Yap">
        </form>
      </div>
    </div>

  </div>
</div>
</div>

</div>
</div>
