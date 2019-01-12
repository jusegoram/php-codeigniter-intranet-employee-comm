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

	$.validator.addMethod("issue_name", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry.');

	$("#form_issue").validate({
		rules: {
			issue_name  : {
				required : true,
				issue_name:true
			}
		},
		messages: {
			issue_name : {
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
	
	// $('#issues-table').DataTable();
	$('#issues-table').DataTable({
		"processing": true,
		"serverSide": true,
		"bLengthChange": true,
		
		"language": {
			"emptyTable":"No Record Found."
		},

		"ajax": {
			
			async:false,
			url: "<?php echo site_url('issues/pagination'); ?>"
			
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
			{ "data": "issue_name", "class": "mdl-data-table__cell--non-numeric"},
			{
				"data": "action",
			  	"searchable":false,
			  	"orderable":false,
		  		"class": "mdl-data-table__cell--non-numeric",
		  		mRender: function (nRow, aData, iDisplayIndex) { 
				  	var rowData 	= nRow.split('~');
				  	var site_url 	= rowData[0];
				  	var id 			= rowData[1];
				  	var is_enabled 	= rowData[2];
				  	var color_class = rowData[3];
				  	
				  	return '<a href=' + site_url + '/edit/'+id+' title="Edit"><i class="tiny material-icons" title="Edit">mode_edit</i></a><a class="check_enabled" href="javascript:void(0);" data-url=' + site_url + '/update data-id=' + id + ' data-is-enabled=' + is_enabled + '><i class="material-icons ' +color_class+ '">fiber_manual_record</i></a>';
				}
			}
		]

		, "order": [[ 1, "asc" ]]
		, "pageLength": 10
		, "bAutoWidth": false // Disable the auto width calculation,
	});

	//==========================================================

	// var csrf_token =  '<?php //echo $csrf["hash"]; ?>';

	// $('.check_enabled').click(function () {

	$(document).on('click', '.check_enabled', function(){

		var url 		= $(this).data('url');
		var thisObject 	= $(this);
		var id 			= thisObject.data('id');
		var is_enabled 	= thisObject.data('is-enabled');

		$.ajax({
			async:false,
			type 	:"POST",
			url 	: url,
			data 	: {
				'csrf_rcc'  : $('meta[name=csrf_rcc]').attr("content"),
				'id' : id,
				'is_enabled':is_enabled
				},

			dataType: "json",
			success : function(data)
			{
				$('meta[name=csrf_rcc]').attr("content", data.hash_token );
				// csrf_token =  data.hash_token;
				var success = data.success;
				// var id 		= data.id;
				if(success == 1)
				{
					if( is_enabled == 1)
					{
						thisObject.data('is-enabled', 0);
						thisObject.find('i').addClass('red-class');
						thisObject.find('i').removeClass('green-class');
						var msg = 'Record Disabled successfully';
						getNotificationBar( 'success', msg );
					}
					else
					{
						thisObject.data('is-enabled',1);
						thisObject.find('i').addClass('green-class');
						thisObject.find('i').removeClass('red-class');
						var msg = 'Record Enabled successfully';
						getNotificationBar( 'success', msg );
					}
				}
				else
				{
					var msg = 'Record is not disabled!';
					getNotificationBar( 'error', msg );
				}
			}
		});
	});
	//==========================================================
	// $('#add-issues').click(function () {
		
	// 	var text_var = $('#show-add-issue').html();
		
	// 	showDialog({
	// 		title : 'Add Issue',
	// 		text : text_var
			// title: 'Cancel'
			// 	},
			// positive: {
			// 	title: 'Submit'
			// }
	// 	});
	// });
	//==========================================================
});

</script>