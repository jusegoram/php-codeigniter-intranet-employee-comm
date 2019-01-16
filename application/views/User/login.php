<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php echo $title;?></title>

		<link rel="icon" sizes="16x16" href="<?php echo ASSETS_PATH . '/images/creative-idea.png' ?>" />
		<link rel="stylesheet pefetch" href="<?php echo ASSETS_PATH ?>/css/material-icon.css">
		<link rel="stylesheet" href="<?php echo ASSETS_PATH ?>/css/fonts.css">
		<link rel="stylesheet" href="<?php echo ASSETS_PATH . '/css/style.css' ?>">


		<link rel="stylesheet" href="<?php echo MATERIAL_PATH; ?>/bower_components/material-design-lite/material.min.css" />

		<link rel="stylesheet" href="<?php echo MATERIALIZE_THEME_PATH ?>/css/reset.css">
		<link rel="stylesheet" href="<?php echo MATERIALIZE_THEME_PATH ?>/css/style.css">
		<style type="text/css">
		p{
			left: 15%;
			top: -20px;
		}

		form{
			padding-bottom: 2%;
		}
		.input-container{
			margin: 0 60px 40px !important;
		}
		label{
			margin-left: 2% !important;
		}

		</style>
	</head>

	<body>
		<div class="">
			<div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
				<header class="demo-header cca-background-color mdl-layout__header ">
					<div class="mdl-layout__header-row">
						<span class="mdl-layout-title" id="title">RCC</span>
						<div class="mdl-layout-spacer"></div>
					</div>
				</header>
			</div>
			<main>
				<br/>
			</main>
		</div>

		<div class="container">
			<div class="card">
				<h1 class="title">
					<img src="<?php echo ASSETS_PATH . '/images/logo_user.png' ?>" class="logo_user" />
				</h1>

				<form action="<?php echo site_url('user/login'); ?>" method="post" id="frm_login">

					<?php $error_class = ( form_error('username') != '' )? 'has-error' : '' ?>
					<div class="input-container <?php echo $error_class; ?>">
						<input type="password" id="username" name="username" placeholder="Username" />
						<div id="username-error" > &nbsp; </div>
						<div class="bar"></div>
					</div>
					<?php echo form_error('username'); ?>

					<?php $error_class = ( form_error('password') != '' )? 'has-error' : '' ?>
					<div class="input-container <?php echo $error_class; ?>">
						<input type="password" id="password" name="password" placeholder="Password"/>
						<div id="password-error" > &nbsp; </div>
						<div class="bar"></div>
					</div>
					<?php echo form_error('password'); ?>

					<div class="button-container">
						<button type="submit" class="cca-background-color mdl-js-ripple-effect"><span>LOG IN</span></button>
					</div>

					<div class="footer">
					</div>

					<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

				</form>
			</div>
		</div>

		<script src="<?php echo ASSETS_PATH ?>/js/jquery-2.2.4.min.js"></script>

		<script src="<?php echo MATERIALIZE_THEME_PATH ?>/js/index.js"></script>
		<script src="<?php echo ASSETS_PATH; ?>/js/jquery.validate.min.js"></script>
		<script src="<?php echo ASSETS_PATH; ?>/js/additional-methods.min.js"></script>

		<link rel="stylesheet" href="<?php echo FLAT_NOTIFICATIONS_PATH . '/overhang.min.css' ?>">
		<script src="<?php echo FLAT_NOTIFICATIONS_PATH; ?>/overHang.min.js"></script>

		<script src="<?php echo ASSETS_PATH; ?>/js/common_functions.js"></script>

		<script type="text/javascript">

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

				console.log('type : ' + msg_type);

				getNotificationBar( msg_type, msg );
			}
			//==========================================================

			$(document).ready(function(){

				function checkCardNumber(inputtxt)
				{
					var visaCard 			= /^(?:4[0-9]{12}(?:[0-9]{3})?)$/;
					var masterCard 			= /^(?:5[1-5][0-9]{14})$/;
					var jcbCard 			= /^(?:(?:2131|1800|35\d{3})\d{11})$/;
					var discoverCard 		= /^(?:6(?:011|5[0-9][0-9])[0-9]{12})$/;
					var americalExpressCard = /^(?:3[47][0-9]{13})$/;
					var dinnerClubCard 		= /^(?:3(?:0[0-5]|[68][0-9])[0-9]{11})$/;

					flag = 0;
					if(inputtxt.match(/(\d+)/g))
					{
						var strArray = inputtxt.match(/(\d+)/g);
					    var i = 0;
					    for(i=0; i<strArray.length;i++)
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
					}else
					{
						return true;
					}
				}


				$.validator.addMethod("username", function(value, element) {
					return checkCardNumber(value);
				}, 'Please enter a valid username');

				$.validator.addMethod("password", function(value, element) {
					return checkCardNumber(value);
				}, 'Please enter a valid password');

				$("#frm_login").validate({
					rules: {
						username: {
							required: true,
							alphanumeric:true,
							username:true
						},

						password: {
							required: true,
							password:true
						}
					},
					messages: {
						username: {
							required: "Required"
						},

						password: {
							required: "Required"
						}
					},
					errorElement : 'p',
					errorClass: "has-error",
			        errorPlacement: function(error, element) {
			          var placement = $(element).data('error');
			          if (placement) {
			            $(placement).append(error)
			          } else {
			            error.insertAfter(element.parent());
			          }
			        }
				});
				//==========================================================
			});
		</script>
	</body>
</html>
