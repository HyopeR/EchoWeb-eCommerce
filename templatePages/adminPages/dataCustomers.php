<?php
  require("../.././controlPages/connection.php");

  function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
  }

  function random_color() {
      return random_color_part() . random_color_part() . random_color_part();
  }

  $usersValue = mysqli_query($connect_db, "SELECT g_name, count(u_id) as num
  FROM users
  LEFT JOIN users_gender
  ON users.g_id = users_gender.g_id
  GROUP BY users_gender.g_name");

  $firstChange = mysqli_query($connect_db, "SELECT products_category.pc_name, sum(products_shop_cart.sc_piece) as big_low
  FROM products
  LEFT JOIN products_category
  ON products.pc_id = products_category.pc_id
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
  WHERE seller.s_email = '".$_SESSION["seller_email"]."'
  GROUP BY products_category.pc_id
  ORDER BY big_low DESC
  LIMIT 20");

  $ageGroup = mysqli_query($connect_db, "CALL age_class");
?>

  <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart1);

      function drawChart1() {

        var data = google.visualization.arrayToDataTable([
          ['Cinsiyet', 'Sayı'],
          <?php
            while($row = mysqli_fetch_assoc($usersValue)) {
                echo " [ '".$row["g_name"]."', ".$row["num"]."],";
            }
           ?>
        ]);

        var options = {'title':'Cinsiyete Göre Kullanıcı Oranları',
        'backgroundColor': 'transparent',
        'margin': "0",
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart1'));

        chart.draw(data, options);
      }

    </script>

    <script type="text/javascript">

    google.charts.setOnLoadCallback(drawChart2);

    function drawChart2() {

      var data = google.visualization.arrayToDataTable([
        ['Yaş', 'Kullanıcı Sayısı'],
        <?php
          while($row2 = mysqli_fetch_assoc($ageGroup)) {
              echo " [ '".$row2["age"]."', ".$row2["person_count"]."],";
          }
         ?>
      ]);

      var options = {'title':'Yaşa Göre Kullanıcı Oranları',
      'backgroundColor': 'transparent',
      'margin': "0",
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

      chart.draw(data, options);
    }
    </script>

    <script type="text/javascript">

    google.charts.setOnLoadCallback(drawChart3);

    function drawChart3() {

      var data = google.visualization.arrayToDataTable([
        ['Kategoriler', 'Sipariş Sayısı', { role: 'style' }],
          <?php
          while($row3 = mysqli_fetch_assoc($firstChange)) {
              echo " [ '".$row3["pc_name"]."', ".$row3["big_low"].", 'color: ".random_color()."'],";
          }
         ?>
      ]);

      var options = {'title':'En Çok Tercih Edilen Kategoriler',
      'backgroundColor': 'transparent',
      'margin': "0",
      legend : 'none',

      hAxis: {
        title: 'Kategoriler',
        textStyle : {
            fontSize: 11
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

    <script>
    $(window).resize(function(){
      drawChart1();
      drawChart2();
      drawChart3();
    });
    </script>
