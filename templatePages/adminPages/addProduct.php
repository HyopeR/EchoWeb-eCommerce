<?php require("adminSettingsTop.php"); ?>
<?php require("adminDesignTop.php"); ?>
<?php require("../.././controlPages/connection.php"); ?>
<h3>Ürünler ► Ürün Ekle</h3>
  <hr class="userspage-hr">

<div class="col-md-12">
  <p id="detail-add-product">
    <?php if(isset($_SESSION["add_detail"])) { echo $_SESSION["add_detail"];} unset($_SESSION['add_detail']);?>
  </p>
</div>

<form name = "product_form" id = "product_form" method = "POST" enctype="multipart/form-data">

	<input class="form-control" name="pro_name" id="pro_name" placeholder="Product Name" type="text">
	<textarea class="form-control" name="pro_content" id="pro_content" placeholder="Product Content" rows="3"></textarea>
	<input class="form-control" name="pro_page" id="pro_page" placeholder="Product Page" type="text">

	<select name='pro_category' id='pro_category' class='form-control'>
    <option value="" disabled="disabled" selected="selected">Ürünün Kategorisini Seçiniz</option>
    <?php
      $allCat = mysqli_query($connect_db, "SELECT * FROM products_category");
      while($cat = mysqli_fetch_assoc($allCat)){
        echo '<option value="'.$cat["pc_id"].'">'.$cat["pc_name"].'</option>';
      }
     ?>
	</select>
	<select name='pro_gender' id='pro_gender' class='form-control'>
		<option>Kadın</option>
		<option>Erkek</option>
	</select>
	<input class="form-control" name="pro_price" id="pro_price" placeholder="Product Price" type="text">

  <div class="type-stock" id="type-1" style="display:none">
	   <input class="form-control type1" id="xs-stock" placeholder="XS Stock" type="text">
     <input class="form-control type1" id="s-stock" placeholder="S Stock" type="text">
     <input class="form-control type1" id="m-stock" placeholder="M Stock" type="text">
     <input class="form-control type1" id="x-stock" placeholder="L Stock" type="text">
     <input class="form-control type1" id="xl-stock" placeholder="XL Stock" type="text">
  </div>
  <div class="type-stock" id="type-2" style="display:none">
    <input class="form-control type2" id="standart-stock" placeholder="Standart Stock" type="text">
  </div>
  <div class="type-stock" id="type-3" style="display:none">
    <input class="form-control type3" id="36-stock" placeholder="36 Stock" type="text">
    <input class="form-control type3" id="37-stock" placeholder="37 Stock" type="text">
    <input class="form-control type3" id="38-stock" placeholder="38 Stock" type="text">
    <input class="form-control type3" id="39-stock" placeholder="39 Stock" type="text">
    <input class="form-control type3" id="40-stock" placeholder="40 Stock" type="text">
    <input class="form-control type3" id="41-stock" placeholder="41 Stock" type="text">
    <input class="form-control type3" id="42-stock" placeholder="42 Stock" type="text">
    <input class="form-control type3" id="43-stock" placeholder="43 Stock" type="text">
    <input class="form-control type3" id="44-stock" placeholder="44 Stock" type="text">
    <input class="form-control type3" id="45-stock" placeholder="45 Stock" type="text">
  </div>

	<div class="custom-file">
    <input type="file" name="pro_media" class="" id="pro_media" aria-describedby="inputGroupFileAddon01">
    <label class="custom-file-label" id="newFileName" for="pro_media">Choose file</label>
	</div>

	<button type="button" id="addProdcut" class="btn btn-outline-success my-2 my-sm-0">Ürün Ekle</button>

</form>

<?php require("adminSettingsBottom.php"); ?>
<?php require("adminDesignBottom.php"); ?>

<script>
let stockType = 0;

$("#pro_category").change(function(){
  document.getElementById("type-1").setAttribute("style", "display:none");
  document.getElementById("type-2").setAttribute("style", "display:none");
  document.getElementById("type-3").setAttribute("style", "display:none");
  let array1 = [1,2,3,4,7,8,19,20];
  let array2 = [5,9,10,11,12,16,17,18];
  let array3= [15];
  if(array1.includes(parseInt(this.value))){
    document.getElementById("type-1").setAttribute("style", "display:block");
    stockType = 1;
  } else if(array2.includes(parseInt(this.value))) {
    document.getElementById("type-2").setAttribute("style", "display:block");
    stockType = 2;
  } else if(array3.includes(parseInt(this.value))) {
    document.getElementById("type-3").setAttribute("style", "display:block");
    stockType = 3;
  }
});

$('#pro_media').change(function () {
  document.getElementById("newFileName").innerHTML = this.files[0]["name"]
});

$('#addProdcut').on('click', function() {
    let stockContent = [];
    let selectType = "type"+stockType;
    let aStock = document.getElementsByClassName(selectType);
    for(let i = 0; i < aStock.length; i++){
      stockContent.push(parseInt(aStock[i].value));
    }
    var file_data = $('#pro_media').prop('files')[0];
    var form_data = new FormData();
    form_data.append('pro_media', file_data);
    form_data.append('pro_name', pro_name.value);
    form_data.append('pro_content', pro_content.value);
    form_data.append('pro_page', pro_page.value);
    form_data.append('pro_category', pro_category.value);
    form_data.append('pro_gender', pro_gender.value);
    form_data.append('pro_price', pro_price.value);
    form_data.append('pro_stock', stockContent);
    $.ajax({
        url: 'http://localhost/controlPagesAdmin/controlAddProducts', // point to server-side PHP script
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'POST',
        success: function( addResult ){
            location.reload();
        }
     });
});

</script>
