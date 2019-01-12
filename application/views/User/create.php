<main class="mdl-layout__content mdl-color--grey-100" id="content">    
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Add</h2>
			</div>
			<div class="mdl-card__supporting-text">
				<div class="mdl-grid">
					<div class="mdl-layout-spacer"></div>
					<div class="mdl-cell mdl-cell--4-col">
						
						<form action="<?php echo site_url("user/create"); ?>" method="post" id="form_users" name="form_user">
							
							<?php $error_class = ( form_error('first_name') != '' )? 'has-error' : '' ?>
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="first_name">First Name</label>
						       <input class="mdl-textfield__input" type="text" id="first_name" name="first_name" value="<?php echo set_value('first_name'); ?>">
						    </div>
							<?php echo form_error('first_name'); ?>

						    <?php $error_class = ( form_error('last_name') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="last_name">Last Name</label>
						       <input class="mdl-textfield__input" type="text" id="last_name" name="last_name" value="<?php echo set_value('last_name'); ?>">
						    </div>
							<?php echo form_error('last_name'); ?>

							<?php $error_class = ( form_error('avaya_number') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="avaya_number">Avaya Number</label>
						       <input class="mdl-textfield__input" type="text" id="avaya_number" name="avaya_number" value="<?php echo set_value('avaya_number'); ?>">
						    </div>
							<?php echo form_error('avaya_number'); ?>

							<?php $error_class = ( form_error('employee_id') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="employee_id">Employee ID</label>
						       <input class="mdl-textfield__input" type="text" id="employee_id" name="employee_id" value="<?php echo set_value('employee_id'); ?>">
						    </div>    
							<?php echo form_error('employee_id'); ?>
						    
						    <?php $error_class = ( form_error('password') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       <label class="mdl-textfield__label" for="password">Password</label>
						       <input class="mdl-textfield__input" type="password" id="password" name="password" value="<?php echo set_value('password'); ?>">
						    </div>
							<?php echo form_error('password'); ?>

						    <?php $error_class = ( form_error('email') != '' )? 'has-error' : '' ?>
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<label class="mdl-textfield__label" for="email">Email</label>
								<input class="mdl-textfield__input" type="text" id="email" name="email" value="<?php echo set_value('email'); ?>">
						    </div>
							<?php echo form_error('email'); ?>
							
							<?php $error_class = ( form_error('user_type') != '' )? 'has-error' : '' ?>
							<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label">
								
								<select id="user_type" class="mdl-selectfield__select user_select" name="user_type" <?php echo set_select('user_type'); ?> >
									<option value="" disabled="disabled" selected="selected">--Choose User Type--</option>
									<option value="5">Supervisor</option>
									<option value="6">Quality Analyst</option>
									<option value="1">Manager</option>
									<option value="2">Employee</option>
					
									<?php if( 3 == $user_session->user_type ) { ?>
									<option value="4">Admin</option>
									<option value="3">Super Admin</option>
									
								<?php } ?>
								</select>
							</div>
							<?php echo form_error('user_type'); ?>

							<?php $error_class 		= ( form_error('job_title') != '' )? 'has-error' : '' ?>
							<?php $display_block 	= ( form_error('job_title') != '' )? 'display:block;' : 'display:none' ?>
							<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label job-title"  style="<?php echo $display_block; ?>">
								<label class="mdl-selectfield__label" for="job_title" >Job Title</label>
							    <select id="job_title" class="mdl-selectfield__select" name="job_title" <?php echo set_select('job_title'); ?> >
									<!-- <option value="" disabled="disabled" selected="selected">--Choose Job Title--</option> -->
									<!-- <option  id="supervisor-option" value="1" style="display:none;">Supervisor</option>
									<option id="qa-option" value="2" style="display:none;">Quality Analyst</option>
									<option id="manager-option" value="3" style="display:none;">Manager</option> -->
								
								</select>
							</div>
							<?php echo form_error('job_title'); ?>

								
							<?php $error_class = ( form_error('assigned_supervisor') != '' )? 'has-error' : '' ?>
							<?php $display_block 	= ( form_error('assigned_supervisor') != '' )? 'display:block;' : 'display:none' ?>
							<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label assign-user"  style="<?php echo $display_block; ?>">
								<label class="mdl-selectfield__label" for="assigned_supervisor" >Assign Supervisor</label>
								<select id="assigned_supervisor" class="mdl-selectfield__select" name="assigned_supervisor" <?php echo set_select('assigned_supervisor'); ?> >
									<option value="" ></option>
									<?php if( !empty($supervisor_results)): ?>
										<?php foreach ($supervisor_results as $result) { ?>
											<?php if( 1 == $result->job_title ) {
													$job_title = 'Supervisor';
												} elseif ( 2 == $result->job_title ) {
													$job_title = 'Quality Analyst';
												} else {
													$job_title = 'Manager';
												}
											?>
											<option value="<?php echo $result->employee_id; ?>"><?php echo $result->first_name.' '.$result->last_name.'( '.$job_title.' )'; ?></option>
										<?php } ?>
									<?php endif; ?>
								</select>
							</div>
							<?php echo form_error('assigned_supervisor'); ?>


							<?php $error_class = ( form_error('assigned_qa') != '' )? 'has-error' : '' ?>
							<?php $display_block 	= ( form_error('assigned_qa') != '' )? 'display:block;' : 'display:none' ?>
							<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label assign-user"  style="<?php echo $display_block; ?>">
								<label class="mdl-selectfield__label" for="assigned_qa" >Assign QA</label>
								<select id="assigned_qa" class="mdl-selectfield__select" name="assigned_qa" <?php echo set_select('assigned_qa'); ?> >
									<option value="" ></option>
									<?php if( !empty($qa_results)): ?>
										<?php foreach ($qa_results as $result) { ?>
											<?php if( 1 == $result->job_title ) {
													$job_title = 'Supervisor';
												} elseif ( 2 == $result->job_title ) {
													$job_title = 'Quality Analyst';
												} else {
													$job_title = 'Manager';
												}
											?>
											<option value="<?php echo $result->employee_id; ?>"><?php echo $result->first_name.' '.$result->last_name.'( '.$job_title.' )'; ?></option>
										<?php }?>
									<?php endif; ?>
								</select>
							</div>
							<?php echo form_error('assigned_qa'); ?>

							<?php $error_class = ( form_error('assigned_manager') != '' )? 'has-error' : '' ?>
							<?php $display_block 	= ( form_error('assigned_manager') != '' )? 'display:block;' : 'display:none' ?>
							<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label assign-user" id="assign-manager"  style="<?php echo $display_block; ?>">
								<label class="mdl-selectfield__label" for="assigned_manager" >Assign Manager</label>
								<select id="assigned_manager" class="mdl-selectfield__select" name="assigned_manager" <?php echo set_select('assigned_manager'); ?> >
									<option value="" ></option>
									<?php if( !empty($manager_results)): ?>
										<?php foreach ($manager_results as $result) { ?>
											<?php if( 1 == $result->job_title ) {
													$job_title = 'Supervisor';
												} elseif ( 2 == $result->job_title ) {
													$job_title = 'Quality Analyst';
												} else {
													$job_title = 'Manager';
												}
											?>
											<option value="<?php echo $result->employee_id; ?>"><?php echo $result->first_name.' '.$result->last_name.'( '.$job_title.' )'; ?></option>
										<?php }?>
									<?php endif; ?>
								</select>
							</div>
							<?php echo form_error('assigned_manager'); ?>

							<?php $error_class = ( form_error('hire_date') != '' )? 'has-error' : '' ?>
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						       	<label class="mdl-textfield__label" for="hire_date">Hire Date</label>
								<input class="mdl-textfield__input common-date-class" type="text" id="hire_date" name="hire_date" value="<?php echo set_value('hire_date'); ?>">
							</div>
							<?php echo form_error('hire_date'); ?>

							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"  style="margin-bottom:10px;">
								<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect " for="is_change_password">
								<input type="checkbox" id="is_change_password" name="is_change_password" class="mdl-checkbox__input" >
									<p>
									 	Force user to change password while login first time.
									</p>
								</label>
							</div>
							
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