<main class="mdl-layout__content mdl-color--grey-100" id="content">    
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Add Multiple Record</h2>
			</div>
			<div class="mdl-card__supporting-text">
				<div class="mdl-grid">
					<div class="mdl-layout-spacer"></div>
					<div class="mdl-cell mdl-cell--4-col">
						<form action="<?php echo base_url("user/create_bulk"); ?>" method="post" id="form_create_bulk" enctype="multipart/form-data">
							
							<?php $error_class = ( form_error('file_name') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <input class="mdl-textfield__input" type="file" id="file_name" name="file_name" value="<?php echo set_value('file_name'); ?>">
						    </div>
					       	<?php echo form_error('file_name'); ?>

						    <?php $error_class = ( form_error('default_password') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="default_password"></label>
						       <input class="mdl-textfield__input" type="password" id="default_password" name="default_password" value="<?php echo set_value('default_password'); ?>">
						    </div>
						    <?php echo form_error('default_password'); ?>

						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="margin-bottom:10px;">
								<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect " for="is_change_password">
								<input type="checkbox" id="is_change_password" name="is_change_password" class="mdl-checkbox__input" >
									<p>
									 	Force user to change password while login first time.
									</p>
								</label>
							</div>
							
						    <div class="clear"> </div>
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