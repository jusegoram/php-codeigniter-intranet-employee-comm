<script type="text/javascript">

$(document).ready(function()
{
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

	$.validator.addMethod("document_name", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry.');

	$.validator.addMethod("manager_comment", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry.');

	$.validator.addMethod("employee_comment", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry.');

	$.validator.addMethod("notification_text", function(value, element) {
		return checkCardNumber(value);
	}, 'Invalid Entry.');

	$.validator.setDefaults({ ignore: ":hidden:not(select)" });
	$("#form_notifications").validate({
		rules: {
			'user_id[]': {
				required: true
			},

			notification_type: {
				required: true
			},

			notification_date: {
				required: true
			},

			document_name: {
				required: true,
				alphanumeric:true,
				document_name:true
			},

			notification_text: {
				required: function(){
	                if($('#file_name').val()=="")
	                    return true;
	                else
	                    return false;
            	},
            	notification_text: true
			},

			file_name: {
				required: function() {
            		if($('#notification_text').val()=="")
	                    return true;
	                else
	                    return false;
            	},
				extension: "pdf|mp4"
			},

			status_date: {
				required: true
			},

			manager_comment: {
				manager_comment: true,
				required: true
			}
		},
		messages: {
			'user_id[]': {
				required: "Required"
			},

			notification_type: {
				required: "Required"
			},

			notification_date: {
				required: "Required"
			},

			document_name: {
				required : "Required"
			},

			notification_text: {
				required: "Required"
			},

			file_name: {
				required : "Required",
				extension: "Please upload only pdf file"
			},

			status_date : {
				required : "Required"
			},
			manager_comment: {
				required : "Required"
			}
		},
		errorElement 	: 'p',
		errorClass 		: "has-error",
		errorPlacement 	: function(error, element) {
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

	$("#edit_form_notifications").validate({
		rules: {
			
			notification_type: {
				required: true
			},

			notification_date: {
				required: true
			},

			document_name: {
				required: true,
				alphanumeric:true,
				document_name:true
			},

			notification_text: {
				required: function(){
	                if(($('#file_name').val()=="") && ($('#uploaded_file').val()==""))
	                    return true;
	                else
	                    return false;
            	},
            	notification_text: true
			},

			file_name: {
				required: function() {
            		if(($('#uploaded_file').val()=="") && ($('#notification_text').val()==""))
	                    return true;
	                else
	                    return false;
            	},
            	extension: "pdf|mp4"
			},

			manager_comment: {
				manager_comment: true,
				required: true
			}
		},
		messages: {
			
			notification_type: {
				required: "Required"
			},

			notification_date: {
				required: "Required"
			},

			document_name: {
				required : "Required"
			},

			notification_text: {
				required: "Required"
			},

			file_name: {
				required : "Required",
				extension: "Please upload only pdf file"
			},

			status_date : {
				required : "Required"
			},
			manager_comment: {
				required : "Required"
			}
		},
		errorElement 	: 'p',
		errorClass 		: "has-error",
		errorPlacement 	: function(error, element) {
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

	$("#form_notification_details").validate({
		rules: {

			employee_comment: {
				employee_comment:true,
				required: true
			},

			manager_comment: {
				manager_comment:true,
				required: true
			}
		},
		messages: {
			employee_comment: {
				required: "Required"
			},
			manager_comment: {
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
				$('p#is_accepted-error').css('margin-top', 'auto');
			}
		}
	});
	//==========================================================

	$(document).on('click', '.submit_notification', function(){

		if($("form#form_notification_details").valid()) {

			if(!$('#is_accepted').is(':checked')) {
				
				showDialog({
					text: 'You must agree with the terms and conditions!',
					positive: {
						title: 'Ok'
					}
				});
				return false;
			}
			$("form#form_notification_details").submit();
		} else {

			return false;
		}
	});
	//==========================================================

	$(document).on('click', '.submit_notification_form', function(){

		if($("form#form_notifications").valid()) {
			
			$("form#form_notifications").submit();
			$(".submit_notification_form").attr('disabled','disabled');
			$(this).removeClass('submit_notification_form');
		} else {

			return false;
		}
	});
	//==========================================================
	
	var checkUserId = '<?php echo $user_session->id; ?>';
	var checkUserType = '<?php echo $user_session->user_type; ?>';

	
	// $('#notification-table').DataTable();
		$('#notification-table').DataTable({
		"processing": true,
		"serverSide": true,
		"bLengthChange": true,
		
		"language": {
			"emptyTable":"No Record Found."
		},

		"ajax": {
			
			async:false,
			url: "<?php echo site_url('notification/pagination'); ?>"
			
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
			{ "data": "notification_type", "class": "mdl-data-table__cell--non-numeric"},
			{ "data": "notification_date", "class": "mdl-data-table__cell--non-numeric"},
			{ "data": "document_name", "class": "mdl-data-table__cell--non-numeric"},
			{ "data": "submit_first_name", "class": "mdl-data-table__cell--non-numeric"},
			{ "data": "is_accepted", "class": "mdl-data-table__cell--non-numeric"},
			
			{
				"data": "action",
			  	"searchable":false,
			  	"orderable":false,
		  		"class": "mdl-data-table__cell--non-numeric",
		  		mRender: function (nRow, aData, iDisplayIndex) { 
				  	var rowData = nRow.split('~');
				  	var site_url = rowData[0];
				  	var id 		= rowData[1];
				  	var user_type 	= rowData[2];
				  	var is_accepted = rowData[3];
				  	var is_global 	= rowData[4];
				  	var global_url = rowData[5];
				  	var submittedBy = rowData[6];
				  	
				  	// console.log(user_type);
				  	// var td_start 	= '<td class="mdl-data-table__cell--non-numeric" >';
					
					var edit_icon = '';
				  	if( ( checkUserId == submittedBy ) || ( 3 == checkUserType ) || ( 4 == checkUserType ) ){

				  		edit_icon 	= '<a href=' + site_url + '/edit/'+id+' title="Edit"><i class="tiny material-icons" title="Edit">mode_edit</i></a>';
				  	}
				  	var delete_icon = '<a class="delete_data" href="javascript:void(0);" data-url=' + site_url + '/remove data-id=' + id +' title="Delete"><i class="tiny material-icons" title="Delete">delete</i></a>';
				  	
				  	var view_icon 	= '<a href=' + site_url + '/details/'+id+'  title="View/Comment"><i class="material-icons">visibility</i></a>';

				  	if( 2 == is_global ){
						view_icon 	= '<a href=' + global_url + '/details/'+id+'  title="View/Comment"><i class="material-icons">visibility</i></a>';					  		
				  	}

				  	var managerOperations = '';
				  	
				  	if( 1 == is_accepted ) {
				  		managerOperations = view_icon;
				  	} else {
				  		managerOperations = edit_icon + view_icon;
				  	}

				  	return ( (1 == user_type) || (5 == user_type) || (6 == user_type)) ? managerOperations : (( 3 == user_type ) || ( 4 == user_type ) ) ? edit_icon + delete_icon + view_icon : view_icon;
				}
			}
		]

		, "order": [[ 3, "desc" ]]
		, "pageLength": 10
		, "bAutoWidth": false // Disable the auto width calculation,
	});
	//==========================================================

	$('.common-date-class').bootstrapMaterialDatePicker({
		time 			: false,
		clearButton 	: false,
		switchOnClick 	: true,
		saveButton 		: false,
		nowButton 		: false,
		minDate 		: new Date()
	});
	//==========================================================

	$( window ).resize(function() {
		changeLayout();	
	});

	$('iframe#iframe1').load(function(){
		$("iframe#iframe1").contents().find('#toolbarContainer #toolbarRight').css({'display':'none','position':'none'});
		$("iframe#iframe1").contents().find('#toolbarContainer #toolbarMiddleContainer #toolbarMiddle').css({'right':'-169%'});
		changeLayout();
	});
	//==========================================================

	function changeLayout(){
		
		$("iframe#iframe1").contents().find('#titlebar #documentName').css('display','block');

		var windowWidth = $(window).width();
		var iframeElement = $("iframe#iframe1").contents().find('#toolbarContainer #toolbarMiddleContainer #toolbarMiddle');
		var iframeMiddleContainer = $("iframe#iframe1").contents().find('#toolbarContainer #toolbarMiddleContainer');

		if( windowWidth < 675 ) {
			
			$("iframe#iframe1").contents().find('#toolbarContainer #toolbarRight').css({'display':'none','position':'none'});
			$("iframe#iframe1").contents().find('#toolbarContainer').css('height','auto');
			$("iframe#iframe1").contents().find('#toolbarContainer #toolbarLeft').css({'float':'left','width':'100%','position':'relative'});
			iframeMiddleContainer.css({'right':'0%','width':'100%','position':'absolute'});

			if ((windowWidth>606) && windowWidth<=675 ) {
				iframeElement.css('right','2%');
			} else if((windowWidth>560) && (windowWidth<=606)) {
				iframeElement.css('right','2%');
			} else if((windowWidth>491) && (windowWidth<=560)) {
				iframeElement.css('right','4%');
			}  else if((windowWidth>403) && (windowWidth<=491)) {
				iframeMiddleContainer.css({'width':'100%','position':'relative'});
				iframeElement.css('right','40%');
			}  else if((windowWidth>360) && (windowWidth<=403)) {
				$("iframe#iframe1").contents().find('#titlebar #documentName').css('display','none');
				iframeMiddleContainer.css({'width':'100%','position':'relative'});
				iframeElement.css('right','35%');
			} else if((windowWidth>300) && (windowWidth<=360)) {
				$("iframe#iframe1").contents().find('#titlebar #documentName').css('display','none');
				iframeMiddleContainer.css({'width':'100%','position':'relative'});
				iframeElement.css('right','20%');
			} else if((windowWidth>200) && (windowWidth<=301)) {
				$("iframe#iframe1").contents().find('#titlebar #documentName').css('display','none');
				iframeMiddleContainer.css({'width':'100%','position':'relative'});
				iframeElement.css('right','2%');
			} 
		} else if((windowWidth>675) && (windowWidth<=1100)) {
			iframeElement.css({'right':'-140%'});
		} else if((windowWidth>1100) && (windowWidth<=1300)) {
			iframeElement.css({'right':'-150%'});
		}
	}
	//==========================================================

	<?php if(isset($add_extra_js) && ($add_extra_js == 1) ) : ?>

	var url 			= '<?php echo site_url("notification/select_employee_list");?>';
	var userType 		= '<?php echo $user_session->user_type;?>';
	var userId 			= '<?php echo $user_session->id;?>';

	$.ajax({
		type 	:"POST",
		url 	: url,
		data 	: {
			'user_type' :userType, 
			'user_id' : userId,
			'csrf_rcc'  : $('input[name=csrf_rcc]').attr("value"),
			},

		dataType: "json",
		success : function(data)
		{
			$('input[name=csrf_rcc]').attr("value", data.hash_token );
			var success = data.success;
			var results = data.results;

			if(success == 1)
			{
				var myOptions = '<option value=""></option>';
				myOptions +='<option value="all" selected="selected" id="notselect-all">All</option>';
				
				for(var i=0; i<results.length; i++){
					myOptions +=  '<option value="'+results[i].id+'" disabled="disabled" >'+results[i].first_name+' '+results[i].last_name+'</option>';
				}

				$("#user_id").html(myOptions).chosen().trigger("chosen:updated");
			}
			else
			{
				var myOptions = '<option value=""></option>';
				$("#user_id").html(myOptions);

				// var msg = 'No postal code available for selected country!';
				// getNotificationBar( 'error', msg );
			}
		}
	});

	<?php endif; ?>
	//==========================================================
	$(document).on('click','.delete_file_name', function(){

		var thisObj = $(this);
		var url 	= thisObj.data('url');
		var id 		= thisObj.data('id');
		
		$.ajax({
			type 	:"POST",
			url 	: url,
			data 	: {
				'id' :id, 
				'csrf_rcc'  : $('input[name=csrf_rcc]').attr("value"),
				},

			dataType: "json",
			success : function(data)
			{
				$('input[name=csrf_rcc]').attr("value", data.hash_token );
				var success = data.success;
				
				// console.log(data);
				if(success == 1)
				{
					$('input[name=uploaded_file]').attr("value", "" );
					thisObj.closest("div").remove();
					var msg = 'Notification file remove successfully';
					getNotificationBar( 'success', msg );
				}
				else
				{
					var msg = 'Notification file not deleted!';
					getNotificationBar( 'error', msg );
				}
			}
		});
	});
	//==========================================================	

	$(".chosen-users").chosen({ placeholder_text_multiple :"Select Users", allow_single_deselect:true });


	$(document).on('change','#user_id',function()
	{		
		if( $('#user_id option:selected').val() == 'all' )
		{
			$('#user_id option').not('#notselect-all').attr("disabled","disabled");

			$('#user_id option.select_all').removeAttr("disabled");

			$('select#user_id').trigger('chosen:updated');

		} else if($('#user_id option:selected').length >= 1 && $('#user_id option:selected').val() != 'all')
		{
			$('#user_id option').removeAttr("disabled");
			$('#notselect-all').attr("disabled","disabled");
			$('select#user_id').trigger('chosen:updated');
			
		} else {
			
			$('#user_id option').removeAttr("disabled");
			$('select#user_id').trigger('chosen:updated');
		}
	});




	//==========================================================

	// $("select.chosen-find-length").on("chosen:showing_dropdown", function(evnt, params) {
	// evnt.target.options.addClass('result-selected');
   	
	// var ss 	= evnt.target.options;
	// console.log(ss);

	//     if( params.chosen.form_field.children.length > 0 ){

	// 	    var chosen = params.chosen,
	// 	        $dropdown = $(chosen.dropdown),
	// 	        $field = $(chosen.form_field);

	// 	    if( !chosen.__customButtonsInitilized ) {
		    	
	// 	    	chosen.__customButtonsInitilized = true;
	// 	        var contained = function( el ) {
	// 	            var container = document.createElement("div");
	// 	            container.appendChild(el);
	// 	            return container;
	// 	        }
	// 	        var width = $dropdown.width();
	// 	        var opts = chosen.options || {},
	// 	            showBtnsTresshold = opts.disable_select_all_none_buttons_tresshold || 0;
	// 	            optionsCount = $field.children().length,
	// 	            selectAllText = opts.select_all_text || 'All',
	// 	            selectNoneText = opts.uncheck_all_text || 'None';

	// 	        if( chosen.is_multiple && optionsCount >= showBtnsTresshold ) {

	// 	        	var selectAllEl = document.createElement("a"),
	// 	                selectAllElContainer = contained(selectAllEl),
	// 	                selectNoneEl = document.createElement("a"),
	// 	                selectNoneElContainer = contained(selectNoneEl);
	// 	            selectAllEl.appendChild( document.createTextNode( selectAllText ) );
	// 	            selectNoneEl.appendChild( document.createTextNode( selectNoneText ) );
	// 	            $dropdown.prepend("<div class='ui-chosen-spcialbuttons-foot' style='clear:both;border-bottom: 1px solid black;'></div>");
	// 	            $dropdown.prepend(selectNoneElContainer);
	// 	            $dropdown.prepend(selectAllElContainer);
	// 	            var $selectAllEl = $(selectAllEl),
	// 	                $selectAllElContainer = $(selectAllElContainer),
	// 	                $selectNoneEl = $(selectNoneEl),
	// 	                $selectNoneElContainer = $(selectNoneElContainer);
	// 	            var reservedSpacePerComp = (width - 25) / 2;
	// 	            $selectNoneElContainer.addClass("ui-chosen-selectNoneBtnContainer")
	// 	                .css("float", "right").css("padding", "5px 8px 5px 0px")
	// 	                .css("max-width", reservedSpacePerComp+"px")
	// 	                .css("max-height", "30px").css("overflow", "hidden");
	// 	            $selectAllElContainer.addClass("ui-chosen-selectAllBtnContainer")
	// 	                .css("float", "left").css("padding", "5px 5px 5px 7px")
	// 	                .css("max-width", reservedSpacePerComp+"px")
	// 	                .css("max-height", "30px").css("overflow", "hidden");
	// 	            $selectAllEl.on("click", function(e) {
	// 	                e.preventDefault();
		                
	// 	                // console.log($field.children());
	// 	                $field.children().prop('selected', true);
	// 	                // $field.children().addClass('result-selected');
	// 	                $field.trigger('chosen:updated');
	// 	                return false;
	// 	            });
	// 	            $selectNoneEl.on("click", function(e) {
	// 	                e.preventDefault();
	// 	                $field.children().prop('selected', false);
	// 	                $field.trigger('chosen:updated');
	// 	                return false;
	// 	            });
	// 	        }
	// 	    }
	// 	}
	// });
});

</script>