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

	$.validator.addMethod("regarding_issue_id", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry.');

	$.validator.addMethod("logs_array1", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry.');
	
	$("#form_logs").validate({
		rules: {
			regarding_issue_id  : {
				required : true,
				regarding_issue_id:true
			},

			<?php 
			$i = 0;
			foreach ($all_field_name as $value) { 
				if( $i == 0 ) { ?> 

					'logs_array[FIELD_ONE]': {
						logs_array1 : true,
						required 	: true
					},
				<?php } else { ?>

					'logs_array[<?php echo $value->field_title; ?>]': {
						logs_array1 : true
					},

				<?php } $i++; ?>
			<?php } ?>

			avaya_number  : {
				required 	: true,
				avaya_number:true
			}
		},
		messages: {
			regarding_issue_id : {
				required : "Required"
			},

			'logs_array[FIELD_ONE]': {
				required 	: "Required"
			},

			avaya_number : {
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
	
	// $('#logs-table').DataTable();
	$('#logs-table').DataTable({
		"processing": true,
		"serverSide": true,
		"bLengthChange": true,
		
		"language": {
			"emptyTable":"No Record Found."
		},

		"ajax": {
			
			url: "<?php echo site_url('logs/pagination'); ?>"
			
			, type: "POST"
			
			, dataSrc: function ( json ) {

				$('meta[name=csrf_rcc]').attr("content", json.hash_token );
				return json.data;
			}

			, data: function( d ){
				d.csrf_rcc = $('meta[name=csrf_rcc]').attr("content");
			}
			
		}

		, "columns": [
			{ "data": "id", "searchable":false, "orderable":false, "class": "mdl-data-table__cell--non-numeric"},
			{ "data": "first_name", "class": "mdl-data-table__cell--non-numeric"},
			{ "data": "avaya_number", "class": "mdl-data-table__cell--non-numeric"},
			{ "data": "issue_name", "class": "mdl-data-table__cell--non-numeric"},
			{ "data": "created_date", "class": "mdl-data-table__cell--non-numeric"},
			{
				"data": "action",
			  	"searchable":false,
			  	"orderable":false,
		  		"class": "mdl-data-table__cell--non-numeric",
		  		mRender: function (nRow, aData, iDisplayIndex) { 
				  	var rowData 	= nRow.split('~');
				  	var site_url 	= rowData[0];
				  	var id 			= rowData[1];
				  	var user_type 	= rowData[2];
				  	var view_icon 	= '<a href=' + site_url + '/details/'+id+'  title="View/Comment"><i class="material-icons">visibility</i></a>';
				  	var delete_icon = '<a class="delete_data" href="javascript:void(0);" data-url=' + site_url + '/remove  data-id=' + id +' title="Delete"><i class="tiny material-icons" title="Delete">delete</i></a>';

				  	return ( ( 3 == user_type ) || ( 4 == user_type ) ) ? view_icon + delete_icon : view_icon;
				}
			}
		]

		, "order": [[ 4, "desc" ]]
		, "pageLength": 10
		, "bAutoWidth": false // Disable the auto width calculation,
	});
	//==========================================================

	$('.common-date-class').bootstrapMaterialDatePicker({
		time 		  : false,
		clearButton	  : false,
		switchOnClick : true,
		saveButton 	  : false,
		nowButton 	  : false
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
	// 			addDiv += '<input class="mdl-textfield__input" id="push" type="text" name="logs_array[FIELD_ONE]" value="" >';
	// 			addDiv += '</div>';

	// 		$(addDiv).insertBefore("#add-logs");
	// 	}
	// 	logNumber += 1;
	// 	// $("#append-logs").append('<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><label class="mdl-textfield__label" for="log_one">Log 1</label><input class="mdl-textfield__input" type="text" name="logs_array[FIELD_ONE]" value="" ></div>');
	// });
	//==========================================================
});

</script>