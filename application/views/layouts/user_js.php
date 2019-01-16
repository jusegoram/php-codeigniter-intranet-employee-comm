<script type="text/javascript">

$(document).ready(function(){

	var message1 = "Password must contain atleast one number,<br/>one speacial character, one upper and lower<br/>lettes with minimum 12 char length";
	// var message2 = "Chain numbers are not allowed";
	var checkPasswordStandard = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{12,}$/;

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

				if( lengthDigits > 12 )
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


	$.validator.addMethod("employee_id", function(value, element) {
		return checkCardNumber(value);
	}, 'Please enter a valid employee ID.');

	$.validator.addMethod("username", function(value, element) {
		return checkCardNumber(value);
	}, 'Please enter a valid username.');

	$.validator.addMethod("avaya_number", function(value, element) {
		return checkCardNumber(value);
	}, 'Please enter a valid Avaya Number');

	$.validator.addMethod("check_current_password", function(value, element) {
		return checkCardNumber(value);
	}, 'Please enter a valid password');

	$.validator.addMethod("check_password", function (value, element) {
	    return this.optional(element) || checkPasswordStandard.test(value);
	}, message1);

	$.validator.addMethod("check_password1", function(value, element) {
		return checkCardNumber(value);
	}, 'Please enter a valid password');


	$.validator.addMethod("new_password", function (value, element) {
	    return this.optional(element) || checkPasswordStandard.test(value);
	}, message1);

	$.validator.addMethod("new_password1", function(value, element) {
		return checkCardNumber(value);
	}, 'Please enter a valid password');

	$.validator.addMethod("default_password", function (value, element) {
	    return this.optional(element) || checkPasswordStandard.test(value);
	}, message1);

	$.validator.addMethod("default_password1", function(value, element) {
		return checkCardNumber(value);
	}, 'Please enter a valid password');

	$.validator.addMethod("edit_password", function (value, element) {
	    return this.optional(element) || checkPasswordStandard.test(value);
	}, message1);

	$.validator.addMethod("edit_password1", function(value, element) {
		return checkCardNumber(value);
	}, 'Please enter a valid password');

	$("#form_users").validate({

		onkeyup: function(element, event) {
                if ($(element).attr('id') == "employee_id") {
                    return false; // disable onkeyup for your element named as "name"
                } else {  // else use the default on everything else
                    if ( element.name in this.submitted || element === this.lastElement ) {
                        this.element( element );
                    }

                }
        },

		rules: {
			first_name: {
				required: true,
				lettersonly: true
			},

			last_name: {
				required: true,
				lettersonly: true
			},

			avaya_number: {
				required: true,
				alphanumeric:true,
				avaya_number: true
			},

			employee_id: {
				required: true,
				alphanumeric:true,
				employee_id:true,
				remote:'<?php echo base_url('user/check_unique_employee_id');?>',
				onkeyup:false

			},

			username: {
				required: true,
				alphanumeric:true,
				username:true
			},

			password: {
				required: true,
				check_password:true,
				check_password1:true
			},

			email: {
				required: true
			},

			current_password: {
				required: true,
				check_current_password:true,
			},

			new_password: {
				required: true,
				new_password:true,
				new_password1:true
			},

			confirm_password: {
				required: true,
				equalTo:$.validator.format("#new_password")
			},

			user_type: {
				alphanumeric:true,
				required: true
			},

			assigned_user: {
				required: true
			},

			hire_date: {
				required: true
			},

			document_name: {
				alphanumeric:true,
				required: true
			}
		},

		messages: {
			first_name: {
				required: "Required"
			},

			last_name: {
				required: "Required"
			},

			avaya_number: {
				required: "Required"
			},

			employee_id: {
				required: "Required",
				remote:"Employee id is already exist."
			},

			username: {
				required: "Required"
			},

			password: {
				required: "Required"
			},

			current_password: {
				required: "Required"
			},

			new_password: {
				required: "Required"
			},

			confirm_password: {
				required: "Required",
				equalTo: $.validator.format("Please enter the same password as above")
			},

			user_type: {
				required: "Required"
			},

			assigned_user: {
				required: "Required"
			},

			hire_date: {
				required: "Required"
			},

			document_name: {
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

	$("#edit_form_users").validate({

		rules: {
			first_name: {
				required: true,
				lettersonly: true
			},

			last_name: {
				required: true,
				lettersonly: true
			},

			edit_password: {
				edit_password:true,
				edit_password1:true
			},

			avaya_number: {
				required: true,
				alphanumeric:true,
				avaya_number: true
			},

			hire_date: {
				required: true,
			}
		},

		messages: {
			first_name: {
				required: "Required"
			},

			last_name: {
				required: "Required"
			},

			avaya_number: {
				required: "Required"
			},

			hire_date: {
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

	$(document).on("change",'.user_select',function(){

		var user_type = $(this).val();
		showNewDropDown( user_type );
	});
	//=================================================

	function showNewDropDown( user_type ) {

		if( 4 == user_type ) {

			$('.job-title').css({"display":"none"});
			$('.assign-user').css({"display":"none"});
			$('#assign-manager').css({"display":"none"});

		} else if( 1 == user_type ) {

			$('.job-title').css({"display":"block"}).addClass('is-focused is-dirty');
			$('.assign-user').css({"display":"none"});
			$('#assign-manager').css({"display":"none"});
			var managerOption =  '<option value="3">Manager</option>';
			$('#job_title').addClass('is-focused').html(managerOption);

		} else if( 5 == user_type ) {

			$('#assign-manager').removeClass('assign-user');
			$('#assign-manager').css({"display":"block"});
			$('.assign-user').css({"display":"none"});
			$('.job-title').css({"display":"block"}).addClass('is-focused is-dirty');
			var supervisorOption =  '<option value="1">Supervisor</option>';
			$('#job_title').addClass('is-focused').html(supervisorOption);

		} else if( 6 == user_type ) {

			$('#assign-manager').removeClass('assign-user');
			$('#assign-manager').css({"display":"block"});
			$('.assign-user').css({"display":"none"});
			$('.job-title').css({"display":"block"}).addClass('is-focused is-dirty');
			var qaOption =  '<option value="2">Quality Analyst</option>';
			$('#job_title').addClass('is-focused').html(qaOption);

		} else {

			$('.assign-user').css({"display":"block"});
			$('#assign-manager').css({"display":"block"});
			$('.job-title').css({"display":"none"});
		}
	}
	//=================================================

	$("#form_create_bulk").validate({
		rules: {
			file_name: {
				required: true,
				extension: "csv"
			},

			default_password: {
				default_password:true,
				required: true,
				default_password1:true
			},
		},

		messages: {
			file_name: {
				required: "Required",
				extension: "Please upload only csv file"
			},

			default_password: {
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
	//==========================================================

	$('#not-added-user-table').DataTable({
		"bFilter"	: false,
		"bInfo"		: false,
	});
	//==========================================================

	$('#user-table').DataTable({
		"processing": true,
		"serverSide": true,
		"bLengthChange": true,

		"language": {
			"emptyTable":"No Record Found."
		},

		"ajax": {

			async:false,
			url: "<?php echo site_url('user/pagination'); ?>"

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
			{ "data": "id", "searchable":false, "orderable":false, "class":"mdl-data-table__cell--non-numeric"},
			{ "data": "first_name", "class":"mdl-data-table__cell--non-numeric"},
			{ "data": "employee_id", "class":"mdl-data-table__cell--non-numeric"},
			{ "data": "avaya_number", "class":"mdl-data-table__cell--non-numeric"},
			{ "data": "email", "class":"mdl-data-table__cell--non-numeric"},
			{ "data": "job_title", "class":"mdl-data-table__cell--non-numeric"},
			{ "data": "user_type", "class":"mdl-data-table__cell--non-numeric"}

			<?php if( (3 == $user_session->user_type) || (4 == $user_session->user_type) ) : ?>
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
				  	var edit_icon 	= '<a href=' + site_url + '/edit/'+id+' title="Edit"><i class="tiny material-icons" title="Edit">mode_edit</i></a>';
				  	var delete_icon = '<a class="delete_data" href="javascript:void(0);" data-url=' + site_url + '/remove  data-id=' + id +' title="Delete"><i class="tiny material-icons" title="Delete">delete</i></a>';
					return (( 3 == user_type ) || ( 4 == user_type )) ? edit_icon + delete_icon : '';
				}
			}

			<?php endif; ?>
		]

		, "order": [[ 1, "asc" ]]
		, "pageLength": 10
		, "bAutoWidth": false // Disable the auto width calculation,
	});
	//==========================================================
	<?php if( 1 == $show_admin_list ) : ?>

		$('#admin-table').DataTable({
			"processing": true,
			"serverSide": true,
			"bLengthChange": true,

			"language": {
				"emptyTable":"No Record Found."
			},

			"ajax": {

				async:false,
				url: "<?php echo site_url('user/admin_pagination'); ?>"

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
				{ "data": "id", "searchable":false, "orderable":false, "class":"mdl-data-table__cell--non-numeric"},
				{ "data": "first_name", "class":"mdl-data-table__cell--non-numeric"},
				{ "data": "employee_id", "class":"mdl-data-table__cell--non-numeric"},
				{ "data": "avaya_number", "class":"mdl-data-table__cell--non-numeric"},
				{ "data": "email", "class":"mdl-data-table__cell--non-numeric"},
				{ "data": "user_type", "class":"mdl-data-table__cell--non-numeric"}

				<?php if( 3 == $user_session->user_type  ) : ?>
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
					  	var edit_icon 	= '<a href=' + site_url + '/edit/'+id+' title="Edit"><i class="tiny material-icons" title="Edit">mode_edit</i></a>';
					  	var delete_icon = '<a class="delete_data" href="javascript:void(0);" data-url=' + site_url + '/remove  data-id=' + id +' title="Delete"><i class="tiny material-icons" title="Delete">delete</i></a>';
						return ( 3 == user_type ) ? edit_icon + delete_icon : '';
					}
				}

				<?php endif; ?>
			]

			, "order": [[ 1, "asc" ]]
			, "pageLength": 10
			, "bAutoWidth": false // Disable the auto width calculation,
		});
	<?php endif; ?>
	//==========================================================

	$(".chosen-select").chosen({ placeholder_text_multiple :"Select Employees" });

	//==========================================================

	$(document).on('click', '.submit_bulk_user_form', function(){

		if($("form#form_create_bulk").valid()) {

			$("form#form_create_bulk").submit();
			$(".submit_bulk_user_form").attr('disabled','disabled');
			$(this).removeClass('submit_bulk_user_form');
		} else {

			return false;
		}
	});
	//==========================================================

	// var csrf_token =  '<?php //echo $csrf["hash"]; ?>';
	// var csrf_token =  '<?php// echo $csrf["hash"]; ?>';

	$(document).on('change','#assigned_user',function () {

		var thisObject 	= $(this);
		var url 		= thisObject.data('url');
		var jobTitleValue = thisObject.val();

		if( jobTitleValue != '' )
		{
			jobTitleValue = jobTitleValue.split(':');
			jobTitle 	  = jobTitleValue[1];

			$.ajax({
				async	:false,
				type 	:"POST",
				url 	: url,
				data 	: {
					'csrf_rcc'  : $('input[name=csrf_rcc]').attr("value"),
					'job_title' : jobTitle
					},

				dataType: "json",
				success : function(data)
				{
					$('input[name=csrf_rcc]').attr("value", data.hash_token );

					// csrf_token =  data.hash_token;

					//$('#hash_token').val( csrf_token );

					var success = data.success;
					var results = data.results;

					if(success == 1)
					{
						var myOptions = "<option value></option>";
						for(var i=0; i<results.length; i++){
							myOptions +=  '<option value="'+results[i].employee_id+'">'+results[i].first_name+' '+results[i].last_name+'</option>';
						}

						$("#select_employee").html(myOptions).chosen().trigger("chosen:updated");
					}
					else
					{
						$("#select_employee").html('').chosen().trigger("chosen:updated");
						var msg = 'Please add employee to assign!';
						getNotificationBar( 'error', msg );
					}
				}
			});
		}
	});
	//==========================================================
	$('#default_password').val('');
	$('#current_password').val('');
});

</script>