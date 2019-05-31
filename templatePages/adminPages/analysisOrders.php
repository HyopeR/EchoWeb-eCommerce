<?php require("adminSettingsTop.php"); ?>
<?php require("adminDesignTop.php"); ?>
<?php require("../.././controlPages/connection.php"); ?>
<h3>Analizler ► Sipariş Analizleri</h3>
  <hr class="userspage-hr">

  <div class="row">
    <div class="col-md-12">
      <div class="col-md-4">

        <div class="col-md-6">
          <?php
          require("../.././controlPages/connection.php");

          $countryList = mysqli_query($connect_db, "SELECT uc_id, uc_name FROM users_country");

          echo '
          <form id="countryForm" method="POST">
            <select id="countrySelect" class="form-control">
            <option value="" disabled="disabled" selected="selected">İl Seçiniz</option>
          ';
          while($country = mysqli_fetch_assoc($countryList)) {
            echo '
            <option value="'.$country["uc_id"].'">'.$country["uc_name"].'</option>
            ';
          }
          echo '
          </select>
          <form>
          ';
          ?>
        </div>
        <div class="col-md-6">
          <select id="colorMap" class="form-control">
            <option value="" disabled="disabled" selected="selected">Detay Seçiniz</option>
            <option value="0">Kullanıcı Yoğunluğu</option>
            <option value="1">Sipariş Yoğunluğu</option>
          </select>
        </div>
        <div class="col-md-12">
          <div id="country_detail"></div>
        </div>
      </div>
      <div class="col-md-8">
        <?php include("turkeyMap.php"); ?>
    </div>
  </div>

  <div class="col-md-12">
    <div class="col-md-4">
      <select class="form-control" id="selectYear" name="selectYear">
        <option value="" disabled="disabled" selected="selected">Yıl Seçiniz</option>
        <?php
          $dbQuery = mysqli_query($connect_db, "SELECT YEAR(o_time) as yil, COUNT(o_id) as toplam
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
          GROUP BY yil
          HAVING toplam > 0");

          while($writeYear = mysqli_fetch_assoc($dbQuery)) {
            echo '
              <option value="'.$writeYear["yil"].'">'.$writeYear["yil"].'</option>
            ';
          }
         ?>
      </select>
    </div>
    <div class="col-md-4">
      <select class="form-control" id="selectMonth" name="selectMonth" style="visibility: hidden;"></select>
    </div>
    <div class="col-md-4">
      <select class="form-control" id="selectDay" name="selectDay" style="visibility: hidden;"></select>
    </div>
  </div>
  <div class="col-md-12"><div id="chart_div"></div></div>
  </div>
  <!-- <input class="range_input" type="range" name="points" value="1" step="0.5" min="1" max="30"> -->

<?php require("adminSettingsBottom.php"); ?>
<?php require("adminDesignBottom.php"); ?>

<script>
svgturkiyeharitasi();

$("#colorMap").change(function(){
  document.getElementById("label-map").setAttribute("style","display: block");
  if(this.value == 0) {
    <?php
      $dbAll = mysqli_query($connect_db, "SELECT count(u_id) FROM users");
      $dbAllRow = mysqli_fetch_row($dbAll);
      $dbAllValue = $dbAllRow[0];

      $countryArray = [];

      $colorPick = mysqli_query($connect_db, "SELECT users_country.uc_name, users_country.uc_id, count(u_id) as toplam_sayi
      FROM users
      RIGHT JOIN users_country
      ON users.uc_id = users_country.uc_id
      GROUP BY users_country.uc_id");

      while($colorOne = mysqli_fetch_assoc($colorPick)) {
        $countryArray[] = json_encode($colorOne, JSON_UNESCAPED_UNICODE);
      }
     ?>
     let dbAllValue = <?php echo $dbAllValue ?>;
     let allCountry = <?php echo json_encode($countryArray) ?>;
     mapFunction(dbAllValue, allCountry);;
     }
  else if(this.value == 1) {
    <?php
      $dbAll = mysqli_query($connect_db, "SELECT count(o_id) FROM orders");
      $dbAllRow = mysqli_fetch_row($dbAll);
      $dbAllValue = $dbAllRow[0];

      $countryArray = [];

      $colorPick = mysqli_query($connect_db, "SELECT users_country.uc_name, users_country.uc_id, COUNT(orders.o_id) as toplam_sayi
      FROM users
      RIGHT JOIN users_country
      ON users.uc_id = users_country.uc_id
      LEFT JOIN orders
      ON users.u_id = orders.u_id
      GROUP BY users_country.uc_id");

      while($colorOne = mysqli_fetch_assoc($colorPick)) {
        $countryArray[] = json_encode($colorOne, JSON_UNESCAPED_UNICODE);
      }
     ?>
     let dbAllValue = <?php echo $dbAllValue ?>;
     let allCountry = <?php echo json_encode($countryArray) ?>;
     mapFunction(dbAllValue, allCountry);
  }
});

function mapFunction(dbAllValue, allCountry) {
  console.log(allCountry);
  let allMap = document.querySelector("g");
  let allMapChild = allMap.children;
  let loopValue = allMapChild.length;
  for (let i = 0; i < loopValue; i++) {
    allMapChild[i].setAttribute("data-value", 0);
  }

  let avgUsers = dbAllValue / allCountry.length;
  // console.log(avgUsers);

   allCountry.forEach(function(element) {
    let country = JSON.parse(element);
    // console.log(country);
    let selectText = 'data-iladi = ' + country["uc_name"];
    let il = document.querySelector('[' + selectText + ']');
    il.setAttribute("data-value", parseInt (il.getAttribute("data-value")) + parseInt(country["toplam_sayi"]));

    let ilPerson = parseInt(il.getAttribute("data-value"));
    if(ilPerson == 0) {
      il.firstElementChild.setAttribute("style", "fill: #e0b09e");
    } else if (ilPerson >= avgUsers) {
      il.firstElementChild.setAttribute("style", "fill: #9a3a15");
    } else if (ilPerson <= avgUsers){
      il.firstElementChild.setAttribute("style", "fill: #cc7959");
    }
    });
}
let label;

$("#selectYear").change(function() {
  let selectMonth = document.getElementById("selectMonth");
  selectMonth.setAttribute("style", "visibility: visible");
  $.ajax({
    type: "POST",
    url: "http://localhost/controlPagesAdmin/controlSalesMonth.php",
    data: {selectYear: this.value},
  }).done(function ( yearResult ) {
    selectMonth.innerHTML = yearResult;
  });
});

$("#selectMonth").change(function() {
  let selectYear = document.getElementById("selectYear");
  let selectDay = document.getElementById("selectDay");
  selectDay.setAttribute("style", "visibility: visible");
  $.ajax({
    type: "POST",
    url: "http://localhost/controlPagesAdmin/controlSales.php",
    data: {selectMonth: this.value, selectYear: selectYear.value},
  }).done(function( monthResult ) {
    label = "Günler";
    selectDay.innerHTML = "";
    let resultSplit = monthResult.split(",");
    for(let i = 0; i < resultSplit.length; i+= 2) {
      selectDay.innerHTML += resultSplit[i];
      resultSplit.splice(i, 1);
    }
    callback(resultSplit);
  });
});

$("#selectDay").change(function() {
  let selectMonth = document.getElementById("selectMonth");
  let selectYear = document.getElementById("selectYear");
  $.ajax({
    type: "POST",
    url: "http://localhost/controlPagesAdmin/controlDaySales.php",
    data: {selectDay: this.value, selectMonth: selectMonth.value, selectYear: selectYear.value},
  }).done(function( dayResult ) {
    label = "Ürünler";
    let resultSplit = dayResult.split(",");
    resultSplit.pop();
    callback(resultSplit);
  });
});

let global_result = 0;
function callback(response) {
  global_result = response;
  ordersDraw(global_result);
}

$(window).resize(function(){
  if(global_result != 0) {
    ordersDraw(global_result);
  }
});

google.charts.load('current', {packages: ['corechart', 'bar']});

function ordersDraw(resultSplit) {

    document.getElementById("chart_div").setAttribute("style","width: 100%; height: 500px; display: block;");
    let monthArray = [];
    monthArray.push([label, 'Sipariş Miktarı']);
    for (let i = 0; i < resultSplit.length; i+= 2) {
      let loopArray = [resultSplit[i], parseInt(resultSplit[i+1])];
      monthArray.push(loopArray);
    }

    var data = new google.visualization.DataTable();

    var data = google.visualization.arrayToDataTable(monthArray);

    var options = {
      title: 'Sipariş Miktarı',
      backgroundColor: 'transparent',
      margin: "0",
      colors: ['#e0693c'],

      hAxis: {
        title: label,
      },
      vAxis: {
        title: 'Sipariş Miktarı'
      }
    };

    var chart = new google.visualization.ColumnChart(
      document.getElementById('chart_div'));

    chart.draw(data, options);
    }

</script>
