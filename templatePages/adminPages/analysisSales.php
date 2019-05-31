<?php require("adminSettingsTop.php"); ?>
<?php require("adminDesignTop.php"); ?>
<?php require("../.././controlPages/connection.php"); ?>

<?php
  $listComp = mysqli_query($connect_db, "SELECT MONTH(o_time) AS month_id, MONTHNAME(o_time) as month_name, YEAR(o_time) as year
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
  GROUP BY YEAR(o_time), MONTH(o_time)");

  $listComp2 = mysqli_query($connect_db, "SELECT MONTH(o_time) AS month_id, MONTHNAME(o_time) as month_name, YEAR(o_time) as year
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
  GROUP BY YEAR(o_time), MONTH(o_time)");

  $dbYear = mysqli_query($connect_db, "SELECT YEAR(o_time) as year, COUNT(o_id) as sum
  FROM orders
  WHERE o_id in (SELECT o_id
  FROM orders
  LEFT JOIN users
  ON orders.u_id = users.u_id
  LEFT JOIN shop_cart
  ON orders.sc_id = shop_cart.sc_id
  LEFT JOIN products_shop_cart
  ON shop_cart.sc_id = products_shop_cart.sc_id
  LEFT JOIN products
  ON products_shop_cart.p_id = products.p_id
  LEFT JOIN seller
  ON products.s_id = seller.s_id
  WHERE seller.s_email = '".$_SESSION["seller_email"]."'
  GROUP BY shop_cart.sc_id)
  GROUP BY year
  HAVING sum > 0");
 ?>
<h3>Analizler ► Satış Analizleri</h3>
  <hr class="userspage-hr">
<div class="row">
  <div class="col-md-12">
    <div class="col-md-6">
      <button id="specific-button" class="form-control">Spesifik Görünüm</button>

      <div class="col-md-12">
        <div class="rotate-wrapper" id="specific-rotate">
          <select class="form-control" id="priceYear">
            <option value="" disabled="disabled" selected="selected">Yıl Seçiniz</option>
            <?php
              while($writeYear = mysqli_fetch_assoc($dbYear)) {
                echo '
                  <option value="'.$writeYear["year"].'">'.$writeYear["year"].'</option>
                ';
              }
             ?>
          </select>

          <select class="form-control" id="priceMonth" style="visibility: hidden;">
          </select>
        </div>
      </div>

    </diV>
    <div class="col-md-6">

      <button id="comparison-button" class="form-control">Karşılaştırmalı Görünüm</button>

      <div class="col-md-12">
        <div class="rotate-wrapper" id="comparison-rotate">
          <select class="form-control" id="comp-1">
            <option value="" disabled="disabled" selected="selected">1. Kıyaslama Ayını Seçiniz</option>
            <?php
              while($compMonth = mysqli_fetch_array($listComp)) {
                echo '
                  <option value="'.$compMonth["year"].'-'.$compMonth["month_id"].'">'.$compMonth["month_name"].' ('.$compMonth["year"].')</option>
                ';
              }
             ?>
          </select>

          <select class="form-control" id="comp-2">
            <option value="" disabled="disabled" selected="selected">2. Kıyaslama Ayını Seçiniz</option>
            <?php
              while($compMonth = mysqli_fetch_array($listComp2)) {
                echo '
                  <option value="'.$compMonth["year"].'-'.$compMonth["month_id"].'">'.$compMonth["month_name"].' ('.$compMonth["year"].')</option>
                ';
              }
             ?>
          </select>
      </div>
    </div>

    </diV>


  <div class="col-md-12">
    <div id="chart_line" class="big-chart"></div>
  </div>
  <div class="col-md-12">
    <div id="chart_bar" class="big-chart"></div>
  </div>
</div>
<?php require("adminSettingsBottom.php"); ?>
<?php require("adminDesignBottom.php"); ?>
<?php
$dataCalender = date('d.m.Y',strtotime('last day of this month'));
$dataDay = explode(".",$dataCalender);
$selectYear = $dataDay[2];

$countrySpread = mysqli_query($connect_db, "SELECT users_country.uc_name, sum(orders.o_total_price) as total_order_country
    FROM products
    LEFT JOIN seller
    ON products.s_id = seller.s_id
    LEFT JOIN products_shop_cart
    ON products.p_id = products_shop_cart.p_id
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
    WHERE YEAR(orders.o_time) = '".$selectYear."'
    AND seller.s_email = '".$_SESSION["seller_email"]."'
    GROUP BY users_country.uc_id
    ORDER BY total_order_country DESC
    LIMIT 20");

    $countrySales = array(["Şehir", "Gelir"]);
    while($row = mysqli_fetch_assoc($countrySpread)){
      $countrySales[] = [$row["uc_name"], (float)$row["total_order_country"]];
    }
?>

<script>
let global_result = 0;
let place = 0;
let label = [];
let compOne = 0;
let compTwo = 0;

$(window).on('load', function() {
  var yearValue = <?php echo $selectYear ?>;
  $.ajax({
    type: "POST",
    url: "http://localhost/controlPagesAdmin/yearSales.php",
    data: {priceYear: yearValue},
  }).done(function( yearSales ) {
    label[0] = yearValue;
    place = 2;
    callback(yearSales);
  })
});

$("#comp-1").change(function () {
  compOne = this.value;
  label[0] = this[this.selectedIndex].innerText;
  if(compTwo != 0) {
    sendComparison();
  }
});

$("#comp-2").change(function () {
  compTwo = this.value;
  label[1] = this[this.selectedIndex].innerText;
  if(compOne != 0) {
    sendComparison();
  }
});

function sendComparison() {
  $.ajax({
    type: "POST",
    url: "http://localhost/controlPagesAdmin/comparisonMonthSales.php",
    data: {compOne: compOne, compTwo: compTwo},
  }).done(function( compResult ) {
    delete compResult[0];
    let result = [];
    for(let i = 1; i < compResult.length; i++) {
      result.push(compResult[i]);
    }
    place = 1;
    callback(result);
  })
}

$("#priceYear").change(function () {
  let priceMonth = document.getElementById("priceMonth");
  priceMonth.setAttribute("style", "visibility: visible");
  $.ajax({
    type: "POST",
    url: "http://localhost/controlPagesAdmin/monthList.php",
    data: {priceYear: this.value},
  }).done(function( monthList ) {
    let priceMonth = document.getElementById("priceMonth");
    priceMonth.innerHTML = monthList;
  });

  $.ajax({
    type: "POST",
    url: "http://localhost/controlPagesAdmin/yearSales.php",
    data: {priceYear: this.value},
  }).done(function( yearSales ) {
    let priceYear = document.getElementById("priceYear");
    label[0] = priceYear[priceYear.selectedIndex].innerText;
    place = 2;
    callback(yearSales);
  })
});

$("#priceMonth").change(function() {
  let priceMonth = document.getElementById("priceMonth");
  let priceYear = document.getElementById("priceYear");
  $.ajax({
    type: "POST",
    url: "http://localhost/controlPagesAdmin/monthAllPrice.php",
    data: {priceMonth: this.value, priceYear: priceYear.value},
  }).done(function( dayResult ) {
    let resultSplit = dayResult.split(",");
    resultSplit.pop();
    label[0] = priceMonth[priceMonth.selectedIndex].innerText;
    label[1] = priceYear[priceYear.selectedIndex].innerText;
    place = 3;
    callback(resultSplit);
  })
});

function callback(response) {
  global_result = response;
  if(place == 1) {
    drawCurveTypes(global_result);
  } else if(place == 2){
    drawYear(global_result);
  } else if(place == 3) {
    drawBasic(global_result);
  }
}

$(window).resize(function(){
  countrySales();
  if(global_result != 0) {
    if(place == 1) {
      drawCurveTypes(global_result);
    } else if(place == 2) {
      drawYear(global_result);
    } else if (place == 3) {
      drawBasic(global_result);
    } else {
      console.log("Seçim yok.");
    }
  }
});

$('#comparison-button').click(function() {
  let comparison_rotate = document.getElementById("comparison-rotate");
  if(comparison_rotate.style.display == "block") {
    comparison_rotate.setAttribute("style","display: none");
  } else {
    comparison_rotate.setAttribute("style","display: block");
  }
});

$('#specific-button').click(function() {
  let specific_rotate = document.getElementById("specific-rotate");
  if(specific_rotate.style.display == "block") {
    specific_rotate.setAttribute("style","display: none");
  } else {
    specific_rotate.setAttribute("style","display: block");
  }
});

google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(countrySales);
function countrySales() {

    var data = new google.visualization.DataTable();

    var data = google.visualization.arrayToDataTable(<?php echo json_encode($countrySales, JSON_UNESCAPED_UNICODE); ?>);

    var options = {
      title: 'Şehirlere Göre Gelir Dağılımı (İlk 20)',
      backgroundColor: 'transparent',
      margin: "0",
      colors: ['#e0693c'],

      hAxis: {
        title: 'Şehir',
      },
      vAxis: {
        title: 'Gelir'
      }
    };

    var chart = new google.visualization.ColumnChart(
      document.getElementById('chart_bar'));

    chart.draw(data, options);
    }

google.charts.load('current', {packages: ['corechart', 'line']});

function drawBasic(resultSplit) {

      let monthArray = [];
      for (let i = 0; i < resultSplit.length; i+= 2) {
        let loopArray = [parseFloat(resultSplit[i]), parseInt(resultSplit[i+1])];
        monthArray.push(loopArray);
      }

      var data = new google.visualization.DataTable();
      data.addColumn('number', 'X');
      data.addColumn('number', 'Gelir');

      data.addRows(monthArray);

      var options = {
        title: label[1] + " " + label[0] + ' Ayı Gelirleri',
        backgroundColor: 'transparent',
        colors:  ['#E0693C','#E0693C'],
        lineWidth: 3,
        hAxis: {
          title: 'Gün',
        },
        vAxis: {
          title: 'Gelir',
        }
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_line'));

      chart.draw(data, options);
    }

    function drawYear(yearSales) {
          var data = google.visualization.arrayToDataTable(yearSales);

          var options = {
            title: label[0] + ' Yıllık Gelirler',
            backgroundColor: 'transparent',

            lineWidth: 2,
            hAxis: {
              title: 'Gün',
            },
            vAxis: {
              title: 'Gelir',
            }
          };

          var chart = new google.visualization.LineChart(document.getElementById('chart_line'));

          chart.draw(data, options);
        }

    function drawCurveTypes(compResult) {
      var data = new google.visualization.DataTable();
      data.addColumn('number', 'X');
      data.addColumn('number', label[0] + ' Gelir');
      data.addColumn('number', label[1] + ' Gelir');

      data.addRows(compResult);

      var options = {
        title: 'Karşılaştırma Gelir Grafiği',
        backgroundColor: 'transparent',
        hAxis: {
          title: 'Gün',
        },
        vAxis: {
          title: 'Gelir',
        }
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_line'));
      chart.draw(data, options);
    }


</script>
