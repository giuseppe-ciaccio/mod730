function populate_data(data) {
	//response = JSON.parse(data);
	
	alert(data);
	
	var response = eval('('+data+')');
	
	if (response.error)
		$('#thep').text(response.error);
	else
		$('#thep').text(response.message);
//    $('address2').value = card.items[0].address2;
//    $('postalcode').value = card.items[0].postalcode;
	
//	alert(response.thevar);
}