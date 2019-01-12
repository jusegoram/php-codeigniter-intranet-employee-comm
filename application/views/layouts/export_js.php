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

	$.validator.addMethod("date_start", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry.');

	$.validator.addMethod("date_end", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry.');

	$.validator.addMethod("regarding_issue_id", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry.');
	
	$("#form_export_logs").validate({
		rules: {
			regarding_issue_id  : {
				required : true,
				regarding_issue_id:true
			},

			date_start  : {
				required 	: true,
				date_start:true
			},
			date_end: {
				date_end	:true,	
				required	: true
			}
		},
		messages: {
			regarding_issue_id : {
				required : "Required"
			},

			date_start : {
				required : "Required"
			},
			date_end: {
				required : "Required"
			}
		},
		errorElement  : 'p',
		errorClass 	  : "has-error",
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
	//==========================================================
	
	$('#logs-table').DataTable();
	//==========================================================

	$('.common-date-class').bootstrapMaterialDatePicker({
		time 		  : false,
		clearButton	  : false,
		switchOnClick : true,
		saveButton 	  : false,
		nowButton 	  : false
	});
	//==========================================================

	$('#date_end').bootstrapMaterialDatePicker({
		weekStart 	  : 0,
		time 		  : false,
		clearButton	  : false,
		switchOnClick : true,
		saveButton 	  : false,
		nowButton 	  : false
	});
	$('#date_start').bootstrapMaterialDatePicker({
		weekStart 	  : 0,
		time 		  : false,
		clearButton	  : false,
		switchOnClick : true,
		saveButton 	  : false,
		nowButton 	  : false
	}).on('change', function(e, date)
	{
		$('#date_end').bootstrapMaterialDatePicker('setMinDate', date);
	});

	//==========================================================
	// $(".add-focuced").click(function () {
	// 	console.log('aSA');

	// });

	// $(document).on('click','.mdl-textfield',function(){

	// 		if($('.mdl-textfield:focus'))
	// 		{
	// 			alert('focus')
	// 			$(this).addClass('is-focused');	

	// 		}else{
	// 			alert('not focus')
	// 			$(this).removeClass('is-focused');
	// 		}
			
		
		

	// });

	
	// var logNumber 	= 1;
	// $("#add-logs").click(function () {


	// 	if( logNumber < 10 )
	// 	{
	// 		var addDiv 	= '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">';
	// 			addDiv += '<label class="mdl-textfield__label" for="push">';
	// 			addDiv += 'Log'+logNumber;
	// 			addDiv += '</label>';
	// 			addDiv += '<input class="mdl-textfield__input" id="push" type="text" name="logs_array[]" value="" >';
	// 			addDiv += '</div>';

	// 		$(addDiv).insertBefore("#add-logs");
	// 	}
	// 	logNumber += 1;
	// 	// $("#append-logs").append('<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><label class="mdl-textfield__label" for="log_one">Log 1</label><input class="mdl-textfield__input" type="text" name="logs_array[]" value="" ></div>');
	// });
	//==========================================================
});

</script>