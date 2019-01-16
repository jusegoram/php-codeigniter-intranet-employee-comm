<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en" style="width:100%; height:100%; margin:0px; padding:0px;">
	<head>
		<link rel="icon" sizes="16x16" href="<?php echo ASSETS_PATH . '/images/creative-idea.png' ?>" />
		<?php include('meta_section.php');  ?>
		<?php include('css_section.php');  ?>
	</head>
	<body style="width:100%; height:100%; margin:0px; padding:0px;">
		<div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
			<header class="demo-header mdl-layout__header mdl-color--white mdl-color--grey-100 mdl-color-text--grey-600">
				<div class="mdl-layout__header-row">

					<span class="mdl-layout-title" id="title"><?php echo $title; ?></span>
					<span class="mdl-layout-title" id="subtitle"></span>
					<div class="mdl-layout-spacer"></div>
					<button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="hdrbtn">
						<i class="material-icons">more_vert</i>
					</button>

					<ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">

						<li class="mdl-menu__item">
							<a href="<?php echo site_url("user/profile_setting"); ?>">
								<label class="mdl-icon-toggle">
									<i class="material-icons">person_outline</i>
								</label>
								Profile Setting
							</a>
						</li>

						<li class="mdl-menu__item">
							<a href="<?php echo site_url("user/change_password"); ?>">
								<label class="mdl-icon-toggle">
									<i class="material-icons">lock</i>
								</label>
								Change Password
							</a>
						</li>

						<li class="mdl-menu__item">
							<a href="<?php echo site_url("user/logout"); ?>" id="disable_false">
								<label class="mdl-icon-toggle">
									<i class="material-icons">power_settings_new</i>
								</label>
								Logout
							</a>
						</li>
					</ul>
				</div>
			</header>