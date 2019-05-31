<?php require("adminSettingsTop.php"); ?>
<?php require("adminDesignTop.php"); ?>
<?php require("../.././controlPages/connection.php"); ?>
<h3>Analizler ► Müşteri Analizleri</h3>
  <hr class="userspage-hr">

  <div class="row">
    <div class="col-md-12">
      <div class="col-md-6"><div id="piechart1" style="width: 100%; height: 300px"></div></div>
      <div class="col-md-6"><div id="piechart2" style="width: 100%; height: 300px"></div></div>
    </div>

    <div class="col-md-12">
      <div class="col-md-12">
        <div class="col-md-1"></div>
        <div class="col-md-5">
          <select class="form-control" id="customersGender">
            <option value="" disabled="disabled" selected="selected">Cinsiyet Seçiniz</option>
            <option value="0">Tüm Cinsiyetler</option>
            <option value="1">Kadın</option>
            <option value="2">Erkek</option>
          </select>
        </div>
        <div class="col-md-5">
          <select class="form-control" id="customersAge">
            <option value="" disabled="disabled" selected="selected">Yaş Seçiniz</option>
            <?php
            $ageGroup = mysqli_query($connect_db, "CALL age_class");
              while($age = mysqli_fetch_assoc($ageGroup)){
                echo '
                  <option value="'.$age["age"].'">'.$age["age"].'</option>;
                ';
              }
             ?>
          </select>
        </div>
        <div class="col-md-1"></div>
      </div>
      <div class="col-md-12">
        <div class="big-chart" id="customer-choice"></div>
      </div>
    </div>
  </div>
<?php require("adminSettingsBottom.php"); ?>
<?php require("adminDesignBottom.php"); ?>
<?php include("dataCustomers.php"); ?>

<script>
  $("#customersGender").change(function () {
    let selectAge = document.getElementById("customersAge");
    if(this.value == 0){
      drawChart3();
      selectAge.selectedIndex = 0;
    } else {
      $.ajax({
        type: "POST",
        url: "http://localhost/controlPagesAdmin/customersChoice.php",
        data: { selectGender: this.value, selectAge: selectAge.value },
      }).done(function( proResult ) {
        selectAge.selectedIndex = 0;
        customerChoice(proResult);
      });
    }
  });

  $("#customersAge").change(function () {
    let selectGender = document.getElementById("customersGender");
    $.ajax({
      type: "POST",
      url: "http://localhost/controlPagesAdmin/customersChoice.php",
      data: { selectGender: selectGender.value, selectAge: this.value },
    }).done(function( proResult ) {
      console.log(proResult);
      customerChoice(proResult);
    });
  });

function customerChoice(proResult) {

  var data = google.visualization.arrayToDataTable(proResult);


  var options = {'title':'En Çok Tercih Edilen Ürünler',
  'backgroundColor': 'transparent',
  'margin': "0",
  colors: ['#E0693C'],

  hAxis: {
    title: 'Kategoriler',
    textStyle : {
        fontSize: 11 // or the number you want
    },
  },
  vAxis: {
    title: 'Sipariş Sayıları'
  }
  };

  var chart = new google.visualization.ColumnChart(document.getElementById('customer-choice'));

  chart.draw(data, options);
}

</script>
