<main class="mdl-layout__content mdl-color--grey-100" id="content">    
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<?php if($user_session->user_type == 3 ):?>
					<h2 class="mdl-card__title-text">Edit</h2>
				<?php else: ?>	
					<h2 class="mdl-card__title-text">Profile</h2>
				<?php endif; ?>	
			</div>
			<div class="mdl-card__supporting-text">
				<div class="mdl-grid">
					<div class="mdl-layout-spacer"></div>
					<div class="mdl-cell mdl-cell--4-col">
						<form method="post"  action="<?php echo site_url('user/profile_setting');?>" id="form_users">

							<?php //if($user_session->user_type != 2 ):?>

								<?php $redonly_attr = ( ( 3 == $user_session->user_type ) || ( 4 == $user_session->user_type) ) ? '': 'readonly="readonly"'; ?>								

								<?php $error_class = ( form_error('first_name') != '' )? 'has-error' : '' ?>
							    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							       <label class="mdl-textfield__label" for="first_name">First Name</label>
							       <input class="mdl-textfield__input" type="text" id="first_name" name="first_name" value="<?php echo $result->first_name;?>" <?php echo $redonly_attr; ?> >
							    </div>
						    	<?php echo form_error('first_name'); ?>

							    <?php $error_class = ( form_error('last_name') != '' )? 'has-error' : '' ?>
							    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							       <label class="mdl-textfield__label" for="last_name">Last Name</label>
							       <input class="mdl-textfield__input" type="text" id="last_name" name="last_name" value="<?php echo $result->last_name;?>" <?php echo $redonly_attr; ?> >
							    </div>
						       	<?php echo form_error('last_name'); ?>

						       	<?php $error_class = ( form_error('username') != '' )? 'has-error' : '' ?>
							    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							       <label class="mdl-textfield__label" for="username">Username</label>
							       <input class="mdl-textfield__input" type="text" id="username" name="username" value="<?php echo $result->username;?>" <?php echo $redonly_attr; ?> >
							    </div>
						       	<?php echo form_error('username'); ?>

						       	<?php $error_class = ( form_error('avaya_number') != '' )? 'has-error' : '' ?>
							    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							       <label class="mdl-textfield__label" for="avaya_number">Avaya Number</label>
							       <input class="mdl-textfield__input" type="text" id="avaya_number" name="avaya_number" value="<?php echo $result->avaya_number;?>" <?php echo $redonly_attr; ?> >
							    </div>
						       	<?php echo form_error('avaya_number'); ?>	
							
								<?php $error_class = ( form_error('email') != '' )? 'has-error' : '' ?>
							    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							       <label class="mdl-textfield__label" for="email">email</label>
							       <input class="mdl-textfield__input" type="text" id="email" name="email" value="<?php echo $result->email;?>" <?php echo $redonly_attr; ?> >
							    </div>
						       	<?php echo form_error('email'); ?>	
								

								<?php if( 1 == $result->user_type ){
										$user_type = 'Manager';
									} elseif( 2 == $result->user_type ){
										$user_type = 'Employee';
									} else {
										$user_type = 'Admin';
									}
								?>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							       <label class="mdl-textfield__label" for="user_type">User Type</label>
							       <input class="mdl-textfield__input" type="text" id="user_type" name="user_type" value="<?php echo $user_type;?>"<?php echo $redonly_attr; ?> >
							    </div>

							    <?php if( ( 3 == $user_session->user_type ) || ( 4 == $user_session->user_type ) ):?>
									<div class="mdl-layout">
										<button type="submit" class="mdl-button cca-background-color-dark-green cca-text-color-white">Save</button>
									</div>
									<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
								<?php endif; ?>

						<?php //endif; ?>
					  </form>
					</div>
					<div class="mdl-layout-spacer"></div>
				</div>
			</div>
		</div>
	</div>
</main>