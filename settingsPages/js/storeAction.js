$(document).ready(function(){
    $('#hiddenCurrent').submit(currentCategory);
    $('#hiddenCurrentGender').submit(currentGender);
})

function currentCategory(){
	$.ajax({
		url : 'http://localhost/controlPages/updateStore.php',
		type : 'POST',
		data: { valueSelect: selector.value},
		success: function(data){
			// console.log(data);
			const main_view = document.getElementById("store_main_view");
			main_view.innerHTML = data;
		}
	});
	return false;
}

function currentGender(){
	$.ajax({
		url : 'http://localhost/controlPages/controlGenderCategory.php',
		type : 'POST',
		data: { selectorGender: selectorGender.value},
		success: function(data){
      // console.log(data);
      const check_menu = document.getElementById("checkbox-category");
      const drop_menu = document.getElementById("genderCatMenu");
			check_menu.innerHTML = data;
      drop_menu.innerHTML = data;
		}
	});
	return false;
}

window.onload=function(){
	  setTimeout(currentCategory, 0);
    setTimeout(currentGender, 0);
}
