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
		
		if( 
			(inputtxt.match(visaCard)) || (inputtxt.match(masterCard)) || (inputtxt.match(jcbCard))
			|| (inputtxt.match(discoverCard)) || (inputtxt.match(americalExpressCard)) || (inputtxt.match(dinnerClubCard)) || (flag > 0)
		){
			return false;
		}
		else
		{
			return true;		
		}	
	}


	$.validator.addMethod("user_id", function(value, element) {
		return checkCardNumber(value);
	}, 'Please enter a valid employee ID.');

	$.validator.addMethod("quality", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry');
	
	$.validator.addMethod("adherence", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry');
	
	$.validator.addMethod("hold_time", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry');

	$.validator.addMethod("transfer_rate", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry');

	$.validator.addMethod("quality_commitment", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry');
	
	$.validator.addMethod("adherence_commitment", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry');
	
	$.validator.addMethod("hold_time_commitment", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry');

	$.validator.addMethod("transfer_rate_commitment", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry');

	$.validator.addMethod("manager_commitment", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry');

	$.validator.addMethod("employee_commitment", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry');

	$.validator.addMethod("add_score", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry');

	$("#form_performance").validate({
		rules: {
			user_id: {
				required: true,
				alphanumeric:true,
				user_id:true
			},

			performance_date: {
				required: true
			},

			quality_commitment: {
				required: true,
				quality_commitment:true
			},

			adherence_commitment: {
				required: true,
				adherence_commitment:true
			},

			hold_time_commitment: {
				required: true,
				hold_time_commitment:true
			},

			transfer_rate_commitment: {
				required: true,
				transfer_rate_commitment: true
			},

			manager_commitment: {
				required: true,
				manager_commitment:true
			}
		},
		messages: {
			user_id: {
				required: "Required"
			},

			performance_date: {
				required: "Required"
			},

			quality_commitment: {
				required: "Required"
			},

			adherence_commitment: {
				required: "Required"
			},

			hold_time_commitment: {
				required: "Required"
			},

			transfer_rate_commitment: {
				required: "Required"
			},

			manager_commitment: {
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
	//==========================================================

	$("#form_score").validate({
		rules: {
			quality: {
				required: true,
				number:true,
				quality:true
			},

			adherence: {
				required: true,
				number:true,
				adherence:true
			},

			hold_time: {
				required: true,
				number:true,
				hold_time:true
			},

			transfer_rate: {
				required: true,
				number:true,
				transfer_rate: true
			}

		},
		messages: {
			quality: {
				required: "Required"
			},

			adherence: {
				required: "Required"
			},

			hold_time: {
				required: "Required"
			},

			transfer_rate: {
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
	//==========================================================

	$("#form_performance_details").validate({
		rules: {
			employee_commitment: {
				employee_commitment:true,
				required: true
			}
		},
		messages: {
			employee_commitment: {
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
	//==========================================================

	$(document).on('click', '.submit_performance', function(){

		if($("form#form_performance_details").valid()) {

			if(!$('#is_accepted').is(':checked')) {
				
				showDialog({
					text: 'You must agree with the terms and conditions!',
					positive: {
						title: 'Ok'
					}
				});
				return false;
			}
			$("form#form_performance_details").submit();
		} else {

			return false;
		}
	});
	//==========================================================	

	$('#performance-table').DataTable({
		"processing": true,
		"serverSide": true,
		"bLengthChange": true,
		
		"language": {
			"emptyTable":"No Record Found."
		},

		"ajax": {
			
			async:false,
			url: "<?php echo site_url('performance/pagination'); ?>"
			
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
			{ "data": "performance_date", "class": "mdl-data-table__cell--non-numeric"},
			{ "data": "quality_commitment", "class": "mdl-data-table__cell--non-numeric"},
			{ "data": "adherence_commitment", "class": "mdl-data-table__cell--non-numeric"},
			{ "data": "hold_time_commitment", "class": "mdl-data-table__cell--non-numeric"},
			{ "data": "transfer_rate_commitment", "class": "mdl-data-table__cell--non-numeric"},
			{ "data": "is_accepted", "class": "mdl-data-table__cell--non-numeric"},
			
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
				  	var edit_icon 	= '<a href=' + site_url + '/edit/'+id+' title="Edit"><i class="tiny material-icons" title="Edit">mode_edit</i></a>';
				  	var delete_icon = '<a class="delete_data" href="javascript:void(0);" data-url=' + site_url + '/remove  data-id=' + id +' title="Delete"><i class="tiny material-icons" title="Delete">delete</i></a>';
				  	var view_icon  	= '<a href=' + site_url + '/details/'+id+'  title="View/Comment"><i class="material-icons">visibility</i></a>'; 

				  	return ( ( 3 == user_type ) || ( 4 == user_type ) ) ? edit_icon + delete_icon + view_icon : ( (1 == user_type) || (5 == user_type) || (6 == user_type) ) ? edit_icon + view_icon : view_icon;
				}
			}
		]

		, "order": [[ 2, "desc" ]]
		, "pageLength": 10
		, "bAutoWidth": false // Disable the auto width calculation,
	});
	//==========================================================

	$('#performance-score-table').DataTable({
		"bPaginate"	: false,
		"bFilter"	: false,
		"bInfo"		: false
	});

	//==========================================================

	$('.common-date-class').bootstrapMaterialDatePicker({
		time 			: false,
		clearButton 	: false,
		switchOnClick 	: true,
		saveButton 		: false,
		nowButton 		: false
	});
	//==========================================================
	
	$( ".get-score" ).keyup(function() {
		var dInput = Number($('#quality').val()) + Number($('#adherence').val()) + Number($('#hold_time').val()) + Number($('#transfer_rate').val());
		if( !isNaN(dInput) )
		{
			$("#add_score").empty();
			$( "#set-focused" ).addClass( "is-focused" );
			$("#add_score").val(dInput);
			// console.log(dInput);
		}
	});
	//==========================================================
	
	$(document).on('click', function(){
		if( $( "#add_score" ).val() )
		{
			$( "#set-focused" ).addClass( "is-focused" );
		}
	});
});	
//==========================================================
</script>