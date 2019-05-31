$('#searchButton').click(function() {
  if (searchCat.value == 0 || searchInput.value == "") {
		alert("Lütfen kategoriyi ve arayacağınız kelimeyi giriniz.");
	} else {
		const searchForm = document.getElementById("searchForm");
		searchForm.submit();
	}
});

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
			url: "http://localhost/controlPages/controlOrderLists.php",
			data: { hiddenOrderId: valueSelect},
		}).done(function( orderListResult ) {
			orderWrapper.innerHTML = orderListResult;
		});
	} else {
		console.log("Zaten buradasın.");
	}
};


$('#addOrder').click(function() {
  if (hiddenCartId.value == "null") {
		alert("Sepetiniz boş.")
	} else {
		$.ajax({
			type: "POST",
			url: "http://localhost/controlPages/controlAddOrder.php",
			data: { hiddenUserId: hiddenUserId.value, hiddenCartId: hiddenCartId.value},
		}).done(function( regResult ) {
			window.location = "http://localhost/templatePages/mainPages/usersorderLists.php";
		});
	}
});


function updateStore(elem){
	let lastSelect = document.getElementById("selector");
	let clearSelector = "category-"+lastSelect.value;
	let clickedAuto = document.getElementById(clearSelector);
	clickedAuto.checked = false;

	let valueSelect = $(elem).attr('value');
	let newSelector = "category-"+valueSelect;
	let clickedNew = document.getElementById(newSelector);
	if(clickedNew.checked = false) {
		clickedNew.checked = true;
	} else {
		clickedNew.checked = true
	}

	lastSelect.value = valueSelect;

	if(clickedAuto.value == valueSelect) {
		console.log("Zaten buradasın.");
	} else {
		$.ajax({
			type: "POST",
			url: "http://localhost/controlPages/updateStore.php",
			data: { valueSelect: valueSelect},
		}).done(function( updateResult ) {
			const main_view = document.getElementById("store_main_view");
			main_view.innerHTML = updateResult;
		});
	};
};

function cartItemDelete(elem){
  let valueSelect = $(elem).attr('value');

  let itemSelect = 'cart-view-'+valueSelect;
  let itemWrapper = document.getElementById(itemSelect);

  let selectPrice = 'cart-item-price-'+valueSelect;
  let priceWrapper = document.getElementById(selectPrice);

  let selectCartInput = 'cart2_id_'+valueSelect;
  let cartItem = document.getElementById(selectCartInput);

  let selectProductInput = 'product2_id_'+valueSelect;
  let productItem = document.getElementById(selectProductInput);

  let selectBodyInput = 'body2_id_'+valueSelect;
  let bodyItem = document.getElementById(selectBodyInput);

  let selectCartValue = document.getElementById("cartview-value");
  let selectCartTotal = document.getElementById("cartview-total");

  let resultTotal = parseFloat(selectCartTotal.innerText) - parseFloat(priceWrapper.innerText);
  resultTotal = Math.round(resultTotal*100)/100;
  let resultInt = parseInt(selectCartValue.innerText) - 1;

    $.ajax({
      type: "POST",
      url: "http://localhost/controlPages/deleteCartItem.php",
      data: { cart_id: cartItem.value, product_id: productItem.value, body_id: bodyItem.value },
    }).done(function( deletePostResult ) {
      selectCartValue.innerText = resultInt;
      selectCartTotal.innerText = resultTotal;
      if (selectCartTotal <= 0) { selectCartTotal.innerText = 0}
      itemWrapper.parentNode.removeChild(itemWrapper);
    });
};


function itemDelete(elem){
  let valueSelect = $(elem).attr('value');

  let itemSelect = 'product-widget-'+valueSelect;
  let itemWrapper = document.getElementById(itemSelect);

  let selectPrice = 'item-price-'+valueSelect;
  let priceWrapper = document.getElementById(selectPrice);

  let selectCartInput = 'cart_id_'+valueSelect;
  let cartItem = document.getElementById(selectCartInput);

  let selectProductInput = 'product_id_'+valueSelect;
  let productItem = document.getElementById(selectProductInput);

  let selectBodyInput = 'body_id_'+valueSelect;
  let bodyItem = document.getElementById(selectBodyInput);

  let selectCartValue = document.getElementById("cart_value");
  let selectCartTotal = document.getElementById("cart_total");
  let qtyValue = document.getElementById("qty-value");

  let resultTotal = parseFloat(selectCartTotal.innerText) - parseFloat(priceWrapper.innerText);
  resultTotal = Math.round(resultTotal*100)/100;
  let resultInt = parseInt(selectCartValue.innerText) - 1;

    $.ajax({
      type: "POST",
      url: "http://localhost/controlPages/deleteCartItem.php",
      data: { cart_id: cartItem.value, product_id: productItem.value, body_id: bodyItem.value },
    }).done(function( deletePostResult ) {
      selectCartValue.innerText = resultInt;
      qtyValue.innerText = resultInt;
      selectCartTotal.innerText = resultTotal;
      if (selectCartTotal <= 0) { selectCartTotal.innerText = 0}
      itemWrapper.parentNode.removeChild(itemWrapper);
    });
};

