<?php require("adminSettingsTop.php"); ?>
<?php require("adminDesignTop.php"); ?>
<?php require("../.././controlPages/connection.php"); ?>
<h3>Ürünler ► Ürün Stokları</h3>
  <hr class="userspage-hr">

<div class="row">
  <div class="col-md-12">
    <div class="col-md-4">
      <select id="selectGender" name="selectGender" class="form-control">
        <option value="" disabled="disabled" selected="selected">Cinsiyet Seçiniz</option>
        <?php
          $genderPro = mysqli_query($connect_db, "SELECT * FROM products_gender");
          while($gender = mysqli_fetch_assoc($genderPro)) {
            echo '
              <option value="'.$gender["pg_id"].'">'.$gender["pg_name"].'</option>
            ';
          }
         ?>
     </select>
    </div>
    <div class="col-md-4">
      <select id="selectCat" name="selectCat" class="form-control" style="visibility: hidden">
     </select>
    </div>
    <div class="col-md-4">
      <select id="detailStock" name="detailStock" class="form-control" style="visibility: hidden">
      </select>
    </div>
      <div class="col-md-12" id="view_detail">
        <div class="col-md-2"><div id="chart_img_wrapper" style="display: none"><img id="chart_img" src=""></div></div>
        <div class="col-md-10"><div id="chart_div" style="width: 100%; display: none;"></div></div>

      </div>
  </div>
</div>

<?php require("adminSettingsBottom.php"); ?>
<?php require("adminDesignBottom.php"); ?>

<script>

$("#selectGender").change(function(){
  let selectCat = document.getElementById("selectCat");
  let detailStock = document.getElementById("detailStock");
  selectCat.setAttribute("style", "visibility: visible")
  detailStock.setAttribute("style", "visibility: hidden");

  $.ajax({
    type: "POST",
    url: "http://localhost/controlPagesAdmin/controlCategory.php",
    data: { selectGender: this.value },
  }).done(function( catResult ) {
    selectCat.innerHTML = catResult;
  });
});

$("#selectCat").change(function(){
  let detailStock = document.getElementById("detailStock");
  let selectGender = document.getElementById("selectGender");
  detailStock.setAttribute("style", "visibility: visible");
  $.ajax({
    type: "POST",
    url: "http://localhost/controlPagesAdmin/controlProduct.php",
    data: { selectCat: this.value,  selectGender: selectGender.value},
  }).done(function( proResult ) {
    detailStock.innerHTML = proResult;
  });
});

$("#detailStock").change(function(){
  let view_detail = document.getElementById("view_detail");

  $.ajax({
    type: "POST",
    url: "http://localhost/controlPagesAdmin/controlStock.php",
    data: { selectPro: this.value},
  }).done(function( stockResult ) {
    let pro = document.getElementById("detailStock");
    let proIndex = pro.selectedIndex;
    let proName = pro[proIndex].text;
    callback(stockResult, proName);
  });
});

let global_result = 0;
let global_name = 0;
function callback(result, name) {
  global_result = result;
  global_name = name;
  drawBasic(global_result, global_name);
}

$(window).resize(function(){
  if(global_result != 0 && global_name != 0) {
    drawBasic(global_result, global_name);
  }
});

google.charts.load('current', {packages: ['corechart', 'bar']});

function drawBasic(stockResult, proName) {

    document.getElementById("chart_img_wrapper").setAttribute("style", "display: block;")
    document.getElementById("chart_div").setAttribute("style","width: 100%; height: 500px; display: block;");
    let stockArray = [];
    stockArray.push(['Beden', 'Stok Miktarı']);
    let stock = stockResult.split(",");
    let proImg = stock[0];
    document.getElementById("chart_img").src = "../"+proImg;
    stock.pop();
    stock.shift();
    for (let i = 0; i < stock.length; i+= 2) {
      let loopArray = [stock[i], parseInt(stock[i+1])];
      stockArray.push(loopArray);
    }

    var data = new google.visualization.DataTable();

    var data = google.visualization.arrayToDataTable(stockArray);

    var options = {
      title: proName + ' Stok Miktarı',
      backgroundColor: 'transparent',
      margin: "0",
      colors: ['#e0693c'],

      hAxis: {
        title: 'Bedenler',
      },
      vAxis: {
        title: 'Stok Miktarı'
      }
    };

    var chart = new google.visualization.ColumnChart(
      document.getElementById('chart_div'));

    chart.draw(data, options);
    }

</script>
