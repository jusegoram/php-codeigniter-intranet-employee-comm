$(document).ready(function(){

	//getNotificationBar( 'info', 'Hello Message' );

	var notification_config = {
		autoDismiss: true,
		autoLinkClass: true,     // onDraw callback
		dismissTimeout: 3000,    // 3 Seconds
		dismissEffect: "slide",  // Slide away: (slide, fade)
		dismissSpeed: "fast",    // Dismiss speed: (slow, fast)
		onDraw: null,            // onDraw callback
		onDismiss: null          // onDismiss callback
	};

	
	$(document).on('click', '.remove_record', function(e){
		e.preventDefault();

		var thisObj 	= $(this);
		var id 			= thisObj.data('id');
		var url 		= thisObj.data('url');
		
		var dataString = 'id=' + id;

		bootbox.confirm("Are you sure want to delete record?", function(result) {
		  	
			if(result == true){
		  		removeRecords(thisObj, url, dataString);
		  	}

		}); 
		
		return false;
	});
	//==========================================================

});


/*
List of Functions
*/

function removeRecords(thisObj, url, dataString){

	$.ajax({

		url 		: url,
		type 		: 'post',
		data 		: dataString,
		dataType	: 'json',
		success 	: function(data){

			if( data.is_success == 1){
				
				thisObj.parents('tr').hide('slow');

				getNotificationBar( 'success', data.message );

			} else {
				getNotificationBar( 'danger', data.message );
			}

		}

	});
}
//==========================================================

function getNotificationBar( type, message ){

	//console.log(type);

	switch(type){
		
		case 'success' :
			notificationBackColor = '#2ECC71'; 
			break;

		case 'warning' :
			notificationBackColor = '#E67E22'; 
			break;

		case 'error' :
			notificationBackColor = '#E74C3C'; 
			break;

		case 'info' :
			notificationBackColor = '#3498DB'; 
			break;

		default :
			notificationBackColor = '#2ECC71'; 
			break;

	}
	
	$("body").overHang({
	  col: notificationBackColor,
	  message: message,
	  closeConfirm: true
	});
	
}
//==========================================================

// $(document).on('blur','#employee_id',function(){

// 	var emp_id = $(this).val();
// 	checkCardNumber(emp_id);
// });

// function checkCardNumber(inputtxt)
// {
// 	if(inputtxt.match(/^\d+$/)) {
// 		var lengthDigits 	= inputtxt.length;
// 	}
// 	var visaCard 			= /^(?:4[0-9]{12}(?:[0-9]{3})?)$/;
// 	var masterCard 			= /^(?:5[1-5][0-9]{14})$/;
// 	var jcbCard 			= /^(?:(?:2131|1800|35\d{3})\d{11})$/;
// 	var discoverCard 		= /^(?:6(?:011|5[0-9][0-9])[0-9]{12})$/;
// 	var americalExpressCard = /^(?:3[47][0-9]{13})$/;
// 	var dinnerClubCard 		= /^(?:3(?:0[0-5]|[68][0-9])[0-9]{11})$/;
	
// 	if( (inputtxt.match(visaCard)) || (inputtxt.match(masterCard)) || (inputtxt.match(jcbCard)) || (inputtxt.match(discoverCard)) || (inputtxt.match(americalExpressCard)) || (inputtxt.match(dinnerClubCard)))
// 	{
// 		//console.log('false');
// 		return false;

// 	}else{

// 		//console.log('true');
// 		return true;		
// 	}	
// }

//==========================================================

