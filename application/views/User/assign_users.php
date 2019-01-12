<main class="mdl-layout__content mdl-color--grey-100" id="content">   
	<meta name="csrf_rcc" content="<?php echo $csrf['hash']; ?>" />
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Assign User</h2>
			</div>
			<div class="mdl-card__supporting-text" style="height:50%;">
				<div class="mdl-grid">
					<div class="mdl-layout-spacer"></div>
					<div class="mdl-cell mdl-cell--4-col">
						<form action="<?php echo site_url("user/assign_users"); ?>" method="post" id="form_users" name="form_user">
							
							<?php $error_class = ( form_error('assigned_user') != '' )? 'has-error' : '' ?>
							<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label">
								<label class="mdl-selectfield__label" for="assigned_user" >Select QA, Supervisor or Manager</label>
								<select id="assigned_user" class="mdl-selectfield__select" name="assigned_user" data-url="<?php echo site_url('user/find_users') ?>">
									<option value=""></option>
									<?php if( !empty($all_managers)): ?>
										<?php foreach ($all_managers as $result) { ?>
											<?php if( 1 == $result->job_title ) {
													$job_title = 'Supervisor';
												} elseif ( 2 == $result->job_title ) {
													$job_title = 'Quality Analyst';
												} elseif ( 3 == $result->job_title ) {
													$job_title = 'Manager';
												}
											?>		
											<option value="<?php echo $result->employee_id.':'.$job_title; ?>"><?php echo $result->first_name.' '.$result->last_name.'( '.$job_title.' )'; ?></option>
										<?php }?>
									<?php endif; ?>
								</select>
							</div>
							<?php echo form_error('assigned_user'); ?>

							<?php $error_class = ( form_error('select_employee[]') != '' )? 'has-error' : '' ?>
							<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label">
								<select id="select_employee" class="mdl-selectfield__select chosen-select" name="select_employee[]" multiple="true" >
								</select>
							</div>
							<?php echo form_error('select_employee[]'); ?>

							<div class="mdl-layout" style="min-height:100px;">
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