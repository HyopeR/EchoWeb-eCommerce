<?php require("adminSettingsTop.php"); ?>
<?php require("adminDesignTop.php"); ?>
<?php require("../.././controlPages/connection.php"); ?>
<?php
$dataCalender = date('d.m.Y');
$dataDay = explode(".",$dataCalender);
$selectDay = $dataDay[2]."-".$dataDay[1]."-".$dataDay[0];
$dateArray = array();
for($i = 0; $i < 7; $i++) {
  $configDate = "-".$i." day";
  $dateArray[] = date("Y-m-d", strtotime($configDate));
}

$dayAvg = mysqli_query($connect_db, "SELECT sum(orders.o_total_price) as price_total, COUNT(orders.o_id) as total_order
          FROM orders
          WHERE o_id IN (SELECT o_id
          FROM orders
          LEFT JOIN shop_cart
          ON orders.sc_id = shop_cart.sc_id
          LEFT JOIN products_shop_cart
          ON shop_cart.sc_id = products_shop_cart.sc_id
          LEFT JOIN products
          ON products_shop_cart.p_id = products.p_id
          LEFT JOIN seller
          ON products.s_id = seller.s_id
          WHERE seller.s_email = '".$_SESSION["seller_email"]."'
          GROUP BY orders.sc_id)");
$dayAvgRow = mysqli_fetch_row($dayAvg);

$dateList = mysqli_query($connect_db, "SELECT *
          FROM orders
          WHERE o_id IN (SELECT o_id
          FROM orders
          LEFT JOIN shop_cart
          ON orders.sc_id = shop_cart.sc_id
          LEFT JOIN products_shop_cart
          ON shop_cart.sc_id = products_shop_cart.sc_id
          LEFT JOIN products
          ON products_shop_cart.p_id = products.p_id
          LEFT JOIN seller
          ON products.s_id = seller.s_id
          WHERE seller.s_email = '".$_SESSION["seller_email"]."'
          GROUP BY orders.sc_id)
          GROUP BY DATE(o_time)");
$dateCount=mysqli_num_rows($dateList);

$commentAvg = mysqli_query($connect_db, "SELECT count(c_id) as total_comment
          FROM products_comment
          LEFT JOIN products
          ON products_comment.p_id = products.p_id
          LEFT JOIN seller
          ON products.s_id = seller.s_id
          WHERE seller.s_email = '".$_SESSION["seller_email"]."' ");
$commentCount = mysqli_fetch_row($commentAvg);

$avgPrice = round($dayAvgRow[0] / $dateCount);
$avgSales = round($dayAvgRow[1] / $dateCount);
$avgComment = round($commentCount[0] / $dateCount);
 ?>

<h3>Güncel Takip ► Günlük Takip</h3>
  <hr class="userspage-hr">
<div class="row">
<div class="col-md-12">
  <div class="col-md-4">
    <div class="saw-wrapper">
      <div class="saw-img"><span class="fa fa-money"></span></div>
      <div class="saw-detail">
        <?php
          $dayQuery = mysqli_query($connect_db, "SELECT DATE(o_time) as date_detail, SUM(orders.o_total_price) as total_day, COUNT(orders.o_id) as total_order
          FROM orders
          WHERE o_id IN (SELECT o_id
          FROM orders
          LEFT JOIN shop_cart
          ON orders.sc_id = shop_cart.sc_id
          LEFT JOIN products_shop_cart
          ON shop_cart.sc_id = products_shop_cart.sc_id
          LEFT JOIN products
          ON products_shop_cart.p_id = products.p_id
          LEFT JOIN seller
          ON products.s_id = seller.s_id
          WHERE seller.s_email = '".$_SESSION["seller_email"]."'
          GROUP BY orders.sc_id)
          AND DATE(o_time) = '".$selectDay."'");

          $dayRow = mysqli_fetch_row($dayQuery);

          echo '<p class="detail-content">'.$dayRow[1].' ₺';

          if ($dayRow[1] > $avgPrice) {
            echo '<span class="fa fa-arrow-up good"></span>';
          } else if ($dayRow[1] == $avgPrice) {
            echo '<span class="fa fa-circle normal"></span>';
          } else {
            echo '<span class="fa fa-arrow-down bad"></span>';
          }
          echo '</p>';
         ?>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="saw-wrapper">
      <div class="saw-img"><span class="fa fa-shopping-cart"></span></div>
      <div class="saw-detail">
         <?php
         echo '<p class="detail-content">'.$dayRow[2].' ';

         if ($dayRow[2] > $avgSales) {
           echo '<span class="fa fa-arrow-up good"></span>';
         } else if ($dayRow[2] == $avgSales) {
           echo '<span class="fa fa-circle normal"></span>';
         } else {
           echo '<span class="fa fa-arrow-down bad"></span>';
         }
         echo '</p>';
        ?>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="saw-wrapper">
      <div class="saw-img"><span class="fa fa-comment"></span></div>
      <div class="saw-detail">
        <?php
          $dayQuery = mysqli_query($connect_db, "SELECT COUNT(products_comment.c_id) as sum_comment
          FROM products_comment
          LEFT JOIN products
          ON products_comment.p_id = products.p_id
          LEFT JOIN seller
          ON products.s_id = seller.s_id
          WHERE seller.s_email = '".$_SESSION["seller_email"]."'
          AND DATE(products_comment.c_time) = '".$selectDay."' ");

          $dayRow = mysqli_fetch_row($dayQuery);

         echo '<p class="detail-content">'.$dayRow[0].' ';

         if ($dayRow[0] > $avgComment) {
           echo '<span class="fa fa-arrow-up good"></span>';
         } else if ($dayRow[0] == $avgComment) {
           echo '<span class="fa fa-circle normal"></span>';
         } else {
           echo '<span class="fa fa-arrow-down bad"></span>';
         }
         echo '</p>';
        ?>
      </div>
    </div>
  </div>
</div>
<div class="col-md-12 settings-column">
  <div class="col-md-5">
    <div class="order-detail-header"><h4>Gelen Siparişler <span class="fa fa-sort"></span></h4></div>
    <div class="order-detail-content">
    <?php
      $dayOrderDetail = mysqli_query($connect_db, "SELECT *
      FROM orders
      LEFT JOIN users
      ON orders.u_id = users.u_id
      WHERE o_id IN (SELECT o_id
      FROM orders
      LEFT JOIN shop_cart
      ON orders.sc_id = shop_cart.sc_id
      LEFT JOIN products_shop_cart
      ON shop_cart.sc_id = products_shop_cart.sc_id
      LEFT JOIN products
      ON products_shop_cart.p_id = products.p_id
      LEFT JOIN seller
      ON products.s_id = seller.s_id
      WHERE seller.s_email = '".$_SESSION["seller_email"]."'
      GROUP BY orders.sc_id)
      AND DATE(orders.o_time) = '".$selectDay."'
      ORDER BY orders.o_time DESC ");

      $cursor = 1;
      while ($orderDetail = mysqli_fetch_assoc($dayOrderDetail)) {
        if($cursor == 1) {
          $color = "background: rgba(0, 0, 0, 0.1);";
          $cursor--;
        } else {
          $color = "background: rgba(0, 0, 0, 0.2);";
          $cursor++;
        }
        echo '
        <div class="detail-order-row" style="'.$color.'">
          <div class="item-order-row"><b>Sipariş No:</b> '.$orderDetail["o_id"].'</div>
          <div class="item-order-row"><b>Sipariş Tarihi:</b> '.$orderDetail["o_time"].'</div>
          <div class="item-order-row"><b>Müşteri:</b> '.$orderDetail["u_name"].' '.$orderDetail["u_surname"].'</div>
          <div class="item-order-row"><b>Adres:</b> '.$orderDetail["u_address"].'</div>
          <div class="item-order-row"><b>Telefon:</b> '.$orderDetail["u_number"].'</div>
          <div class="item-order-row"><b>Sipariş Tutarı:</b> '.$orderDetail["o_total_price"].'</div>
        </div>
        ';
      }
     ?>
   </div>
  </div>
  <div class="col-md-7"><div class="big-chart" id="chart_bar"></div></div>
</div>
</div>
<?php require("adminSettingsBottom.php"); ?>
<?php require("adminDesignBottom.php"); ?>

<?php
  $salesDetail = mysqli_query($connect_db, "SELECT DATE(orders.o_time) as date_week, SUM(orders.o_total_price) as total_price
  FROM orders
  WHERE o_id IN (SELECT o_id
  FROM orders
  LEFT JOIN shop_cart
  ON orders.sc_id = shop_cart.sc_id
  LEFT JOIN products_shop_cart
  ON shop_cart.sc_id = products_shop_cart.sc_id
  LEFT JOIN products
  ON products_shop_cart.p_id = products.p_id
  LEFT JOIN seller
  ON products.s_id = seller.s_id
  WHERE seller.s_email = '".$_SESSION["seller_email"]."'
  GROUP BY orders.sc_id)
  AND DATE(o_time) IN ('".$dateArray[0]."','".$dateArray[1]."','".$dateArray[2]."','".$dateArray[3]."','".$dateArray[4]."','".$dateArray[5]."','".$dateArray[6]."')
  GROUP BY DATE(orders.o_time)
  ORDER BY date_week DESC");

  $array = array(["Gün", "Gelir"]);
  while ($weekData = mysqli_fetch_assoc($salesDetail)) {
    $array[] = [$weekData["date_week"], (float)$weekData["total_price"]];
  }
?>

<script>

$(window).resize(function(){
  weekSales();
});
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(weekSales);
function weekSales() {

    var data = new google.visualization.DataTable();

    var data = google.visualization.arrayToDataTable(<?php echo json_encode($array, JSON_UNESCAPED_UNICODE); ?>);

    var options = {
      title: 'Haftalık Gelir',
      backgroundColor: 'transparent',
      margin: "0",
      colors: ['#e0693c'],

      hAxis: {
        title: 'Gün',
      },
      vAxis: {
        title: 'Gelir'
      }
    };

    var chart = new google.visualization.ColumnChart(
      document.getElementById('chart_bar'));

    chart.draw(data, options);
    }
</script>
