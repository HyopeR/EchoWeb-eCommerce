<?php
  $categorySum = mysqli_query($connect_db, "SELECT products_category.pc_name, sum(products_shop_cart.sc_piece) as sum_piece, sum(products_shop_cart.sc_total) as sum_total
  FROM products_shop_cart
  LEFT JOIN products
  ON products_shop_cart.p_id = products.p_id
  LEFT JOIN seller
  ON products.s_id = seller.s_id
  LEFT JOIN products_category
  ON products.pc_id = products_category.pc_id
  LEFT JOIN shop_cart
  ON products_shop_cart.sc_id = shop_cart.sc_id
  LEFT JOIN orders
  ON shop_cart.sc_id = orders.sc_id
  LEFT JOIN users
  ON orders.u_id = users.u_id
  LEFT JOIN users_gender
  ON users.g_id = users_gender.g_id
  LEFT JOIN users_country
  ON users.uc_id = users_country.uc_id
  WHERE seller.s_email = '".$_SESSION["seller_email"]."'
  GROUP BY products_category.pc_id");

  $arrayPrice = array(["Kategori", "Gelir"]);
  $array = array(["Kategori", "Sipariş Miktarı"]);
  while ($category = mysqli_fetch_assoc($categorySum)) {
    $array[] = [$category["pc_name"], (int)$category["sum_piece"]];
    $arrayPrice[] = [$category["pc_name"], (float)$category["sum_total"]];
  }

  $likeQuery = mysqli_query($connect_db, "SELECT products.p_name, round(avg(products_like.like_state),2) as avg_like
  FROM products_like
  LEFT JOIN products
  ON products_like.p_id = products.p_id
  LEFT JOIN seller
  ON products.s_id = seller.s_id
  WHERE seller.s_email = '".$_SESSION["seller_email"]."'
  GROUP BY products_like.p_id
  ORDER BY avg_like DESC
  LIMIT 20");

  $arrayLike = array(["Ürün", "Beğeni Ortalaması"]);
  while ($likeState = mysqli_fetch_assoc($likeQuery)) {
    $arrayLike[] = [$likeState["p_name"], (float)$likeState["avg_like"]];
  }

  $commentQuery = mysqli_query($connect_db, "SELECT products.p_name, count(products_comment.c_id) as count_comment
  FROM products_comment
  LEFT JOIN products
  ON products_comment.p_id = products.p_id
  LEFT JOIN seller
  ON products.s_id = seller.s_id
  WHERE seller.s_email = '".$_SESSION["seller_email"]."'
  GROUP BY products.p_id
  ORDER BY count_comment DESC
  LIMIT 20");

  $arrayComment = array(["Ürün", "Yorum Sayısı"]);
  while ($commentState = mysqli_fetch_assoc($commentQuery)) {
    $arrayComment[] = [$commentState["p_name"], (int)$commentState["count_comment"]];
  }

  $viewQuery = mysqli_query($connect_db, "SELECT products.p_name, count(products_view.p_id) as count_view
  FROM products_view
  LEFT JOIN products
  ON products_view.p_id = products.p_id
  LEFT JOIN seller
  ON products.s_id = seller.s_id
  WHERE seller.s_email = '".$_SESSION["seller_email"]."'
  GROUP BY products.p_id
  ORDER BY count_view DESC
  LIMIT 20");

  $arrayView = array(["Ürün", "Görüntülenme Sayısı"]);
  while ($viewState = mysqli_fetch_assoc($viewQuery)) {
    $arrayView[] = [$viewState["p_name"], (int)$viewState["count_view"]];
  }
 ?>

<script>

$(window).resize(function(){
  categoryDraw();
  catPrice();
  likeDraw();
  commentDraw();
  viewDraw();
});
google.charts.load('current', {packages: ['corechart', 'bar']});

google.charts.setOnLoadCallback(catPrice);
google.charts.setOnLoadCallback(viewDraw);
google.charts.setOnLoadCallback(commentDraw);
google.charts.setOnLoadCallback(likeDraw);
google.charts.setOnLoadCallback(categoryDraw);

function catPrice() {

    var data = new google.visualization.DataTable();

    var data = google.visualization.arrayToDataTable(<?php echo json_encode($arrayPrice, JSON_UNESCAPED_UNICODE); ?>);

    var options = {
      title: 'Ürün Kategorilerine Göre Gelir Miktarı',
      backgroundColor: 'transparent',
      margin: "0",
      colors: ['#e0693c'],

      hAxis: {
        title: 'Kategori',
      },
      vAxis: {
        title: 'Gelir'
      }
    };

    var chart = new google.visualization.ColumnChart(
      document.getElementById('chart_bar_cat_price'));

    chart.draw(data, options);
    }

function viewDraw() {

    var data = new google.visualization.DataTable();

    var data = google.visualization.arrayToDataTable(<?php echo json_encode($arrayView, JSON_UNESCAPED_UNICODE); ?>);

    var options = {
      title: 'En Çok Görüntülenen Ürünler (İlk 20)',
      backgroundColor: 'transparent',
      margin: "0",
      colors: ['#e0693c'],

      hAxis: {
        title: 'Ürün',
      },
      vAxis: {
        title: 'Görüntülenme Sayısı'
      }
    };

    var chart = new google.visualization.ColumnChart(
      document.getElementById('chart_bar_view'));

    chart.draw(data, options);
    }

function commentDraw() {

    var data = new google.visualization.DataTable();

    var data = google.visualization.arrayToDataTable(<?php echo json_encode($arrayComment, JSON_UNESCAPED_UNICODE); ?>);

    var options = {
      title: 'En Çok Yorum Alan Ürünler (İlk 20)',
      backgroundColor: 'transparent',
      margin: "0",
      colors: ['#e0693c'],

      hAxis: {
        title: 'Ürün',
      },
      vAxis: {
        title: 'Yorum Sayısı'
      }
    };

    var chart = new google.visualization.ColumnChart(
      document.getElementById('chart_bar_comment'));

    chart.draw(data, options);
    }

function likeDraw() {

    var data = new google.visualization.DataTable();

    var data = google.visualization.arrayToDataTable(<?php echo json_encode($arrayLike, JSON_UNESCAPED_UNICODE); ?>);

    var options = {
      title: 'En Çok Beğenilen Ürünler (İlk 20)',
      backgroundColor: 'transparent',
      margin: "0",
      colors: ['#e0693c'],

      hAxis: {
        title: 'Ürün',
      },
      vAxis: {
        title: 'Beğeni Ortalaması'
      }
    };

    var chart = new google.visualization.ColumnChart(
      document.getElementById('chart_bar_like'));

    chart.draw(data, options);
    }

function categoryDraw() {

    var data = new google.visualization.DataTable();

    var data = google.visualization.arrayToDataTable(<?php echo json_encode($array, JSON_UNESCAPED_UNICODE); ?>);

    var options = {
      title: 'Ürün Kategorilerine Göre Adet Satış Miktarı',
      backgroundColor: 'transparent',
      margin: "0",
      colors: ['#e0693c'],

      hAxis: {
        title: 'Kategori',
      },
      vAxis: {
        title: 'Sipariş Miktarı'
      }
    };

    var chart = new google.visualization.ColumnChart(
      document.getElementById('chart_bar_cat'));

    chart.draw(data, options);
    }
</script>
