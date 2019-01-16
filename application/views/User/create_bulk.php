<main class="mdl-layout__content mdl-color--grey-100" id="content">
	<div class="mdl-grid demo-content">
		<div class="mdl-card mdl-shadow--2dp demo-todo">
			<div class="mdl-card__title">
				<div class="mdl-cell mdl-cell--3-col" style="width:21% !important;">
					<h2 class="mdl-card__title-text">Add Multiple Record</h2>
				</div>

				<div class="mdl-cell mdl-cell--9-col">
					<a id="download_sample" href="<?php echo site_url('user/export_sample_users'); ?>" ><label for="download_sample" class="mdl-button mdl-js-button mdl-button--icon" >
							<i class="material-icons" title="Download sample file to add bulk users">file_download</i></label></a>
				</div>
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
						       <label class="mdl-textfield__label" for="default_password">Default Password</label>
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
								<button type="button" class="mdl-button cca-background-color-dark-green cca-text-color-white submit_bulk_user_form">Save</button>
							</div>
							<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

						</form>
					</div>
					<div class="mdl-layout-spacer"></div>
				</div>
			</div>
		</div>
	</div>

	<?php if( !empty($not_added_record) ): ?>
		<div class="mdl-grid demo-content">
			<div class="mdl-card mdl-shadow--2dp demo-todo">
				<div class="mdl-card__title">
					<div class="mdl-cell mdl-cell--3-col">
						<h2 class="mdl-card__title-text">Not Added Users List</h2>
					</div>
				</div>
				<div class="mdl-layout--middle">
					<table id="not-added-user-table" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th class="mdl-data-table__cell--non-numeric" data-field="id">S.No</th>
								<th class="mdl-data-table__cell--non-numeric" data-field="name">Name</th>
								<th class="mdl-data-table__cell--non-numeric" data-field="employee_id">Employee ID</th>
								<th class="mdl-data-table__cell--non-numeric" data-field="reason">Reason</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($not_added_record as $key => $not_added_record1) { ?>
								<tr>
									<td class="mdl-data-table__cell--non-numeric"><?php echo $key+1; ?></td>
									<td class="mdl-data-table__cell--non-numeric"><?php echo $not_added_record1['first_name'].' '.$not_added_record1['last_name']; ?></td>
									<td class="mdl-data-table__cell--non-numeric"><?php echo $not_added_record1['employee_id']; ?></td>
									<td class="mdl-data-table__cell--non-numeric"><?php echo $not_added_record1['reason']; ?></td>
								</tr>
							<?php }  ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	<?php endif; ?>
</main>