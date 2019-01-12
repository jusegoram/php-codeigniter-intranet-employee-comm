<main class="mdl-layout__content mdl-color--grey-100" id="content">    
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Edit</h2>
			</div>
			<div class="mdl-card__supporting-text">
				<div class="mdl-grid">
					<div class="mdl-layout-spacer"></div>
					<div class="mdl-cell mdl-cell--4-col">
						<form action="<?php echo site_url("user/change_password"); ?>" method="post" id="form_users">
						    
						    <?php $error_class = ( form_error('current_password') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="current_password">Current Password</label>
						       <input class="mdl-textfield__input" type="password" id="current_password" name="current_password" value="<?php echo set_value('current_password'); ?>">
						    </div>
					    	<?php echo form_error('current_password'); ?>
						    
						    <?php $error_class = ( form_error('new_password') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="new_password">New Password</label>
						       <input class="mdl-textfield__input" type="password" id="new_password" name="new_password" value="<?php echo set_value('new_password'); ?>">
						    </div>
					    	<?php echo form_error('new_password'); ?>

						    <?php $error_class = ( form_error('confirm_password') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="confirm_password">Confirm Password</label>
						       <input class="mdl-textfield__input" type="password" id="confirm_password" name="confirm_password" value="<?php echo set_value('confirm_password'); ?>">
						    </div>
							<?php echo form_error('confirm_password'); ?>
							
							<div class="clear"></div>
							<div class="mdl-layout">
								<button type="submit" class="mdl-button cca-background-color-dark-green cca-text-color-white">Save</button>
							</div>

							<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
					  </form>
					</div>
					<div class="mdl-layout-spacer"></div>
				</div>
			</div>
		</div>
	</div>
</main>