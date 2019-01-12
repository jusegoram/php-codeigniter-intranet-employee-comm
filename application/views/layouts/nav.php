
<div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
	<header class="demo-drawer-header">
		<a href="<?php echo site_url('home') ?>" style="display:flex;">
		<img src="<?php echo ASSETS_PATH; ?>/images/logo.png" style="height:130px; width:125px; margin: 0 auto;">
		</a>
	</header>
	<nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
		
		<nav-item id = "dashboardId">
			<a class="mdl-navigation__link mdl-color-text--white add-active-class" href="<?php echo site_url('home'); ?>" ><i class="mdl-color-text--blue-grey-400 material-icons mdl-color-text--white">home</i>Dashboard</a>
		</nav-item>

		<nav-item id = "siteLinkId">
			<a class="mdl-navigation__link mdl-color-text--white add-active-class" href="<?php echo site_url('site_link');?>"><i class="mdl-color-text--blue-grey-400 material-icons mdl-color-text--white">link</i>Site Links</a>
		</nav-item>

		<?php if( 2 !=  $user_session->user_type): ?>
			<nav-item id = "usersId">
				<a class="mdl-navigation__link mdl-color-text--white add-active-class" href="<?php echo site_url('user'); ?>" ><i class="mdl-color-text--blue-grey-400 material-icons mdl-color-text--white">supervisor_account</i>Users</a>
			</nav-item>
		<?php endif; ?>

		<?php if( ( 3 ==  $user_session->user_type ) || ( 4 ==  $user_session->user_type ) ): ?>
		<nav-item id = "welcomeQuotesId">	
			<a class="mdl-navigation__link mdl-color-text--white add-active-class" href="<?php echo site_url('welcome_quotes');?>" data-title="Welcome Quotes"><i class="mdl-color-text--blue-grey-400 material-icons mdl-color-text--white">sms</i>Welcome Quotes</a>
		</nav-item>
		<?php endif; ?>		
		
		<nav-item id = "notificationsId">	
			<a class="mdl-navigation__link mdl-color-text--white add-active-class" href="<?php echo site_url('notification/index');?>"><i class ="mdl-color-text--blue-grey-400 material-icons mdl-color-text--white">notifications</i>Notifications</a>
		</nav-item>
		<?php if( ( 3 ==  $user_session->user_type ) || ( 4 ==  $user_session->user_type ) ): ?>
			<nav-item id = "globalNotificationsId">
			<a class="mdl-navigation__link mdl-color-text--white add-active-class" href="<?php echo site_url('global_notification');?>"><i class ="mdl-color-text--blue-grey-400 material-icons mdl-color-text--white">notifications</i>Global Notifications</a>
		</nav-item>
		<?php endif ?>	
		<nav-item id = "performanceId">
			<a class="mdl-navigation__link mdl-color-text--white add-active-class" href="<?php echo site_url('performance');?>"><i class="mdl-color-text--blue-grey-400 material-icons mdl-color-text--white">insert_chart</i>Performance</a>
		</nav-item>

		<nav-item id = "performanceScoreId">
			<a class="mdl-navigation__link mdl-color-text--white add-active-class" href="<?php echo site_url('performance_score');?>"><i class="mdl-color-text--blue-grey-400 material-icons mdl-color-text--white">insert_chart</i>Performance Scores</a>
		</nav-item>

		<nav-item id = "logsId">
			<?php if( 2 ==  $user_session->user_type): ?>
				<a class="mdl-navigation__link mdl-color-text--white add-active-class" href="<?php echo site_url('logs');?>"><i class="mdl-color-text--blue-grey-400 material-icons mdl-color-text--white">assignment</i>Add Log</a>
			<?php else: ?>
				<a class="mdl-navigation__link mdl-color-text--white add-active-class" href="<?php echo site_url('logs');?>"><i class="mdl-color-text--blue-grey-400 material-icons mdl-color-text--white">assignment</i>View Logs</a>
			<?php endif ?>
		</nav-item>

		<?php if ( ( 3 ==  $user_session->user_type ) || ( 4 ==  $user_session->user_type ) ): ?>
			<nav-item id = "settingsId">
				<a class="mdl-navigation__link mdl-color-text--white add-active-class" href="<?php echo site_url('Settings');?>"><i class="mdl-color-text--blue-grey-400 material-icons mdl-color-text--white">settings</i>Settings</a>
			</nav-item>
		<?php endif ?>
	</nav>
</div>