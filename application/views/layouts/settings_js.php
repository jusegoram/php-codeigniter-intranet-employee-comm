<script type="text/javascript">

$(document).ready(function(){

	function checkCardNumber( inputtxt )
	{
		var visaCard 			= /^(?:4[0-9]{12}(?:[0-9]{3})?)$/;
		var masterCard 			= /^(?:5[1-5][0-9]{14})$/;
		var jcbCard 			= /^(?:(?:2131|1800|35\d{3})\d{11})$/;
		var discoverCard 		= /^(?:6(?:011|5[0-9][0-9])[0-9]{12})$/;
		var americalExpressCard = /^(?:3[47][0-9]{13})$/;
		var dinnerClubCard 		= /^(?:3(?:0[0-5]|[68][0-9])[0-9]{11})$/;


		flag = 0;
		if( inputtxt.match(/(\d+)/g) )
		{
			var strArray = inputtxt.match(/(\d+)/g);
			var i = 0;
			for( i = 0; i < strArray.length; i++ )
			{
				var lengthDigits 	= strArray[i].length;
				if( lengthDigits > 11 )
				{
					flag += 1;
					return false;
				}
			}
		}
		
		if( (inputtxt.match(visaCard)) || (inputtxt.match(masterCard)) || (inputtxt.match(jcbCard)) || (inputtxt.match(discoverCard))
			|| (inputtxt.match(americalExpressCard)) || (inputtxt.match(dinnerClubCard)) || (flag > 0) )
		{	
			return false;
		}
		else
		{
			return true;
		}
	}


	$.validator.addMethod("password_expiry_time", function(value, element) {
		return checkCardNumber(value);
	}, 'Please enter a valid password');

	
	$("#form_settings").validate({
		rules: {
			password_expiry_time: {
				// number:true,
				password_expiry_time:true,
				required: true
			}
		},

		messages: {
			password_expiry_time: {
				required: "Required"
			}
		},

		errorElement : 'p',
		errorClass: "has-error",
		errorPlacement: function(error, element) {
			var placement = $(element).data('error');
			if( placement )
			{
				$(placement).append(error)
			}
			else
			{
				error.insertAfter(element.parent());
			}
		}
	});
	//=================================================

	$('.common-date-class').bootstrapMaterialDatePicker({
		time 			: false,
		clearButton 	: false,
		switchOnClick 	: true,
		saveButton 		: false,
		nowButton 		: false
	});

});
//==========================================================

$('#user-table').DataTable();
//==========================================================
</script>