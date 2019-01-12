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
				console.log(lengthDigits+' '+flag);
				if( lengthDigits > 11 )
				{
					flag += 1;
					return false;
				}
			}
		}

		if( (inputtxt.match(visaCard)) || (inputtxt.match(masterCard)) || (inputtxt.match(jcbCard)) || (inputtxt.match(discoverCard))
			|| (inputtxt.match(americalExpressCard)) || (inputtxt.match(dinnerClubCard)) || (flag > 0))
		{	
			return false;
		}
		else
		{
			return true;		
		}	
	}


	$.validator.addMethod("welcome_quote", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry.');


	$("#form_welcome_quotes").validate({
		rules: {
			
			welcome_quote: {
				required: true,
				welcome_quote:true
			},

			welcome_quote_date: {
				required: true
			}
		},
		
		messages: {
			
			welcome_quote: {
				required: "Required"
			},

			welcome_quote_date: {
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
	
	$('.common-date-class').bootstrapMaterialDatePicker({
		time 			: false,
		clearButton 	: false,
		switchOnClick 	: true,
		saveButton 		: false,
		nowButton  		: false,
		minDate 		: new Date()
	});
});
//==========================================================

// $('#welcome_quotes-table').DataTable();
$('#welcome_quotes-table').DataTable({
	"processing": true,
	"serverSide": true,
	"bLengthChange": true,
	
	"language": {
		"emptyTable":"No Record Found."
	},

	"ajax": {
		
		url: "<?php echo site_url('welcome_quotes/pagination'); ?>"
		
		, type: "POST"
		
		, dataSrc: function ( json ) {

			$('meta[name=csrf_rcc]').attr("content", json.hash_token );
			return json.data;
		}

		, data: function( d ){
			d.csrf_rcc = $('meta[name=csrf_rcc]').attr("content");
		}
		
	}
	, fnRowCallback: function( nRow, aData, iDisplayIndex ) {
			$('td', nRow).attr('wrap','wrap');
			return nRow;
		},
	"columns": [
		{ "data": "id", "searchable":false, "orderable":false, "class": "mdl-data-table__cell--non-numeric"},
		{ "data": "welcome_quote", "class": "mdl-data-table__cell--non-numeric", "style":"word-wrap: break-word;"},
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

			  	return ( ( 3 == user_type ) || ( 4 == user_type ) ) ? '<a href=' + site_url + '/edit/'+id+' title="Edit"><i class="tiny material-icons" title="Edit">mode_edit</i></a><a class="delete_data" href="javascript:void(0);" data-url=' + site_url + '/remove  data-id=' + id +' title="Delete"><i class="tiny material-icons" title="Delete">delete</i></a>' : '';
			}
		}
	]

	, "order": [[ 1, "asc" ]]
	, "pageLength": 10
	, "bAutoWidth": false // Disable the auto width calculation,
});
//==========================================================
</script>