<script type="text/javascript">

$(document).ready(function(){

	var pathController = '<?php echo site_url('performance_score/find_performance_score'); ?>';
	findScores( pathController, 1 );

	var tableDestroy = 1;

	$(document).on('click', '.add_score_table', function () {
		
		var thisObj 	= $(this);
		var url 		= thisObj.data('url');
		var scoreType 	= thisObj.data('score-type');
		
		findScores( url, scoreType );
	});
	//===========================================

	function findScores( url,scoreType ){

		if( tableDestroy ) {
			$('#performance_score_table').DataTable().destroy();
		}

		$('#performance_score_table').DataTable({
			
			"processing": true,
			"serverSide": true,
			"bLengthChange": true,
			
			"bPaginate"	: false,
			"bFilter"	: false,
			"bInfo"		: false,

			"language": {
				"emptyTable":"No Record Found."
			},

			"ajax": {
				
				async:false,
				url: url
				
				, type: "POST"
				
				, dataSrc: function ( json ) {

					$('meta[name=csrf_rcc]').attr("content", json.hash_token );
					return json.data;
				}

				, data: function( d ){
					d.csrf_rcc = $('meta[name=csrf_rcc]').attr("content");
					d.score_type = scoreType;
				}
			}
			
			, "columns": [
				{ "data": "s_n", "searchable":false, "orderable":false, "class": "mdl-data-table__cell--non-numeric"},
				{ "data": "name", "searchable":false, "orderable":false, "class": "mdl-data-table__cell--non-numeric"},
				{ "data": "avaya_number", "searchable":false, "orderable":false, "class": "mdl-data-table__cell--non-numeric"},
				{ "data": "date", "searchable":false, "orderable":false, "class": "mdl-data-table__cell--non-numeric"},
				{ "data": "score", "searchable":false, "orderable":false, "class": "mdl-data-table__cell--non-numeric"},
			]

			, "order": false
			, "pageLength": 12
			, "bAutoWidth": false
		});
	}
	//===========================================

	findUsers( 1 );

	var tableDestroy2 = 1;

	$(document).on('click', '.add_users_table', function () {
		
		var thisObj 	= $(this);
		var scoreType 	= thisObj.data('score-type');
		
		findUsers( scoreType );
	});
	//===========================================

	function findUsers( scoreType ){

		if( tableDestroy2 ) {
			$('#performance_users_table').DataTable().destroy();
		}

		$('#performance_users_table').DataTable({
			"processing": true,
			"serverSide": true,
			"bLengthChange": true,
			
			"language": {
				"emptyTable":"No Record Found."
			},

			"ajax": {
				
				async:false,
				url: "<?php echo site_url('performance_score/pagination'); ?>"
				, type: "POST"
				
				, dataSrc: function ( json ) {

					$('meta[name=csrf_rcc]').attr("content", json.hash_token );
					return json.data;
				}

				, data: function( d ){
					d.csrf_rcc 	  = $('meta[name=csrf_rcc]').attr("content");
					d.score_type  = scoreType;
				}
			}

			, "columns": [
				{ "data": "id", "searchable":false, "orderable":false, "class": "mdl-data-table__cell--non-numeric"},
				{ "data": "first_name", "class": "mdl-data-table__cell--non-numeric",

					mRender: function (nRow, aData, iDisplayIndex) {
						var userType = '<?php echo $user_session->user_type;?>';	
						if( (1 == userType) || (5 == userType) || (6 == userType) ) {
							
							var rowData 	= nRow.split('~&');
							var showButton 	= '<a href="javascript:void(0);" data-score-type='+rowData[2]+' data-employee_id='+rowData[1]+' class="show-dialog-content">'+rowData[0]+'</a>';
							return showButton;
						} else {
							return nRow;
						}
					}
				},
				{ "data": "employee_id", "class": "mdl-data-table__cell--non-numeric"},
				
				<?php if( (1 == $user_session->user_type) || (5 == $user_session->user_type) || (6 == $user_session->user_type) ): ?>
					{ "data": "email", "class": "mdl-data-table__cell--non-numeric"}
				<?php else: ?>
					{ "data": "score", "class": "mdl-data-table__cell--non-numeric"},
					{ "data": "avaya_number", "class": "mdl-data-table__cell--non-numeric"},
					{ "data": "date", "class": "mdl-data-table__cell--non-numeric"},
					{ "data": "action", "searchable":false, "orderable":false, "class": "mdl-data-table__cell--non-numeric",

						mRender: function (nRow, aData, iDisplayIndex) {
							var rowData 	= nRow.split('~');
						  	var site_url 	= rowData[0];
						  	var id 			= rowData[1];
							var showButton 	= '<a class="delete_data" href="javascript:void(0);" data-url=' + site_url + '/remove  data-id=' + id +' title="Delete"><i class="tiny material-icons" title="Delete">delete</i></a>';
							return showButton;
						}	

					}
				<?php endif; ?>
			]

			<?php if( (1 == $user_session->user_type) || (5 == $user_session->user_type) || (6 == $user_session->user_type) ): ?>
				, "order": [[ 1, "asc" ]]
			<?php else: ?>
				, "order": [[ 5, "desc" ]]
			<?php endif; ?>
			, "pageLength": 10
			, "bAutoWidth": false
		});
	}
	//===========================================
		
	$(document).on('click', '.show-dialog-content', function () {
		
		var thisObj = $(this);
		
		var pathToController = '<?php echo site_url('performance_score/find_performance_score'); ?>';
		var employeeId 	= thisObj.data('employee_id');
		var scoreType 	= thisObj.data('score-type');
		var scoreName = '';

		switch ( scoreType )
		{
			case 1:
				scoreName = 'External Quality';
			break;
	
			case 2:
				scoreName = 'Internal Quality';
			break;
		
			case 3:
				scoreName = 'Adherence';
			break;
		
			case 4:
				scoreName = 'Transfer Rate';
			break;

			case 5:
				scoreName = 'Lateness';
			break;

			case 6:
				scoreName = 'Conversion Rate';
			break;
		}

		$('#performance_score_popup').DataTable({
			"processing": true,
			"serverSide": true,
			"bLengthChange": true,
			"bPaginate"	: false,
			"bFilter"	: false,
			"bInfo"		: false,
			
			"language": {
				"emptyTable":"No Record Found."
			},

			"ajax": {
				
				async:false,
				url: pathToController
				
				, type: "POST"
				
				, dataSrc: function ( json ) {

					$('meta[name=csrf_rcc]').attr("content", json.hash_token );
					return json.data;
				}

				, data: function( d ){
					d.csrf_rcc = $('meta[name=csrf_rcc]').attr("content");
					d.score_type 	= scoreType;
					d.employee_id 	= employeeId;	
				}
			}
			
			, "columns": [
				{ "data": "s_n", "searchable":false, "orderable":false, "class": "mdl-data-table__cell--non-numeric"},
				{ "data": "name", "searchable":false, "orderable":false, "class": "mdl-data-table__cell--non-numeric"},
				{ "data": "avaya_number", "searchable":false, "orderable":false, "class": "mdl-data-table__cell--non-numeric"},
				{ "data": "date", "searchable":false, "orderable":false, "class": "mdl-data-table__cell--non-numeric"},
				{ "data": "score", "searchable":false, "orderable":false, "class": "mdl-data-table__cell--non-numeric"},
			]

			, "order": false
			, "pageLength": 12
			, "bAutoWidth": false
		});

		setTimeout(function(){

			var nameOfId =  document.getElementById('name_score1');
			nameOfId.innerHTML = scoreName+' Scores';
			
			var dynamicHtml = $('#main_push').html();

			showDialog({
				text : dynamicHtml,
				negative: {
					title: 'Close'
				}
			});

			$('.dialog_class_div').parents('.mdl-card').addClass('dialog-container-first-div');

			$('#performance_score_popup').DataTable().destroy();
		}, 10);


	});
	//===========================================
	
	$('.select_file').on('change', function(){

		var thiOb 	= $(this); 
		var form_id = thiOb.parents('form').attr('id');
		var form_name = thiOb.parents('form').attr('name');
		
		// $("#preview").html('');
		// $("#preview").html('<img src="<?php //echo ASSETS_PATH.'/images/loading.gif'; ?>" alt="Uploading...."/>');

		$("#show-progress-bar").css('display','block');

		fileUploadAjax( form_id, form_name, thiOb );
	});
	
	//===========================================
	function fileUploadAjax( form_id, form_name, thiOb ) {

		$("#" + form_id).ajaxSubmit({
			
			target:   '#targetLayer',
			dataType: 'json',
			data 	: {
				'csrf_rcc'  : $('meta[name=csrf_rcc]').attr("content")
			},

			beforeSend:function(request) {
				
				$("#progress-bar").width('0%');
				
				$.blockUI({ css: {
						border: 'none',
						padding: '15px',
						backgroundColor: '#000',
							'-webkit-border-radius': '10px',
							'-moz-border-radius': '10px',
						opacity: .5,
						color: '#fff'
					},
				});
			},

			uploadProgress: function (event, position, total, percentComplete){	
				
				$("#progress-bar").width(percentComplete + '%');
				$("#progress-bar").html('<div id="progress-status">' + percentComplete +' %</div>')
			},

			success:function(data){
				
				if( !data.error )
				{
					$("#progress-bar").width('100%');
					$("#progress-bar").html('<div id="progress-status">100%</div>');
					
					$.unblockUI()
					thiOb.wrap('<form>').closest('form').get(0).reset();
					thiOb.unwrap();
					
					// $("#preview").html('');
					
					var arrayLength = data.records.length;
					
					$('meta[name=csrf_rcc]').attr("content", data.hash_token );

					$("#show-progress-bar").css('display','none');

					var vic_data = data.records;

					$('#added_score_table').DataTable().destroy();

					document.getElementById("name_score_added").innerHTML = arrayLength+" "+form_name+" Score(s) Status";

					$('.show-second-times').css('display','block');

					$('#added_score_table').DataTable({

						"bPaginate"	: false,
						"bFilter"	: false,
						"bInfo"		: false,	

						data: vic_data,

						columns: [
							{data: 'employee_id', "searchable":false, "orderable":false, "class": "mdl-data-table__cell--non-numeric"},
							{data: 'name', "searchable":false, "orderable":false, "class": "mdl-data-table__cell--non-numeric"},
							{data: 'avaya_number', "searchable":false, "orderable":false, "class": "mdl-data-table__cell--non-numeric"},
							{data: 'date', "searchable":false, "orderable":false, "class": "mdl-data-table__cell--non-numeric"},
							{data: 'score', "searchable":false, "orderable":false, "class": "mdl-data-table__cell--non-numeric"},
							{data: 'action', "searchable":false, "orderable":false, "class": "mdl-data-table__cell--non-numeric"

								,mRender: function (nRow, aData, iDisplayIndex) {
									var rowData = nRow.split('~');
								  	
								  	var recordData = rowData[0];
								  	var status 		= rowData[1];

								  	if( 1 == status){
								  		return '<strong style="color:red;">'+recordData+'</strong>';
								  	} else {
								  		return '<strong style="color:green;">'+recordData+'</strong>';
								  	}
									
								}
							}
						]
						
						, "order": false
						, "pageLength": 10
						, "bAutoWidth": false
					});
				} else {

					getNotificationBar( 'warning', data.error );
					$.unblockUI()
					thiOb.wrap('<form>').closest('form').get(0).reset();
					thiOb.unwrap();
					$('meta[name=csrf_rcc]').attr("content", data.hash_token );
					$("#show-progress-bar").css('display','none');
					return false;
				}
			},
			resetForm: true 
		});
		return false; 

	}

});



</script>