$('#regSeller').click(function() {
  if (reg_s_name.value != "" && reg_s_email.value != "" && reg_s_password.value != "" && reg_s_key.value != "") {
      $.ajax({
        type: "POST",
        url: "http://localhost/controlPages/controlSellerRegister.php",
        data: { reg_s_name: reg_s_name.value, reg_s_email: reg_s_email.value, reg_s_password: reg_s_password.value, reg_s_key: reg_s_key.value},
      }).done(function( regResult ) {
          if (regResult[0] == 1) {
            let resulSplit = regResult.split('-');
            let logUser = resulSplit[1];
            window.location = logUser;
          } else if (regResult[0] == 0) {
             alert( "Bu email ile mağaza hesabı bulunmaktadır.");
          }
      });
    } else {
      alert("Bu alanlar zorunludur!")
    }
  });

  $('#logSellerRequest').click(function() {
  	if (seller_email.value != "" && seller_password.value != "") {
  		$.ajax({
  			type: "POST",
  			url: "http://localhost/controlPages/controlSellerLogin.php",
  			data: { seller_email: seller_email.value, seller_password: seller_password.value  },
  		}).done(function( logResult ) {
  				if (logResult[0] == 1) {
  					let resulSplit = logResult.split('-');
  					let logUser = resulSplit[1];
  					window.location = logUser;
  				} else if (logResult[0] == 0) {
  					 alert( "Böyle bir hesap bulunumadı!");
  				}
  		});
  	} else {
  		alert("Bu alanlar boş bırakılamaz.")
  	}
  });

$('#userRegister').click(function() {
  if (regEmail.value != "" &&
			regPassword.value != "" &&
			regName.value != "" &&
			regSurname.value != "" &&
			regDay.value != "" &&
			regMonth.value != "" &&
			regYear.value != "" &&
			regGender.value != "" &&
			regCity.value != "" &&
			regChildCity.value != "" &&
			regAddress.value != "" &&
			regNumber.value != "") {
      $.ajax({
        type: "POST",
        url: "http://localhost/controlPages/controlRegister.php",
        data: {
					regEmail: regEmail.value,
					regPassword: regPassword.value,
					regName: regName.value,
					regSurname: regSurname.value,
					regDay: regDay.value,
					regMonth: regMonth.value,
					regYear: regYear.value,
					regGender: regGender.value,
					regCity: regCity.value,
					regChildCity: regChildCity.value,
					regAddress: regAddress.value,
					regNumber: regNumber.value
				},
      }).done(function( regResult ) {
          if (regResult[0] == 1) {
            let resulSplit = regResult.split('-');
            let logUser = resulSplit[1];
            window.location.assign(logUser);
          } else if (regResult[0] == 0) {
             alert( "Bu email ile hesap bulunmaktadır.");
          }
      });
    } else {
      alert("Bu alanlar zorunludur!")
    }
  });

  $('#logUserRequest').click(function() {
  	if (user_email.value != "" && user_password.value != "") {
  		$.ajax({
  			type: "POST",
  			url: "http://localhost/controlPages/controlLogin.php",
  			data: { user_email: user_email.value, user_password: user_password.value  },
  		}).done(function( logResult ) {
  				if (logResult[0] == 1) {
  					let resulSplit = logResult.split('-');
  					let logUser = resulSplit[1];
  					window.location.assign(logUser);
  				} else if (logResult[0] == 0) {
  					 alert( "Böyle bir hesap bulunumadı!");
  				}
  		});
  	} else {
  		alert("Bu alanlar boş bırakılamaz.")
  	}
  });
