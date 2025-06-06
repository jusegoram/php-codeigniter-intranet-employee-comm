<main class="mdl-layout__content mdl-color--grey-100" id="content">    
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Add Notification</h2>
			</div>
			<div class="mdl-card__supporting-text">
				<div class="mdl-grid">
					<div class="mdl-layout-spacer"></div>
					<div class="mdl-cell mdl-cell--4-col">
						<form action="<?php echo site_url("notification/create"); ?>" method="post" id="form_notifications" enctype="multipart/form-data">
						    
						    <!-- <?php //if(3 == $user_session->user_type) {?>

						    	<?php// $error_class = ( form_error('user_id1') != '' )? 'has-error' : '' ?>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield">
									<label class="mdl-textfield__label" for="user_id1" >Notification For</label>
								    <select id="user_id1"  name="user_id1" class="mdl-textfield__input" <?php //echo set_select('user_id1'); ?> >
										<option value=""></option>
										<option value="1"> All </option>
									</select>
								</div>
								<?php //echo form_error('user_id1'); ?>

							    <?php //} else {?>	 -->
							    
							    <?php $error_class = ( form_error('user_id') != '' )? 'has-error' : '' ?>
								<div class="mdl-textfield mdl-js-textfield set-margin">
									<label class="mdl-textfield__label set-visiblity" for="user_id" >Select Employee</label>
							    </div>
								<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label">
									<select id="user_id" class="mdl-selectfield__select chosen-find-length chosen-users" name="user_id[]" <?php echo set_select('user_id'); ?> multiple="true" >
										<!-- <?php //if (!empty($user_results) ): ?>
											<?php// foreach ( $user_results as $user_result ): ?>
												<option class="other_class" value="<?php //echo $user_result->id; ?>"><?php //echo $user_result->first_name.' '.$user_result->last_name; ?></option>
											<?php// endforeach; ?>
										<?php// endif; ?> -->
									</select>
								</div>
								<?php echo form_error('user_id'); ?>

							<!-- <?php //}?>	 -->

							<?php $error_class = ( form_error('notification_type') != '' )? 'has-error' : '' ?>
							<div class="mdl-textfield mdl-js-textfield mdl-textfield">
								<label class="mdl-textfield__label" for="notification_type" >Notification Type</label>
							    <select id="notification_type"  name="notification_type" class="mdl-textfield__input" <?php echo set_select('notification_type'); ?> >
									<option value=""></option>
									<option value="1"> Warning </option>
									<option value="2"> Agreement </option>
									<option value="3"> Training </option>
								</select>
							</div>
							<?php echo form_error('notification_type'); ?>

						    <?php $error_class = ( form_error('notification_date') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="notification_date"> Notification Date </label>
						       <input class="mdl-textfield__input common-date-class" type="text" id="notification_date" name="notification_date" value="<?php echo set_value('notification_date'); ?>">
						    </div>
					       	<?php echo form_error('notification_date'); ?>
						    
						    <?php $error_class = ( form_error('document_name') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="document_name">Document Name</label>
						       <input class="mdl-textfield__input" type="text" id="document_name" name="document_name" value="<?php echo set_value('document_name'); ?>">
						    </div>
							<?php echo form_error('document_name'); ?>

							<?php $error_class = ( form_error('notification_text') != '' )? 'has-error' : '' ?>
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       	<label class="mdl-textfield__label" for="notification_text">Notification Text</label>
								<textarea class="mdl-textfield__input" id="notification_text" name="notification_text"><?php echo set_value('notification_text'); ?></textarea>
							</div>
						    <?php echo form_error('notification_text'); ?>

						    <?php $error_class = ( form_error('file_name') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <input class="mdl-textfield__input" type="file" id="file_name" name="file_name">
						    </div>
					       	<?php echo form_error('file_name'); ?>

							
						    <?php $error_class = ( form_error('manager_comment') != '' )? 'has-error' : '' ?>
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       	<label class="mdl-textfield__label" for="manager_comment">Manager Comment</label>
								<textarea class="mdl-textfield__input" id="manager_comment" name="manager_comment"><?php echo set_value('manager_comment'); ?></textarea>
							</div>
						    <?php echo form_error('manager_comment'); ?>

							<div class="clear"> </div>
							<div class="mdl-layout">
								<button type="button" class="mdl-button cca-background-color-dark-green cca-text-color-white submit_notification_form">Save</button>
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