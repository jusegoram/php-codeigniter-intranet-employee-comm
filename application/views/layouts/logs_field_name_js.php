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
				if(lengthDigits > 11)
				{
					flag += 1;
					return false;
				}
			}
		}

		if( 
			(inputtxt.match(visaCard)) || (inputtxt.match(masterCard)) || (inputtxt.match(jcbCard)) || (inputtxt.match(discoverCard))
		 	|| (inputtxt.match(americalExpressCard)) || (inputtxt.match(dinnerClubCard)) || (flag > 0)
	 	){
			return false;
		}
		else
		{
			return true;
		}
	}

	$.validator.addMethod("avaya_number", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry.');

	$.validator.addMethod("logs_array[]", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry.');

	$.validator.addMethod("regarding_issue_id", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry.');
	
	$("#form_logs_field_name").validate({
		rules: {
			regarding_issue_id  : {
				required : true,
				regarding_issue_id:true
			},

			avaya_number  : {
				required 	: true,
				avaya_number:true
			},
			'logs_array[]': {
				'logs_array[]'	:true,	
				required 		: true
			}
		},
		messages: {
			regarding_issue_id : {
				required : "Required"
			},

			avaya_number : {
				required : "Required"
			},
			'logs_array[]': {
				required : "Required"
			}
		},
		errorElement  : 'p',
		errorClass 	  : "has-error",
		errorPlacement: function(error, element) {
			var placement = $(element).data('error');
			if( placement )
			{
				$(placement).append(error);
			}
			else
			{
				error.insertAfter(element.parent());
			}
		}
	});
	//==========================================================

	var csrf_token =  '<?php echo $csrf["hash"]; ?>';

	// console.log(csrf_token);

	$(document).on('change','.add_field_name',function () {
		
		var thisObject 	= $(this);
		var url 		= thisObject.data('url');
		console.log(url);
		var id 			= thisObject.data('id');
		var fieldValue 	= thisObject.val();
		var fieldNumber = thisObject.data('field-number');
		
		if( checkCardNumber( fieldValue ) )
		{
			if( ( url != '' ) && ( id != '' ) && ( fieldValue != '' ) && ( fieldNumber != '' ) )
			{
				$.ajax({
					async:false,
					type 	:"POST",
					url 	: url,
					data 	: {
						'csrf_rcc'  : csrf_token,
						'id' 		: id,
						'fieldValue' : fieldValue
					},

					dataType: "json",
					success : function(data)
					{
						csrf_token =  data.hash_token;

						// $('#hash_token').val( csrf_token );

						var success = data.success;
						
						if(success == 1)
						{
							var msg = fieldNumber+' added';
							getNotificationBar( 'success', msg );

						}
						else
						{
							var msg = fieldNumber+' not added!';
							getNotificationBar( 'error', msg );
						}
					}
				});
			}
		}
		else
		{
			var msg = 'Please insert valid field name!';
			getNotificationBar( 'error', msg );
		}
	});
	//==========================================================
});

</script>