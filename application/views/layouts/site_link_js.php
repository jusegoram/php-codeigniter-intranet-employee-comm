<script type="text/javascript">

$(document).ready(function(){

	url_link_id = "";
	
	<?php if( $site_link_id ) : ?>

		url_link_id = '<?php echo ($site_link_id) ? $site_link_id : ''; ?>';
	<?php endif; ?>
	
	// console.log(url_link_id);
	// return false;

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

	$.validator.addMethod("title", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry.');

	$("#form_site_link").validate({
		rules: {
			title: {
				required: true,
				title:true
			},

			url: {
				required: true,
				url:true,
				remote:'<?php echo base_url('site_link/check_unique_site_url');?>/'+url_link_id,
				onkeyup:false
			}

		},
		messages: {
			title: {
				required: "Required"
			},

			url: {
				required: "Required",
				remote:"Site url is already exist."
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

	$("#form_site_link_details").validate({
		rules: {
			employee_comment: {
				required: true
			}
		},
		messages: {
			employee_comment: {
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
	
	// $('#site-link-table').DataTable();
	$('#site-link-table').DataTable({
		"processing": true,
		"serverSide": true,
		"bLengthChange": true,
		
		"language": {
			"emptyTable":"No Record Found."
		},

		"ajax": {
			
			async:false,
			url: "<?php echo site_url('site_link/pagination'); ?>"
			
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
		}

		, "columns": [
			{ "data": "id", "searchable":false, "orderable":false, "class": "mdl-data-table__cell--non-numeric"},
			{ "data": "title", "class": "mdl-data-table__cell--non-numeric"},
			{ "data": "url", "class": "mdl-data-table__cell--non-numeric"}
			<?php if( (3 == $user_session->user_type) || (4 == $user_session->user_type) ) { ?>

			,{
				"data": "action",
			  	"searchable":false,
			  	"orderable":false,
		  		"class": "mdl-data-table__cell--non-numeric",
		  		mRender: function (nRow, aData, iDisplayIndex) {
				  	var rowData 	= nRow.split('~');
				  	var site_url 	= rowData[0];
				  	var id 			= rowData[1];
				  	var user_type 	= rowData[2];

				  	return ( ( 3 == user_type ) || ( 4 == user_type )  ) ? '<a href=' + site_url + '/edit/'+id+' title="Edit"><i class="tiny material-icons" title="Edit">mode_edit</i></a><a class="delete_data" href="javascript:void(0);" data-url=' + site_url + '/remove  data-id=' + id +' title="Delete"><i class="tiny material-icons" title="Delete">delete</i></a>' : '';
				}
			}
			
			<?php } ?>
		]
		
		, "order": [[ 1, "asc" ]]
		, "pageLength": 10
		, "bAutoWidth": false // Disable the auto width calculation,
	});
	//==========================================================
});

</script>