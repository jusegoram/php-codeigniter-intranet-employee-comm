<main class="mdl-layout__content mdl-color--grey-100" id="content">
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Add Performance Commitment</h2>
			</div>
			<div class="mdl-card__supporting-text">
				<div class="mdl-grid">
					<div class="mdl-layout-spacer"></div>
					<div class="mdl-cell mdl-cell--4-col">
						<form action="<?php echo site_url("performance/create"); ?>" method="post" id="form_performance" enctype="multipart/form-data">

						    <?php $error_class = ( form_error('user_id') != '' )? 'has-error' : '' ?>
						    <div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label">
						    	<label class="mdl-selectfield__label" for="user_id" >Select Employee</label>
								<select id="user_id"  name="user_id" class="mdl-selectfield__select" <?php echo set_select('user_id'); ?> >
									<?php if (!empty($user_results) ): ?>
										<?php foreach ( $user_results as $user_result ): ?>
											<option value="<?php echo $user_result->id; ?>">
												<?php echo $user_result->username  . ' ( '. $user_result->first_name . ' ' .  $user_result->last_name .' )'; ?>
											</option>
										<?php endforeach; ?>
									<?php endif; ?>
								</select>
							</div>
							<?php echo form_error('user_id'); ?>

							<?php $error_class = ( form_error('quality_commitment') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="quality_commitment">Quality</label>
						       <input class="mdl-textfield__input" type="text" id="quality_commitment" name="quality_commitment" value="<?php echo set_value('quality_commitment'); ?>">
						    </div>
					       	<?php echo form_error('quality_commitment'); ?>

						    <?php $error_class = ( form_error('adherence_commitment') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="adherence_commitment">Hours</label>
						       <input class="mdl-textfield__input" type="text" id="adherence_commitment" name="adherence_commitment" value="<?php echo set_value('adherence_commitment'); ?>">
						    </div>
					       	<?php echo form_error('adherence_commitment'); ?>

						    <?php $error_class = ( form_error('hold_time_commitment') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="hold_time_commitment">Productivity</label>
						       <input class="mdl-textfield__input" type="text" id="hold_time_commitment" name="hold_time_commitment" value="<?php echo set_value('hold_time_commitment'); ?>">
						    </div>
					       	<?php echo form_error('hold_time_commitment'); ?>

						    <?php $error_class = ( form_error('transfer_rate_commitment') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="transfer_rate_commitment">Other</label>
						       <input class="mdl-textfield__input" type="text" id="transfer_rate_commitment" name="transfer_rate_commitment" value="<?php echo set_value('transfer_rate_commitment'); ?>">
						    </div>
					       	<?php echo form_error('transfer_rate_commitment'); ?>

					       	<?php $error_class = ( form_error('performance_date') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="performance_date"> Performance Date </label>
						       <input class="mdl-textfield__input common-date-class" type="text" id="performance_date" name="performance_date" value="<?php echo set_value('performance_date'); ?>">
						    </div>
					       	<?php echo form_error('performance_date'); ?>

					       	<?php $error_class = ( form_error('manager_commitment') != '' )? 'has-error' : '' ?>
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       	<label class="mdl-textfield__label" for="manager_commitment">Manager Comment</label>
								<textarea class="mdl-textfield__input" id="manager_commitment" name="manager_commitment"><?php echo set_value('manager_commitment'); ?></textarea>
							</div>
					       	<?php echo form_error('manager_commitment'); ?>

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