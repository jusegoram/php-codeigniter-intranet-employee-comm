	</div>
	<footer>
		
	</footer>
	<?php include('js_section.php');  ?>

	<script type="text/javascript">

		<?php 

		if( ($user_session->is_change_password) || ( !empty($user_session->expired_date) 
			&& date('Y-m-d',$user_session->today_date) > date('Y-m-d',$user_session->expired_date) ) ){ ?>

			$('nav-item > a').click(function(e){
				e.preventDefault();
			});

			$('li > a:not(#disable_false)').click(function(e){
				e.preventDefault();
			});

			$('a').removeClass('mdl-color-text--white');
			$('i').removeClass('mdl-color-text--white');
			
			$('a').attr('disabled', 'disabled');
			$("li > a:not(#disable_false)").attr("style", "color:#757476 !important");

			$("#disable_false").removeAttr("disabled");
		
		<?php } ?>			

		<?php if($this->session->flashdata('success')){ ?>
			var msg_type 	= 'success';
			var msg 		= '<?php echo $this->session->flashdata('success'); ?>';
		<?php } ?>

		<?php if($this->session->flashdata('info')){ ?>
			var msg_type 	= 'info';
			var msg 		= '<?php echo $this->session->flashdata('info'); ?>';
		<?php } ?>


		<?php if($this->session->flashdata('error')){ ?>
			var msg_type 	= 'error';
			var msg 		= '<?php echo $this->session->flashdata('error'); ?>';
		<?php } ?>


		<?php if($this->session->flashdata('warning')){ ?>
			var msg_type 	= 'warning';
			var msg 		= '<?php echo $this->session->flashdata('warning'); ?>';
		<?php } ?>


		if(typeof msg_type != 'undefined' ){
			getNotificationBar( msg_type, msg );
		}

		<?php $navBarNumber =  (!empty($navBarNumber)) ? $navBarNumber : ""; ?>

		//===========================================
		
		$(document).on('click', '.add-active-class', function(){


			$('nav-item').removeClass('active');

			$(this).parent().addClass('active');

			// var thisObj 	 	= $(this);
			// var navBarNumber 	= thisObj.attr('data-navBarNumber');
			// console.log('click '+navBarNumber);
			// addActiveClass( navBarNumber );

		});
		//===========================================
		
		$(document).ready(function(){

			var navBarNumber  	= '<?php echo $navBarNumber; ?>';
			addActiveClass( navBarNumber );
		});
		//===========================================
			
		function addActiveClass( navBarNumber )
		{	
			var dashboardActive 	= '';
			var siteLinkActive		= '';
			var usersActive			= '';
			var welcomeQuotesActive	= '';
			var notificationsActive	= '';
			var performanceActive	= '';
			var performanceScoreActive	= '';
			var logsActive			= '';
			var settingsActive		= '';
			var globalNotificationsActive = '';

			switch ( navBarNumber )
			{
				case '1':
					dashboardActive = 'active';
				break;
		
				case '2':
					siteLinkActive = 'active';
				break;
			
				case '3':
					usersActive = 'active';
				break;
			
				case '4':
					welcomeQuotesActive = 'active';
				break;

				case '5':
					notificationsActive = 'active';
				break;

				case '6':
					performanceActive = 'active';
				break;

				case '7':
					performanceScoreActive = 'active';
				break;

				case '8':
					logsActive = 'active';
				break;

				case '9':
					settingsActive = 'active';
				break;

				case '10':
					globalNotificationsActive = 'active';
				break;
			}

			$('#dashboardId').addClass(dashboardActive);
			$('#siteLinkId').addClass(siteLinkActive);
			$('#usersId').addClass(usersActive);
			$('#welcomeQuotesId').addClass(welcomeQuotesActive);
			$('#notificationsId').addClass(notificationsActive);
			$('#globalNotificationsId').addClass(globalNotificationsActive);
			$('#performanceId').addClass(performanceActive);
			$('#performanceScoreId').addClass(performanceScoreActive);
			$('#logsId').addClass(logsActive);
			$('#settingsId').addClass(settingsActive);
		}
		//===========================================

		$(document).on('click', '.delete_data', function () {
			
			// var csrf_token2 =  '<?php //echo $csrf["hash"]; ?>';
			var thisObj = $(this);
			var url 	= thisObj.data('url');
			var id 		= thisObj.data('id');
			
			showDialog({
				text: 'Are you sure want to delete?',
				negative: {
					title: 'Cancel'
				},
				positive: {
					title: 'Yes',
					onClick: function() {
						$.ajax({
							type 	:"POST",
							url 	: url,
							async	:false,
							data 	: {
								'csrf_rcc'  : $('meta[name=csrf_rcc]').attr("content"),
								'id' : id
							},
							dataType: "json",

							success : function(data)
							{
								// csrf_token2 =  data.hash_token;
								$('meta[name=csrf_rcc]').attr("content", data.hash_token );
								var success = data.success;
								var id 		= data.id;
								if(success == 1)
								{
									thisObj.closest("tr").remove();
									// $('tr#'+id).remove();

									var msg = 'Record deleted successfully';
									getNotificationBar( 'success', msg );
								}
								else
								{
									var msg = 'Record not deleted!';
									getNotificationBar( 'error', msg );
								}
							}
						});
					}
				}
			});
		});
		//===========================================
	</script>

	<?php
		
		if( isset($page_js) ) :
			include($page_js.'.php'); 
		endif;
	?>
	

</body>
</html>