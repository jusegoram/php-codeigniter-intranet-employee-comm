<main class="mdl-layout__content mdl-color--grey-100" id="content">    
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Setting</h2>
			</div>
			<div class="mdl-card__supporting-text">
				<div class="mdl-grid">
					<div class="mdl-layout-spacer"></div>
					<div class="mdl-cell mdl-cell--4-col">
						
						<form action="<?php echo site_url("settings/index"); ?>" method="post" id="form_settings" name="form_settings">
						   
							<?php $error_class = ( form_error('password_expiry_time') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="password_expiry_time">Password Expire Time(In Days)</label>
						       <input class="mdl-textfield__input" type="text" id="password_expiry_time" name="password_expiry_time" value="<?php echo set_value('password_expiry_time'); ?>">
						    </div>
					       	<?php echo form_error('password_expiry_time'); ?>

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