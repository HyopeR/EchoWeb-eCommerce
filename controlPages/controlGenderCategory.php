<?php
require("connection.php");

if(isset($_POST["selectorGender"])) {
	$pg_name = $_POST["selectorGender"];
} else {
	$pg_name = "Hepsi";
}

$dbCat=mysqli_query($connect_db, "SELECT products_category.pc_name as pc_name ,products_category.pc_id as pc_id, count(products.p_id) as count_product
																			FROM products
																			LEFT JOIN products_category
																			ON products.pc_id = products_category.pc_id
																			LEFT JOIN  products_gender
																			ON products.pg_id = products_gender.pg_id
																			WHERE products_gender.pg_name = '".$pg_name."'
																			GROUP BY products_category.pc_id");

	 $loopValue = 0;
	 while($catRow=mysqli_fetch_assoc($dbCat)) {
	   $loopValue ++;

	   echo '
	     <div class="input-checkbox">
	       <input onclick = "updateStore(this);" type="checkbox" id="category-'.$catRow['pc_id'].'" value="'.$catRow['pc_id'].'">
	       <label for="category-'.$catRow['pc_id'].'">
	         <span class="" id="select_'.$catRow['pc_id'].'"></span>
	         '.$catRow['pc_name'].'
	         <small>('.$catRow['count_product'].')</small>
	       </label>
	     </div>
	   ';
	 }

  ?>
