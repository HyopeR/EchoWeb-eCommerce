function orderPage(elem){
	let valueSelect = $(elem).attr('value');
	let hiddenTabInput = document.getElementById("hiddenTabId");
	let centerValue = document.getElementById("centerValue");
	let oldValue = hiddenTabInput.value;
	oldValue = parseInt(oldValue);
	let newValue;

	if (valueSelect == "Next") {
		newValue = oldValue + 1;
	} else if (valueSelect == "Prev") {
		newValue = oldValue - 1;
	}

	if( newValue > 0) {
	  let tabDeselect = "view-tab-"+oldValue;
	  let oldTab = document.getElementById(tabDeselect);
	  oldTab.setAttribute("style", "display:none");

		centerValue.innerHTML = newValue;
	  let tabSelect = "view-tab-"+newValue;
	  let newTab = document.getElementById(tabSelect);
	  newTab.setAttribute("style", "display:block");
	  hiddenTabInput.value = newValue;
	} else {
		console.log("Eleman yok.");
	}
}

function viewOrder(elem){
	let valueSelect = $(elem).attr('value');
	let saveClick = document.getElementById("saveClick");

	if (saveClick.value != valueSelect) {
		if(saveClick.value == "null") {
			saveClick.value = valueSelect;
		} else {
			let removeSelect = 'orderContent-'+saveClick.value;
			let removeOrder = document.getElementById(removeSelect);
			removeOrder.innerHTML = "";
			saveClick.value = valueSelect;
		}

		let orderSelect = 'orderContent-'+valueSelect;
		let orderWrapper = document.getElementById(orderSelect);

		$.ajax({
			type: "POST",
			url: "http://localhost/controlPagesAdmin/seeListOrder.php",
			data: { hiddenOrderId: valueSelect},
		}).done(function( orderListResult ) {
			orderWrapper.innerHTML = orderListResult;
		});
	} else {
		console.log("Zaten buradasın.");
	}
};

function selectMenu(elem){
	let valueSelect = $(elem).attr('value');

  $.ajax({
    type: "POST",
    url: "http://localhost/controlPagesAdmin/createMenuSession.php",
    data: { menuTab: valueSelect },
  })
}

$("#countrySelect").change(function(){
  $.ajax({
    type: "POST",
    url: "http://localhost/controlPagesAdmin/controlCountry.php",
    data: { countrySelect: this.value },
  }).done(function( countryResult ) {
    document.getElementById("country_detail").innerHTML = countryResult;
  });
});

$('#adminLogin').click(function() {
  if (adminEmail.value != "" && adminPass.value != "") {
    $.ajax({
      type: "POST",
      url: "http://localhost/controlPages/controlSellerLogin.php",
      data: { seller_email: adminEmail.value, seller_password: adminPass.value  },
    }).done(function( logResult ) {
        if (logResult[0] == 1) {
          window.location = "http://localhost/admin"
        } else if (logResult[0] == 0) {
           alert( "Böyle bir hesap bulunumadı!");
        }
    });
  } else {
    alert("Bu alanlar boş bırakılamaz.")
  }
});
