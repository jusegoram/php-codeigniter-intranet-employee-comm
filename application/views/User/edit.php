<main class="mdl-layout__content mdl-color--grey-100" id="content">
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Edit</h2>
			</div>

			<div class="mdl-card__supporting-text">
				<div class="mdl-grid">
					<?php if(!empty($result)) : ?>
						<div class="mdl-layout-spacer"></div>
						<div class="mdl-cell mdl-cell--4-col">
							<form action="<?php echo site_url('user/edit/'.$result->id);?>" method="post" id="edit_form_users">
								<?php $error_class = ( form_error('first_name') != '' )? 'has-error' : '' ?>
							    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							       <label class="mdl-textfield__label" for="first_name">First Name</label>
							       <input class="mdl-textfield__input" type="text" id="first_name" name="first_name" value="<?php echo set_value('first_name', $result->first_name ); ?>"  >
							    </div>
							    <?php echo form_error('first_name'); ?>

							    <?php $error_class = ( form_error('last_name') != '' )? 'has-error' : '' ?>
							    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							       <label class="mdl-textfield__label" for="last_name">Last Name</label>
							       <input class="mdl-textfield__input" type="text" id="last_name" name="last_name" value="<?php echo set_value('last_name', $result->last_name ); ?>" >
							    </div>
						    	<?php echo form_error('last_name'); ?>

						    	<?php $error_class = ( form_error('avaya_number') != '' )? 'has-error' : '' ?>
							    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							       <label class="mdl-textfield__label" for="avaya_number">Campaign</label>
							       <input class="mdl-textfield__input" type="text" id="avaya_number" name="avaya_number" value="<?php echo set_value('avaya_number', $result->avaya_number ); ?>" >
							    </div>
						    	<?php echo form_error('avaya_number'); ?>

						    	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							       <label class="mdl-textfield__label" for="username">Username</label>
							       <input class="mdl-textfield__input" type="text" id="username" name="username"  value="<?php echo set_value('username', $result->username ); ?>" disabled="disabled">
							    </div>

							    <?php $error_class = ( form_error('edit_password') != '' )? 'has-error' : '' ?>
							    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							       <label class="mdl-textfield__label" for="edit_password">Password</label>
							       <input class="mdl-textfield__input" type="password" id="edit_password" name="edit_password" value="<?php echo set_value('edit_password') ?>" >
							    </div>
						    	<?php echo form_error('edit_password'); ?>

							    <?php $error_class = ( form_error('email') != '' )? 'has-error' : '' ?>
							    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							       <label class="mdl-textfield__label" for="email">Client</label>
							       <input class="mdl-textfield__input" type="text" id="email" name="email" value="<?php echo set_value('email', $result->email ); ?>"  >
							    </div>
						       	<?php echo form_error('email'); ?>


						       	<?php $error_class = ( form_error('user_type') != '' )? 'has-error' : '' ?>
							    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							       <label class="mdl-textfield__label" for="user_type">User Type</label>
								    <?php if( 1 == $result->user_type ) {
											$user_type = 'Manager';
										} elseif ( 2 == $result->user_type ) {
											$user_type = 'Employee';
										} elseif ( 5 == $result->user_type ) {
											$user_type = 'Supervisor';
										} elseif ( 6 == $result->user_type ) {
											$user_type = 'Quality Analyst';
										} elseif ( ( 3 == $result->user_type ) || ( 4 == $result->user_type ) ) {
											$user_type = 'Admin';
										}
									?>

							       <input class="mdl-textfield__input" type="text" id="user_type" name="user_type" value="<?php echo set_value('user_type', $user_type ); ?>" disabled="disable" >
							    </div>
						       	<?php echo form_error('user_type'); ?>

						       	<?php if( 2 == $result->user_type ) : ?>

							       	<?php $error_class = ( form_error('assigned_supervisor') != '' )? 'has-error' : '' ?>
									<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label assign-user"  style="<?php echo $display_block; ?>">
										<!-- <label class="mdl-selectfield__label" for="assigned_supervisor" >Supervisor</label> -->
										<select id="assigned_supervisor" class="mdl-selectfield__select" name="assigned_supervisor" <?php echo set_select('assigned_supervisor'); ?> >
											<option value="" disabled="disabled" selected="selected">--Choose Supervisor--</option>
											<?php if( !empty($supervisor_results)): ?>
												<?php foreach ($supervisor_results as $supervisor_result) { ?>
													<?php if( 1 == $supervisor_result->job_title ) {
															$job_title = 'Supervisor';
														} elseif ( 2 == $supervisor_result->job_title ) {
															$job_title = 'Quality Analyst';
														} else {
															$job_title = 'Manager';
														}
													?>
													<option value="<?php echo $supervisor_result->employee_id; ?>" <?php echo ( $supervisor_result->employee_id == $result->assigned_supervisor ) ? 'selected="selected"' : '' ?> ><?php echo $supervisor_result->first_name.' '.$supervisor_result->last_name.'( '.$job_title.' )'; ?></option>
												<?php }?>
											<?php endif; ?>
										</select>
									</div>
									<?php echo form_error('assigned_supervisor'); ?>

									<?php $error_class = ( form_error('assigned_qa') != '' )? 'has-error' : '' ?>
									<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label assign-user"  style="<?php echo $display_block; ?>">
										<!-- <label class="mdl-selectfield__label" for="assigned_qa" >Assign QA</label> -->
										<select id="assigned_qa" class="mdl-selectfield__select" name="assigned_qa" <?php echo set_select('assigned_qa'); ?> >
											<option value="" disabled="disabled" selected="selected">--Choose QA--</option>
											<?php if( !empty($qa_results)): ?>
												<?php foreach ($qa_results as $qa_result) { ?>
													<?php if( 1 == $qa_result->job_title ) {
															$job_title = 'Supervisor';
														} elseif ( 2 == $qa_result->job_title ) {
															$job_title = 'Quality Analyst';
														} else {
															$job_title = 'Manager';
														}
													?>
													<option value="<?php echo $qa_result->employee_id; ?>" <?php echo ( $qa_result->employee_id == $result->assigned_qa ) ? 'selected="selected"' : '' ?> > <?php echo $qa_result->first_name.' '.$qa_result->last_name.'( '.$job_title.' )'; ?></option>
												<?php }?>
											<?php endif; ?>
										</select>
									</div>
									<?php echo form_error('assigned_qa'); ?>
								<?php endif; ?>
								<?php if( ( 2 == $result->user_type ) || ( 1 == $result->job_title ) || ( 2 == $result->job_title ) ) : ?>

									<?php $error_class = ( form_error('assigned_manager') != '' )? 'has-error' : '' ?>
									<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label assign-user"  style="<?php echo $display_block; ?>">
										<!-- <label class="mdl-selectfield__label" for="assigned_manager" >Assign Manager</label> -->
										<select id="assigned_manager" class="mdl-selectfield__select" name="assigned_manager" <?php echo set_select('assigned_manager'); ?> >
											<option value="" disabled="disabled" selected="selected">--Choose Manager--</option>
											<?php if( !empty($manager_results)): ?>
												<?php foreach ($manager_results as $manager_result) { ?>
													<?php if( 1 == $manager_result->job_title ) {
															$job_title = 'Supervisor';
														} elseif ( 2 == $manager_result->job_title ) {
															$job_title = 'Quality Analyst';
														} else {
															$job_title = 'Manager';
														}
													?>

													<option value="<?php echo $manager_result->employee_id; ?>" <?php echo ( $manager_result->employee_id == $result->assigned_manager ) ? 'selected="selected"' : '' ?> > <?php echo $manager_result->first_name.' '.$manager_result->last_name.'( '.$job_title.' )'; ?></option>
												<?php }?>
											<?php endif; ?>
										</select>
									</div>
									<?php echo form_error('assigned_manager'); ?>
								<?php endif; ?>


								<?php $error_class = ( form_error('hire_date') != '' )? 'has-error' : '' ?>
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							       	<label class="mdl-textfield__label" for="hire_date">Hire Date</label>
									<input class="mdl-textfield__input common-date-class" type="text" id="hire_date" name="hire_date"  value="<?php echo set_value('hire_date', date('Y-m-d', $result->hire_date) ); ?>" >
								</div>
						       	<?php echo form_error('hire_date'); ?>

								<div class="mdl-layout">
									<button type="submit" class="mdl-button cca-background-color-dark-green cca-text-color-white">Save</button>
								</div>

								<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
						  	</form>
						</div>
						<div class="mdl-layout-spacer"></div>
					<?php else :?>
						No record found!
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</main>