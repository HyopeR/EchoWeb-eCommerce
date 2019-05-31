<?php
$connect_db = mysqli_connect("localhost","root","","1_web_commerce");
$connect_db->query("SET NAMES 'utf8'");
 ?>
<!DOCTYPE html>
<html lang="tr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>EchoWeb - Giyim</title>

		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
		<?php
		define( 'SCRIPT_ROOT', 'http://localhost/' );

		echo '
		<link type="text/css" rel="stylesheet" href="'.SCRIPT_ROOT.'settingsPages/css/bootstrap.min.css"/>

		<link type="text/css" rel="stylesheet" href="'.SCRIPT_ROOT.'settingsPages/css/slick.css"/>

		<link type="text/css" rel="stylesheet" href="'.SCRIPT_ROOT.'settingsPages/css/slick-theme.css"/>

		<link type="text/css" rel="stylesheet" href="'.SCRIPT_ROOT.'settingsPages/css/nouislider.min.css"/>

		<link rel="stylesheet" href="'.SCRIPT_ROOT.'settingsPages/css/font-awesome.min.css">

		<link type="text/css" rel="stylesheet" href="'.SCRIPT_ROOT.'settingsPages/css/style.css"/>

		<link rel="shortcut icon" type="image/png" href="'.SCRIPT_ROOT.'settingsPages/img/favicon.png"/>
		';
		 ?>


    </head>
	<body>
		<header>
			<div id="top-header">
				<div class="container">
					<div id="top-area-content">
            <?php
            $sessionControlUser = isset($_SESSION['user_email']);
            $sessionControlSeller = isset($_SESSION['seller_email']);
            if ($sessionControlUser == 0 && $sessionControlSeller == 0) {
              echo '
              <ul class="header-links pull-left"></ul>
              ';
            } else if ($sessionControlUser == 1) {
              echo '
              <ul class="header-links pull-left">
                <li><a href="#"><i class="fa fa-envelope-o"></i>
              '.$_SESSION['user_email'].'</a></li>
              </ul>
              ';
            } else if ($sessionControlSeller == 1) {
              echo '
              <ul class="header-links pull-left">
                <li><a href="#"><i class="fa fa-envelope-o"></i>
              '.$_SESSION['seller_email'].'</a></li>
              </ul>
              ';
            }
            ?>
					<?php
						if (((int)$sessionControlUser) == 0 && ((int)$sessionControlSeller) == 0) {
							echo '
							<ul class="header-links pull-right">
								<li>
										<div class="dropdown">
											<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
												<i class="fa fa-shopping-cart"></i>
												<span>Mağaza Girişi</span>
											</a>
											<div class="cart-dropdown">
												<div class="cart-list2">
													<div class="cart-summary-top">
														Mağaza Girişi
													</div>
													<div class="product-widget">
													<form id="main-seller-login" class="form-inline my-2 my-lg-0" method="POST">
														<input id="seller_email" class="form-control mr-sm-2" name="seller_email" type="email" placeholder="Email" aria-label="Email">
														<input id="seller_password" class="form-control mr-sm-2" name="seller_password" type="password" placeholder="Password" aria-label="password">
													</div>
												</div>
												<div class="cart-summary">
												</div>
												<div class="cart-btns">
													<a type="button" value="Giriş Yap" id="logSellerRequest">Giriş Yap</a>
													</form>
												</div>
											</div>
										</div>
								</li>
								<li>
									<div class="dropdown" id="user_login">
										<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
											<i class="fa fa-user"></i>
											<span>Kullanıcı Girişi</span>
										</a>
										<div class="cart-dropdown">
											<div class="cart-list2">
												<div class="cart-summary-top">
													Kullanıcı Girişi
												</div>
												<div class="product-widget">
												<form id="main-user-login" class="form-inline my-2 my-lg-0" method="POST">
													<input id="user_email" class="form-control mr-sm-2" name="user_email" type="email" placeholder="Email" aria-label="Email">
													<input id="user_password" class="form-control mr-sm-2" name="user_password" type="password" placeholder="Password" aria-label="password">
												</div>
											</div>
											<div class="cart-summary">
											</div>
											<div class="cart-btns">
												<a type="button" value="Giriş Yap" id="logUserRequest">Giriş Yap</a>
												</form>
											</div>
										</div>
									</div>
								</li>
							</ul>
							';
						} else {
							echo '
							<ul class="header-links pull-right">
							</ul>
							';
						}
					?>
				</div>
			</div>
			</div>

			<div id="header">
				<div class="container">
					<div class="row">
						<div class="col-md-3">
							<div class="header-logo">
								<a href="http://localhost/" class="logo">
									<?php echo '<img src="'.SCRIPT_ROOT.'settingsPages/img/logo.png" alt="">' ?>
								</a>
							</div>
						</div>

						<div class="col-md-6">
							<div class="header-search">
								<form id="searchForm" method="POST" action="http://localhost/templatePages/mainPages/searchProduct.php">
									<select class="input-select" id="searchCat" name="searchCat">
										<option value="0">Kategoriler</option>
										<?php
											$dbControl = mysqli_query($connect_db, "SELECT * FROM products_category");

											while($itemCat=mysqli_fetch_assoc($dbControl)) {
												echo '
													<option value="'.$itemCat["pc_id"].'">'.$itemCat["pc_name"].'</option>
												';
											}
										 ?>
									</select>
									<input id="searchInput" name="searchInput" class="input" placeholder="Aranacak kelimeyi giriniz.">
									<button id="searchButton" type="button" class="search-btn">Arama</button>
								</form>
							</div>
						</div>

						<div class="col-md-3 clearfix">
							<div class="header-ctn">

								<div class="dropdown" id="cart-drop">
									<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										<i class="fa fa-shopping-cart"></i>
										<span>Sepet</span>
										<?php
											if(isset($_SESSION['cart_id'])) {

												$cart_id = $_SESSION['cart_id'];
												$dbControl=mysqli_query($connect_db, "SELECT count(p_id) FROM products_shop_cart WHERE sc_id = '".$cart_id."' ");
												$dbValue = mysqli_fetch_row($dbControl);
												$selectObject = $dbValue[0];

												echo '<div id="qty-value" class="qty">'.$selectObject.'</div>';
											} else {

												echo '<div id="qty-value" class="qty">0</div>';
											}


										?>
									</a>
									<div class="cart-dropdown">
										<div class="cart-list">

											<?php
												if(isset($_SESSION['cart_id'])) {

													$cart_id = $_SESSION['cart_id'];
													$dbControl=mysqli_query($connect_db, "SELECT p_name, p_media, pc_name, sc_piece, sc_total, products.p_id as p_id, products_shop_cart.b_id as b_id, b_name
																																FROM shop_cart
																																LEFT JOIN products_shop_cart
																																ON shop_cart.sc_id = products_shop_cart.sc_id
																																LEFT JOIN products
																																ON products_shop_cart.p_id = products.p_id
																																LEFT JOIN products_media
																																ON products.p_id = products_media.p_id
																																LEFT JOIN products_category
																																ON products.pc_id = products_category.pc_id
																																LEFT JOIN products_body
																																ON products.p_id = products_body.p_id
																																AND products_shop_cart.b_id = products_body.b_id
																																LEFT JOIN body
																																ON products_body.b_id = body.b_id
																																WHERE products_shop_cart.sc_id = '".$cart_id."' ");
													$valueLoop = 0;
													$valueTotal = 0;
													while($row=mysqli_fetch_assoc($dbControl)) {

														$valueLoop ++;
														$valueTotal = $valueTotal + $row["sc_total"];
														echo '
														<div id="product-widget-'.$valueLoop.'" class="product-widget">
															<div class="product-img">
																<img src="'.SCRIPT_ROOT.''.$row["p_media"].'" alt="">
															</div>
															<div class="product-body">
																<h3 class="product-name"><a href="#">'.$row["p_name"].'</a></h3>
																<h4 id="product-price" class="product-price"><span class="qty">'.$row["sc_piece"].'x</span><span id="item-price-'.$valueLoop.'">'.$row["sc_total"].'</span></h4>
																<span>Beden: '.$row["b_name"].'</span>
															</div>
															<form id="pw-form-'.$valueLoop.'" name="pw_form" method="POST">
																<input class="hiddenInput" name="cart_id" id="cart_id_'.$valueLoop.'" value="'.$cart_id.'" readonly>
																<input class="hiddenInput" name="product_id" id="product_id_'.$valueLoop.'" value="'.$row["p_id"].'" readonly>
																<input class="hiddenInput" name="body_id" id="body_id_'.$valueLoop.'" value="'.$row["b_id"].'" readonly>
																<span class="delete" type="button" value="'.$valueLoop.'" onclick = "itemDelete(this);"><i class="fa fa-close"></i></span>
															</form>
														</div>
														';
													}
												}
											 ?>

										</div>
										<?php
											if(isset($_SESSION['cart_id'])) {
												echo '
												<div class="cart-summary">
													<small><span id="cart_value">'.$selectObject.'</span>  adet ürün seçildi</small>
													<h5>Toplam Fiyat: <span id="cart_total">'.$valueTotal.'</span></h5>
												</div>
												';
											} else {
												echo '
												<div class="product-widget">
													<p>Sepetiniz boş.</p></br>
												</div>
												<div class="cart-summary">
													<small><span id="cart_value">0</span>  adet ürün seçildi</small>
													<h5>Toplam Fiyat: <span id="cart_total">0</span></h5>
												</div>
												';
											}
										?>
										<div class="cart-btns">
											<a href="http://localhost/templatePages/mainPages/shoppingcartview.php">Sepeti Görüntüle  <i class="fa fa-arrow-circle-right"></i></a>
										</div>
									</div>
								</div>
								<?php
								$sessionControlUser = isset($_SESSION['user_email']);
								$sessionControlSeller = isset($_SESSION['seller_email']);

								if (((int)$sessionControlUser) == 0 && ((int)$sessionControlSeller) == 0) {
									echo '
									<div>
										<a href="http://localhost/templatePages/mainPages/usersRegisterpage.php">
										<i class="fa fa-book"></i>
										<span>Üye Ol</span>
										</a>
									</div>
									';
								} else if (((int)$sessionControlUser) == 1 ) {

										echo '
											<div class="dropdown">
												<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
													<i class="fa fa-user-o"></i>
													<span>'.$_SESSION['user_name'].'</span>
												</a>
												<div class="cart-dropdown">
													<div class="cart-list2">
														<div class="product-widget" id="product-widget-menu">
															<ul>
															<a href="http://localhost/templatePages/mainPages/userspages.php"><li>Profilim / Ayarlar</li></a>
															<a href="http://localhost/templatePages/mainPages/usersorderLists.php"><li>Siparişlerim</li></a>
															</ul>
														</div>
													</div>
													<div class="cart-summary">
													</div>
														<form id="main-logout" method = "POST">
														<div class="cart-btns">
														<a href="http://localhost/controlpages/controlLogout.php" type="button" value="logOut" id="unlogRequest">Çıkış Yap  <i class="fa fa-arrow-circle-right"></i></a>
													</div>
													</form>
												</div>
											</div> ';
									} else if (((int)$sessionControlSeller) == 1) {
										$store_link = "http://localhost/seller/".$_SESSION['seller_key'];
										echo '
											<div class="dropdown">
												<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
													<i class="fa fa-building-o "></i>
													<span>'.$_SESSION['seller_name'].'</span>
												</a>
												<div class="cart-dropdown">
													<div class="cart-list2">
														<div class="product-widget" id="product-widget-menu">
															<ul>
															<a href="'.$store_link.'"><li>Mağazam</li></a>
															<a href="http://localhost/templatePages/mainPages/sellerpages.php"><li>Hesap İşlemleri</li></a>
															<a href="http://localhost/admin"><li>Yönetici Paneli</li></a>
															</ul>
														</div>
													</div>
													<div class="cart-summary">
													</div>
														<form id="main-logout" method = "POST">
														<div class="cart-btns">
														<a href="http://localhost/controlpages/controlLogout.php" type="button" value="logOut" id="unlogRequest">Çıkış Yap  <i class="fa fa-arrow-circle-right"></i></a>
													</div>
													</form>
												</div>
											</div> ';
									}
								?>

								<div class="menu-toggle">
									<a href="#">
										<i class="fa fa-bars"></i>
										<span>Menu</span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>

		<nav id="navigation">
			<div class="container">
				<div id="responsive-nav">
					<ul class="main-nav nav navbar-nav">
						<li class="active"><a href="http://localhost/">Ana Sayfa</a></li>
						<li><a href="http://localhost/templatepages/mainpages/woman.php">Kadın</a></li>
						<li><a href="http://localhost/templatepages/mainpages/man.php">Erkek</a></li>
					</ul>
				</div>
			</div>
		</nav>
